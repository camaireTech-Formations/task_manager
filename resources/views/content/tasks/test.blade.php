@extends('layouts/contentNavbarLayout')


@section('title', 'Cards basic   - UI elements')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" integrity="sha512-gs7fqmRm/c61sC2hqDxEKtHw2byPiMv/LE8gVVj/Q9zZCvxHrpyrCPZ8WJ0fAh1YHHS5bz4+D4eIyX5X9DYnpQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">TASKS /</span> Manage Tasks</h4>


<!-- Grid Card -->
<div class="card">
  <h5 class="card-header">Task List</h5>
  
  @if($tasks)
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead style="margin-top : 10px;margin-bottom : 10px;">
          <tr>
            <th>Task Name</th>
            <th>Status</th>
            <th>Favorite</th>
            <th>Actions</th>
        </tr>
        </thead>
        @foreach ($tasks as $task)
    <tbody class="table-border-bottom-0">
    <tr>
        @if($task->statut == 1)
        <td><strong>{{ $task->task_name }}</strong></td>
            @elseif($task->statut == 2)
            <td><strong class="text-decoration-underline" >{{ $task->task_name }}</strong></td>
            @else 
            <td><strong class="text-decoration-line-through">{{ $task->task_name }}</strong></td>
            @endif
        <td>
            @if($task->statut == 1)
                <span class="badge bg-label-info me-1">Scheduled</span>
            @elseif($task->statut == 2)
                <span class="badge bg-label-warning me-1">Pending</span>
            @else 
                <span class="badge bg-label-success me-1">Completed</span>
            @endif
        </td>
        <td>
            <span class="favorite">
                {{--  <!-- Icône de favori vide -->  --}}
                @if ($task->favoris == 0)
                  <form action="{{ route('tasks.updateFavorite', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit"><i class="fa fa-heart-o" onclick="toggleHeart();" clickable></i></button>
                  </form>  
                @else
                  <form action="{{ route('tasks.updateFavorite', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button  type="submit"><i onclick="toggleHeart();" class="fa fa-heart clickable"></i>
                    </button>
                  </form>  
                @endif
            </span>
        </td>        
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                    <button class="dropdown-item" href="#" onclick="display({{$task}});"><i class="bx bx-edit-alt me-1"></i> Edit</button>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                        <button type="submit" class="dropdown-item "><i class="bx bx-trash me-1"></i> Delete</button>
                    </form>
                </div>
            </div>
        </td>
    </tr>
  @endforeach
      </table>
    </div>
    <div class="d-flex justify-content-center mt-5 ">
      {{$tasks->links()}}
  </div>
    @else
      <p>Aucune tache</p>
    @endif  

</div>


{{--  <h3 class="card-title">Add Task</h3>  --}}

  <div class="row mt-5">
    <div class="col-xl d-none" id="update" >
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Update Task</h5> <small class="text-muted float-end">Default Update</small>
        </div>
        <div class="card-body">           
           <form  action="{{route('tasks.update', '1') }}" id="update-form" method="post">  
            @csrf    
            @method('PUT')
            <input type="hidden" name="update_id" id="update_id">  
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">task Name</label>
              <input type="text" class="form-control" name = "task_name" id="task_name" value="{{ $task->task_name  }}" placeholder="Basic Task" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-message">Message</label>
              <textarea id="details" name="details" class="form-control" rows="12"  placeholder="Hi, Do you want to add any task ?">{{ $task->details }}</textarea>
            </div>
            <div class="form-group mb-3">
              <label for="statut">Status:</label>
              <select class="form-control"  name="statut">
                <option id="statut" value="1" {{ $task->statut == 1 ? 'selected' : '' }}>Scheduled</option>
                <option id="statut" value="2" {{ $task->statut == 2 ? 'selected' : '' }}>Pending</option>
                <option id="statut" value="3" {{ $task->statut == 3 ? 'selected' : '' }}>Complete</option>
              </select>
            </div>
            <div class="d-flex justify-content-between pt-4 mt-3">
              <button type="reset" class="btn btn-info">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>        
          </form>
        </div>
      </div>
    </div>
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Add Task</h5>
          <small class="text-muted float-end">Add any task</small>
        </div>
        <div class="card-body">
          <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
          
            <div class="form-outline mb-4">
              <label class="form-label" for="task_name">Task Name</label>
              <input type="text" id="task_name" name="task_name" class="form-control" value=" Basic Task" required/>
            </div>
          
            <div class="form-outline mb-4">
              <label class="form-label" for="details">Details</label>
              <textarea class="form-control" id="details" name="details" value=" " required rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-4">Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="row">
        <div class="col-md-6">
            <h5 class="card-header">Scheduled Tasks</h5>
            </div>
                <div class="col-md-6 text-end">
                    <div class="dropdown">
                        <button class="btn p-0 dropdown-toggle hide-arrow" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item">Date croissante</a></li>
                            <li><a class="dropdown-item">Date décroissante</a></li>
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
                        @if($task->statut == 1)
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

  <script>

    function display(task) {
      console.log(task);
      document.getElementById('task_name').value = task.task_name;
      document.getElementById('details').value = task.details;
      document.getElementById('statut').value = task.status;
      document.getElementById('update_id').value = parseInt(task.id);
      document.getElementById('update').classList.remove("d-none");
    }
  

    function toggleHeart() {
      const clickableHearts = document.querySelectorAll('.clickable');
      
      for(let i = 0; i < clickableHearts.length; i++) {
        clickableHearts[i].addEventListener('click', function() {
          const currentClass = clickableHearts[i].getAttribute('class');
    
          if(currentClass === 'fa fa-heart-o clickable') {
            clickableHearts[i].setAttribute('class', 'fa fa-heart clickable');
          } else {
            clickableHearts[i].setAttribute('class', 'fa fa-heart-o clickable');
          }
        });
      }
    }  
  </script>
