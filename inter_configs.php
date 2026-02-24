<?php

session_start();

require_once "cfg/conexion.php";
require_once "crud/crud.php";

$estado = $_POST['estado'];
$usuario = $_POST['usuario'];
$salir = '<button type="button" class="btn btn-dark btn-sq-responsive bg-success"  onClick="regresar()" style="width: 100px; height: 100px;"><img style="width: 75px; height: 75px" src="images/back.png"></button>
<img src="images/autologo.jpg" width="100px" height="100px">
<br> <b> Usuario : ' . $usuario . '</b>';

if ($estado == 'tab_principal_configs') 
{
// MENU PRINCIPAL DE BOTON DE CONFIGURACIONES 
echo '<br><br><br><div style="margin: 0 auto;width: 50%;text-align: center;border-style: double;background:rgba(60, 179, 113, 0.75);"><br> 
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="configusuarios" onClick="config_usuarios()"><img style="width: 75px; height: 75px" src="images/users.png" title="Usuarios y privilegios..."></button>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="configgrupos" onClick="config_grupos()"><img style="width: 75px; height: 75px" src="images/access.png" title="Grupos"></button>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="configproveedores" onClick="config_proveedores()"><img style="width: 75px; height: 75px" src="images/proveedor.png" title="Proveedores"></button>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="configclientes" onClick="config_clientes()"><img style="width: 75px; height: 75px" src="images/clientes.png" title="Clientes"></button>
<br>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="configmesas" onClick="config_mesas()"><img style="width: 75px; height: 75px" src="images/mesas.png" title="Zonas y mesas"></button>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="ingredientes" onClick="config_ingredientes()"><img style="width: 75px; height: 75px" src="images/ingredientes.png" title="Ingredientes"></button>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="productos" onClick="config_productos()"><img style="width: 75px; height: 75px" src="images/productos.png" title="Productos"></button>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="catprod" onClick="config_catprod()"><img style="width: 75px; height: 75px" src="images/categorias.png" title="Categorias-menus de Productos">-</button>
<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient" style="width: 100px; height: 100px" id="configempresa" onClick="config_empresa()"><img style="width: 75px; height: 75px" src="images/empresa.png" title="Mantenimiento de Empresa"></button>
<br>' . $salir . '</div><br><br><br>' ;

}
?>

<script>
var usuario = sessionStorage.getItem('currentloggedin');
var salir = '<button type="button" class="btn btn-dark btn-sq-responsive bg-success"  onClick="regresar_config()" style="width: 100px; height: 100px"><img style="width: 75px; height: 75px" src="images/back.png"></button><img src="images/autologo.jpg" width="100px" height="100px"><br> <b> Usuario : ' + usuario + '</b>';

function config_usuarios()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           buscar: '',
           buscarg: '',
           usuario: usuario,
           estado: 'tab_usuarios'
        },
        beforeSend: function() {
        },
        success: function(r) {

          if (r.includes("noboton") == true)
          {
           document.getElementById('configusuarios').disable;
          }
          else{
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>USUARIOS/ROLES</b></h1><br>' + r + salir + '</div><br><br><br>');
          }
      }
      });
     
}

function activar_zonasameseros()
{
  let isExecuted = confirm("Esta seguro?, Esta tarea le dara permiso a todo MESERO de ver todas las zonas existentes");

if (isExecuted == true)
{   
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tarea_zonasusuario'
        },
        beforeSend: function() {
        },
        success: function(r) {
          Swal.fire({
                icon: 'success',
                title: 'Exito..',
                text: 'TAREA EJECUTADA CON EXITO!'
              }).then(function() {
                config_usuarios();
              });
      }
      });
}
}


function buscar_usuarioa()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           buscar: document.getElementById('UsuarioB').value,
           buscarg: '',
           usuario: usuario,
           estado: 'tab_usuarios'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:white;"><br><h1><b>USUARIOS/ROLES</b></h1><br>' + r + salir + '</div><br><br><br>');
      }
      });


}

function buscar_usuario_grupo()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           buscar: '',
           buscarg: document.getElementById('usuarioa').value,
           usuario: usuario,
           estado: 'tab_usuarios'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:white;"><br><h1><b>USUARIOS/ROLES</b></h1><br>' + r + salir + '</div><br><br><br>');
      }
      });


}

function agregar_usuario()
{

  if (document.getElementById('UsuarioN').value == '')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un Usuario'
              }).then(function() {
              });
            }
  else if (document.getElementById('passwordN').value == '')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un Password'
              }).then(function() {
              });
  }
  else if (document.getElementById('nombreN').value == '')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un Nombre'
              }).then(function() {
              });
  }
  else if (document.getElementById('rol').value == '')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un rol'
              }).then(function() {
              });
  }
  else if (document.getElementById('ComisionS').value > 100)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La comision de venta no puede ser mayor de 100%'
              }).then(function() {
              });
  }
  else if (document.getElementById('ComisionP').value > 100)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La comision de propina no puede ser mayor de 100%'
              }).then(function() {
              });

  }
  else
  {

    if (document.getElementById('MetaS').value == ''){document.getElementById('MetaS').value = 0;}
    if (document.getElementById('ComisionS').value == ''){document.getElementById('ComisionS').value = 0;}

  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            usuario: document.getElementById('UsuarioN').value,
            password: document.getElementById('passwordN').value,
            rol: document.getElementById('rol').value,
            meta: document.getElementById('MetaS').value,
            comision: document.getElementById('ComisionS').value,
            comisionp: document.getElementById('ComisionP').value,
            nombre: document.getElementById('nombreN').value,
            fondo: document.getElementById('colori').value,
            estado: 'agregar_usuario'
          },
          beforeSend: function() {

          },
          success: function(r) {
           if (r == 1062) {
              Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'USUARIO DUPLICADO!'
              }).then(function() {

              });
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Exito..',
                text: 'USUARIO AGREGADO!'
              }).then(function() {
                config_usuarios();
              });
            }

          }

        });
      }

}


function borrar_usuario(id) {
      var r = confirm("Desea borrar el usuario actual?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            usuarioid: id,
            estado: 'borrar_usuario'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Usuario eliminado!'
            }).then(function() {});
          }
        });
        //refrescar usuarios
        config_usuarios();
      }

    }

    function modificar_usuario(id) {
      usuarioid = id;
      usuario = document.getElementById('usuarioID' + id).value
      password = document.getElementById('Newpassword' + id).value;
      nombre = document.getElementById('usuarioN' + id).value;
      rol = document.getElementById('rol' + id).value;
      estadouser = document.getElementById('estado' + id).value;
      meta = document.getElementById('MetaS' + id).value;
      comision = document.getElementById('Comision' + id).value;
      comisionp = document.getElementById('ComisionP' + id).value;
      fondop = document.getElementById('colori' + id).value;
      //obtener estado de zonas
      // select the dropdown menu by its ID
      //CHAT GPT
      const dropdownMenu = document.querySelector('#drop' + id);

      // select all the checkboxes in the dropdown menu
      const checkboxes = dropdownMenu.querySelectorAll('input[type="checkbox"]');

      // create an array to hold the checkbox values and checked status
      const checkboxValues = [];

      // loop through each checkbox and add its value to the array
      checkboxes.forEach((checkbox) => {
       // const value = checkbox.value
        const checked = checkbox.checked;
        checkboxValues.push(checked);
      });

  if (comision > 100)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La comision de venta no puede ser mayor de 100%'
              }).then(function() {
              });
  }
  else if (comisionp > 100)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La comision de propina no puede ser mayor de 100%'
              }).then(function() {
              });

  }
  else
  {
      $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            usuarioid: usuarioid,
            password: password,
            nombre: nombre,
            estadouser: estadouser,
            meta: meta,
            comision:comision,
            comisionp:comisionp,
            rol: rol,
            fondo: fondop,
            estado: 'modificar_usuario',
            zonas: checkboxValues
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos modificados para usuario id : ' + usuario 
            }).then(function() {
                          //refrescar usuarios
            config_usuarios();
            });
          }
        });
      }

    }

/// ROLES roles
function agregar_rol()
{

  if (document.getElementById('rolcrea').value == '')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un rol'
              }).then(function() {
              });
  }
  else
  {
   $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            rol: document.getElementById('rolcrea').value,
            estado: 'agregar_rol'
          },
          beforeSend: function() {

          },
          success: function(r) {
           if (r == 1062) {
              Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'ROL DUPLICADO!'
              }).then(function() {

              });
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Exito..',
                text: 'ROL AGREGADO!'
              }).then(function() {
                config_usuarios();
              });
            }

          }

        });
      }

}


function borrar_rol(id) {
      var r = confirm("Desea borrar el rol?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            rol: id,
            estado: 'borrar_rol'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'rol eliminado!'
            }).then(function() {});
          }
        });
        //refrescar usuarios
        config_usuarios();
      }

    }

    function modificar_rol(id) {
      rol = id;

      $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            rolnombre: document.getElementById('rolc' + id).value,
            rol: rol,
            estado: 'modificar_rol'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos modificados para rol id : ' + document.getElementById('rolc' + id).value
            }).then(function() {
                          //refrescar usuarios
            config_usuarios();
            });
          }
        });

    }

// grupos

function config_grupos()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           buscar: '',
           buscarg: '',
           usuario: usuario,
           estado: 'tab_grupos'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><br><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>GRUPOS DE ACCESOS/PRIVILEGIOS</b></h1><br>' + r + salir + '</div><br><br><br>');
      }
      });
     
}

function buscar_grupo()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           buscar: document.getElementById('Grupo').value,
           buscarg: '',
           usuario: usuario,
           estado: 'tab_grupos'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:white;"><br><h1><b>GRUPOS DE ACCESOS/PRIVILEGIOS</b></h1><br>' + r + salir + '</div><br><br><br>');
      }
      });
}

function buscar_grupod()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           buscar: '',
           buscarg: document.getElementById('Grupod').value,
           usuario: usuario,
           estado: 'tab_grupos'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:white;"><br><h1><b>GRUPOS DE ACCESOS/PRIVILEGIOS</b></h1><br>' + r + salir + '</div><br><br><br>');
      }
      });
}

function agregar_grupo()
{

  if (document.getElementById('grupocrea').value == '')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un Grupo'
              }).then(function() {
              });
  }
  else
  {
   $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            grupo: document.getElementById('grupocrea').value,
            estado: 'agregar_grupo'
          },
          beforeSend: function() {

          },
          success: function(r) {
           if (r == 1062) {
              Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'GRUPO DUPLICADO!'
              }).then(function() {

              });
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Exito..',
                text: 'GRUPO AGREGADO!'
              }).then(function() {
                config_grupos();
              });
            }

          }

        });
      }

}

function borrar_grupo(id) {
      var r = confirm("!ADVERTENCIA!, al llevar acabo esto no solo borrara el grupo sino que tambien sus privilegios asignados por consecuencia, muchos usuarios podrian perder accesos, esta seguro?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            grupo: id,
            estado: 'borrar_grupo'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Grupo eliminado! Recuerde que se afectaron privilegios que pudieron estar asignados a usuarios'
            }).then(function() {});
          }
        });
        //refrescar usuarios
        config_grupos();
      }

    }

    function modificar_grupo(id) {
      $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            grupo: document.getElementById('grupoc' + id).value,
            id: id,
            estado: 'modificar_grupo'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Grupo modificado'
            }).then(function() {
            config_grupos();
            });
          }
        });

    }


function load_opciones(id)
{
  var usuario = sessionStorage.getItem('currentloggedin');
  var grupo = document.getElementById(id).value;
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "JSON",
        data: {
           usuario: usuario,
           grupo: grupo,
           estado: 'listado_opciones'
        },
        beforeSend: function() {
        },
        success: function(r) {
          var data = jQuery.parseJSON(r);
          $('#listopciones').html('');
          $('#listopciones').html(data[0]);

          $('#listopciones2').html('');
          $('#listopciones2').html(data[1]);

      }
      });

}


function agregar_opcion(id)
{
idfinal = id.replace("a", "");

if (document.getElementById(id).value == 'ADMINISTRADOR')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No es permitido agregar mas opciones a ADMINISTRADOR'
              }).then(function() {
              });
            }
 else {
$.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "JSON",
          data: {
            idfinal: idfinal,
            grupo: document.getElementById(id).value,
            estado: 'agregar_opcion'
          },
          beforeSend: function() {

          },
          success: function(r) {
          var data = jQuery.parseJSON(r);
          document.getElementById('grupod' + data[0]).click();

          }

        });

      }
}

