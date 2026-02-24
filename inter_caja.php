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

function get_area($n)
{
  $info = new crud();

  $ret = '';

  //$mapa = $info->get_mapa($n);

  $mapa = $info->get_mapacaja();

  $ret = get_estructura($mapa);

  return $ret;
}

function get_time_refreshmesas()
{
  $info = new crud();

  $mapa = '';

  $mapa = $info->get_refresh_mesas();
  
  return $mapa[0];
}

function get_estructura($mapa)
{
  $info = new crud();
  $colorb = '';
  $imageurl = '';
  $body = '';

  $body .= '<div>';

  $body .= '<table id="pendientescaja" class="table table-bordered table-light table-hover" style="font-size:16px;align:center">';  

  $body .= '<thead style="position: sticky; top:0;"><tr><th></th><th>MESA</th><th>COMANDA</th><th>MESERO</th><th>FECHA/HORA</th><th>CUENTA</th></tr></thead>';

  foreach ($mapa as $row)
  {
    if ($row['MESA_PRINCIPAL'] == 0){$mesa_padre = '';} else {$mesa_padre = '(' . $row['MESA_PRINCIPAL'] . ')';}  

    if ($row['COLOR'] == '' || $row['COLOR'] == 'green'){$colorb = 'green'; $imageurl = 'mesagr.png';} else {$colorb = $row['COLOR'];}

    if ($colorb == 'red')
    {
      $imageurl = 'mesar.png';
    }
    if ($colorb == 'yellow')
    {
      $imageurl = 'mesay.png';
    }

    /// como es caja verificar si esta listo para facturar
    if ($row['ORDEN_ACTUAL'] != '')
    {
    $facturar_mesa = $info->get_facturar_estado_mesa($row['ORDEN_ACTUAL']);
     
    if ($facturar_mesa[0] == 0)
    {
        $imageurl = 'mesab.png';
    }
    }

    $total_linea = '';

    $total_linea = $info->get_total_linea($row['ORDEN_ACTUAL']);

    if ($colorb != 'green')
    {
    $body .= '<tr onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)"><td><img  src="images/' . $imageurl . '" width="20" height="20"> </td><td>' . $row['MESA'] . '</td><td>' . $row['ORDEN_ACTUAL'] . '</td><td>' . $row['MESERO'] . '</td><td>' . $row['MODIFICADO'] . '</td><td>$ ' . $total_linea[0] . '</td></tr>';
    }
    //$body .= '<tr style="width:20px"><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</label></span></td></tr><tr><td>&nbsp</td></tr>';
    
    $body .= '';


  }

  $body .= '</table></div>';

  return  $body ;
}

