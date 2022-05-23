@extends('layouts.app')

@section('content')
<main class="container py-2">
    <h1 class="mb-4">{{__("Tags")}}</h1>
    @if (Auth::User())
    <a href="/labels/create" class="btn btn-primary ml-auto">{{__("Create tag")}}</a>
    @endif

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>{{__("Name")}}</th>
                <th>{{__("Description")}}</th>
                <th>{{__("Creation date")}}</th>
                @Auth()
                <th class="text-center">{{__("Actions")}}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($labels as $label)
            <tr>
                <td class="text-center">{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at }}</td>
                @if (Auth::id())
                <td class="text-center">
                    <a  href="{{ route('labels.destroy', $label->id )}}"
                        data-method="delete"
                        rel="nofollow"
                        data-confirm="Вы уверены?"
                        class="text-danger pt-0 me-2" 
                        ">{{ __("Delete") }}
                    </a>
                    <a class="text-black" href="{{ route('labels.edit', $label->id) }}">{{ __("Change") }}</a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</main>
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('labels.index') }}
@endsection