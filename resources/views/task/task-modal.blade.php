<div class="modal fade" id="task-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="taskForm" method="POST" action="{{ url('task') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="form-task-title">
                        <label for="title">Task Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group" id="form-task-details">
                        <label for="details">Details</label>
                        <textarea class="form-control task-details" id="details" name="details"></textarea>
                    </div>
                    <div class="form-group" id="form-task-status" style="display: none">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            @foreach (config('cap.statuses') as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="task_id">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="save-btn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>