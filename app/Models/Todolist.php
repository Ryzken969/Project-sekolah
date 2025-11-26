<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task; // agar relasi tasks dikenali

class Todolist extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'judul',
        'deadline',
    ];

    // Relasi: 1 Todolist punya banyak Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
