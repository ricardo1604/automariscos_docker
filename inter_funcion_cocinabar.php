<script>
// todo lo referente a cocina y bar
function mostrar_modalbar()
{
    document.getElementById('myModalusuariobar').style.display = '';
}

function seleccionar_usuariobar(e) 
{
  if(e.keyCode === 13)
  {
     logear_bar();
  }
}

function esconder_logusuariobar()
{
  document.getElementById('myModalusuariobar').style.display = 'none';
}

function logear_bar()
{
   // validar si es buena la contrasena del mesero
   // luego asignarusuario actual
      $.ajax({
        type: "POST",
        url: "inter_log.php",
        datatype: "html",
        data: {
           estado: 'login_comanda',
           usuario: document.getElementById('usermesero').value,
           pass: document.getElementById('usermeseropass').value
        },
        beforeSend: function() {

        },
        success: function(r) {
         if (r==1)
          {
            usuario_bar = document.getElementById('usermesero').value;
            document.getElementById('meseroact').value = usuario_bar;
            esconder_logbar();
            document.getElementById('usermeseropass').value = '';

            document.getElementById('logcom').src = 'images/logout.png';
            if (sessionStorage.getItem('currentloggedin') == 'ADMIN')
            {
             //  deshabilitar_zonas_usuario('ADMIN');
            }
            else
            {
            //   deshabilitar_zonas_usuario(usuario_comanda);
            }
           
          }
          else
          {
            Swal.fire({
                icon: 'info',
                title: 'Incorrecto',
                text: 'Contrasena o Rol incorrecto de Mesero'
              }).then(function() {
              });  
          }
        }

       });

}

function logout_bar()
{
  if (usuario_bar != '')
   {
   Swal.fire({
   icon: 'info',
   title: 'Salir',
   text: 'Esta seguro que quiere desconectar el cocinero actual?',
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
               usuario_bar = '';
               document.getElementById('meseroact').value = usuario_bar;
               document.getElementById('usermesero').value = '';// quitar zonas grises
               document.getElementById('logcom').src = 'images/login.png';         
      }
      });
   }
   else
   {
      mostrar_modalbar();
   }
}

function esconder_logbar()
{
   if (usuario_bar != '')
   {
      document.getElementById('myModalusuariobar').style.display = 'none';
   }
}

function esconder_pedidomesa()
{
   if (usuario_bar != '')
   {
      document.getElementById('myModalpedidomesa').style.display = 'none';
   }
}

function mostrar_composicion(event,id)
{
  event.stopPropagation();
    $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "JSON",
       data: {
          usuario: '',
          id: id,
          estado: 'mostrar_componentes_ingre'
       },
       beforeSend: function() {
       },
       success: function(r) {
       var data = jQuery.parseJSON(r);
       Swal.fire({
                title: 'Ingredientes de : ' + data[1],
                html:  data[0] 
              }).then(function() {
              }); 
       }
     });

}

function desplegar_nota(id)
{
idprod = id.replace("i", "n");
var element = document.getElementById(idprod);
if (element.hasAttribute("hidden")) {
  // Element is currently hidden, so remove the hidden attribute to show it
  element.removeAttribute("hidden");
} else {
  // Element is currently visible, so add the hidden attribute to hide it
  element.setAttribute("hidden", "");
}
}

// function marcar_item(id)
// {
//   if (document.getElementById('meseroact').value == '')
//   {
//     Swal.fire({
//                 icon: 'info',
//                 title: 'No logeado',
//                 text:  'No hay un usuario de Cocina/Barra conectado!' 
//               }).then(function() {
//                 mostrar_modalbar();
//               }); 
//   }
//   else
//   {
//   idprod = id.replace("reg_", "");
  
//   if (document.getElementById("ci_" + idprod).style.backgroundColor != 'lightgreen') //si es verde que no haga nada
//   {
//   if (document.getElementById("ci_" + idprod).style.backgroundColor == 'white')
//   {
//     document.getElementById("ci_" + idprod).style.backgroundColor = 'salmon';
//     accion_item(idprod,'preparacion');
//   }
//   else if (document.getElementById("ci_" + idprod).style.backgroundColor == 'salmon')
//   {
//     document.getElementById("ci_" + idprod).style.backgroundColor = 'lightgreen';
//     accion_item(idprod,'despacho');
//   }
//   }
//   }
// }