function quitar_opcion(id)
{
  idfinal = id.replace("q", "");

  if (document.getElementById(id).value == 'ADMINISTRADOR')
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No es permitido quitar opciones a ADMINISTRADOR'
              }).then(function() {
              });
            }
 else {

  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "JSON",
          data: {
            idfinal: idfinal,
            grupo: document.getElementById(id).value,
            estado: 'quitar_opcion'
          },
          beforeSend: function() {

          },
          success: function(r) {
          var data = jQuery.parseJSON(r);
          document.getElementById('grupod' + data[0]).click();
          }

        });

      }
}


function load_gruposusuario(id)
{
  var usuario = sessionStorage.getItem('currentloggedin');
  var usuariob = document.getElementById(id).value;

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "JSON",
        data: {
           usuario: usuario,
           usuariob: usuariob,
           estado: 'listado_gruposusuario'
        },
        beforeSend: function() {
        },
        success: function(r) {
          var data = jQuery.parseJSON(r);
          $('#listgrupos').html('');
          $('#listgrupos').html(data[0]);

          $('#listgrupos2').html('');
          $('#listgrupos2').html(data[1]);

      }
      });

}

function quitar_opgrupo(id)
{
  idfinal = id.replace("q", "");

  if (document.getElementById(id).value == '1' /*ADMIN*/)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No es permitido quitar opciones a ADMIN'
              }).then(function() {
              });
            }
  else {
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "JSON",
          data: {
            grupo: idfinal,
            userid: document.getElementById(id).value,
            estado: 'quitar_grupo'
          },
          beforeSend: function() {

          },
          success: function(r) {
          document.getElementById('usuariod' + document.getElementById(id).value).click();
          }

        });
      }


}

function agregar_opgrupo(id)
{
  idfinal = id.replace("a", "");

  if (document.getElementById(id).value == '1' /*ADMIN*/)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No es permitido agregar opciones a ADMIN'
              }).then(function() {
              });
            }
  else {
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "JSON",
          data: {
            grupo: idfinal,
            userid: document.getElementById(id).value,
            estado: 'agregar_grupod'
          },
          beforeSend: function() {

          },
          success: function(r) {
          document.getElementById('usuariod' + document.getElementById(id).value).click();
          }

        });
      }

  
}


function load_privilegioslist(id)
{
  var usuario = sessionStorage.getItem('currentloggedin');
  var usuariob = document.getElementById(id).value;
  
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "JSON",
        data: {
           usuario: usuario,
           usuariob: usuariob,
           estado: 'listado_usuarioprivilegios'
        },
        beforeSend: function() {
        },
        success: function(r) {
          var data = jQuery.parseJSON(r);
       
          $('#listprivilegios').html('');
          $('#listprivilegios').html(data[0]);

          $('#listprivilegios2').html('');
          $('#listprivilegios2').html(data[1]);

      }
      });

}


function modpermisocbl(id)
{
  estadof = '';
  if (document.getElementById(id).checked == true)
  {
    estadof = 'agregar_privlectura';
  }
  else if (document.getElementById(id).checked == false)
  {
    estadof = 'quitar_privlectura';
  }

  if (estadof)
  {
  idfinal = id.replace("cbl", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: estadof
          },
          beforeSend: function() {

          },
          success: function(r) {
          }

        });
      }
}

function modpermisocbe(id)
{
  estadof = '';
  if (document.getElementById(id).checked == true)
  {
    estadof = 'agregar_privescritura';
  }
  else if (document.getElementById(id).checked == false)
  {
    estadof = 'quitar_privescritura';
  }

  if (estadof)
  {
  idfinal = id.replace("cbe", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: estadof
          },
          beforeSend: function() {

          },
          success: function(r) {
          }

        });
      }

}

function modpermisocbb(id)
{
  estadof = '';
  if (document.getElementById(id).checked == true)
  {
    estadof = 'agregar_privborrar';
  }
  else if (document.getElementById(id).checked == false)
  {
    estadof = 'quitar_privborrar';
  }

  if (estadof)
  {
  idfinal = id.replace("cbb", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: estadof
          },
          beforeSend: function() {

          },
          success: function(r) {
          }

        });
      }

}


function modpermisocbp(id)
{
  estadof = '';
  if (document.getElementById(id).checked == true)
  {
    estadof = 'agregar_privimprimir';
  }
  else if (document.getElementById(id).checked == false)
  {
    estadof = 'quitar_privimprimir';
  }

  if (estadof)
  {
  idfinal = id.replace("cbp", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: estadof
          },
          beforeSend: function() {

          },
          success: function(r) {
          }

        });
      }

}

function modpermisocbc(id)
{
  estadof = '';
  if (document.getElementById(id).checked == true)
  {
    estadof = 'agregar_privcortesia';
  }
  else if (document.getElementById(id).checked == false)
  {
    estadof = 'quitar_privcortesia';
  }

  if (estadof)
  {
  idfinal = id.replace("cbc", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: estadof
          },
          beforeSend: function() {

          },
          success: function(r) {
          }

        });
      }

}

function modpermisocbpre(id)
{
  estadof = '';
  if (document.getElementById(id).checked == true)
  {
    estadof = 'agregar_privprecuenta';
  }
  else if (document.getElementById(id).checked == false)
  {
    estadof = 'quitar_privprecuenta';
  }

  if (estadof)
  {
  idfinal = id.replace("cbpre", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: estadof
          },
          beforeSend: function() {

          },
          success: function(r) {
          }

        });
      }

}

function modpermisocbsep(id)
{
  estadof = '';
  if (document.getElementById(id).checked == true)
  {
    estadof = 'agregar_privseparar';
  }
  else if (document.getElementById(id).checked == false)
  {
    estadof = 'quitar_privseparar';
  }

  if (estadof)
  {
  idfinal = id.replace("cbsep", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: estadof
          },
          beforeSend: function() {

          },
          success: function(r) {
          }

        });
      }

}

function agregar_privop(id)
{
  idfinal = id.replace("ap", "");

  usuario = document.getElementById(id).value;

  if (usuario == '1' /*ADMIN*/)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No es permitido agregar privilegios a ADMIN'
              }).then(function() {
                
              });
  }
  else
  {
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            priv_id: idfinal,
            usuario: document.getElementById(id).value,
            estado: 'agregar_privop'
          },
          beforeSend: function() {

          },
          success: function(r) {
            load_privilegioslist("usuariodp" +  document.getElementById(id).value);
          }

        });
      }
}




function quitar_privop(id)
{
  idfinal = id.replace("qp", "");
  usuario = document.getElementById(id).value;

  if (usuario == '1' /*ADMIN*/)
{
  Swal.fire({
              icon: 'error',
              title: 'Error...',
              text: 'No es permitido quitar privilegios a ADMIN'
            }).then(function() {
            });
  }
  else
  {
$.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
          priv_id: idfinal,
          usuario: document.getElementById(id).value,
          estado: 'quitar_privop'
        },
        beforeSend: function() {

        },
        success: function(r) {
          load_privilegioslist("usuariodp" +  document.getElementById(id).value);
        }

      });
    }

}


// PROVEEDORES
function config_proveedores()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_proveedores'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><br><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>MANTENIMIENTO DE PROVEEDORES</b></h1><br>' + r + salir + '</div><br><br><br>');
          bgestadocolor();
          // Get the modal
          var modal = document.getElementById("myModalproveedores");

          // Get the button that opens the modal
          var btn = document.getElementById("buscarproveedores");

          // Get the <span> element that closes the modal
          var span = document.getElementsByClassName("close")[0];

          // When the user clicks on the button, open the modal
          btn.onclick = function() {
            redraw_proveedores();
            modal.style.display = "block";
          }

          // When the user clicks on <span> (x), close the modal
          span.onclick = function() {
            modal.style.display = "none";
          }

          // When the user clicks anywhere outside of the modal, close it
          window.onclick = function(event) {
            if (event.target == modal) {
              modal.style.display = "none";
            }
          }

          document.getElementById('nprov').focus();

      }
      });
     
}

function redraw_ingredientes()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_ingredientes'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#myModalingredientes').html('');
          $('#myModalingredientes').html(r);
          
      }
      });
}

function redraw_proveedores()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_proveedores'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#myModalproveedores').html('');
          $('#myModalproveedores').html(r);
          
      }
      });
}

function redraw_clientes()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_clientes'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#myModalclientes').html('');
          $('#myModalclientes').html(r);          
      }
      });
}

function redraw_mesas()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_mesas'
        },
        beforeSend: function() {
          document.getElementById("Espere").style.display = 'block';
         },
        success: function(r) {
          document.getElementById("Espere").style.display = 'none';
          $('#distmesas').html('');
          $('#distmesas').html(r);  
         
      }
      });
}

function redraw_productos()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_productos'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#myModalproductos').html('');
          $('#myModalproductos').html(r);
          
      }
      });
}

function config_clientes()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_clientes'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><br><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>MANTENIMIENTO DE CLIENTES</b></h1><br>' + r + salir + '</div><br><br><br>');
          bgestadocolorc();

           // Get the modal
            var modal = document.getElementById("myModalclientes");

            // Get the button that opens the modal
            var btn = document.getElementById("buscarclientes");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            btn.onclick = function() {
              redraw_clientes();
              modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
              modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = "none";
              }
            }
      }
      });     
}

function calcular_precioiva()
{
   //7-4-2024 agregar total_acumsubs que viene de los subproductos al calculo junto al producto

  if (document.getElementById("prprod").value <= 0 || document.getElementById("prprod").value == '' || document.getElementById("porcmanto").value == '' || document.getElementById("porcganancia").value == '')
  {
    //document.getElementById("prprod").value = '';
  }  
  else
  {
    //obtener iva de table , calcular iva y colocar en ivaprod
    $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "JSON",
          data: {
            precio: document.getElementById("prprod").value,
           // porcpropina: document.getElementById("porcpropina").value,
            porcmanto: document.getElementById("porcmanto").value,
            porcganancia: document.getElementById("porcganancia").value,
            estado: 'get_iva'
          },
          beforeSend: function() {
          },
          success: function(r) {
            var data = jQuery.parseJSON(r);
            //document.getElementById("ivaprod").value = data[0].toFixed(3);
            //add subproducto suma before final price
            document.getElementById("ivaprod").value = (data[0] + total_acumsubs).toFixed(3);
            cambiarfinalprod();
        }
        });

      }
  
}

function cambiarfinalprod()
{
  let iva = parseFloat(document.getElementById("ivaprod").value);
  let final = parseFloat(document.getElementById("finalprod").value);
  bgtext = '';  
  
  if (iva > final)
  {
    bgtext = 'salmon';
  }
  else if (final => iva)
  {
    bgtext = 'lightgreen';
  }
  else
  {
    bgtext = 'white';
  }
   document.getElementById("finalprod").style.backgroundColor = bgtext;
}

function calcular_precioiva2()
{
      if (document.getElementById("porcmanto").value < 0 || document.getElementById("porcmanto").value == '')
      {
        document.getElementById("porcmanto").value = 0;
      }

      if (document.getElementById("porcmanto").value > 100)
      {
        document.getElementById("porcmanto").value = 100;
      }

      if (document.getElementById("porcganancia").value < 0 || document.getElementById("porcganancia").value == '')
      {
        document.getElementById("porcganancia").value = 0;
      }

      if (document.getElementById("porcganancia").value > 100)
      {
        document.getElementById("porcganancia").value = 100;
      }

      calcular_precioiva();
}

function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("icprod").src = oFREvent.target.result;
            document.getElementById("icprod").title = document.getElementById("file").value;
        };
    };

