<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['task_name' , 'details' , 'tasks_list_id'];

    public function tasksList()
{
    return $this->belongsTo(TasksList::class);
}
}
