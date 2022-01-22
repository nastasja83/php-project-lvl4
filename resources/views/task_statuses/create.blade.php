@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('taskStatuses.Create status') }}</h1>
{{Form::open(['url' => route('task_statuses.store'), 'class' => 'w-50'])}}
    <div class="form-group mb-3">
        {{Form::label('name', __('taskStatuses.Status name'))}}
        {{Form::text('name', '', ['class' => 'form-control'])}}
        <div class="invalid-feedback d-block">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif
        </div>
    </div>
        {{Form::submit(__('taskStatuses.Create'), ['class' => 'btn btn-primary mt-3'])}}
{{ Form::close() }}
@endsection('content')
