<script>
 

// obtiene los privilegios del rol
function configs()
{
    var user = sessionStorage.getItem('currentloggedin');
    $.ajax({
        type: "POST",
        url: "inter_configs.php",
        datatype: "html",
        data: {
          usuario: user,
           estado: 'tab_principal_configs'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#content').html('');
          $('#content').html(r);
        }
      });
}

function comanda()
{
    var user = sessionStorage.getItem('currentloggedin');
    $.ajax({
        type: "POST",
        url: "inter_comanda.php",
        datatype: "html",
        data: {
          usuario: user,
           estado: 'tab_principal_comanda'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#content').html('');
          $('#content').html(r);          

          document.getElementById('body-bg').style.backgroundImage = '';

          //var modal = document.getElementById("myModalcomanda");

          // setear el tiempo a refrescar desde globales, se guarda en inter_comanda cuando se construye
          tref = document.getElementById('tmesas').innerText*60000; 
          tmesasrun = setInterval( function() { actualizar_colores_refresh(); refrescar_vistadetallada();}, tref);
        
        }
      });

}
//2X
function actualizar_colores_refresh()
{
//redraw practicamente de las zonas y mesas

if (document.getElementById("myModalcomanda").style.display == 'block') // solo si se muestra que actualize si no nada
{
var usuario = sessionStorage.getItem('currentloggedin');
 $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          estado: 'redraw_map_areas'
       },
       beforeSend: function() {
       },
       success: function(r) {
       var data = jQuery.parseJSON(r);
        $('#area1').html('');
        $('#area2').html('');
        $('#area3').html('');
        $('#area4').html('');
        $('#area1').html(data[0]);
        $('#area2').html(data[1]);
        $('#area3').html(data[2]);
        $('#area4').html(data[3]);
        //document.getElementById("myModalcomanda").style.display = 'block' ; no regresar a la pantalla de mesas
        if (sessionStorage.getItem('currentloggedin') == 'ADMIN')
        {
        deshabilitar_zonas_usuario('ADMIN');
        }
        else
        {
        deshabilitar_zonas_usuario(document.getElementById('usermesero').value);
        }
     }
     });
 }
}
//2X
function actualizar_colores_refreshcaja()
{
//redraw practicamente de las zonas y mesas

if (document.getElementById("myModalcomanda").style.display == 'block') // solo si se muestra que actualize si no nada
{
var usuario = sessionStorage.getItem('currentloggedin');
 $.ajax({
       type: "POST",
       url: "inter_caja.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          estado: 'redraw_map_areas'
       },
       beforeSend: function() {
       },
       success: function(r) {
       var data = jQuery.parseJSON(r);
        $('#area1').html('');
        $('#area2').html('');
        $('#area3').html('');
        $('#area4').html('');
        $('#area1').html(data[0]);
        $('#area2').html(data[1]);
        $('#area3').html(data[2]);
        $('#area4').html(data[3]);
        //document.getElementById("myModalcomanda").style.display = 'block' ; no regresar a la pantalla de mesas
        if (sessionStorage.getItem('currentloggedin') == 'ADMIN')
        {
        deshabilitar_zonas_usuario('ADMIN');
        }
        else
        {
        deshabilitar_zonas_usuario(document.getElementById('usermesero').value);
        }
     }
     });
 }
}
//2X
function deshabilitar_zonas_usuario(usuario_comanda)
{
   // obtener mesas que puede ver el usuario
   var usuario = sessionStorage.getItem('currentloggedin');
   $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          usuarioc: usuario_comanda,
          estado: 'get_mesasxzona_dusuario'
       },
       beforeSend: function() {
       },
       success: function(r) {
       var data = jQuery.parseJSON(r);
       //ocultar estas zonas en realidad mesas
       data.forEach(element => {
           document.getElementById("mesa_" + element).removeAttribute('onclick'); 
           document.getElementById("mesa_" + element).src = 'images/mesaf.png';
           document.getElementById("smesa_" + element).removeAttribute('onclick'); 
       });
       }
     });
}
//2X
function refrescar_vistadetallada()
 {
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          estado: 'refresh_vistadetallada'
       },
       beforeSend: function() {
       },
       success: function(r) {
         var data = JSON.parse(r);
         $('#vdetallada').html('');
         $('#vdetalladasum').html('');
         $('#vdetallada').html(data[0]);
         $('#vdetalladasum').html(data[1]);
       }
       });
 }

 function bar()
{
  var user = sessionStorage.getItem('currentloggedin');
    $.ajax({
        type: "POST",
        url: "inter_cocinabar.php",
        datatype: "html",
        data: {
          usuario: user,
           estado: 'tab_principal_bar'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#content').html('');
          $('#content').html(r);          

          //document.getElementById('body-bg').style.backgroundImage = '';

          //var modal = document.getElementById("myModalcomanda");

          // setear el tiempo a refrescar desde globales, se guarda en inter_comanda cuando se construye
          tref = document.getElementById('tact').innerText*60000; 
          tbarrun = setInterval( function() { actualizar_listadobar_auto();}, tref);
        
        }
      });
}