function config_mesas()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_mesas'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><br><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>MANTENIMIENTO DE MESAS</b></h1><br>' + r + salir + '</div><br><br><br>');
          adquirir_azonas();
      }
      });

    }

    function config_productos()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_productos'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;border-style: double;background-color:' + themecolor + ';"><br><div style="text-align:center"><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp<b>MANTENIMIENTO DE PRODUCTOS</b> </h1></div><br>' + r + '<div style="text-align:center">' + salir + '</div></div><br><br><br>');
          bgestadocolorp();
          document.getElementById('nprod').focus();

           // Get the modal
           var modal = document.getElementById("myModalproductos");

            // Get the button that opens the modal
            var btn = document.getElementById("buscarproductos");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            btn.onclick = function() {
              //redraw_proveedores();
              modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
              modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = "none";
              }
            }


      }
      });

    }

    function config_ingredientes()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        async: false,
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_ingredientes'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><br><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>MANTENIMIENTO DE INGREDIENTES</b></h1><br>' + r + salir + '</div><br><br><br>');
         bgestadocolori();

           // Get the modal
           var modal = document.getElementById("myModalingredientes");

            // Get the button that opens the modal
            var btn = document.getElementById("buscaringredientes");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            btn.onclick = function() {
              //redraw_proveedores();
              modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
              modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = "none";
              }
            }


      }
      });

    }

    function config_catprod()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_catprod'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><br><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>MANTENIMIENTO DE CATEGORIAS/MENUS DE PRODUCTOS</b></h1><br>' + r + salir + '</div><br><br><br>');
      }
      });

    }

    function config_empresa()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  
   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_empresa'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#content').html('');
          $('#content').html('<div style="margin: 0 auto;width: 90%;text-align: center;border-style: double;background-color:' + themecolor + ';"><br><h1><img style="width: 20px; height: 20px" src="images/back.png" onClick="regresar_config()">&nbsp &nbsp <b>MANTENIMIENTO DE EMPRESA</b></h1><br>' + r + salir + '</div><br><br><br>');
      }
      });

    }

function buscar_municipio()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  if (document.getElementById('dpprov').value != '')
  {
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           departamento: document.getElementById('dpprov').value,
           estado: 'get_municipio'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#municipiospan').html('');
          $('#municipiospan').html(r);
        }
      });
    }

}



function seleccionar_prov(prov)
{
  var usuario = sessionStorage.getItem('currentloggedin');
 //get data and fill all
 if (prov > 0)
 {
 $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "JSON",
        data: {
           usuario: usuario,
           proveedor: prov,
           estado: 'seleccionar_proveedor'
        },
        beforeSend: function() {
        },
        success: function(r) {
        var data = jQuery.parseJSON(r);
        document.getElementById('cprov').value = data[0];
        document.getElementById('nprov').value = data[1];
        document.getElementById('tprov').value = data[2];
        document.getElementById('celprov').value = data[3];
        document.getElementById('eprov').value = data[4];
        document.getElementById('dprov').value = data[5];
        document.getElementById('dpprov').value = data[6];
        $('#municipiospan').html('');
        $('#municipiospan').html(data[14]);
        document.getElementById('mprov').value = data[7];
        document.getElementById('pprov').value = data[8];
        document.getElementById('ctprov').value = data[9];
        document.getElementById('iprov').value = data[10];
        document.getElementById('nitprov').value = data[11];
        document.getElementById('gprov').value = data[12];
        document.getElementById('clprov').value = data[13];
        document.getElementById('esprov').value = data[15];
      
        bgestadocolor();
        //esconder el modal
        var modal = document.getElementById("myModalproveedores");
        modal.style.display = "none";
        }
      });
  }

}

function seleccionar_prov_nombre()
{
  var usuario = sessionStorage.getItem('currentloggedin');
  var prov = document.getElementById('nprov').value;
 //get data and fill all
 if (prov != '')
 {
 $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "JSON",
        data: {
           usuario: usuario,
           proveedor: prov,
           estado: 'seleccionar_proveedor_nombre'
        },
        beforeSend: function() {
        },
        success: function(r) {
        var data = jQuery.parseJSON(r);
        if (data[0] != 'NF') {
        document.getElementById('cprov').value = data[0];
        document.getElementById('nprov').value = data[1];
        document.getElementById('tprov').value = data[2];
        document.getElementById('celprov').value = data[3];
        document.getElementById('eprov').value = data[4];
        document.getElementById('dprov').value = data[5];
        document.getElementById('dpprov').value = data[6];
        $('#municipiospan').html('');
        $('#municipiospan').html(data[14]);
        document.getElementById('mprov').value = data[7];
        document.getElementById('pprov').value = data[8];
        document.getElementById('ctprov').value = data[9];
        document.getElementById('iprov').value = data[10];
        document.getElementById('nitprov').value = data[11];
        document.getElementById('gprov').value = data[12];
        document.getElementById('clprov').value = data[13];
        document.getElementById('esprov').value = data[15];
        bgestadocolor();
        }
        
        }
      });
  }

}

function seleccionar_cliente(cliente)
{
  var usuario = sessionStorage.getItem('currentloggedin');
 //get data and fill all
 if (cliente > 0)
 {
 $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "JSON",
        data: {
           usuario: usuario,
           cliente: cliente,
           estado: 'seleccionar_cliente'
        },
        beforeSend: function() {
        },
        success: function(r) {
        var data = jQuery.parseJSON(r);
        document.getElementById('ncliente').focus();
        document.getElementById('ccliente').value = data[0];
        document.getElementById('ncliente').value = data[1];
        document.getElementById('acliente').value = data[2];
        document.getElementById('ecliente').value = data[3];
        document.getElementById('dcliente').value = data[4];
        document.getElementById('corcliente').value = data[5];
        document.getElementById('escliente').value = data[6];
        document.getElementById('tcliente').value = data[7];
        document.getElementById('fclientec').value = data[8];
        document.getElementById('fcliented').value = data[9];
        document.getElementById('notcliente').value = data[10];


        bgestadocolorc();
        //esconder el modal
        var modal = document.getElementById("myModalclientes");
        modal.style.display = "none";
        }
      });
  }

}

function seleccionar_ingrediente(ingre)
{
  var usuario = sessionStorage.getItem('currentloggedin');
 //get data and fill all
 if (ingre > 0)
 {
 $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        async: false,
        datatype: "JSON",
        data: {
           usuario: usuario,
           ingre: ingre,
           estado: 'seleccionar_ingrediente'
        },
        beforeSend: function() {
        },
        success: function(r) {

        var data = jQuery.parseJSON(r);
        document.getElementById('ningre').focus();
        document.getElementById('cingre').value = data[0];
        document.getElementById('ningre').value = data[1];
        document.getElementById('uniingre').value = data[2];
        document.getElementById('esingre').value = data[3];
        document.getElementById('costingre').value = data[4];
        document.getElementById('cantelegible').value = data[5];

        bgestadocolori();
        //esconder el modal
        var modal = document.getElementById("myModalingredientes");
        modal.style.display = "none";
        }
      });

  // draw table 
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        async: false,
        datatype: "html",
        data: {
           usuario: usuario,
           ingre: document.getElementById('cingre').value,
           estado: 'llenar_subingredientes'
        },
        beforeSend: function() {
        },
        success: function(r) {
        $('#subingredientesasignados').html('');
        $('#subingredientesasignados').html(r);
        }
      });
}

}

function buscarsubingre()
{

  console.log('cambio');
}

function nuevo_ingrediente()
{
        redraw_ingredientes();
        document.getElementById('ningre').focus();
        document.getElementById('cingre').value = '';
        document.getElementById('costingre').value = '';
        document.getElementById('ningre').value = '';
        document.getElementById('uniingre').value = '';
        document.getElementById('esingre').value = 'Activo';
        bgestadocolori();
        
}

function nuevo_proveedor()
{
        redraw_proveedores();
        document.getElementById('nprov').focus();

        document.getElementById('cprov').value = '';
        document.getElementById('nprov').value = '';
        document.getElementById('tprov').value = '';
        document.getElementById('celprov').value = '';
        document.getElementById('eprov').value = '';
        document.getElementById('dprov').value = '';
        document.getElementById('dpprov').value = '';
        $('#municipiospan').html('<select  id="mprov"><option value=""></option></select>');
        document.getElementById('mprov').value = '';
        document.getElementById('pprov').value = '';
        document.getElementById('ctprov').value = '';
        document.getElementById('iprov').value = '';
        document.getElementById('nitprov').value = '';
        document.getElementById('gprov').value = '';
        document.getElementById('clprov').value = '';
        document.getElementById('esprov').value = 'Activo';
        bgestadocolor();
        
}

function nuevo_cliente()
{
        redraw_clientes();
        document.getElementById('ncliente').focus();

        document.getElementById('ccliente').value = '';
        document.getElementById('ncliente').value = '';
        document.getElementById('acliente').value = '';
        document.getElementById('ecliente').value = '';
        document.getElementById('corcliente').value = '';
        document.getElementById('dcliente').value = '';
        document.getElementById('escliente').value = 'Activo';
        document.getElementById('tcliente').value = '';
        document.getElementById('fclientec').value = '';
        document.getElementById('fcliented').value = '';
        document.getElementById('notcliente').value = '';
        bgestadocolorc();
        
}

function nuevo_producto()
{
      redraw_productos();
      totalingres = [];
      totalprods = [];
      config_productos();            
}

function nuevo_producto2()
{
      redraw_productos();
      config_productos();            
}

function seleccionar_prod(prod)
{
  var usuario = sessionStorage.getItem('currentloggedin');
 //get data and fill all
 if (prod > 0)
 {
 $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "JSON",
        data: {
           usuario: usuario,
           producto_id: prod,
           estado: 'seleccionar_producto'
        },
        beforeSend: function() {
        },
        success: function(r) {
        var data = jQuery.parseJSON(r);
        document.getElementById('cprod').value = data[0];
        document.getElementById("icprod").src = "images/productos/" + data[1] + "";
        document.getElementById("icprod").title = data[1];
        document.getElementById("nprod").value = data[2];
        document.getElementById("finalprod").value = data[3];
        //document.getElementById("ivaprod").value = data[4];
        document.getElementById("catprod").value = data[5];
        document.getElementById("scatprod").value = data[6];
        document.getElementById("descprod").value = data[7];
        document.getElementById("esprod").value = data[8];
        if (data[9] == 'true'){document.getElementById('diasLu').checked = true;}else{document.getElementById('diasLu').checked = false;}
        if (data[10] == 'true'){document.getElementById('diasMa').checked = true;}else{document.getElementById('diasMa').checked = false;}
        if (data[11] == 'true'){document.getElementById('diasMi').checked = true;}else{document.getElementById('diasMi').checked = false;}
        if (data[12] == 'true'){document.getElementById('diasJu').checked = true;}else{document.getElementById('diasJu').checked = false;}
        if (data[13] == 'true'){document.getElementById('diasVi').checked = true;}else{document.getElementById('diasVi').checked = false;}
        if (data[14] == 'true'){document.getElementById('diasSa').checked = true;}else{document.getElementById('diasSa').checked = false;}
        if (data[15] == 'true'){document.getElementById('diasDo').checked = true;}else{document.getElementById('diasDo').checked = false;}
        document.getElementById("desdeh").value = data[16];
        document.getElementById("desdem").value = data[17];
        document.getElementById("hastah").value = data[18];
        document.getElementById("hastam").value = data[19];
        totalingres = data[20];
        totalprods = data[21];
        document.getElementById("porcmanto").value = data[22];
        document.getElementById("porcganancia").value = data[23];
        //LLEVA SERVICIO TODOS LOS DIAS
        if (data[24] == 'true')
        {
          if (document.getElementById('servicioindef').checked == false){document.getElementById("servicioindef").click();}  
        }
        if (data[24] == 'false')
        {
          if (document.getElementById('servicioindef').checked == true){document.getElementById("servicioindef").click();}  
        }
         //LLEVA PROPINA
         if (data[25] == 'true'){document.getElementById('propina').checked = true;}else{document.getElementById('propina').checked = false;}

        arregloasignados = data[27];
        arregloproductos = data[28];

        if (data[29] == 'true')
        {
          document.getElementById('notaoblig').checked = true;
          document.getElementById('preguntas').value = data[30];
          document.getElementById('preguntas').disabled = false;
          document.getElementById('respuestas').value = data[31];
          document.getElementById('respuestas').disabled = false;
        }
        else
        {
          document.getElementById('notaoblig').checked = false;
          document.getElementById('preguntas').value = '';
          document.getElementById('preguntas').disabled = true;
          document.getElementById('respuestas').value = '';
          document.getElementById('respuestas').disabled = true;
        }


        regenerar_ingredientesasignar();
        redraw_ingredientes_asignados();
        regenerar_productosasignar();
        redraw_productos_asignados();
        
         document.getElementById('prprod').value = data[26].toFixed(3);
        //tempcosto = '';
        // document.getElementById('prprod').value = '';
        // totalingres.forEach((score) => {
        // tempcosto = (Number(tempcosto) + Number(score[4])).toFixed(2);
        // });
        // document.getElementById('prprod').value = tempcosto;
        calcular_precioiva();
        bgestadocolorp();
        //esconder el modal
        var modal = document.getElementById("myModalproductos");
        modal.style.display = "none";
        cambiarfinalprod();



        }
      });
  }

}

