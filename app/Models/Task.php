<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Todolist;

class Task extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'todolist_id',
        'nama',
        'status'
    ];

    // 1 Task milik 1 Todolist
    public function todolist()
    {
        return $this->belongsTo(Todolist::class);
    }
}
