<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function index()
    {
        $lists = Todolist::latest()->get();
        return view('todolist.index', compact('lists'));
    }

    public function create()
    {
        return view('todolist.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deadline' => 'required|date'
        ]);

        $list = Todolist::create($request->all());

        // SETELAH SAVE → LANGSUNG KE CREATE TASK (FLOWCHART)
        return redirect()->route('todolist.show', $list->id);
    }

    public function show($id)
    {
        $list = Todolist::with('tasks')->findOrFail($id);
        return view('todolist.show', compact('list'));
    }

    public function edit($id)
    {
        $list = Todolist::findOrFail($id);
        return view('todolist.edit', compact('list'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deadline' => 'required|date'
        ]);

        Todolist::findOrFail($id)->update($request->all());

        return redirect()->route('todolist.index');
    }

    public function destroy($id)
    {
        Todolist::findOrFail($id)->delete();
        return redirect()->route('todolist.index');
    }
}
