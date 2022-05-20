<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        {{ __("Confirm deletion") }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("Close") }}</button>
        <form action="" method="POST" class="alert-delete-form">
          @method('delete')
          @csrf
          <button type="submit" class="btn btn-primary">{{ __("Delete?") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>