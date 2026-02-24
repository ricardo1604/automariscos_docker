<script>
// todo lo referente a comanda

function crear_submenus(id)
{
   if (document.getElementById('mesaactual').innerText == 'llevar')
   {
      document.getElementById('numpersonas').value = 1;
   }
//AGREGAR VAL
if (document.getElementById('numpersonas').value > 0)
{
 var usuario = sessionStorage.getItem('currentloggedin');
 $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          cat: id,
          estado: 'tab_submenu'
       },
       beforeSend: function() {
       },
       success: function(r) {
        $('#submenus').html('');
        $('#submenus').html(r);
        innerprods = r; 
        
     }
     });
   }
   else
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione el numero de personas en la mesa'
              }).then(function() {
              });  
   }
}

function mostrar_prodsselec(id)
{
 var usuario = sessionStorage.getItem('currentloggedin');
 $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          subcat: id,
          estado: 'tab_prodsselec'
       },
       beforeSend: function() {
       },
       success: function(r) {
        //$('#submenus').html('');
        $('#submenus').html(innerprods + r);

     }
     });
}

function actualizar_timer()
{   
   tiempo++
   tiempom = Math.floor((tiempo / 60));
   tiempos = tiempo % 60;
   tiempoact = tiempom*60000;
   tiempobloq = Number(document.getElementById('tiempobloqueos').innerText)*60000;
    
   if (tiempom < 10)
   {
     document.getElementById('elapsedtime').innerText = '0' + tiempom;
   }
   else
   {
      document.getElementById('elapsedtime').innerText = tiempom;
   }
   if (tiempos < 10)
   {
     document.getElementById('elapsedtimes').innerText = '0' + tiempos;
   }
   else
   {
      document.getElementById('elapsedtimes').innerText = tiempos;
   }
    // si se pasa del tiempo de bloqueo
   if (tiempoact > tiempobloq)
   {
      document.getElementById('transcurrido').style.backgroundColor = 'red';
    //  document.getElementById('transcurrido').innerText += ' Se cerrara su comanda pronto por inactividad';
   }
   else
   {
      document.getElementById('transcurrido').style.backgroundColor = '';
   }
   
}


function seleccionar_mesa(mesa, flag)
{
   if (sessionStorage.getItem('currentloggedin') == 'ADMIN' &&  document.getElementById('logeoadmin').style.backgroundColor != 'green')
   {

   document.getElementById('logeoadmin').style.backgroundColor = 'green'
   document.getElementById('logeoadmin').innerText = 'ADMIN';
   usuario_comandatmp = 'MESEROS';
   }

   //verificar si es submesa
   mesa_de_parent = 0;
   // find if its a submesa, if so then pick parent mesa always
   //const mesa = 21; // Assuming the mesa value is 21
   const elementId = 'smesa_' + mesa;
   const element = document.getElementById(elementId);

   //let numberInParentheses = null;
   if (element) {
   const labelElement = element.querySelector('label');
   const labelText = labelElement.innerText;

   const pattern = /\((\d+)\)/;
   const match = labelText.match(pattern);

   if (match) {
      mesa_de_parent = 1;
      mesa = match[1];
   }
   }
   //after this if it was a sub mesa then it will get mesa parent
 

 if (usuario_comanda == '')  
 { // SI EL mesero ESTA VACIO
   document.getElementById('myModalusuariocomanda').style.display = '';
   document.getElementById('usermesero').focus();    
 }
 else
 {
   if (mesa_de_parent == 1)
   {
      Swal.fire({
      icon: 'info',
      title: 'Mesa Unida...',
      text: 'Se Selecciono la mesa principal : ' + mesa,
      timer: 1500, 
      showConfirmButton: false
         });
   }
  // LOGICA DE RETIRAR LA DATA 
  var usuario = sessionStorage.getItem('currentloggedin');
      $.ajax({
       type: "POST",
       async: false,
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          mesa: mesa,
          estado: 'buscar_orden_pendiente'
       },
       beforeSend: function() {
       },
       success: function(r) {
       var data = JSON.parse(r);
       document.getElementById('ordenactual').innerText = 0;
       if (data[0] != 0)
       {
       //ENCONTRANDO ORDEN LLENAR TODO
       document.getElementById('ordenactual').innerText = data[0];
       listado_comanda = data[1];
               listado_comanda.forEach(function(element) {
               if (cuentas_comanda.includes(element[0].trim()) == true)
               {
               } 
               else
               {
                  cuentas_comanda.push(element[0]);
               }
              });
              if (cuentas_comanda)
              {
              agregar_subcuenta_delineas();     
              }
       //copia de listado comanda para tener el original solo para comparar en codigo
             
       listado_comandaori  = JSON.parse(JSON.stringify(listado_comanda));

       dui_comanda = data[2];
       document.getElementById('smesaactual').value = data[3];
       //llenar sub mesas cuenta
       const strtmp = document.getElementById('smesaactual').value;
       const valuestmp = strtmp.split(",");

       mesas_unidas = [];
       for (let i = 0; i < valuestmp.length; i++) {
        mesas_unidas.push(valuestmp[i]);
       }

       document.getElementById('clientecid').value = data[4];       
       document.getElementById('numpersonas').value = data[5];    
       }
       seleccionarfinal_mesa(mesa, flag);
       }
       });

       //DESHABILITAR BOTONES QUE NO TIENEN PERMISOS BASADO EN MESERO
       //usuario de sesion y usuario mesero, le da prioridad si es ADMIN
       deshabilitar_opciones(usuario,document.getElementById('usermesero').value);
       refrescar_comanda_principal();

       seleccionar_cuenta_principal();
      }
}

function deshabilitar_opciones(usuariosesion, usuariomesero)
{
 //usuario de sesion y usuario mesero, le da prioridad si es ADMIN
//    if (usuariosesion == 'ADMIN')
//   {
//    document.getElementById('precuenta').disabled = false;
//    document.getElementById('dividircuentas').disabled = false;
//   }
//   else
//   {
     
       if (usuariosesion == 'ADMIN')
       {
         usuariomesero = 'ADMIN';
       }


       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuariomesero,
          estado: 'permisos_comanda'
       },
       beforeSend: function() {
       },
       success: function(r) {
         var data = JSON.parse(r);
         if (data[0] == 1) //PRE CUENTA
         {
            document.getElementById('precuenta').disabled = false;
            document.getElementById('precuenta').hidden = false;
         }
         else
         {
            document.getElementById('precuenta').disabled = true;
            document.getElementById('precuenta').hidden = true;
         }
         if (data[1] == 1) // DIVIDIR CUENTAS
         {
            document.getElementById('dividircuentas').disabled = false;
            document.getElementById('dividircuentas').hidden = false;
         }
         else
         {
            document.getElementById('dividircuentas').disabled = true;
            document.getElementById('dividircuentas').hidden = true;
         }
         if (data[2] == 1) // DIVIDIR CUENTAS
         {
            document.getElementById('cortesia').disabled = false;
            document.getElementById('cortesia').hidden = false;
         }
         else
         {
            document.getElementById('cortesia').disabled = true;
            document.getElementById('cortesia').hidden = true;
         }
         if (data[3] == 1) // DIVIDIR CUENTAS
         {
            document.getElementById('imprimir_pre').disabled = false;
            document.getElementById('imprimir_pre').hidden = false;
         }
         else
         {
            document.getElementById('imprimir_pre').disabled = true;
            document.getElementById('imprimir_pre').hidden = true;
         }
       }
       });
 // }
}

function seleccionarfinal_mesa(mesa , flag)
{
 //flag = 0;
  // CLICK ALA CUENTA PRINCIPAL
 buscar_cliente_primera(); //solo para que se genere por primera vez
 document.getElementById('cuentaprincipal').click();

 document.getElementById('elapsedtime').innerText = 0;
 document.getElementById('elapsedtimes').innerText = 0;
 tiempo = 0;
 //actualizar_colores();  
 //iniciar contador
 clearInterval(tiemporun);
 if (document.getElementById('ordenactual').innerText == 0)
 {
 tiemporun = setInterval( function() { actualizar_timer(); }, 1000);
 }
 mesaval = "mesa_" + mesa;
 if (usuario_comanda == '')  
 { // SI EL mesero ESTA VACIO
              document.getElementById('myModalusuariocomanda').style.display = '';
              document.getElementById('usermesero').focus();              
 }
 else
 {
 $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          mesa: mesa,
          usuario: usuario_comanda,
          estado: 'bloquear_la_mesa'
       },
       success: function(r) {
         if (r==1){
         document.getElementById('mesaactual').innerText = mesa;
         var modal = document.getElementById("myModalcomanda");
         modal.style.display = "none";
         }
         else if (r == 0)
         {
            if (document.getElementById(mesaval).title.includes(document.getElementById('meseroact').value) == false && flag == 0)
            {
            Swal.fire({
                icon: 'info',
                title: 'MESA #' + mesa,
                text: 'Ocupada por el ' + document.getElementById(mesaval).title
              }).then(function() {
              });
          }
          else
          {
            document.getElementById('mesaactual').innerText = mesa;
            var modal = document.getElementById("myModalcomanda");
            modal.style.display = "none";
          //  seleccionar_cuenta_principal2();
          }

         }
       }
       }); 

 }
}

function seleccionar_llevar()
{
      // CLICK ALA CUENTA PRINCIPAL
 document.getElementById('cuentaprincipal').click();

document.getElementById('elapsedtime').innerText = 0;
document.getElementById('elapsedtimes').innerText = 0;
tiempo = 0;
//actualizar_colores();  
//iniciar contador
clearInterval(tiemporun);
tiemporun = setInterval( function() { actualizar_timer(); }, 1000);
mesaval = 'llevar';
if (usuario_comanda == '')  
 { // SI EL mesero ESTA VACIO
              document.getElementById('myModalusuariocomanda').style.display = '';
              document.getElementById('usermesero').focus();              
 }
 else
 {
            document.getElementById('mesaactual').innerText = mesaval;
            var modal = document.getElementById("myModalcomanda");
            modal.style.display = "none";
 }

}

function mostrar_catexistentes(id)
{
 var usuario = sessionStorage.getItem('currentloggedin');
 $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          cat: id,
          estado: 'tab_catasignadas'
       },
       beforeSend: function() {
       },
       success: function(r) {
        var data = JSON.parse(r);
        $('#catexistentes_asignados').html('');
        $('#catexistentes_asignados').html(data[0]);
        document.getElementById('spanasignados').innerHTML = "<b style='color:white'>" + id + " </b>";

        $('#catexistentes_asignar').html('');
        $('#catexistentes_asignar').html(data[1]);
        idactualexist = id;
     }
     });
}


function mostrar_imagenprod(id)
{
   var usuario = sessionStorage.getItem('currentloggedin');
   idfinal = id.replace("lupa_", "");
   

   $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          idfinal: idfinal,
          estado: 'tab_productoscontenidos'
       },
       beforeSend: function() {
       },
       success: function(r) {
          if (r == 0)
       {
         Swal.fire({
            icon: 'error',
            title: 'No Hay Productos asignados',
            }).then(function() {
            // You can add some action here
            });

       }
         else
         {
            Swal.fire({
            icon: 'info',
            title: 'Productos :',
            html: r,
            }).then(function() {
            // You can add some action here
            });

         }


         
      }
     });



}

function quitar_scattocat(id)
{
   idfinal = id.replace("bscat_", "");

   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       async: false,
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          scat: idfinal,
          estado: 'tab_borrar_scat'
       },
       beforeSend: function() {
       },
       success: function(r) {
       }
       });
       mostrar_catexistentes(idactualexist);
}


function asignar_scattocat(id)
{
   idfinal = id.replace("ascat_", "");
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       async: false,
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          scat: idfinal, //37
          cat: idactualexist, //PLATOS
          estado: 'tab_asignar_scat'
       },
       beforeSend: function() {
       },
       success: function(r) {
       }
       });
       mostrar_catexistentes(idactualexist);
}

function agregar_subcuenta()
{
   if (document.getElementById('mesaactual').innerText != 'llevar')
{
   if (cuentas_comanda.length == 0)
   {
      cuentas_comanda.push('Principal');
   }

   if (document.getElementById('cliente').value == '')
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un nombre de cliente'
              }).then(function() {
              });
              document.getElementById('cliente').focus();
   }
    else if (cuentas_comanda.includes(document.getElementById('cliente').value.trim()) == true)
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ya existe una cuenta con ese nombre!'
              }).then(function() {
              });
              document.getElementById('cliente').value = '';
              document.getElementById('cliente').focus();
   } //si ya inicio una comanda individual
   else if (cuentas_comanda.length <= 1 && listado_comanda.length > 0)
   {

      Swal.fire({
                icon: 'info',
                title: 'Informacion',
                text: 'Ya comenzo una orden individual, Utilize la opcion de Dividir Cuentas!'
              }).then(function() {
               dividir_cuentas();
              });
   }
   else
   {
      cuentas_comanda.push(document.getElementById('cliente').value);
   }

   //llenar las cuentas
    cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principal(this.id)" id="cuentaprincipal" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';


    cuentas_comanda.forEach(function(element) {
    if (element != 'Principal')
    {
    cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuenta(this.id)"  onClick="seleccionar_cuenta(this.id)" id="cuenta_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
    }
    });

    cuentasllenar += '</tr></table>';

   $('#mesacuentas').html('');
   $('#mesacuentas').html(cuentasllenar);
   document.getElementById('cliente').value = '';
   cambiar_color_cuenta();
   document.getElementById('cliente').focus();
}
else
{
   Swal.fire({
                icon: 'info',
                title: 'Orden',
                text: 'No se pueden crear cuentas separadas cuando es para llevar!'
              }).then(function() {
              });
              document.getElementById('cliente').value = '';
              document.getElementById('cliente').focus();
}
}

function agregar_subcuentatmp()
{
   if (document.getElementById('mesaactual').innerText != 'llevar')
{
   if (cuentas_comandatmp.length == 0)
   {
      cuentas_comandatmp.push('Principal');
   }

   if (document.getElementById('clientetmp').value == '')
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Debe Ingresar un nombre de cliente'
              }).then(function() {
              });
              document.getElementById('clientetmp').focus();
   }
    else if (cuentas_comandatmp.includes(document.getElementById('clientetmp').value.trim()) == true)
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ya existe una cuenta con ese nombre!'
              }).then(function() {
              });
              document.getElementById('clientetmp').value = '';
              document.getElementById('clientetmp').focus();
   } 
   else
   {
      cuentas_comandatmp.push(document.getElementById('clientetmp').value);
   }

   //llenar las cuentas
    cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principaltmp(this.id)" id="cuentaprincipaltmp" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';


    cuentas_comandatmp.forEach(function(element) {
    if (element != 'Principal')
    {
    cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuentatmp(this.id)"  onClick="seleccionar_cuentatmp(this.id)" id="cuentatmp_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
    }
    });

    cuentasllenar += '</tr></table>';

   $('#mesacuentastmp').html('');
   $('#mesacuentastmp').html(cuentasllenar);
   document.getElementById('clientetmp').value = '';
   cambiar_color_cuentatmp();
   document.getElementById('clientetmp').focus();
}
else
{
   Swal.fire({
                icon: 'info',
                title: 'Orden',
                text: 'No se pueden crear cuentas separadas cuando es para llevar!'
              }).then(function() {
              });
}
}

function agregar_subcuenta_delineas()
{
   if (document.getElementById('mesaactual').innerText != 'llevar')
{

   //llenar las cuentas
    cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principal(this.id)" id="cuentaprincipal" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';
    cuentas_comanda.forEach(function(element) {
    if (element != 'Principal')
    {
    cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuenta(this.id)"  onClick="seleccionar_cuenta(this.id)" id="cuenta_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
    }
    });

    cuentasllenar += '</tr></table>';

   $('#mesacuentas').html('');
   $('#mesacuentas').html(cuentasllenar);
   document.getElementById('cliente').value = '';
   cambiar_color_cuenta();
}
}

function limpiar_cuentas()
{
   cuentas_comanda = [];
   cuentas_comanda.push('Principal');

   
   cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principal(this.id)" id="cuentaprincipal" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td></tr></table>';
    
   $('#mesacuentas').html('');
   $('#mesacuentas').html(cuentasllenar);
   document.getElementById('cliente').value = '';
}

function refresh_subcuenta()
{
   if (cuentas_comanda.length == 0)
   {
      cuentas_comanda.push('Principal');
   }

   //llenar las cuentas
    cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principal(this.id)" id="cuentaprincipal" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';


    cuentas_comanda.forEach(function(element) {
    if (element != 'Principal')
    {
    cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuenta(this.id)"  onClick="seleccionar_cuenta(this.id)" id="cuenta_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
    }
    });

    cuentasllenar += '</tr></table>';

   $('#mesacuentas').html('');
   $('#mesacuentas').html(cuentasllenar);
   document.getElementById('cliente').value = '';
   
}

function refresh_subcuentatmp()
{
   if (cuentas_comandatmp.length == 0)
   {
      cuentas_comandatmp.push('Principal');
   }

   //llenar las cuentas
    cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principaltmp(this.id)" id="cuentaprincipaltmp" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';


    cuentas_comandatmp.forEach(function(element) {
    if (element != 'Principal')
    {
    cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuentatmp(this.id)"  onClick="seleccionar_cuentatmp(this.id)" id="cuentatmp_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
    }
    });

    cuentasllenar += '</tr></table>';

   $('#mesacuentastmp').html('');
   $('#mesacuentastmp').html(cuentasllenar);
   document.getElementById('clientetmp').value = '';
}

function quitar_cuenta(id)
{
   Swal.fire({
   icon: 'info',
   title: 'Cancelar eliminar cuenta',
   text: 'Esta seguro que quiere eliminar la cuenta : ' + idfinal,
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
         idfinal = id.replace("cuenta_", "");

         index = cuentas_comanda.indexOf(idfinal);

         x = cuentas_comanda.splice(index, 1);

         refresh_subcuenta();

         remover_productosdecuenta(idfinal); //remover primero los datos de cuenta
         document.getElementById('cuentaprincipal').click();
      }
      });
}

