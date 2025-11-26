<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    /**
     * Menampilkan seluruh todolist
     */
    public function index()
    {
        $todolist = Todolist::with('tasks')->get();
        return view('todolist.index', compact('todolist'));
    }

    /**
     * Menampilkan form tambah todolist
     */
    public function create()
    {
        return view('todolist.create');
    }

    /**
     * Menyimpan data todolist
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required',
            'deadline' => 'required|date'
        ]);

        Todolist::create([
            'judul'    => $request->judul,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('todolist.index')
            ->with('success', 'Daftar berhasil ditambahkan');
    }

    /**
     * Menampilkan detail todolist
     */
    public function show($id)
    {
        $list = Todolist::with('tasks')->findOrFail($id);
        return view('todolist.show', compact('list'));
    }

    /**
     * Menampilkan form edit todolist
     */
    public function edit($id)
    {
        $todolist = Todolist::findOrFail($id);
        return view('todolist.edit', compact('todolist'));
    }

    /**
     * Update todolist
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'    => 'required',
            'deadline' => 'required|date'
        ]);

        $todolist = Todolist::findOrFail($id);
        $todolist->update([
            'judul'    => $request->judul,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('todolist.index')
            ->with('success', 'Daftar berhasil diupdate');
    }

    /**
     * Hapus todolist
     */
    public function destroy($id)
    {
        $todolist = Todolist::findOrFail($id);
        $todolist->delete();

        return redirect()->route('todolist.index')
            ->with('success', 'Daftar berhasil dihapus');
    }
}
