@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('taskStatuses.Statuses') }}</h1>
    @if(Auth::check())
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('taskStatuses.Create status') }}</a>
    @endif
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('taskStatuses.Status name') }}</th>
                    <th scope="col">{{ __('taskStatuses.Date of creation') }}</th>
                    @if(Auth::check())
                    <th scope="col">{{ __('taskStatuses.Actions') }}</th>
                    @endif
                </tr>
            </thead>
            @if ($taskStatuses)
                @foreach ($taskStatuses as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td scope="row"> {{ $status->name }} </td>
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
</div>
@endsection