function redraw_ingredientes_asignar()
{
  const tableRows = document.querySelectorAll('#ingredientesasignar tr');
  tableRows.forEach(tr => tr.style.display = '');
}



function redraw_ingredientes_asignados()
{
  // REDRAW PANEL IZQUIERDO
  //redraw_ingredientes_asignar();

  // totalingres.forEach((score) => {
  //   document.getElementById("fingre" + score[0]).style.display = 'none';
  // }); 

  // fill secondary table
  ingasig = ''; //global
  $('#ingredientesasignados').html('');

  //ingasig += '<table class="table table-bordered table-light table-hover" id="fingredientestable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th><input type="text" id="fingreb2" onkeypress="filtrar_ingre2_key(event)" placeholder="INGREDIENTE" size="9px"/> <input  type="button" value="B" class="bg-success" onClick="filtrar_ingre2()"  ></th><th>CANTIDAD</th><th>UNIDAD</th><th>-</th></thead><tr>';
  ingasig += 'INGREDIENTES SELECCIONADOS : <br><table class="table table-bordered table-light table-hover" id="fingredientestable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>INGREDIENTE</th><th>CANTIDAD</th><th>COSTOU</th><th>COSTOT</th><th>UNIDAD</th><th>-</th></thead><tr>';


  funcion = 'quitar_ingrediente(this.id)';

  totalingres.forEach((score) => {
    ingasig += '<tr id="aingre' + score[0] + '"><td>' + score[1] + '</td><td>' + score[2] + '</td><td>$ ' + Number(score[4]/score[2]).toFixed(3)  + '</td><td>$ ' +  Number(score[4]).toFixed(3) + '</td><td>' + score[3] + '</td><td class="bg-danger" id="' + score[0] + '" onClick="' + funcion + '">-</td></tr>';
  });

  ingasig += '</table>' ;

  $('#ingredientesasignados').html(ingasig);


}

function redraw_productos_asignar()
{
  const tableRows = document.querySelectorAll('#productosasignar tr');
  tableRows.forEach(tr => tr.style.display = '');
}


function redraw_productos_asignados()
{
  // REDRAW PANEL IZQUIERDO
  // redraw_productos_asignar();

  // totalprods.forEach((score) => {
  //   document.getElementById("nprod" + score[0]).style.display = 'none';
  // }); 

  // fill secondary table
  ingasig = ''; //global
  $('#productosasignados').html('');

  ingasig += 'PRODUCTOS SELECCIONADOS : <br><table class="table table-bordered table-light table-hover" id="fproductostable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>NOMBRE</th><th>CATEGORIA</th><th>CANTIDAD</th><th>DESCRIPCION</th><th>IMAGEN</th><th>-</th></thead></thead><tr>';


  funcion = 'quitar_producto(this.id)';

  totalprods.forEach((score) => {
    ingasig += '<tr id="qprod' + score[0] + '"><td>' + score[1] + '</td><td>' + score[2] + '</td><td>' + score[3] + '</td><td>' + score[4] + '</td><td><img src="images/productos/' + score[5] + '" style="width:25px;height:25px" title="' + score[5] + '" ></td><td class="bg-danger" id="' + score[0] + '" onClick="' + funcion + '">-</td></tr>';
  });

  ingasig += '</table>' ;

  $('#productosasignados').html(ingasig);

}

function bgestadocolor()
{
   if (document.getElementById('esprov').value == 'Activo')
   {
    document.getElementById('esprov').style.backgroundColor = "green";
   }
   else if  (document.getElementById('esprov').value == 'Inactivo')
   { 
    document.getElementById('esprov').style.backgroundColor = "red";   
   }
}

function bgestadocolorc()
{
   if (document.getElementById('escliente').value == 'Activo')
   {
    document.getElementById('escliente').style.backgroundColor = "green";
   }
   else if  (document.getElementById('escliente').value == 'Inactivo')
   { 
    document.getElementById('escliente').style.backgroundColor = "red";   
   }

}

function bgestadocolorp()
{
   if (document.getElementById('esprod').value == 'Activo')
   {
    document.getElementById('esprod').style.backgroundColor = "green";
   }
   else if  (document.getElementById('esprod').value == 'Inactivo')
   { 
    document.getElementById('esprod').style.backgroundColor = "red";   
   }

}

function bgestadocolori()
{
   if (document.getElementById('esingre').value == 'Activo')
   {
    document.getElementById('esingre').style.backgroundColor = "green";
   }
   else if  (document.getElementById('esingre').value == 'Inactivo')
   { 
    document.getElementById('esingre').style.backgroundColor = "red";   
   }

}

function bgestadocolor_fondos(id)
{
   if (document.getElementById(id).value == 'celeste')
   {
    document.getElementById(id).style.backgroundColor = "cyan";
   }
   else if  (document.getElementById(id).value == 'gris')
   { 
    document.getElementById(id).style.backgroundColor = "gray";   
   }
   else if  (document.getElementById(id).value == 'blanco')
   { 
    document.getElementById(id).style.backgroundColor = "white";   
   }
   else if  (document.getElementById(id).value == 'verde')
   { 
    document.getElementById(id).style.backgroundColor = "green";   
   }
   else if  (document.getElementById(id).value == 'amarillo')
   { 
    document.getElementById(id).style.backgroundColor = "yellow";   
   }
   else if  (document.getElementById(id).value == 'azul')
   { 
    document.getElementById(id).style.backgroundColor = "lightblue";   
   }

}

function guardarmod_proveedor()
{
  var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; //para email

  tipo = 'insertar';

  if (document.getElementById('cprov').value != '')
  {
    tipo = 'modificar';
  }

  if (document.getElementById('nprov').value == '')
  {
    document.getElementById('nprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un nombre de Proveedor Unico'
              }).then(function() {
                
              });

  }  

  else if ((document.getElementById('celprov').value).length < 8 || isNaN(document.getElementById('celprov').value) == true)
  {
    document.getElementById('celprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Celular Invalido'
              }).then(function() {
                
              });

  }
  else if (document.getElementById('eprov').value != '' && document.getElementById('eprov').value.match(validRegex) == null)
  {
    document.getElementById('eprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Email Invalido'
              }).then(function() {
                
              });

  }
  else if ((document.getElementById('dprov').value).length < 20)
  {
    document.getElementById('dprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Proporcione una direccion valida'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('dpprov').value == '')
  {
    document.getElementById('dpprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione un Departamento'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('mprov').value == '')
  {
    document.getElementById('mprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione un Municipio'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('pprov').value == '')
  {
    document.getElementById('pprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione un Pais'
              }).then(function() {
                
              });
  }
  else if ((document.getElementById('ctprov').value).length < 10)
  {
    document.getElementById('ctprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un nombre de Contacto'
              }).then(function() {
                
              });

  }
  else if ((document.getElementById('iprov').value).length < 7)
  {
    document.getElementById('iprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Registro de Iva Invalido, (no guiones)'
              }).then(function() {
                
              });

  }
  else if ((document.getElementById('nitprov').value).length < 14)
  {
    document.getElementById('nitprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Nit invalido, (no guiones)'
              }).then(function() {
                
              });

  }
  else if (document.getElementById('gprov').value == '')
  {
    document.getElementById('gprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione un Giro'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('clprov').value == '')
  {
    document.getElementById('clprov').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione una Clasificacion DGII'
              }).then(function() {
                
              });
  }
  else
  {
    //guardar mod
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           tipo: tipo,
           estadop: document.getElementById('esprov').value ,
           codigo: document.getElementById('cprov').value ,
           nombre: document.getElementById('nprov').value,
           telefono: document.getElementById('tprov').value,
           cel: document.getElementById('celprov').value,
           email:document.getElementById('eprov').value,
           direccion:document.getElementById('dprov').value,
           departamento:document.getElementById('dpprov').value,
           municipio:document.getElementById('mprov').value,
           pais:document.getElementById('pprov').value,
           contacto:document.getElementById('ctprov').value,
           iva:document.getElementById('iprov').value,
           nit:document.getElementById('nitprov').value,
           giro:document.getElementById('gprov').value,
           dgii:document.getElementById('clprov').value,
           estado: 'guardarmod_proveedor'
        },
        beforeSend: function() {
        },
        success: function(r) {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos Guardados!'
            }).then(function() {});
        }
      });



    nuevo_proveedor();
    redraw_proveedores();
  }

}

function guardarmod_cliente()
{
  var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; //para email

  tipo = 'insertar';

  if (document.getElementById('ccliente').value != '')
  {
    tipo = 'modificar';
  }

  if (document.getElementById('ncliente').value == '')
  {
    document.getElementById('ncliente').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un nombre de Cliente'
              }).then(function() {
                
              });

  }  
  else if (document.getElementById('acliente').value == '')
  {
    document.getElementById('acliente').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un apellido de Cliente'
              }).then(function() {
                
              });
  } 
  else if ((document.getElementById('tcliente').value).length < 8 || isNaN(document.getElementById('tcliente').value) == true)
  {
    document.getElementById('tcliente').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Celular/Telefono Invalido'
              }).then(function() {
                
              });

  }
  else if (document.getElementById('corcliente').value != '' && document.getElementById('corcliente').value.match(validRegex) == null)
  {
    document.getElementById('corcliente').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Email Invalido'
              }).then(function() {
                
              });

  }
  else if ((document.getElementById('dcliente').value).length < 9 || isNaN(document.getElementById('dcliente').value) == true)
  {
    document.getElementById('dcliente').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Proporcione un DUI'
              }).then(function() {
                
              });
  }
  else
  {
    //guardar mod
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           tipo: tipo,
           estadop: document.getElementById('escliente').value,
           codigo: document.getElementById('ccliente').value,
           nombre: document.getElementById('ncliente').value,
           apellido: document.getElementById('acliente').value,
           empresa: document.getElementById('ecliente').value,
           email: document.getElementById('corcliente').value,
           dui: document.getElementById('dcliente').value,
           telefono: document.getElementById('tcliente').value,
           cumple: document.getElementById('fclientec').value,
           com: document.getElementById('fcliented').value,
           notas: document.getElementById('notcliente').value,
           estado: 'guardarmod_cliente'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos Guardados!'
            }).then(function() {});

            nuevo_cliente();
            redraw_clientes();
            document.getElementById('dcliente').focus();
          } else
          {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'El DUI ingresado ya existe!'
              }).then(function() {
                
              });
          }
        }
      });


  }

}

function guardarmod_ingrediente()
{
  tipo = 'insertar';

  if (document.getElementById('cingre').value != '')
  {
    tipo = 'modificar';
  }

  if (document.getElementById('ningre').value == '')
  {
    document.getElementById('ningre').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un nombre unico de ingrediente'
              }).then(function() {
                
              });

  }  
  else if (document.getElementById('costingre').value == '' || document.getElementById('costingre').value <= 0)
  {
    document.getElementById('costingre').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un costo y no puede ser 0'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('uniingre').value == '')
  {
    document.getElementById('uniingre').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar una unidad'
              }).then(function() {
                
              });
  }
  else
  {
    //guardar mod
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           tipo: tipo,
           estadoi: document.getElementById('esingre').value,
           nombre: document.getElementById('ningre').value,
           unidad: document.getElementById('uniingre').value,
           ingreid: document.getElementById('cingre').value, 
           costingre: document.getElementById('costingre').value, 
           cantelegible: document.getElementById('cantelegible').value, 
           estado: 'guardarmod_ingrediente'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos Guardados!'
            }).then(function() {});

            nuevo_ingrediente();
            redraw_ingredientes();
            document.getElementById('ningre').focus();
          } else
          {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'El Ingrediente ya existe!'
              }).then(function() {
                
              });
          }
        }
      });


  }

}

