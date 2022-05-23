@extends('layouts.app')

@section('content')
<main class="container py-2">
    <h1 class="mb-4">{{ __("Task statuses") }}</h1>
    @if (Auth::User())
    <a href="/task_statuses/create" class="btn btn-primary ml-auto">{{ __("Create status") }}</a>
    @endif

    <table class="table mt-2 table-striped">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>{{ __("Name") }}</th>
                <th>{{ __("Creation date") }}</th>
                @Auth()
                <th class="text-center">{{__("Actions")}}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($taskStatuses as $taskStatus)
                <td class="text-center"> {{ $taskStatus->id }} </td>
                <td> {{ $taskStatus->name }} </td>
                <td> {{ $taskStatus->created_at }} </td>
                @if (Auth::id())
                <td class="text-center">
                    @if( !$usedStatusIds->contains($taskStatus->id) )
                        <a  href="{{ route('task_statuses.destroy', $taskStatus->id )}}"
                            data-method="delete"
                            rel="nofollow"
                            data-confirm="Вы уверены?"
                            class="text-danger pt-0 me-2" 
                            ">{{ __("Delete") }}
                        </a>
                    @else
                        <a 
                            data-bs-toggle="modal" 
                            data-bs-target="#cannotDeleteModal" 
                            class="text-muted pt-0 me-2">{{ __("Delete") }}
                        </a>
                    @endif
                    <a class="text-black" href="{{ route('task_statuses.edit', $taskStatus->id )}}">{{ __("Change") }}</a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

</main>
<script>
/*     let modalEl = document.getElementById('deleteModal');
    modalEl.addEventListener('show.bs.modal', (event) => {
        let button = event.relatedTarget;
        modalEl.querySelector('.modal-body').textContent = button.dataset.message;
        modalEl.querySelector('.alert-delete-form').setAttribute('action', '/task_statuses/' + button.dataset.id)
    }); */
</script>
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('task_statuses.index') }}
@endsection

