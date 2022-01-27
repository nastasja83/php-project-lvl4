@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">{{ __('labels.Labels') }}</h1>
    @if(Auth::check())
    <a href="{{ route('labels.create') }}" class="btn btn-primary">{{ __('labels.Create label') }}</a>
    @endif
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('labels.Label name') }}</th>
                    <th scope="col" class="text-break">{{ __('labels.Description') }}</th>
                    <th scope="col">{{ __('labels.Date of creation') }}</th>
                    @if(Auth::check())
                    <th scope="col">{{ __('labels.Actions') }}</th>
                    @endif
                </tr>
            </thead>
            @if ($labels)
                @foreach ($labels as $label)
                    <tr>
                        <td>{{ $label->id }}</td>
                        <td scope="row"> {{ $label->name }} </td>
                        <td class="text-break"> {{ $label->description }} </td>
                        <td>{{ $label->created_at->format('d.m.Y') }}</td>
                        @if(Auth::check())
                        <td>
                            <a class="text-danger" href="{{ route('labels.destroy', ['label' => $label]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('labels.Are you sure?') }}">{{ __('labels.Delete') }}</a>
                            <a href="{{ route('labels.edit', ['label' => $label]) }}">{{ __('labels.Edit') }}</a>
                        </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </table>
    <nav>
        <ul class="pagination">
        <li>{{ $labels->onEachSide(3)->links() }}</li>
        </ul>
    </nav>
</div>
@endsection
