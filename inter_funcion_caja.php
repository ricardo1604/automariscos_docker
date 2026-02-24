<script>   
function seleccionar_mesacaja(mesa, flag)
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
       seleccionarfinal_mesacaja(mesa, flag);
       }
       });

       //DESHABILITAR BOTONES QUE NO TIENEN PERMISOS BASADO EN MESERO
       //usuario de sesion y usuario mesero, le da prioridad si es ADMIN
       //deshabilitar_opciones(usuario,document.getElementById('usermesero').value);
       //refrescar_comanda_principal();

       //seleccionar_cuenta_principal();
      }
}

function seleccionarfinal_mesacaja(mesa , flag)
{
 //flag = 0;
  // CLICK ALA CUENTA PRINCIPAL
 buscar_cliente_primera(); //solo para que se genere por primera vez
 document.getElementById('cuentaprincipal').click();

//  document.getElementById('elapsedtime').innerText = 0;
//  document.getElementById('elapsedtimes').innerText = 0;
//  tiempo = 0;
 //actualizar_colores();  
 //iniciar contador
 //clearInterval(tiemporun);
 if (document.getElementById('ordenactual').innerText == 0)
 {
 //tiemporun = setInterval( function() { actualizar_timer(); }, 1000);
 }
 mesaval = "mesa_" + mesa;
 if (usuario_comanda == '')  
 { // SI EL mesero ESTA VACIO
              document.getElementById('myModalusuariocomanda').style.display = '';
              document.getElementById('usermesero').focus();              
 }
 else
 {
   // verificar si mesa esta en azul (que esta para facturar)
   var usuario = sessionStorage.getItem('currentloggedin');
      $.ajax({
       type: "POST",
       async: false,
       url: "inter_caja.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          mesa: mesa,
          estado: 'get_facturar_estado_mesa'
       },
       beforeSend: function() {
       },
       success: function(r) {
         var data = JSON.parse(r);

         if (data[0] != 0)
            {
            Swal.fire({
                icon: 'info',
                title: 'MESA #' + mesa,
                text: 'No se puede facturar!'
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
       });



 }
}

function actualizar_colores_prompt_caja()
{
if (listado_comanda.length == 0)
{ 
 clear_comanda_vars();
 actualizar_colores_caja();
}
else
{
   Swal.fire({
   icon: 'info',
   title: 'Regresar a seleccion de mesas',
   text: 'Esta seguro?',
   showCancelButton: true,
   confirmButtonText: 'Si',
   cancelButtonText: 'No'
      }).then((result) => {
      if (result.value == true) {
         // bug resetear cuentacomanda
         cuentaactual = 'cuentaprincipal'; //solo por si no dieron click en principal de nuevo
         clear_comanda_vars_caja();
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
               url: "inter_cocina.php",
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
                actualizar_colores_caja();
            }
            });
            actualizar_colores_caja();
      }
      });
  }
}

function clear_comanda_vars_caja()
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


function seleccionar_usuariocaja(e) 
{
  if(e.keyCode === 13)
  {
     logearcaja();
  }
}

function logearcaja()
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
            actualizar_colores_caja();//quita las zonas grises
            document.getElementById('logcom').src = 'images/logout.png';
            // if (sessionStorage.getItem('currentloggedin') == 'ADMIN')
            // {
            //    deshabilitar_zonas_usuario('ADMIN');
            // }
            // else
            // {
            //    deshabilitar_zonas_usuario(usuario_comanda);
            // }
           
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


function actualizar_colores_caja()
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
        document.getElementById("myModalcomanda").style.display = 'block' ;

     }
     });    
}

function calcular_vuelto()
{
    // Get the value from the element with id "pagocon"
    var totv1 = document.getElementById("totales_precuenta");
      if (totv1 === null) {
         return;
      }
      var totv = totv1.value;

   // Split the string using commas as the delimiter
   var valuesArray = totv.split(',');

   // Access the first value
   var firstValue = valuesArray[0];

   // Display or use the first value as needed
   console.log(document.getElementById("pagocon").value);
   console.log(firstValue);


  vuelto = document.getElementById("pagocon").value - firstValue;
   
  document.getElementById("cambio").value = parseFloat(vuelto).toFixed(2);

}

function cobrar()
{
   var radios = document.getElementsByName("payment");
    var selectedValue;

    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            selectedValue = radios[i].value;
            break;
        }
    }

    if (selectedValue) {
       // alert("Selected value: " + selectedValue);
    } else {
      Swal.fire({
                icon: 'info',
                title: 'Metodo de pago',
                text: 'Seleccione un metodo de pago'
              }).then(function() {
              });  
              return;
    }

    if (selectedValue == 'cash')
    {
      if (document.getElementById('pagocon').value == '')
      {
         document.getElementById('pagocon').focus();
         Swal.fire({
                icon: 'info',
                title: 'Aporte',
                text: 'Selecciono efectivo, ingrese un Aporte del cliente'
              }).then(function() {
              });  
              return;
      }
      if (document.getElementById('cambio').value < 0)
      {
         document.getElementById('pagocon').focus();
         Swal.fire({
                icon: 'info',
                title: 'Cambio',
                text: 'No puede haber cambio negativo, verifique la cantidad'
              }).then(function() {
              });  
              return;
      }
    }
    else
    {
      document.getElementById('pagocon').value = '';
      document.getElementById('cambio').value = '';
    }



    if (selectedValue == 'check')
    {
      selectedValue = 'Cheque';
    }
    if (selectedValue == 'cash')
    {
      selectedValue = 'Efectivo';
    }


    var usuario = sessionStorage.getItem('currentloggedin');
    $.ajax({
       type: "POST",
       url: "inter_caja.php",
       datatype: "JSON",
       data: {
          usuario: usuario,
          usuarioc: document.getElementById('usermesero').value,
          orden: document.getElementById('ordenactual').innerText,
          metodo: selectedValue,
          mesa:  document.getElementById('mesaactual').innerText,
          estado: 'facturar_orden'
       },
       beforeSend: function() {
       },
       success: function(r) {
      //limpiar radios y todo cuando se complete bien
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = false;
         }
         //limpiar pago con y aporte
         document.getElementById('pagocon').focus();
         document.getElementById('pagocon').value = '';
         document.getElementById('cambio').value = '';


         Swal.fire({
                  icon: 'success',
                  title: 'Facturada',
                  text: 'Orden Facturada : ' + document.getElementById('ordenactual').innerText
                  }).then(function() {
                     actualizar_colores_caja();
                  });
     }
     });    




}
</script>