function actualizar_listadobar_auto()
 {
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       async: false,
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          estado: 'actualizar_bar'
       },
       beforeSend: function() {
       },
       success: function(r) {
        $('#ordenes_pendientes').html('');
        $('#ordenes_pendientes').html(r);
       }
     });
     actualizar_listadobar_auto_totales();
 }

 function actualizar_listadobar_auto_totales()
 {
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          estado: 'get_bar_autototales'
       },
       beforeSend: function() {
       },
       success: function(r) {
        document.getElementById('totalordenes').textContent = "TOTAL DE ORDENES : " + r;
        var currentDateString = fechahoraactual();
        document.getElementById('totalactualizacion').textContent = "ULTIMA ACTUALIZACION : " + currentDateString;
       }
     });
 }

 function cocina()
{
  var user = sessionStorage.getItem('currentloggedin');
    $.ajax({
        type: "POST",
        url: "inter_cocinabar.php",
        datatype: "html",
        data: {
          usuario: user,
           estado: 'tab_principal_cocina'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#content').html('');
          $('#content').html(r);          

          //document.getElementById('body-bg').style.backgroundImage = '';

          //var modal = document.getElementById("myModalcomanda");

          // setear el tiempo a refrescar desde globales, se guarda en inter_comanda cuando se construye
         // tref = document.getElementById('tact').innerText*60000; 
          //tbarrun = setInterval( function() { actualizar_listadococina_auto();}, tref);
        
        }
      });
}

function caja()
{
  var user = sessionStorage.getItem('currentloggedin');
    $.ajax({
        type: "POST",
        url: "inter_caja.php",
        datatype: "html",
        data: {
           usuario: user,
           estado: 'tab_principal_caja'
        },
        beforeSend: function() {

        },
        success: function(r) {
          $('#content').html('');
          $('#content').html(r);          

          document.getElementById('body-bg').style.backgroundImage = '';

          //var modal = document.getElementById("myModalcomanda");

          // setear el tiempo a refrescar desde globales, se guarda en inter_comanda cuando se construye
          tref = document.getElementById('tmesas').innerText*60000; 
          tmesasrun = setInterval( function() { actualizar_colores_refreshcaja();}, tref);
        
        }
      });
}

function actualizar_listadococina_auto()
 {
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       async: false,
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          estado: 'actualizar_cocina'
       },
       beforeSend: function() {
       },
       success: function(r) {
        $('#ordenes_pendientes').html('');
        $('#ordenes_pendientes').html(r);
       }
     });
     actualizar_listadococina_auto_totales();
 }

 function actualizar_listadococina_auto_totales()
 {
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          estado: 'get_cocina_autototales'
       },
       beforeSend: function() {
       },
       success: function(r) {
        document.getElementById('totalordenes').textContent = "TOTAL DE ORDENES : " + r;
        var currentDateString = fechahoraactual();
        document.getElementById('totalactualizacion').textContent = "ULTIMA ACTUALIZACION : " + currentDateString;
       }
     });
 }


 function fechahoraactual()
 {
  var currentDate = new Date();

  var day = currentDate.getDate();
  var month = currentDate.getMonth() + 1; // Months are zero-based, so we add 1
  var year = currentDate.getFullYear();

  var hours = currentDate.getHours();
  var minutes = currentDate.getMinutes();
  var seconds = currentDate.getSeconds();

  // Add leading zeros if necessary
  if (day < 10) {
    day = '0' + day;
  }

  if (month < 10) {
    month = '0' + month;
  }

  if (hours < 10) {
    hours = '0' + hours;
  }

  if (minutes < 10) {
    minutes = '0' + minutes;
  }

  if (seconds < 10) {
    seconds = '0' + seconds;
  }

  var meridiem = hours >= 12 ? 'PM' : 'AM';

  if (hours > 12) {
    hours %= 12;
  }

  return currentDateString = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds + ' ' + meridiem;

 }
</script>