function guardarmod_producto()
{
  tipo = 'insertar';

  if (document.getElementById('cprod').value != '')
  {
    tipo = 'modificar';
  }

  var files = document.getElementById("file").files;

  if (files[0] == undefined && document.getElementById('cprod').value == '')
  {
    document.getElementById('file').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Seleccionar una imagen (Maximo 20Mb)'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('nprod').value == '')
  {
    document.getElementById('nprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un Nombre de Producto'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('catprod').value == '') 
  {
    document.getElementById('catprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar una Categoria de Producto'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('descprod').value == '') 
  {
    document.getElementById('descprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese una breve descripcion del producto'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('diasLu').checked == false && document.getElementById('diasMa').checked == false && document.getElementById('diasMi').checked == false && document.getElementById('diasJu').checked == false && document.getElementById('diasVi').checked == false && document.getElementById('diasSa').checked == false && document.getElementById('diasDo').checked == false)   
  {
    document.getElementById('descprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe ingresar al menos un dia de servicio para el producto'
              }).then(function() {
                
              });              
  }
  else if (document.getElementById('servicioindef').checked == false && document.getElementById('desdeh').value == '' )   
  {
    document.getElementById('desdeh').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe ingresar una hora y fecha de inicio'
              }).then(function() {
                
              });        
  }
  else if (document.getElementById('servicioindef').checked == false && document.getElementById('desdem').value == '' )   
  {
    document.getElementById('desdeh').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe ingresar una hora y fecha de inicio'
              }).then(function() {
                
              });        
  }
  else if (document.getElementById('servicioindef').checked == false && document.getElementById('hastah').value == '' )   
  {
    document.getElementById('hastah').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe ingresar una hora y fecha final'
              }).then(function() {
                
              });        
  }
  else if (document.getElementById('servicioindef').checked == false && document.getElementById('hastam').value == '' )   
  {
    document.getElementById('hastah').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe ingresar una hora y fecha final'
              }).then(function() {
                
              });        
  }
  else if (document.getElementById('servicioindef').checked == false && (document.getElementById('hastah').value + ' ' + document.getElementById('hastam').value) <= (document.getElementById('desdeh').value + ' ' + document.getElementById('desdem').value) )   
  {
    document.getElementById('hastah').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La fecha final no puede ser menor que la inicial'
              }).then(function() {                
              });        
  }
  else if (document.getElementById('notaoblig').checked == true && document.getElementById('preguntas').value == '' && document.getElementById('respuestas').value == '')    ///al menos 10 letras
  {
    document.getElementById('preguntas').focus();
    Swal.fire({
                icon: 'info',
                title: 'Advertencia...',
                text: 'Selecciono Notas obligatorias, agrege unas preguntas/notas al producto'
              }).then(function() {                
              });        
  }
  else if (document.getElementById('prprod').value <= 0)
  {
    document.getElementById('prprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No hay calculo de ingredientes'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('finalprod').value <= 0)
  {
    document.getElementById('finalprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe ingresar un precio final'
              }).then(function() {
                
              });
  }
  else if (totalingres.length == 0)   
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe asignar al menos un Ingrediente!'
              }).then(function() {                
              });        
  }
     else
  {
    if (files[0] != undefined) 
    { 
    // if more than 40 chars trow error
    if (files[0].name.length > 40) 
    {  
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'El nombre de la imagen esta muy largo!, acortelo e intente de nuevo!' 
              }).then(function() {
                
              });
    }
    else
    {
    guardar_producto(tipo,files[0].name);
    }
    }
    else
    {
      guardar_producto(tipo,'no');
    }

  }

}

function guardar_producto(tipo,files)
{
   // no se pueden mandar arrays vacios en AJAX
   if (totalprods.length == 0)
   {
    var totalprods2 = ''
   }
   else
   {
    var totalprods2 = [];
    //totalprods2.push(totalprods);
    totalprods2 = totalprods;
   }

       // quitar espacios del nombre
      files = files.replace(/ /g, '_'); // Replace all spaces with underscores
      files = files.replace(/\(/g, ''); // Remove all '(' characters
      files = files.replace(/\)/g, ''); // Remove all ')' characters\

    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           estadopr: document.getElementById('esprod').value,
           tipo: tipo,
           filename1: files,
           codprod: document.getElementById('cprod').value,
           producto: document.getElementById('nprod').value,
           precio: document.getElementById('finalprod').value,
           iva: document.getElementById('ivaprod').value,
           categoria:  document.getElementById('catprod').value,
           scategoria:  document.getElementById('scatprod').value,
           desc:  document.getElementById('descprod').value,
           lunes: document.getElementById('diasLu').checked,
           martes: document.getElementById('diasMa').checked,
           miercoles: document.getElementById('diasMi').checked,
           jueves: document.getElementById('diasJu').checked,
           viernes: document.getElementById('diasVi').checked,
           sabado: document.getElementById('diasSa').checked,
           domingo: document.getElementById('diasDo').checked,
           //fdesde: document.getElementById('desdeh').value + ' ' + document.getElementById('desdem').value,
          // fhasta: document.getElementById('hastah').value + ' ' + document.getElementById('hastam').value,
           fdesde: document.getElementById('desdeh').value,
           fhasta: document.getElementById('hastah').value,
           mdesde: document.getElementById('desdem').value,
           mhasta: document.getElementById('hastam').value,
           servicio:  document.getElementById('servicioindef').checked,
           tingredientes: totalingres,
           tproductos: totalprods2,
           propina:  document.getElementById('propina').checked,
           porcmanto: document.getElementById('porcmanto').value,
           porcganancia: document.getElementById('porcganancia').value,
           notaoblig: document.getElementById('notaoblig').checked,
           preguntas: document.getElementById('preguntas').value,
           respuestas: document.getElementById('respuestas').value,
           estado: 'guardarmod_producto'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Producto Guardado!'
            }).then(function() {});
            if (files != 'no')
            { 
              uploadFile();
            }
            nuevo_producto();
            redraw_productos();
            document.getElementById('nprod').focus();
            totalingres = [];
            tempingres = [];
            totalprods = [];
            arregloasignados = [];
          } else
          {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'El Producto ya existe, ingrese un nombre unico!'
              }).then(function() {
                
              });
          }
        }
      });
}

function servicio_indef()
{
  if (document.getElementById('servicioindef').checked == true) 
  {
    document.getElementById('desdeh').disabled = true;
    document.getElementById('hastah').disabled = true;
    document.getElementById('desdem').disabled = true;
    document.getElementById('hastam').disabled = true;

    document.getElementById('diasLu').checked = true;
    document.getElementById('diasMa').checked = true;
    document.getElementById('diasMi').checked = true;
    document.getElementById('diasJu').checked = true;
    document.getElementById('diasVi').checked = true;
    document.getElementById('diasSa').checked = true;
    document.getElementById('diasDo').checked = true;

    document.getElementById('diasLu').disabled = true;
    document.getElementById('diasMa').disabled = true;
    document.getElementById('diasMi').disabled = true;
    document.getElementById('diasJu').disabled = true;
    document.getElementById('diasVi').disabled = true;
    document.getElementById('diasSa').disabled = true;
    document.getElementById('diasDo').disabled = true;

    document.getElementById('desdeh').value = '';
    document.getElementById('hastah').value = '';
    document.getElementById('desdem').value = '';
    document.getElementById('hastam').value = '';
  }
  else
  {
    document.getElementById('desdeh').disabled = false;
    document.getElementById('hastah').disabled = false;
    document.getElementById('desdem').disabled = false;
    document.getElementById('hastam').disabled = false;

    document.getElementById('diasLu').checked = false;
    document.getElementById('diasMa').checked = false;
    document.getElementById('diasMi').checked = false;
    document.getElementById('diasJu').checked = false;
    document.getElementById('diasVi').checked = false;
    document.getElementById('diasSa').checked = false;
    document.getElementById('diasDo').checked = false;

    document.getElementById('diasLu').disabled = false;
    document.getElementById('diasMa').disabled = false;
    document.getElementById('diasMi').disabled = false;
    document.getElementById('diasJu').disabled = false;
    document.getElementById('diasVi').disabled = false;
    document.getElementById('diasSa').disabled = false;
    document.getElementById('diasDo').disabled = false;
  }
  
}

function preguntas_obligatorias()
{
  if (document.getElementById('notaoblig').checked == true) 
  {
    document.getElementById('preguntas').disabled = false;
    document.getElementById('preguntas').value = '';
    document.getElementById('preguntas').focus();

    document.getElementById('respuestas').disabled = false;
    document.getElementById('respuestas').value = '';
  }
  else
  {
    document.getElementById('preguntas').disabled = true;
    document.getElementById('preguntas').value = '';
    document.getElementById('respuestas').disabled = true;
    document.getElementById('respuestas').value = '';
  }

}

  function uploadFile() {

  var files = document.getElementById("file").files;


  if(files.length == 1 ){

    var formData = new FormData();
    formData.append("file", files[0]);

    var xhttp = new XMLHttpRequest();

    // Set POST method and ajax file path
    xhttp.open("POST", "ajaxfileenvio.php", true);

    // call on request changes state
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var response = this.responseText;
          if(response == 1){
            //alert("Upload successfully.");
          }else{
           // alert("Problemas al subir Imagen.");
           //throw new Error('No se puede subir la imagen , debe ser extension JPG o JPEG');
           return 999;
          }
        }
    };

    // Send request with data
    xhttp.send(formData);
    
  }else{
    alert("Por favor seleccione una imagen");
  }

  }


  
   function borrar_proveedor()
   {
    if (document.getElementById('cprov').value != '') 
    {
    var r = confirm("Desea borrar el proveedor actual?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            provid: document.getElementById('cprov').value,
            estado: 'borrar_proveedor'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Proveedor eliminado!'
            }).then(function() {});
          }
        });
        nuevo_proveedor();
       redraw_proveedores();
      }
    }
    else
    {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione un Proveedor'
              }).then(function() {
                
              });
    }

   }

   function borrar_producto()
   {
    //confirmar
    //debe borrar de productos el producto_id
    //debe borrar de ingredientes_Asignados el id (producto_id)
    //debe borrar de  subproductos_asignados (producto_id)
    if (document.getElementById('cprod').value != '') 
    {
    var r = confirm("Desea borrar el producto actual, si esta asignado a otro producto ya no se podra utilizar?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            prodid: document.getElementById('cprod').value,
            estado: 'borrar_producto'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Producto y asociaciones eliminado!'
            }).then(function() {});
          }
        });
        nuevo_producto();
        redraw_productos();
      }
    }
    
   }


   function borrar_cliente()
   {
    if (document.getElementById('ccliente').value != '') 
    {
    var r = confirm("Desea borrar el cliente actual?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            clienteid: document.getElementById('ccliente').value,
            estado: 'borrar_cliente'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Cliente eliminado!'
            }).then(function() {});
          }
        });
        nuevo_cliente();
        redraw_clientes();
      }
    }
    else
    {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione un Cliente'
              }).then(function() {
                
              });
    }

   }


   function borrar_ingrediente()
   {
    if (document.getElementById('cingre').value != '') 
    {
    var r = confirm("Desea borrar el ingrediente actual?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            ingreid: document.getElementById('cingre').value,
            estado: 'borrar_ingrediente'
          },
          beforeSend: function() {

          },
          success: function(r) {
            if (r == 1)
            {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Ingrediente eliminado!'
            }).then(function() {});
            }
            else if (r == 99)
            {
              Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'El Ingrediente ya esta asignado y en uso, intente desactivarlo!'
              }).then(function() {
                
              });
            }
          }
        });
        nuevo_ingrediente();
        redraw_ingredientes();
      }
    }
    else
    {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione un Ingrediente'
              }).then(function() {
                
              });
    }

   }
function seleccionar_zona(id)
{
  idfinal = id.replace("Z", "");
  document.getElementById('szonas').value = idfinal;
  document.getElementById('szonas').style.backgroundColor = "lightgreen";
}

