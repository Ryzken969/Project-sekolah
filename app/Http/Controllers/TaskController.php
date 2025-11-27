<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // (OPSIONAL) TAMPILKAN SEMUA TASK JIKA ADA HALAMAN task.index
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('task.index', compact('tasks'));
    }

    // SIMPAN TASK BARU
    public function store(Request $request)
    {
        $request->validate([
            'todolist_id' => 'required|exists:todolists,id',
            'nama'        => 'required|string|max:255'
        ]);

        Task::create([
            'todolist_id' => $request->todolist_id,
            'nama'        => $request->nama,
            'status'      => false
        ]);

        return back()->with('success', 'Task berhasil ditambahkan');
    }

    // HAPUS TASK
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return back()->with('success', 'Task berhasil dihapus');
    }
}
