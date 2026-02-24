<?php

session_start();

require_once "cfg/conexion.php";
require_once "crud/crud.php";

$estado = $_POST['estado'];
$usuario = $_POST['usuario'];
$salir = '<button type="button" class="btn btn-dark btn-sq-responsive bg-success"  onClick="regresar()" style="width: 100px; height: 100px;"><img style="width: 75px; height: 75px" src="images/back.png"></button>
<img src="images/autologo.jpg" width="100px" height="100px">
<br> <b> Usuario : ' . $usuario . '</b>';

$logo = '<div  style="position: absolute;right: 0;bottom: 0;background-color:gray"><img src="images/autologo.jpg" width="120px" height="120px"><br> <b> Usuario : ' . $usuario . '</b></div>';

function get_time_refreshbar()
{
  $info = new crud();

  $mapa = '';

  $mapa = $info->get_refresh_bar();
  
  return $mapa[0];
}

function get_meseros_bar()
{
  $info = new crud();

  $ret ='';

  $cat ='';

  $cat = $info->get_meseros_users_bar();


  $ret .= '<select id="usermesero" style="width:340px" onChange="selec_pass()">';

  $ret .= '<option value=""></option>';

  foreach ($cat as $row)
  { 
    $ret .= '<option value="' . $row['NOMBRE'] . '">' . $row['NOMBRE'] . '</option>';

  }

  $ret .= '</select>';

  return $ret;

}


if ($estado == 'mostrar_componentes_ingre') 
{
  $id = $_POST['id'];
  $info = new crud();

  $results = $info->mostrar_componentes_ingre($id);

  $ret = '';

  $prod = '';
  
  foreach ($results as $row)
  {
  $ret = '<center><img src="images/productos/' . $row['URLIMG'] . '"  alt="' . $row['URLIMG'] . '"  width="100" height="100"></center><br>';
  break;
  }

  $ret .= '<div style="overflow:auto;height:250px;"><table class="table table-bordered table-light table-hover" style="font-size:14px;align:center" ><th>INGREDIENTE</th><th>CANT.</th><th>UNIDAD</th>';

  
  foreach ($results as $row)
  {
    $prod =  $row['NOMBRE_PROD'] ;
    $ret .= '<tr><td>' . $row['INGREDIENTE'] . '</td><td>' . $row['CANTIDAD'] . '</td><td>' . $row['UNIDAD'] . '</td></tr>';
  }

  $ret .= '</table></div>';
  
  $resultss = [];

  $resultss[0] = $ret;
  $resultss[1] = $prod;

  echo json_encode($resultss);
}

if ($estado == 'accion_item') 
{
  $registro = $_POST['registro'];
  $usuariob = $_POST['usuariob'];
  $estadoitem = $_POST['estadoitem'];

  $idprod = $_POST['idprod'];
  $cant = $_POST['cant'];
  $orden = $_POST['orden'];

  $info = new crud();

  $result = $info->accion_item($usuario,$usuariob,$registro,$estadoitem,$idprod,$cant,$orden);

  echo $result;

}

if ($estado == 'adquirir_mesaspedidobar')
{
  $info = new crud();

  $ordenes = $info->get_tickets_bar_ordenesV2();

  // Sort the $ordenes array by the "MESA" column in ascending order, ignoring non-numeric values
  usort($ordenes, function($a, $b) {
    $mesaA = is_numeric($a['MESA']) ? $a['MESA'] : PHP_INT_MAX;
    $mesaB = is_numeric($b['MESA']) ? $b['MESA'] : PHP_INT_MAX;
    return $mesaA - $mesaB;
  });

  $ret = '';
  
  
  $ret .= '<table class="table table-bordered table-light table-hover" style="font-size:14px;align:center" ><th>MESA</th><th>ORDEN</th>';

  foreach ($ordenes as $row)
  {
    if (strpos($row['MESA'], 'LLEVAR') !== false)
    {
      $ret .= '<tr style="cursor: pointer;" id="' . $row['MESA'] . '" onclick="seleccionar_reg_mesabar(this.id,' . $row['ORDEN_ACTUAL'] . ')"><td>LLEVAR</td><td>' . $row['ORDEN_ACTUAL'] . '</td></tr>';
    }
    else
    {
      $ret .= '<tr style="cursor: pointer;" onclick="seleccionar_reg_mesabar(' . $row['MESA'] . ',' . $row['ORDEN_ACTUAL'] . ')"><td>' . $row['MESA'] . '</td><td>' . $row['ORDEN_ACTUAL'] . '</td></tr>';
    }
  }

  $ret .= '</table>';

  echo $ret;
}

