<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Repositories\Backend\Transaction\TodoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class TodoController
 *
 * @package App\Http\Controllers
 */
class TodoController extends Controller
{
    /**
     * @var TodoRepository
     */
    private $repository;

    /**
     * TodoController constructor.
     *
     * @param $repository
     */
    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $models = $this->repository->getAll();
        return TodoResource::collection($models);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Todo|JsonResponse|Response
     * @throws Throwable
     */
    public function store(Request $request)
    {
        $model = $this->repository->create($request->all());
        if ($model) {
            return response()->json(new TodoResource($model), 200);
        }

        return response()->json(['error' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(Request $request, $id)
    {
        $model = $this->repository->update($id, $request->all());

        if ($model) {
            return response()->json(new TodoResource($model), 200);
        }

        return response()->json(['error' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy($id)
    {
        $model = $this->repository->delete($id);

        if ($model) {
            return response()->json(['error' => false], 200);
        }

        return response()->json(['error' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws GeneralException
     * @throws Throwable
     */
    public function complete($id)
    {
        $model = $this->repository->complete($id);

        if ($model) {
            return response()->json(['error' => false], 200);
        }

        return response()->json(['error' => true]);
    }


    /**
     * Remove the all resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws GeneralException
     * @throws Throwable
     */
    public function clearCompleted()
    {
        if ($this->repository->clearCompleted()) {
            return response()->json(['error' => false], 200);
        }

        return response()->json(['error' => true]);
    }
}
