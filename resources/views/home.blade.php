@extends('layouts.app')
@section('content')
<div class="container-fluid plr-80">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-right p-15">
                <a href="javascript:;" id="create-task" class="btn btn-primary btn-sm btn-flat">Create Task</a>
            </div>
            <div class="card">
                <div class="card-header">Task Manager</div>
                <div class="card-body">
                    <table class="table table-hover table-striped" id="task-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Title</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->details }}</td>
                                <td>{{ $item->status ? $item->status : 'To Do' }}</td>
                                <td>{{ $item->created_at_display }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="javascript:;" onclick="taskAction('change-status', {{ $item->id }})">Change Status</a>
                                            <a class="dropdown-item" href="javascript:;" onclick="taskAction('edit', {{ $item->id }})">Edit</a>
                                            <a class="dropdown-item" href="javascript:;" onclick="taskAction('destroy', {{ $item->id }})">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('task.task-modal')
@endsection

@section('page-css')
<link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<style>
.plr-80 {
    padding: 0 80px !important;
}
</style>
@endsection

@section('page-js')
<script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\TaskRequest') !!}
<script>
var taskTable;
$(document).ready(function () {
    $('#create-task').click(function (e) { 
        e.preventDefault();
        $('#modal-title').html('Create New Task');
        $('#taskForm')[0].reset();
        $('#task_id').val('');
        $('#task-modal').modal('show');
    });

    taskTable = $('#task-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
    });
});

function taskAction(action, id) {
    $('#form-task-title').show();
    $('#form-task-details').show();
    $('#form-task-status').hide();
    if(action === 'edit') {
        $.ajax({
            type: "GET",
            url: "{{ url('task') }}/"+id+"/edit",
            dataType: "json",
            success: function (response) {
                $('#modal-title').html('Update Task');
                $('#title').val(response.task.title);
                $('#details').val(response.task.details);
                $('#task_id').val(response.task.id);
                $('#task-modal').modal('show');
            }
        });
    } else if(action === 'change-status') {
        $('#modal-title').html('Change Task Status');
        $('#form-task-title').hide();
        $('#form-task-details').hide();
        $('#form-task-status').show();
        $('#task_id').val(id);
        $('#task-modal').modal('show');
    } else if(action === 'destroy') {
        if(confirm('Are you sure you want to delete this?')) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('task') }}/"+id,
                dataType: "json",
                success: function (response) {
                    location.reload();
                }
            });
        }
    }
}
</script>
@endsection
