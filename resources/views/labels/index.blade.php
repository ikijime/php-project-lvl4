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
                    <div class="btn-group">
                        <a class="text-black" href="/labels/{{ $label->id }}/edit">{{__("Change")}}</a>

                        <form action="/labels/{{ $label->id }}" method="POST">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-link text-danger pt-0">{{__("Delete")}}</button>
                        </form>
                    </div>
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