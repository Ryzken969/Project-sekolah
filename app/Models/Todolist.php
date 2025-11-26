<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task; // WAJIB agar relasi dikenali

class Todolist extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (fillable)
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
