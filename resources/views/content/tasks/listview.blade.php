@extends('layouts/contentNavbarLayout')


@section('title', 'Cards basic   - UI elements')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" integrity="sha512-gs7fqmRm/c61sC2hqDxEKtHw2byPiMv/LE8gVVj/Q9zZCvxHrpyrCPZ8WJ0fAh1YHHS5bz4+D4eIyX5X9DYnpQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="row">
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
                                @foreach($list->task as $ttask)
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>{{$ttask->task_name}}</strong></td>
                                        <td><i class="fa fa-heart{{ $ttask->favoris ? '' : '-o' }}"></i></td>
                                    </tr>
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>      
    @endforeach
</div>
    

@endsection  