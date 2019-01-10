<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="_token" content="{{ csrf_token() }}"/> <!-- Obtención del token de seguridad -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Battles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 align="center">Guerreros<h4 align="center">(Selecciona un Guerrero)</h4></h1>
      </div>
    </div>
    <div class="row">
    <!-- Se recibe la variable $warriors con todos los guerreros de la base de datos para que el usuario pueda seleccionar uno y pelear -->
      <div class="col-md-3"></div>
      @if(isset($warriors))
        @foreach($warriors as $warrior)
          <!-- <div class="col-md-2"> -->
          <div data-id="{{$warrior->id}}" data-speed="{{$warrior->speed}}" data-skills="{{$warrior->skills}}" data-strength="{{$warrior->strength}}" data-name="{{$warrior->name}}" class="card col-md-3" style="margin:10px">
            <img  class="card-img-top imgWarrior pelea" src="{{$warrior->img}}" alt="Card image cap">
            <div class="card-body">
              <p style="text-align: center;" class="card-text"><strong>{{$warrior->name}}</strong></p>
            </div>
          </div>
          <!-- </div> -->
        @endforeach
      @endif
      <div class="col-md-3 alertas"></div>
    </div>
  </div>
</body>

<!-- Modal para pintar a los peleadores que van a pelear -->
  <div class="modal fade" id="modalBattles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">Batalla</h4>
          <button type="button" class="close cancelar" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <!-- Aquí de agrega a los peleadores del resultado de la petición ajax al servidor -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cancelar" data-dismiss="modal">Cancelar</button>
          <button id="pelear" type="submit" class="btn btn-primary">Pelear</button>
        </div>
      </div>
    </div>
  </div>
