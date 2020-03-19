@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome {{ Auth::user()->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged at {{ date('d/m/y h:i:s') }}

                <div id="container">
                    <h1></h1>
                    <p>Your Session ends in <span>30:00 minutes.</span></p>
                    
                    <div id="clock"></div>
<!-- 
                    <h1 class='timer' data-minutes-left=1></h1>
                    <h1 class='timer' data-seconds-left=30></h1> -->
                </div>  
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
<h3>Your time logs for today</h3>
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
<script src="{{ asset('js/jquery.js') }}"></script>
<script>
$(document).ready(function(){

    $.ajax({
        url : {{ route('loguser') }},
        type: "POST",
        data : {{ Auth::user()->id }},
        success: function(response){
            alert("hello");
        },
    })

    var counter = 0;
    var timeLeft = 5;
    function convertSeconds(s) {
        var min  = Math.floor(s / 60);
        var sec  = s % 60;
        return min + ':' + sec
    }
    var timer = $("#clock").text();
    $("#clock").text(convertSeconds(timeLeft - counter));
    function timeIt(){
        counter++;
        $("#clock").text(convertSeconds(timeLeft - counter));
        if((timeLeft - counter) == 15) {
            prompt("3 more minutes left")
            $.ajax({

            })
        } else if ( (timeLeft - counter) == 0){
            alert("Your logged out")
        }
    }
    setInterval(timeIt, 1000);
    
    
})
</script>
@endsection
