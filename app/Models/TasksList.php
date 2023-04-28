<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class TasksList extends Model
{
    use HasFactory;
    protected $fillable = ['list_name'];

    public function task()
    {
        return $this->hasMany(Task::class);
    }
}