function quitar_cuentatmp(id)
{
   Swal.fire({
   icon: 'info',
   title: 'Cancelar eliminar cuenta',
   text: 'Esta seguro que quiere eliminar la cuenta : ' + idfinal,
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
         idfinal = id.replace("cuentatmp_", "");

         index = cuentas_comandatmp.indexOf(idfinal);

         x = cuentas_comandatmp.splice(index, 1);

         refresh_subcuentatmp();

         remover_productosdecuentatmp(idfinal); //remover primero los datos de cuenta

         // refresh the right and left panel here
         //
         redraw_asignados_noasignados();
         // document.getElementById('cuentaprincipaltmp').click();

         // if (document.getElementById('cuentaseleccionadatmp').value == idfinal)
         // {
         //    document.getElementById('cuentaseleccionadatmp').value ='';
         // }
      }
      });
}

function seleccionar_cuenta(id)
{
  idfinal = id.replace("cuenta_", "");
  cuentaactual = idfinal;
  //DEPENDIENDO DE LA CUENTA LLENAR SUS ELEMENTOS, PRINCIPAL SIEMPRE CARGARA TODO, LAS DEMAS FILTRARAN
  refrescar_comanda_porcuenta();
  cambiar_color_cuenta();
}

function seleccionar_cuentatmp(id)
{
  idfinal = id.replace("cuentatmp_", "");
  cuentaactualtmp = idfinal;
  //DEPENDIENDO DE LA CUENTA LLENAR SUS ELEMENTOS, PRINCIPAL SIEMPRE CARGARA TODO, LAS DEMAS FILTRARAN
  cambiar_color_cuentatmp();
  document.getElementById('cuentaseleccionadatmp').value = idfinal;
  
  redraw_asignados_noasignados();

}

function seleccionar_cuentatmpcortesia(id)
{
  idfinal = id.replace("cuentatmpcort_", "");
  cuentaactualtmp = idfinal;
  //DEPENDIENDO DE LA CUENTA LLENAR SUS ELEMENTOS, PRINCIPAL SIEMPRE CARGARA TODO, LAS DEMAS FILTRARAN
  cambiar_color_cuentatmpcortesia();
  document.getElementById('cuentaseleccionadatmpcortesia').value = idfinal;

  
  redraw_por_cuenta_cortesia();

}

function seleccionar_cuenta_principal()
{
   // aqui entra caja tambien
   cuentaactual = 'Principal';
   if (cuentas_comanda.length > 1)
   {
     refrescar_comanda_principal_suma();
    // refrescar_comanda_principal();
   }
   else
   {
   refrescar_comanda_principal();
   }
   cambiar_color_cuenta();
}

function seleccionar_cuenta_principaltmp()
{
   cuentaactualtmp = 'Principal';
   cambiar_color_cuentatmp();   
}

function seleccionar_cuenta_principaltmpcortesia()
{
   cuentaactualtmp = 'Principal';
   cambiar_color_cuentatmpcortesia();   
   document.getElementById('cuentaseleccionadatmpcortesia').value = 'Principal';
   redraw_por_principal_cortesia();
   console.log(listado_comandatmp);
}

function buscar_cliente()
{
   document.getElementById('myModalclientesV').style.display = '';
   config_clientes();  
}

function buscar_cliente_primera()
{
   config_clientes();  
}

function cambiar_color_cuenta()
{

 if (cuentaactual == 'Principal') 
 {
   document.getElementById('cuentaprincipal').style.backgroundColor = 'lightgreen';
   if (cuentas_comanda.length > 1)
   {
   cuentas_comanda.forEach((score) => {
     if (score != 'Principal')
     {
        document.getElementById('cuenta_' + score).style.backgroundColor = 'lightblue';
     }
   });
   }
 }
 else
 {
   document.getElementById('cuentaprincipal').style.backgroundColor = 'lightblue';
   //bug to fix here 394// fixed 142023
   if (cuentaactual != 'cuentaprincipal')
   {
   document.getElementById('cuenta_' + cuentaactual).style.backgroundColor = 'lightgreen';
   }

   cuentas_comanda.forEach((score) => {
     if (score != 'Principal')
     {
     if (score != cuentaactual)
     {
     // console.log(score);
       document.getElementById('cuenta_' + score).style.backgroundColor = 'lightblue';
     }
     }
   });  
 }
}

function cambiar_color_cuentatmp()
{

 if (cuentaactualtmp == 'Principal') 
 {
   document.getElementById('cuentaprincipaltmp').style.backgroundColor = 'lightgreen';
   if (cuentas_comandatmp.length > 1)
   {
   cuentas_comandatmp.forEach((score) => {
     if (score != 'Principal')
     {
        document.getElementById('cuentatmp_' + score).style.backgroundColor = 'lightblue';
     }
   });
   }
 }
 else
 {
   document.getElementById('cuentaprincipaltmp').style.backgroundColor = 'lightblue';
   //bug to fix here 394// fixed 142023
   if (cuentaactualtmp != 'cuentaprincipaltmp')
   {
   document.getElementById('cuentatmp_' + cuentaactualtmp).style.backgroundColor = 'lightgreen';
   }

   cuentas_comandatmp.forEach((score) => {
     if (score != 'Principal')
     {
     if (score != cuentaactualtmp)
     {
     // console.log(score);
       document.getElementById('cuentatmp_' + score).style.backgroundColor = 'lightblue';
     }
     }
   });  
 }
}

function cambiar_color_cuentatmpcortesia()
{

 if (cuentaactualtmp == 'Principal') 
 {
   document.getElementById('cuentaprincipaltmpcortesia').style.backgroundColor = 'lightgreen';
   if (cuentas_comandatmp.length > 1)
   {
   cuentas_comandatmp.forEach((score) => {
     if (score != 'Principal')
     {
        document.getElementById('cuentatmpcort_' + score).style.backgroundColor = 'lightblue';
     }
   });
   }
 }
 else
 {
   document.getElementById('cuentaprincipaltmpcortesia').style.backgroundColor = 'lightblue';
   //bug to fix here 394// fixed 142023
   if (cuentaactualtmp != 'cuentaprincipaltmpcort')
   {
   document.getElementById('cuentatmpcort_' + cuentaactualtmp).style.backgroundColor = 'lightgreen';
   }

   cuentas_comandatmp.forEach((score) => {
     if (score != 'Principal')
     {
     if (score != cuentaactualtmp)
     {
     // console.log(score);
       document.getElementById('cuentatmpcort_' + score).style.backgroundColor = 'lightblue';
     }
     }
   });  
 }
}

function incrementar_per()
{
 if (parseInt(document.getElementById('numpersonas').value) >= 0)
 {

   var usuario = sessionStorage.getItem('currentloggedin');

   if (document.getElementById('ordenactual').innerText != 0 && usuario != 'ADMIN')
   {
      Swal.fire({
            icon: 'info',
            title: 'No se puede modicar',
            text: 'Ya guardo la orden, si quiere agregar mas personas contacte al administrador del sistema!'
         }).then(function() {
         });  
         return;
   }

     document.getElementById('numpersonas').value = parseInt(document.getElementById('numpersonas').value) + 1;
     if (listado_comanda.length > 0)
     {
     logica_cover_actualizar();
     logica_consumo_actualizar();
     }
 }
 else
 {
   document.getElementById('numpersonas').value = 0;    
 }
}

function disminuir_per()
{
   if (parseInt(document.getElementById('numpersonas').value) > 0)
 {
      var usuario = sessionStorage.getItem('currentloggedin');

      if (document.getElementById('ordenactual').innerText != 0 && usuario != 'ADMIN')
      {
         Swal.fire({
               icon: 'info',
               title: 'No se puede modicar',
               text: 'Ya guardo la orden, si quiere agregar mas personas contacte al administrador del sistema!'
            }).then(function() {
            });  
            return;
      }

     document.getElementById('numpersonas').value = parseInt(document.getElementById('numpersonas').value) - 1;
     if (listado_comanda.length > 0)
     {
     logica_cover_actualizar();
     logica_consumo_actualizar(); 
     }
 }
 else
 {
   document.getElementById('numpersonas').value = 0;    
 }  
 
}

function actualizar_numprods_decalcu(id)
{
 idprod = id.replace("numprods", "");
 if (parseInt(document.getElementById('numprods' + idprod).value) >= 0)
 {
     document.getElementById('numprodst' + idprod).value = (parseFloat(document.getElementById('numprods' + idprod).value)*parseFloat(document.getElementById('numprodss' + idprod).value)).toFixed(3);
 }
 
 if (parseInt(document.getElementById('numprods' + idprod).value) == 0)
 {
   document.getElementById('numprods' + idprod).value = 1;    
   document.getElementById('numprodst' + idprod).value = (parseFloat(document.getElementById('numprods' + idprod).value)*parseFloat(document.getElementById('numprodss' + idprod).value)).toFixed(3);
 }
  // ACTUALIZA EL VALOR MULTIPLICADO
  total_prods = [];
  total_prop = 0;
  listado_comanda.forEach((score) => {
  if (score[0] == cuentaactual & score[1] == idprod)
  {
    score[4] = document.getElementById("numprods" + idprod).value;
  }
   total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
   if (score[5] == 'true')
   {
   total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
   }
 });
 listfinal2 = '';

//  iva = ((total_prods*(parseFloat(document.getElementById('viva').value)/100))).toFixed(2);
//  total_prodsiva = (parseFloat(Number(total_prods)) + parseFloat(Number(iva)) + parseFloat(Number(total_prop))).toFixed(2);
//  listfinal2 = '&nbsp&nbsp<b><span style="font-size:30px">$' + parseFloat(Number(total_prodsiva).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">PROPINA : $ ' + total_prop + ' <br> IVA : $ ' + iva + ' </span>';
//  $('#comandat').html(listfinal2);

      subtotal = 0;
      subtotal = parseFloat(Number(total_prods)).toFixed(2);
      total_prodfinal = (parseFloat(Number(total_prods)) + parseFloat(Number(total_prop))).toFixed(2);
      listfinal2 = '&nbsp&nbsp<input type="text" id="totales_precuenta" hidden value="' + parseFloat(Number(total_prodfinal).toFixed(2)) +  ','  + subtotal + ',' + total_prop + '" /><b><span style="font-size:30px">$' + parseFloat(Number(total_prodfinal).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">SUB-TOTAL : $ ' + subtotal + ' <br> PROPINA : $ ' + total_prop + ' </span>';
      $('#comandat').html(listfinal2);

}

function agregar_notas(id)
{   
  idprod = id.replace("notasprod", "");
  fakeprod = id.replace("notasprod", "prods_"); //simular que viene de agregar el prod
  notaactual = '';

  if (cuentaactual == 'Principal' && cuentas_comanda.length > 1)
  {
   Swal.fire({
          title: 'Notas en cuenta dividida',
          text: 'Debe agregar la nota a una cuenta, esta orden esta dividida.',
          icon: 'info',
          confirmButtonText: 'Cerrar'
        });
        return;
  }

  listado_comanda.forEach(element => {
     if (element[0] == cuentaactual)
     {
               if (element[1] == idprod)
            {  
               notaactual = element[6];
            }
     }   
   });

      Swal.fire({
      icon: 'info',
      title: 'Agregar Notas',
      html:
         '<textarea id="note-textarea" rows="4" cols="50">' + notaactual + '</textarea>',
      showCancelButton: true,
      confirmButtonText: 'Guardar nota',
      cancelButtonText: 'Cancelar'
      }).then((result) => {
      if (result.value == true) {
         const note = document.getElementById('note-textarea').value;
            listado_comanda.forEach(element => {
            if (element[0] == cuentaactual)
            {
                        if (element[1] == idprod)
                     {  
                        element[6] = note;
                        if (cuentas_comanda.length > 1)
                        {
                        refrescar_comanda_porcuenta();
                        }
                        else
                        {
                        refrescar_comanda_principal();
                        }
                     }
            }   
            });
      }
      });
}

var flagcontinue = 0;

function esconder_modalsubingre()
{
   document.getElementById('myModalsubingre').style.display = 'none';
}

function procesar_subingrediente()
{
        //var maxSelectionInput = document.getElementById("ingresaractualtexto");  // Input box where the max number of selections is stored
        var checkboxes = document.querySelectorAll("input[name='ingredientes[]']");
        var maxSelection = parseInt(document.getElementById("ingreactualtexto").value);  // Get the value from the input box
        var checkedCount = 0;  // Initialize checked count

         // Count checked checkboxes
         checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                  checkedCount++;  // Increment count for each checked checkbox
            }
         });

            if (checkedCount != maxSelection) {
                  esconder_modalsubingre();
                  Swal.fire({
                     title: 'Error',
                     text: 'Debe seleccionar : ' + document.getElementById("ingreactualtexto").value + ' producto(s). ',
                     icon: 'error',
                     confirmButtonText: 'Cerrar'
                  });
            } else {
                  //si todo bien 
               flagcontinue = 1;
               agregar_prodalist(document.getElementById('ingreactual').value);


               esconder_modalsubingre();
            }

}

function agregar_prodalist(id)
{
   idprod = id.replace("prods_", "");
   var prod = document.querySelector("#" + id);
   var repetido = false;
   var notas_obligatorias = false;
   var pregunta = '';
 
   listado_comanda.forEach((score) => {
             if (score[0] == cuentaactual)
             {
               if (score[1] == idprod)
               {
                  repetido = true;                  
               }
             }
      });

      // extras
   if (document.getElementById('ordenactual').innerText != 0)
   {
      listado_comandaextras.forEach((score) => {
             if (score[0] == cuentaactual)
             {
               if (score[1] == idprod)
               {
                  repetido = true;                  
               }
             }
      });
   }

   // agregar logica si es sub ingredientes 17/10/2024
   
   if (flagcontinue != 1)
   {
         if (prod.dataset.subingre == 1)
         {
            document.getElementById('myModalsubingre').style.display = '';
            document.getElementById('ingreactual').value = id;

            $.ajax({
            type: "POST",
            async: false,
            url: "inter_comanda.php",
            datatype: "html",
            data: {
               usuario: '',
               id:idprod,
               estado: 'tab_subingreseleccionar',
            },
            beforeSend: function() {

            },
            success: function(r) {
               $('#listadosubingredientes').html('');
               $('#listadosubingredientes').html(r);
            }

            });
         }
      
   }

  
   if (prod.dataset.subingre == 1)
   {
      if (flagcontinue == 0)
      {
      return;
      }
      else
      {
         flagcontinue = 0;
         
      }
   }
   

    // si hay notas obligatorias no dejar agregar hasta que se llenen
   if (prod.dataset.preguntas != '')
   {
      notas_obligatorias = true;
   }
 
   if (notas_obligatorias != true)
   {
      finalizar_agregarprodlist(id, prod, repetido, pregunta);
   }
   else
   {
      if (repetido != true)
      {
       try {
       // const answers = ['apple/orange', 'cat/dog', 'pan/tortilla', 'medio/crudo/tres cuartos'];
        const answers = prod.dataset.respuestas.split(',');
        const questions = prod.dataset.preguntas.split('/');

        const steps = questions.map((question, index) => {
        const questionParts = question.split('/');
        const answerParts = answers[index].split('/');
  
        return {
          title: questionParts.join('<br>'),
          input: 'select',
          inputOptions: getDropdownOptions(answerParts),
          inputPlaceholder: `Seleccione una opción`,
          inputValidator: (value) => {
            return new Promise((resolve) => {
              if (value) {
                resolve();
              } else {
                resolve(`Necesita seleccionar una opción para ${questionParts[0]}`);
              }
            });
          }
        };
      });

      Swal.mixin({
        confirmButtonText: 'Next &rarr;',
        showCancelButton: true,
        progressSteps: steps.map((_, index) => (index + 1).toString())
      }).queue(steps).then((result) => {
        if (result.value) {
          const answersText = questions.map((question, index) => {
            const questionParts = question.split('/');
            return `${questionParts[0]}: ${result.value[index]}\n`;
          }).join('');

          Swal.fire({
            title: 'Agregando notas!',
            html: '',
            confirmButtonText: 'Espere...',
            timer: 500,
            timerProgressBar: true
          }).then(() => {
               finalizar_agregarprodlist(id, prod, repetido,answersText);
          });
        }
      });   
      } catch (error) {
         Swal.fire({
          title: 'Error con las notas',
          text: 'Ha ocurrido un error al procesar las notas obligatorias. Por favor, contacte al administrador.',
          icon: 'error',
          confirmButtonText: 'Cerrar'
        });
      } 
   } 
   else
   {
      finalizar_agregarprodlist(id, prod, repetido,'');
   } 
   }
}

function getDropdownOptions(answerParts) {
      return answerParts.reduce((options, answer) => {
        options[answer] = answer;
        return options;
      }, {});
 }