if ($estado == 'adquirir_mesaspedidococina')
{
  $info = new crud();

  $ordenes = $info->get_tickets_cocina_ordenesV2();

  // Sort the $ordenes array by the "MESA" column in ascending order, ignoring non-numeric values
  usort($ordenes, function($a, $b) {
    $mesaA = is_numeric($a['MESA']) ? $a['MESA'] : PHP_INT_MAX;
    $mesaB = is_numeric($b['MESA']) ? $b['MESA'] : PHP_INT_MAX;
    return $mesaA - $mesaB;
  });

  $ret = '';
  
  
  $ret .= '<table class="table table-bordered table-light table-hover" style="font-size:14px;align:center" ><th>MESA</th><th>ORDEN</th>';



  foreach ($ordenes as $row)
  {
    if (strpos($row['MESA'], 'LLEVAR') !== false)
    {
      $ret .= '<tr style="cursor: pointer;" id="' . $row['MESA'] . '" onclick="seleccionar_reg_mesacocina(this.id,' . $row['ORDEN_ACTUAL'] . ')"><td>LLEVAR</td><td>' . $row['ORDEN_ACTUAL'] . '</td></tr>';
    }
    else
    {
      $ret .= '<tr style="cursor: pointer;" onclick="seleccionar_reg_mesacocina(' . $row['MESA'] . ',' . $row['ORDEN_ACTUAL'] . ')"><td>' . $row['MESA'] . '</td><td>' . $row['ORDEN_ACTUAL'] . '</td></tr>';
    }
  }

  $ret .= '</table>';

  echo $ret;
}

function get_fechaactual()
{
  date_default_timezone_set('America/El_Salvador');

  $serverTimeZone = date_default_timezone_get();

// Set the time zone
date_default_timezone_set($serverTimeZone);

// Get the current date and time based on the server's time zone
$currentDateTime = date('d/m/Y h:i:s A');

return $currentDateTime;
}

function get_cuentabar()
{
  $info = new crud();

  $ordenes = $info->get_cuentatotalbar();

  return $ordenes;

}

function get_cuentacocina()
{
  $info = new crud();

  $ordenes = $info->get_cuentatotalcocina();

  return $ordenes;
}

if ($estado == 'get_bar_autototales')
{
  $ret = '';

  $ret = get_cuentabar();

  echo $ret[0];
}

if ($estado == 'get_cocina_autototales')
{
  $ret = '';

  $ret = get_cuentacocina();

  echo $ret[0];
}

// function get_estilo_bar()
// {
//   return '           <style>
//   .ticket {
//     background-color: #fff;
//     border: 1px solid #ccc;
//     border-radius: 2px;
//     padding: 7px;
//     margin-bottom: 2px;
//     width: 100%;
//     height: 100%;
//   }
  
//   .ticket-header {
//     background-color: #007bff;
//     color: #fff;
//     padding: 0px;
//     text-align: center;
//     border-radius: 2px 2px 0 0;
//     cursor: pointer;
//     font-size: 11px;
//   }

//   .ticket-headerred {
//     background-color: red;
//     color: white;
//     padding: 0px;
//     text-align: center;
//     border-radius: 2px 2px 0 0;
//     cursor: pointer;
//     font-size: 11px;
//   }
  
//   .ticket-body {
//     padding: 10px;
//     height: 120px;
//     overflow:auto;
//   }
  
//   .item-row {
//     display: flex;
//     justify-content: space-between;
//     align-items: center;
//     margin-bottom: 5px;
//     font-size: 10px;
//     border-radius: 1px;border: 1px solid black
//   }

//   .item-row2 {
//     display: flex;
//     justify-content: space-between;
//     align-items: center;
//     margin-bottom: 0px;
//     font-size: 9px;
//   }
  
//   .item-name {
//     width: 65px;
//     flex-grow: 1;
//     font-size: 10px;
//   }

//   .item-info {
//     width: 25px;
//     flex-grow: 1;
//   }
  
//   .item-quantity {
//     width: 50px;
//     text-align: center;
//     font-size: 10px;
//     font-weight: bold;
//   }

//   .item-note {
//     width: 20px;
//     text-align: center;
//   }

//   .item-note2 {
//     width: 200px;
//     text-align: left;
//     padding: 0.5rem 1rem; 
//     font-size: 10px; 
//     line-height: 1; 
//     height: 30px;
//   }
  
//   .total-row {
//     display: flex;
//     justify-content: flex-end;
//     align-items: center;
//     margin-top: 10px;
//     font-weight: bold;
//     font-size: 11px;
//   }

 
// </style>';
// }

function get_estilo_cocina()
{
  $info = new crud();
  $total_cocina = $info->get_cuentatotalcocina();
  $fs = "font-size:13px;";
  $fs2 = 10;
  if ($total_cocina[0] < 5)
  {
    $fs = "font-size:18px;";
    $fs2 = 13;
  }

  return '           <style>
  .ticket {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 2px;
    padding: 7px;
    margin-bottom: 2px;
    width: 100%;
    height: 100%;
  }
  
  .ticket-header {
    background-color: #007bff;
    color: #fff;
    padding: 0px;
    text-align: center;
    border-radius: 2px 2px 0 0;
    cursor: pointer;
    ' . $fs .'
  }

  .ticket-headerred {
    background-color: red;
    color: white;
    padding: 0px;
    text-align: center;
    border-radius: 2px 2px 0 0;
    cursor: pointer;
    ' . $fs .'
  }
  
  .ticket-body {
    padding: 10px;
    height: 120px;
    overflow:auto;
  }
  
  .item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
    ' . $fs .'
    border-radius: 1px;border: 1px solid black
  }

  .item-row2 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0px;
    ' . $fs .'
  }
  
  .item-name {
    width: 65px;
    flex-grow: 1;
    ' . $fs .'
  }

  .item-info {
    width: 25px;
    flex-grow: 1;
  }
  
  .item-quantity {
    width: 50px;
    text-align: center;
    ' . $fs .'
    font-weight: bold;
  }

  .item-note {
    width: 20px;
    text-align: center;
  }

  .item-note2 {
    width: 200px;
    text-align: left;
    padding: 0.5rem 1rem; 
    ' . $fs .'
    line-height: 1; 
    height: 30px;
  }
  
  .total-row {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: 10px;
    font-weight: bold;
    ' . $fs .'
  }

  .mesatitle {
    font-weight: bold;
    font-size:' . $fs2*1.8 .'px;
  }

 
