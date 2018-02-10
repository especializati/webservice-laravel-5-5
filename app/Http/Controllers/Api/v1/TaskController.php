<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\StoreUpdateTaskValidate;

class TaskController extends Controller
{
    private $task;
    private $totalPage = 10;
    
    /**
     * DI of \App\Models\Task
     *
     * @param  \App\Models\Task $request
     * @return \Illuminate\Http\Response
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // For testing preloader (optional)
        // sleep(2);
        $tasks = $this->task->getResults($request->all(), $this->totalPage);
        
        return response()->json($tasks);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateTaskValidate $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTaskValidate $request)
    {
        if ( !$task = $this->task->create($request->all()) )
            return response()->json(['error' => 'error_insert'], 500);
        
        return response()->json($task, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( !$task = $this->task->find($id) )
           return response()->json(['error' => 'product_not_found'], 404);
        
        return response()->json($task);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateTaskValidate $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateTaskValidate $request, $id)
    {
        if ( !$task = $this->task->find($id) )
           return response()->json(['error' => 'product_not_found'], 404);
        
        if ( !$task->update($request->all()) )
            return response()->json(['error' => 'product_not_update'], 500);
        
        return response()->json($task);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( !$task = $this->task->find($id) )
           return response()->json(['error' => 'product_not_found'], 404);
        
        if ( !$task->delete() )
            return response()->json(['error' => 'product_not_delete'], 500);
        
        return response()->json($task);
    }
}
