@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('taskStatuses.Statuses') }}</h1>
    @if(Auth::check())
        <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('taskStatuses.Create status') }}</a>
    @endif
    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('taskStatuses.Status name') }}</th>
                <th>{{ __('taskStatuses.Date of creation') }}</th>
                @if(Auth::check())
                <th>{{ __('taskStatuses.Actions') }}</th>
                @endif
            </tr>
        </thead>
                @if ($taskStatuses)
                    @foreach ($taskStatuses as $status)
                        <tr>
                            <td>{{ $status->id }}</td>
                            <td> {{ $status->name }} </td>
                            <td>{{ $status->created_at }}</td>
                            @if(Auth::check())
                            <td>
                                <a class="text-danger" href="{{ route('task_statuses.destroy', ['task_status' => $status]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('taskStatuses.Are you sure?') }}">{{ __('taskStatuses.Delete') }}</a>
                                <a href="{{ route('task_statuses.edit', ['task_status' => $status]) }}">{{ __('taskStatuses.Edit') }}</a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
    </table>
    <nav>
        <ul class="pagination">
        <li>{{ $taskStatuses->onEachSide(5)->links() }}</li>
        </ul>
    </nav>
@if ($errors->any())
    <div class="invalid-feedback d-block">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif
@endsection('content')