</style>';
}

function get_estilo_bar()
{
  $info = new crud();
  $total_bar = $info->get_cuentatotalbar();
  $fs = "font-size:13px;";
  $fs2 = 10;
  if ($total_bar[0] < 5)
  {
    $fs = "font-size:18px;";
    $fs2 = 13;
  }

  return '           <style>
  .ticket {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 2px;
    padding: 7px;
    margin-bottom: 2px;
    width: 100%;
    height: 100%;
  }
  
  .ticket-header {
    background-color: #007bff;
    color: #fff;
    padding: 0px;
    text-align: center;
    border-radius: 2px 2px 0 0;
    cursor: pointer;
    ' . $fs .'
  }

  .ticket-headerred {
    background-color: red;
    color: white;
    padding: 0px;
    text-align: center;
    border-radius: 2px 2px 0 0;
    cursor: pointer;
    ' . $fs .'
  }
  
  .ticket-body {
    padding: 10px;
    height: 120px;
    overflow:auto;
  }
  
  .item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
    ' . $fs .'
    border-radius: 1px;border: 1px solid black
  }

  .item-row2 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0px;
    ' . $fs .'
  }
  
  .item-name {
    width: 65px;
    flex-grow: 1;
    ' . $fs .'
  }

  .item-info {
    width: 25px;
    flex-grow: 1;
  }
  
  .item-quantity {
    width: 50px;
    text-align: center;
    ' . $fs .'
    font-weight: bold;
  }

  .item-note {
    width: 20px;
    text-align: center;
  }

  .item-note2 {
    width: 200px;
    text-align: left;
    padding: 0.5rem 1rem; 
    ' . $fs .'
    line-height: 1; 
    height: 30px;
  }
  
  .total-row {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: 10px;
    font-weight: bold;
    ' . $fs .'
  }

  .mesatitle {
    font-weight: bold;
    font-size:' . $fs2*1.8 .'px;
  }

 
</style>';
}


