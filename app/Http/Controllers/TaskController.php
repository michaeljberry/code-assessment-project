<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(TaskRequest $request)
    {
        $status = $request['status'];
        $id = $request['id'];
        $user_id = Auth::user()->id;

        $task = $id ? Task::find($id) : new Task;
        if(!isset($status)) {
            $task->title = $request['title'];
            $task->details = $request['details'];
        }
        $task->status = isset($status) ? $status : $task->status;
        $task->user_id = $user_id;
        $task->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        $data['task'] = Task::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data['task'] = $task = Task::find($id);
        $task->delete();
        
        return response()->json($data);
    }
}
