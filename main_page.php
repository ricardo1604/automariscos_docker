<!doctype html>
<html lang="en">

<style> 
form .loader {
  display: none;
  background-color: #EEE;
  position: absolute;
  top: 0; left: 0;
  bottom: 0; right: 0;
  opacity: 0.8;
}
form .loader img {
  position: absolute;
  top: 50%;
  margin-top: -20px;
  left: 50%;
  margin-left: -20px;
}

</style>
<?php
require_once "cfg/conexion.php";
require_once "crud/crud.php";
require_once "main_menu.php";
require_once "inter_funcion_comanda.php";
require_once "inter_funcion_cocinabar.php";
require_once "inter_funcion_caja.php";
?>


  <head>
  	<title>AUTOMARISCOS</title>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script> -->
    <script src="js/html-docx.js"></script>


    <script src="jquery/jquery-3.6.1.min.js"></script>
    <script src="jquery/sweetalert2.all.min.js"></script>
    <script src="js/popper.js"></script>

    <!-- IMPORTANTE HABILITAR DE NUEVO PARA EVITAR QUE VEAN EL DEVELOPER TOOLS -->
    <!-- <script disable-devtool-auto src='js/disable-devtool/disabledev.js'></script> -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- <script src='dragula-master/dist/dragula.js'></script> -->
    <!-- <script src='dragula-master/dist/dragula.min.css'></script> -->
    <!-- <link rel="stylesheet" href="./style.css"> -->
    <!-- <script type="text/javascript" src="js/virtual-key.js"></script> -->
	<link rel="stylesheet" type="text/css" href="css/virtual-key.css">
  </head>
  <body id="body-bg" onload="checklog()" style="background-color:lightgray;background-image: url('images/bgauto.jpg');">
  <h5 style="color:red;background-color:black;width:400px" id="numCount"></h5>
		  <div id="content" name="content" >
      </div>


    <!-- <div>
  Time remain: <span id="time"><span>
</div> -->

  </body>



    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script> 
    <script type="text/javascript" src="elapseMe.min.js"></script>
     
    <script>

      //crea el formulatio de usuario
    function checklog()
    {
     // get_timeidle();
      // limpieza si se duplica un tab
       window.addEventListener('beforeunload', function (event) {
       sessionStorage.removeItem('__lock');
      });

      if (sessionStorage.getItem('__lock')) {
       sessionStorage.clear();
       console.warn('Found a lock in session storage. The storage was cleared.');
      }

      sessionStorage.setItem('__lock', '1');
       // limpieza si se duplica un tab


     //verificar si alguien esta logeado sino mostrar pantalla de logeo
    //si esta logeado llenar el menu correspondiente dependiendo de su grupo
    var usuario = sessionStorage.getItem('currentloggedin');
   
        if (usuario == null)
        {
          window.location = "index.php";
        }
        else
        {
          drawmenu(sessionStorage.getItem('currentloggedin'));
          //admin no se saldra nunca, los demas 20mins
          if (usuario != 'ADMIN')
          {
          startCountdown();
          }
          
        }
     }


    // no funciona
    //  function get_timeidle()
    //  {
    //    $.ajax({
    //     type: "POST",
    //     async: false,
    //     url: "inter_log.php",
    //     datatype: "JSON",
    //     data: {
    //        estado: 'get_timeidle'
    //     },
    //     beforeSend: function() {

    //     },
    //     success: function(r) {
    //       console.log(r);
    //       var data = jQuery.parseJSON(r);
    //       document.getElementById('tiempolog').value = data[0];
    //     }
       
        
    //   });
       
    //  }

    //dibuja el menu con un usuario autenticado
    function drawmenu(usuario)
    {
     $.ajax({
        type: "POST",
        url: "inter_log.php",
        datatype: "html",
        data: {
           estado: 'opcionesusuario',
           usuario: usuario
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#content').html('');
          $('#content').html(r);
          colorfondousuario(usuario);

          // DETERMINAR SI SOLO HAY UNA OPCION COMO MESERO, COCINA O BAR, SI ES ASI DAR CLICK INMEDIATAMENTE
          var buttons = document.querySelectorAll('#opciones_menu button')

          if (buttons.length == 2) // solo 1 opcion y el boton de salida por eso 2
          {
            buttons[0].click();
          }

        }

      });
     
    }

    function colorfondousuario(usuario)
    {
      $.ajax({
        type: "POST",
        url: "inter_log.php",
        datatype: "html",
        data: {
           estado: 'fondousuario',
           usuario: usuario
        },
        beforeSend: function() {

        },
        success: function(r) {
          themecolor = r.trim();
        }

      });

    }

    //limpia la sesion del usuario actual y se sale
    function salir()
    {
       Swal.fire({
      icon: 'info',
      title: 'Salir?',
      text: 'Seguro que desea salir?',
      showCancelButton: true,
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
          sessionStorage.clear();
          location.reload();
      }
      });
    }


 // LOGICA DE INACTIVIDAD AQUI
  let warningTimeout = 600000; //10 mins
  let warningTimerID;
  let counterDisplay = document.getElementById('numCount');
  var tempingres = [];
  var totalingres = [];
  var totalingrestemp = [];

  var tempprods = [];
  var totalprods = [];
  var totalprodstemp = [];
  
  var themecolor = '';
  var tablesizes = '';

  var arregloasignados = [];
  var arregloproductos = [];
  var innerprods = '';

  //global de ingredientes
  var idactualexist = '';

  //comandas
  var cuentas_comanda = [];
  var cuentas_comandatmp = [];
  //listado comanda
  var listado_comanda = [];
  var listado_comandaori = [];
  var tlistado_comanda = [];
  var listado_comandatmp = [];
  var tlistado_comandatmp = [];
  var listado_comandatmp2 = [];
  //var rlistado_comanda = [];
  var listado_comandaextras = [];
  var tlistado_comandaextras = [];
  
  var cuentaactual ='Principal';
  var cuentaactualtmp ='Principal';

  //usuario comanda
  usuario_comanda = '';
  usuario_comandatmp = '';
  var total_prods = 0;
 //jalar el color de tema de algun lado por user
