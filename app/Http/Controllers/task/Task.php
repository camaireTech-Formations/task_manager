<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Task extends Controller
{
  public function index()
  {
    return view('content.tasks.tasks');
  }
}
