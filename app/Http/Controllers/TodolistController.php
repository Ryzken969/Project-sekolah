<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    // ✅ TAMPILKAN SEMUA TODOLIST (HALAMAN DASHBOARD)
    public function index()
    {
        $todolists = Todolist::latest()->get();
        return view('todolist.index', compact('todolists'));
    }

    // ✅ FORM TAMBAH TODOLIST
    public function create()
    {
        return view('todolist.create');
    }

    // ✅ SIMPAN TODOLIST BARU
    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required',
            'deadline' => 'required|date'
        ]);

        $todolist = Todolist::create($request->all());

        // ✅ SETELAH SIMPAN → LANGSUNG KE DETAIL (SESUAI FLOWCHART)
        return redirect()->route('todolist.show', $todolist->id);
    }

    // ✅ DETAIL TODOLIST + TASK
    public function show($id)
    {
        $todolist = Todolist::with('tasks')->findOrFail($id);
        return view('todolist.show', compact('todolist'));
    }

    // ✅ FORM EDIT TODOLIST
    public function edit($id)
    {
        $todolist = Todolist::findOrFail($id);
        return view('todolist.edit', compact('todolist'));
    }

    // ✅ UPDATE TODOLIST
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'    => 'required',
            'deadline' => 'required|date'
        ]);

        Todolist::findOrFail($id)->update($request->all());

        return redirect()->route('todolist.index');
    }

    // ✅ HAPUS TODOLIST
    public function destroy($id)
    {
        Todolist::findOrFail($id)->delete();
        return redirect()->route('todolist.index');
    }
}
