@extends('layouts.app')

@section('content')
<main class="container">
    <div class="col">
        <div class="row">
            <h1 class="mb-2">{{ __("Tasks") }}</h1>
            @if (Auth::User())
            <div class="pl-2 pt-1 mt-2">
                <a href="/tasks/{{ $task->id }}/edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench" viewBox="0 0 16 16">
                        <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11l.471.242z" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
        <div class="col">
            <p>{{ __("Author") }}: {{ $task->creator->name }}</p>
            <p>{{ __("Name") }}: {{ $task->name }}</p>
            <p>{{ __("Status") }}: {{ $task->status->name }}</p>
            <p>{{ __("Executor") }}: {{ $task->executor->name }}</p>
            <p>{{ __("Description") }}: {{ $task->description }}</p>
            <p>{{ __("Labels") }}: </p>
            <ul>
                @foreach ($labels as $label)
                <li>{{ $label->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</main>
@endsection