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
      <div class="col-md-10">
        <h1>Guerreros<h4>(Selecciona un Guerrero)</h4></h1>
      </div>
      <div class="col-md-2" style="margin-top:10px">
        <button id="iniciarBatalla" class="btn btn-primary">Batalla</button>
      </div>
    </div>
    <div class="row">
    <!-- Se recibe la variable $warriors con todos los guerreros de la base de datos para que el usuario pueda seleccionar uno y pelear -->
      @if(isset($warriors))
        @foreach($warriors as $warrior)
          <!-- <div class="col-md-2"> -->
          <div data-id="{{$warrior->id}}" class="card col-md-3">
            <img  class="card-img-top imgWarrior" src="{{$warrior->img}}" alt="Card image cap">
            <div class="card-body">
              <p style="text-align: center;" class="card-text"><strong>{{$warrior->name}}</strong></p>
            </div>
          </div>
          <!-- </div> -->
        @endforeach
      @endif
      <div class="col-md-6">
      </div>
    </div>
  </div>
</body>

<!-- Modal para pintar a los peleadores que van a pelear -->
  <div class="modal fade" id="modalBattles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">Batalla</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <!-- Aquí de agrega a los peleadores del resultado de la petición ajax al servidor -->
          </div>
        </div>
        <div class="modal-footer">
          <button id="cancelar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button id="pelear" type="button" class="btn btn-primary">Pelear</button>
        </div>
      </div>
    </div>
  </div>
</html>
<script>
var w1 = 0;
var w2 = 0;
var skill_one = 0;
var skill_two = 0;
var speed_one = 0;
var speed_two = 0;
var strength_one = 0;
var strength_two = 0;
var idWarrior = 0;  // Variable para obtener el Guerrero que seleccionó el usuario
var warriors = '';
var totalWarriorOne = 0;
var totalWarriorTwo = 0;
  /** Función para obtener el id del guerrero del usuario */
  $('.card').on('click', function() {
    idWarrior = $(this).data('id')
  })