if ($estado == 'tab_principal_bar') 
{
    $ver = '';
    $mod = '';
    $borrar = '';
    $imprimir = '';
  
    $info = new crud();
  
    $privilegios = $info->get_privilegios($usuario, 16);
  
    foreach ($privilegios as $row)
    {   
     $ver = $row['VER']; 
     $mod = $row['MODIFICAR'];
     $borrar = $row['BORRAR'];
     $imprimir = $row['IMPRIMIR'];
    }

    $trefresh = get_time_refreshbar();

    $estilo_bar = get_estilo_bar();

    $meseros = get_meseros_bar();

    $tickets = get_tickets_bar();

    $fechaactual = get_fechaactual();

    $cuentatotal =  get_cuentabar();

        if ($ver == 1) 
    {
        $bgc = "steelblue";
        // MENU PRINCIPAL DE BOTON DE CONFIGURACIONES 
        echo '     
        <div id="myModalcocinabar" style="display: block; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%;
        overflow: auto; /* Enable scroll if needed column-count: 3;column-gap: 20px */
        background: rgb(2,0,36);
        background: linear-gradient(186deg, rgba(2,0,36,1) 0%, rgba(1,48,116,1) 33%, rgba(0,212,255,1) 100%);
        "> 
        
  
        <div style="display:flex;">
        <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
        </div>
        <div id=""  style="background-color:black;height:25px;flex:1.5;border-radius: 6px;border: 1px solid white;" >
        <center><label style="color:white"> [B A R] </label>&nbsp&nbsp&nbsp&nbsp <label style="color:cyan;font-size:12px" id="totalordenes"> TOTAL DE ORDENES : ' . $cuentatotal[0]  . ' </label>&nbsp&nbsp <label style="color:lightgreen;font-size:12px" id="totalactualizacion"> ULTIMA ACTUALIZACION : ' . $fechaactual . ' </label></center>
        </div> &nbsp
        <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
        </div> 
        
        </div>
          
         
        <div style="display:flex;">
        <div id="myModalusuariobar" style="display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        left: 35%;
        top: 30%;
        width: 340px: /* Full width */
        height: 50px;
        background-color: white;
        border-radius: 6px;border: 1px solid black;font-size:25px;
        "> 
        <img src="images/cancelar.png" onclick="esconder_logusuariobar()" height="20px" width="20px" style="float: right;">
        <center><b>SELECCIONE UN BARTENDER :</b>  <br>
        ' . $meseros . ' <br>
        <input type="number" pattern="[0-9]*" id="usermeseropassxx" inputmode="numeric" style="-webkit-text-security:disc;width:340px" onkeypress="seleccionar_usuariobar(event)" hidden>
        <input type="text"  id="usermeseropass"  style="-webkit-text-security:disc;width:340px" onkeypress="seleccionar_usuariobar(event)"><br>Presione Enter<br>
        <label id="tact" hidden> ' . $trefresh . ' </label>
         </center> 
        </div>   

        <div id="myModalpedidomesa" style="display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        left: 30%;
        top: 25%;
        width: 500px: /* Full width */
        height: 340px;
        background-color: white;
        border-radius: 6px;border: 2px solid black;font-size:20px;
        "> 
        <div >
        <img src="images/cancelar.png" onclick="mostrar_pedidomesabar()" height="20px" width="20px" style="float: right;">
        <center><b>MESAS PEDIDO ACTUAL : </b></center>
          <div style="display:flex;width:600px">
         <div id="mesaspedido" style="flex:1.5;overflow:auto;height:300px;border-radius: 6px;border: 2px solid black;">
         </div>
         <div id="mesaspedidoselec" style="flex:1.5;overflow:auto;height:300px;border-radius: 6px;border: 2px solid black;">
         </div>
         </div>
         <center><button onClick="mostrar_pedidomesabar()"> CANCELAR</button></center>
         </div>
        </div>   


           &nbsp&nbsp
          ' . $estilo_bar .'
           
           <div style="overflow:auto;height:700px;flex:8.25;border-radius: 6px;border: 1px solid black;background:rgb(147, 198, 231);" >
           <div style="display:flex;" id="ordenes_pendientes"> 
            ' . $tickets . '
           </div>
           </div>  &nbsp
          <div id="infopanel" style="height:700px;flex:1.10;border-radius: 6px;border: 1px solid black;background:rgb(147, 198, 231);">
          <br>
          &nbsp<button type="button" class="bg-info" style="width:75px;font-size:12px" onClick="mostrar_modalbar()"> <img src="images/mesero.png" height ="20px" width="20px" />MESERO ACTUAL</button>
          &nbsp<button type="button" class="bg-success" style="width:75px;font-size:12px" onClick="mostrar_pedidomesabar()"> <img src="images/leer.png" height ="20px" width="20px" />PEDIDO MESA</button>
          <br>
          ESTADOS :
          <br> <label style="background-color:white;width:100px;font-size:12px;text-align:center" > SIN TOMAR</label> 
          <br> <label style="background-color:salmon;width:100px;font-size:12px;text-align:center" > PREPARACION</label> 
          <br> <label style="background-color:lightgreen;width:100px;font-size:12px;text-align:center" > DESPACHO</label> 
          <br><br>&nbsp<img src="images/autologo.jpg" height ="40px" width="40px" />&nbsp<img src="images/login.png" id="logcom" height ="40px" width="40px" onClick="logout_bar()"/><br>
          
          <table>
          <tr><td>Usuario :</td><td><input type="text" id="usuariomaster" readonly style="width:120px; background: none; border: none; outline: none; font-weight: bold;" value="' . $usuario . '"/></td></tr>
          <tr><td>Bart :</td><td><input type="text" id="meseroact" readonly style="width:120px; background: none; border: none; outline: none; font-weight: bold;"/></td></tr>
          </table>
          </div>  &nbsp
      
          <div id="" style="height:270px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
          </div>
          </div>
        
      

        </div> 
        </div>'; 
        }
        else
        {
          echo '<h5 style="background-color:red"><b> USTED NO TIENE ACCESO A ESTA OPCION</b></h5>' . $salir;
        }

}

