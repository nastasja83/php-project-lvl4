@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('taskStatuses.Create status') }}</h1>
{{Form::open(['url' => route('task_statuses.store')])}}
    <div class="form-group mb-3">
        {{Form::label('name', __('taskStatuses.Status name'))}}
            {{Form::text('name', '', ['class' => 'form-control'])}}
    </div>
        @if ($errors->any())
            <div class="invalid-feedback d-block">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        {{Form::submit(__('taskStatuses.Create'), ['class' => 'btn btn-primary mt-3'])}}
{{ Form::close() }}
@endsection('content')
