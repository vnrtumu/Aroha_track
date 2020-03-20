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
                    You are logged at {{ Auth::user()->last_login_at }}
                <div id="container">
                    <h1></h1>
                    <p>Your Session ends in <span id="clock" style="font-size: 44px; color: red " > </span> minutes.</p>
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
    <?php $k = 1; ?>
    @foreach ($userlogs as $userlog)
    <?php 

        // Declare and define two dates 
        $date1 = strtotime($userlog->last_login_time );
        $date2 =strtotime($userlog->last_logout_time);
        // Formulate the Difference between two dates 
        $diff = abs($date2 - $date1); 

        $years = floor($diff / (365*60*60*24));

        $months = floor(($diff - $years * 365*60*60*24) 
                                    / (30*60*60*24)); 

        $days = floor(($diff - $years * 365*60*60*24 - 
                    $months*30*60*60*24)/ (60*60*24)); 

        $hours = floor(($diff - $years * 365*60*60*24 
            - $months*30*60*60*24 - $days*60*60*24) 
                                        / (60*60)); 

        $minutes = floor(($diff - $years * 365*60*60*24 
                - $months*30*60*60*24 - $days*60*60*24 
                                - $hours*60*60)/ 60); 

        $seconds = floor(($diff - $years * 365*60*60*24 
                - $months*30*60*60*24 - $days*60*60*24 
                        - $hours*60*60 - $minutes*60)); 

?> 

    <tr>
      <th scope="row">{{ $k }}</th>
      <td>{{ $userlog->last_login_time }}</td>
      <td>{{ $userlog->last_logout_time }}</td>
      <td><?php

      if($date1 != '' && $date2 != ''){
            printf("  %d hours, %d minutes, %d seconds", $hours, $minutes, $seconds); 
       
        
      }
       ?></td>
    </tr>
    <?php $k++; ?>
    @endforeach
  </tbody>
</table>
</div>



<div class="modal fade" id="MyPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Do You Want to contiue the Session?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="continue">Countinue....</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    
    function displayTime() {
        var str = "";
        var currentTime = new Date()
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var month = currentTime.getMonth()+1; 
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();

        if (minutes < 10) {
            minutes = "0" + minutes
        }
        if (seconds < 10) {
            seconds = "0" + seconds
        }

        if (day < 10) {
            day = "0" + day
        }
        if (month < 10) {
            month = "0" + month
        }
        str += year +"-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds + " ";
        
        return str;
    }
    var date = displayTime();
    var counter = 0;
    var timeLeft = 1800;
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
        if((timeLeft - counter) == 180) {
            $("#MyPopup").modal("show");
        } else if ( (timeLeft - counter) == 0){
            var date = displayTime();
            $.ajax({
                type:'POST',
                url:'/update',
                data: {  
                    "_token": "{{ csrf_token() }}", 
                    "user_id": {{ Auth::user()->id }}, 
                    "last_logout_time": date,  
                    },
                success:function() {
                    location.reload(true);
                }
            })
        }
    }
    setInterval(timeIt, 1000);
    


    $("#logout").click(function() {
            function displayTime() {
                var str = "";
                var currentTime = new Date()
                var hours = currentTime.getHours();
                var minutes = currentTime.getMinutes();
                var seconds = currentTime.getSeconds();
                var month = currentTime.getMonth()+1; 
                var day = currentTime.getDate();
                var year = currentTime.getFullYear();

                if (minutes < 10) {
                    minutes = "0" + minutes
                }
                if (seconds < 10) {
                    seconds = "0" + seconds
                }

                if (day < 10) {
                    day = "0" + day
                }
                if (month < 10) {
                    month = "0" + month
                }
                str += year +"-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds + " ";
                
                return str;
            }
            var date = displayTime();
            $.ajax({
                type:'POST',
                url:'/update',
                data: {  
                    "_token": "{{ csrf_token() }}", 
                    "user_id": {{ Auth::user()->id }}, 
                    "last_logout_time": date,  
                    },
                success:function() {
                    location.reload(true);
                }
            });
    });


    $("#continue").click(function(){
        $("#MyPopup").modal("hide");
        location.reload(true);
    })
    
})
</script>
@endsection
