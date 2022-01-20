@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('tasks.Edit task') }}</h1>
    {{Form::model($task, ['url' => route('tasks.update', ['task' => $task]), 'method' => 'PATCH'])}}
        <div class="form-group mb-3">
           {{Form::label('name', __('tasks.Task name'))}}
           {{Form::text('name', $task->name, ['class' => 'form-control'])}}
           @if ($errors->has('name'))
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            @endif
        </div>
        <div class="form-group mb-3">
           {{Form::label('description', __('tasks.Description'))}}
           {{Form::textarea('description', null, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
        </div>
        <div class="form-group mb-3">
           {{Form::label('status_id', __('taskStatuses.Status'))}}
           {{Form::select('status_id', $taskStatuses, null, ['placeholder' => '----------', 'class' => 'form-control'])}}
           @if ($errors->has('name'))
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            @endif
        </div>
        <div class="form-group mb-3">
           {{Form::label('assigned_to_id', __('tasks.Executor'))}}
           {{Form::select('assigned_to_id', $executors, null, ['placeholder' => '----------', 'class' => 'form-control'])}}
        </div>
        <div class="form-group mb-3">
           {{Form::label('label_id', __('labels.Labels'))}}
           {{Form::select('label_id', $labels, $task->labels, ['placeholder' => '', 'multiple' => 'multiple', 'name' => 'labels[]', 'class' => 'form-control'])}}
        </div>
    {{Form::submit(__('task.Update'), ['class' => 'btn btn-primary mt-3'])}}
    {{Form::close()}}
@endsection('content')
