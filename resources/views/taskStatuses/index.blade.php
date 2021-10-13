@extends('layouts.app')

@section('content')
@php $unableDeleteMessage = "Невозможно удалить статус пока он используется в задачах." @endphp
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

                    @if( !$usedStatusIds->contains($taskStatus->id) )
                    @php $deleteMessage = "Вы хотите удалить статуc {$taskStatus->name} ?" @endphp
                        <button 
                          type="button" 
                          data-toggle="modal" 
                          data-target="#deleteModal" 
                          data-message="{{ $deleteMessage }}"
                          data-id="{{ $taskStatus->id }}"
                          class="btn btn-link text-danger pt-0">Удалить
                      </button>
                    @else
                        <button 
                          type="button" 
                          data-toggle="modal" 
                          data-target="#cannotDeleteModal" 
                          class="btn btn-link text-muted pt-0">Удалить
                      </button>
                    @endif

                </div>
            </td>
            @endif
        </tr>
        @endforeach
    </table>

<!-- Подтверждение удаления -->
<x-alert-confirm-delete></x-alert-unable-delete>
<!-- Подтверждение удаления -->

 <!-- Невозможно удалить -->
<x-alert-unable-delete :message="$unableDeleteMessage"></x-alert-unable-delete>
 <!-- Невозможно удалить -->

<script>
$('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var message = button.data('message') 
  var id = button.data('id')

  var modal = $(this)
  modal.find('.alert-delete-form').attr('action', '/task_statuses/' + id)
  modal.find('.modal-body').text(message)
})
</script>
</main>
@endsection