function get_tickets_bar()
{
  $info = new crud();
  $ret = '';
  $ordenes = $info->get_tickets_bar_ordenes();
  $results = $info->get_tickets_bar();
  $tiempo_orden = $info->get_tiempo_maxordenbar();
  $printer = '<button id="imprimir_pre" 
  style="background-image: url(images/print2.png); 
  background-repeat: no-repeat; 
  background-position: 0px 0px;  
  border: none;          
  cursor: pointer;   
  vertical-align: middle;
  height:25px;width:25px;font-weight:bold;font-size:10px" 
  class="btn btn-outline-dark btn-sm border border-dark"
  data-orden="numerobar"
  data-tiempo="tiempobar"
  onClick="imprimir_ordenbar(this.id)"></button> ';

  $filtro = '<button id="filtrar_" 
  style="background-image: url(images/eye.png); 
  background-repeat: no-repeat; 
  background-position: 0px 0px;  
  border: none;          
  cursor: pointer;   
  vertical-align: middle;
  height:25px;width:25px;font-weight:bold;font-size:10px" 
  class="btn btn-outline-dark btn-sm border border-dark" onClick="mostrar_ordenesdespachadas(this.id)"></button> ';
  
  $areaCounter = 0;  
  $i = 0;
  foreach ($ordenes as $i => $row1)
  {
    $mesa= $row1['MESA'];   
    $orden = $row1['ORDEN_ACTUAL'];   
    $tiempo = $row1['TIEMPO_MINUTOS']; 
    // Replace "imprimir_pre" with the value of $row1['ORDEN_ACTUAL']
    $fprinter = str_replace("imprimir_pre", "imprimir_pre" . $mesa, $printer);
    $fprinter = str_replace("numerobar", $orden, $fprinter);
    $fprinter = str_replace("tiempobar", $tiempo, $fprinter);
    $ffiltrar = str_replace("filtrar_", "filtrar_ticketBody" . $i, $filtro);

     $th = 'ticket-header';
     if ($row1['TIEMPO_MINUTOS'] > $tiempo_orden[0])
     {
      $th = 'ticket-headerred';
     }

    //draw area
    if ($i % 3 == 0) {
      //$ret .= '<div id="area_tickets' . $areaCounter . '" style="flex:1;border-radius: 6px;border: 1px solid black;background:rgb(147, 198, 231);">';
      $ret .= '<div id="area_tickets' . $areaCounter . '" style="background:rgb(147, 198, 231); flex: 1;">';
      $areaCounter++;
     }

    $ret .= '<div class="container mt-4">
      <div class="ticket">
        <div class="'. $th .'" data-toggle="" data-target="#ticketBody' . $i .'" aria-expanded="false" aria-controls="ticketBody' . $i .'"> ';
        
        if (strpos($row1['MESA'], 'LLEVAR') !== false)
        {
          $ret .= '<b><label class="mesatitle">LLEVAR</label></b> <br> Orden : ' . $row1['ORDEN_ACTUAL'] . ' <br> ' . $row1['TIEMPO_MINUTOS'] . ' minutos';
          $ret .= '&nbsp&nbsp' . $fprinter . $ffiltrar;
        }
        else
        {
          $ret .= '<b><label class="mesatitle">MESA : ' . $row1['MESA'] .'</label></b> <br> Orden : ' . $row1['ORDEN_ACTUAL'] . ' <br> ' . $row1['TIEMPO_MINUTOS'] . ' minutos';
          $ret .= '&nbsp&nbsp' . $fprinter . $ffiltrar;
        }
        $ret .= '</div>
        <div class="ticket-body collapse show" id="ticketBody' . $i .'">';
         
    foreach ($results as $row2)
    {
      if ($row1['MESA'] == $row2['MESA'] )
      {
        $nota = '<label id="reg_' . $row2['REGISTRO_ID'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)"></label>';
        if ($row2['NOTAS'] != '')
        {
          $nota = '<img src="images/notes1.png" height ="15px" width="15px" id="i' . $row2['MESA'] . '' . $row2['REGISTRO_ID'] . '" onclick="desplegar_nota(this.id)"/>';
        }
        $estadocolor = 'style="background-color:white"';
        if ($row2['ESTADO'] == 'preparacion')
        {
            $estadocolor = 'style="background-color:salmon"';
        }
        else if ($row2['ESTADO'] == 'despacho')
        {
          $estadocolor = 'style="background-color:lightgreen" hidden';  
        }
        $ret .=  '<div class="item-row" id="ci_' . $row2['REGISTRO_ID'] . '" ' . $estadocolor . '>';
        $ret .= '<div class="item-info" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)"><img src="images/info.png" height ="20px" width="20px" onclick="mostrar_composicion(event,' . $row2['PRODUCTO_ID'] . ')"/></div>';
        $ret .= '<div class="item-info" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)"><img src="images/clock.png" height ="20px" width="20px"/> ' . $row2['TIEMPO_ITEM'] . ' mins</div>';
        $ret .= '<div class="item-name" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)">' . $row2['DETALLE'] . '</div>';
        $ret .= '<div class="item-note" >' . $nota  . '</div>';
        $ret .= '<div class="item-quantity" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)">' . $row2['CANTIDAD'] . '</div>';
        $ret .=  '</div>';

        if ($nota != '')
        {
          $ret .=  '<div class="item-row2">';
          $ret .= '<div class="item-note2 alert alert-primary" role="alert" hidden id="n' . $row2['MESA'] . '' . $row2['REGISTRO_ID'] . '">' . $row2['NOTAS'] . '</div>';
          $ret .=  '</div>';
        }

      }
    }
    
    $ret .= '</div></div></div>';
    //end
    // end area
    if ($i % 3 == 2) {
      $ret .= '</div>';
      }
      $i++;
  }

  //CORREGIR EL ULTIMO DIV
  if ($i % 3 != 0) {
  $ret .= '</div>';
  }
  
 
  return $ret;
}


if ($estado == 'adquirir_mesaspedido_regsbar')
{
  $mesa = $_POST['mesa'];
  $orden = $_POST['orden'];

  $info = new crud();
  $ret = '';

    $results = $info->get_ticket_bar($mesa);

    $ret .= '<table class="table table-bordered table-hover" style="font-size:12px;align:center" ><th>DETALLE</th><th>CANTIDAD</th>';

    $i = 0;
    foreach ($results as $row2)
    {
      $i++;
      $estadocolor = 'style="cursor: pointer;background-color:white"';
      if ($row2['ESTADO'] == 'preparacion')
      {
          $estadocolor = 'style="cursor: pointer;background-color:salmon"';
      }
      else if ($row2['ESTADO'] == 'despacho')
      {
          $estadocolor = 'style="cursor: pointer;background-color:lightgreen"';  
      }
     // $ret .= '<tr ' . $estadocolor  . ' id="ci2_' . $row2['REGISTRO_ID'] . '" onclick="corregir_regbar(this.id)"><td>' . $row2['DETALLE'] . '</td><td>' . $row2['CANTIDAD'] . '</td></tr>';
     $ret .= '<tr ' . $estadocolor  . ' data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row2['ORDEN'] . '" id="ci2_' . $row2['ORDEN'] . '_' . $i . '" onclick="corregir_regbar(this.id)"><td>' . $row2['DETALLE'] . '</td><td>' . $row2['CANTIDAD'] . '</td></tr>';
    }
  
    $ret .= '</table>';

    echo $ret;
}

