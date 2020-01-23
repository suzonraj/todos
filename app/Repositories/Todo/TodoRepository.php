<?php

namespace App\Repositories\Backend\Transaction;

use App\Events\Todo\TodoCompleted;
use App\Events\Todo\TodoCreated;
use App\Events\Todo\TodoDeleted;
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
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->get();
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

            $model = $this->model::create([
                'todo' => $data['body'],
                'status' => 1
            ]);

            if ($model) {
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
     * @return mixed
     * @throws Throwable
     */
    public function delete($id)
    {
        $model = $this->getById($id);
        try {
            return DB::transaction(function () use ($model, $id) {
                if ($this->deleteById($id)) {
                    event(new TodoDeleted($model));
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
     * @throws Throwable
     */
    public function complete($id): Todo
    {
        return DB::transaction(function () use ($id) {
            $model = $this->getById($id);

            if ($model->update([
                'status' => 2,
            ])) {

                event(new TodoCompleted($model));

                return $model;
            }
        });
    }

    /**
     * @return Todo
     * @throws Throwable
     */
    public function clearCompleted()
    {
        return DB::transaction(function () {
            $completedTodo = $this->model->complete()->get();

            foreach ($completedTodo as $todo){
                $todo->forceDelete();
                event(new TodoDeleted($todo));
            }

            return true;
        });
    }
}