var url_batalla = "{{ route('start.battle') }}"; // Variable para almacenar la 'URL' para enviar por Ajax
  /** Función para iniciar la batalla, con el guerrero del usuario contra un guerrero proporcionado por el sistema */
  $('#iniciarBatalla').click((e)=> {
    if (idWarrior == 0) {
      alert("Selecciona un Guerrero")
      return false
    }
    /** Obtención del token de seguridad de laravel para peticiones por AJAX */
    $.ajaxSetup({
      headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}/*token del formulario*/
    });
    /** Petición AJAX por POST la respuesta se obtiene en formato json en la variable DATA*/
    $.ajax({
      url: url_batalla,
      type: "POST",
      data: {
        id : idWarrior,
      },
      dataType: 'json',
      success: function (response) {
        if (response.success == true) {
          $('#modalBattles').modal('show')
          warriors = response.data
          w1 = (warriors[0].speed * warriors[0].strength) * warriors[0].skills  // Se obtiene el puntaje de cada peleador
          w2 = (warriors[1].speed * warriors[1].strength) * warriors[1].skills  // w1 = guerrero seleccionado por el usuario; w2 = guerrero de la pc

          skill_one = warriors[0].skills
          skill_two = warriors[1].skills

          speed_one = warriors[0].speed
          speed_two = warriors[1].speed

          strength_one = warriors[0].strength
          strength_two = warriors[1].strength
          $('#modalBattles .row').html(`
            <div class="col-md-5 warriors_one">
              <img data-idwarrior="${warriors[0].id}" id="warriorImg" class="imgWarrior" src="${warriors[0].img}" style="width:60%" alt="">
              <h4>${warriors[0].name}</h4>
            </div>
            <div class="col-md-2">VS</div>
            <div class="col-md-5 warriors_two">
              <img data-idwarrior="${warriors[1].id}" id="warriorImg" class="imgWarrior" src="${warriors[1].img}" style="width:60%" alt="">
            <h4>${warriors[1].name}</h4>
            </div>
          `)  // Se obtiene el id, nombre e imagen de los guerreros y se pintan en el modal
        }
      },
      error: function (response) {
        alert("Hubo un error en el servidor")
      }
    })
  })
  /** Función que muestra la imagen que simula la pelea */
  $('#pelear').click((e)=>{
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
        Punto para : <strong>${warriors[0].name}</strong>
      `)
      totalWarriorOne += 1
    }else if (speed_one == speed_two) {
      $('#modalBattles .row').html(`
        Empate
      `)
    }else{
      $('#modalBattles .row').html(`
        Punto para : <strong>${warriors[1].name}</strong>
      `)
      totalWarriorTwo += 1
    }
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
        Punto para : <strong>${warriors[0].name}</strong>
        `)
      totalWarriorOne += 1
    }else if (skill_one == skill_two) {
      $('#modalBattles .row').html(`
        Empate
        `)
    }else{
      $('#modalBattles .row').html(`
        Punto para : <strong>${warriors[1].name}</strong>
      `)
      totalWarriorTwo += 1
    }
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
        Punto para : <strong>${warriors[0].name}</strong>
      `)
      totalWarriorOne += 1
    }else if (strength_one == strength_two) {
      $('#modalBattles .row').html(`
        Empate
        `)
    }else{
      $('#modalBattles .row').html(`
        Punto para : <strong>${warriors[1].name}</strong>
      `)
      totalWarriorTwo += 1
    }
    console.log(totalWarriorOne);
    console.log(totalWarriorTwo);
    setTimeout(winnerBatalla,3000)
  }
  function winnerBatalla() {
    $('.modal-footer').html(`
      <button id="cancelar" type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
    `)
    if (totalWarriorOne > totalWarriorTwo) {
      $('#modalBattles .row').html(`
        <div class="col-md-5 warriors_one imgWinner">
          <h2>Ganador</h2>
          <img id="warriorImg" class="imgWinner" src="${warriors[0].img}" style="width:60%" alt="">
          <h4><strong>${warriors[0].name}</strong></h4>
          <h6>Habilidades: ${warriors[0].skills}</h6>
          <h6>Velocidad: ${warriors[0].speed}</h6>
          <h6>Fuerza: ${warriors[0].strength}</h6>
        </div>
        <div class="col-md-2">VS</div>
        <div class="col-md-5 warriors_two">
          <img id="warriorImg" src="${warriors[1].img}" style="width:60%" alt="">
          <h4><strong>${warriors[1].name}</strong></h4>
          <h6>Habilidades: ${warriors[1].skills}</h6>
          <h6>Velocidad: ${warriors[1].speed}</h6>
          <h6>Fuerza: ${warriors[1].strength}</h6>
        </div>
      `)
      totalWarriorOne = 0
      totalWarriorTwo = 0
    } else if(totalWarriorOne == totalWarriorTwo){
      $('#modalBattles .row').html(`
        <div class="col-md-5 warriors_one">
          <img id="warriorImg" src="${warriors[0].img}" style="width:60%" alt="">
          <h4><strong>${warriors[0].name}</strong></h4>
          <h6>Habilidades: ${warriors[0].skills}</h6>
          <h6>Velocidad: ${warriors[0].speed}</h6>
          <h6>Fuerza: ${warriors[0].strength}</h6>
        </div>
        <div class="col-md-2">VS<h5>Empate</h5></div>
        <div class="col-md-5 warriors_two">
          <img id="imgWinner" src="${warriors[1].img}" style="width:60%" alt="">
          <h4><strong>${warriors[1].name}</strong></h4>
          <h6>Habilidades: ${warriors[1].skills}</h6>
          <h6>Velocidad: ${warriors[1].speed}</h6>
          <h6>Fuerza: ${warriors[1].strength}</h6>
        </div>
      `)
      totalWarriorOne = 0
      totalWarriorTwo = 0
    }else{
      $('#modalBattles .row').html(`
        <div class="col-md-5 warriors_one">
          <img id="warriorImg" src="${warriors[0].img}" style="width:60%" alt="">
          <h4><strong>${warriors[0].name}</strong></h4>
          <h6>Habilidades: ${warriors[0].skills}</h6>
          <h6>Velocidad: ${warriors[0].speed}</h6>
          <h6>Fuerza: ${warriors[0].strength}</h6>
        </div>
        <div class="col-md-2">VS</div>
        <div class="col-md-5 warriors_two imgWinner">
          <h2>Ganador</h2>
          <img id="imgWinner" class="imgWinner" src="${warriors[1].img}" style="width:60%" alt="">
          <h4><strong>${warriors[1].name}</strong></h4>
          <h6>Habilidades: ${warriors[1].skills}</h6>
          <h6>Velocidad: ${warriors[1].speed}</h6>
          <h6>Fuerza: ${warriors[1].strength}</h6>
        </div>
      `)
      totalWarriorOne = 0
      totalWarriorTwo = 0
    }
  }
  function fightFunc() {
    $('#modalBattles .row').html(`
      <img src="http://25.media.tumblr.com/tumblr_lkemgaph2o1qdrazeo1_500.gif" style="width:100%" alt="">
    `)
  }
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