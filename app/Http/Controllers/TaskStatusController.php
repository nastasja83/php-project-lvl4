<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id', 'asc')->paginate();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taskStatusInputData = $this->validate($request, [
            'name' => 'required|max:255|unique:task_statuses'
        ], $messages = [
            'unique' => __('validation.The status name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);
        $taskStatus = new TaskStatus();
        $taskStatus->fill($taskStatusInputData);
        $taskStatus->save();
        flash(__('taskStatuses.Status has been added successfully'))->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $taskStatusInputData = $this->validate($request, [
            'name' => 'required|max:255|unique:task_statuses,name,' . $taskStatus->id
        ], $messages = [
            'unique' => __('validation.The status name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);
        $taskStatus->fill($taskStatusInputData);
        $taskStatus->save();
        flash(__('taskStatuses.Status has been updated successfully'))->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('taskStatuses.Failed to delete status'))->error();
            return back();
        }
        $taskStatus->delete();
        flash(__('taskStatuses.Status has been deleted successfully'))->success();
        return redirect()
        ->route('task_statuses.index');
    }
}
