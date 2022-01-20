@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('taskStatuses.Status edit') }}</h1>
    {{Form::model($taskStatus, ['url' => route('task_statuses.update', ['task_status' => $taskStatus]), 'method' => 'PATCH'])}}
        <div class="form-group mb-3">
           {{Form::label('name', __('taskStatuses.Status name'))}}
           {{Form::text('name', $taskStatus->name, ['class' => 'form-control'])}}
           <div class="invalid-feedback d-block">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                @endif
           </div>
        </div>
    {{Form::submit(__('taskStatuses.Update'), ['class' => 'btn btn-primary mt-3'])}}
    {{Form::close()}}
@endsection('content')
