<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Todolist;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /* ===============================
       HALAMAN INDEX GABUNGAN
       =============================== */
    public function index()
    {
        // Ambil data items
        $items = Item::all();

        // Ambil data todolist + relasi tasks
        $lists = Todolist::with('tasks')->get();

        // Tampilkan ke 1 halaman blade
        return view('items.index', compact('items', 'lists'));
    }


    /* ===============================
       CREATE ITEM
       =============================== */
    public function create()
    {
        return view('items.create');
    }


    /* ===============================
       STORE ITEM
       =============================== */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'file' => 'nullable|file|max:2048'
        ]);

        $fileName = null;

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('uploads'), $fileName);
        }

        Item::create([
            'nama' => $request->nama,
            'file' => $fileName
        ]);

        return redirect()->route('items.index')->with('success', 'Data berhasil ditambahkan');
    }


    /* ===============================
       EDIT ITEM
       =============================== */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }


    /* ===============================
       UPDATE ITEM
       =============================== */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'nama' => 'required',
            'file' => 'nullable|file|max:2048'
        ]);

        $fileName = $item->file;

        if ($request->hasFile('file')) {

            // Hapus file lama
            if ($item->file && file_exists(public_path('uploads/' . $item->file))) {
                unlink(public_path('uploads/' . $item->file));
            }

            // Simpan file baru
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('uploads'), $fileName);
        }

        $item->update([
            'nama' => $request->nama,
            'file' => $fileName
        ]);

        return redirect()->route('items.index')->with('success', 'Data berhasil diupdate');
    }


    /* ===============================
       DELETE ITEM
       =============================== */
    public function destroy(Item $item)
    {
        if ($item->file && file_exists(public_path('uploads/' . $item->file))) {
            unlink(public_path('uploads/' . $item->file));
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Data dan file berhasil dihapus');
    }
}
