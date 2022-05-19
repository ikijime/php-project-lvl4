@extends('layouts.app')

@section('content')
@php $filterInput = app('request')->filter @endphp
<main class="container">
    <h1 class="mb-5">{{ __("Tasks") }}</h1>
    <div class="d-flex">
        <div>
            <form method="GET" action="/tasks" accept-charset="UTF-8" class="form-inline">
                <select class="form-control mr-2" name="filter[status_id]" id="status_id">
                    <option value="">{{ __("Status") }}</option>
                    @foreach (\App\Models\TaskStatus::all() as $status)
                    <option value="{{ $status->id }}" 
                        @if(isset($filterInput['status_id']) && $filterInput['status_id'] == $status->id) selected @endif>
                        {{ $status->name }}
                    </option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[author_id]">
                    <option value="">{{ __("Author") }}</option>
                    @foreach (\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}"
                        @if(isset($filterInput['author_id']) && $filterInput['author_id'] == $user->id) selected @endif>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[assigned_to_id]">
                    <option selected="selected" value="">{{ __("Executor") }}</option>
                    @foreach (\App\Models\User::all() as $user)
                    <option value=" {{ $user->id }} "
                        @if(isset($filterInput['assigned_to_id']) && $filterInput['assigned_to_id'] == $user->id) selected @endif>
                        {{ $user->name }} 
                    </option>
                    @endforeach
                </select>
                <input class="btn btn-outline-primary mr-2" type="submit" value="{{ __("Apply") }}">
            </form>
        </div>
        @if (Auth::User())
        <a href="/tasks/create" class="btn btn-primary ml-auto">{{ __("Create task") }}</a>
        @endif
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __("Status") }}</th>
                <th>{{ __("Name") }}</th>
                <th>{{ __("Author") }}</th>
                <th>{{ __("Executor") }}</th>
                <th>{{ __("Creation date") }}</th>
                @Auth()
                <th>{{ __("Actions") }}</th>
                @endauth
            </tr>
        </thead>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->status->name }}</td>
            <td>
                <a href="/tasks/{{ $task->id }}">
                    {{ $task->name }}
                </a>
            </td>
            <td>{{ $task->creator->name }}</td>
            <td>{{ $task->executor->name }}</td>
            <td>{{ $task->created_at }}</td>

            
            <td>
                <div class="btn-group">
                    @if (Auth::id())
                        <a class="text-black" href="/tasks/{{ $task->id }}/edit">{{ __("Change") }}</a>
                    @endif
                    @if (Auth::id() === $task->author_id or Auth::user() && Auth::user()->isAdmin() )
                        <form action="/tasks/{{ $task->id }}" method="POST">
                            @method('delete')
                            @csrf
                            <button 
                                type="button" 
                                data-toggle="modal" 
                                data-target="#deleteModal" 
                                data-message="{{ __('messages.tasksDelete', ['name' => $task->name]) }}"
                                data-id="{{ $task->id }}"
                                class="btn btn-link text-danger pt-0">{{ __("Delete") }}
                            </button>
                        </form>
                    @endif
                </div>
            </td>
            @endforeach
        </tr>
    </table>

<!-- Подтверждение удаления -->
<x-alert-confirm-delete></x-alert-unable-delete>
<!-- Подтверждение удаления -->

<script>
$('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var message = button.data('message') 
  var id = button.data('id')

  var modal = $(this)
  modal.find('.alert-delete-form').attr('action', '/tasks/' + id)
  modal.find('.modal-body').text(message)
})
</script>
</main>
@endsection