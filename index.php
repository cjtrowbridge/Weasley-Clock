<?php

if(file_exists('Config.php')){
  include('Config.php');
}else{
  die('Create Config.php from Config.sample.php');
}

if(
  isset($_GET['key']) &&
  isset($_GET['person']) &&
  isset($_GET['place'])
){
  if(
    isset( $People[ $_GET['person'] ] ) &&
    isset( $Places[ $_GET['place'] ] ) &&
    ( $People[ $_GET['person'] ][ $_GET['Key'] == $_GET['key'] )
  ){
    //"Away" includes transit between routers. Everyone becomes away in between destinations. Maybe another name would be better(?)
    
    $LogEntry = '<p>'.$_GET['person'];
    if(strtolower($_GET['place'])=='away'){
      $LogEntry .= " went away.";
    }else{
      $LogEntry .= " arrived at ".$_GET['place'].".";
    }
    $LogEntry .= '</p>';
    
    //Update the file tracking each person's current location
    file_put_contents('people/'.$_GET['person'].'.txt', $_GET['place']);
    
    if(file_exists('people/log.txt')){
      $Log = file_get_contents('people/log.txt');
    }else{
      $Log='';
    }
    $Log = $LogEntry.PHP_EOL.$Log;
    
    file_put_contents('people/log.txt',$Log);
      
    die('<p>Done.</p>');
  }
}

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/favicon.ico">

  <title>Weasley Clock</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

  <style>
    .person{
      width: 240px;
      height: 240px;
      display: inline-block;
      margin: .5rem .5rem 0 0;
      border: 1px solid grey;
      overflow: hidden;
      text-align: center;
    }
    .person img{
      height: 100%;
      width: 100%;
      max-width: 100%;
      max-height: 100%;
    }
  </style>

</head>

<body>

<div class="container">
  <div class="row">
    
    <div class="col-12">
      <h1>Weasley Clock v2.0</h1>
    </div>
    
    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-header">
          Home
        </div>
        <div class="card-body">
          <div id="home"></div>
        </div><!--/card-body-->
      </div><!--/card-->
      <br>
      <div class="card">
        <div class="card-header">
          Away
        </div>
        <div class="card-body">
          <div id="away"></div>
        </div><!--/card-body-->
      </div><!--/card-->
    </div><!--/col-12  col-md-4-->
    
    <div class="col-12 col-md-4">
      <div class="card">
        <div class="card-header">
          Log
        </div>
        <div class="card-body">
          <div id="log"></div>
        </div><!--/card-body-->
      </div><!--/card-->
    </div><!--/col-12  col-md-4-->
    
  </div><!--/row-->
</div><!--/container-->

<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


<script>

function LocatePeople(){

  $('#home').html('');
  $('#away').html('');

  console.log('Fetching Log...');
  $.get( "people/log.txt?"+$.now(), function(data){
    $('#log').html('data');
  });
  
  console.log("Checking...");
  $.each([<?php
      $PeopleString='';  
      foreach($People as $Person => $Array){
        $PeopleString .= "'".$Person."', ";
      }
      $PeopleString = rtrim($PeopleString, ", ");
      echo $PeopleString;
    ?>], function( index, person ) {
    $.get( "people/"+person+".txt?"+$.now(), function(data){
      if(data=='home'){
        var position = 'home';
      }else{
        var position = 'away';
      }
      console.log(person+" is "+position+'('+data+')');
      
      $('<div class="person"><a href="#"><!--'+person+'<br>--><img src="/img/'+person.toString().toLowerCase()+'.jpg" alt=""></a></div>').appendTo("#"+position);

      ResizePeople();


    });

  });

}

function ResizePeople(){
  $(".person").width($("#home").width()/2-40);

  $( ".person" ).each(function( index ) {
    $(this).height($(this).width());
  });
}

$(window).resize(function(){
  ResizePeople();
});

setInterval(function(){ LocatePeople(); }, 60000);
LocatePeople();

</script>

</body>
</html>

