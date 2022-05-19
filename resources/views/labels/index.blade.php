@extends('layouts.app')

@section('content')
<main class="container">
    <h1 class="mb-5">{{__("Tags")}}</h1>

    @if (Auth::User())
    <a href="/labels/create" class="btn btn-primary ml-auto">{{__("Create tag")}}</a>
    @endif

    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{__("Name")}}</th>
                <th>{{__("Description")}}</th>
                <th>{{__("Creation date")}}</th>
            </tr>
        </thead>
        @foreach ($labels as $label)
        <tr>
            <td>{{ $label->id }}</td>
            <td>{{ $label->name }}</td>
            <td>{{ $label->description }}</td>
            <td>{{ $label->created_at }}</td>
            @if (Auth::id())
            <td>
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
    </table>
</main>
@endsection