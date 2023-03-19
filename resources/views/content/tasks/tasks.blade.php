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
                <!-- Icône de favori vide -->
                @if ($task->favoris == 0)
                    <i class="fa fa-heart-o clickable" onclick="toggleHeart();" data-task-id="{{ $task->id }}"></i>
                @else
                    <i class="fa fa-heart clickable" onclick="toggleHeart();" data-task-id="{{ $task->id }}"></i>
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
                        <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i> Delete</button>
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
          <form action="{{ route('tasks.update', '1') }}" id="update-form" method="post">
            @csrf    
            @method('put'); 
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
      /*const clickableHearts = document.querySelectorAll('.clickable');
      
      for(let i = 0; i < clickableHearts.length; i++) {
        clickableHearts[i].addEventListener('click', function() {
          const currentClass = clickableHearts[i].getAttribute('class');
    
          if(currentClass === 'fa fa-heart-o clickable') {
            clickableHearts[i].setAttribute('class', 'fa fa-heart clickable');
          } else {
            clickableHearts[i].setAttribute('class', 'fa fa-heart-o clickable');
          }
        });
      }*/
      $('.clickable').click(function() {
        // ID de la tâche correspondante
        var taskId = $(this).data('task-id');

        // Nouvelle valeur de favori
        var newFavorite = 0;
        if ($(this).hasClass('fa-heart-o')) {
            newFavorite = 1;
        }

        // Requête AJAX pour mettre à jour la tâche
        $.ajax({
            url: '/tasks/' + taskId + '/update-favorite',
            type: 'PUT',
            data: { 'favoris': newFavorite },
            success: function(response) {
                // Mettre à jour l'icône de favori dans la vue
                if (newFavorite == 1) {
                    $('.favorite i').removeClass('fa-heart-o').addClass('fa-heart');
                    console.log('jytyrdyg');
                } else {
                    $('.favorite i').removeClass('fa-heart').addClass('fa-heart-o');
                    console.log('58451487458458745');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
    }
    
  </script>
@endsection
