<?php

if(file_exists('Key.php')){
  include('Key.php');
}else{
  die('Create Key.php from Key.sample.php');
}

if(
  isset($_GET['key'])&&
  ($Key==$_GET['key'])&&
  (
    $_GET['position']=='home' ||
    $_GET['position']=='away'
  )&&(
    $_GET['person']=='CJ' ||
    $_GET['person']=='Ben' ||
    $_GET['person']=='Zach' ||
    $_GET['person']=='Jenny'
  )
){

  switch($_GET['person']){
    case 'Ben':
    case 'Zach':
    case 'CJ':
    case 'Jenny':
      echo '<p>Updating <a href="people/'.$_GET['person'].'.txt">people/'.$_GET['person'].'.txt</a> to '.$_GET['position'].'...</p>';
      var_dump(file_put_contents('people/'.$_GET['person'].'.txt',$_GET['position']));
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

  <title>CJTrowbridge - Weasley Clock</title>

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
      <h1>Weasley Clock v1.0</h1>
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
    </div><!--/col-12-->
  </div><!--/row-->
</div><!--/container-->

<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


<script>

function LocatePeople(){

  $('#home').html('');
  $('#away').html('');

  console.log("Checking...");
  $.each([ 'Ben','Zach', 'Jenny', 'CJ' ], function( index, person ) {
    $.get( "people/"+person+".txt?"+$.now(), function(data){
      if(data=='home'){
        var position = 'home';
      }else{
        var position = 'away';
      }
      console.log(person+" is "+position+'('+data+')');
      //$('<div class="person"><a href="#"><!--'+person+'<br>--><img src="/img/'+person.toString().toLowerCase()+'.jpg" alt=""></a></div>').hide().appendTo("#"+position).show();

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

