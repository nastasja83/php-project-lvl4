@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('tasks.Create task') }}</h1>
    {{Form::open(['url' => route('tasks.store'), 'class' => 'w-50'])}}
        <div class="form-group mb-3">
           {{Form::label('name', __('tasks.Task name'))}}
           {{Form::text('name', $task->name, ['class' => 'form-control'])}}
        </div>
        <div class="form-group mb-3">
           {{Form::label('description', __('tasks.Description'))}}
           {{Form::textarea('description', null, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
        </div>
        <div class="form-group mb-3">
           {{Form::label('status_id', __('taskStatuses.Status'))}}
           {{Form::select('status_id', $taskStatuses, null, ['placeholder' => '----------', 'class' => 'form-control'])}}
        </div>
        <div class="form-group mb-3">
           {{Form::label('assigned_to_id', __('tasks.Executor'))}}
           {{Form::select('assigned_to_id', $executors, null, ['placeholder' => '----------', 'class' => 'form-control'])}}
        <div class="form-group mb-3">
           {{Form::label('label_id', __('labels.Labels'))}}
           {{Form::select('label_id', $labels, $task->labels, ['placeholder' => '', 'multiple' => 'multiple', 'name' => 'labels[]', 'class' => 'form-control'])}}
        </div>
           @if ($errors->any())
            <div class="invalid-feedback d-block">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
            @endif
    {{Form::submit(__('tasks.Update'), ['class' => 'btn btn-primary mt-3'])}}
    {{Form::close()}}
@endsection('content')