// inserta la mesa a la zona seleccionada
function agregarmesa_azona(id)
{
  if (document.getElementById('szonas').value > 0)
  {
  document.getElementById(id).style.display = 'none'
  idfinal = id.replace("M", "");

  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            mesa: idfinal,
            zona: document.getElementById('szonas').value,
            estado: 'agregar_mesa'
          },
          beforeSend: function() {

          },
          success: function(r) {
            redraw_mesas();
            redraw_areas_zonas();
          }
        });

  }
  else
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione una Zona'
              }).then(function() {
                
              });

  }
  
}

// inserta la mesa a la zona seleccionada
function quitarmesa_azona(id)
{
  document.getElementById(id).style.display = 'none'
  idfinal = id.replace("MQ", "");
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            mesa: idfinal,
            estado: 'quitar_mesa'
          },
          beforeSend: function() {

          },
          success: function(r) {
            redraw_mesas();
          }
        });

  
}

function guardar_cantzonas()
{
  zonas = document.getElementById('nzonas').value;

  if (zonas > 0)
  {  
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            zonas: zonas,
            estado: 'guardar_cantzonas'
          },
          beforeSend: function() {
            document.getElementById("Espere").style.display = 'block';
          },
          success: function(r) {
            document.getElementById("Espere").style.display = 'none';
            redraw_mesas();
            //REDRAW zonas asignar
           // redraw_areas_zonas();
           config_mesas();
          }
        });

  }
  else
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Cantidad para zona invalida!'
              }).then(function() {
                zonas.focus();
              });
  }
}

function guardar_cantmesas()
{
  mesas = document.getElementById('nmesas').value;

  if (mesas > 0)
  {  
  $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            mesas: mesas,
            estado: 'guardar_cantmesas'
          },
          beforeSend: function() {
            document.getElementById("Espere").style.display = 'block';
          },
          success: function(r) {
            document.getElementById("Espere").style.display = 'none';
            redraw_mesas();
          }
        });

  }
  else
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Cantidad para mesas invalida!'
              }).then(function() {
                mesas.focus();
              });
  }
  
}



function agregar_ingrediente(id)
{
idfinal = id.replace("ingre", "");
tempcosto = '';

//esconderfila
if (document.getElementById("cingre" + idfinal).value == "" || document.getElementById("cingre" + idfinal).value <= 0)
{
  Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese una cantidad al ingrediente : ' + document.getElementById("ningre" + idfinal).innerText
              }).then(function() {
                document.getElementById("cingre" + idfinal).focus();
              });

}
else
{

  // REMOVER 3191
//document.getElementById("fingre" + idfinal).style.display = 'none';
// esconderlo por query
//generar array de ids a esconder
arregloasignados.push(idfinal);

//generar de nuevo los ingredientes asignados
tempingres.push(idfinal, document.getElementById("ningre" + idfinal).innerHTML, document.getElementById("cingre" + idfinal).value, document.getElementById("uingre" + idfinal).innerHTML,(document.getElementById("cingre" + idfinal).value*document.getElementById("dingre" + idfinal).value));

totalingres.push(tempingres);

tempingres = [];

// fill secondary table
ingasig = ''; //global
$('#ingredientesasignados').html('');

//ingasig += '<table class="table table-bordered table-light table-hover" id="fingredientestable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th><input type="text" id="fingreb2" onkeypress="filtrar_ingre2_key(event)" placeholder="INGREDIENTE" size="9px"/> <input  type="button" value="B" class="bg-success" onClick="filtrar_ingre2()"  ></th><th>CANTIDAD</th><th>UNIDAD</th><th>-</th></thead><tr>';
ingasig += 'INGREDIENTES SELECCIONADOS : <br><table class="table table-bordered table-light table-hover" id="fingredientestable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>INGREDIENTE</th><th>CANTIDAD</th><th>COSTOU</th><th>COSTOT</th><th>UNIDAD</th><th>-</th></thead><tr>';


funcion = 'quitar_ingrediente(this.id)';

totalingres.forEach((score) => {
  ingasig += '<tr id="aingre' + score[0] + '"><td>' + score[1] + '</td><td>' + Number(score[2]).toFixed(3) + '</td><td>$ ' + Number(score[4]/score[2]).toFixed(3)  + '</td><td>$ ' + Number(score[4]).toFixed(3)  + '</td><td>' + score[3] + '</td><td class="bg-danger" id="' + score[0] + '" onClick="' + funcion + '">-</td></tr>';
});

ingasig += '</table>' ;

$('#ingredientesasignados').html(ingasig);

document.getElementById('prprod').value = '';
totalingres.forEach((score) => {
  tempcosto = (Number(tempcosto) + Number(score[4])).toFixed(3);
});
document.getElementById('prprod').value = tempcosto;

  if (tempcosto == '')
  {
    document.getElementById('ivaprod').value = '';
  }

calcular_precioiva();

// esconderlo por query
//generar array de ids a esconder
regenerar_ingredientesasignar();

}

}

function regenerar_ingredientesasignar()
{
  var usuario = sessionStorage.getItem('currentloggedin');


  if (arregloasignados.length == 0)
  {
    var temparr = '';
  }
  else
  {
    var temparr = arregloasignados;
  }

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           ingredientesasignar: temparr,
           usuario: usuario,
           estado: 'regenerar_ingredientesasignar'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#ingredientesasignar').html('');
          $('#ingredientesasignar').html(r);
          
      }
      });

}

function regenerar_ingredientesasignar_noasync()
{
  var usuario = sessionStorage.getItem('currentloggedin');


  if (arregloasignados.length == 0)
  {
    var temparr = '';
  }
  else
  {
    var temparr = arregloasignados;
  }

  $.ajax({
        type: "POST",
        async: false,
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           ingredientesasignar: temparr,
           usuario: usuario,
           estado: 'regenerar_ingredientesasignar'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#ingredientesasignar').html('');
          $('#ingredientesasignar').html(r);
          
      }
      });

}

function quitar_ingrediente(id)
{
//remueve por indice la linea y la vuelve a crear
tempcosto = '';

 for (var i=0; i < totalingres.length; ++i) {
    if (totalingres[i][0] == id) {
        totalingres.splice(i, 1);
    }
  }

  if (totalingres != [])
  {
  //redraw
  // fill secondary table
  ingasig = ''; //global
  $('#ingredientesasignados').html('');

//ingasig += '<table class="table table-bordered table-light table-hover" id="fingredientestable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th><input type="text" id="fingreb2" onkeypress="filtrar_ingre2_key(event)" placeholder="INGREDIENTE" size="9px"/> <input  type="button" value="B" class="bg-success" onClick="filtrar_ingre2()"  ></th><th>CANTIDAD</th><th>UNIDAD</th><th>-</th></thead><tr>';
ingasig += 'INGREDIENTES SELECCIONADOS : <br><table class="table table-bordered table-light table-hover" id="fingredientestable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>INGREDIENTE</th><th>CANTIDAD</th><th>COSTO</th><th>UNIDAD</th><th>-</th></thead><tr>';


funcion = 'quitar_ingrediente(this.id)';

totalingres.forEach((score) => {
  ingasig += '<tr id="aingre' + score[0] + '"><td>' + score[1] + '</td><td>' + score[2] + '</td><td>$ ' + score[4] + '</td><td>' + score[3] + '</td><td class="bg-danger" id="' + score[0] + '" onClick="' + funcion + '">-</td></tr>';
});

  ingasig += '</table>' ;


  $('#ingredientesasignados').html(ingasig);

  document.getElementById('prprod').value = '';
  totalingres.forEach((score) => {
  tempcosto = (Number(tempcosto) + Number(score[4])).toFixed(3);
  });
  document.getElementById('prprod').value = tempcosto;
  
  if (tempcosto == '')
  {
    document.getElementById('ivaprod').value = '';
  }


//volver a mostrar el que se borro
//document.getElementById("fingre" + id).style.display = '';
//document.getElementById("cingre" + id).value = '';
if (arregloasignados.length != 0)
{
var index = arregloasignados.indexOf(id.toString());
if (index > -1) { // only splice array when item is found
  arregloasignados.splice(index, 1); // 2nd parameter means remove one item only
}
}
regenerar_ingredientesasignar();

calcular_precioiva();
}
}


function agregar_producto(id)
{
idfinal = id.replace("prod", "");

//esconderfila
if (document.getElementById("cantprod" + idfinal).value == "" || document.getElementById("cantprod" + idfinal).value <= 0)
{
  Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese una cantidad al producto : ' + document.getElementById("npprod" + idfinal).innerText
              }).then(function() {
                document.getElementById("cantprod" + idfinal).focus();
              });

}
else
{
//document.getElementById("nprod" + idfinal).style.display = 'none';

arregloproductos.push(idfinal);

tempprods.push(idfinal, document.getElementById("npprod" + idfinal).innerHTML, (document.getElementById("catprod" + idfinal).innerHTML).trim(), document.getElementById("cantprod" + idfinal).value, document.getElementById("descprod" + idfinal).innerHTML, (document.getElementById("url2prod" + idfinal).value).trim(), (document.getElementById("precioprod" + idfinal).innerHTML*document.getElementById("cantprod" + idfinal).value), document.getElementById("precioprod" + idfinal).innerHTML);

totalprods.push(tempprods);

tempprods = [];

// fill secondary table
ingasig = ''; //global
$('#productosasignados').html('');

ingasig += 'PRODUCTOS SELECCIONADOS : <br><table class="table table-bordered table-light table-hover" id="fproductostable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>NOMBRE</th><th>CATEGORIA</th><th>CANTIDAD</th><th>PRECIO</th><th>PRECIO T</th><th>DESCRIPCION</th><th>IMAGEN</th><th>-</th></thead></thead><tr>';


funcion = 'quitar_producto(this.id)';

total_acumsubs = 0;

totalprods.forEach((score) => {
  ingasig += '<tr id="qprod' + score[0] + '"><td>' + score[1] + '</td><td>' + score[2] + '</td><td>' + score[3] + '</td><td>' + score[7] + '</td><td>' + score[6] + '</td><td>' + score[4] + '</td><td><img src="images/productos/' + score[5] + '" style="width:25px;height:25px" title="' + score[5] + '" ></td><td class="bg-danger" id="' + score[0] + '" onClick="' + funcion + '">-</td></tr>';
  //acumular el total de subproducto antes del recalculo
  total_acumsubs = total_acumsubs + score[6];
});

ingasig += '</table>' ;

$('#productosasignados').html(ingasig);

//console.log(totalprods);
regenerar_productosasignar();

// cambio para agregar al calculo el sub producto  
calcular_precioiva();


}

}

function regenerar_productosasignar()
{
  var usuario = sessionStorage.getItem('currentloggedin');


  if (arregloproductos.length == 0)
  {
    var temparr = '';
  }
  else
  {
    var temparr = arregloproductos;
  }

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           productosasignar: temparr,
           usuario: usuario,
           estado: 'regenerar_productosasignar'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#productosasignar').html('');
          $('#productosasignar').html(r);
          
      }
      });

}

function quitar_producto(id)
{
//remueve por indice la linea y la vuelve a crear

 for (var i=0; i < totalprods.length; ++i) {
    if (totalprods[i][0] == id) {
       total_acumsubs = total_acumsubs - totalprods[i][6]; //get value from subproduct to sum to the product
       totalprods.splice(i, 1);
    }
  }

  if (totalprods != [])
  {
  //redraw
  // fill secondary table
  ingasig = ''; //global
  $('#productosasignados').html('');

  ingasig += 'PRODUCTOS SELECCIONADOS : <br><table class="table table-bordered table-light table-hover" id="fproductostable2"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>NOMBRE</th><th>CATEGORIA</th><th>CANTIDAD</th><th>PRECIO</th><th>PRECIO T</th><th>DESCRIPCION</th><th>IMAGEN</th><th>-</th></thead></thead><tr>';


  funcion = 'quitar_producto(this.id)';


  totalprods.forEach((score) => {
    ingasig += '<tr id="qprod' + score[0] + '"><td>' + score[1] + '</td><td>' + score[2] + '</td><td>' + score[3] + '</td><td>' + score[7] + '</td><td>' + score[6] + '</td><td>' + score[4] + '</td><td><img src="images/productos/' + score[5] + '" style="width:25px;height:25px" title="' + score[5] + '" ></td><td class="bg-danger" id="' + score[0] + '" onClick="' + funcion + '">-</td></tr>';
    //acumular el total de subproducto antes del recalculo
    // if (total_acumsubs != 0)
    // {
    // total_acumsubs = total_acumsubs - score[6];
    // }
  });

  //console.log(total_acumsubs);

  ingasig += '</table>' ;


  $('#productosasignados').html(ingasig);




//volver a mostrar el que se borro
//document.getElementById("nprod" + id).style.display = '';
//document.getElementById("cantprod" + id).value = '';
if (arregloproductos.length != 0)
{
var index = arregloproductos.indexOf(id.toString());
if (index > -1) { // only splice array when item is found
  arregloproductos.splice(index, 1); // 2nd parameter means remove one item only
}
}
regenerar_productosasignar();

//console.log(totalprods);

// cambio para agregar al calculo el sub producto  
calcular_precioiva();

}
}