function finalizar_agregarprodlist(id, prod, repetido, answersText)
{
   
   if (cuentaactual == 'Principal' && cuentas_comanda.length > 1)
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Esta usando cuentas separadas, seleccione una de las cuentas para agregar productos'
              }).then(function() {
              });  
   }
   else if (document.getElementById('numpersonas').value <= 0)//(cuentas_comanda.length <= 1) // cambio
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Seleccione el numero de personas en la mesa'
              }).then(function() {
              });  
   }
   else if (prod)//(cuentas_comanda.length <= 1) // cambio
   {
      //revisar primero si esta repetido
      // listado_comanda.forEach((score) => {
      //        if (score[0] == cuentaactual)
      //        {
      //          if (score[1] == idprod)
      //          {
      //             repetido = true;                  
      //          }
      //        }
      // });

      //una sola cuenta
      if (repetido != true)
      {


      var resultnom = prod.dataset.nombre.substring(0,30);
      //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
      // cuenta, idprod, nombre, precio, unidad, propina, pregunta
     // tlistado_comanda.push(cuentaactual, idprod,resultnom,prod.dataset.precio,1,prod.dataset.propina,pregunta );
      
     // detectar si es modificar guardar el array de modificar
      if (document.getElementById('ordenactual').innerText != 0)
      {
      tlistado_comandaextras.push(cuentaactual, idprod,resultnom,prod.dataset.precio,1,prod.dataset.propina,answersText);
      listado_comandaextras.push(tlistado_comandaextras);
      tlistado_comandaextras = [];
      }
      else
      {
      tlistado_comanda.push(cuentaactual, idprod,resultnom,prod.dataset.precio,1,prod.dataset.propina,answersText);
      listado_comanda.push(tlistado_comanda);
      tlistado_comanda = [];
      }
      

      if (document.getElementById('mesaactual').innerText != 'llevar')
   {
      logica_cover();
      logica_consumominimo();      
   }

      listfinal2 ='';

      listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:14px;"><b><tr><th scope="col"></th><th>CANTIDAD</th><th scope="col">DETALLE</th><th scope="col">NOTAS</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';
      
      total_prods = [];
      total_prop = 0;
      listado_comanda.forEach((score) => {
         if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
         if (score[1] == 'CV') { prop = '';}
         if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
         if (typeof nota === 'undefined') {nota = 'notes.png' }
        // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
       // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
      });

      //agregar los extras si hay temporalmente, aun no grabados
      if (document.getElementById('ordenactual').innerText != 0)
      {
         listado_comandaextras.forEach((score) => {
         if (!score[2].includes('EXTRA_'))
         {
         if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
         if (score[1] == 'CV') { prop = '';}
         if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
         if (typeof nota === 'undefined') {nota = 'notes.png' }
        // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
       // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
         }
      });
      }

      listfinal += '</table>';

      subtotal = 0;
      subtotal = parseFloat(Number(total_prods)).toFixed(2);
      total_prodfinal = (parseFloat(Number(total_prods)) + parseFloat(Number(total_prop))).toFixed(2);
      listfinal2 = '&nbsp&nbsp<input type="text" id="totales_precuenta" hidden value="' + parseFloat(Number(total_prodfinal).toFixed(2)) +  ','  + subtotal + ',' + total_prop + '" /><b><span style="font-size:30px">$' + parseFloat(Number(total_prodfinal).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">SUB-TOTAL : $ ' + subtotal + ' <br> PROPINA : $ ' + total_prop + ' </span>';
      $('#comanda').html('');
      $('#comanda').html(listfinal);
      $('#comandat').html('');
      $('#comandat').html(listfinal2);
     // no totalmente seguro
     if (document.getElementById('mesaactual').innerText != 'llevar')
     {
      logica_consumo_actualizar();
     }
      // seleccionar el boton de la cuenta actual
      if (cuentaactual == 'Principal')
      {
         document.getElementById('cuentaprincipal').click();
      }
      else
      {

       document.getElementById('cuenta_' + cuentaactual).click();
      }
      
      }
      else
      {
         Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Producto Repetido'
              }).then(function() {
              });  
      }      

   }
}

function lleva_cover()
{
   $.ajax({
        type: "POST",
        async: false,
        url: "inter_comanda.php",
        datatype: "JSON",
        data: {
           usuario: '',
           estado: 'lleva_cover',
        },
        beforeSend: function() {

        },
        success: function(r) {
         var data = jQuery.parseJSON(r);
         cover = data;
        }

       });

}

function lleva_consumo()
{
   $.ajax({
        type: "POST",
        async: false,
        url: "inter_comanda.php",
        datatype: "JSON",
        data: {
           usuario: '',
           estado: 'lleva_consumo',
        },
        beforeSend: function() {
        },
        success: function(r) {
         var data = jQuery.parseJSON(r);
         consumo = data;
        }
       });
}

function logica_cover_borrar()
{

         i = 0;
         listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CV')
               {//borrar el item dentro de la cuenta actual y refrescar
                  listado_comanda.splice(i,1);                  
               }
             }
         i++;      
         });
}

function logica_consumo_borrar()
{
 
      i = 0;
      listado_comanda.forEach((score) => {
      if (score[0] == 'Principal')
      {
         if (score[1] == 'CM')
         {//borrar el item dentro de la cuenta actual y refrescar
            listado_comanda.splice(i,1);                  
         }
      }
      i++;      
      });

}

function logica_cover_actualizar() //cuando se cambia el num de personas
{
      if (document.getElementById('numpersonas').value == 0)
      {
         document.getElementById('numpersonas').value = 1;
      }

      //lleva cover o consumo minimo?
      repetidocover = false;
      i = 0;
            //revisar si ya lleva el item de cover si aplica
      listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CV')
               {
                  repetidocover = true;    
                  listado_comanda.splice(i,1);                
               }
             }
             i++; 
      });

      lleva_cover();
      if (cover > 0)
      {
      if (repetidocover == true)
      {
         // volverlo a agregar, esto lo refresca tambien
         tlistado_comanda.push('Principal','CV','COVER',cover,document.getElementById('numpersonas').value,'false','');
         listado_comanda.unshift(tlistado_comanda);
         tlistado_comanda = [];

         listfinal2 ='';

         listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:14px;"><b><tr><th scope="col"></th><th>CANTIDAD</th><th scope="col">DETALLE</th><th scope="col">NOTAS</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

         total_prods = [];
         total_prop = 0;
         listado_comanda.forEach((score) => {
            if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
            if (score[1] == 'CV') { prop = '';}
            if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
         // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
            if (score[5] == 'true')
            {
               total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
            }
         });

         listfinal += '</table>';

         subtotal = 0;
         subtotal = parseFloat(Number(total_prods)).toFixed(2);
         total_prodfinal = (parseFloat(Number(total_prods)) + parseFloat(Number(total_prop))).toFixed(2);
         listfinal2 = '&nbsp&nbsp<input type="text" id="totales_precuenta" hidden value="' + parseFloat(Number(total_prodfinal).toFixed(2)) +  ','  + subtotal + ',' + total_prop + '" /><b><span style="font-size:30px">$' + parseFloat(Number(total_prodfinal).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">SUB-TOTAL : $ ' + subtotal + ' <br> PROPINA : $ ' + total_prop + ' </span>';
         $('#comanda').html('');
         $('#comanda').html(listfinal);
         $('#comandat').html('');
         $('#comandat').html(listfinal2);


      }  
      }

}


function logica_consumo_actualizar() //cuando se cambia el num de personas
{
   if (document.getElementById('mesaactual').innerText != 'llevar')
   {

   if (document.getElementById('numpersonas').value == 0)
   {
    document.getElementById('numpersonas').value = 1;
   }

      //lleva cover o consumo minimo?
      repetidoconsumo = false;
      i = 0;
            //revisar si ya lleva el item de consumo si aplica
      listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CM')
               {
                  repetidoconsumo = true;    
                  listado_comanda.splice(i,1);                
               }
             }
             i++; 
      });

      lleva_consumo();
      if (consumo > 0)
      {
      if (repetidoconsumo == true)
      {
      //CALCULAR DIFERENCIA DE CONSUMO MENOS TOTAL
      diff_consumo = 0;
      uni_consumo = 0 ;  //consumo convertido y reducido a unitario
      total_prodst = [];
      total_propt = 0;
      listado_comanda.forEach((score) => {
         if (score[1] != 'CV')
         {
         total_prodst = parseFloat(Number(total_prodst)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_propt = (parseFloat(total_propt) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
         }
      });

      if (document.getElementById('ordenactual').innerText != 0)
      {
      //agregados
      listado_comandaextras.forEach((score) => {
         if (!score[2].includes('EXTRA_'))
         {
         if (score[1] != 'CV')
         {
         total_prodst = parseFloat(Number(total_prodst)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_propt = (parseFloat(total_propt) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
         }
         }
      });
      }

      subtotalt = 0;
      subtotalt = parseFloat(Number(total_prodst)).toFixed(2);
      total_prodfinalt = (parseFloat(Number(total_prodst)) + parseFloat(Number(total_propt))).toFixed(2);
      diff_consumo = (consumo*document.getElementById('numpersonas').value) - total_prodfinalt;
      uni_consumo = (diff_consumo/document.getElementById('numpersonas').value);

          if (diff_consumo > 0) // solo si es positiva la diferencia por supuesto
          {
            // volverlo a agregar, esto lo refresca tambien
           // tlistado_comanda.push('Principal','CM','CONSUMO MINIMO (' + document.getElementById('numpersonas').value + ')',diff_consumo,1,'NA','Consumo minimo: $' + consumo);
            tlistado_comanda.push('Principal','CM','PENDIENTE X CONSUMIR',uni_consumo,document.getElementById('numpersonas').value,'true','Consumo minimo: $' + consumo);
            listado_comanda.unshift(tlistado_comanda);
            tlistado_comanda = [];
            
            redraw_consumo();         
          }
          else
          {
            redraw_consumo();   
          }
      }
      else // si no esta repetido es nuevo
      {
      //CALCULAR DIFERENCIA DE CONSUMO MENOS TOTAL
      diff_consumo = 0;
      uni_consumo = 0 ;  //consumo convertido y reducido a unitario
      total_prodst = [];
      total_propt = 0;
      listado_comanda.forEach((score) => {
         if (score[1] != 'CV')
         {
         total_prodst = parseFloat(Number(total_prodst)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_propt = (parseFloat(total_propt) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
         }
      });


      if (document.getElementById('ordenactual').innerText != 0)
      {

         listado_comandaextras.forEach((score) => {
         if (!score[2].includes('EXTRA_'))
         {
         if (score[1] != 'CV')
         {
         total_prodst = parseFloat(Number(total_prodst)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_propt = (parseFloat(total_propt) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
         }
         }
      });
      }


      subtotalt = 0;
      subtotalt = parseFloat(Number(total_prodst)).toFixed(2);
      total_prodfinalt = (parseFloat(Number(total_prodst)) + parseFloat(Number(total_propt))).toFixed(2);
      diff_consumo = (consumo*document.getElementById('numpersonas').value) - total_prodfinalt;
      uni_consumo = (diff_consumo/document.getElementById('numpersonas').value);

      
      if (diff_consumo > 0) // solo si es positiva la diferencia por supuesto
      {
            // volverlo a agregar, esto lo refresca tambien
         //   tlistado_comanda.push('Principal','CM','CONSUMO MINIMO (' + document.getElementById('numpersonas').value + ')',diff_consumo,1,'NA','Consumo minimo: $' + consumo);
            tlistado_comanda.push('Principal','CM','PENDIENTE X CONSUMIR',uni_consumo,document.getElementById('numpersonas').value,'true','Consumo minimo: $' + consumo);
            listado_comanda.unshift(tlistado_comanda);
            tlistado_comanda = [];
            
            redraw_consumo();         
      }
      }

      }

   }
}

function redraw_consumo()
{
   //verificar si quedo solo el consumo minimo para no dibujarlo
   if (listado_comanda.length == 1 )
   {
      logica_consumo_borrar();
      //logica_cover_borrar();
   }


   listfinal2 ='';

   listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:14px;"><b><tr><th scope="col"></th><th>CANTIDAD</th><th scope="col">DETALLE</th><th scope="col">NOTAS</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

   total_prods = [];
   total_prop = 0;
   listado_comanda.forEach((score) => {
      if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
      if (score[1] == 'CV') { prop = '';}
      if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
      cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
   // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
   listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
   total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
      if (score[5] == 'true')
      {
         total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
      }
   });
  
   // extras
   if (document.getElementById('ordenactual').innerText != 0)
   {
      listado_comandaextras.forEach((score) => {
         if (!score[2].includes('EXTRA_'))
         {
      if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
      if (score[1] == 'CV') { prop = '';}
      if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
      cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
   // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
   listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
   total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
      if (score[5] == 'true')
      {
         total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
      }
   }
   });

   }

   listfinal += '</table>';

   subtotal = 0;
   subtotal = parseFloat(Number(total_prods)).toFixed(2);
   total_prodfinal = (parseFloat(Number(total_prods)) + parseFloat(Number(total_prop))).toFixed(2);
   listfinal2 = '&nbsp&nbsp<input type="text" id="totales_precuenta" hidden value="' + parseFloat(Number(total_prodfinal).toFixed(2)) +  ','  + subtotal + ',' + total_prop + '" /><b><span style="font-size:30px">$' + parseFloat(Number(total_prodfinal).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">SUB-TOTAL : $ ' + subtotal + ' <br> PROPINA : $ ' + total_prop + ' </span>';
   $('#comanda').html('');
   $('#comanda').html(listfinal);
   $('#comandat').html('');
   $('#comandat').html(listfinal2);

}

function logica_cover()
{
      //lleva cover o consumo minimo?
      repetidocover = false;

            //revisar si ya lleva el item de cover si aplica
      listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CV')
               {
                  repetidocover = true;                  
               }
             }
      });

      lleva_cover();
      if (cover > 0)
      {
      if (repetidocover != true)
      {
         tlistado_comanda.push('Principal','CV','COVER',cover,document.getElementById('numpersonas').value,'false','');
         listado_comanda.unshift(tlistado_comanda);
         tlistado_comanda = [];
      }
      else
      { // quitarlo por que debe ir siempre al final
         i = 0;
         listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CV')
               {//borrar el item dentro de la cuenta actual y refrescar
                  listado_comanda.splice(i,1);                  
               }
             }
         i++;      
         });
           // volverlo a agregar, esto lo refresca tambien
         tlistado_comanda.push('Principal','CV','COVER',cover,document.getElementById('numpersonas').value,'false','');
         listado_comanda.unshift(tlistado_comanda);
         tlistado_comanda = [];
      }  
      }
}


function logica_consumominimo()
{
      //lleva consumo minimo?
      repetidoconsumo = false;

            //revisar si ya lleva el item de consumo si aplica
      listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CM')
               {
                  repetidoconsumo = true;                  
               }
             }
      });

      lleva_consumo();
      if (consumo > 0)
      {
      //CALCULAR DIFERENCIA DE CONSUMO MENOS TOTAL
      diff_consumo = 0;
      uni_consumo = 0 ;  //consumo convertido y reducido a unitario

      total_prodst = [];
      total_propt = 0;
      listado_comanda.forEach((score) => {
         if (score[1] != 'CV')
         {
         total_prodst = parseFloat(Number(total_prodst)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_propt = (parseFloat(total_propt) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
         }
      });

      subtotalt = 0;
      subtotalt = parseFloat(Number(total_prodst)).toFixed(2);
      total_prodfinalt = (parseFloat(Number(total_prodst)) + parseFloat(Number(total_propt))).toFixed(2);
      diff_consumo = (consumo*document.getElementById('numpersonas').value) - total_prodfinalt;
      uni_consumo = (diff_consumo/document.getElementById('numpersonas').value);

      if (diff_consumo > 0)
      {
      if (repetidoconsumo != true)
      {
        // tlistado_comanda.push('Principal','CM','CONSUMO MINIMO (' + document.getElementById('numpersonas').value + ')',diff_consumo,1,'NA','Consumo minimo: $' + consumo);
         tlistado_comanda.push('Principal','CM','PENDIENTE X CONSUMIR',uni_consumo,document.getElementById('numpersonas').value,'true','Consumo minimo: $' + consumo);
         listado_comanda.unshift(tlistado_comanda);
         tlistado_comanda = [];
      }
      else
      { // quitarlo por que debe ir siempre al final
         i = 0;
         listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CM')
               {//borrar el item dentro de la cuenta actual y refrescar
                  listado_comanda.splice(i,1);                  
               }
             }
         i++;      
         });
           // volverlo a agregar, esto lo refresca tambien
        // tlistado_comanda.push('Principal','CM','CONSUMO MINIMO (' + document.getElementById('numpersonas').value + ')',diff_consumo,1,'false','Consumo minimo: $' + consumo);
         tlistado_comanda.push('Principal','CM','PENDIENTE X CONSUMIR',uni_consumo,document.getElementById('numpersonas').value,'true','Consumo minimo: $' + consumo);
         listado_comanda.unshift(tlistado_comanda);
         tlistado_comanda = [];
      }  
      }

      }
}


