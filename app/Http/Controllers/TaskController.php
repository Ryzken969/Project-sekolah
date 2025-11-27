<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * SIMPAN TASK BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'todolist_id' => 'required|exists:todolists,id',
            'nama'        => 'required|string|min:1'
        ]);

        Task::create([
            'todolist_id' => $request->todolist_id,
            'nama'        => $request->nama,
            'status'      => false
        ]);

        return back()->with('success', 'Task berhasil ditambahkan');
    }

    /**
     * HAPUS TASK
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return back()->with('success', 'Task berhasil dihapus');
    }
}
