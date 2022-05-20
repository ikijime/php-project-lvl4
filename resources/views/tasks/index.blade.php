@extends('layouts.app')

@section('content')
@php
$filterInput = app('request')->filter;
@endphp
<main class="container py-2">
    <h1 class="mb-4">{{ __("Tasks") }}</h1>
    <div class="d-flex mb-3">
        <div>
            <form method="GET" action="/tasks" accept-charset="UTF-8">
                <div class="row row-cols-auto g-2">
                    <div class="col">
                        <select class="form-select me-2" name="filter[status_id]" id="status_id">
                            <option value="">{{ __("Status") }}</option>
                            @foreach (\App\Models\TaskStatus::all() as $status)
                            <option value="{{ $status->id }}" @if(isset($filterInput['status_id']) && $filterInput['status_id']==$status->id) selected @endif>
                                {{ $status->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select me-2" name="filter[author_id] ">
                            <option value="">{{ __("Author") }}</option>
                            @foreach (\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" @if(isset($filterInput['author_id']) && $filterInput['author_id']==$user->id) selected @endif>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select me-2" name="filter[assigned_to_id]">
                            <option selected="selected" value="">{{ __("Executor") }}</option>
                            @foreach (\App\Models\User::all() as $user)
                            <option value=" {{ $user->id }} " @if(isset($filterInput['assigned_to_id']) && $filterInput['assigned_to_id']==$user->id) selected @endif>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input class="btn btn-outline-primary me-2" type="submit" value="{{ __("Apply") }}">
                    </div>
                    <div class="col">
                        @if (Auth::User())
                        <a href="/tasks/create" class="btn btn-primary">{{ __("Create task") }}</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>{{ __("Status") }}</th>
                <th>{{ __("Name") }}</th>
                <th>{{ __("Author") }}</th>
                <th>{{ __("Executor") }}</th>
                <th>{{ __("Creation date") }}</th>
                @Auth()
                <th class="text-center">{{ __("Actions") }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td class="text-center">{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td>
                <td>
                    <a href="/tasks/{{ $task->id }}">
                        {{ $task->name }}
                    </a>
                </td>
                <td>{{ $task->creator->name }}</td>
                <td>{{ $task->executor->name }}</td>
                <td>{{ $task->created_at }}</td>
                <div class="btn-group">
                    @if (Auth::id())
                    <td class="text-center">
                        <a class="text-black" href="/tasks/{{ $task->id }}/edit">{{ __("Change") }}</a>
                        @if ((int) Auth::id() === (int) $task->author_id || Auth::user() && Auth::user()->isAdmin() )
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" data-message="{{ __('messages.taskDelete', ['name' => $task->name]) }}" data-id="{{ $task->id }}" class="btn btn-link text-danger">{{ __("Delete") }}
                        </button>
                        @endif
                    </td>
                    @endif
                </div>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>

<x-alert-confirm-delete></x-alert-confirm-delete>
<script>
    let modalEl = document.getElementById('deleteModal');
    modalEl.addEventListener('show.bs.modal', (event) => {
        let button = event.relatedTarget;
        modalEl.querySelector('.modal-body').textContent = button.dataset.message;
        modalEl.querySelector('.alert-delete-form').setAttribute('action', '/tasks/' + button.dataset.id)
    });
</script>
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('tasks.index') }}
@endsection