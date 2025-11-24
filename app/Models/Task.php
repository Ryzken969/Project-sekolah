<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'todolist_id',
        'nama',
        'status'
    ];

    public function todolist()
    {
        return $this->belongsTo(Todolist::class);
    }
}