function remover_productocomanda(id)
{
   flagcancelar = 0;
   var usuario = sessionStorage.getItem('currentloggedin');
   //si admin puede borrar pero si admin y estado del producto diferente de abierto no aun siendo admin

   if (id == 'cbprodCV' || id == 'cbprodCM')
   {
   }
   else
   {
   var idextras = id.replace("cbprod", "");
   existe = false;
   //revisar si esta en extras si es asi aun se puede eliminar
   listado_comandaextras.forEach((score) => {
             if (score[0] == cuentaactual)
             {
               if (score[1] == idextras)
               {
                  if (!score[2].includes('EXTRA_'))
                  {
                  existe = true;                  
                  }
               }
             }
           });

   //if (usuario != 'ADMIN' && document.getElementById('ordenactual').innerText != 0) //PRIMER PERMISO
   if (document.getElementById('ordenactual').innerText != 0 && existe == false) //PRIMER PERMISO
   {
      Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'No puede remover el producto, la orden ya esta puesta'
              }).then(function() {
              }); 
     return;
   }
   else if (usuario == 'ADMIN' && document.getElementById('ordenactual').innerText != 0)
   {
    
      // si ya esta siendo procesado al menos un item que no permita ni al admin
               // obtener mesas que puede ver el usuario
      // $.ajax({
      //    type: "POST",
      //    url: "inter_comanda.php",
      //    async: false,
      //    datatype: "JSON",
      //    data: {
      //       usuario: usuario,
      //       orden: document.getElementById('ordenactual').innerText,
      //       estado: 'revisar_orden_enproceso'
      //    },
      //    beforeSend: function() {
      //    },
      //    success: function(r) {
      //    var data = jQuery.parseJSON(r);
      //       if (data[0] > 0)
      //       {
      //         flagcancelar = 1;
      //         if (usuario != 'ADMIN')
      //         {
      //                      Swal.fire({
      //                      icon: 'info',
      //                      title: 'Error...',
      //                      text: 'La orden ya esta siendo procesada en Bar o Cocina'
      //                   }).then(function() {
      //                   }); 
      //                   return;
      //         }
      //       }
      //    }
      // });
   }
   }

   if (usuario == 'ADMIN' && flagcancelar == 1)
   {
      var retVal = confirm("La orden ya esta siendo procesada en Bar o Cocina, en verdad quiere eliminar el producto ?");
         if (retVal == false) {
            return;
         } else {     
         }           
   }


   // Si es cover no permitir que se borre
   if (id == 'cbprodCV')
   {
      
      if (usuario != 'ADMIN') //PRIMER PERMISO
      {
         // SEGUNDO PERMISO SI PUEDE COVERS PRIVILEGIO 7 Y COVER
         Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'No tiene permisos suficientes para remover el COVER'
              }).then(function() {
              });  
         return;
      }
   }

      // Si es cover no permitir que se borre
   if (id == 'cbprodCM')
   {
      if (usuario != 'ADMIN') //PRIMER PERMISO
      {
         // SEGUNDO PERMISO SI PUEDE COVERS PRIVILEGIO 7 Y COVER
         Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'No tiene permisos suficientes para remover el CONSUMO MINIMO'
              }).then(function() {
              });  
         return;
      }
   }

   //solo si es principal borrar de ahi si no por subcuentas
   if (cuentas_comanda.length > 1 && cuentaactual == 'Principal')
   {
    //  no se puede remover de principal en multicuentas de principal
   }
   {   
      //evitar que borre por que ya esta puesta la orden si no es ADMIN
      if (usuario != 'ADMIN' && (document.getElementById('ordenactual').innerText != 0 || document.getElementById('ordenactual').innerText == 'LLEVAR'))
      {
         Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'No tiene permisos suficientes, el producto ya fue ordenado'
              }).then(function() {
              }); 
              return;
      }

      acum = 0;
      // siempre quitar cover si estamos borrando el ultimo para que no quede cover solo:
      if (listado_comanda.length == 3 ) // && usuario != 'ADMIN')
      {  
       if (id == 'cbprodCM')   
      {
         logica_consumo_borrar();
      }
      else if (id == 'cbprodCV')  
      {
         logica_cover_borrar();
      }
      else
      {
      listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CV')
               {
                acum = acum + 1;
               }
               if (score[1] == 'CM')
               {
                acum = acum + 1;
               }
             }          
      }); 
           if (acum == 2)
         { 
            logica_consumo_borrar();
            logica_cover_borrar();
            listado_comanda = [];
         }
      }
      }


      
      if (document.getElementById('mesaactual').innerText != 'llevar')
     {
      if (id == 'cbprodCV')
      {
         logica_cover_borrar();         
      }
      if (id == 'cbprodCM')
      {
         logica_consumo_borrar();
      }
     }

      
      var cuentab = document.querySelector("#" + id);
      var cuenta_s = cuentab.dataset.cuenta;
      var item_borrar = id.replace("cbprod", "");
      
      i = 0;
      listado_comanda.forEach((score) => {
             if (score[0] == cuenta_s)
             {
               if (score[1] == item_borrar)
               {//borrar el item dentro de la cuenta actual y refrescar
                  listado_comanda.splice(i,1);                  
               }
             }
      i++;      
      });

      if (existe == true)
      {
      i = 0;
      listado_comandaextras.forEach((score) => {
             if (score[0] == cuenta_s)
             {
               if (score[1] == item_borrar)
               {//borrar el item dentro de la cuenta actual y refrescar
                  listado_comandaextras.splice(i,1);                  
               }
             }
      i++;      
      });

      }
      
      // seleccionar el boton de la cuenta actual
      if (cuentaactual == 'Principal')
      {
         document.getElementById('cuentaprincipal').click();
      }
      else
      {
         document.getElementById('cuenta_' + cuentaactual).click();
      }

      if (id == 'cbprodCM' && usuario == 'ADMIN')
      {
         redraw_consumo();
      }
      else
      {
         if (document.getElementById('mesaactual').innerText != 'llevar')
        {
         if (id == 'cbprodCV' && usuario == 'ADMIN')
         {
            // revisar si ya borro el CONSUMO para no estarlo dibujando a cada rato
            acum = 0;
            listado_comanda.forEach((score) => {
             if (score[0] == 'Principal')
             {
               if (score[1] == 'CM')
               {
                acum = acum + 1;
               }
             }          
             }); 

            if (acum == 1)
            {
               logica_consumo_actualizar();
            }
            else if (acum == 0)
            {
               redraw_consumo();
            }
             return;
         }
         logica_consumo_actualizar();
      }
   }     

   }
      //bug fix flashing to like principal
      if (id.includes('cbprod'))
   {      
      if (cuentaactual == 'Principal') 
      {
         document.getElementById('cuentaprincipal').click();
      }
      else
      {
      document.getElementById('cuenta_' + cuentaactual).click();
      }
   }
}


function remover_productosdecuenta(idfinal)
{
      var cuenta_s = idfinal;
      borrarIndex = [];
      
      i = 0;
      listado_comanda.forEach((score) => {
             if (score[0] != cuenta_s)
             {
                 borrarIndex.push(score);
             }
      i++;      
      });

      lista_comanda = [];
      listado_comanda = borrarIndex;
}

function remover_productosdecuentatmp(idfinal)
{
      //revertir la cantidad de regreso al listado original
      listado_comandatmp2.forEach((score) => {
      if (score[0] == idfinal) {
         // Check if score[1] already exists in listado_comandatmp2
         const index = listado_comandatmp.findIndex((item) => item[1] === score[1]);
         if (index === -1) {
         } else {
            listado_comandatmp[index][4] = parseInt(listado_comandatmp[index][4]) + parseInt(score[4]);
         }
      }
      });

               //SPLICE ADECUADO quitar el elemento que ya se agrego de nuevo
         let i = listado_comandatmp2.length - 1;
         for (i; i >= 0; i--) {
         if (listado_comandatmp2[i][0] === idfinal) {
            listado_comandatmp2.splice(i, 1);
         }
         }

         cuentaactualtmp = 'Principal';
         document.getElementById('cuentaseleccionadatmp').value = '';
      
}

function refrescar_comanda_principal_suma()
{
   var sinduplicados = [];
   var count = 0;
   var start = false;

      // VIEJA MANERA, ESTA IGNORA LOS ITMES CON CERO
      // const result = Object.values(listado_comanda.reduce((acc, curr) => {
      // const key = curr[2];
      // if (!acc[key]) {
      //    acc[key] = [...curr];
      //    acc[key][4] = +curr[4];
      // } else {
      //    acc[key][4] += +curr[4];
      //    if (curr[5] === 'false') {
      //       acc[key][5] = 'false';
      //    }
      // }
      // return acc;
      // }, {}));

      // result.forEach(item => {
      // item[5] = item[5] === 'true';
      // item.pop();
      // });

      const result = Object.values(listado_comanda.reduce((acc, curr) => {
         const key = curr[2];
         if (curr[3] === 0) {
            return acc; // Skip and ignore if item[3] is 0
         }
         if (!acc[key]) {
            acc[key] = [...curr];
            acc[key][4] = +curr[4];
         } else {
            acc[key][4] += +curr[4];
            if (curr[5] === 'false') {
               acc[key][5] = 'false';
            }
         }
         return acc;
      }, {}));

      result.forEach(item => {
         item[5] = item[5] === 'true';
       //  item.pop();
      });


      listfinal2 ='';

      listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:14px;"><b><tr><th scope="col"></th><th>CANTIDAD</th><th scope="col">DETALLE</th><th scope="col">NOTAS</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

      total_prods = [];
      total_prop = 0;
      result.forEach((score) => {
         if (score[5] == false) { prop = ' (SP)';} else { prop = ''}
         if (score[1] == 'CV') { prop = '';}
         // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
        if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
        // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
     //    listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/notes.png" disabled height="15px" width="15px" /></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == true)
         {
            total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
      });

      subtotal = 0;
      subtotal = parseFloat(Number(total_prods)).toFixed(2);
      total_prodfinal = (parseFloat(Number(total_prods)) + parseFloat(Number(total_prop))).toFixed(2);
      listfinal2 = '&nbsp&nbsp<input type="text" id="totales_precuenta" hidden value="' + parseFloat(Number(total_prodfinal).toFixed(2)) +  ','  + subtotal + ',' + total_prop + '" /><b><span style="font-size:30px">$' + parseFloat(Number(total_prodfinal).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">SUB-TOTAL : $ ' + subtotal + ' <br> PROPINA : $ ' + total_prop + ' </span>';
      $('#comanda').html('');
      $('#comanda').html(listfinal);
      $('#comandat').html('');
      $('#comandat').html(listfinal2);

      console.log(document.getElementById('totales_precuenta').value);
}


function refrescar_comanda_principal()
{
   //aqui entra caja tambien
   listfinal2 ='';

   listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:14px;"><b><tr><th scope="col"></th><th>CANTIDAD</th><th scope="col">DETALLE</th><th scope="col">NOTAS</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

   total_prods = [];
   total_prop = 0;
   listado_comanda.forEach((score) => {
      if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
      if (score[1] == 'CV') { prop = '';}
      if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
      cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
      listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
      //listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
      total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
      if (score[5] == 'true')
      {
         total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
      }
   });

   // extras
   if (document.getElementById('ordenactual').innerText != 0)
   {
      listado_comandaextras.forEach((score) => {
         if (!score[2].includes('EXTRA_'))
         {
      if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
      if (score[1] == 'CV') { prop = '';}
      if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
      cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
      listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
      //listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
      total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
      if (score[5] == 'true')
      {
         total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
      }
   }
   });
   }

   listfinal += '</table>';

      subtotal = 0;
      subtotal = parseFloat(Number(total_prods)).toFixed(2);
      total_prodfinal = (parseFloat(Number(total_prods)) + parseFloat(Number(total_prop))).toFixed(2);
      listfinal2 = '&nbsp&nbsp<input type="text" id="totales_precuenta" hidden value="' + parseFloat(Number(total_prodfinal).toFixed(2)) +  ','  + subtotal + ',' + total_prop + '" /><b><span style="font-size:30px">$' + parseFloat(Number(total_prodfinal).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">SUB-TOTAL : $ ' + subtotal + ' <br> PROPINA : $ ' + total_prop + ' </span>';
      $('#comanda').html('');
      $('#comanda').html(listfinal);
      $('#comandat').html('');
      $('#comandat').html(listfinal2);

}

function refrescar_comanda_porcuenta()
{
   listfinal2 ='';

   listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:14px;"><b><tr><th scope="col"></th><th>CANTIDAD</th><th scope="col">DETALLE</th><th scope="col">NOTAS</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

   total_prods = [];
   total_prop = 0;
   listado_comanda.forEach((score) => {
      if (score[0] == cuentaactual) // por cuenta actual
      {
      if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
      if (score[1] == 'CV') { prop = '';}
      if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
       cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
      listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
      //listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
      total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
      if (score[5] == 'true')
      {
         total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
      }
      }
   });

         //agregar los extras si hay temporalmente, aun no grabados
         if (document.getElementById('ordenactual').innerText != 0)
      {
         listado_comandaextras.forEach((score) => {
         if (!score[2].includes('EXTRA_') && score[0] == cuentaactual)
         {
         if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
         if (score[1] == 'CV') { prop = '';}
         if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
         if (typeof nota === 'undefined') {nota = 'notes.png' }
        // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        cmcvcolor ='';
         if (score[1] == 'CV' || score[1] == 'CM') 
        {
         cmcvcolor = 'style="background-color: lightblue;"';
        }
       // listfinal += '<tr><td><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td style="width:90px"><button type="button"  style="height:20px" onClick="disminuir_numprods(this.id)" id="dbprod' + score[1] + '">-</button><input type="text" id="numprods' + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/><button type="button" onClick="incrementar_numprods(this.id)" id="abprod' + score[1] + '" style="height:20px">+</button></td><td><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td><img src="images/' + nota + '" height="15px" width="15px" value="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        listfinal += '<tr><td ' + cmcvcolor + '><img src="images/cancelar.png" height="15px" width="15px" data-cuenta="' + score[0] + '" id="cbprod' + score[1] + '" onClick="remover_productocomanda(this.id)"/></td><td ' + cmcvcolor + ' style="width:90px"><input type="text" id="numprods'  + score[1] + '"  onClick="mostrar_calculadora(this.id)" value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td  ' + cmcvcolor + '><input type="text" style="text-align:left;" value="' + score[2]  + prop +  '" readonly/></td><td  ' + cmcvcolor + '><img src="images/' + nota + '" height="15px" width="15px" data-notas="' + score[6] + '" id="notasprod' + score[1] + '" onClick="agregar_notas(this.id)"/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodss' + score[1] + '" style="text-align:center;width:40px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td  ' + cmcvcolor + '>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
        total_prods = parseFloat(Number(total_prods)) + parseFloat((Number(score[3])*Number(score[4])));
         if (score[5] == 'true')
         {
            total_prop = (parseFloat(total_prop) + parseFloat(Number(score[3])*Number(score[4])) * parseFloat(document.getElementById('vpropina').value)/100).toFixed(2);
         }
         }
      });
      }

   listfinal += '</table>';

      subtotal = 0;
      subtotal = parseFloat(Number(total_prods)).toFixed(2);
      total_prodfinal = (parseFloat(Number(total_prods)) + parseFloat(Number(total_prop))).toFixed(2);
      listfinal2 = '&nbsp&nbsp<input type="text" id="totales_precuenta" hidden value="' + parseFloat(Number(total_prodfinal).toFixed(2)) +  ','  + subtotal + ',' + total_prop + '" /><b><span style="font-size:30px">$' + parseFloat(Number(total_prodfinal).toFixed(2)) + '</span></b>&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size:10px;width:100px;height:50px;display: inline-block;">SUB-TOTAL : $ ' + subtotal + ' <br> PROPINA : $ ' + total_prop + ' </span>';
      $('#comanda').html('');
      $('#comanda').html(listfinal);
      $('#comandat').html('');
      $('#comandat').html(listfinal2);

}



function limpiar_prodlist()
{
   tlistado_comanda = [];
   listado_comanda = [];
   rlistado_comanda = [];
   total_prods = [];
   //
   listado_comandaextras = [];
   tlistado_comandaextras = [];
   listado_comandaori = [];
}

function no_agregar(id)
{
   //var prod = document.querySelector("#" + id);
   
   //mensaje = "No se puede servir este dia el producto : " . prod.dataset.nombre ;  
   Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'No se puede servir este dia el producto seleccionado'
              }).then(function() {
              });  

}

function logout_comanda()
{
   if (usuario_comanda != '')
   {
   Swal.fire({
   icon: 'info',
   title: 'Salir',
   text: 'Esta seguro que quiere desconectar el mesero actual?',
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
               usuario_comanda = '';
               document.getElementById('meseroact').value = usuario_comanda;
               document.getElementById('meseroact2').value = usuario_comanda;
               document.getElementById('usermesero').value = '';// quitar zonas grises
               actualizar_colores();//quitar zonas grises
               document.getElementById('logcom').src = 'images/login.png';         
      }
      });
   }
   else
   {
      mostrar_modalmeseros();
   }


   // if (usuario_comanda != '')
   // {
   // let isExecuted = confirm("Esta seguro que quiere desconectar el mesero actual?");

   //          if (isExecuted == true)
   //          {
   //             usuario_comanda = '';
   //             document.getElementById('meseroact').value = usuario_comanda;
   //             document.getElementById('meseroact2').value = usuario_comanda;
   //             document.getElementById('usermesero').value = '';// quitar zonas grises
   //             actualizar_colores();//quitar zonas grises
   //             document.getElementById('logcom').src = 'images/login.png';
   //          }
   // }
   // else
   // {
   //    mostrar_modalmeseros();
   // }

}

function selec_pass()
{
   document.getElementById("usermeseropass").focus();
}

function seleccionar_usuario(e) 
{
  if(e.keyCode === 13)
  {
     logear();
  }
}

