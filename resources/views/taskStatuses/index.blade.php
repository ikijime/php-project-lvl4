@extends('layouts.app')

@section('content')

@include('flash::message')

<main class="container">
    <h1 class="mb-5">Статусы Задач</h1>

    @if (Auth::User())
    <a href="/task_statuses/create" class="btn btn-primary ml-auto">Создать статус</a>
    @endif

    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Дата создания</th>
            </tr>
        </thead>
        <tr>
            @foreach($taskStatuses as $taskStatus)
            <td> {{ $taskStatus->id }} </td>
            <td> {{ $taskStatus->name }} </td>
            <td> {{ $taskStatus->created_at }} </td>
            @if (Auth::id())
            <td>
                <div class="btn-group">
                    <a class="text-black" href="/task_statuses/{{ $taskStatus->id }}/edit">Изменить</a>
                    @if($taskStatus->task()->count() == 0)
                        <button type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-link text-danger pt-0">Удалить</button>
                    @else
                        <button type="button" data-toggle="modal" data-target="#cannotDeleteModal" class="btn btn-link text-muted pt-0">Удалить</button>
                    @endif

                </div>
            </td>
            @endif
        </tr>
        @endforeach
    </table>

<!-- Подтверждение удаления -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Вы уверены что хотите удалить статус {{ $taskStatus->name ?? '' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <form action="/task_statuses/{{ $taskStatus->id ?? '' }}" method="POST">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-primary">Удалить</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Подтверждение удаления -->

<!-- Невозможно удалить -->
<div class="modal fade" id="cannotDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Невозможно удалить статус {{ $taskStatus->name ?? '' }} пока он используется в задачах.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>
<!-- Невозможно удалить -->

</main>
@endsection