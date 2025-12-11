<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    /**
     * Tampilkan semua To-do List
     */
    public function index()
    {
        $todolists = Todolist::latest()->get();
        return view('todolist.index', compact('todolists'));
    }

    /**
     * Form tambah To-do List
     */
    public function create()
    {
        return view('todolist.create');
    }

    /**
     * Simpan To-do List baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deadline' => 'required|date'
        ]);

        $todolist = Todolist::create([
            'judul'    => $request->judul,
            'deadline' => $request->deadline
        ]);

        // Setelah simpan → langsung ke halaman detail list
        return redirect()->route('todolist.show', $todolist->id);
    }

    /**
     * Detail To-do List + Task di dalamnya
     */
    public function show($id)
    {
        $todolist = Todolist::with('tasks')->findOrFail($id);
        return view('todolist.show', compact('todolist'));
    }

    /**
     * Form edit To-do List
     */
    public function edit($id)
    {
        $todolist = Todolist::findOrFail($id);
        return view('todolist.edit', compact('todolist'));
    }

    /**
     * Update To-do List
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deadline' => 'required|date'
        ]);

        Todolist::findOrFail($id)->update([
            'judul'    => $request->judul,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('todolist.index');
    }

    /**
     * Hapus To-do List
     */
    public function destroy($id)
    {
        Todolist::findOrFail($id)->delete();
        return redirect()->route('todolist.index');
    }
}