/* obsolete */
function get_estructuraobsolete($mapa)
{
  $tablezone1 = '';
  $tablezone2 = '';
  $tablezone3 = '';
  $tablezone4 = '';
  $tablezone5 = '';
  $tablezone6 = '';
  $tablezone7 = '';
  $tablezone8 = '';
  $tablezone9 = '';
  $tablezone10 = '';

  $info = new crud();

  $i = 1;
  $a = 1;
  $b = 1;
  $c = 1;
  $d = 1;
  $e = 1;
  $f = 1;
  $g = 1;
  $h = 1;
  $j = 1;

  $tablezone1 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone2 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone3 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone4 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone5 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone6 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone7 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone8 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone9 .= '<div><table style="float: left;margin-right:10px;">';
  $tablezone10 .= '<div><table style="float: left;margin-right:10px;">';

      // width and height imagen
      $w = 40;
      $h = 40;
      // width and height boton
      $w2 = 55;
      $h2 = 45;
      //top and left
      $t = 3;
      $l = -32;
      //$t = -36;
      //$l = 1;
      // font
      $ft = '20px;font-weight:bold;text-shadow: 2px 2px 2px #000000;color:white';

            // // width and height imagen
            // $w = 35;
            // $h = 40;
            // // width and height boton
            // $w2 = 50;
            // $h2 = 45;
            // //top and left
            // $t = -26;
            // $l = 13;
            // // font
            // $ft = 22;
      
    $nombre = 'name="mesasbotones"';
    
  foreach ($mapa as $row)
  { 
    $colorb = '';
    $imageurl = '';
    $mesa_padre = '';

    if ($row['MESA_PRINCIPAL'] == 0){$mesa_padre = '';} else {$mesa_padre = '(' . $row['MESA_PRINCIPAL'] . ')';}  

    if ($row['COLOR'] == '' || $row['COLOR'] == 'green'){$colorb = 'green'; $imageurl = 'mesagr.png';} else {$colorb = $row['COLOR'];}

    if ($colorb == 'red')
    {
      $imageurl = 'mesar.png';
    }
    if ($colorb == 'yellow')
    {
      $imageurl = 'mesay.png';
    }

    /// como es caja verificar si esta listo para facturar
    if ($row['ORDEN_ACTUAL'] != '')
    {
    $facturar_mesa = $info->get_facturar_estado_mesa($row['ORDEN_ACTUAL']);
     
    if ($facturar_mesa[0] == 0)
    {
        $imageurl = 'mesab.png';
    }
    }

    if ($row['ZONA'] == '1')
    {     
      if ($i == 1){$tablezone1 .= '<table  style="float: left;margin-right:10px;">';}
      //$tablezone1 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '</span></td></tr><tr><td>&nbsp</td></tr>';
      $tablezone1 .= '<tr style="width:20px"><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</label></span></td></tr><tr><td>&nbsp</td></tr>';
      if ($i == 4){$tablezone1 .= '</table>'; $i = 0;}
      $i++;
    }
    if ($row['ZONA'] == '2')
    {
      if ($a == 1){$tablezone2 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone2 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($a == 4){$tablezone2 .= '</table>'; $a = 0;}
      $a++;
    }
    if ($row['ZONA'] == '3')
    {
      if ($b == 1){$tablezone3 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone3 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($b == 4){$tablezone3 .= '</table>'; $b = 0;}
      $b++;
    }
    if ($row['ZONA'] == '4')
    {
      if ($c == 1){$tablezone4 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone4 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($c == 4){$tablezone4 .= '</table>'; $c = 0;}
      $c++;
    }
    if ($row['ZONA'] == '5')
    {
      if ($d == 1){$tablezone5 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone5 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($d == 4){$tablezone5 .= '</table>'; $d = 0;}
      $d++;
    }
    if ($row['ZONA'] == '6')
    {
      if ($e == 1){$tablezone6 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone6 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($e == 4){$tablezone6 .= '</table>'; $e = 0;}
      $e++;
    }
    if ($row['ZONA'] == '7')
    {
      if ($f == 1){$tablezone7 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone7 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($f == 4){$tablezone7 .= '</table>'; $f = 0;}
      $f++;
    }
    if ($row['ZONA'] == '8')
    {
      if ($g == 1){$tablezone8 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone8 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($g == 4){$tablezone8 .= '</table>'; $g = 0;}
      $g++;
    }
    if ($row['ZONA'] == '9')
    {
      if ($h== 1){$tablezone9 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone9 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($h == 4){$tablezone9 .= '</table>'; $h = 0;}
      $h++;
    }
    if ($row['ZONA'] == '10')
    {
      if ($j == 1){$tablezone10 .= '<table  style="float: left;margin-right:10px;">';}
      $tablezone10 .= '<tr><td><img title="mesero : ' . $row['MESERO'] . '" id="mesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" src="images/' . $imageurl . '"  width="' . $w . 'px" height="' . $h . 'px" style="margin:0 auto;"><span id="smesa_' . $row['MESA'] . '" onclick="seleccionar_mesacaja(' . $row['MESA'] . ',0)" style="font-size:' . $ft . ';position:relative;top: ' . $t . 'px;left: ' . $l . 'px;">' . $row['MESA'] . '<label style="font-size: 8px;color: white;">' . $mesa_padre . '</span></td></tr><tr><td>&nbsp</td></tr>';
      if ($j == 4){$tablezone10 .= '</table>'; $j = 0;}
      $j++;
    }

  
  }

  $tablezone1 .= '</table></div>';
  $tablezone2 .= '</table></div>';
  $tablezone3 .= '</table></div>';
  $tablezone4 .= '</table></div>';
  $tablezone5 .= '</table></div>';
  $tablezone6 .= '</table></div>';
  $tablezone7 .= '</table></div>';
  $tablezone8 .= '</table></div>';
  $tablezone9 .= '</table></div>';
  $tablezone10 .= '</table></div>';

  // contarlas
  //$cuenta_zonas = $info->get_cuentas_zonas();

      
  // foreach ($cuenta_zonas  as $row)
  // { 
  //    if ($row['F'] <= 0){$tablezone6 = '';}
  //    if ($row['G'] <= 0){$tablezone7 = '';}
  // }

   
  return  $tablezone1 . $tablezone2 . $tablezone3 . $tablezone4 . $tablezone5 . $tablezone6 . $tablezone7 . $tablezone8 .  $tablezone9 .  $tablezone10;

}

function get_categorias()
{
  $info = new crud();

  $ret ='';

  $cat ='';

  $cat = $info->get_cat_prod();


  $ret .= '<table>';



  foreach ($cat as $row)
  { 
    $style = "style='background-image: url(images/" . $row['URLCAT'] . "); 
    background-repeat: no-repeat; 
    background-position: 0px 0px;  
    border: none;          
    cursor: pointer;   
    padding-left: 32px;   
    vertical-align: middle;
    height:40px;width:120px;font-weight:bold'";

    $ret .= '<tr><td></td></tr><tr><td><input ' . $style . ' type="button" class="btn btn-outline-dark btn-sm border border-dark"  id="' . $row['NOMBRE'] . '" value="' . $row['NOMBRE'] . '" onclick="crear_submenus(this.id)"/></td></tr>';

  }

  $ret .= '</table>';

  return $ret;

}

function get_meseros()
{
  $info = new crud();

  $ret ='';

  $cat ='';

  $cat = $info->get_meseros_users();


  $ret .= '<select id="usermesero" style="width:340px" onChange="selec_pass()">';

  $ret .= '<option value=""></option>';

  foreach ($cat as $row)
  { 
    $ret .= '<option value="' . $row['NOMBRE'] . '">' . $row['NOMBRE'] . '</option>';

  }

  $ret .= '</select>';

  return $ret;

}

function get_detalles()
{
  $info = new crud();

  $ret ='';

  $dat ='';
  
  //$sql = "SELECT MESA, ESTADO, COLOR, TIEMPO_CORRIENDO, MESERO, MODIFICADO FROM MESAS_ESTADO ORDER BY MESA ASC;";

  $dat = $info->get_vista_detallada();

  $ret .= '<table id="tabasignadas" class="table table-bordered table-light table-hover" style="font-size:14px;align:center" ><thead style="position: sticky; top:0;">  
    <tr>
      <th></th>  
      <th>ZONA</th>  
      <th>MESA</th>
      <th>ESTADO</th>
      <th>TIEMPO(h:m)</th>
      <th>MESERO</th>
      <th>ORDEN</th>
      <th>#PERSONAS</th>
      <th>MESA PRINCIPAL</th>
      <th>ULTIMA MODIFICACION</th>
    </tr>
  </thead><tbody>';

  foreach ($dat as $row)
  { 
    // Calculate the number of hours and minutes
    $hours = floor($row['TIEMPO_CORRIENDO'] / 60);
    $minutes = $row['TIEMPO_CORRIENDO'] % 60;

    // Format the result as "hours:minutes"
     $time_string = $hours . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT);
      
     $c = '';
     $clase = 'class="table-success"';
     //mesa color
     if ($row['COLOR'] == 'green' ) 
     {
      $c = 'gr';
      $clase = 'class="table-success"';
     }
      else if ($row['COLOR'] == 'yellow' ) 
     {
      $c = 'y';
      $clase = 'class="table-warning"';
     }
     else if ($row['COLOR'] == 'red' ) 
     {
      $c = 'r';
      $clase = 'class="table-danger"';
     }
     else
     {
      $c = 'f';
     }
     $ret .= '<tr ' . $clase . '><td ><img src="images/mesa' . $c . '.png" height ="20px" width="20px" /></td><td>' . $row['ZONA'] . '</td><td>' . $row['MESA'] . '</td><td>' . $row['ESTADO'] . '</td><td>' . $time_string . '</td><td>' . $row['MESERO'] . '</td><td>' . $row['ORDEN_ACTUAL'] . '</td><td>' . $row['NUM_PERSONAS'] . '</td><td>' . $row['MESA_PRINCIPAL'] . '</td><td>' . $row['MODIFICADO'] . '</td></tr>';
  }

  $ret .= ' </tbody></table>';


  return $ret;
}


if ($estado == 'tab_principal_caja') 
{

  $ver = '';
  $mod = '';
  $borrar = '';
  $imprimir = '';

  $info = new crud();

  $privilegios = $info->get_privilegios($usuario, 17);

  foreach ($privilegios as $row)
  {   
   $ver = $row['VER']; 
   $mod = $row['MODIFICAR'];
   $borrar = $row['BORRAR'];
   $imprimir = $row['IMPRIMIR'];
  }

   //get area1
  $area1 = get_area(1);
  $area2 = get_area(2);
  $area3 = get_area(3);
  $area4 = get_area(4);

  $categorias = get_categorias();

  $meseros = get_meseros();

  $detalles = get_detalles();

  $trefresh = get_time_refreshmesas();

  $iva = $info->get_iva();

  $propina = $info->get_propina();

  $mesabloqueo = $info->get_bloqueomesa();

  $datos_globales = $info->get_global_empresa();

  $botones = botones_decomanda(999);

  $totalones = $info->get_totales_nofacturados();
  
  //if ($usuario == 'ADMIN')
  //{
  $liberar = '&nbsp<button type="button" class="bg-danger" style="width:100px" onClick="mostrar_liberarmesas()"> <img src="images/cancelar.png" height ="50px" width="50px" />LIBERAR MESA</button>';
  //} else
  //{
  //$liberar = '';
 // }


  //$url = "url('images/notepad.jpg')";
  //$url = "url('images/fondocuaderno2.png')";
  $url = "url('images/non.png')";
  /*<td><button type="button" style="height:25px;background-color: #008CBA;font-size: 10px;" class="rounded-circle">Carlos</button></td>*/
  if ($ver == 1) {
  $bgc = "steelblue";
  // MENU PRINCIPAL DE BOTON DE CONFIGURACIONES 
  echo '<div style="width: 100%;border-style: double;background-color:' . $bgc  .';">  
   <div style="height:45px;width: 100%;border-style: double;background-color:' . $bgc  .';display:flex;">&nbsp
   <div id="" style="flex:0.25;border-radius: 6px;border: 1px solid black;background-color:' . $bgc  .';" >
   <center><img src="images/autologo.jpg" height ="37px" width="45px" /></center>
   </div>&nbsp
   <div id="" style="flex:1.60;border-radius: 6px;border: 1px solid black;background-color:' . $bgc  .';" >
   <input type="text" id="viva" value="'. $iva[0] .'"readonly style="width:100px" hidden/><input type="text" value="'. $propina[0] .'" id="vpropina" hidden readonly style="width:100px"/>
   Cajero : <input type="text" id="meseroact2" readonly style="width:100px"/></b>&nbsp
   <button onClick="actualizar_colores_prompt_caja()" style="width:45px;height:35px;background-color:lightblue;" id="abrircomanda"><img id="abrircomanda" src="images/mesav.png" height ="30px" width="30px" title="Mesas" /></button>
   </div>
   <div id="" style="flex:1.60;border-radius: 6px;border: 1px solid black;background-color:' . $bgc  .';" >
   <center>
   <span style="text-align:right"><b>MESA # </b><button id="mesaactual" style="font-weight:bold;border-style: double;background-color:blue;color:white" readonly></button>
   <input type="text" id="smesaactual" style="width:100px;font-weight:bold;border-style: double;background-color:lightblue;color:white" readonly/>&nbsp
   </span>
   <span style="text-align:right"><b>ORDEN # </b><button id="ordenactual" style="font-weight:bold;border-style: double;background-color:blue;color:white" readonly onclick="display_lista()">0</button></span>
   </center>
   </div>   
   </div>
  <div style="height:560px;width: 100%;display:flex;border-style: double;background-color:' . $bgc  .';"> <div style="overflow-y:scroll;" hidden>' . $categorias . '</div>
  <div id="listadoorden" style="overflow:auto;flex:1.25;border-radius: 6px;border: 1px solid black;background-color:teal;" >
  <div>
  <input type="text" id="cliente" placeholder="Nombre" size="10px" hidden/>
  <button type="button" class="btn btn-primary btn-sm" onClick="agregar_subcuenta()" hidden>+ Cuentas...</button>
  <b style="font-size:10px">#PERSONAS :  <button type="button"  style="height:20px" onClick="disminuir_per()" hidden>-</button><input type="number" id="numpersonas" value="0" style="width:40px" onClick="mostrar_calculadorav2(this.id)" readonly/><button type="button" onClick="incrementar_per()" style="height:20px" hidden>+</button></b>
  <button type="button" class="btn btn-secondary btn-sm" onClick="buscar_cliente()" style="background:url(images/search.png) no-repeat;background-size: 25px 25px;height:30px;width:30px;"></button>
  Cliente: <input type="text" id="clientecid" size="20px" disabled/>
  </div>
  <div id="mesacuentas" style="overflow:auto;border-style: double;" hidden>
  <table style="overflow:auto;">
  <tr>
  <td><button type="button" style="height:25px;background-color: lightgreen;font-size: 10px;" class="rounded-circle" id="cuentaprincipal" onClick="seleccionar_cuenta_principal(this.id)">Principal</button></td>
   </tr>
  </table>
   </div>
  
   <div id="mesadetalles" style="height:390px;background-repeat: no-repeat;background-size: 100% 100%;background-image: ' . $url . ';">
   

   <div id="myModalusuarioteclado" style="display: none; /* Hidden by default */
   position: fixed; /* Stay in place */
   /*left: 70%;
   top: 30%;*/
   left: 50%;
   top: 50%;
   transform: translate(-50%, -50%);
   width: 500px: /* Full width */
   height: 50px;
   background-color: white;
   border-radius: 6px;border: 1px solid black;font-size:30px;
   z-index: 9999; /* Set a high value */
   "> 
   <center>
   <input type=text id="calcufrom" disabled hidden/>
   <table class="table_teclado">
   <tr><input type=text id="calcuval" disabled style="width:200px"/></tr>
   <tr>
     <td onclick="calcu(1)">1</td>
     <td onclick="calcu(2)">2</td>
     <td onclick="calcu(3)">3</td>
   </tr>
   <tr>
     <td onclick="calcu(4)">4</td>
     <td onclick="calcu(5)">5</td>
     <td onclick="calcu(6)">6</td>
   </tr>
   <tr>
     <td onclick="calcu(7)">7</td>
     <td onclick="calcu(8)">8</td>
     <td onclick="calcu(9)">9</td>
   </tr>
   <tr>
     <td colspan="2" onclick="calcu(0)">0</td>
     <td onClick="borrar_calc()"><img class="btn_delete" src="images/borrar2.png" ></td>
   </tr>
   </table>
   <button onClick="esconder_calculadora()"> CERRAR </button>
   <button onClick="enviar_calcuto()"> ENVIAR </button>
    </center> 
   </div>

   <div id="myModalprecuenta" style="display: none; /* Hidden by default */
   position: fixed; /* Stay in place */
   left: 50%;
   top: 45%;
   transform: translate(-50%, -50%);
   width: 310px: /* Full width */
   height: 350px;
   background-color: white;
   border-radius: 6px;border: 1px solid black;font-size:30px;
   z-index: 99999; /* Set a high value */
   "> 
   <style>
   
   .receipt-container {
     width: 300px;
     height: 340px;
     margin: 0 auto;
     padding: 2px;
     border: 1px solid #ccc;
     background-color: #f9f9f9;
   }
   
   .receipt-title {
     text-align: center;
     font-size: 12px;
     margin-bottom: 0px;
   }


  
   .receipt-item {
     margin-bottom: 5px;
     font-size: 12px;
   }

   .receipt-total {
     text-align: center;
     margin-top: 10px;
   }
   
   .receipt-total label {
     font-weight: bold;
   }
   
   .receipt-total span {
     margin-left: 10px;
   }
 </style>
 
 <h1 class="receipt-title">PRECUENTA</h1>
 <h1 class="receipt-title">TICKET DE PREVENTA</h1>
 <h1 class="receipt-title">"' . $datos_globales[1] . '"</h1>
 <h1 class="receipt-item"> <label id="datosmesa"> </label></h1>
 <div class="receipt-container" style="overflow-y: auto;"> 
 <div class="receipt-items" id="contenidoprecuenta">
 </div>
  </div>
  <div class="receipt-total" id="precuentat">  
   </div>
   <div id="datosempresa" style="font-size:10px">
   </div>
   

   <button id="imprimir_pre" 
   style="background-image: url(images/print2.png); 
   background-repeat: no-repeat; 
   background-position: 0px 0px;  
   border: none;          
   cursor: pointer;   
   vertical-align: middle;
   height:25px;width:25px;font-weight:bold;font-size:10px" 
   class="btn btn-outline-dark btn-sm border border-dark" onClick="imprimir_precuenta()"></button> 

   <button id="cerrar_pre" 
   style="background-repeat: no-repeat; 
   background-position: 0px 0px;  
   border: none;          
   cursor: pointer;   
   vertical-align: middle;
   height:25px;width:25px;font-weight:bold;font-size:10px" 
   class="btn btn-outline-dark btn-sm border border-dark" onClick="cerrar_precuenta_form()">X</button> 
   </div>

   <div id="myModalunirmesas" style="display: none; /* Hidden by default */
   position: fixed; /* Stay in place */
   left: 50%;
   top: 30%;
   width: 500px: /* Full width */
   height: 50px;
   background-color: white;
   border-radius: 6px;border: 1px solid black;font-size:16px;
   "> 
    </div>
     
    <div id="myModalmovermesa" style="display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    left: 50%;
    top: 30%;
    width: 500px: /* Full width */
    height: 50px;
    background-color: white;
    border-radius: 6px;border: 1px solid black;font-size:16px;
    "> 
     </div>

    <div id="myModaldividircuentas" style="overflow:auto;  display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    /* z-index: 9999; Display on top of other elements */
    left: 50%;
    top: 42%;
    transform: translate(-50%, -50%);
    width: 80%;
    height: 75%;
    background-color: white;
    border-radius: 6px;
    border: 1px solid black;
    font-size: 16px;
    "> 
     </div>

     <div id="myModalcortesia" style="overflow:auto;  display: none; /* Hidden by default */
     position: fixed; /* Stay in place */
     /* z-index: 9999; Display on top of other elements */
     left: 50%;
     top: 42%;
     transform: translate(-50%, -50%);
     width: 80%;
     height: 75%;
     background-color: white;
     border-radius: 6px;
     border: 1px solid black;
     font-size: 16px;
     "> 
      </div>

      <div id="myModalmodificar" style="overflow:auto;  display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      /* z-index: 9999; Display on top of other elements */
      left: 50%;
      top: 42%;
      transform: translate(-50%, -50%);
      width: 18%;
      height: 20%;
      background-color: white;
      border-radius: 6px;
      border: 1px solid black;
      font-size: 16px;
      "> 
       <center> OPCIONES DISPONIBLES : </center>
      
       <div style="background-color: white;border-radius: 6px;border: 1px solid black;">
       <br>
       <center>
       <button id="movermesa" 
      style="background-image: url(images/mover.png); 
      background-repeat: no-repeat; 
      background-position: 0px 0px;  
      border: none;          
      cursor: pointer;   
      padding-left: 32px;   
      vertical-align: middle;
      height:35px;width:85px;font-weight:bold;font-size:10px" 
      class="btn btn-outline-dark btn-sm border border-dark" onClick="mover_mesa()">MOVER MESA</button> 

      <button id="cortesia" 
      style="background-image: url(images/cortesia2.png); 
      background-repeat: no-repeat; 
      background-position: 0px 0px;  
      border: none;          
      cursor: pointer;   
      padding-left: 32px;   
      vertical-align: middle;
      height:35px;width:85px;font-weight:bold;font-size:10px" 
      class="btn btn-outline-dark btn-sm border border-dark" onClick="ver_cortesia()" >CORTESIA</button> 
    
      <button id="sustituir" 
      style="background-image: url(images/sustituir.png); 
      background-repeat: no-repeat; 
      background-position: 0px 0px;  
      border: none;          
      cursor: pointer;   
      padding-left: 32px;   
      vertical-align: middle;
      height:35px;width:85px;font-weight:bold;font-size:10px" 
      class="btn btn-outline-dark btn-sm border border-dark" onClick="ver_sustituir()" >SUSTITUIR</button>   
      <br><br>
      <button onClick="ver_modificar()"> CERRAR </button>
      </center> 
             </div>
          </div>

    <div id="myModalclientesV" style="display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    left: 30%;
    top: 1%;
    width: 700px: /* Full width */
    height: 50px;
    background-color: white;
    border-radius: 6px;border: 1px solid black;font-size:12px;
    "> 
     </div>

     

     <div id="myModalusuariocomanda2" style="display: none; /* Hidden by default */
     position: fixed; /* Stay in place */
     left: 35%;
     top: 30%;
     width: 340px: /* Full width */
     height: 50px;
     background-color: white;
     border-radius: 6px;border: 1px solid black;font-size:20px;
     "> 
     <img src="images/cancelar.png" onclick="logeo_admin()" height="20px" width="20px" style="float: right;">
     <center><b>USUARIO ADMINISTRATIVO :</b>  <br>
     <br>
     <input type="text"  id="usermesero2"  style="width:340px" placeholder="USUARIO"><br>
     <input type="password"  id="usermeseropass2"  style="-webkit-text-security:disc;width:340px" onkeypress="seleccionar_usuario2(event)"><br>Presione Enter<br>
      </center> 
     </div>
   <div id="comanda" style="overflow:auto;object-position: 10% 50%;width:85.5%;height:320px;margin-left: 9.5%;color: black;font-size:12px" disabled>
   </div>
   <span id="comandat" style="background-color: white;float: right;width:50%;margin-right: 6%;object-position: 50% 50%;border-style: double;">
   </span>
     </div>
  <center>
  APORTE : <b>$</b>&nbsp<input type="number" id="pagocon" onblur="calcular_vuelto()">  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp CAMBIO : <b>$</b>&nbsp<input type="number" id="cambio" disabled> <br><br>
  <div id="botones_comanda" style="display: inline-block;">
  ' .  $botones . '
  </div>
  <div id="logeoa" style="display: inline-block;">
  <button id="logeoadmin" 
  style="background-image: url(images/user.png); 
  background-repeat: no-repeat; 
  background-color: none;
  background-position: 0px 0px;  
  border: none;          
  cursor: pointer;   
  padding-left: 32px;   
  vertical-align: middle;
  height:35px;width:85px;font-weight:bold;font-size:10px" 
  class="btn btn-outline-dark btn-sm border border-dark" onClick="logeo_admin()">USUARIO</button>
  </div>
  </center>
  </div>
  <br></div><div id="transcurrido"><span id="tiempobloqueos" hidden>' . $mesabloqueo[0] . '</span><b> </b><span id="elapsedtime"></span>:<span id="elapsedtimes"></span></div> 

  <div id="myModalcomanda" style="display: block; /* Hidden by default */
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
  
  <div><span class="close" style="float:right;background-color:gray;visibility: hidden;" >&times;</span></div>

  <div style="text-align: center;background-color:gray"><h5>CAJA - SELECCION DE MESAS :</h5> </div>

  <div style="display:flex;">
  <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
  </div>

  <div id=""  style="overflow:auto;height:35px;flex:1.20;border-radius: 6px;border: 1px solid black;background: rgb(72,72,73); background: linear-gradient(186deg, rgba(72,72,73,1) 1%, rgba(77,144,152,1) 56%);">
  <center>&nbsp<button disabled style="background-color:blue;width:20px;height:20px"></button>&nbspFACTURAR&nbsp<button disabled style="background-color:red;width:20px;height:20px"></button>&nbspOCUPADA&nbsp<button disabled style="background-color:yellow;width:20px;height:20px"></button>&nbspORDENANDO&nbsp&nbsp<button style="background-color:green;width:20px;height:20px" disabled></button>&nbspLIBRE
   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <span style="border: 1px solid black;"><b>TOTAL : $ <input type="text" id="totalrestaurante" readonly style="width:100px; background: none; border: none; outline: none; font-weight: bold;" value="' . $totalones[0] . '"/>PERSONAS : <input type="text" id="cantperrestaurante" readonly style="width:50px; background: none; border: none; outline: none; font-weight: bold;" value="' . $totalones[1] . '"/></b></span>
  </center>
  </div> &nbsp

  <div id=""  style="height:35px;flex:0.5;border-radius: 6px;border: 1px solid black;background: rgb(72,72,73); background: linear-gradient(186deg, rgba(72,72,73,1) 1%, rgba(77,144,152,1) 56%);">
  &nbsp<button type="button" class="bg-info" style="width:35px"> <img src="images/cajero.png" height ="20px" width="20px" onClick="mostrar_modalmeseros()"/></button>
  &nbsp<img src="images/autologo.jpg" height ="30px" width="30px" />&nbsp<img src="images/login.png" id="logcom" height ="30px" width="30px" onClick="logout_comanda()"/>  
   Usuario :<input type="text" id="usuariomaster" readonly style="width:100px; background: none; border: none; outline: none; font-weight: bold;" value="' . $usuario . '"/>
   Cajero :<input type="text" id="meseroact" readonly style="width:100px; background: none; border: none; outline: none; font-weight: bold;"/>
  </table>
  </div>
  

  <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
  </div> 
  </div>



  <div style="display:flex;">
  <div id="" style="height:270px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
  </div>
  <div id="area1"  style="overflow:auto;height:570px;flex:1.5;border-radius: 6px;border: 1px solid black;background:rgb(147, 198, 231);" >
  ' . $area1 . '
  </div> &nbsp

  </div>

  <div id="" style="height:1px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
  </div> 


  <div style="display:flex;">
  <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
  </div>
  <div id=""  style="visibility: hidden;overflow:auto;height:25px;flex:0.5;border-radius: 6px;border: 1px solid black;background: rgb(72,72,73); background: linear-gradient(186deg, rgba(72,72,73,1) 1%, rgba(77,144,152,1) 56%);">
  </div>
  <div id=""  style="visibility: hidden;overflow:auto;height:25px;flex:1.20;border-radius: 6px;border: 1px solid black;background: rgb(72,72,73); background: linear-gradient(186deg, rgba(72,72,73,1) 1%, rgba(77,144,152,1) 56%);">
  </div> &nbsp

  <div id="" style="height:25px;width:10px;border-radius: 6px;border: 1px solid black;background-color:lightgreen;visibility: hidden;">
  </div> 
  </div>
  
  
  <div id="myModalusuariocomanda" style="display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  left: 35%;
  top: 30%;
  width: 340px: /* Full width */
  height: 50px;
  background-color: white;
  border-radius: 6px;border: 1px solid black;font-size:25px;
  "> 
  <img src="images/cancelar.png" onclick="esconder_logmeserosv2()" height="20px" width="20px" style="float: right;">
  <center><b>SELECCIONE UN CAJERO :</b>  <br>
  ' . $meseros . ' <br>
  <input type="number" pattern="[0-9]*" id="usermeseropassxx" inputmode="numeric" style="-webkit-text-security:disc;width:340px" onkeypress="seleccionar_usuariocaja(event)" hidden>
  <input type="text"  id="usermeseropass"  style="-webkit-text-security:disc;width:340px" onkeypress="seleccionar_usuariocaja(event)"><br>Presione Enter<br>
  <label id="tmesas" hidden> ' . $trefresh . ' </label>
   </center> 
  </div>

  <div id="myModalliberarmesa" style="display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  left: 35%;
  top: 20%;
  width: 340px: /* Full width */
  height: 50px;
  background-color: white;
  border-radius: 6px;border: 1px solid black;font-size:30px;
  "> 
   </div>

  <div id="myModaldetalles" style="display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  left: 20%;
  top: 3%;
  width: 700px: /* Full width */
  height: 300px;
  background-color: white;
  border-radius: 6px;border: 1px solid black;font-size:20px;
  "> 

  
  <div style="text-align: center;">
  <b>RESUMEN :</b> <img src="images/mesavv.png" height ="40px" width="40px" />
  <img src="images/cancelar.png" onclick="cerrar_vistadetallada()" height ="20px" width="20px" style="float: right;" />
  </div>
  </div>
  '; 
  }
  else
  {
    echo '<h5 style="background-color:red"><b> USTED NO TIENE ACCESO A ESTA OPCION</b></h5>' . $salir;
  }

}

function botones_decomanda($usuario)
{
  $botones = '';

  $botones = ' 
  
  <label>
  <input type="radio" name="payment" value="check">
  <img src="images/visa.png" alt="Pago Cheque" width="40px" height="40px"> 
</label>

<label>
  <input type="radio" name="payment" value="cash">
  <img src="images/cash.png" alt="Pago Efectivo" width="40px" height="40px"> 
</label>

<label>
  <input type="radio" name="payment" value="Transferencia">
  <img src="images/transfer.png" alt="Pago Transferencia" width="40px" height="40px"> 
</label>

&nbsp&nbsp

  <button id="precuenta" 
  style="background-image: url(images/precuenta.png); 
  background-repeat: no-repeat; 
  background-position: 0px 0px;  
  border: none;          
  cursor: pointer;   
  padding-left: 32px;   
  vertical-align: middle;
  height:35px;width:95px;font-weight:bold;font-size:10px" 
  class="btn btn-outline-dark btn-sm border border-dark" onClick="ver_precuenta()" >CUENTA</button> 

  <button id="ordenar" 
  style="background-image: url(images/ordenar.png); 
  background-repeat: no-repeat; 
  background-position: 0px 0px;  
  border: none;          
  cursor: pointer;   
  padding-left: 32px;   
  vertical-align: middle;
  height:35px;width:85px;font-weight:bold;font-size:10px" 
  class="btn btn-outline-dark btn-sm border border-dark" onClick="cobrar()">FACTURAR</button> 
  &nbsp&nbsp

 ';

  return $botones;
}


if ($estado == 'tab_submenu') 
{
  $cat = $_POST['cat'];

  $ver = '';
  $mod = '';
  $borrar = '';
  $ret = '';

  $info = new crud();

  $privilegios = $info->get_privilegios($usuario, 7);

  foreach ($privilegios as $row)
  {   
   $ver = $row['VER']; 
   $mod = $row['MODIFICAR'];
   $borrar = $row['BORRAR'];
  }


  $categorias = $info-> get_subcat_prod_list($cat);
  
  $ret .= '<div style="width: 100%;border-style: double;" >';


  if ($ver == 1) 
  {
    foreach ($categorias as $row)
    {   
       $ret .= '<input type="button" class="bg-info" style="font-size:14px;" onclick="mostrar_prodsselec(this.id)" id="' . $row['SUBCAT'] . '" value="' . $row['SUBCAT'] . '" /> &nbsp';
    }

    $ret .= '</div>';

    echo $ret;

  }


}

if ($estado == 'tab_prodsselec') 
{
  $subcat = $_POST['subcat'];

  $ver = '';
  $mod = '';
  $borrar = '';
  $ret = '';

  $info = new crud();

  $privilegios = $info->get_privilegios($usuario, 7);

  foreach ($privilegios as $row)
  {   
   $ver = $row['VER']; 
   $mod = $row['MODIFICAR'];
   $borrar = $row['BORRAR'];
  }


  $categorias = $info-> get_prods_seleccion($subcat);

  $ret .= '<center>' . $subcat . ' : </center>' ;

  if ($ver == 1) 
  {
    foreach ($categorias as $row)
    {  
       // evaluar si se puede server el plato sino deshabilitar el boton
       $funcion = "agregar_prodalist(this.id)";
       $servir = validar_servicio($row);
       if ($servir == 'disabled') {$funcion = "no_agregar(this.id)";}

       $preguntas = traer_preguntas($row);
     
       // imagenes de productos en la comanda aqui >>>> 
       $ret .= '<button type="button" class="bg-info" style="font-size:12px;width: fit-content;height:130px" ' . $servir . '> <img src="images/productos/' . $row['URLIMG'] . '"  height ="110px" width="120px" id="prods_' . $row['PRODUCTO_ID'] . '" title="' . $row['NOMBRE_PROD'] . '" data-preguntas="' . $preguntas . '" data-respuestas="' . $row['RESPUESTAS'] . '"  data-nombre="' . $row['NOMBRE_PROD'] . '" data-precio="' . $row['PRECIO_FINAL'] . '" data-propina="' . $row['PROPINA'] . '"  onClick="' . $funcion . '"/><br><span > <b>' . $row['NOMBRE_PROD'] . '</b></span> </button>';
    }

    echo $ret;

  }
}

function validar_servicio($row)
{
  $serv = '';
  date_default_timezone_set('America/El_Salvador');
  $fechacompar = date('l');

  if ($row['SERVICIO'] == 'false')
  {
    if ($row['LUNES'] == 'false' && $fechacompar == 'Monday' ){$serv = 'disabled';}
    if ($row['MARTES'] == 'false' && $fechacompar == 'Tuesday' ){$serv = 'disabled';}
    if ($row['MIERCOLES'] == 'false' && $fechacompar == 'Wednesday' ){$serv = 'disabled';}
    if ($row['JUEVES'] == 'false' && $fechacompar == 'Thursday' ){$serv = 'disabled';}
    if ($row['VIERNES'] == 'false' && $fechacompar == 'Friday' ){$serv = 'disabled';}
    if ($row['SABADO'] == 'false' && $fechacompar == 'Saturday' ){$serv = 'disabled';}
    if ($row['DOMINGO'] == 'false' && $fechacompar == 'Sunday' ){$serv = 'disabled';}
  }
  else
  {
      $serv = 'enabled';
  }
  return $serv;
}

function traer_preguntas($row)
{
  $preguntas = '';
  if ($row['NOTAS_OBLIGATORIAS'] == 'true')
  {
    $preguntas = $row['PREGUNTAS'];
  }
  return $preguntas;
}

if ($estado == 'tab_catasignadas') 
{ 
  $cat = $_POST['cat'];

  $info = new crud();

  //ASIGNADOS

  $result_j = $info->get_cat_prod_asig($cat);

  $catasig = '';

  $catasig .= '<table id="tabasignadas" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>MENUS</th><th>>></th></thead>';
  foreach ($result_j as $row)
  {   
     $catasig .=  '<tr><td> ' . $row['NOMBRE'] . '</td><td><input  type="button" value=">>" class="bg-danger" id="bscat_'. $row['CAT_ID'] . '"  onClick="quitar_scattocat(this.id)" ></td></tr>';
  }
  $catasig .= '</table>';

  // DISPONIBLES

  $result_j = $info->get_cat_prod_asig2($cat);

  $catasig2 = '';

  $catasig2 .= '<table id="tabasignar" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>MENUS</th><th><<</th><th>ASIGNADO:</th></thead>';
  foreach ($result_j as $row)
  {  
    $color ='';
    if ($row['ESTADO'] != 'NO ASIGNADO')
    {
      $color = 'warning';
    }
    else
    {
      $color = 'success';
    }

     $catasig2 .=  '<tr><td> ' . $row['NOMBRE'] . '</td><td><input  type="button" value="<<" class="bg-success" id="ascat_'. $row['CAT_ID'] . '"   onClick="asignar_scattocat(this.id)" ></td><td class="bg-' . $color . '">'. $row['ESTADO'] . '</td></tr>';
  }
  $catasig2 .= '</table>';


  $retarray = [];

  $retarray[0] = $catasig;
  $retarray[1] = $catasig2;
  
  echo json_encode($retarray);

}

if ($estado == 'tab_borrar_scat') 
{ 
  $scat = $_POST['scat'];

  $info = new crud();

  $borrar ='';

  $borrar = $info->borrar_scat($scat);

  echo $borrar;
}

if ($estado == 'tab_asignar_scat') 
{ 
  $scat = $_POST['scat'];
  $cat = $_POST['cat'];

  $info = new crud();

  $borrar ='';

  $borrar = $info->asignar_scat($scat,$cat);

  echo $borrar;
}

if ($estado == 'bloquear_la_mesa') 
{ 
  $mesa = $_POST['mesa'];

  $info = new crud();

  $result = '';

  $result = $info->bloquear_mesa($mesa, $usuario);

  echo $result;

}

if ($estado == 'redraw_map_areas') 
{ 

  $info = new crud();
   //get area1
  $area1 = get_area(1);
  $area2 = get_area(2);
  $area3 = get_area(3);
  $area4 = get_area(4);

  $areas = [];

  $areas[0] =  $area1; 
  $areas[1] =  $area2;
  $areas[2] =  $area3;
  $areas[3] =  $area4; 



  echo json_encode($areas);
  
}

if ($estado == 'get_mesasxzona_dusuario')
{
  $usuarioc = $_POST['usuarioc'];
  //$returnarray = array();
  
  $returnarray = refreshzonasusuario($usuarioc);

  echo json_encode($returnarray);

}

function refreshzonasusuario($usuarioc)
{
  $info = new crud();
  $zonas =  $info-> get_zonas_usuario($usuarioc);
  $returnarraytmp = array();
 // se obtienen las mesas que se van a ocultar! traducido de CHAT GPT
 foreach ($zonas as $row) {
  for ($i = 1; $i <= 10; $i++) { //10 zonas
    $zonaKey = 'ZONA' . $i;
    if ($row[$zonaKey] == 'false') {
      $result = $info->get_zonas($i);
      foreach ($result as $row2) {
        array_push($returnarraytmp, $row2['MESA']);
      }
    }
  }
}

return $returnarraytmp;

}

if ($estado == 'grid_mesas_mover')
{
  $ret ='';

  $mesaact = $_POST['mesaact'];
  $mesasu = $_POST['mesasu'];
  $usuarioc = $_POST['usuarioc'];


  $info = new crud();

  $result_j = $info->zonas($usuarioc);

  $ret = '<b>MESA : </b> <input type="text" size="5px" value="' . $mesaact . '" disabled><b><br>';

  $ret .= 'SELECCIONE UNA ZONA : <select onchange="abrir_zona_mover(event)"> ';

  $ret .= "<option value=''></option>";

  $i = 1;
  foreach ($result_j as $row) {
    if ($row['ZONAX'] == 'true' )
    {
    $ret .= "<option value='" .   $row['ZONA']  . "'>ZONA " .   $row['ZONA']  . "</option>";
    }
  }

  $ret .= '</select><br><div id="mesasmover" style="height:200px;width:200px;overflow:auto;box-sizing: border-box;padding: 10px;border: 3px double black;">Solo se mostraran zonas y mesas asignadas al usuario y que no esten ocupadas en el momento</div>';

  echo $ret;

}


if ($estado == 'grid_mesas_union')
{
  $ret ='';

  $mesaact = $_POST['mesaact'];
  $mesauni = $_POST['mesauni'];
  $mesasu = $_POST['mesasu'];
  $usuarioc = $_POST['usuarioc'];


  $info = new crud();

  //ASIGNADOS

  $result_j = $info->zonas($usuarioc);

  $ret = '<b>MESA PRINCIPAL : </b> <input type="text" size="5px" value="' . $mesaact . '" disabled><b><br> MESAS-UNIDAS : </b><input id="unidas" type="text" size="10px" value="' . $mesauni . '" disabled><br>';

  $ret .= 'SELECCIONE UNA ZONA : <select onchange="abrir_zona(event)"> ';

  $ret .= "<option value=''></option>";

  $i = 1;
  foreach ($result_j as $row) {
    if ($row['ZONAX'] == 'true' )
    {
    $ret .= "<option value='" .   $row['ZONA']  . "'>ZONA " .   $row['ZONA']  . "</option>";
    }
  }

  $ret .= '</select><br><div id="mesasunir" style="height:200px;width:200px;overflow:auto;float:left;box-sizing: border-box;padding: 10px;border: 3px double black;">Solo se mostraran zonas y mesas asignadas al usuario y que no esten ocupadas en el momento</div><div style="height:200px;width:200px;overflow:auto;float:left;box-sizing: border-box;padding: 10px;border: 3px double black;" id="mesasunidas"></div>';

  echo $ret;

}

if ($estado == 'grid_mesas_liberar')
{
  $usuarioc = $_POST['usuarioc'];

   $ret ='';
 
   $info = new crud();

  //ASIGNADOS

  if ($usuario == 'ADMIN')
  {
  $result_j = $info->zonas_all();
  }
  else
  {
    $zonas = $info->get_zonas_usuario($usuarioc);
    $result_j = array();

    for ($i = 1; $i <= 10; $i++) {
      $column = 'ZONA' . $i;
      if ($zonas[0][$column] == 'true') {
          array_push($result_j, (string)$i);
      }
  }
   }

  $ret .= 'SELECCIONE UNA ZONA : <select id="selectzona" onchange="abrir_zona_liberar(event)"> ';

  $ret .= "<option value=''></option>";

  $i = 1;
  

  if ($usuario == 'ADMIN')
  {
  foreach ($result_j as $row) {
    $ret .= "<option value='" .   $row['ZONA']  . "'>ZONA " .   $row['ZONA']  . "</option>";
  }
  }
  else
  {
    $i = 0;
    foreach ($result_j as $row) {
      $ret .= "<option value='" .   $result_j[$i]  . "'>ZONA " .   $result_j[$i]  . "</option>";
      $i ++;
    }
  }

  $ret .= '</select><br><div id="mesas_a_liberar" style="height:200px;width:400px;overflow:auto;box-sizing: border-box;padding: 10px;border: 3px double black;"></div>';

  echo $ret;

}

if ($estado == 'llenar_zonas_unir')
{
  $zona = $_POST['zona'];
  $mesaactual = $_POST['mesaactual'];

  $ret ='';

  $info = new crud();

  $result_j = $info->get_zonas_a($zona,$mesaactual); // TODAS LAS ZONAS Q ESTEN LIBRES
    
  $count = 0; // initialize a counter for the number of buttons added
  foreach ($result_j as $row) {
    $ret .= "<button  value='" . $row['MESA'] . "' onclick='agregar_submesa(" . $row['MESA'] . ")' class='btn-primary' style='width:32px'>" . $row['MESA'] . "</button> &nbsp";
    $count++; // increment the counter after each button is added
    if ($count % 4 == 0) { // check if the current button is a multiple of 5
      $ret .= "<br>"; // add a <br> tag after every 5th button
     }
  }
  

  echo $ret;
}

if ($estado == 'llenar_zonas_mover')
{
  $zona = $_POST['zona'];
  $mesaactual = $_POST['mesaactual'];

  $ret ='';

  $info = new crud();

  $result_j = $info->get_zonas_a($zona,$mesaactual); // TODAS LAS ZONAS Q ESTEN LIBRES
    
  $count = 0; // initialize a counter for the number of buttons added
  foreach ($result_j as $row) {
    $ret .= "<button  value='" . $row['MESA'] . "' onclick='mover_mesa_a(" . $row['MESA'] . ")' class='btn-primary' style='width:32px'>" . $row['MESA'] . "</button> &nbsp";
    $count++; // increment the counter after each button is added
    if ($count % 4 == 0) { // check if the current button is a multiple of 5
      $ret .= "<br>"; // add a <br> tag after every 5th button
     }
  }
  

  echo $ret;
}

if ($estado == 'llenar_zonas_liberar')
{
  $zona = $_POST['zona'];
  
  $ret ='';

  $info = new crud();

  $result_j = $info->get_zonas_aliberar($zona); // TODAS LAS ZONAS Q ESTEN LIBRES
    
  $count = 0; // initialize a counter for the number of buttons added
  foreach ($result_j as $row) {
    $ret .= "<button id='eliminar" . $row['MESA'] . "' value='" . $row['MESA'] . "' onclick='liberar_mesa(" . $row['MESA'] . ")' class='btn-primary' style='width:50px'>" . $row['MESA'] . "</button> &nbsp";
    $count++; // increment the counter after each button is added
    if ($count % 4 == 0) { // check if the current button is a multiple of 5
      $ret .= "<br>"; // add a <br> tag after every 5th button
     }
  }
  

  echo $ret;
}

if ($estado == 'agregar_submesa')
{
  $submesa = $_POST['submesa'];
  $mesa = $_POST['mesa'];
  $usuarioc = $_POST['usuarioc'];
  $ret = 0;

  $info = new crud();

  $result_j = $info->verificar_mesaocupada($submesa);
  if ($result_j[0] == 0)
  {
   //no esta ocupada, verificar si es mia
   $result_k = $info->verificar_mesausuario($usuarioc,$submesa);
   if ($result_k[0] > 0)
   {
    //si es mia hacer esto
    $result_l = $info->bloquear_mesa_ylog($submesa, $usuarioc, $mesa);
    $ret = 1;
   }
  }

  echo $ret;
}

if ($estado == 'quitar_submesa')
{
  $submesa = $_POST['submesa'];
  $ret = 0;

  $info = new crud();

  $result_j = $info->desocupar_submesa($submesa);

  
  echo $result_j[0];
}

if ($estado == 'liberar_mesao')
{
  $mesa = $_POST['mesa'];
  $smesa = $_POST['smesa'];
  $principal = $_POST['principal'];

  $info = new crud();

  $result_f = $info->estado_submesa($mesa,$smesa);

  $result_j = $info->liberar_mesao($mesa);

  if ($principal == 'SI')
  {
    // cambiar estado de orden a cancelado
    // en futuro afectar inventario
    $result_s = $info->estado_mesa_cancelar($mesa);
  }
  
  echo $result_j;
}

// if ($estado == 'enviar_comanda')
// {
//   $usuarioc = $_POST['usuarioc'];
//   $num_personas = $_POST['num_personas'];
//   $dui = $_POST['dui'];
//   $mesa = $_POST['mesa'];
//   $submesa = $_POST['submesa'];
//   $listado_comanda = $_POST['listado_comanda']; //array
//   $propina = $_POST['propina'];
//   $llevar = 'NO';
//   $bloquear_mesa = 0;

//   if ($mesa == 'llevar'){$llevar = 'SI';}
  
//   $info = new crud();

//   $ordenm = mes_comanda();
//   $ordend = dia_comanda();
//   $ordena = ano_comanda();
  
//   // adquirir Id de la orden de tabla ordenes HEADER
//   $orden = $info->insertar_ordentable($mesa,$submesa,$usuarioc,$usuario,$ordenm,$ordend,$ordena,$llevar,$dui,$num_personas);//retornar orden creada
  
//   $ordenzeros = orden_zeros($orden);

//   $ordenmasked = $ordenm . $ordend . $ordena . $ordenzeros;

//   // guardarla en la mesas_estado (de aqui se sabe que la orden esta abierta y cual en que mesa)
//   if ($llevar == 'NO')
//   {
//   $bloquear_mesa = $info->ocupar_mesa($mesa,$submesa,$num_personas,$usuarioc,$orden,$ordenmasked);
//   }

//   //GUARDAR LINEAS
//   // guardar las lineas basado en los datos de la orden para linkear
//        //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
//       // cuenta, idprod, nombre, precio, unidad, propina, pregunta
//       //da vuelta a cada linea
//   foreach ($listado_comanda as $value) {
//       $guardar_orden = $info->enviar_comanda($value,$ordenm,$ordend,$ordena,$orden,$ordenzeros,$ordenmasked,$usuarioc,$usuario,$propina);
//   }
  
//   echo json_encode($ordenmasked);
// }

// if ($estado == 'modificar_comanda')
// {
//   $info = new crud();

//   $orden =  $_POST['orden'];
//   $usuarioc = $_POST['usuarioc'];
//   $num_personas = $_POST['num_personas'];
//   $listado_comandaextras = $_POST['listado_comandaextras']; //array
//   $propina = $_POST['propina'];
//   $borrarcv = $_POST['borrarcv'];
//   $borrarcm = $_POST['borrarcm'];

//   $ordenm = mes_comanda();
//   $ordend = dia_comanda();
//   $ordena = ano_comanda();

//   $ordensub = substr($orden,-6);
//   $ordensola = intval($ordensub);

//     //GUARDAR LINEAS
//   // guardar las lineas basado en los datos de la orden para linkear
//        //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
//       // cuenta, idprod, nombre, precio, unidad, propina, pregunta
//      foreach ($listado_comandaextras as $value) {
//         $guardar_orden = $info->enviar_comanda($value,$ordenm,$ordend,$ordena,$ordensola,$ordensub,$orden,$usuarioc,$usuario,$propina);
//     }

//     if ($borrarcm == 'SI')
//     {
//       $borrar_ordencm = $info-> borrar_extras_cm($orden);
//     }
//     if ($borrarcv == 'SI')
//     {
//       $borrar_ordencv = $info-> borrar_extras_cv($orden);
//     }

    
//     echo json_encode($orden);
// }


function mes_comanda()
{
  date_default_timezone_set('America/El_Salvador');
  $month = date('m'); // Get the current month in two-digit format (e.g. "04")

  if(strlen($month) == 1) {
    $month = '0' . $month; // Add a leading zero if the length is one (e.g. "04" instead of "4")
  }
  
  return $month;
}

function ano_comanda()
{
  date_default_timezone_set('America/El_Salvador');
  $year = date('Y'); // Get the current month in two-digit format (e.g. "04")
  
  return $year;
}

function dia_comanda()
{
  date_default_timezone_set('America/El_Salvador');
  $day = date('d'); // Get the current month in two-digit format (e.g. "04")

  if(strlen($day) == 1) {
    $day = '0' . $day; // Add a leading zero if the length is one (e.g. "04" instead of "4")
  }
  
  return $day;
}

function orden_zeros($orden)
{
  $num = $orden; // The integer value to be padded with zeros
  $num_padded = str_pad($num, 6, '0', STR_PAD_LEFT); // Pad $num with zeros to a length of 6
  
  return $num_padded; 
}


if ($estado == 'buscar_orden_pendiente')
{
  $mesa = $_POST['mesa'];
  $submesa = '';
  $dui = '';
  $clientenombres = '';
  $numpersonas = 0;

  $info = new crud();
  $datos = [];
  // buscar si tiene orden
  // si tiene orden buscar de un solo sus datos en un array  
  $orden = $info->get_orden_estado($mesa);

  if ($orden[0] != 0)
  {
    $datos = $info->get_busqueda_orden($orden[0]);
  }

  $ordenheader = $info->get_orden_header($mesa);

  foreach ($ordenheader as $row) {
    $dui = $row['DUI'];
    $submesa = $row['SUBMESAS'];
    $numpersonas = $row['NUM_PERSONAS'];
  }
 
  $cliente = $info->buscar_cliente_delinea($dui);

  foreach ($cliente as $row) {
    $clientenombres = $row['NOMBRES'];
  }

  $ret = [];

  $ret[0] = $orden;
  $ret[1] = $datos;
  $ret[2] = $dui;
  $ret[3] = $submesa;
  $ret[4] = $clientenombres;
  $ret[5] = $numpersonas;

  echo json_encode($ret); 
}

if ($estado == 'lleva_cover') 
{

  $info = new crud();
  
  $cover = $info->lleva_cover();

  if ($cover)
  {
    if (date("l") == 'Monday' && $cover[1] == 'false')
    {
      $cover[0] = 0;
    }
    if (date("l") == 'Tuesday' && $cover[2] == 'false')
    {
      $cover[0] = 0;
    }
    if (date("l") == 'Wednesday' && $cover[3] == 'false')
    {
      $cover[0] = 0;
    }
    if (date("l") == 'Thursday' && $cover[4] == 'false')
    {
      $cover[0] = 0;
    }  
      if (date("l") == 'Friday' && $cover[5] == 'false')
      {
        $cover[0] = 0;
      }
      if (date("l") == 'Saturday' && $cover[6] == 'false')
      {
        $cover[0] = 0;
      }
      if (date("l") == 'Sunday' && $cover[7] == 'false')
      {
        $cover[0] = 0;
      }

            //si esta desactivado
            if ($cover[8] == 'false')
            {
              $cover[0] = 0;
            }
  }

  if ($cover)
  {
  echo $cover[0];
  }
  else
  {
  echo 0;
  }
}

if ($estado == 'lleva_consumo') 
{

  $info = new crud();
  
  $consumo = $info->lleva_consumo();

  if ($consumo)
  {
    if (date("l") == 'Monday' && $consumo[1] == 'false')
    {
      $consumo[0] = 0;
    }
    if (date("l") == 'Tuesday' && $consumo[2] == 'false')
    {
      $consumo[0] = 0;
    }
    if (date("l") == 'Wednesday' && $consumo[3] == 'false')
    {
      $consumo[0] = 0;
    }
    if (date("l") == 'Thursday' && $consumo[4] == 'false')
    {
      $consumo[0] = 0;
    }  
      if (date("l") == 'Friday' && $consumo[5] == 'false')
      {
        $consumo[0] = 0;
      }
      if (date("l") == 'Saturday' && $consumo[6] == 'false')
      {
        $consumo[0] = 0;
      }
      if (date("l") == 'Sunday' && $consumo[7] == 'false')
      {
        $consumo[0] = 0;
      }

      //si esta desactivado
      if ($consumo[8] == 'false')
      {
        $consumo[0] = 0;
      }
  }

  if ($consumo)
  {
  echo $consumo[0];
  }
  else
  {
  echo 0;
  }
}


if ($estado == 'permisos_comanda') 
{
  $info = new crud();

  $data = [];

  $result = $info->get_permisos_comanda($usuario);

  $data[0]  = $result[0]; //pre
  $data[1]  = $result[1]; //separar
  $data[2]  = $result[2]; //cortesia
  $data[3]  = $result[3]; //IMPRIMIR

  echo json_encode($data);

}

if ($estado == 'accion_mover_mesa') 
{
  $mesaori = $_POST['mesaori'];
  $mesa = $_POST['mesa'];
  $usuariob = $_POST['usuariob'];
  $ordenmasked = $_POST['orden'];
  $num_personas = $_POST['numpersonas'];
  $submesa = $_POST['submesa'];
  $result_f = '';
  $result = '';

  if ($ordenmasked != 0)
  {
  $lastSixChars = substr($ordenmasked, -6);
  $orden = intval($lastSixChars);
  }
    
  
  $info = new crud();

  // decision si solo bloqueo o ocupada dependiedo de la orden

  if ($ordenmasked == 0)
  {
    $result = $info->bloquear_mesa($mesa, $usuariob);
    echo $result;
  }
  else
  {
    $result = $info->ocupar_mesa_affectrows($mesa,$submesa,$num_personas,$usuariob,$orden,$ordenmasked);
    if ($result > 0)
    {
      $result_f = $info->actualizar_ordentable($mesaori,$mesa,$submesa,$usuariob,$usuario,'NO',$num_personas);
    }
    echo $result;
  }

  //activar mesa original ya no debe estar ocupada
  $result_j = $info->liberar_mesao($mesaori); 
}

if ($estado == 'revisar_orden_enproceso')
{
  $orden = $_POST['orden'];

  $info = new crud();

  $result_j = $info->revisar_ordenproceso($orden); 

  echo json_encode($result_j);
}

if ($estado == 'get_extra_detalles')
{
  $idprod = $_POST['idprod'];
  //get prod name, precio, propina
  $info = new crud();

  $result_j = $info->get_extra_det($idprod); 
  //NOMBRE_PROD, PRECIO_FINAL, PROPINA
  $ret = [];

  $ret[0] = $result_j[0];
  $ret[1] = $result_j[1];
  $ret[2] = $result_j[2];
  
  echo json_encode($ret);
}

if ($estado == 'get_facturar_estado_mesa')
{
$mesa = $_POST['mesa'];

$info = new crud();

$orden = $info->get_orden_caja($mesa);
$facturar_mesa = $info->get_facturar_estado_mesa($orden[0]);
echo json_encode($facturar_mesa[0]);

}

if ($estado == 'facturar_orden')
{
  $orden = $_POST['orden'];
  $usuarioc = $_POST['usuarioc'];
  $metodo = $_POST['metodo'];
  $mesa = $_POST['mesa'];

  $info = new crud();

  $facturar_orden = $info->facturar_orden($orden,$usuarioc,$metodo);

  $liberar = $info->liberar_mesao($mesa);

  echo $facturar_orden;

}

?>