if ($estado == 'adquirir_mesaspedido_regscocina')
{
  $mesa = $_POST['mesa'];
  $orden = $_POST['orden'];

  $info = new crud();
  $ret = '';

    $results = $info->get_ticket_cocina($mesa);

    $ret .= '<table class="table table-bordered table-hover" style="font-size:12px;align:center" ><th>DETALLE</th><th>CANTIDAD</th>';

    $i = 0;
    foreach ($results as $row2)
    {
      $i++;
      $estadocolor = 'style="cursor: pointer;background-color:white"';
      if ($row2['ESTADO'] == 'preparacion')
      {
          $estadocolor = 'style="cursor: pointer;background-color:salmon"';
      }
      else if ($row2['ESTADO'] == 'despacho')
      {
          $estadocolor = 'style="cursor: pointer;background-color:lightgreen"';  
      }
      //$ret .= '<tr ' . $estadocolor  . ' id="ci2_' . $row2['REGISTRO_ID'] . '" onclick="corregir_regcocina(this.id)"><td>' . $row2['DETALLE'] . '</td><td>' . $row2['CANTIDAD'] . '</td></tr>';
      $ret .= '<tr ' . $estadocolor  . ' data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row2['ORDEN'] . '" id="ci2_' . $row2['ORDEN'] . '_' . $i . '" onclick="corregir_regcocina(this.id)"><td>' . $row2['DETALLE'] . '</td><td>' . $row2['CANTIDAD'] . '</td></tr>';
    }
  
    $ret .= '</table>';

    echo $ret;
}

if ($estado == 'actualizar_bar')
{
  $tickets = get_tickets_bar();

  echo $tickets;

}

if ($estado == 'actualizar_cocina')
{
  $tickets = get_tickets_cocina();

  echo $tickets;

}

//// COCINA AQUI :
/// COCINA
/// COCINA

function get_time_refreshcocina()
{
  $info = new crud();

  $mapa = '';

  $mapa = $info->get_refresh_cocina();
  
  return $mapa[0];
}

function get_meseros_cocina()
{
  $info = new crud();

  $ret ='';

  $cat ='';

  $cat = $info->get_meseros_users_cocina();


  $ret .= '<select id="usermesero" style="width:340px" onChange="selec_pass()">';

  $ret .= '<option value=""></option>';

  foreach ($cat as $row)
  { 
    $ret .= '<option value="' . $row['NOMBRE'] . '">' . $row['NOMBRE'] . '</option>';

  }

  $ret .= '</select>';

  return $ret;

}