</html>
<script>
var warriors = @json($warriors);
var idUser = 0;
var w1 = 0;
var w2 = 0;
var skill_one = 0;
var skill_two = 0;
var speed_one = 0;
var speed_two = 0;
var strength_one = 0;
var strength_two = 0;
var totalWarriorOne = 0;
var totalWarriorTwo = 0;
var name_one = '';
var name_two = '';
  $('.pelea').on('click', function () {
    idUser = $(this).parents('div').data('id');
    $('#modalBattles').modal('show')
    $.each(warriors, function (key, warrior) {
      if (warrior.id == idUser) {
        name_one = warrior.name
        skill_one = warrior.skills;
        speed_one = warrior.speed;
        strength_one = warrior.strength;
        $('#modalBattles .row').append(`
          <div class="col-md-5 warriors_one">
            <h5>Has seleccionado a:</h5>
            <img data-idwarrior="${warrior.id}" id="warriorImg" class="imgWarrior imgWinner" src="${warrior.img}" style="width:60%" alt="">
            <h4>${warrior.name}</h4>
          </div>
        `)
      }else{
        $('#modalBattles .row').append(`
          <div class="col-md-5 warriors_one">
            <img data-idwarrior="${warrior.id}" id="warriorImg" class="imgWarrior" src="${warrior.img}" style="width:60%" alt="">
            <h4>${warrior.name}</h4>
          </div>
        `)
        name_two = warrior.name
        skill_two = warrior.skills;
        speed_two = warrior.speed;
        strength_two = warrior.strength;
      }
    })
  })

  /** Función que muestra la imagen que simula la pelea */
  $('#pelear').on('click', function() {
    $('.modal-footer').html('')
    $('#modalBattles .row').html(`
      <img src="http://2.bp.blogspot.com/-C3JqZ2Hxutg/UT_z4tF9U6I/AAAAAAAACb4/FECRzzqdORQ/s1600/round+1+fight2.jpg" style="width:100%" alt="">
    `)
    round_one()
    // setInterval(fightFunc, 5000); // Se establece un tiempo para ejecutar la funcion que define al ganador
  })
  function round_one() {
    setTimeout(fightFunc, 1000)
    setTimeout(calcRoundOne, 2000)
  }
  function calcRoundOne() {
    if (speed_one > speed_two) {
      $('#modalBattles .row').html(`
        Punto para : <strong>${name_one}</strong>
      `)
      totalWarriorOne += 1
    }else if (speed_one == speed_two) {
      $('#modalBattles .row').html(`
        Empate
      `)
    }else{
      $('#modalBattles .row').html(`
        Punto para : <strong>${name_two}</strong>
      `)
      totalWarriorTwo += 1
    }
    //console.log("velocidad",speed_one > speed_two,speed_one == speed_two,speed_one < speed_two, totalWarriorOne, totalWarriorTwo)
    round_two()
  }
  function round_two() {
    setTimeout(imgRoundTwo, 4000)
    setTimeout(fightFunc, 6000)
    setTimeout(calcRoundTwo, 9000)
  }
  function imgRoundTwo() {
    $('#modalBattles .row').html(`
      <img src="https://i0.wp.com/prokartsss.co.za/wp-content/uploads/imagesV6L5LGFZ.jpg?fit=319%2C158&ssl=1" style="width:100%" alt="">
    `)
  }
  function calcRoundTwo() {
    if (skill_one > skill_two) {
      $('#modalBattles .row').html(`
        Punto para : <strong>${name_one}</strong>
        `)
      totalWarriorOne += 1
    }else if (skill_one == skill_two) {
      $('#modalBattles .row').html(`
        Empate
        `)
    }else{
      $('#modalBattles .row').html(`
        Punto para : <strong>${name_two}</strong>
      `)
      totalWarriorTwo += 1
    }
    console.log("habilidades",skill_one > skill_two,skill_one == skill_two,skill_one < skill_two, totalWarriorOne, totalWarriorTwo)
    round_three()
  }
  function round_three() {
    setTimeout(imgRoundThree, 4000)
    setTimeout(fightFunc, 6000)
    setTimeout(calcRoundThree, 9000)
  }
  function imgRoundThree() {
    $('#modalBattles .row').html(`
      <img src="https://i2.wp.com/prokartsss.co.za/wp-content/uploads/Round-3.png?fit=225%2C225&ssl=1" style="width:100%" alt="">
    `)
  }
  function calcRoundThree() {
    if (strength_one > strength_two) {
      $('#modalBattles .row').html(`
        Punto para : <strong>${name_one}</strong>
      `)
      totalWarriorOne += 1
    }else if (strength_one == strength_two) {
      $('#modalBattles .row').html(`
        Empate
        `)
    }else{
      $('#modalBattles .row').html(`
        Punto para : <strong>${name_two}</strong>
      `)
      totalWarriorTwo += 1
    }
    // console.log("fuerza",strength_one > strength_two,strength_one == strength_two,strength_one < strength_two, totalWarriorOne, totalWarriorTwo)
    // console.log("puntos warrior uno", totalWarriorOne);
    // console.log("puntos warrior dos", totalWarriorTwo);
    setTimeout(winnerBatalla,3000)
  }
  function winnerBatalla() {
    $('.modal-footer').html(`
      <button type="button" class="btn btn-primary cancelar" data-dismiss="modal">Ok</button>
    `)
    if (totalWarriorOne > totalWarriorTwo) {
      $('#modalBattles .row').html(`
        <div class="container">
          <div class="row"> 
            <div class="alert alert-success" role="alert" align="center">
              Ganaste
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 warriors_one fin" data-fin="${warriors[0].id}">
              <img id="warriorImg" src="${warriors[0].img}" style="width:60%" alt="">
              <h4><strong>${warriors[0].name}</strong></h4>
              <h6>Habilidades: ${warriors[0].skills}</h6>
              <h6>Velocidad: ${warriors[0].speed}</h6>
              <h6>Fuerza: ${warriors[0].strength}</h6>
            </div>
            <div class="col-md-2">VS</div>
            <div class="col-md-5 warriors_two fin" data-fin="${warriors[1].id}">
              <img id="warriorImg" src="${warriors[1].img}" style="width:60%" alt="">
              <h4><strong>${warriors[1].name}</strong></h4>
              <h6>Habilidades: ${warriors[1].skills}</h6>
              <h6>Velocidad: ${warriors[1].speed}</h6>
              <h6>Fuerza: ${warriors[1].strength}</h6>
            </div>
          </div>
        </div>
      `)
      $("[data-fin = '" + idUser +"']").addClass('imgWinner')
      totalWarriorOne = 0
      totalWarriorTwo = 0
    } else if(totalWarriorOne == totalWarriorTwo){
      $('#modalBattles .row').html(`
        <div class="container">
          <div class="row">
            <div class="alert alert-dark" role="alert" align="center">
              Empate
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 warriors_one fin" data-fin="${warriors[0].id}">
              <img id="warriorImg" src="${warriors[0].img}" style="width:60%" alt="">
              <h4><strong>${warriors[0].name}</strong></h4>
              <h6>Habilidades: ${warriors[0].skills}</h6>
              <h6>Velocidad: ${warriors[0].speed}</h6>
              <h6>Fuerza: ${warriors[0].strength}</h6>
            </div>
            <div class="col-md-2">VS<h5>Empate</h5></div>
            <div class="col-md-5 warriors_two fin" data-fin="${warriors[1].id}">
              <img id="imgWinner" src="${warriors[1].img}" style="width:60%" alt="">
              <h4><strong>${warriors[1].name}</strong></h4>
              <h6>Habilidades: ${warriors[1].skills}</h6>
              <h6>Velocidad: ${warriors[1].speed}</h6>
              <h6>Fuerza: ${warriors[1].strength}</h6>
            </div>
          </div>
        </div>
      `)
      $("[data-fin = '" + idUser +"']").addClass('imgWinner')
      totalWarriorOne = 0
      totalWarriorTwo = 0
    }else{
      $('#modalBattles .row').html(`
        <div class="container">
          <div class="row">
            <div class="alert alert-danger" role="alert" align="center">
              Perdiste
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 warriors_one">
              <img id="warriorImg" src="${warriors[0].img}" style="width:60%" alt="">
              <h4><strong>${warriors[0].name}</strong></h4>
              <h6>Habilidades: ${warriors[0].skills}</h6>
              <h6>Velocidad: ${warriors[0].speed}</h6>
              <h6>Fuerza: ${warriors[0].strength}</h6>
            </div>
            <div class="col-md-2">VS</div>
            <div class="col-md-5 warriors_two imgWinner">
              <img id="imgWinner" src="${warriors[1].img}" style="width:60%" alt="">
              <h4><strong>${warriors[1].name}</strong></h4>
              <h6>Habilidades: ${warriors[1].skills}</h6>
              <h6>Velocidad: ${warriors[1].speed}</h6>
              <h6>Fuerza: ${warriors[1].strength}</h6>
            </div>
          </div>
        </div>
      `)
      $("[data-fin = '" + idUser +"']").addClass('imgWinner')
      totalWarriorOne = 0
      totalWarriorTwo = 0
    }
  }
  function fightFunc() {
    $('#modalBattles .row').html(`
      <img src="http://25.media.tumblr.com/tumblr_lkemgaph2o1qdrazeo1_500.gif" style="width:100%" alt="">
    `)
  }
  $('.cancelar').on('click', function () {
    location.reload(true)
  })
  $('#modalBattles').on('hidden.bs.modal', function () {
    location.reload(true)
  })
</script>

<style>
  /* Estilo que pone sombreada la imagen al pasar el mouse sobre ella*/
  .imgWarrior:hover{
    box-shadow: 0px 10px 1px #ddd, 0 10px 20px #ccc;
  }
  .imgWinner{
    box-shadow: 0px 10px 1px #ddd, 0 10px 20px #ccc;
  }
</style>