function marcar_item(id)
{
  if (document.getElementById('meseroact').value == '')
  {
    Swal.fire({
                icon: 'info',
                title: 'No logeado',
                text:  'No hay un usuario de Cocina/Barra conectado!' 
              }).then(function() {
                mostrar_modalbar();
              }); 

  }
  else
  {
  idreg = id.replace("reg_", "");
  prod = document.querySelector("#" + id);
  idp = prod.dataset.idprod;
  cant = prod.dataset.cantidad;
  orden = prod.dataset.orden;

  if (document.getElementById("ci_" + idreg).style.backgroundColor != 'lightgreen') //si es verde que no haga nada
  {
  if (document.getElementById("ci_" + idreg).style.backgroundColor == 'white')
  {
    document.getElementById("ci_" + idreg).style.backgroundColor = 'salmon';
    accion_item(idreg,'preparacion', idp, cant, orden);
  }
  else if (document.getElementById("ci_" + idreg).style.backgroundColor == 'salmon')
  {
    document.getElementById("ci_" + idreg).style.backgroundColor = 'lightgreen';
    accion_item(idreg,'despacho', idp, cant, orden);
  }
  }
  }
}

function accion_item(registro, estadoitem, idprod, cantidad, orden)
{
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          usuariob: document.getElementById('meseroact').value,
          registro: registro,
          estadoitem: estadoitem,
          idprod: idprod,
          cant: cantidad,
          orden: orden,
          estado: 'accion_item'
       },
       beforeSend: function() {
       },
       success: function(r) {
        console.log(r);
       }
     });
}


function mostrar_pedidomesabar()
{
  if (document.getElementById('meseroact').value == '')
  {
    Swal.fire({
                icon: 'info',
                title: 'No logeado',
                text:  'No hay un usuario de Barra conectado!' 
              }).then(function() {
                mostrar_modalbar();
              }); 
  }
  else
  {
  if (document.getElementById('myModalpedidomesa').style.display == 'none')
  {
    var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          estado: 'adquirir_mesaspedidobar'
       },
       beforeSend: function() {
       },
       success: function(r) {
        document.getElementById('myModalpedidomesa').style.display = '';
        $('#mesaspedido').html('');
        $('#mesaspedidoselec').html('');
        $('#mesaspedido').html(r);
       }
     });
  }
  else
  {
    document.getElementById('myModalpedidomesa').style.display = 'none';
  }
}
}

function mostrar_pedidomesacocina()
{
  if (document.getElementById('meseroact').value == '')
  {
    Swal.fire({
                icon: 'info',
                title: 'No logeado',
                text:  'No hay un usuario de Cocina conectado!' 
              }).then(function() {
                mostrar_modalbar();
              }); 
  }
  else
  {
  if (document.getElementById('myModalpedidomesa').style.display == 'none')
  {
    var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          estado: 'adquirir_mesaspedidococina'
       },
       beforeSend: function() {
       },
       success: function(r) {
        document.getElementById('myModalpedidomesa').style.display = '';
        $('#mesaspedido').html('');
        $('#mesaspedidoselec').html('');
        $('#mesaspedido').html(r);
       }
     });
  }
  else
  {
    document.getElementById('myModalpedidomesa').style.display = 'none';
  }
}
}

function seleccionar_reg_mesabar(mesa,orden)
{
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          mesa: mesa,
          orden: orden,
          estado: 'adquirir_mesaspedido_regsbar'
       },
       beforeSend: function() {
       },
       success: function(r) {
        document.getElementById('myModalpedidomesa').style.display = '';
        $('#mesaspedidoselec').html('');
        if (mesa.toString().includes('LLEVAR'))
        {
         $('#mesaspedidoselec').html('ORDEN PARA LLEVAR : ' + r);
        }
        else
        {
          $('#mesaspedidoselec').html('MESA ACTUAL : ' + mesa + r);
        }
       }
     });
}