function logear()
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
            usuario_comanda = document.getElementById('usermesero').value;
            document.getElementById('meseroact').value = usuario_comanda;
            document.getElementById('meseroact2').value = usuario_comanda;
            esconder_logmeseros();
            document.getElementById('usermeseropass').value = '';
            actualizar_colores();//quita las zonas grises
            document.getElementById('logcom').src = 'images/logout.png';
            if (sessionStorage.getItem('currentloggedin') == 'ADMIN')
            {
               deshabilitar_zonas_usuario('ADMIN');
            }
            else
            {
               deshabilitar_zonas_usuario(usuario_comanda);
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

function seleccionar_usuario2(e) 
{
  if(e.keyCode === 13)
  {
     logear2();
  }
}

function logear2()
{

   // validar si es buena la contrasena del mesero
   // luego asignarusuario actual
      $.ajax({
        type: "POST",
        url: "inter_log.php",
        datatype: "html",
        data: {
           estado: 'login_comanda2',
           usuario: document.getElementById('usermesero2').value,
           pass: document.getElementById('usermeseropass2').value
        },
        beforeSend: function() {

        },
        success: function(r) {
         if (r==1)
          {
           //  usuario_comandatmp = document.getElementById('usuariomaster').value;
            usuario_comandatmp = sessionStorage.getItem('currentloggedin');
            sessionStorage.setItem('currentloggedin', document.getElementById('usermesero2').value);
            document.getElementById('usuariomaster').value = sessionStorage.getItem('currentloggedin');
             esconder_logmeseros2();            
             actualizar_colores_noblock();
             document.getElementById('logeoadmin').style.backgroundColor = 'green';
             document.getElementById('logeoadmin').innerText = sessionStorage.getItem('currentloggedin');

            //usuario de sesion y usuario mesero, le da prioridad si es ADMIN
            deshabilitar_opciones(sessionStorage.getItem('currentloggedin'), document.getElementById('meseroact2').value)
          }
          else
          {
            Swal.fire({
                icon: 'info',
                title: 'Incorrecto',
                text: 'Contrasena o Rol incorrecto de usuario Administrativo'
              }).then(function() {
              });  
          }
        }

       });

}

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

function deshabilitar_zonas_usuario_admin(usuario_comanda)
{
   // obtener mesas que puede ver el usuario
   var usuario_comanda = sessionStorage.getItem('currentloggedin');

   $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario_comanda,
          usuarioc: sessionStorage.getItem('currentloggedin'),
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

function esconder_logmeseros()
{
   if (usuario_comanda != '')
   {
      document.getElementById('myModalusuariocomanda').style.display = 'none';
   }
}

function esconder_logmeseros2()
{
      document.getElementById('myModalusuariocomanda2').style.display = 'none';
      document.getElementById('usermesero2').value = '';   
      document.getElementById('usermeseropass2').value = '';   
}

function esconder_logmeserosv2()
{
      document.getElementById('myModalusuariocomanda').style.display = 'none';
      document.getElementById('usermesero').value = '';   
      document.getElementById('usermeseropass').value = '';   
}

function mostrar_modalmeseros()
{
   document.getElementById('myModalusuariocomanda').style.display = '';
}

function actualizar_colores()
{
//actualizar colores sin prompt y borrar todo seleccionado
$('#submenus').html('');
$('#comanda').html('');
$('#comandat').html('');
//vars a zero de la comanda
limpiar_cuentas(); //limpia cuentas
document.getElementById('numpersonas').value = 0
limpiar_prodlist();  // limpia lo del menu

//redraw practicamente de las zonas y mesas
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
        document.getElementById("myModalcomanda").style.display = 'block' ;
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

function actualizar_colores_especial()
{
   //actualizar colores sin prompt y borrar todo seleccionado
   $('#submenus').html('');
   $('#comanda').html('');
   $('#comandat').html('');
   //vars a zero de la comanda
   limpiar_cuentas(); //limpia cuentas
   document.getElementById('numpersonas').value = 0
   limpiar_prodlist();  // limpia lo del menu

}

function actualizar_colores_especialV2()
{
   //actualizar colores sin prompt y borrar todo seleccionado
   //$('#submenus').html('');
   $('#comanda').html('');
   $('#comandat').html('');
   //vars a zero de la comanda
   limpiar_cuentas(); //limpia cuentas
   document.getElementById('numpersonas').value = 0
   limpiar_prodlist();  // limpia lo del menu

}

function actualizar_colores_noblock()
{
//redraw practicamente de las zonas y mesas
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
        //document.getElementById("myModalcomanda").style.display = 'block' ;
       // deshabilitar_zonas_usuario(document.getElementById('usermesero').value);
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

function clear_comanda_vars()
{
   
   //LIMPIA ALGUNAS VARIABLES
   document.getElementById("myModalunirmesas").style.display = 'none' ;   //esconderla si no no refresca
   document.getElementById("myModalusuarioteclado").style.display = 'none' ;   //esconderla si no no refresca
   if (document.getElementById('myModalclientesV').innerHTML != '')
   {
   document.getElementById("myModalclientes").style.display = 'none' ;   //esconderla si no no refresca
   }
   mesas_unidas = [];
   const unidasElement = document.getElementById("unidas");
   if (unidasElement) {
   unidasElement.value = '';
   }
   document.getElementById("smesaactual").value = '';
   document.getElementById("clientecid").value = '';
   dui_comanda = '';
}



function actualizar_colores_prompt()
{
if (listado_comanda.length == 0)
{ 
 clear_comanda_vars();
 actualizar_colores();
}
else
{
   Swal.fire({
   icon: 'info',
   title: 'Regresar a seleccion de mesas',
   text: 'Esta seguro?, producto no enviado de la comanda se perdera',
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
         // bug resetear cuentacomanda
         cuentaactual = 'cuentaprincipal'; //solo por si no dieron click en principal de nuevo
         clear_comanda_vars();
         //actualizar colores sin prompt y borrar todo seleccionado
         $('#submenus').html('');
         $('#comanda').html('');
         $('#comandat').html('');
         //vars a zero de la comanda
         limpiar_cuentas(); //limpia cuentas
         document.getElementById('numpersonas').value = 0
         limpiar_prodlist();  // limpia lo del menu

         //redraw practicamente de las zonas y mesas
         var usuario = sessionStorage.getItem('currentloggedin');
         $.ajax({
               type: "POST",
               url: "inter_comanda.php",
               datatype: "JSON",
               data: {
                  usuario: usuario,
                  usuarioc: document.getElementById('usermesero').value,
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
                document.getElementById("myModalcomanda").style.display = 'block' ;
                if (usuario == 'ADMIN')
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
      });
  }
}

  //// funcionalidad de la comanda
  function enviar_comanda()
  {

   if (dui_comanda == '')
   {
      Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'Seleccione o Cree un cliente!'
              }).then(function() {
               document.getElementById('clientecid').focus();
              });  
   }
   else if (document.getElementById('numpersonas').value <= 0 && document.getElementById('mesaactual').innerText != 'llevar')
   {
      Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'Seleccione el numero de Personas!'
              }).then(function() {
               document.getElementById('numpersonas').focus();
              });  
   }
   else if (listado_comanda.length <= 0)
   {
      Swal.fire({
                icon: 'info',
                title: 'Error...',
                text: 'Debe agregar al menos un Producto!'
              }).then(function() {
              });  
     
   }
   else
   {
      if (document.getElementById('ordenactual').innerText == 0) //orden nueva
      {
       var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          usuarioc: document.getElementById('usermesero').value,
          num_personas: document.getElementById('numpersonas').value,
          dui: dui_comanda,
          mesa: document.getElementById('mesaactual').innerText,
          submesa: document.getElementById('smesaactual').value,
          listado_comanda: listado_comanda,
          propina: document.getElementById('vpropina').value,          
          estado: 'enviar_comanda'
       },
       beforeSend: function() {
       },
       success: function(r) {
        var data = jQuery.parseJSON(r);
        if (data != '')
        {
           document.getElementById('ordenactual').innerText = data;
           //BUG FIX -- agregaba doble en la primera pasada
           //usuario_comanda = document.getElementById('meseroact2').value
           seleccionar_mesa(document.getElementById('mesaactual').innerText, 1);
        }
       }
       });
      }
      else if (document.getElementById('ordenactual').innerText != 0)
      {

         if (listado_comandaextras.length == 0)
         {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No hay nada que modificar!'
              }).then(function() {
              }); 
         }
         else
         { 
               borrar_consumo = verificar_extras_consumo();
               borrar_cover = verificar_extras_cover();
   
                     // usar el listado extra para modificar todo
               var usuario = sessionStorage.getItem('currentloggedin');
               $.ajax({
               type: "POST",
               url: "inter_comanda.php",
               datatype: "JSON",
               data: {
                  usuario: usuario,
                  usuarioc: document.getElementById('usermesero').value,
                  orden: document.getElementById('ordenactual').innerText,
                  num_personas: document.getElementById('numpersonas').value,
                  listado_comandaextras: listado_comandaextras,
                  propina: document.getElementById('vpropina').value,  
                  borrarcm: borrar_consumo,
                  borrarcv: borrar_cover,
                  estado: 'modificar_comanda'
                  },
                  beforeSend: function() {
                  },
                  success: function(r) {
                  $('#comanda').html('');
                  actualizar_colores_especialV2();
                  usuario_comanda = document.getElementById('meseroact2').value
                  seleccionar_mesa(document.getElementById('mesaactual').innerText, 1);
                  //refrescar aqui el listado comanda por que dejaron de ser extras:
                  Swal.fire({
                  icon: 'success',
                  title: 'modificada',
                  text: 'Orden modificada!'
                  }).then(function() {
                  });
               
                  }
                  });
         }
         
      }


   }

  }

  function verificar_extras_consumo()
  {
   borrarcm = 'SI';
   //verificar si al agregar extras se quito o no el cover
           //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
       // cuenta, idprod, nombre, precio, unidad, propina, pregunta
       listado_comanda.forEach(function(element) {
         if (element[1] == 'CM')
         {
            borrarcm = 'NO';
         }
         });

         return borrarcm;
  }

  function verificar_extras_cover()
  {
   borrarcover = 'SI';
   //verificar si al agregar extras se quito o no el cover
           //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
       // cuenta, idprod, nombre, precio, unidad, propina, pregunta
       listado_comanda.forEach(function(element) {
         if (element[1] == 'CV')
         {
            borrarcover = 'NO';
         }
         });

         return borrarcover;
  }

  function mostrar_calculadora(id)
  {
   if (id.includes('ctnumprod1sz'))
   {
      if (cuentaactualtmp == 'Principal' && cuentas_comanda.length > 1)
      {
                  esconder_calculadora();
                  Swal.fire({
                  icon: 'info',
                  title: 'Accion invalida',
                  text: 'Es cuenta dividida, seleccione la cuenta a  aplicar la cortesia' 
               }).then(function() {
               });  
               return;   
      }
   }
   //auto zero
   if (id.includes('ctnumprod1ss'))
   {
      if (cuentaactualtmp == 'Principal' && cuentas_comanda.length > 1)
      {
                  esconder_calculadora();
                  Swal.fire({
                  icon: 'info',
                  title: 'Accion invalida',
                  text: 'Es cuenta dividida, seleccione la cuenta a  aplicar la cortesia' 
               }).then(function() {
               });  
               return;   
      }

       document.getElementById('calcuval').value = 0;
      if (document.getElementById('calcuval').value == 0)
      {
         idfinal = id.replace("ctnumprod1ss", "");   
         document.getElementById(id).value = document.getElementById('calcuval').value;
         document.getElementById('ctnumprodst' + idfinal).value = (document.getElementById(id).value*document.getElementById('ctnumprod1sz' + idfinal).value).toFixed(3);
         afectar_array_cortesia(idfinal);
         esconder_calculadora();
      }
      return;
   }

   if (id.includes('tasignar'))
   {
   document.getElementById('myModalusuarioteclado').style.display = '';
   document.getElementById('calcufrom').value = id;
   document.getElementById('calcuval').value = '';
   return;
   }


   // if (cuentaactual == 'Principal' && cuentas_comanda.length > 1)
   // {
   // }
   // else
   // {   
   document.getElementById('myModalusuarioteclado').style.display = '';
   document.getElementById('calcufrom').value = id;
   document.getElementById('calcuval').value = '';
  // }
  }

  function mostrar_calculadorav2(id)
  {
   document.getElementById('myModalusuarioteclado').style.display = '';
   document.getElementById('calcufrom').value = id;
   document.getElementById('calcuval').value = '';
  }

  function esconder_calculadora()
  {
   document.getElementById('myModalusuarioteclado').style.display = 'none';
  }

  function calcu(id)
  {
   document.getElementById('calcuval').value += id;
  }

  function enviar_calcuto()
  {
   var usuario = sessionStorage.getItem('currentloggedin');
   ret = document.getElementById('calcufrom').value;

   if (ret.includes('numprods') && document.getElementById('ordenactual').innerText != 0) // && usuario != 'ADMIN') // para extras
   {  
      idfinal = ret.replace("numprods", "");
      compar = 0; 
      //BUSCAR VALOR REAL YA GUARDADO
      //find quantity
        //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
       // cuenta, idprod, nombre, precio, unidad, propina, pregunta
         listado_comandaori.forEach(function(element) {
         if (element[0] == cuentaactual)
         {
              if (element[1] == idfinal)
               {
                      compar = element[4];           
               }            
         }
         });


      if (Number(compar) > Number(document.getElementById('calcuval').value))
      {
         esconder_calculadora();
         Swal.fire({
                  icon: 'info',
                  title: 'Valor Invalido',
                  text: 'No puede disminuir el valor o ser el mismo, orden ya puesta!' 
               }).then(function() {
               }); 
               return;
      }
      else
      {
         repetido = false;
         // verificar si ya existe
         listado_comandaextras.forEach((score) => {
             if (score[0] == cuentaactual)
             {
               if (score[1] == idfinal)
               {
                  repetido = true;                  
               }
             }
           });

         diff = document.getElementById('calcuval').value - compar;
         if (repetido == false)  
         {
         if (diff != 0)
         {
         
         //get prod name, precio, propina
         $.ajax({
         type: "POST",
         async: false,
         url: "inter_comanda.php",
         datatype: "JSON",
         data: {
            usuario: '',
            idprod: idfinal,
            estado: 'get_extra_detalles'
         },
         beforeSend: function() {
         },
         success: function(r) {
            var data = JSON.parse(r);
            prodnamet = data[0];
            preciot = data[1];
            propinat = data[2];
         }
         });

          //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
         // cuenta, idprod, nombre, precio, unidad, propina, pregunta
         //tlistado_comandaextras.push(cuentaactualtmp, idfinal,'EXTRA',0,diff,0,'');
         tlistado_comandaextras.push(cuentaactual, idfinal,'EXTRA_' + prodnamet,preciot,diff,propinat,'');
         listado_comandaextras.push(tlistado_comandaextras);
         tlistado_comandaextras = [];
         }
         }
         else
         {
            listado_comandaextras.forEach((score) => {
             if (score[0] == cuentaactual)
             {
               if (score[1] == idfinal)
               {
                 score[4] = diff;                 
               }
             }
           });
         }
      }
       //borrarlo si volvio al valor original, no debe haber extra si la differencia es 0
      if (repetido == true && diff == 0)
      {
         borrarIndex = [];
         
         listado_comandaextras.forEach((score) => {
               if (score[0] == cuentaactual && score[1] == idfinal)
               {
               }
               else
               {
                  borrarIndex.push(score);
               }
         });

         lista_comandaextras = [];
         listado_comandaextras = borrarIndex;
      }
   }


   if (ret.includes('ctnumprod1sz'))
   {
      // verificar el id del original y comprar cual es la cantidad y el valor precio unit
      cantidad_calcu = document.getElementById('calcuval').value;
      idfinal = ret.replace("ctnumprod1sz", ""); 
      cantidad = 0;

      if (cantidad_calcu < 1)
      {
               esconder_calculadora();
                  Swal.fire({
                  icon: 'info',
                  title: 'Valor Invalido',
                  text: 'No puede ser 0 o negativo' 
               }).then(function() {
               });  
               return;                
      }
      //find quantity
        //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
       // cuenta, idprod, nombre, precio, unidad, propina, pregunta
            listado_comanda.forEach(function(element) {

            if (element[0] == cuentaactualtmp && element[1] == idfinal && cantidad_calcu <= element[4])
            {
               if (element[4] >= 1)
               { 
                   document.getElementById(ret).value = cantidad_calcu;
                   document.getElementById('ctnumprodst' + idfinal).value = (cantidad_calcu*element[3]).toFixed(3);
                   document.getElementById('ctnumprod1ss' + idfinal).value = Number(element[3]).toFixed(3);
                   //guardar en listado_comandatmp la cantidad, el precio unitario basado en cuentaactual y id
                   actualizar_cantidadescortesia(cantidad_calcu,Number(element[3]).toFixed(3),idfinal);
                   esconder_calculadora();
               }
            }
            else if (element[0] == cuentaactualtmp && element[1] == idfinal && cantidad_calcu > element[4])
            {
               esconder_calculadora();
               Swal.fire({
                icon: 'info',
                title: 'Valor Invalido',
                text: 'No puede ser mayor que : ' + element[4]
              }).then(function() {
              });  
              return;
            }
            });
      return;
   }


   if (ret.includes('tasignar'))
   {
      valtmp = ret.replace("tasignar", "");   
      valtmp2 = 'tnumprods' + valtmp
      if (parseInt(document.getElementById('calcuval').value) > parseInt(document.getElementById(valtmp2).value))
      {
         esconder_calculadora();
         Swal.fire({
                icon: 'info',
                title: 'Error',
                text: 'No se puede exceder el valor existente del producto en la comanda'
              }).then(function() {
              });  
      }
      else if (parseInt(document.getElementById('calcuval').value) <= 0)
      {
         esconder_calculadora();
         Swal.fire({
                icon: 'info',
                title: 'Error',
                text: 'No puede ser 0, escoga al menos 1'
              }).then(function() {
              }); 
      }
      else
      {
      document.getElementById(ret).value = parseInt(document.getElementById('calcuval').value)
      esconder_calculadora();
      }
      return;
   }

   if (ret.includes('tquitar'))
   {
      valtmp = ret.replace("tquitar", "");   
      valtmp2 = 'qnumprods' + valtmp
      if (parseInt(document.getElementById('calcuval').value) > parseInt(document.getElementById(valtmp2).value))
      {
         esconder_calculadora();
         Swal.fire({
                icon: 'info',
                title: 'Error',
                text: 'No se puede exceder el valor existente del producto en la comanda'
              }).then(function() {
              });  
      }
      else if (parseInt(document.getElementById('calcuval').value) <= 0)
      {
         esconder_calculadora();
         Swal.fire({
                icon: 'info',
                title: 'Error',
                text: 'No puede ser 0, escoga al menos 1'
              }).then(function() {
              }); 
      }
      else
      {
      document.getElementById(ret).value = parseInt(document.getElementById('calcuval').value)
      esconder_calculadora();
      }
      return;
   }

   if (ret == 'numpersonas')//si viene del document de num personas solo cambiarlo y salirse
   {
      // si ya esta guardado no se deberia poder modificar nada
      if (document.getElementById('ordenactual').innerText != 0 && usuario != 'ADMIN')
      {
         Swal.fire({
                icon: 'info',
                title: 'No se puede modicar',
                text: 'Ya guardo la orden, si quiere agregar mas personas contacte al administrador del sistema!'
              }).then(function() {
              });  
              return;
      }


      document.getElementById(ret).value = parseInt(document.getElementById('calcuval').value);
      if (listado_comanda.length > 0)
      {
      if (document.getElementById('mesaactual').innerText != 'llevar')
      {
      logica_cover_actualizar();
      logica_consumo_actualizar(); 
      }
      }
      esconder_calculadora();
      return;
   }

    if (document.getElementById('calcuval').value != '')
   {
   if (document.getElementById('calcuval').value != '0')
   {   
   //por cover
   idprodtmp = ret.replace("numprods", "");   
   if (idprodtmp != 'CV')
   {
   document.getElementById(ret).value = parseInt(document.getElementById('calcuval').value);
   }
   actualizar_numprods_decalcu(ret);
   logica_consumo_actualizar(); 
   }
   }
   esconder_calculadora();

   //bug fix flashing to like principal
     
   if (ret.includes('numprods'))
   {  
   if (cuentaactual == 'Principal') 
      {
         document.getElementById('cuentaprincipal').click();
      }
      else
      {
      document.getElementById('cuenta_' + cuentaactual).click();
      }

   }

  }

  function borrar_calc()
  {
   var text = document.getElementById('calcuval').value;
   var editedText = text.slice(0, -1) 
   document.getElementById('calcuval').value = editedText;
 }

 function mostrar_vistadetallada()
 {
   //REFRESCAR  Y MOSTRAR LA PANTALLA
   actualizar_colores();
   refrescar_vistadetallada();
   document.getElementById("myModaldetalles").style.display = '';
 }

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

 function cerrar_vistadetallada()
 {
   document.getElementById("myModaldetalles").style.display = 'none';
 }

 function unir_mesas()
 {
   if (document.getElementById('ordenactual').innerText != 0 )
   {
      Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Ya unio las mesas y guardo, no se pueden modificar!'
              }).then(function() {
              }); 

   }
    else if (document.getElementById('mesaactual').innerText != 'llevar')
   {
   if (mesas_unidas.length == 0)
   {
      var mesasu = '';
   }
   else
   {
      var mesasu = [];
      mesasu = mesas_unidas;
   }
   //obtener con la mesa actual sus uniones
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          mesasu: mesasu,
          mesaact: document.getElementById("mesaactual").innerText,
          mesauni: document.getElementById("smesaactual").value,
          usuarioc: document.getElementById('usermesero').value,
          estado: 'grid_mesas_union'
       },
       beforeSend: function() {
       },
       success: function(r) {
         $('#myModalunirmesas').html('<center> <b>MESAS A UNIR : </b><br>' + r + '<br> <button onClick="cerrar_unirmesas()"> CERRAR </button></center>');   
         document.getElementById("myModalunirmesas").style.display = '';
         draw_mesasunidas();
       }
       });
      }
      else
      {
         Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No se puede ya que es para llevar!'
              }).then(function() {
              });  
      }
 }

 function mover_mesa()
 {
   ver_modificar();

   if (document.getElementById('mesaactual').innerText != 'llevar')
   {
   if (mesas_unidas.length == 0)
   {
      var mesasu = '';
   }
   else
   {
      var mesasu = [];
      mesasu = mesas_unidas;
   }
   //obtener con la mesa actual sus uniones
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          mesasu: mesasu,
          mesaact: document.getElementById("mesaactual").innerText,
          usuarioc: document.getElementById('usermesero').value,
          estado: 'grid_mesas_mover'
       },
       beforeSend: function() {
       },
       success: function(r) {
         $('#myModalmovermesa').html('<center> <b>MESA A MOVER : </b><br>' + r + '<br> <button onClick="cerrar_movermesa()"> CERRAR </button></center>');   
         document.getElementById("myModalmovermesa").style.display = '';
       //  draw_mesasunidas();
       }
       });
      }
      else
      {
         Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'No se mover mesa ya que es para llevar!'
              }).then(function() {
              });  
      }
 }

 function dividir_cuentas()
 {
   // determinar si es una cuenta unica, si ya esta dividida no tiene sentido meterse a la pantalla de dividir
   if (listado_comanda.every(score => score[0] == 'Principal')) 
   {
   }
   else
   {
         Swal.fire({
                icon: 'info',
                title: 'Advertencia',
                text: 'Esta cuenta ya esta dividida!'
              }).then(function() {
              });  
      return;
   }

   //hacerlas temporal si no hay nada, no hay que dividir
   if (listado_comanda.length == 0)
   {
      Swal.fire({
                icon: 'info',
                title: 'Agrege productos',
                text: 'No hay nada que dividir!'
              }).then(function() {
              });  
      return;
   }

   if (document.getElementById('numpersonas').value < 2)
   {
      Swal.fire({
                icon: 'info',
                title: 'Agrege productos',
                text: 'Deben haber al menos 2 personas para poder dividir en cuentas'
              }).then(function() {
              });  
      return;
   }
  
  agregar_cuenta = '<input type="text" id="clientetmp" placeholder="Nombre" size="10px"/><button type="button" class="btn btn-primary btn-sm" onClick="agregar_subcuentatmp()">Agregar cuenta</button>';
  botones_cuentas = '  <div id="mesacuentastmp" style="overflow:auto;border-style: double;"><table style="overflow:auto;"><tr><td><button type="button" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle" id="cuentaprincipaltmp" onClick="seleccionar_cuenta_principaltmp(this.id)">Principal</button></td></tr></table></div>';
  tabla_listado = '<div style="display: flex;justify-content: right;align-items: right;">CUENTA SELECCIONADA : <input type="text" id="cuentaseleccionadatmp" readonly> </div><div style="display: flex;justify-content: center;align-items: center;"><div id="listadoadividir" style="height:380px;width:500px;overflow:auto;float:left;box-sizing: border-box;padding: 10px;border: 3px double black;"></div>';
  tabla_division = '<div style="height:380px;width:500px;overflow:auto;float:left;box-sizing: border-box;padding: 10px;border: 3px double black;" id="division"></div></div>';

  $('#myModaldividircuentas').html('<center> <b>DIVIDIR CUENTAS : </b></center><br>' + agregar_cuenta + botones_cuentas + tabla_listado + tabla_division + '<br><center><button onClick="procesar_dividircuentas()"> DIVIDIR CUENTAS </button> <button onClick="cerrar_dividircuentas()"> CERRAR </button></center>');   

   //llenar las cuentas
   cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principaltmp(this.id)" id="cuentaprincipaltmp" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';

   // llenar cuentas comanda tmp del original no asignar
    cuentas_comanda.forEach(function(element) {
      cuentas_comandatmp.push(element);
    });


  
   cuentas_comandatmp.forEach(function(element) {
   if (element != 'Principal')
   {
   cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuentatmp(this.id)"  onClick="seleccionar_cuentatmp(this.id)" id="cuentatmp_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
   }
   });

   cuentasllenar += '</tr></table>';

   $('#mesacuentastmp').html('');
   $('#mesacuentastmp').html(cuentasllenar);
   document.getElementById('clientetmp').value = '';
   cambiar_color_cuentatmp();
   document.getElementById('clientetmp').focus();

   //llenar listado de comanda en el temp
   // Create a deep copy of listado_comanda
   listado_comandatmp = JSON.parse(JSON.stringify(listado_comanda))
   .reduce(function(result, element) {
    if (element[1] !== 'CV' && element[1] !== 'CM') {
      result.push(element.slice()); // Create a shallow copy of the element
    }
    return result;
   }, []);



   //REEMPLAZAR TODOS POR PRINCIPAL POR SI ESTABAN YA DIVIDIENDOLA SOLO SI NO ESTA DIVIDIDA YA, SI NO COPIARLA TAL CUAL ES:
      listado_comandatmp.forEach((score) => {
        score[0] = 'Principal';        
      });

 

  // SUMAR TODOS EN UNO SOLO
      const result = Object.values(listado_comandatmp.reduce((acc, curr) => {
      const key = curr[2];
      if (!acc[key]) {
         acc[key] = [...curr];
         acc[key][4] = +curr[4];
      } else {
         acc[key][4] += +curr[4];
         if (curr[5] === 'false') {
            acc[key][5] = 'false';
         }
      }
      return acc;
      }, {}));

      result.forEach(item => {
      item[5] = item[5] === 'true';
      item.pop();
      });

      // console.log(listado_comandatmp);
      // console.log(result);
      // console.log(cuentas_comandatmp);

      // verificar que al menos halla un item
   if (listado_comandatmp.length == 1)
   {
      ret = 0;
      listado_comandatmp.forEach((score) => {
        if (score[4] < 2)  
        {
         ret = 1;
        }
      });

      if (ret == 1)
      {
         Swal.fire({
                icon: 'info',
                title: 'Agrege productos',
                text: 'Solo hay un producto, no se puede dividir'
              }).then(function() {
              }); 
         document.getElementById("myModaldividircuentas").style.display = 'none';
         listado_comandatmp = [];
         cuentas_comandatmp = [];
         listado_comandatmp2 = [];
         cuentaactualtmp = 'Principal'; 
         return;  
      }
   }

   listfinal2 ='';

   listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:12px;"><b><tr><th>CANT</th><th scope="col">DETALLE</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th><th> ASIGNAR </th></tr></b>';

   total_prop = 0;
   result.forEach((score) => {
      if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
      if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
      listfinal += '<tr><td style="width:45px"><input type="text" id="tnumprods' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td>$ <input type="text" id="tnumprodss' + score[1] + '" style="text-align:center;width:50px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td><td><input type="number" id="tasignar' + score[1] + '"    style="text-align:center;width:40px" readonly onclick="mostrar_calculadora(this.id)" value="1"/><button class="btn-primary" id="vasignar' + score[1] + '" onclick="asignar_dividirtmp(this.id)"> >> </button></td></tr>';
   });

   listfinal += '</table>';

   $('#listadoadividir').html('');
   $('#listadoadividir').html(listfinal);
   

   document.getElementById("myModaldividircuentas").style.display = '';
 }

 function cerrar_unirmesas()
 {
   document.getElementById("myModalunirmesas").style.display = 'none';
 }

 function cerrar_movermesa()
 {
   document.getElementById("myModalmovermesa").style.display = 'none';
 }



 function cerrar_dividircuentas()
 {
   Swal.fire({
   icon: 'info',
   title: 'Cancelar dividir cuentas',
   text: 'Esta seguro que quiere cancelar dividir cuentas?, perdera sus cambios',
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
         document.getElementById("myModaldividircuentas").style.display = 'none';
         listado_comandatmp = [];
         cuentas_comandatmp = [];
         listado_comandatmp2 = [];
         cuentaactualtmp = 'Principal';
      }
      });
 }

 function cerrar_dividircuentas_noprompt()
 {
         document.getElementById("myModaldividircuentas").style.display = 'none';
         listado_comandatmp = [];
         cuentas_comandatmp = [];
         listado_comandatmp2 = [];
         cuentaactualtmp = 'Principal';
         //refrescar la comanda ahora con los nuevos valores
         //cuentas_comanda.push('Principal');
         cuentaactual = 'Principal'
             

         //fix
         i = 0;
         listado_comanda.forEach((score) => {
               if (score[1] == 'CV') 
               {
               }
               else if (score[1] == 'CM') 
               {
               }
               else
               {  
                  if (score[0] == 'Principal')
                  {
                  listado_comanda.splice(i,1);
                  }                  
               }
         i++;      
         });
                  //generar las cuentas html de nuevo antes del click final
            //llenar las cuentas
            cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principal(this.id)" id="cuentaprincipal" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';

            cuentas_comanda.forEach(function(element) {
            if (element != 'Principal')
            {
            cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuenta(this.id)"  onClick="seleccionar_cuenta(this.id)" id="cuenta_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
            }
            });

            cuentasllenar += '</tr></table>';

            $('#mesacuentas').html('');
            $('#mesacuentas').html(cuentasllenar);
            //click final
            document.getElementById('cuentaprincipal').click();

 }


 function llenar_zona_unir(zona)
 {
   //obtener con la mesa actual sus uniones
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          mesaactual: document.getElementById('mesaactual').innerText,
          zona: zona,
          estado: 'llenar_zonas_unir'
       },
       beforeSend: function() {
       },
       success: function(r) {
         $('#mesasunir').html('');
         $('#mesasunir').html(r);
       }
       });
 }


 function llenar_zona_mover(zona)
 {
   //obtener con la mesa actual sus uniones
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          mesaactual: document.getElementById('mesaactual').innerText,
          zona: zona,
          estado: 'llenar_zonas_mover'
       },
       beforeSend: function() {
       },
       success: function(r) {
         $('#mesasmover').html('');
         $('#mesasmover').html(r);
       }
       });
 }

 function llenar_zona_liberar(zona)
 {
   //obtener con la mesa actual sus uniones
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          zona: zona,
          estado: 'llenar_zonas_liberar'
       },
       beforeSend: function() {
       },
       success: function(r) {
         $('#mesas_a_liberar').html('');
         $('#mesas_a_liberar').html(r);
       }
       });
 }

 function abrir_zona(event)
 {
   llenar_zona_unir(event.target.value);
 }

 function abrir_zona_mover(event)
 {
   llenar_zona_mover(event.target.value);
 }

 function abrir_zona_liberar(event)
 {
   llenar_zona_liberar(event.target.value);
 }

 function liberar_mesa(id)
 {
  // revisar que no sea principal si es admin si no error diciendo solo puede liberar submesas
     var usuario = sessionStorage.getItem('currentloggedin');
     var smesa = '';
     var principal = 'SI';


         //verificar si es submesa
   mesa_de_parent = 0;
   // find if its a submesa, if so then pick parent mesa always
   //const mesa = 21; // Assuming the mesa value is 21
   const elementId = 'smesa_' + id;
   const element = document.getElementById(elementId);

   //let numberInParentheses = null;
   if (element) {
   const labelElement = element.querySelector('label');
   const labelText = labelElement.innerText;

   const pattern = /\((\d+)\)/;
   const match = labelText.match(pattern);

   if (match) {
      mesa_de_parent = 1;
      smesa = match[1];
      principal = 'NO';
   }
   }


   if (usuario != 'ADMIN')
   {
   if (mesa_de_parent != 1)
   {
      Swal.fire({
                icon: 'error',
                title: 'Permisos',
                text: 'No tiene permisos para liberar una Mesa Principal, solo las mesas unidas'
              }).then(function() {
              });  
      return;
   }
   }

   

       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          mesa: id,
          smesa: smesa,
          principal: principal,
          estado: 'liberar_mesao'
       },
       beforeSend: function() {
       },
       success: function(r) {
        // var button = document.getElementById('eliminar' + id);
        // button.parentNode.removeChild(button);
         llenar_zona_liberar(document.getElementById('selectzona').value);
         actualizar_colores();
       }
       });
 }

 function agregar_submesa(id)
 {
      if (!mesas_unidas.includes(id)) {
       var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          submesa: id,
          usuarioc : document.getElementById('usermesero').value,
          mesa: document.getElementById('mesaactual').innerText,
          estado: 'agregar_submesa'
       },
       beforeSend: function() {
       },
       success: function(r) {
         if (r > 0)
         {
         mesas_unidas.push(id);
         draw_mesasunidas();
         }
         else
         {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'La mesa esta ocupada!'
              }).then(function() {
              });  
         }
       }
       });
      }
      else
      {
         Swal.fire({
                icon: 'info',
                title: 'Unir Mesas',
                text: 'La mesa ya fue unida!'
              }).then(function() {
              });  
      }
 }

 function mover_mesa_a(id)
 {
  // con la mesa ir a cambiarla a la tabla mesa estado
  // ver si no esta ocupada por nadie
  Swal.fire({
   icon: 'info',
   title: 'Cambio de mesa',
   text: 'Esta seguro que quiere mover la mesa : ' + document.getElementById('mesaactual').innerText + ' hacia mesa : ' + id ,
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
         movimiento_demesa(id);
      }
      });
 }

 function movimiento_demesa(id)
 {
      var usuario = sessionStorage.getItem('currentloggedin');
       var usuariob = document.getElementById('meseroact').value;

       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          usuariob: usuariob,
          orden: document.getElementById('ordenactual').innerText,
          mesa: id,
          mesaori: document.getElementById('mesaactual').innerText,
          numpersonas: document.getElementById('numpersonas').value,
          submesa: document.getElementById('smesaactual').value,
          estado: 'accion_mover_mesa'
       },
       beforeSend: function() {
       },
       success: function(r) {
           if (r == 0)
        {         
         Swal.fire({
                icon: 'info',
                title: 'MESA #' + id,
                text: 'Ocupada '
              }).then(function() {
              });
        }         
        else
        {
         cerrar_movermesa();
         document.getElementById('mesaactual').innerText = id;         
         Swal.fire({
                icon: 'info',
                title: 'Movimiento Completado',
                text: 'Puede usar la mesa : ' + id
              }).then(function() {
              });
        }
       }
       });
 }


 function draw_mesasunidas()
 {
   r = '';
   r2 = '';
   if (mesas_unidas.length > 0)
   {
    mesas_unidas.forEach(function(element) {
    r += '<button value="' + element + '" onclick="quitar_submesa(' + element + ')" class="btn-success" style="width:32px">'  + element + '</button> &nbsp';
    r2 += element + ',';
   });
   }
   r2 = r2.slice(0, -1);

   document.getElementById('unidas').value = r2;
   document.getElementById('smesaactual').value = r2;
   $('#mesasunidas').html('');
   $('#mesasunidas').html(r);

 }

 function quitar_submesa(id)
 {
   var usuario = sessionStorage.getItem('currentloggedin');
       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          submesa: id,
          mesa: document.getElementById('mesaactual').innerText,
          estado: 'quitar_submesa'
       },
       beforeSend: function() {
       },
       success: function(r) {
         const filteredArray = mesas_unidas.filter(item => item !== id);
         mesas_unidas = filteredArray;
         draw_mesasunidas();
       }
       });
 }

