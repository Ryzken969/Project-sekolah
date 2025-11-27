<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'todolist_id' => 'required',
            'nama' => 'required'
        ]);

        Task::create([
            'todolist_id' => $request->todolist_id,
            'nama' => $request->nama,
            'status' => false
        ]);

        return back();
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return back();
    }
}