function seleccionar_reg_mesacocina(mesa,orden)
{
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       datatype: "html",
       data: {
          usuario: usuario,
          mesa: mesa,
          orden: orden,
          estado: 'adquirir_mesaspedido_regscocina'
       },
       beforeSend: function() {
       },
       success: function(r) {
        document.getElementById('myModalpedidomesa').style.display = '';
        $('#mesaspedidoselec').html('');
        if (mesa.toString().includes('LLEVAR'))
        {
         $('#mesaspedidoselec').html('ORDEN PARA LLEVAR : ' + r);
        }
        else
        {
          $('#mesaspedidoselec').html('MESA ACTUAL : ' + mesa + r);
        }
       }
     });
}

function corregir_regbar(id)
{
  idprod = id.replace("ci2_", "");
  prod = document.querySelector("#" + id);
  idp = prod.dataset.idprod;
  cant = prod.dataset.cantidad;
  orden = prod.dataset.orden;


  if (document.getElementById(id).style.backgroundColor == 'white')
  {
    document.getElementById(id).style.backgroundColor = 'salmon';
    //accion_item(idprod,'preparacion');
    accion_item('','preparacion',idp, cant, orden);
    actualizar_listadobar();
  }
  else if (document.getElementById(id).style.backgroundColor == 'salmon')
  {
    document.getElementById(id).style.backgroundColor = 'lightgreen';
    //accion_item(idprod,'despacho');
    accion_item('','despacho',idp, cant, orden);
    actualizar_listadobar();
  }
  else if (document.getElementById(id).style.backgroundColor == 'lightgreen')
  {
    document.getElementById(id).style.backgroundColor = 'white';
   // accion_item(idprod,'abierta');
    accion_item('','abierta',idp, cant, orden);
    actualizar_listadobar();
  }
  actualizar_listadobar_auto_totales();  
}

function corregir_regcocina(id)
{
  idprod = id.replace("ci2_", "");
  prod = document.querySelector("#" + id);
  idp = prod.dataset.idprod;
  cant = prod.dataset.cantidad;
  orden = prod.dataset.orden;

  if (document.getElementById(id).style.backgroundColor == 'white')
  {
    document.getElementById(id).style.backgroundColor = 'salmon';
  //  accion_item(idprod,'preparacion');
  accion_item('','preparacion',idp, cant, orden);
    actualizar_listadococina();
  }
  else if (document.getElementById(id).style.backgroundColor == 'salmon')
  {
    document.getElementById(id).style.backgroundColor = 'lightgreen';
  //  accion_item(idprod,'despacho');
    accion_item('','despacho',idp, cant, orden);
    actualizar_listadococina();
  }
  else if (document.getElementById(id).style.backgroundColor == 'lightgreen')
  {
    document.getElementById(id).style.backgroundColor = 'white';
 //   accion_item(idprod,'abierta');
    accion_item('','abierta',idp, cant, orden);
    actualizar_listadococina();
  }
  actualizar_listadococina_auto_totales();
}

function actualizar_listadobar()
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
}

function actualizar_listadococina()
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

 function mostrar_ordenesdespachadas(id)
 {
  idf = id.replace("filtrar_", "");
  // Get the element with the ID "ticketBody1"
  const ticketBody = document.getElementById(idf);

  // Find all elements with the class "item-row" inside "ticketBody1"
  const itemRows = ticketBody.querySelectorAll('.item-row');

  let hiddenCount = 0;

  itemRows.forEach((itemRow) => {
    if (itemRow.hasAttribute('hidden')) {
      itemRow.removeAttribute('hidden');
      hiddenCount++;
    }
  });

  // If there are no hidden elements, add the "hidden" attribute to elements with the specified background color
  if (hiddenCount === 0) {
    itemRows.forEach((itemRow) => {
      if (itemRow.style.backgroundColor === 'lightgreen') {
        itemRow.setAttribute('hidden', '');
      }
    });
  }
 }
 

</script>