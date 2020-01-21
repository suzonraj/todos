<?php

namespace App\Repositories\Backend\Transaction;

use App\Events\Todo\TodoCreated;
use App\Exceptions\GeneralException;
use App\Models\Todo;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;


class TodoRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param  Todo  $model
     */
    public function __construct(Todo $model)
    {
        $this->model = $model;
    }

    /**
     * Get all patient by date
     *
     * @param        $transDate
     * @param  bool  $consultantId
     * @return mixed
     */
    public function getAllByDate($transDate, $consultantId = false)
    {
        return $this->model::select([
            'id', 'serial', 'consultant_id', 'patient_id', 'procedure_id', 'procedure_type_id', 'trans_date', 'notes'
        ])
            ->with([
                'details' => function ($q) {
                    $q->select(['id', 'trans_id', 'serial', 'condition_id', 'value_type', 'value']);
                }
            ])
            ->with([
                'details.condition' => function ($q) {
                    $q->select(['id', 'name', 'type', 'value_type'])->active();
                }
            ])
            ->with([
                'consultant' => function ($q) {
                    $q->select(['id', 'title', 'first_name', 'last_name']);
                }
            ])
            ->with([
                'patient' => function ($q) {
                    $q->select([
                        'id', 'pid', 'title', 'first_name', 'last_name', 'nationality_id', 'gender', 'age', 'bed_no'
                    ]);
                }
            ])
            ->with([
                'patient.nationality' => function ($q) {
                    $q->select(['id', 'name']);
                }
            ])
            ->with([
                'procedure' => function ($q) {
                    $q->select(['id', 'name']);
                }
            ])
            ->with([
                'procedure_type' => function ($q) {
                    $q->select(['id', 'name']);
                }
            ])
            ->where('trans_date', $transDate)
            ->when($consultantId, function ($q) use ($consultantId) {
                $q->where('consultant_id', $consultantId);
            })
            ->get();
    }

    /**
     * @param  array  $data
     *
     * @return Todo
     * @throws Throwable
     * @throws Exception
     */
    public function create(array $data): Todo
    {
        return DB::transaction(function () use ($data) {
            $data['serial'] = $this->generateSerial();

            $model = $this->model::create([
                'serial' => $data['serial'],
                'consultant_id' => $data['consultant_id'],
                'patient_id' => $data['patient_id'],
                'procedure_id' => $data['procedure_id'],
                'procedure_type_id' => $data['procedure_type'],
                'trans_date' => Carbon::createFromFormat('d/m/Y', $data['Todo_date']),
                'notes' => $data['notes']
            ]);

            if ($model) {
                $data['trans_id'] = $model->id;
                $data['serial'] = $model->serial;

                foreach ($data['conditions'] as $id => $condition) {
                    $data['condition_id'] = $id;
                    $data['value'] = $condition['value'];
                    $data['value_type'] = $condition['type'];

                }

                event(new TodoCreated($model));

                return $model;
            }

            throw new GeneralException('There was a problem creating this record. Please try again.');
        });
    }

    /**
     * @param         $id
     * @param  array  $data
     *
     * @return Todo
     * @throws Throwable
     */
    public function update($id, array $data): Todo
    {
        return DB::transaction(function () use ($id, $data) {
            $model = $this->getById($id);

            if ($model->update([
                'consultant_id' => $data['consultant_id'],
                'patient_id' => $data['patient_id'],
                'procedure_id' => $data['procedure_id'],
                'procedure_type_id' => $data['procedure_type'],
                'trans_date' => Carbon::createFromFormat('d/m/Y', $data['Todo_date']),
                'notes' => $data['notes']
            ])) {
                $data['trans_id'] = $model->id;
                $data['serial'] = $model->serial;


//                    $data['condition_id'] = $id;
//                    $data['value'] = $condition['value'];
//                    $data['value_type'] = $condition['type'];

                app(TodoDetailRepository::class)->update($data);

                event(new TodoUpdated($model));

                return $model;
            }

            throw new GeneralException(trans('There was a problem updating this record. Please try again.'));
        });
    }

    /**
     * @param $id
     * @return Todo
     * @throws GeneralException
     * @throws Throwable
     */
    public function forceDelete($id): Todo
    {
        $model = $this->withTrashed()->find($id);
        if ($model->deleted_at === null) {
            throw new GeneralException(trans('This record must be deleted first before it can be destroyed permanently.!'));
        }

        try {
            return DB::transaction(function () use ($model) {
                if ($model->forceDelete()) {
                    event(new TodoPermanentlyDeleted($model));
                    return true;
                }

                throw new GeneralException(trans('There was a problem deleting this record. Please try again.'));
            });
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param $id
     * @return Todo
     * @throws GeneralException
     * @throws Throwable
     */
    public function restore($id): Todo
    {
        $model = $this->model->withTrashed()->find($id);

        if ($model->deleted_at === null) {
            throw new GeneralException(trans('This record is not deleted so it can not be restored.'));
        }

        try {
            return DB::transaction(function () use ($model) {
                if ($model->restore()) {
                    event(new TodoRestored($model));

                    return $model;
                }

                throw new GeneralException(trans('There was a problem restoring this record. Please try again.'));
            });
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
