<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Repositories\Backend\Transaction\TodoRepository;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $models = $this->repository->getAll();
        return TodoResource::collection($models);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Todo|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $model =  $this->repository->create($request->all());
        if($model){
            return response()->json($model, 200);
        }

        return response()->json(['error'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