// de clientes
 function config_clientes()
{
  //var usuario = sessionStorage.getItem('currentloggedin'); USUARIO DEBE SER EL MESERO EN ESTE CASO CON PRIV 9 DE CLIENTES
   var usuario = document.getElementById('meseroact').value;

   $.ajax({
        type: "POST",
        url: "inter_configs_pantallas.php",
        datatype: "html",
        data: {
           usuario: usuario,
           estado: 'tab_clientes_comanda'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#myModalclientesV').html('');
          $('#myModalclientesV').html(r);
          if (r.includes("escliente"))
          {
          bgestadocolorc();
          }
          else
          {
            $('#myModalclientesV').html('');
          }
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
           estado: 'redraw_clientes_comanda'
        },
        beforeSend: function() {
        },
        success: function(r) {
          $('#myModalclientes').html('');
          $('#myModalclientes').html(r);          
      }
      });
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

        }
      });
  }

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


   function seleccionar_cliente_comanda(cliente)
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
        dui_comanda = data[4];
        document.getElementById('clientecid').value = data[1] + ' ' + data[2];
        document.getElementById("myModalclientesV").style.display = 'none';
         }
      });
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

function filtrar_clientes_key(e) 
{
  if(e.keyCode === 13)
  {
  e.preventDefault();
  filtrar_cliente();
  }
}

function mostrar_liberarmesas()
{  
   var usuario = sessionStorage.getItem('currentloggedin');
   var usuarioc = document.getElementById('meseroact').value;

   if (usuario != 'ADMIN')
   {
      if (document.getElementById('meseroact').value == '')
      {
         mostrar_modalmeseros();
         return;
      }
   }

       $.ajax({
       type: "POST",
       url: "inter_comanda.php",
       datatype: "html",
       data: {
          usuario: usuario,
          usuarioc: usuarioc,
          estado: 'grid_mesas_liberar'
       },
       beforeSend: function() {
       },
       success: function(r) {
         $('#myModalliberarmesa').html('<center> <b>MESAS A LIBERAR : </b><br>' + r + '<label style="font-size:10px">Si selecciona la mesa principal, las mesas unidas se liberaran tambien </label><br> <button onClick="cerrar_liberarmesas()"> CERRAR </button></center>');   
         document.getElementById("myModalliberarmesa").style.display = '';
       }
       });

   document.getElementById('myModalliberarmesa').style.display = '';
}


function cerrar_liberarmesas()
{
   document.getElementById("myModalliberarmesa").style.display = 'none';
}

function esconder_clientescomanda()
{
   document.getElementById("myModalclientesV").style.display = 'none';
}

