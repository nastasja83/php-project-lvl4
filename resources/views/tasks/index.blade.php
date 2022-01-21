@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('tasks.Tasks') }}</h1>
    <div class="d-flex mb-3">
        <div>
            {{Form::open(['route' => 'tasks.index', 'method' => 'GET'])}}
            <div class="row g-1">
                <div class="col">
                    {{Form::select('filter[status_id]', $taskStatuses, $filter['status_id'] ?? null, ['placeholder' => __('taskStatuses.Status'), 'class' => 'form-select me-2'])}}
                </div>
                <div class="col">
                    {{Form::select('filter[created_by_id]', $taskStatuses, $filter['created_by_id'] ?? null, ['placeholder' => __('tasks.Author'), 'class' => 'form-select me-2'])}}
                </div>
                <div class="col">
                    {{Form::select('filter[assigned_to_id]', $taskStatuses, $filter['assigned_to_id'] ?? null, ['placeholder' => __('tasks.Executor'), 'class' => 'form-select me-2'])}}
                </div>
                <div class="col">
                    {{Form::submit(__('tasks.Apply'), ['class' => 'btn btn-outline-primary me-2'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
        <div class="ms-auto">
            @if(Auth::check())
            <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">{{ __('tasks.Create task') }}</a>
            @endif
        </div>
    </div>
        <table class="table me-2">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('taskStatuses.Status') }}</th>
                    <th scope="col">{{ __('tasks.Task name') }}</th>
                    <th scope="col">{{ __('tasks.Author') }}</th>
                    <th scope="col">{{ __('tasks.Executor') }}</th>
                    <th scope="col">{{ __('tasks.Date of creation') }}</th>
                    @if(Auth::check())
                    <th scope="col">{{ __('tasks.Actions') }}</th>
                    @endif
                </tr>
            </thead>
            @if ($tasks)
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td scope="row"> {{ $task->status->name }} </td>
                        <td><a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->name }}</a></td>
                        <td>{{ $task->creator->name }}</td>
                        <td>{{ $task->executor->name ?? null }}</td>
                        <td>{{ $task->created_at->format('d.m.Y') }}</td>
                        @if(Auth::check())
                        <td>
                            @can('delete', $task)
                                <a class="text-danger" href="{{ route('tasks.destroy', ['task' => $task->id]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('tasks.Are you sure?') }}">{{ __('tasks.Delete') }}</a>
                            @endcan
                            @can('update', $task)
                            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ __('tasks.Edit') }}</a>
                            @endcan
                        </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </table>
    <nav>
        <ul class="pagination">
        <li>{{ $tasks->onEachSide(3)->links() }}</li>
        </ul>
    </nav>
</div>
@endsection
