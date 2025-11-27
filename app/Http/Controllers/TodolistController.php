<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    // INDEX — tampilkan semua daftar
    public function index()
    {
        // ambil data terbaru dulu
        $lists = Todolist::with('tasks')->latest()->get();
        return view('todolist.index', compact('lists'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('todolist.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        Todolist::create([
            'judul' => $request->judul,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('todolist.index')->with('success', 'Daftar berhasil ditambahkan');
    }

    // SHOW (detail + task)
    public function show($id)
    {
        $list = Todolist::with('tasks')->findOrFail($id);
        return view('todolist.show', compact('list'));
    }

    // EDIT
    public function edit($id)
    {
        $todolist = Todolist::findOrFail($id);
        return view('todolist.edit', compact('todolist'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        $t = Todolist::findOrFail($id);
        $t->update([
            'judul' => $request->judul,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('todolist.index')->with('success', 'Data berhasil diupdate');
    }

    // DESTROY
    public function destroy($id)
    {
        $t = Todolist::findOrFail($id);
        $t->tasks()->delete(); // optional: bersihkan tasks
        $t->delete();

        return redirect()->route('todolist.index')->with('success', 'Data berhasil dihapus');
    }
}