function display_lista()
{
   console.log("ori");
   console.log(listado_comandaori);
   console.log("   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6");
   console.log("cuenta, idprod, nombre, precio, unidad, propina, pregunta");
   console.log(listado_comanda);
   console.log("EXTRAS :");
   console.log(listado_comandaextras);
}

function logeo_admin()
{
   if (document.getElementById('logeoadmin').style.backgroundColor == 'green')
   {
      document.getElementById('logeoadmin').style.backgroundColor = '';
      document.getElementById('logeoadmin').innerText = 'USUARIO';
      sessionStorage.setItem('currentloggedin', usuario_comandatmp);
      document.getElementById('usuariomaster').value = usuario_comandatmp;
      deshabilitar_opciones(usuario_comandatmp,document.getElementById('usermesero').value);      
      return;
   }

   if (document.getElementById('myModalusuariocomanda2').style.display != '')
   {
   document.getElementById('myModalusuariocomanda2').style.display = '';
   document.getElementById('usermesero2').focus();   
   }
   else
   {
      document.getElementById('myModalusuariocomanda2').style.display = 'none';
      document.getElementById('usermesero2').value = '';   
      document.getElementById('usermeseropass2').value = '';   
   }
}

function ver_precuenta()
{
   if (listado_comanda.length == 0)
   {
      Swal.fire({
                icon: 'info',
                title: 'Agrege items a la comanda',
                text: 'No Hay nada que mostrar en la Pre Cuenta'
              }).then(function() {
                
              });
   }
   else if (document.getElementById('ordenactual').innerText == '' || document.getElementById('ordenactual').innerText == 0 || document.getElementById('ordenactual').innerText == 'LLEVAR')
   {
      Swal.fire({
                icon: 'info',
                title: 'Error al generar Precuenta',
                text: 'No se puede generar la Precuenta'
              }).then(function() {
                
              });
   }
   else
   {
      generar_precuenta();      
   }
}

function generar_precuenta()
{

   if (document.getElementById('myModalprecuenta').style.display == '')
   {
      document.getElementById('myModalprecuenta').style.display = 'none';
      return;
   }

  //SUMARIZAR EL PREVIEW
  listado_comanda_precuenta = [];

  listado_comanda_precuenta = JSON.parse(JSON.stringify(listado_comanda))
   .reduce(function(result, element) {
      result.push(element.slice()); // Create a shallow copy of the element
    return result;
   }, []);



   if (cuentas_comanda.length > 1)
   {
      if (cuentaactual != 'Principal')
      {
         //SPLICE ADECUADO
         let i = listado_comanda_precuenta.length - 1;
         for (i; i >= 0; i--) {
         if (listado_comanda_precuenta[i][0] !== cuentaactual) {
            listado_comanda_precuenta.splice(i, 1);
         }
         }
      }
   }
   /// VERSION VIEJA SIN EXCLUIR LOS ITEMS CON VALOR DE CORTESIA 0
   // const result2 = Object.values(listado_comanda_precuenta.reduce((acc, curr) => {
   //    const key = curr[2];
   //    if (!acc[key]) {
   //       acc[key] = [...curr];
   //       acc[key][4] = +curr[4];
   //    } else {
   //       acc[key][4] += +curr[4];
   //       if (curr[5] === 'false') {
   //          acc[key][5] = 'false';
   //       }
   //    }
   //    return acc;
   //    }, {}));

   //    result2.forEach(item => {
   //    item[5] = item[5] === 'true';
   //    item.pop();
   //    });

         const result2 = Object.values(listado_comanda_precuenta.reduce((acc, curr) => {
         const key = curr[2];
         if (curr[3] === 0) {
            return acc; // Skip and ignore if item[3] is 0
         }
         if (!acc[key]) {
            acc[key] = [...curr];
            acc[key][4] = +curr[4];
         } else {
            acc[key][4] += +curr[4];
            if (curr[5] === 'false') {
               acc[key][5] = 'false';
            }
         }
         return acc;
      }, {}));

      result2.forEach(item => {
         item[5] = item[5] === 'true';
         item.pop();
      });


     ///generar items de la precuenta sumarizados
     // listfinalprint = '<div style="font-size:9px;font-weight:bold;display: inline-block">';
     // listfinalprint += '<label style="width: 100px;text-align:left;">CANT</label><label style="width: 300px;text-align:left;">PRODUCTO</label><label style="width: 100px;text-align:left;">P.UNIT</label><label style="width: 100px;text-align:left;">PRECIO</label>';

      let listfinal = '<table style="width: 100%; height: 100%;">';
      listfinal += '<thead><tr style="font-size: 12px"><th style="width: 20%;">CANT</th><th style="width: 50%;">PRODUCTO</th><th style="width: 15%;">P.UNI</th><th style="width: 15%;">PRECIO</th></tr></thead>';

      let total_prop = 0;
      result2.forEach((score) => {
      const isSP = score[5] === 'false';
      const prop = isSP ? ' (SP)' : '';
      const nota = score[6] === '' ? 'notes.png' : 'notes1.png';
      const rowStyle = score[1] === 'CV' || score[1] === 'CM' ? 'font-weight: bold;font-size: 10px' : 'font-size: 10px';

      listfinal += '<tr style="' + rowStyle + '">';
      listfinal += '<td style="text-align:center">' + score[4] + '</td>';
      listfinal += '<td style="text-align:left">' + score[2] + prop + '</td>';
      listfinal += '<td style="text-align:center">' + Number(score[3]).toFixed(2) + '</td>';
      listfinal += '<td style="text-align:center">' + (Number(score[3])*Number(score[4])).toFixed(2) + '</td>';
      listfinal += '</tr>';

      //listfinalprint += '<label style="display: inline-block;width: 300px;text-align:left;">' + document.getElementById('clientecid').value + '</label><br>';;

      });

      listfinal += '</table>';

     // listfinalprint += '</div>';

     // sub  HEADER DE LA PRECUENTA
     const currentDate = new Date();
     const formattedDate = currentDate.toLocaleDateString('en-GB');
     const formattedTime = currentDate.toLocaleString('en-GB', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      });


      listheader = '' ;
      listheader =  '<table style="width: 100%; height: 100%;">';
      listheader += '<tr>';
      listheader += '<td style="text-align:left">Cliente: ';
      listheader += '<td style="text-align:left">' + document.getElementById('clientecid').value + '</td>';
      listheader += '<td style="text-align:right"></td>';
      listheader += '</tr>';
      listheader += '<tr>';
      listheader += '<td style="text-align:left">Mesero: ';
      listheader += '<td style="text-align:left">' + document.getElementById('meseroact2').value + '</td>';
      listheader += '<td style="text-align:right"></td>';
      listheader += '</tr>';
      listheader += '<tr>';
      listheader += '<td style="text-align:left">Mesa: ';
      listheader += '<td style="text-align:left">' + document.getElementById('mesaactual').innerText + '</td>';
      listheader += '<td style="text-align:left">FECHA: ' + formattedDate + '</td>';
      listheader += '</tr>';
      listheader += '<tr>';
      listheader += '<td style="text-align:left">Comanda No: ';
      listheader += '<td style="text-align:left">' + document.getElementById('ordenactual').innerText + '</td>';
      listheader += '<td style="text-align:left">HORA : ' + formattedTime + '</td>';
      listheader += '</tr>';
      listheader += '</table>';
       //para impresion
      listheaderprint = '' ;
      listheaderprint +=  '<center><table style="font-size:11px;font-weight:bold;">';
      listheaderprint += '<th>PRECUENTA <br>';
      listheaderprint += 'TICKET DE PREVENTA <br>';
      listheaderprint += '"RESTAURANTE AUTOMARISCOS" <br><br></th>';
      listheaderprint += '</table></center>';
      
      listheaderprint += '<div style="font-size:9.5px;font-weight:bold;">';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">Cliente: </label><label style="display: inline-block;width: 300px;text-align:left;">' + document.getElementById('clientecid').value + '</label><br>';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">Mesero: </label><label style="display: inline-block;width: 200px;text-align:left;">' + document.getElementById('meseroact2').value + '</label><br>';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">Mesa: </label><label style="display: inline-block;width: 100px;text-align:left;">' + document.getElementById('mesaactual').innerText + '</label>';
      listheaderprint += '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">FECHA: </label><label style="display: inline-block;width: 100px;text-align:left;">' + formattedDate + '</label><br>';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">Comanda: </label><label style="display: inline-block;width: 200px;text-align:left;">' + document.getElementById('ordenactual').innerText + '</label>';
      listheaderprint += '&nbsp&nbsp&nbsp';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">HORA: </label><label style="display: inline-block;width: 100px;text-align:left;">' + formattedTime + '</label><br>';
      listheaderprint += '____________________________________________';
      listheaderprint += '</div>';
      //para impresion


      //document.getElementById('datosmesa').innerHTML = 'Cliente&nbsp: ' + document.getElementById('clientecid').value + '<br>Mesa&nbsp&nbsp&nbsp&nbsp: ' + document.getElementById('mesaactual').innerText + '<br>Mesero&nbsp: ' + document.getElementById('meseroact2').value + '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFECHA:' + '<br>Comanda No: ' + document.getElementById('ordenactual').innerText + '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspHORA:' ; 
      document.getElementById('datosmesa').innerHTML = listheader;
      $('#contenidoprecuenta').html(listfinal);
      totales = document.getElementById('totales_precuenta').value;
      var totalesn = totales.split(',');

      listtotales  = '' ;
      listtotales  +=  '<table style="width: 50%; height: 50%;font-size:12px;margin-left: auto; margin-right: 10px;">';
      listtotales  += '<tr>';
      listtotales  += '<td style="text-align:left">SUB-TOTAL';
      listtotales  += '<td style="text-align:left">:</td>';
      listtotales  += '<td style="text-align:right">$</td>';
      listtotales  += '<td style="text-align:right">' + totalesn[1] + '</td>';
      listtotales  += '</tr>';
      listtotales  += '<tr>';
      listtotales  += '<td style="text-align:left">PROPINA';
      listtotales  += '<td style="text-align:left">:</td>';
      listtotales  += '<td style="text-align:right">$</td>';
      listtotales  += '<td style="text-align:right">' + totalesn[2] + '</td>';
      listtotales  += '</tr>';
      listtotales  += '<tr>';
      listtotales  += '<td style="text-align:left">GRAN TOTAL';
      listtotales  += '<td style="text-align:left">:</td>';
      listtotales  += '<td style="text-align:right">$</td>';
      listtotales  += '<td style="text-align:right">' + totalesn[0] + '</td>';
      listtotales  += '</tr>';
      listtotales  += '</table>';

      listtotalesprint  = '';
      listtotalesprint  += '<div style="font-size:12px;font-weight:bold;text-align:right">'; ;
      listtotalesprint += '<label style="display: inline-block;width: 100px;text-align:leftt;">SUB-TOTAL: $</label>&nbsp&nbsp&nbsp<label style="display: inline-block;width: 200px;text-align:right;">' + totalesn[1] + '</label><br>';
      listtotalesprint += '<label style="display: inline-block;width: 100px;text-align:left;">PROPINA: $</label>&nbsp&nbsp&nbsp<label style="display: inline-block;width: 200px;text-align:right;">' + totalesn[2] + '</label><br>';
      listtotalesprint += '<label style="display: inline-block;width: 100px;text-align:left;">GRAN TOTAL: $</label>&nbsp&nbsp&nbsp<label style="display: inline-block;width: 200px;text-align:right;">' + totalesn[0] + '</label>';
      listtotalesprint  += '</div>'; ;

      $('#precuentat').html(listtotales);
      document.getElementById('myModalprecuenta').style.display = '';

      // variables que se pueden imprimir:
      precuenta_printh = listheaderprint + listfinal + '____________________________' + listtotalesprint ;
}

function cerrar_precuenta_form()
{
   document.getElementById('myModalprecuenta').style.display = 'none';
}


function imprimir_precuenta()
{
   imprimir_epson(document.getElementById('ordenactual').innerText,'precuenta_')
    .then(() => {
      Swal.fire({
        icon: 'info',
        title: 'Imprimiendo...',
        text: 'Imprimiendo Precuenta de mesa: ' + document.getElementById('mesaactual').innerText,
        timer: 2000,
        showConfirmButton: false
      });

      document.getElementById('myModalprecuenta').style.display = 'none';

      $.ajax({
       type: "POST",
       url: "inter_impresion.php",
       async: false,
       datatype: "html",
       data: {
          usuario: document.getElementById('meseroact2').value,
          tipo: 'Precuenta',
          nota: '',
          mesa: document.getElementById('mesaactual').innerText,
          orden: document.getElementById('ordenactual').innerText,
          txthist: imprimir_var,
          estado: 'guardar_historial_impresion'
       },
       beforeSend: function() {
       },
       success: function(r) {
       }
       });

    })
    .catch(error => {
      console.error('Error printing:', error);
    });

}


function imprimir_epson(orden, tipo)
{
   return new Promise((resolve, reject) => {
      var uniqueId = Date.now().toString();
      uniqueId = uniqueId + '_' + document.getElementById('meseroact').value + '_' + orden;

      const richContent = `
      <!DOCTYPE html>
      <html>
      <head>
      </head>
      <body>
      ${precuenta_printh}
      </body>
      </html>
      `;

      const docx = htmlDocx.asBlob(richContent);

      const uniqueFilename = `${tipo}${uniqueId}.docx`;

      const formData = new FormData();
      formData.append('file', docx, uniqueFilename);

    fetch('guardar_impresiones.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      imprimir_var = result;
      resolve(); // Resolve the Promise when printing is complete
    })
    .catch(error => {
      imprimir_var = error;
      reject(error); // Reject the Promise if there's an error
    });
  });

}

function imprimir_ordenbar(id)
{
   if (document.getElementById('meseroact').value != '')
   {
      var prod = document.querySelector("#" + id);
      mesa = id.replace("imprimir_pre", "");
      orden = prod.dataset.orden;
      tiempo = prod.dataset.tiempo;

       //para impresion
            // sub  HEADER DE LA PRECUENTA
     const currentDate = new Date();
     const formattedDate = currentDate.toLocaleDateString('en-GB');
     const formattedTime = currentDate.toLocaleString('en-GB', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      });

   
       listheaderprint = '' ;
      listheaderprint +=  '<center><table style="font-size:11px;font-weight:bold;">';
      listheaderprint += '<th>ORDEN DE BAR <br>';
      listheaderprint += '"RESTAURANTE AUTOMARISCOS" <br>';
      listheaderprint += 'Transcurrido : ' + tiempo + ' mins </th>';
      listheaderprint += '</table></center>';

      listheaderprint += '<div style="font-size:9.5px;font-weight:bold;display: inline-block">';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">BAR: </label><label style="display: inline-block;width: 200px;text-align:left;">BARRA</label><br>';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">Mesero: </label><label style="display: inline-block;width: 200px;text-align:left;">' + document.getElementById('meseroact').value + '</label><br>';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">Mesa: </label><label style="display: inline-block;width: 100px;text-align:left;">' + mesa + '</label>';
      listheaderprint += '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">FECHA: </label><label style="display: inline-block;width: 100px;text-align:left;">' + formattedDate + '</label><br>';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">Comanda: </label><label style="display: inline-block;width: 200px;text-align:left;">' + orden + '</label>';
      listheaderprint += '&nbsp&nbsp&nbsp';
      listheaderprint += '<label style="display: inline-block;width: 100px;text-align:left;">HORA: </label><label style="display: inline-block;width: 100px;text-align:left;">' + formattedTime + '</label><br>';
      listheaderprint += '____________________________________________';
      listheaderprint += '</div>';

      // get al items
     //ajax que va llamar los items async off
     $.ajax({
       type: "POST",
       url: "inter_cocinabar.php",
       async: false,
       datatype: "html",
       data: {
          usuario: document.getElementById('meseroact').value,
          orden: orden,
          estado: 'obtener_listadobar'
       },
       beforeSend: function() {
       },
       success: function(r) {
         precuenta_printh = listheaderprint + r + '____________________________'; 
       }
       });

     imprimir_epson(orden,'ordenbar_')
    .then(() => {
      Swal.fire({
        icon: 'info',
        title: 'Imprimiendo...',
        text: 'Imprimiendo Orden de Bar de mesa: ' + mesa,
        timer: 2000,
        showConfirmButton: false
      });

       $.ajax({
       type: "POST",
       url: "inter_impresion.php",
       async: false,
       datatype: "html",
       data: {
          usuario: document.getElementById('meseroact').value,
          tipo: 'ordenbar',
          nota: '',
          mesa: mesa,
          orden: orden,
          txthist: imprimir_var,
          estado: 'guardar_historial_impresion'
       },
       beforeSend: function() {
       },
       success: function(r) {
       }
       });

    })
    .catch(error => {
      console.error('Error printing:', error);
    });
   }
}


function ver_modificar()
{
  if (document.getElementById('myModalmodificar').style.display == 'none')
  {
   document.getElementById('myModalmodificar').style.display = '';
  }
  else
  {
   document.getElementById('myModalmodificar').style.display = 'none';
  }
}

function cerrar_precuenta()
{
   document.getElementById('myModalmodificar').style.display = 'none';
}

function procesar_dividircuentas()
{
   // si existe al menos un Principal quiere decir que no las distribuyo todas:
      faltan_dividir = 0;
      faltan_dividirs = 0;
      listado_comandatmp.forEach((score) => {
      if (score[0] == 'Principal') {
         faltan_dividir ++;
      }
      if (score[4] != 0) {
         faltan_dividirs ++ ;
      }
      });


  if (cuentas_comandatmp.length == 1)
  {
   Swal.fire({
                icon: 'info',
                title: 'Agrege items a la comanda',
                text: 'No ha hecho ninguna division entre cuentas'
              }).then(function() {
             });
  }
  else if (faltan_dividir != 0 && faltan_dividirs != 0)
  {
   Swal.fire({
                icon: 'info',
                title: 'Divida todo lo que hay en la comanda',
                text: 'Aun quedan productos sin asignar a una cuenta, debe asignarlos todos!'
              }).then(function() {
                
              });
  }
  else
  {
   // como todo se cumplio borrar todo lo de listado_Comanda original menos CV y CM si existiese
   // insertarle todo lo de listado_comandatmp2 y luego borrar las variables tmp del dividir comanda
      
         i = 0;
         listado_comanda.forEach((score) => {
               if (score[1] == 'CV') 
               {
               }
               else if (score[1] == 'CM') 
               {
               }
               else
               {  
                  listado_comanda.splice(i,1);                  
               }
         i++;      
         });

         listado_comandatmp2.forEach((score) => {
            listado_comanda.push(score);
         });

     // borarr todas las cuentas originales
    // agregar las cuentas tmp a la cuentas verdaderas     
         i = 0;
         cuentas_comanda.forEach((score) => {
                cuentas_comanda.splice(i,1);                  
         i++;      
         });

         cuentas_comandatmp.forEach((score) => {
                cuentas_comanda.push(score);
         });
   
         Swal.fire({
         icon: 'success',
         title: 'OK',
         text: 'Se dividio todo con exito, actualizado'
         }).then(function() {
         });
         
         //todas las vars tmp a cero y refrescar comandas
         cerrar_dividircuentas_noprompt();

            // console.log('original');
            // console.log(listado_comanda);
            // console.log('tmp');
            // console.log(listado_comandatmp);
            // console.log('tmp2');
            // console.log(listado_comandatmp2);
            // console.log('cuentas');
            // console.log(cuentas_comanda);
  }

}