function get_tickets_cocina()
{
  $info = new crud();
  $ret = '';
  $ordenes = $info->get_tickets_cocina_ordenes();
  $results = $info->get_tickets_cocina();
  $tiempo_orden = $info->get_tiempo_maxordencocina();

  $printer = '<button id="imprimir_pre" 
  style="background-image: url(images/print2.png); 
  background-repeat: no-repeat; 
  background-position: 0px 0px;  
  border: none;          
  cursor: pointer;   
  vertical-align: middle;
  height:25px;width:25px;font-weight:bold;font-size:10px" 
  class="btn btn-outline-dark btn-sm border border-dark" onClick="imprimir_ordencocina()"></button> ';

  $filtro = '<button id="filtrar_" 
  style="background-image: url(images/eye.png); 
  background-repeat: no-repeat; 
  background-position: 0px 0px;  
  border: none;          
  cursor: pointer;   
  vertical-align: middle;
  height:25px;width:25px;font-weight:bold;font-size:10px" 
  class="btn btn-outline-dark btn-sm border border-dark" onClick="mostrar_ordenesdespachadas(this.id)"></button> ';
  
  $areaCounter = 0;  
  $i = 0;
  foreach ($ordenes as $i => $row1)
  {
    $row1_ORDEN_ACTUAL = $row1['ORDEN_ACTUAL'];   
    // Replace "imprimir_pre" with the value of $row1['ORDEN_ACTUAL']
    $fprinter = str_replace("imprimir_pre", "imprimir_pre" . $row1_ORDEN_ACTUAL, $printer);
    $ffiltrar = str_replace("filtrar_", "filtrar_ticketBody" . $i, $filtro);

     $th = 'ticket-header';
     if ($row1['TIEMPO_MINUTOS'] > $tiempo_orden[0])
     {
      $th = 'ticket-headerred';
     }

    //draw area
    if ($i % 3 == 0) {
      //$ret .= '<div id="area_tickets' . $areaCounter . '" style="flex:1;border-radius: 6px;border: 1px solid black;background:rgb(147, 198, 231);">';
      $ret .= '<div id="area_tickets' . $areaCounter . '" style="background:rgb(147, 198, 231); flex: 1;">';
      $areaCounter++;
     }

     $ret .= '<div class="container mt-4">
     <div class="ticket">
     <div class="'. $th .'" data-toggle="" data-target="#ticketBody' . $i .'" aria-expanded="false" aria-controls="ticketBody' . $i .'"> ';
     
     if (strpos($row1['MESA'], 'LLEVAR') !== false)
     {
       $ret .= '<b><label class="mesatitle">LLEVAR</label></b> <br> Orden : ' . $row1['ORDEN_ACTUAL'] . ' <br> ' . $row1['TIEMPO_MINUTOS'] . ' minutos';
       $ret .= '&nbsp&nbsp' . $fprinter . $ffiltrar;
     }
     else
     {
       $ret .= '<b><label class="mesatitle">MESA : ' . $row1['MESA'] .'</label></b> <br> Orden : ' . $row1['ORDEN_ACTUAL'] . ' <br> ' . $row1['TIEMPO_MINUTOS'] . ' minutos';
       $ret .= '&nbsp&nbsp' . $fprinter . $ffiltrar;
     }
     $ret .= '</div>
     <div class="ticket-body collapse show" id="ticketBody' . $i .'">';
      
          
    foreach ($results as $row2)
    {
      if ($row1['MESA'] == $row2['MESA'] )
      {
        $nota = '<label id="reg_' . $row2['REGISTRO_ID'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)"></label>';
        if ($row2['NOTAS'] != '')
        {
          $nota = '<img src="images/notes1.png" height ="15px" width="15px" id="i' . $row2['MESA'] . '' . $row2['REGISTRO_ID'] . '" onclick="desplegar_nota(this.id)"/>';
        }
        $estadocolor = 'style="background-color:white"';
        if ($row2['ESTADO'] == 'preparacion')
        {
            $estadocolor = 'style="background-color:salmon"';
        }
        else if ($row2['ESTADO'] == 'despacho')
        {
          $estadocolor = 'style="background-color:lightgreen" hidden';  
        }
        $ret .=  '<div class="item-row" id="ci_' . $row2['REGISTRO_ID'] . '" ' . $estadocolor . '>';
        $ret .= '<div class="item-info" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)"><img src="images/info.png" height ="20px" width="20px" onclick="mostrar_composicion(event,' . $row2['PRODUCTO_ID'] . ')"/></div>';
        $ret .= '<div class="item-info" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)"><img src="images/clock.png" height ="20px" width="20px"/> ' . $row2['TIEMPO_ITEM'] . ' mins</div>';
        $ret .= '<div class="item-name" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)">' . $row2['DETALLE'] . '</div>';
        $ret .= '<div class="item-note" >' . $nota  . '</div>';
        $ret .= '<div class="item-quantity" id="reg_' . $row2['REGISTRO_ID'] . '" data-idprod="' . $row2['PRODUCTO_ID'] . '" data-cantidad="' . $row2['CANTIDAD'] . '" data-orden="' . $row1['ORDEN_ACTUAL'] . '" style="cursor: pointer;" onclick="marcar_item(this.id)">' . $row2['CANTIDAD'] . '</div>';
        $ret .=  '</div>';

        if ($nota != '')
        {
          $ret .=  '<div class="item-row2">';
          $ret .= '<div class="item-note2 alert alert-primary" role="alert" hidden id="n' . $row2['MESA'] . '' . $row2['REGISTRO_ID'] . '">' . $row2['NOTAS'] . '</div>';
          $ret .=  '</div>';
        }

      }
    }
    
    $ret .= '</div></div></div>';
    //end
    // end area
    if ($i % 3 == 2) {
      $ret .= '</div>';
      }
      $i++;
  }

  //CORREGIR EL ULTIMO DIV
  if ($i % 3 != 0) {
  $ret .= '</div>';
  }
  
 
  return $ret;
}

