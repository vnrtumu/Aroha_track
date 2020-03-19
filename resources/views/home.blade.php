@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                <div id="container">
                    <h1>You time stats now</h1>
                    <h1 class='timer' data-minutes-left=1></h1>
                    <h1 class='timer' data-seconds-left=30></h1>
                </div>  
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
<h3>Today Your Activity</h3>
<table class="table">

  <thead class="bg-dark text-light" >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Login</th>
      <th scope="col">Logged Out</th>
      <th scope="col">Duration</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>19-03-2020 9:00.</td>
      <td>19-03-2020 9:30.</td>
      <td>30 mins</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>19-03-2020 9:30.</td>
      <td>19-03-2020 10:00.</td>
      <td>30 mins</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>19-03-2020 10:22.</td>
      <td>19-03-2020 10:52.</td>
      <td>30 mins</td>
    </tr>
  </tbody>
</table>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
        crossorigin="anonymous"></script>
<script src="{{ asset('js/jquery.simple.timer.js') }}"></script>
<script>
    
    $( document ).ready(function() {
        // alert("hi");
        $('.timer').startTimer();
        $('.timer').startTimer({
            onComplete: function(element){
                // do something...
            }
        })
    })
    
    

    
</script>
@endsection