@endsection


Route::get('/tasks', $controller_path . '\task\Task@index1')->name('tasks');
Route::get('/tasks', $controller_path . '\task\Task@index')->name('tasks');
Route::put('/tasks/{id}', $controller_path . '\task\Task@update')->name('tasks.update');
Route::put('/tasks/{id}', $controller_path . '\task\Task@updateFavorite')->name('tasks.updateFavorite');
Route::delete('/tasks/{id}', [Task::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks', [Task::class, 'store'])->name('tasks.store');
Route::get('/tasks/pending',  $controller_path . '\task\Task@getAsc')->name('tasks/pending');
Route::get('/tasks/pending',  $controller_path . '\task\Task@getDesc')->name('tasks/pending');
Route::get('/tasks/statistiques',  $controller_path . '\task\Task@stat')->name('tasks/statistiques');


*/


<div class="table-responsive text-nowrap">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Project</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
      <tr>
        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
        <td>Albert Cook</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><i class="fab fa-react fa-lg text-info me-3"></i> <strong>React Project</strong></td>
        <td>Barry Hunter</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><i class="fab fa-vuejs fa-lg text-success me-3"></i> <strong>VueJs Project</strong></td>
        <td>Trevor Baker</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td><i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>Bootstrap Project</strong></td>
        <td>Jerry Milton</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="col-md-4 mt-4 mb-4">
  <div class="card h-100">
      <div class="card-header d-flex justify-content-between align-items-center font-weight-bold">
          {{ $tasks[$i]->list_name }}
          {{--  <div class="form-group mb-3">
              <select class="form-control" name="statut">
              </select>
          </div>                  --}}
      </div>
      <p>{{ $tasks[$i]->task_name }}</p>
      {{--  <div class="card-body">
          <div class="table-responsive text-nowrap">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>Task Name</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                      <tr>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>{{ $tasks}}</strong></td>
                          <td><i class="fa fa-heart{{ $tasks[$i]->favoris ? '' : '-o' }}"></i></td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>  --}}
  </div>
</div>


  {{--  @foreach ($tasks as $task)  --}}
  @for ($i = 0 ; $i < 11; $i++)
  <div class="col-md-4 mt-4 mb-4">
    <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center font-weight-bold">
            <div class="form-group mb-3">
                <select class="form-control" name="statut">
                  <option value=""></option>
                </select>
            </div>                
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>{{ $tasks}}</strong></td>
                            <td><i class="fa fa-heart{{ $tasks[$i]->favoris ? '' : '-o' }}"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
  @endfor
{{--  @endforeach  --}}


@foreach($tasks as $list)
<div class="col-md-4 mt-4 mb-4">
    <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center font-weight-bold">
            {{ $list->list_name }}
            <div class="form-group mb-3">
                <select class="form-control" name="statut">
                    <option disabled selected value="1">Add ?</option>
                </select>
            </div>                
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong></strong></td>
                            <td><i class="fa fa-heart"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@foreach($list as $task)
            <p>{{ $task }}</p>
        @endforeach    
@endforeach




<div class="row">
  @foreach($tasks as $list)
<h2>{{ $list->list_name }}</h2>
    @foreach($list->task as $task)
      <div class="col-md-4 mt-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center font-weight-bold">
                <div class="form-group mb-3">
                    <select class="form-control" name="statut">
                      <option value=""></option>
                    </select>
                </div>                
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>{{ $task->name}}</strong></td>
                                <td><i class="fa fa-heart{{ $task->favoris ? '' : '-o' }}"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>     
    @endforeach
@endforeach 