// BUSQUEDA SIN QUERY, SOLO DE LA TABLA
// filtro sin volver a cargar
function filtrar_priv1() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("privb1");
  filter = input.value.toUpperCase();
  table = document.getElementById("privs1");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

// BUSQUEDA SIN QUERY, SOLO DE LA TABLA
// filtro sin volver a cargar
function filtrar_priv2() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("privb2");
  filter = input.value.toUpperCase();
  table = document.getElementById("privs2");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
// BUSQUEDA SIN QUERY, SOLO DE LA TABLA
// filtro sin volver a cargar
function buscar_usuario_grupoab() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("usuarioab");
  filter = input.value.toUpperCase();
  table = document.getElementById("privs3");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("button")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
        $('#listprivilegios').html('');
         $('#listprivilegios2').html('');
}

function filtrar_proveedor() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("fprov");
  filter = input.value.toUpperCase();
  table = document.getElementById("listprov");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2]; // filtra PROVEEDOR
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function filtrar_cliente() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("fcliente");
  filter = input.value.toUpperCase();
  table = document.getElementById("listclientes");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[5]; ///filtra DUI
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function filtrar_ingre1() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("fingreb1");
  filter = input.value.toUpperCase();
  table = document.getElementById("fingredientestable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; // filtra INGREDIENTE
    // td2 = tr[i].getElementsByTagName("td")[1]; // filtra INGREDIENTE
    // console.log(td2);   
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }

    }
  }
}

function filtrar_producto() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("fproducto");
  filter = input.value.toUpperCase();
  table = document.getElementById("listproductos");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2]; // filtra PROVEEDOR
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}



// var table = document.getElementById("fingredientestable");
// for (var i = 0, row; row = table.rows[i]; i++) 
// {
//   for (var j = 0, col; col = row.cells[j]; j++) {
//     const inputElement = col.querySelector('input');
//     //just in case there's no input element inside the td
//     if (inputElement !== null){
//        const value = inputElement.value;
//        console.log( value );
//        inputElement.style.display = "none" ;
//     }        
//   }  
// }


function filtrar_ingre2() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("fingreb2");
  filter = input.value.toUpperCase();
  table = document.getElementById("fingredientestable2");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; // filtra INGREDIENTE
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function guardar_unidad()
{
  if (document.getElementById('nuni').value == '')
  {
    document.getElementById('nuni').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar una unidad de medida'
              }).then(function() {
                
              });
  }
  else
  {
    //guardar mod
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           unidad: document.getElementById('nuni').value,
           estado: 'guardar_unidad'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos Guardados!'
            }).then(function() {});

            redraw_unidades();
            document.getElementById('nuni').value = '';
            document.getElementById('nuni').focus();
          } else
          {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La unidad ya existe!'
              }).then(function() {
                document.getElementById('nuni').focus();
              });
          }
        }
      });
  }
}

function redraw_unidades()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_unidades'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#unidadesexistentes').html('');
          $('#unidadesexistentes').html(r);
          
      }
      });

}

function redraw_catexistentes()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_catexistentes'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#spanasignados').html('');
          $('#catexistentes_asignados').html('');
          $('#catexistentes_asignar').html('');
          $('#catexistentes').html('');
          $('#catexistentes').html(r);
          
      }
      });

}

function borrar_unidad(id)
{
  idfinal = id.replace("borraru_", "");

  var r = confirm("Desea borrar la Unidad de medida?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            unidad: idfinal,
            estado: 'borrar_unidad'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Unidad borrada!'
            }).then(function() {});
          }
        });  
        redraw_unidades();    
      }
  }

  function guardar_categoria()
{

  var files = document.getElementById("fcat").files;

if (document.getElementById('ncat').value == '')
  {
    document.getElementById('ncat').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar una Categoria'
              }).then(function() {    
              });
  }
  else if (files[0] == undefined )
  {
  document.getElementById('fcat').focus();
  Swal.fire({
              icon: 'error',
              title: 'Error...',
              text: 'Debe Seleccionar una imagen (Maximo 16Px)'
            }).then(function() {
              
            });
  } 
  else
  {
    filen = files[0].name;
    //guardar mod
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           filecat: filen,
           cat: document.getElementById('ncat').value,
           estado: 'guardar_categoria'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos Guardados!'
            }).then(function() {});

            redraw_categoria();
            document.getElementById('ncat').value = '';
            document.getElementById('ncat').focus();
            uploadFile2();
          } else
          {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La categoria ya existe!'
              }).then(function() {
                document.getElementById('ncat').focus();
              });
          }
        }
      });
  }
}

function uploadFile2() {

var files = document.getElementById("fcat").files;


if(files.length == 1 ){

  var formData = new FormData();
  formData.append("file", files[0]);

  var xhttp = new XMLHttpRequest();

  // Set POST method and ajax file path
  xhttp.open("POST", "ajaxfileenvio2.php", true);

  // call on request changes state
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = this.responseText;
        if(response == 1){
          //alert("Upload successfully.");
        }else{
          alert("Problemas al subir Imagen.");
        }
      }
  };

  // Send request with data
  xhttp.send(formData);
  
}else{
  alert("Por favor seleccione una imagen");
}

}

function redraw_categoria()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_categoria'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#categoriasexistentes').html('');
          $('#categoriasexistentes').html(r);
          //por si guardo una cat, redibujat tambien el manto
          redraw_catexistentes();  
      }
      });

}

function mod_cat(id)
{
  idfinal = id.replace("modcat_", "");

  var r = confirm("Desea modificar la Categoria? (esto modificara todos los productos existentes)");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            cat: idfinal,
            nuevon: document.getElementById('nombrecat_' + idfinal).value,
            estado: 'modificar_categoria'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Categoria modificada!'
            }).then(function() {});
          }
        });  
        redraw_catexistentes(); 
        redraw_barcocina();
        redraw_categoria();  
 
      }
}

function mod_subcat(id)
{
  idfinal = id.replace("modsubcat_", "");

  var r = confirm("Desea modificar la SubCategoria? (esto modificara todos los productos existentes)");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            cat: idfinal,
            nuevon: document.getElementById('nombresubcat_' + idfinal).value,
            estado: 'modificar_subcategoria'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'SubCategoria modificada!'
            }).then(function() {});
          }
        });  
        redraw_catexistentes(); 
        redraw_scategoria();
        redraw_barcocina();
        redraw_categoria();  
 
      }
}

function mod_unidad(id)
{
  idfinal = id.replace("modunidad_", "");

  var r = confirm("Desea modificar la Unidad? (esto modificara todas las unidades ya asignadas)");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            idunidad: idfinal,
            nuevounidad: document.getElementById('nombreunidad_' + idfinal).value,
            estado: 'modificar_unidad'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Unidad modificada!'
            }).then(function() {});
          }
        });  
       redraw_unidades(); 
      }
}

function borrar_cat(id)
{
  idfinal = id.replace("borrarcat_", "");

  var r = confirm("Desea borrar la Categoria y Menus asociadas?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            cat: idfinal,
            estado: 'borrar_categoria'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Categoria borrada!'
            }).then(function() {});
          }
        });  
        redraw_categoria();    
      }
  }

  function guardar_scategoria()
{
  if (document.getElementById('nscat').value == '')
  {
    document.getElementById('nscat').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un nombre de MENU'
              }).then(function() {
                
              });
  }
  else
  {
    //guardar mod
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           scat: document.getElementById('nscat').value,
           estado: 'guardar_scategoria'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos Guardados!'
            }).then(function() {});

            redraw_scategoria();
            document.getElementById('nscat').value = '';
            document.getElementById('nscat').focus();
          } else
          {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'El MENU ya existe!'
              }).then(function() {
                document.getElementById('nscat').focus();
              });
          }
        }
      });
  }
}


function borrar_scat(id)
{
  idfinal = id.replace("borrarscat_", "");

  var r = confirm("Desea borrar el MENU?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "inter_acciones.php",
          datatype: "html",
          data: {
            scat: idfinal,
            estado: 'borrar_scategoria'
          },
          beforeSend: function() {

          },
          success: function(r) {
            Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'MENU borrado!'
            }).then(function() {});
          }
        });  
        redraw_scategoria();    
      }
  }

function redraw_scategoria()
{
  var usuario = sessionStorage.getItem('currentloggedin');

  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'redraw_scategoria'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#scategoriasexistentes').html('');
          $('#scategoriasexistentes').html(r);
         //por si guardo una cat, redibujat tambien el manto
         redraw_catexistentes();  
      }
      });

}

function guardar_empresa()
{
  var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; //para email

  if (document.getElementById('codempresa').value == '')
  {
    document.getElementById('codempresa').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un codigo de empresa'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('nomcomercial').value == '')
  {
    document.getElementById('nomcomercial').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un nombre comercial'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('razonsocial').value == '')
  {
    document.getElementById('razonsocial').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese una razon social'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('dir').value == '')
  {
    document.getElementById('dir').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese una direccion'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('nit').value == '')
  {
    document.getElementById('nit').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un NIT'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('iva').value == '')
  {
    document.getElementById('iva').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese IVA'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('caja').value == '')
  {
    document.getElementById('caja').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un numero de CAJA'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('mensaje').value == '')
  {
    document.getElementById('mensaje').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un mensaje'
              }).then(function() {
                
              });
  }
  else if (document.getElementById('correonoti').value == '' || document.getElementById('correonoti').value.match(validRegex) == null)
  {
    document.getElementById('correonoti').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Email Invalido u obligatorio'
              }).then(function() {
                
              });

  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           codempresa: document.getElementById('codempresa').value,
           nomcomercial: document.getElementById('nomcomercial').value,
           razonsocial: document.getElementById('razonsocial').value,
           dir: document.getElementById('dir').value,
           nit: document.getElementById('nit').value,
           iva: document.getElementById('iva').value,
           giro: document.getElementById('giro').value,
           caja: document.getElementById('caja').value,
           mensaje: document.getElementById('mensaje').value,
           correonoti: document.getElementById('correonoti').value,
           correonoticc: document.getElementById('correonoticc').value,
           estado: 'guardar_empresa'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos Modificados!'
            }).then(function() {});
          }          
       }
      });
  }

}

function guardar_iva_global()
{
  if (document.getElementById('ivaprod').value <= 0)
  {
    document.getElementById('ivaprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de IVA invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           ivaprod: document.getElementById('ivaprod').value,
           estado: 'guardar_iva'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'IVA actualizado!'
            }).then(function() {});
          }          
       }
      });
  }

}


function guardar_propina_global()
{
  if (document.getElementById('propinaprod').value < 0)
  {
    document.getElementById('propinaprod').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de propina invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           ivaprod: document.getElementById('propinaprod').value,
           estado: 'guardar_propina'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Propina actualizada!'
            }).then(function() {});
          }          
       }
      });
  }

}

function guardar_bloqueomesa_global()
{
  if (document.getElementById('bloqueomesa').value <= 0)
  {
    document.getElementById('bloqueomesa').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de mins invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           bloqueo: document.getElementById('bloqueomesa').value,
           estado: 'guardar_bloqueomesa'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Tiempo de bloqueo de Mesa actualizado!'
            }).then(function() {});
          }          
       }
      });
  }

}

function guardar_mesarefresh_global()
{
  if (document.getElementById('refreshmesa').value <= 0)
  {
    document.getElementById('refreshmesa').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de mins invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           refreshmesa: document.getElementById('refreshmesa').value,
           estado: 'refresh_mesa'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Tiempo de refrescamiento de mesas actualizado!'
            }).then(function() {});
          }          
       }
      });
  }

}