//  themecolor = 'cyan';
  tablesizes = '16';
  var tiempo = 0;
  var tref = 0;
  var tiemporun;
  var tiemporunconsole;
  var tbarrun;

  //union mesas
  var mesas_unidas = [];
  var dui_comanda = '';

  var cover = '';
  var consumo = '';

  // PARA BAR Y COCINA
  usuario_bar = '';

  var imprimir_var = '';

  var precuenta_printh = '';

  var total_acumsubs = 0;

  
  function startTimer() {
    // window.setTimeout returns an ID that can be used to start and stop the timer
    warningTimerID = window.setTimeout(idleLogout, warningTimeout);
    //animate(counterDisplay, 600, 0, warningTimeout);
    animate(counterDisplay, 600, 0, warningTimeout);
  }
    //function for resetting the timer
  function resetTimer() {
    window.clearTimeout(warningTimerID);
    startTimer();
  }

  // Logout the user.
  function idleLogout() {
          sessionStorage.clear();
          location.reload();
          return false;
  }

  function startCountdown() {
    document.addEventListener("mousemove", resetTimer);
    document.addEventListener("mousedown", resetTimer);
    document.addEventListener("keypress", resetTimer);
    document.addEventListener("touchmove", resetTimer);
    document.addEventListener("onscroll", resetTimer);
    document.addEventListener("wheel", resetTimer);
    startTimer();
  }
   //the animating function
      function animate(obj, initVal, lastVal, duration) {

        let startTime = null;

        //get the current timestamp and assign it to the currentTime variable

        let currentTime = Date.now();

        //pass the current timestamp to the step function

        const step = (currentTime ) => {

        //if the start time is null, assign the current time to startTime

            if (!startTime) {
            startTime = currentTime ;
            }

        //calculate the value to be used in calculating the number to be displayed

            const progress = Math.min((currentTime  - startTime) / duration, 1);

        //calculate what is to be displayed using the value gotten above

            displayValue = Math.floor(progress * (lastVal - initVal) + initVal);
     
            //console.log(displayValue);

            if (displayValue < 30)
            {
              obj.innerHTML = 'Se Desconectara por inactividad en ... '+ displayValue;
            }
            else
            {
             obj.innerHTML = '';
             // FOR TEST ONLY
            // obj.innerHTML = 'Se Desconectara por inactividad en ... '+ displayValue;
            }
            

        //checking to make sure the counter does not exceed the last value(lastVal)

            if (progress < 1) {
                window.requestAnimationFrame(step);
            }else{
                window.cancelAnimationFrame(window.requestAnimationFrame(step));
            }
        };

        //start animating
        window.requestAnimationFrame(step);
    }

    function agregar_subingrediente(id)
    {
      if (document.getElementById('cingre').value != '')
      {
        $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           idparent: document.getElementById('cingre').value,
           idchild: id,
           estado: 'agregar_subingrediente',
           usuario: usuario
        },
        beforeSend: function() {

        },
        success: function(r) {
          seleccionar_ingrediente(document.getElementById('cingre').value);
        }

      });

      }
    }

    function quitar_subingrediente(id)
    {
        if (document.getElementById('cingre').value != '')
      {
        $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           idparent: document.getElementById('cingre').value,
           idchild: id,
           estado: 'quitar_subingrediente',
           usuario: usuario
        },
        beforeSend: function() {

        },
        success: function(r) {
          seleccionar_ingrediente(document.getElementById('cingre').value);
        }

      });

      }
    }
    </script>




</html>