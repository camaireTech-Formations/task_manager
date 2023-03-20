@extends('layouts/contentNavbarLayout')


@section('title', 'Cards basic - UI elements')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Pending Tasks</h5>
                </div>
                    <div class="col-md-6 text-end">
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle hide-arrow" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{route('tasks/pending', ['sort' => 'asc']) }}">Date croissante</a></li>
                                <li><a class="dropdown-item" href="{{route('tasks/pending', ['sort' => 'desc']) }}">Date décroissante</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Task Name</th>
                                <th style="width: 50%; text-align: center;">Details</th>
                                <th style="width: 25%; white-space: nowrap;">Date creation</th>
                            </tr>
                        </thead>
                        @foreach ($tasks as $task)
                            @if($task->statut == 2)
                                <tr>
                                    <td><strong>{{$task->task_name}}</strong></td>
                                    <td style="width: 50%; text-align: center;"><strong>{{$task->details }}</strong></td>
                                    <td style="white-space: nowrap;"><strong>{{$task->created_at }}</strong></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                                        
                </div>    
        </div>
    </div>
@endsection