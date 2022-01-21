@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('labels.Edit label') }}</h1>
    {{Form::model($label, ['url' => route('labels.update', ['label' => $label]), 'method' => 'PATCH'])}}
        <div class="form-group mb-3">
           {{Form::label('name', __('labels.Label name'))}}
           {{Form::text('name', $label->name, ['class' => 'form-control'])}}
        </div>
        <div class="invalid-feedback d-block">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                @endif
        </div>
        <div class="form-group mb-3">
           {{Form::label('description', __('labels.Description'))}}
           {{Form::textarea('description', null, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
        </div>

    {{Form::submit(__('labels.Update'), ['class' => 'btn btn-primary mt-3'])}}
    {{Form::close()}}
@endsection('content')