function guardar_barrefresh_global()
{
  if (document.getElementById('refreshbar').value <= 0)
  {
    document.getElementById('refreshbar').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de mins invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           refreshbar: document.getElementById('refreshbar').value,
           estado: 'refresh_bar'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Tiempo de refrescamiento de bar actualizado!'
            }).then(function() {});
          }          
       }
      });
  }

}

function guardar_cocinarefresh_global()
{
  if (document.getElementById('refreshcocina').value <= 0)
  {
    document.getElementById('refreshcocina').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de mins invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           refreshcocina: document.getElementById('refreshcocina').value,
           estado: 'refresh_cocina'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Tiempo de refrescamiento de cocina actualizado!'
            }).then(function() {});
          }          
       }
      });
  }

}

function guardar_maxbar_global()
{
  if (document.getElementById('maxbar').value <= 0)
  {
    document.getElementById('maxbar').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de mins invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           tmaxbar: document.getElementById('maxbar').value,
           estado: 'max_bar'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Tiempo de maximo en bar actualizado!'
            }).then(function() {});
          }          
       }
      });
  }

}

function guardar_maxcocina_global()
{
  if (document.getElementById('maxcocina').value <= 0)
  {
    document.getElementById('maxcocina').focus();
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Valor de mins invalido'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           tmaxcocina: document.getElementById('maxcocina').value,
           estado: 'max_cocina'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Tiempo de maximo en cocina actualizado!'
            }).then(function() {});
          }          
       }
      });
  }

}

function filtrar_ingredientes() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("fingrediente");
  filter = input.value.toUpperCase();
  table = document.getElementById("listingredientes");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2]; // filtra INGREDIENTE
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function filtrar_subingredientes() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("buscarsub");
  filter = input.value.toUpperCase();
  table = document.getElementById("listsubingredientest");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1]; // filtra INGREDIENTE
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function filtraringreb() {
  //REFRESCAR EL GRID 28-4-2024
  regenerar_ingredientesasignar_noasync();

  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("buscaingre");
  filter = input.value.toUpperCase();
  table = document.getElementById("fingredientestable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; // filtra INGREDIENTE
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function qfiltraringreb() 
{
  document.getElementById("buscaingre").value = '';
  filtraringreb();
}


function filtrarprodb() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("buscaprod");
  filter = input.value.toUpperCase();
  table = document.getElementById("fproductostable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; // filtra INGREDIENTE
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function qfiltrarprodb() 
{
  document.getElementById("buscaprod").value = '';
  filtrarprodb();
}
// AQUI TODOS LOS EVENTOS KEYPRESS DE CONFIGS
// keypress que son enter
function filtraringreb_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtraringreb();
  }
}

function filtrarprodb_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrarprodb();
  }
}

function checkdistzona(id)
{
  if (id == "distzonas1")
  {
  document.getElementById(id).style.backgroundColor = 'lightgreen';
  document.getElementById("distzonas2").style.backgroundColor = 'white';
  document.getElementById("distzonas3").style.backgroundColor = 'white';
  document.getElementById("distzonas4").style.backgroundColor = 'white';
  }
  else if (id == "distzonas2")
  {
  document.getElementById(id).style.backgroundColor = 'lightgreen';
  document.getElementById("distzonas1").style.backgroundColor = 'white';
  document.getElementById("distzonas3").style.backgroundColor = 'white';
  document.getElementById("distzonas4").style.backgroundColor = 'white';
  }
  else if (id == "distzonas3")
  {  
    document.getElementById(id).style.backgroundColor = 'lightgreen';
  document.getElementById("distzonas1").style.backgroundColor = 'white';
  document.getElementById("distzonas2").style.backgroundColor = 'white';
  document.getElementById("distzonas4").style.backgroundColor = 'white';
  }
  else if (id == "distzonas4")
  {
    document.getElementById(id).style.backgroundColor = 'lightgreen';
  document.getElementById("distzonas1").style.backgroundColor = 'white';
  document.getElementById("distzonas2").style.backgroundColor = 'white';
  document.getElementById("distzonas3").style.backgroundColor = 'white';

  }


}

function moverazona(id)
{
  
 if (document.getElementById("distzonas1").style.backgroundColor == 'lightgreen')
 {
  agregar_azona(1, id);
 }
 else if (document.getElementById("distzonas2").style.backgroundColor == 'lightgreen')
 {
  agregar_azona(2, id);
 }
 else if (document.getElementById("distzonas3").style.backgroundColor == 'lightgreen')
 {
  agregar_azona(3, id);
 }
 else if (document.getElementById("distzonas4").style.backgroundColor == 'lightgreen')
 {
  agregar_azona(4, id);
 }
 else
 {
  Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'De click en un area antes de agregar una Zona'
              }).then(function() {
                
              });

 }
}

function agregar_azona(num, id) // num es el area y id es la zona
{
  idfinal = id.replace("MQZ", "");

  // const box = document.createElement("button");
  // box.innerHTML = "ZONA # " + idfinal;
  // box.id = id;
  // box.type = "button";
  // box.addEventListener("click", quitar_azona(id), false);
  // //box.MyParam = id;
    
  // document.getElementById("distzonas" + num).appendChild(box);
  // document.getElementById("distzonas" + num).appendChild(document.createElement("br"));  

  $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           area: num,
           zona: idfinal,
           estado: 'guardar_area_zona'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
            document.getElementById("distzonas" + num).innerHTML +=  '<button type="button"  id="MQZ' + idfinal + '" onclick="quitar_azona(this.id)">ZONA # ' + idfinal + ' </button><br>';
 
            var elem = document.getElementById(id);
            elem.parentNode.removeChild(elem);  
          }          
       }
      });
}

function quitar_azona(id)
{
  idfinal = id.replace("MQZ", "");
  //llamar ya guardados
  $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           zona: idfinal,
           estado: 'borrar_area_zona'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r==0)
          {
          //borrar de DB y refrescar el menu de zonas
          var elem = document.getElementById(id);
          elem.parentNode.removeChild(elem);  
          redraw_areas_zonas();
         }          
       }
      });

}

function adquirir_azonas()
{
  $.ajax({
        type: "POST",
        url: "inter_acciones.php",
        datatype: "html",
        data: {
           estado: 'adquirir_azonas1'
        },
        beforeSend: function() {
        },
        success: function(r) {
          var data = jQuery.parseJSON(r);
          document.getElementById("distzonas1").innerHTML = '';
          document.getElementById("distzonas2").innerHTML = '';
          document.getElementById("distzonas3").innerHTML = '';
          document.getElementById("distzonas4").innerHTML = '';

          for (var i = 0; i < data[0].length; i++) {          
            if (data[0][i] == 1)
            {              
             document.getElementById("distzonas" + data[0][i]).innerHTML +=  '<button type="button"  id="MQZ' + data[1][i] + '" onclick="quitar_azona(this.id)">ZONA # ' + data[1][i] + ' </button><br>';
            }
            else if (data[0][i] == 2)
            {
              document.getElementById("distzonas" + data[0][i]).innerHTML +=  '<button type="button"  id="MQZ' + data[1][i] + '" onclick="quitar_azona(this.id)">ZONA # ' + data[1][i] + ' </button><br>'; 
            }
            else if (data[0][i] == 3)
            {
              document.getElementById("distzonas" + data[0][i]).innerHTML +=  '<button type="button"  id="MQZ' + data[1][i] + '" onclick="quitar_azona(this.id)">ZONA # ' + data[1][i] + ' </button><br>'; 
            }
            else if (data[0][i] == 4)
            {
              document.getElementById("distzonas" + data[0][i]).innerHTML +=  '<button type="button"  id="MQZ' + data[1][i] + '" onclick="quitar_azona(this.id)">ZONA # ' + data[1][i] + ' </button><br>'; 
            }
          }
       }
      });
}

function redraw_areas_zonas()
{
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
        //   zona: idfinal,
           usuario: sessionStorage.getItem('currentloggedin'),
           estado: 'redraw_areas_zonas'
        },
        beforeSend: function() {
        },
        success: function(r) {
            $('#mapzon').html('');
            $('#mapzon').html(r);         
       }
      });
}

function agregar_abar(id)
{
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           categoria: id,
           usuario: sessionStorage.getItem('currentloggedin'),
           estado: 'agregar_abar'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r == 0)
          {
          redraw_barcocina();
          }
       }
      });
}

function agregar_acocina(id)
{
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           categoria: id,
           usuario: sessionStorage.getItem('currentloggedin'),
           estado: 'agregar_acocina'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r == 0)
          {
          redraw_barcocina();
          }
       }
      });
}

function quitar_barcocina(id)
{
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           categoria: id,
           usuario: sessionStorage.getItem('currentloggedin'),
           estado: 'quitar_barcocina'
        },
        beforeSend: function() {
        },
        success: function(r) {
          if (r >= 0)
          {
          redraw_barcocina();
          }
       }
      });
}

function redraw_barcocina()
{
  $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "JSON",
        data: {
           usuario: sessionStorage.getItem('currentloggedin'),
           estado: 'redraw_barcocina'
        },
        beforeSend: function() {
        },
        success: function(r) {
          var data = jQuery.parseJSON(r);
            $('#catbarcocina').html(data[0]);
            $('#catbar').html(data[1]);
            $('#catcocina').html(data[2]);                   
       }
      });

}

function guardar_cover()
{
  if (document.getElementById('cover').value < 0)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un valor valido de Cover'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: sessionStorage.getItem('currentloggedin'),
           ecover: document.getElementById('estadocover').checked,
           cover: document.getElementById('cover').value,
           cdiasLu: document.getElementById('cdiasLu').checked,
           cdiasMa: document.getElementById('cdiasMa').checked,
           cdiasMi: document.getElementById('cdiasMi').checked,
           cdiasJu: document.getElementById('cdiasJu').checked,
           cdiasVi: document.getElementById('cdiasVi').checked,
           cdiasSa: document.getElementById('cdiasSa').checked,
           cdiasDo: document.getElementById('cdiasDo').checked,
           cdesdem: document.getElementById('cdesdem').value,
           chastam: document.getElementById('chastam').value,
           estado: 'guardar_cover'
        },
        beforeSend: function() {
        },
        success: function(r) {    
          config_empresa();  
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos de Cover actualizados!'
            }).then(function() {});         
        }
      });
  }
}

function guardar_consumo()
{
  if (document.getElementById('consumo').value < 0)
  {
    Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ingrese un valor valido de Consumo minimo'
              }).then(function() {
                
              });
  }
  else
  {
    $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: sessionStorage.getItem('currentloggedin'),
           econsumo: document.getElementById('estadoconsumo').checked,
           consumo: document.getElementById('consumo').value,
           cmdiasLu: document.getElementById('cmdiasLu').checked,
           cmdiasMa: document.getElementById('cmdiasMa').checked,
           cmdiasMi: document.getElementById('cmdiasMi').checked,
           cmdiasJu: document.getElementById('cmdiasJu').checked,
           cmdiasVi: document.getElementById('cmdiasVi').checked,
           cmdiasSa: document.getElementById('cmdiasSa').checked,
           cmdiasDo: document.getElementById('cmdiasDo').checked,
           cmdesdem: document.getElementById('cmdesdem').value,
           cmhastam: document.getElementById('cmhastam').value,
           estado: 'guardar_consumo'
        },
        beforeSend: function() {
        },
        success: function(r) {    
          config_empresa();  
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              text: 'Datos de Consumo Minimo actualizados!'
            }).then(function() {});         
        }
      });
  }
}

function filtrar_ingredientes_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_ingredientes();
  }
}

function filtrar_subingredientes_key(e) 
{
  filtrar_subingredientes();
}

function buscar_usuario_grupoab_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  buscar_usuario_grupoab();
  }
}

function filtrar_ingre1_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_ingre1();
  }
}

function filtrar_producto_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_producto();
  }
}

function filtrar_ingre2_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_ingre2();
  }
}

function filtrar_priv1_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_priv1();
  }
}

function filtrar_priv2_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_priv2();
  }
}


function filtrar_proveedor_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_proveedor();
  }
}

function filtrar_clientes_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_cliente();
  }
}
// botones miscelanios
/// boton regresar
function regresar()
{
  window.location = "main_page.php";
}

/// boton regresar
function regresar_config()
{
  totalingres = [];
  configs();
}


</script>

