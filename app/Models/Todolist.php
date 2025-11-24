<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task; // ← WAJIB ditambahkan agar relasi dikenali

class Todolist extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'judul',
        'deadline',
    ];

    // Relasi ke tasks (1 todolist punya banyak task)
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