function asignar_dividirtmp(id)
{
   if (document.getElementById('cuentaseleccionadatmp').value == '')
   {
      Swal.fire({
                icon: 'info',
                title: 'Seleccione un Cliente',
                text: 'Seleccione un Cliente para asignar el producto'
              }).then(function() {                
              }); 
      return;
   }

   // se necesita el id nada mas y la cantidad a reemplazar
   idtmp = id.replace("vasignar", "");   
   valtmp = document.getElementById("tasignar" + idtmp).value;
   
   if (document.getElementById("tasignar" + idtmp).value != 0)
   {
     // Actualizar el nuevo array con el nombre de cuenta listado_comandatmp2 
      listado_comandatmp.forEach((score) => {
      if (score[1] == idtmp) {
         const cuentaseleccionada = document.getElementById('cuentaseleccionadatmp').value;
         const index = listado_comandatmp2.findIndex((item) => item[1] === score[1]);

         if (index === -1 || listado_comandatmp2[index][0] !== cuentaseleccionada) {
            listado_comandatmp2.push([
            cuentaseleccionada,
            score[1],
            score[2],
            score[3],
            valtmp,
            score[5],
            score[6]
            ]);
         } else {
            listado_comandatmp2[index][4] = parseInt(listado_comandatmp2[index][4]) + parseInt(valtmp);
         }

         score[4] = parseInt(score[4]) - parseInt(valtmp);
      }
      });

    redraw_asignados_noasignados();  

   //  console.log('original');
   //  console.log(listado_comanda);
   //  console.log('tmp');
   //  console.log(listado_comandatmp);
   //  console.log('tmp2');
   //  console.log(listado_comandatmp2);
   }
   else
   {
      Swal.fire({
                icon: 'info',
                title: 'Seleccione una Cantidad',
                text: 'No ha seleccionado la cantidad a dividir'
              }).then(function() {
                
              });
   }



}

function quitar_dividirtmp(id)
{
   // se necesita el id nada mas y la cantidad a reemplazar
   idtmp = id.replace("vquitar", "");   
   valtmp = document.getElementById("tquitar" + idtmp).value;

   if (document.getElementById("tquitar" + idtmp).value != 0)
   {
        // Actualizar el nuevo array con el nombre de cuenta listado_comandatmp2 
        listado_comandatmp2.forEach((score) => {
      if (score[1] == idtmp && score[0] == document.getElementById('cuentaseleccionadatmp').value) {
         // Check if score[1] already exists in listado_comandatmp2
         const index = listado_comandatmp.findIndex((item) => item[1] === score[1]);

         if (index === -1) {
         } else {
            listado_comandatmp[index][4] = parseInt(listado_comandatmp[index][4]) + parseInt(valtmp);
            listado_comandatmp[index][0] = 'Principal';
         }

         // Subtract valtmp from the original score[4] in listado_comandatmp
         score[4] = parseInt(score[4]) - parseInt(valtmp);
      }
      });

      //borrar los valores de cantidades 0 del listado dividir
         i = 0;
         listado_comandatmp2.forEach((score) => {
               if (score[4] == 0 && score[0] == document.getElementById('cuentaseleccionadatmp').value)
               {//borrar el item dentro de la cuenta actual y refrescar
                  listado_comandatmp2.splice(i,1);                  
               }
         i++;      
         });


    redraw_asignados_noasignados();

   //  console.log('original');
   //  console.log(listado_comanda);
   //  console.log('tmp');
   //  console.log(listado_comandatmp);
   //  console.log('tmp2');
   //  console.log(listado_comandatmp2);
   }
   else
   {
      Swal.fire({
                icon: 'info',
                title: 'Seleccione una Cantidad',
                text: 'No ha seleccionado la cantidad a regresar'
              }).then(function() {
                
              });
   }
}

function redraw_asignados_noasignados()
{
      // ACTUALIZAR LO DIVIDIDO
      listfinal ='';

      listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:12px;"><b><tr><th>QUITAR</th><th>CANT</th><th scope="col">DETALLE</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

      total_prop = 0;
      listado_comandatmp2.forEach((score) => {
         if (document.getElementById('cuentaseleccionadatmp').value == score[0])
         {
         if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
         if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
         listfinal += '<tr><td><button class="btn-danger" id="vquitar' + score[1] + '" onclick="quitar_dividirtmp(this.id)"> << </button><input type="number" id="tquitar' + score[1] + '"    style="text-align:center;width:40px" readonly onclick="mostrar_calculadora(this.id)" value="1"/></td><td style="width:45px"><input type="text" id="qnumprods' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td>$ <input type="text" id="qnumprodss' + score[1] + '" style="text-align:center;width:50px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="qnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         }
      });

      listfinal += '</table>';

      $('#division').html('');
      $('#division').html(listfinal);
    
      //ACTUALIZAR LO A ASIGNAR AHORA DESPUES DE RESTA
      listfinal ='';

      listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:12px;"><b><tr><th>CANT</th><th scope="col">DETALLE</th><th scope="col">P.UNITARIO</th><th scope="col">P.TOTAL</th><th> ASIGNAR </th></tr></b>';

      total_prop = 0;
      listado_comandatmp.forEach((score) => {
         if (score[4] != 0)
         {
         if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
         if (score[6] == '' || typeof score[6] === 'undefined' ) { nota = 'notes.png';} else { nota = 'notes1.png';}
         listfinal += '<tr><td style="width:45px"><input type="text" id="tnumprods' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" readonly/></td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td>$ <input type="text" id="tnumprodss' + score[1] + '" style="text-align:center;width:50px" value="' + Number(score[3]).toFixed(3)  + '" readonly/></td><td>$ <input type="text" id="numprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td><td><input type="number" id="tasignar' + score[1] + '"    style="text-align:center;width:40px" readonly onclick="mostrar_calculadora(this.id)" value="1"/><button class="btn-primary" id="vasignar' + score[1] + '" onclick="asignar_dividirtmp(this.id)"> >> </button></td></tr>';
         }
      });

      listfinal += '</table>';

      $('#listadoadividir').html('');
      $('#listadoadividir').html(listfinal);
}

function redraw_por_cuenta_cortesia()
{
         // ACTUALIZAR LO DIVIDIDO
         listfinal ='';

         listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:12px;"><b><tr><th style="background-color:lightblue"><input type="button" onclick="reset_valores_cortesiaall()" value="R" title="resetear valor de esta fila"/>CANT</th><th scope="col">DETALLE</th><th scope="col" style="background-color:lightblue">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

         total_prop = 0;
         listado_comandatmp.forEach((score) => {
            if (document.getElementById('cuentaseleccionadatmpcortesia').value == score[0])
            {
            if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
            //listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + score[4] + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
            rt = get_max_cortesia(score[0],score[1]);
           // listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + score[4] + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
           listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + rt + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
            }
         });

         listfinal += '</table>';


         $('#listadocortesia').html('');
         $('#listadocortesia').html(listfinal);
}

function redraw_por_principal_cortesia()
{

           // SUMAR TODOS EN UNO SOLO
           const result = Object.values(listado_comandatmp.reduce((acc, curr) => {
            const key = curr[2];
            if (!acc[key]) {
               acc[key] = [...curr];
               acc[key][4] = +curr[4];
            } else {
               acc[key][4] += +curr[4];
               if (curr[5] === 'false') {
                  acc[key][5] = 'false';
               }
            }
            return acc;
            }, {}));

            result.forEach(item => {
            item[5] = item[5] === 'true';
            item.pop();
            });


         // ACTUALIZAR LO DIVIDIDO
         listfinal ='';

         listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:12px;"><b><tr><th style="background-color:lightblue"><input type="button" onclick="reset_valores_cortesiaall()" value="R" title="resetear valor de esta fila"/>CANT</th><th scope="col">DETALLE</th><th scope="col" style="background-color:lightblue">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

         total_prop = 0;
         result.forEach((score) => {
            if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
            //listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + score[4] + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
            rt = get_max_cortesia(score[0],score[1]);
           // listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + score[4] + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
           listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + rt + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
            
         });

         listfinal += '</table>';


         $('#listadocortesia').html('');
         $('#listadocortesia').html(listfinal);
}

function ver_cortesia()
{
   ver_modificar();
   //no hay nada para cortesia
   if (listado_comanda.length == 0)
   {
      Swal.fire({
                icon: 'info',
                title: 'Agrege productos',
                text: 'No hay nada para asignar una cortesia!'
              }).then(function() {
              });  
      return;
   }

   if (document.getElementById('ordenactual').innerText == 0)
   {
      Swal.fire({
                icon: 'info',
                title: 'Orden no enviada',
                text: 'No ha enviado esta orden aun a Cocina/Bar'
              }).then(function() {
              });  
      return;
   }
  
  botones_cuentas = '  <div id="mesacuentastmpcortesia" style="overflow:auto;border-style: double;"><table style="overflow:auto;"><tr><td><button type="button" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle" id="cuentaprincipaltmpcortesia" onClick="seleccionar_cuenta_principaltmpcortesia(this.id)">Principal</button></td></tr></table></div>';
  tabla_listado = '<div style="display: flex;justify-content: left;align-items: left;">CUENTA SELECCIONADA : <input type="text" id="cuentaseleccionadatmpcortesia" readonly> </div><div style="justify-content: center;align-items: center;"><div id="listadocortesia" style="justify-content: center;align-items: center;height:380px;overflow:auto;box-sizing: border-box;border: 3px double black;"></div>';
  $('#myModalcortesia').html('<center> <b>CORTESIA : </b></center><br>' + botones_cuentas + tabla_listado + '<br><center><button onClick="procesar_cortesia()"> APLICAR CORTESIA</button> <button onClick="cerrar_cortesia()"> CERRAR </button></center>');   

     //llenar las cuentas
     cuentasllenar ='<table style="overflow:auto;"><tr><td><button type="button" onClick="seleccionar_cuenta_principaltmpcortesia(this.id)" id="cuentaprincipaltmpcortesia" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle">Principal</button></td>';

      // llenar cuentas comanda tmp del original no asignar
      cuentas_comanda.forEach(function(element) {
         cuentas_comandatmp.push(element);
      });

      cuentas_comandatmp.forEach(function(element) {
      if (element != 'Principal')
      {
      cuentasllenar += '<td><button type="button"  ondblclick="quitar_cuentatmpcortesia(this.id)"  onClick="seleccionar_cuentatmpcortesia(this.id)" id="cuentatmpcort_' + element + '" style="height:25px;background-color: lightblue;font-size: 10px;" class="rounded-circle">' + element + '</button></td>';
      }
      });

      cuentasllenar += '</tr></table>';

      $('#mesacuentastmpcortesia').html('');
      $('#mesacuentastmpcortesia').html(cuentasllenar);
      cambiar_color_cuentatmpcortesia();

         //llenar listado de comanda en el temp
      // Create a deep copy of listado_comanda
      listado_comandatmp = JSON.parse(JSON.stringify(listado_comanda))
      .reduce(function(result, element) {
         result.push(element.slice()); // Create a shallow copy of the element
      return result;
      }, []);

      if (cuentas_comandatmp.length > 1)
      {
           // SUMAR TODOS EN UNO SOLO
      const result = Object.values(listado_comandatmp.reduce((acc, curr) => {
      const key = curr[2];
      if (!acc[key]) {
         acc[key] = [...curr];
         acc[key][4] = +curr[4];
      } else {
         acc[key][4] += +curr[4];
         if (curr[5] === 'false') {
            acc[key][5] = 'false';
         }
      }
      return acc;
      }, {}));

      result.forEach(item => {
      item[5] = item[5] === 'true';
      item.pop();
      });

      listfinal ='';

      listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:12px;"><b><tr><th style="background-color:lightblue"><input type="button" onclick="reset_valores_cortesiaall()" value="R" title="resetear valor de esta fila"/>CANT</th><th scope="col">DETALLE</th><th scope="col" style="background-color:lightblue">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

      total_prop = 0;
      result.forEach((score) => {
         if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
         rt = get_max_cortesia(score[0],score[1]);
         //listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + score[4] + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + rt + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
      });

      listfinal += '</table>';

      }
      else
      {
         listfinal ='';

         listfinal = '<table class="table table-bordered table-light table-hover" style="text-align:center;height:10px;font-size:12px;"><b><tr><th style="background-color:lightblue"><input type="button" onclick="reset_valores_cortesiaall()" value="R" title="resetear valor de esta fila"/>CANT</th><th scope="col">DETALLE</th><th scope="col" style="background-color:lightblue">P.UNITARIO</th><th scope="col">P.TOTAL</th></tr></b>';

         total_prop = 0;
         listado_comandatmp.forEach((score) => {
            if (score[5] == 'false') { prop = ' (SP)';} else { prop = ''}
            rt = get_max_cortesia(score[0],score[1]);
           // listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + score[4] + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
           listfinal += '<tr><td style="width:105px;background-color:lightblue"><input type="button" max="' + score[4] + '" id="btresetcortesia' + score[1] + '" onclick="reset_valores_cortesia(this.id)" value="R" title="resetear valor de esta fila"/> <input type="text" id="ctnumprod1sz' + score[1] + '"  value="' + score[4] + '"  style="text-align:center;width:30px" onclick="mostrar_calculadora(this.id)" readonly/> de ' + rt + ' </td><td><input type="text" style="text-align:left;width:100px" value="' + score[2]  + prop +  '" readonly/></td><td style="background-color:lightblue">$ <input type="text" id="ctnumprod1ss' + score[1] + '" style="text-align:center;width:50px;" readonly value="' + Number(score[3]).toFixed(3)  + '"  onclick="mostrar_calculadora(this.id)"/></td><td>$ <input type="text" id="ctnumprodst' + score[1] + '" style="text-align:center;width:40px" value="' + (Number(score[3])*Number(score[4])).toFixed(3)  + '" readonly/></td></tr>';
         });

         listfinal += '</table>';
      }

      $('#listadocortesia').html('');
      $('#listadocortesia').html(listfinal);
      document.getElementById("myModalcortesia").style.display = '';
}

function get_max_cortesia(cuentat,idt)
{
   cortmax = 0;
   listado_comanda.forEach((score) => {
           if (score[0] == cuentat)
           {
               if (score[1] == idt)
            {
               cortmax = score[4];
            }
           }
    });
    return cortmax;
}

function cerrar_cortesia()
{
   Swal.fire({
   icon: 'info',
   title: 'Cancelar asignar Cortesia',
   text: 'Esta seguro que quiere cancelar Cortesia?, perdera sus cambios',
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
         document.getElementById('myModalcortesia').style.display = 'none';
         listado_comandatmp = [];
         cuentas_comandatmp = [];
         cuentaactualtmp = 'Principal';
      }
      });
}

function cerrar_cortesia_noprompt()
{
         document.getElementById('myModalcortesia').style.display = 'none';
         listado_comandatmp = [];
         cuentas_comandatmp = [];
         cuentaactualtmp = 'Principal';
}


function procesar_cortesia()
{
   Swal.fire({
   icon: 'info',
   title: 'Cancelar asignar Cortesia',
   text: 'Una vez aplicada la cortesia no podra revertirla a menos que no halla guardado los cambios de la comanda actual!',
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
        cortesia();
      }
      });
}

function cortesia()
{
         listado_comanda = [];
         listado_comandatmp.forEach((score) => {
            listado_comanda.push(score);
         });

         Swal.fire({
         icon: 'success',
         title: 'OK',
         text: 'Se hicieron los cambios de cortesia solicitados!'
         }).then(function() {
         });
         
         //todas las vars tmp a cero y refrescar comandas
         cerrar_cortesia_noprompt();
         document.getElementById('cuentaprincipal').click();

}

function afectar_array_cortesia(id)
{
   if (cuentas_comandatmp.length >= 1)
   {
     //solo hay principal asi que afectar el id
      listado_comandatmp.forEach(function(element) {
        if (element[0] == cuentaactualtmp  && element[1] == id)
        {
        element[3] = 0;
        }
      });
   }
}

//guardar en listado_comandatmp la cantidad, el precio unitario basado en cuentaactual y id
function actualizar_cantidadescortesia(cantidad_calcu,preciounitario,idfinal)
{
     //solo hay principal asi que afectar el id
       //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
       // cuenta, idprod, nombre, precio, unidad, propina, pregunta
      listado_comandatmp.forEach(function(element) {
        if (element[0] == cuentaactualtmp  && element[1] == idfinal)
        {
        element[4] = cantidad_calcu;
        element[3] = preciounitario;
        }
      });
}

function reset_valores_cortesia(id)
{
   //resetiar con 1
   var input = document.getElementById(id);
   var cantidadmax = parseInt(input.max);
   idtmp = id.replace("btresetcortesia", "");  
   
   document.getElementById('ctnumprod1sz' + idtmp).click();
   document.getElementById('calcuval').value = cantidadmax;
   enviar_calcuto();
}

function reset_valores_cortesiaall()
{
   // Find elements with "btresetcortesia" in their id
   var elements = document.querySelectorAll('[id*="btresetcortesia"]');

   //switch cuenta temporal solo para que deje pasar
   // Perform an action on each element
   elements.forEach(function(element) {
         cantidadmax = element.max;
         element.click();
         document.getElementById('calcuval').value = cantidadmax;
         enviar_calcuto();
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
