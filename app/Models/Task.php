<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'tasks_list_id' , 'details'];

    public function taksList()
    {
        return $this->belongsTo(TaskList::class);
    }
}