if ($estado == 'tab_principal_cocina') 
{
    $ver = '';
    $mod = '';
    $borrar = '';
    $imprimir = '';
  
    $info = new crud();
  
    $privilegios = $info->get_privilegios($usuario, 15);
  
    foreach ($privilegios as $row)
    {   
     $ver = $row['VER']; 
     $mod = $row['MODIFICAR'];
     $borrar = $row['BORRAR'];
     $imprimir = $row['IMPRIMIR'];
    }

    $trefresh = get_time_refreshcocina();

    $estilo_bar = get_estilo_cocina();

    $meseros = get_meseros_cocina();

    $tickets = get_tickets_cocina();

    $fechaactual = get_fechaactual();

    $cuentatotal =  get_cuentacocina();

        if ($ver == 1) 
    {
        $bgc = "steelblue";
        // MENU PRINCIPAL DE BOTON DE CONFIGURACIONES 
        echo '     
        <div id="myModalcocinabar" style="display: block; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%;
        overflow: auto; /* Enable scroll if needed column-count: 3;column-gap: 20px */
        background: rgb(2,0,36);
        background: linear-gradient(186deg, rgba(2,0,36,1) 0%, rgba(1,48,116,1) 33%, rgba(0,212,255,1) 100%);
        "> 
        
  
        <div style="display:flex;">
        <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
        </div>
        <div id=""  style="background-color:black;height:25px;flex:1.5;border-radius: 6px;border: 1px solid white;" >
        <center><label style="color:white"> [C O C I N A] </label>&nbsp&nbsp&nbsp&nbsp <label style="color:cyan;font-size:12px" id="totalordenes"> TOTAL DE ORDENES : ' . $cuentatotal[0]  . ' </label>&nbsp&nbsp <label style="color:lightgreen;font-size:12px" id="totalactualizacion"> ULTIMA ACTUALIZACION : ' . $fechaactual . ' </label></center>
        </div> &nbsp
        <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
        </div> 
        
        </div>
          
         
        <div style="display:flex;">
        <div id="myModalusuariobar" style="display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        left: 35%;
        top: 30%;
        width: 340px: /* Full width */
        height: 50px;
        background-color: white;
        border-radius: 6px;border: 1px solid black;font-size:25px;
        "> 
        <img src="images/cancelar.png" onclick="esconder_logusuariobar()" height="20px" width="20px" style="float: right;">
        <center><b>SELECCIONE UN BARTENDER :</b>  <br>
        ' . $meseros . ' <br>
        <input type="number" pattern="[0-9]*" id="usermeseropassxx" inputmode="numeric" style="-webkit-text-security:disc;width:340px" onkeypress="seleccionar_usuariobar(event)" hidden>
        <input type="text"  id="usermeseropass"  style="-webkit-text-security:disc;width:340px" onkeypress="seleccionar_usuariobar(event)"><br>Presione Enter<br>
        <label id="tact" hidden> ' . $trefresh . ' </label>
         </center> 
        </div>   

        <div id="myModalpedidomesa" style="display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        left: 30%;
        top: 25%;
        width: 500px: /* Full width */
        height: 340px;
        background-color: white;
        border-radius: 6px;border: 2px solid black;font-size:20px;
        "> 
        <div >
        <img src="images/cancelar.png" onclick="mostrar_pedidomesacocina()" height="20px" width="20px" style="float: right;">
        <center><b>MESAS PEDIDO ACTUAL : </b></center>
          <div style="display:flex;width:600px">
         <div id="mesaspedido" style="flex:1.5;overflow:auto;height:300px;border-radius: 6px;border: 2px solid black;">
         </div>
         <div id="mesaspedidoselec" style="flex:1.5;overflow:auto;height:300px;border-radius: 6px;border: 2px solid black;">
         </div>
         </div>
         <center><button onClick="mostrar_pedidomesacocina()"> CANCELAR</button></center>
         </div>
        </div>   


           &nbsp&nbsp
          ' . $estilo_bar .'
           
           <div style="overflow:auto;height:700px;flex:8.25;border-radius: 6px;border: 1px solid black;background:rgb(147, 198, 231);" >
           <div style="display:flex;" id="ordenes_pendientes"> 
            ' . $tickets . '
           </div>
           </div>  &nbsp
          <div id="infopanel" style="height:700px;flex:1.10;border-radius: 6px;border: 1px solid black;background:rgb(147, 198, 231);">
          <br>
          &nbsp<button type="button" class="bg-info" style="width:75px;font-size:12px" onClick="mostrar_modalbar()"> <img src="images/mesero.png" height ="20px" width="20px" />MESERO ACTUAL</button>
          &nbsp<button type="button" class="bg-success" style="width:75px;font-size:12px" onClick="mostrar_pedidomesacocina()"> <img src="images/leer.png" height ="20px" width="20px" />PEDIDO MESA</button>
          <br>
          ESTADOS :
          <br> <label style="background-color:white;width:100px;font-size:12px;text-align:center" > SIN TOMAR</label> 
          <br> <label style="background-color:salmon;width:100px;font-size:12px;text-align:center" > PREPARACION</label> 
          <br> <label style="background-color:lightgreen;width:100px;font-size:12px;text-align:center" > DESPACHO</label> 
          <br><br>&nbsp<img src="images/autologo.jpg" height ="40px" width="40px" />&nbsp<img src="images/login.png" id="logcom" height ="40px" width="40px" onClick="logout_bar()"/><br>
          
          <table>
          <tr><td>Usuario :</td><td><input type="text" id="usuariomaster" readonly style="width:120px; background: none; border: none; outline: none; font-weight: bold;" value="' . $usuario . '"/></td></tr>
          <tr><td>Bart :</td><td><input type="text" id="meseroact" readonly style="width:120px; background: none; border: none; outline: none; font-weight: bold;"/></td></tr>
          </table>
          </div>  &nbsp
      
          <div id="" style="height:270px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
          </div>
          </div>
        
      

        </div> 
        </div>'; 
        }
        else
        {
          echo '<h5 style="background-color:red"><b> USTED NO TIENE ACCESO A ESTA OPCION</b></h5>' . $salir;
        }

}

if ($estado == 'obtener_listadobar') 
{
  $orden = $_POST['orden'];
  $info = new crud();
  
  $res = $info->listado_print_ordenesbar($orden);

  $listfinal = '';
  $listfinal = '<table style="width: 100%; height: 100%;">';
  $listfinal .= '<thead><tr style="font-size: 9px"><th style="width: 20%;">PRODUCTO</th><th style="width: 50%;">CANTIDAD</th><th style="width: 15%;">ESTADO</th></tr></thead>';

  
  foreach ($res as $row)
  { 
    $estado = 'Preparacion';
    if ($row['ESTADO'] == 'abierta')
    {
      $estado = 'Sin Tomar';
    }
    if ($row['ESTADO'] == 'despacho')
    {
      $estado = 'despachada';
    }
    // DETALLE CANT ESTADO
    $listfinal .= '<tr style="font-size: 9px">';
    $listfinal .= '<td style="text-align:center">' . $row['DETALLE']  . '</td>';
    $listfinal .= '<td style="text-align:center">' . $row['CANT']  . '</td>';
    $listfinal .= '<td style="text-align:center">' .  $estado . '</td>';
    $listfinal .= '</tr>';
  }

  $listfinal .= '</table>';

  echo $listfinal;

}
?>
