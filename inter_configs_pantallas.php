<?php

session_start();

require_once "cfg/conexion.php";
require_once "crud/crud.php";

$estado = $_POST['estado'];
$usuario = $_POST['usuario'];

if ($estado == 'tarea_zonasusuario')  
{
    $info = new crud();

    $result_f = $info->tarea_zonasuser();    

    echo $result_f;
}

function get_colores($colorval,$sel)
{
    $colores = '';
    $selC = '';
    $selG = '';
    $selB = '';
    $selA = '';
    $selAZ = '';
    $selV = '';
    $backg = '';

    if ($sel == 'celeste')
    {
       $selC = 'selected';
       $backg = 'style="background-color:cyan"';
    }
    else if ($sel == 'gris')
    {
       $selG = 'selected'; 
       $backg = 'style="background-color:gray"';
    }
    else if ($sel == 'blanco')
    {
       $selB = 'selected'; 
       $backg = 'style="background-color:white"';
    }
    else if ($sel == 'verde')
    {
       $selV = 'selected'; 
       $backg = 'style="background-color:green"';
    }
    else if ($sel == 'amarillo')
    {
       $selA = 'selected'; 
       $backg = 'style="background-color:yellow"';
    }
    else if ($sel == 'azul')
    {
       $selAZ = 'selected'; 
       $backg = 'style="background-color:lightblue"';
    }
    else
    {
        $selB = 'selected';
        $backg = 'style="background-color:white"';
    }

    $colores = '<select name="estado" id="colori'. $colorval . '" onchange="bgestadocolor_fondos(this.id)" '. $backg .'>
    <option value="celeste" style="background-color:cyan" '. $selC .'>celeste</option>
    <option value="gris" style="background-color:gray" '. $selG .'>gris</option>
    <option value="blanco" style="background-color:white" '. $selB .'>blanco</option>
    <option value="verde" style="background-color:green" '. $selV .'>verde</option>
    <option value="amarillo" style="background-color:yellow" '. $selA .'>amarillo</option>
    <option value="azul" style="background-color:lightblue" '. $selAZ .'>azul</option>
    </select>';

    return $colores;
}

function get_zonas_deusuario($cantz, $userid)//cant de zonas, id de usuario
{
        $info = new crud();

         $result_f = $info->get_allzonas($userid);    

         $selecciones = '';         
         
         for ($i = 0; $i <= $cantz - 1 ; $i++) {
         $ck = '';
         if ($result_f[$i] != 'false' )
         {
            $ck = 'checked';
         }
         $asig = 0;
         $asig = $i + 1;
         $selecciones .=  '<a class="dropdown-item"><input type="checkbox" ' . $ck . ' value="ZONA' . $asig . '" > Zona ' . $asig . ' </a>';
         }

        $rowzonas = '<div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Zonas :
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="drop' . $userid . '">
        ' . $selecciones .'
        </div>
        </div>';
    return $rowzonas;
}

if ($estado == 'tab_usuarios') 
{
$info = new crud();
//seguridad
$ver = 0;
$mod = 0;
$borrar = 0;
$flagmod = 'disabled';
$flagborrar = 'disabled';

$buscar = $_POST['buscar'];
$buscarg = $_POST['buscarg'];

// si buscar viene vacio buscar todos si no buscar el especifico
if ($buscar == '') {
     $result_f = $info->grid_usuarios();    
}
else
{
    $result_f = $info->grid_usuarios_buscar($buscar);   
}

//seguridad
// Priv = 1 , Mantener usuarios
$privilegios = $info->get_privilegios($usuario, 1);

foreach ($privilegios as $row)
{   
 $ver = $row['VER']; 
 $mod = $row['MODIFICAR'];
 $borrar = $row['BORRAR'];
}

$varroles = '';
$roles = $info->get_roles();
$varroles .= '<select name="rol" id="rol"><option value=""></option>';
foreach ($roles as $row)
{   
 $varroles .=  '<option value="'. $row['NOMBREROL'] . '" valor'. $row['NOMBREROL'] . '>'. $row['NOMBREROL'] . '</option>';
}
$varroles .= '</select>';

$retorno ='';

//seguridad
if ($ver == 1)
{
//seguridad
if ($mod != 0){ $flagmod = 'enabled'; } else { $flagmod = 'disabled'; }
if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

if ($buscar == '') {
    $result_f = $info->grid_usuarios();    
}
else
{
   $result_f = $info->grid_usuarios_buscar($buscar);   
}

$colorval = '';
$sel = '';

$colores = get_colores($colorval,$sel);

$cantz = '';

$cantz = $info->get_cantzonas();  

//$seleccioneszonas = get_zonas_sinusuario($cantz);
    
$retorno .=  '<div style="text-align: left;font-size:16px;"> 
<b><h5>CREAR UN USUARIO : </b></h5>
<p> <input type="text" id="UsuarioN" placeholder="Usuario">
<input type="password" id="passwordN" placeholder="password"> 
<input type="text" id="nombreN" placeholder="Nombre">
ROL: ' . $varroles . ' <br><br>
<input type="number" id="MetaS" placeholder="Meta Semanal">
<input type="number" min="1" max="1000" id="ComisionS" placeholder="Comision de Venta" style="width: 160px" > %
<input type="number" min="1" max="1000" id="ComisionP" placeholder="Comision de Propina" style="width: 160px"> %
Fondo : ' . $colores . '
<button type="button" class="btn btn-dark btn-sq-responsive bg-primary" onClick="agregar_usuario()" style="height: 20px" ' . $flagmod. '></button></p>
<p> FILTRAR USUARIO : <input type="text" id="UsuarioB" placeholder="Usuario"> 
<button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="buscar_usuarioa()" style="height: 20px" ></button> TAREAS : <button type="button" class="btn btn-dark btn-sq-responsive bg-warning" onClick="activar_zonasameseros()" style="height: 40px" >TODA ZONA</button></p>
</div>';

$retorno .= '<div style="height:400px;overflow:auto;font-size: 12px;"><table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">ID</th><th width="100px">USUARIO</th><th width="100px">PASSWORD</th><th width="325px">NOMBRE</th><th width="75px">ESTADO</th><th width="100px">ROL</th><th width="85px">META SEMANAL</th><th width="90px">COMISION VENTA</th><th width="90px">COMISION PROPINA</th><th>ZONAS</th><th>FONDO</th><th width="100px">X</th><th width="100px">M</th></thead><tr>'; 




foreach ($result_f as $row)
{   

 $tempvalorroles   = '';
 $valreplace = '';
 $tempvalorroles =  $varroles;
 $valreplace = 'valor'. $row['ROL'] . '';
 $idreplace = 'id=rol' . $row['USUARIO_ID'] . '';
 $tempvalorroles = str_replace ($valreplace, 'selected', $tempvalorroles);
 $tempvalorroles = str_replace ('id="rol"',  $idreplace , $tempvalorroles );

 $seleccion = '';

if ( $row['ESTADO'] == 'ACTIVO')
{
    $seleccion = '<select name="estado" id="estado'. $row['USUARIO_ID'] . '">
    <option value="ACTIVO" selected>ACTIVO</option>
    <option value="INACTIVO">INACTIVO</option>
    </select>';
}
else
{
    $seleccion = '<select name="estado" id="estado'. $row['USUARIO_ID'] . '">
    <option value="ACTIVO">ACTIVO</option>
    <option value="INACTIVO" selected>INACTIVO</option>
    </select>';
}

$butdelete = '<button id="'. $row['USUARIO_ID'] . '"class="bg-danger" '. $flagborrar . ' OnClick="borrar_usuario(this.id)">X</button>';
$butmodifi = '<button id="'. $row['USUARIO_ID'] . '"class="bg-warning" '. $flagmod . ' OnClick="modificar_usuario(this.id)">M</button>';
// no queremos que se pierda el acceso total al sistema
$rowselect = '';
if ($row['USUARIO'] == 'ADMIN' || $row['USUARIO'] =='DESPINOZA')
{
    $butdelete = '';
    //$butmodifi = '';
    $rowselect = 'disabled';
    $seleccion = '<select name="estado" id="estado'. $row['USUARIO_ID'] . '">
    <option value="ACTIVO" selected disabled>ACTIVO</option>
    </select>';
    $tempvalorroles = '<select name="rol" id="rol'. $row['USUARIO_ID'] . '">
    <option value="ADMINISTRADOR" selected disabled>ADMINISTRADOR</option>
    </select';
}
$idzona = '';

$rowzonas = get_zonas_deusuario($cantz[0], $row['USUARIO_ID']);

$colorval = $row['USUARIO_ID'] ;
$sel = $row['FONDO'] ;
$colores = get_colores($colorval,$sel);
$retorno .= '<tr><td width="100px">' . $row['USUARIO_ID'] . '</td><td width="100px" ><input type="text" id="usuarioID'. $row['USUARIO_ID'] . '" value="' . $row['USUARIO'] . '" disabled></td><td><input type="password" id="Newpassword'. $row['USUARIO_ID'] . '" placeholder="Nuevo Password" ' . $rowselect . '> </td><td width="350px"><input type="text" id="usuarioN'. $row['USUARIO_ID'] . '" value="' . $row['NOMBRE'] . '" ' . $rowselect . '></td><td width="75px" >' . $seleccion . '</td><td width="100px" >' . $tempvalorroles . '</td><td width="100px"><input type="number"  ' . $rowselect . ' id="MetaS'. $row['USUARIO_ID'] . '" value="' . $row['META'] . '" > </td><td width="100px"><input style="width:45px;" type="number" min="1" max="100" id="Comision'. $row['USUARIO_ID'] . '" value="' . $row['COMISION_VENTA'] . '" ' . $rowselect . '> % </td><td width="100px"><input style="width:45px;" type="number" min="1" max="100" id="ComisionP'. $row['USUARIO_ID'] . '" value="' . $row['COMISION_PROPINA'] . '" ' . $rowselect . '> % </td><td>' . $rowzonas  . '</td> <td>' . $colores . '</td><td width="100px">' . $butdelete . '</td><td width="100px">' . $butmodifi . '</td></tr>';
} 

$retorno .= '</table></div>' ;

}

// manto de roles principales

//seguridad
$ver2 = 0;
$mod2 = 0;
$borrar2 = 0;
$flagmod2 = 'disabled';
$flagborrar2 = 'disabled';
// Priv = 2 , Mantener usuarios
$privilegios2 = $info->get_privilegios($usuario, 2);

foreach ($privilegios2 as $row)
{   
 $ver2 = $row['VER']; 
 $mod2 = $row['MODIFICAR'];
 $borrar2 = $row['BORRAR'];
}

//seguridad
if ($ver2 == 1)
{
//seguridad
if ($mod2 != 0){ $flagmod2 = 'enabled'; } else { $flagmod2 = 'disabled'; }
if ($borrar2 != 0) { $flagborrar2 = 'enabled'; } else { $flagborrar2 = 'disabled'; }

$retorno .=
 '<div style="text-align: left;font-size: 10px;"> <b><h5>CREAR/MODIFICAR UN ROL :</b></h5><p> ROL : <input type="text" id="rolcrea" placeholder="Nombre de Rol"> 
<button type="button" class="btn btn-dark btn-sq-responsive bg-primary" onClick="agregar_rol()" style="height: 20px" ' . $flagmod2 . '></button></p></div>';

$retorno .= '<div style="height:300px;overflow:auto;font-size: 12px;"><table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">ROL</th><th>X - ELIMINAR</th><th>M - MODIFICAR</th></thead><tr>'; 

$result_g = $info->get_roles();    

foreach ($result_g as $row)
{   
    $butdelete = '<button id="'. $row['ROL_ID'] . '"class="bg-danger" '. $flagborrar2 . ' OnClick="borrar_rol(this.id)">X</button>';
    $butmodifi = '<button id="'. $row['ROL_ID'] . '"class="bg-warning" '. $flagmod2  . ' OnClick="modificar_rol(this.id)">M</button>';
    if ($row['NOMBREROL'] == 'ADMINISTRADOR' )
    {
        $butdelete = '';
        $butmodifi = '';
    }
    $retorno .= '<tr><td><input type="text" id="rolc'. $row['ROL_ID'] . '" value="' . $row['NOMBREROL'] . '" ></td> <td width="100px">' . $butdelete . '</td><td width="100px">' . $butmodifi . '</td></tr>';
}
$retorno .= '</table></div>' ;
}
else
{
 //puede q el otro ya traiga algo, no hacer nada no crear nada    
}


// manto de grupos para usuarios

//seguridad
$ver3 = 0;
$mod3 = 0;
$borrar3 = 0;
$flagmod3 = 'disabled';
$flagborrar3 = 'disabled';
// Priv = 2 , Mantener usuarios
$privilegios3 = $info->get_privilegios($usuario, 3);

foreach ($privilegios3 as $row)
{   
 $ver3 = $row['VER']; 
 $mod3 = $row['MODIFICAR'];
 $borrar3 = $row['BORRAR'];
}

if ($ver3 == 1)
{

    if ($buscarg == '') {
        $result_f = $info->grid_usuarios();    
    }
    else
    {
       $result_f = $info->grid_usuarios_buscar($buscarg);   
    }

//seguridad
if ($mod3 != 0){ $flagmod3 = 'enabled'; } else { $flagmod3 = 'disabled'; }
if ($borrar3 != 0) { $flagborrar3 = 'enabled'; } else { $flagborrar3 = 'disabled'; }

$retorno .=
 '<div style="text-align: left;font-size: 10px;"> <b><h5>ASIGNAR UN GRUPO A UN USUARIO :</b></h5><p> FILTRAR USUARIO : <input type="text" id="usuarioa" placeholder="Nombre de Usuario"> 
<button type="button" class="btn btn-dark btn-sq-responsive bg-primary" onClick="buscar_usuario_grupo()" style="height: 20px" ' . $flagmod3 . '></button></p><p>Nota: Al agregar un nuevo grupo se resetean los privilegios a ese usuario a los de fabrica del grupo. AL quitar el grupo se quitan tambien los privilegios pertenecientes al grupo</p></div>';

$retorno .= '<div style="display: flex;"><div style="height:300px;overflow:auto;font-size: 12px;flex:1"><table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">USUARIO</th></thead><tr>'; 


foreach ($result_f as $row)
{   
   $retorno .= '<tr><td> <button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="load_gruposusuario(this.id)"  value="' . $row['USUARIO_ID'] . '"  id="usuariod'. $row['USUARIO_ID'] . '">' . $row['USUARIO'] . '</button></td></tr>';
}

$retorno .= '</table></div><div id="listgrupos" style="height:300px;overflow:auto;font-size: 12px;flex:1" > </div><div id="listgrupos2" style="height:300px;overflow:auto;font-size: 12px;flex:1" ></div></div><br><br> ' ;


}

/// pantalla asignar privilegios

$ver4 = 0;
$mod4 = 0;
$borrar4 = 0;
$flagmod4 = 'disabled';
$flagborrar4 = 'disabled';
// Priv = 2 , Mantener usuarios
$privilegios4 = $info->get_privilegios($usuario, 4);

foreach ($privilegios4 as $row)
{   
 $ver4 = $row['VER']; 
 $mod4 = $row['MODIFICAR'];
 $borrar4 = $row['BORRAR'];
}

if ($ver4 == 1)
{

    if ($buscarg == '') {
        $result_f = $info->grid_usuarios();    
    }
    else
    {
       $result_f = $info->grid_usuarios_buscar($buscarg);   
    }
    //seguridad
if ($mod4 != 0){ $flagmod4 = 'enabled'; } else { $flagmod4 = 'disabled'; }
if ($borrar4 != 0) { $flagborrar4 = 'enabled'; } else { $flagborrar4 = 'disabled'; }

    $retorno .=
    '<div style="text-align: left;font-size: 10px;"> <b><h5>ASIGNAR/MODIFICAR PRIVILEGIOS :</b></h5><p> FILTRAR USUARIO : <input type="text" id="usuarioab" placeholder="Nombre de Usuario" onKeypress="buscar_usuario_grupoab_key(event)" > 
   <button type="button" class="btn btn-dark btn-sq-responsive bg-primary" onClick="buscar_usuario_grupoab()" style="height: 20px" ' . $flagmod4 . '></button></p></div>';
   
   $retorno .= '<div style="display: flex;"><div style="height:300px;overflow:auto;font-size: 12px;flex:1"><table id="privs3"  class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">USUARIO</th></thead><tr>'; 


   foreach ($result_f as $row)
   {   
      $retorno .= '<tr><td> <button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="load_privilegioslist(this.id)"  value="' . $row['USUARIO_ID'] . '"  id="usuariodp'. $row['USUARIO_ID'] . '">' . $row['USUARIO'] . '</button></td></tr>';
   }
   
   $retorno .= '</table></div><div id="listprivilegios" style="height:300px;overflow:auto;font-size: 12px;flex:1" > </div><div id="listprivilegios2" style="height:300px;overflow:auto;font-size: 12px;flex:1" ></div></div><br><br> ' ;
   
   
 

}

// si ningun ver esta habilitato, deshabilitar el boton de configs de usuarios
if (($ver + $ver2 + $ver3 + $ver4) != 0)
{
echo $retorno;
}
else
{
echo $retorno = 'noboton';    
}

}



if ($estado == 'tab_grupos') 
{

    // grupos existentes
    $info = new crud();
    //seguridad
    $ver = 0;
    $mod = 0;
    $borrar = 0;
    $flagmod = 'disabled';
    $flagborrar = 'disabled';


    //seguridad
    // Priv = 1 , Mantener usuarios
    $privilegios = $info->get_privilegios($usuario, 5);

    foreach ($privilegios as $row)
    {   
    $ver = $row['VER']; 
    $mod = $row['MODIFICAR'];
    $borrar = $row['BORRAR'];
    }

    $buscar = $_POST['buscar'];
    $buscarg = $_POST['buscarg'];
     
    $retorno = ''; 

    // si buscar viene vacio buscar todos si no buscar el especifico

    if ($buscar == '') 
    {
        $result_f = $info->get_grupos();    
    } 
    else
    {
        $result_f = $info->buscar_grupo($buscar);    
    }

    if ($ver == 1)
    {
    //seguridad
    if ($mod != 0){ $flagmod = 'enabled'; } else { $flagmod = 'disabled'; }
    if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

    $retorno ='<div style="text-align: left;font-size: 10px;"> <b><h5>CREAR/MODIFICAR UN GRUPO :</h5><b><p> GRUPO : <input type="text" id="grupocrea" placeholder="Nombre de Grupo"> 
    <button type="button" class="btn btn-dark btn-sq-responsive bg-primary" onClick="agregar_grupo()" style="height: 20px" ' . $flagmod . '></button></p>
    <p> FILTRAR GRUPO : <input type="text" id="Grupo" placeholder="Grupo"> 
    <button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="buscar_grupo()" style="height: 20px" ></button></p></div>';


    $retorno .= '<div style="height:300px;overflow:auto;font-size: 12px;"><table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">GRUPO</th><th>X - ELIMINAR</th><th>M - MODIFICAR</th></thead><tr>'; 

    
    foreach ($result_f as $row)
    {   
        $butdelete = '<button id="'. $row['GRUPO_ID'] . '"class="bg-danger" '. $flagborrar . ' OnClick="borrar_grupo(this.id)">X</button>';
        $butmodifi = '<button id="'. $row['GRUPO_ID'] . '"class="bg-warning" '. $flagmod  . ' OnClick="modificar_grupo(this.id)">M</button>';

        if ($row['GRUPO_ID'] == '1' || $row['GRUPO_ID'] == '8')
        {
            $butdelete = '';
            $butmodifi = '';
        }

        $retorno .= '<tr><td><input type="text" id="grupoc'. $row['GRUPO_ID'] . '" value="' . $row['GRUPO_NOMBRE'] . '" ></td> <td width="100px">' . $butdelete . '</td><td width="100px">' . $butmodifi . '</td></tr>';
    }
    $retorno .= '</table></div>' ;

    }

    if ($buscarg == '') 
    {
        $result_f = $info->get_grupos();    
    } 
    else
    {
        $result_f = $info->buscar_grupo($buscarg);    
    }


     // ASIGNAR OPCIONES A GRUPOS
    //seguridad
    $ver2 = 0;
    $mod2 = 0;
    $borrar2 = 0;
    $flagmod2 = 'disabled';
    $flagborrar2 = 'disabled';


    //seguridad
    // Priv = 1 , Mantener usuarios
    $privilegios2 = $info->get_privilegios($usuario, 6);

    foreach ($privilegios2 as $row)
    {   
    $ver2 = $row['VER']; 
    $mod2 = $row['MODIFICAR'];
    $borrar2 = $row['BORRAR'];
    }

    if ($ver2 == 1)
    {
    //seguridad
    if ($mod2 != 0){ $flagmod2  = 'enabled'; } else { $flagmod2 = 'disabled'; }
    if ($borrar2 != 0) { $flagborrar2 = 'enabled'; } else { $flagborrar2 = 'disabled'; }



    $retorno .='<div style="text-align: left;font-size: 10px"> <b><h5>ASIGNACION DE OPCIONES DE MENU A GRUPOS :</h5></b>
    <p> FILTRAR GRUPO : <input type="text" id="Grupod" placeholder="Grupo"> 
    <button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="buscar_grupod()" style="height: 20px" ></button></p></div>';


    $retorno .= '<div style="display: flex;"><div style="height:300px;overflow:auto;font-size: 12px;flex:1"><table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">GRUPO</th></thead><tr>'; 

    
    foreach ($result_f as $row)
    {   
       $retorno .= '<tr><td> <button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="load_opciones(this.id)"  value="' . $row['GRUPO_NOMBRE'] . '"  id="grupod'. $row['GRUPO_ID'] . '">' . $row['GRUPO_NOMBRE'] . '</button></td></tr>';
    }
   
    $retorno .= '</table></div><div id="listopciones" style="height:300px;overflow:auto;font-size: 12px;flex:1" > </div><div id="listopciones2" style="height:300px;overflow:auto;font-size: 12px;flex:1" ></div></div><br><br> ' ;

    }

     echo $retorno;


}



if ($estado == 'listado_opciones') {
    $grupo = $_POST['grupo'];
    $usuario = $_POST['usuario'];
  
    $info = new crud();
  
    $result_f = $info->buscar_grupo_opciones($grupo);
  
    //seguridad
      // Priv = 5 , Mantener usuarios
      $privilegios2 = $info->get_privilegios($usuario, 6);
  
      foreach ($privilegios2 as $row)
      {   
      $ver2 = $row['VER']; 
      $mod2 = $row['MODIFICAR'];
      $borrar2 = $row['BORRAR'];
      }
  
      if ($ver2 == 1)
      {
      //seguridad
      if ($mod2 != 0){ $flagmod2  = 'enabled'; } else { $flagmod2 = 'disabled'; }
      if ($borrar2 != 0) { $flagborrar2 = 'enabled'; } else { $flagborrar2 = 'disabled'; }
  
      $opciones = '';
  
      $opciones .= '<table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">OPCIONES DE : ' . $grupo . '</th></thead><tr>';
  
      foreach ($result_f as $row)
      {   
      $butborrar = '<button value="'. $grupo . '" id="q'. $row['OPCION_ID'] . '"class="bg-secondary" '. $flagmod2 . ' OnClick="quitar_opcion(this.id)">>></button>';
      $opciones .= '<tr><td> <input type="textbox"  style="text-align:center" value="' . $row['NOMBRE'] . '"  id="opid'. $row['OPCION_ID'] . '" disabled/>&nbsp&nbsp'. $butborrar. '</td><tr>';
      }
    
      $opciones .= '</table>';

     /// aqui de un solo los privilegios filtrados
  
          $result_g = $info->get_opciones($grupo); 
          
          $retorno = '';
  
          $retorno .= '<table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">DISPONIBLES</th></thead><tr> ' ;
  
  
          foreach ($result_g as $row)
          {   
            $butborrar = '<button value="'. $grupo . '" id="a'. $row['OPCION_ID'] . '"class="bg-success" '. $flagmod2 . ' OnClick="agregar_opcion(this.id)"><<</button>';
            $retorno .= '<tr><td> '. $butborrar. ' &nbsp&nbsp<input type="textbox"  style="text-align:center" value="' . $row['NOMBRE'] . '"  id="opid'. $row['OPCION_ID'] . '" disabled/></td><tr>';
          }
  
         $retorno .= '</table>';
  
     $datost = [];
  
     $datost[0] = $opciones;
     $datost[1] = $retorno;

    }
    else
    {

        $datost = [];

        $datost[0] = '';
        $datost[1] = '';

    }

   
     echo json_encode($datost);
  
  }


  if ($estado == 'listado_gruposusuario') 
  {
    $usuariob = $_POST['usuariob'];
    $usuario = $_POST['usuario'];
  
    $info = new crud();
  
    $result_q = $info->buscar_grupo_usuarioa($usuariob);
    $result_f = $info->buscar_grupo_usuario($result_q[0]);
  
    //seguridad
      // Priv = 5 , Mantener usuarios
      $privilegios2 = $info->get_privilegios($usuario, 3);
  
      foreach ($privilegios2 as $row)
      {   
      $ver2 = $row['VER']; 
      $mod2 = $row['MODIFICAR'];
      $borrar2 = $row['BORRAR'];
      }
  
      if ($ver2 == 1)
      {
        if ($mod2 != 0){ $flagmod2  = 'enabled'; } else { $flagmod2 = 'disabled'; }
        if ($borrar2 != 0) { $flagborrar2 = 'enabled'; } else { $flagborrar2 = 'disabled'; }

        $opciones = '';
  
        $opciones .= '<table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">GRUPOS DE : ' . $result_q[0] . '</th></thead><tr>';
    
        foreach ($result_f as $row)
        {   
        $butborrar = '<button value="'. $usuariob . '" id="q'. $row['GRUPO_ID'] . '"class="bg-secondary" '. $flagmod2 . ' OnClick="quitar_opgrupo(this.id)">>></button>';
        $opciones .= '<tr><td> <input type="textbox"  style="text-align:center" value="' . $row['GRUPO_NOMBRE'] . '"  id="grid'. $row['GRUPO_ID'] . '" disabled/>&nbsp&nbsp'. $butborrar. '</td><tr>';
        }

        $opciones .= '</table>';
 
        $retorno= '';

             /// aqui de un solo los privilegios filtrados
  
             $result_g = $info->get_grupos_filtrados($usuariob); 
          
             $retorno = '';
     
             $retorno .= '<table class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">DISPONIBLES</th></thead><tr> ' ;
     
     
             foreach ($result_g as $row)
             {   
               $butborrar = '<button value="'. $usuariob  . '" id="a'. $row['GRUPO_ID'] . '"class="bg-success" '. $flagmod2 . ' OnClick="agregar_opgrupo(this.id)"><<</button>';
               $retorno .= '<tr><td> '. $butborrar. ' &nbsp&nbsp<input type="textbox"  style="text-align:center" value="' . $row['GRUPO_NOMBRE'] . '"  id="opid'. $row['GRUPO_ID'] . '" disabled/></td><tr>';
             }
     
            $retorno .= '</table>';



        $datost = [];
  
        $datost[0] = $opciones;
        $datost[1] = $retorno;
    }
    else
    {
        $datost = [];

        $datost[0] = '';
        $datost[1] = '';

    }


        echo json_encode($datost);


    }



    if ($estado == 'listado_usuarioprivilegios') 
  {
    $usuariob = $_POST['usuariob'];
    $usuario = $_POST['usuario'];
  
    $info = new crud();
  
    $result_q = $info->buscar_grupo_usuarioa($usuariob);
    $result_f = $info->buscar_usuario_privilegio($usuariob);
  
    //seguridad
      // Priv = 4 , privilegios
      $privilegios2 = $info->get_privilegios($usuario, 4);
  
      foreach ($privilegios2 as $row)
      {   
      $ver2 = $row['VER']; 
      $mod2 = $row['MODIFICAR'];
      $borrar2 = $row['BORRAR'];
      }
  
      if ($ver2 == 1)
      {
        if ($mod2 != 0){ $flagmod2  = 'enabled'; } else { $flagmod2 = 'disabled'; }
        if ($borrar2 != 0) { $flagborrar2 = 'enabled'; } else { $flagborrar2 = 'disabled'; }

        $opciones = '';
  
        $opciones .= '<b>PRIVILEGIOS DEL USUARIO : ' . $result_q[0] . '</b> <br> Filtrar Privilegio: <input type="text" id="privb1" onkeypress="filtrar_priv1_key(event)">  <button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="filtrar_priv1()" style="height: 20px" ></button><br><table id="privs1" class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th >PRIVILEGIO</th><th><img src="images/leer.png"  width="15" height="15" title="Leer"></th><th><img src="images/escribir2.png"  width="15" height="15" title="Escribir"></th><th><img src="images/borrar.png"  width="15" height="15" title="Borrar"></th><th><img src="images/print.png"  width="15" height="15" title="Imprimir"></th><th><img src="images/cortesia.png"  width="15" height="15" title="Cortesia"></th><th><img src="images/pre.png"  width="15" height="15" title="Pre-Cuenta"></th><th><img src="images/sep.png"  width="15" height="15" title="Separar"></th><th>X</th></thead><tr>';
         



        foreach ($result_f as $row)
        {   
            $cbl = '<input type="checkbox" id="cbl'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbl(this.id)">';
            $cbe = '<input type="checkbox" id="cbe'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbe(this.id)">';
            $cbb = '<input type="checkbox" id="cbb'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbb(this.id)">';
            $cbp = '<input type="checkbox" id="cbp'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbp(this.id)">';
            $cbc = '<input type="checkbox" id="cbc'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbc(this.id)">';
            $cbpre = '<input type="checkbox" id="cbpre'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbpre(this.id)">';
            $cbsep = '<input type="checkbox" id="cbsep'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbsep(this.id)">';

            if ($row['VER'] == 1)
            {
                $cbl =  '<input type="checkbox" id="cbl'. $row['PRIV_ID'] . '" value ="'. $usuariob  . '" onClick="modpermisocbl(this.id)" checked>';
            }
            if ($row['MODIFICAR'] == 1)
            {
                $cbe = '<input type="checkbox" id="cbe'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"  onClick="modpermisocbe(this.id)" checked>';
            }
            if ($row['BORRAR'] == 1)
            {
                $cbb = '<input type="checkbox" id="cbb'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"   onClick="modpermisocbb(this.id)" checked>';
            }
            if ($row['IMPRIMIR'] == 1)
            {
                $cbp = '<input type="checkbox" id="cbp'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"   onClick="modpermisocbp(this.id)" checked>';
            }
            if ($row['CORTESIA'] == 1)
            {
                $cbc = '<input type="checkbox" id="cbc'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"   onClick="modpermisocbc(this.id)" checked>';
            }
            if ($row['PRECUENTA'] == 1)
            {
                $cbpre = '<input type="checkbox" id="cbpre'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"   onClick="modpermisocbpre(this.id)" checked>';
            }
            if ($row['SEPARAR'] == 1)
            {
                $cbsep = '<input type="checkbox" id="cbsep'. $row['PRIV_ID'] . '"  value ="'. $usuariob  . '"   onClick="modpermisocbsep(this.id)" checked>';
            }


        $butborrar = '<button value="'. $usuariob . '" id="qp'. $row['PRIV_ID'] . '"class="bg-secondary" '. $flagmod2 . ' OnClick="quitar_privop(this.id)">>></button>';
       // $opciones .= '<tr><td><b>' . $row['GRUPO_NOMBRE'] . ' </b></td><td>' . $row['PRIVILEGIO'] . '</td><td>'. $cbl . ' </td><td>'. $cbe . ' </td><td>'. $cbb . ' </td><td>'. $butborrar . '</td></tr>';
       $opciones .= '<tr><td>' . $row['PRIVILEGIO'] . '</td><td>'. $cbl . ' </td><td>'. $cbe . ' </td><td>'. $cbb . ' </td><td>'. $cbp . '</td><td>'. $cbc . '</td><td>'. $cbpre . '</td><td>'. $cbsep . '</td><td>'. $butborrar . '</td></tr>';    
    }

        $opciones .= '</table>';
 
        $retorno= '';

             /// aqui de un solo los privilegios filtrados
  
             $result_g = $info->get_privilegios_filtrados($usuariob); 
          
             $retorno = '';
     
             $retorno .= '<table id="privs2" class="table table-bordered table-light table-hover"><thead style="position: sticky; top:0;" class="table-primary"><tr><th width="100px">DISPONIBLES <br> Filtrar Privilegio: <input type="text" id="privb2" onkeypress="filtrar_priv2_key(event)">  <button type="button" class="btn btn-dark btn-sq-responsive bg-info" onClick="filtrar_priv2()" style="height: 20px" ></button></th></thead><tr> ' ;
     
     
             foreach ($result_g as $row)
             {   
               $butborrar = '<button value="'. $usuariob  . '" id="ap'. $row['PRIV_ID'] . '"class="bg-success" '. $flagmod2 . ' OnClick="agregar_privop(this.id)"><<</button>';
               $retorno .= '<tr><td style="text-align:left"> '. $butborrar. ' &nbsp&nbsp<input type="textbox"  style="text-align:center" value="' . $row['PRIVILEGIO'] . '"  id="opid'. $row['PRIV_ID'] . '" disabled hidden/>' . $row['PRIVILEGIO'] . ' </td><tr>';
             }
     
            $retorno .= '</table>';



        $datost = [];
  
        $datost[0] = $opciones;
        $datost[1] = $retorno;
    }
    else
    {
        $datost = [];

        $datost[0] = '';
        $datost[1] = '';

    }


        echo json_encode($datost);


    }

    if ($estado == 'redraw_ingredientes') 
    {
        $info = new crud();

        $ingredientes = '';

        $ingredientes = generar_listado_ingredientes();

        $result = '';

        $result .= '<span class="close">&times;</span>
    <b><label>LISTADO DE INGREDIENTES :</label></b><br>
     ' . $ingredientes . ' ';

        echo $result;
  
    }  

    if ($estado == 'redraw_proveedores') 
    {
        $info = new crud();

        $proveedores = '';

        $proveedores = generar_listado_proveedores();

        $result = '';

        $result .= '<span class="close">&times;</span>
    <b><label>LISTADO DE PROVEEDORES :</label></b><br>
     ' . $proveedores . ' ';

        echo $result;
  
    }   


  
    if ($estado == 'redraw_clientes') 
    {
        $info = new crud();

        $clientes = '';

        $clientes = generar_listado_clientes();

        $result = '';

        $result .= '<span class="close">&times;</span>
    <b><label>LISTADO DE CLIENTES :</label></b><br>
     ' . $clientes . ' ';

        echo $result;
  
    }  

      
    if ($estado == 'redraw_clientes_comanda') 
    {
        $info = new crud();

        $clientes = '';

        $clientes = generar_listado_clientes_comanda();

        $result = '';

        $result .= '<b><label>LISTADO DE CLIENTES :</label></b><br>
     ' . $clientes . ' ';

        echo $result;
  
    }  
    
    if ($estado == 'redraw_productos') 
    {
        $info = new crud();

        $prods = '';

        $prods = get_productos();

        $result = '';

        $result .= '<span class="close">&times;</span>
    <b><label>LISTADO DE PRODUCTOS :</label></b><br>
     ' . $prods . ' ';

        echo $result;
  
    }   

    if ($estado == 'redraw_mesas') 
    {
        $info = new crud();

        $result = '';

       ///se tiene que saber de nuevo si puede escribir o no el usuario

        $privilegios = $info->get_privilegios($usuario, 10);
   
       foreach ($privilegios as $row)
       {   
        $mod = $row['MODIFICAR'];
       }
   
       $flagmod = '';
       $flagborrar = '';
   
       if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }

        $result = generar_distribucion_mesas($flagmod);

        echo $result;
  
    }   

    if ($estado == 'tab_proveedores') 
    {
        $ver = '';

        $info = new crud();
  
        $result_f = $info->buscar_departamentos();

        $vardept = '';

        $vardept.= '<select  id="dpprov" onChange="buscar_municipio()"><option value=""></option>';
        foreach ($result_f as $row)
        {   
        $vardept .=  '<option value="'. $row['DEPARTAMENTO'] . '">'. $row['DEPARTAMENTO'] . '</option>';
        }
        $vardept .= '</select>';

        $privilegios = $info->get_privilegios($usuario, 8);

        foreach ($privilegios as $row)
        {   
         $ver = $row['VER']; 
         $mod = $row['MODIFICAR'];
         $borrar = $row['BORRAR'];
        }
 
        $flagmod = '';
        $flagborrar = '';

        if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
        if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

    if ($ver == 1)
    {

      $proveedores = '';

      $proveedores = generar_listado_proveedores();

      $retorno = '<form style="padding: 8px;border-radius: 6px;border: 1px solid black;">
      <label for="cprov">Codigo del Proveedor :</label><br>
      <input type="text" id="cpprov" Value="P -" disabled style="width:30px;"><input type="text" id="cprov" placeholder="Cod" disabled style="width:100px;">
      <label for="eprov">Estado :</label>  <select id="esprov" onChange="bgestadocolor()"><option value="Activo" style="background-color:green">Activo</option><option value="Inactivo" style="background-color:red">Inactivo</option></select> <input  type="button"  class="bg-info" id="buscarproveedores" style="background:url(images/search.png) no-repeat;background-size: 25px 25px;height:30px;width:30px;" ><br>
      <label for="nprov" >Nombre del Proveedor :</label><br>
      <input type="text" id="nprov"  placeholder="Nombre" style="width:300px;" onfocusout="seleccionar_prov_nombre()"><br>
      <label for="tprov">Telefono :</label><br> 
      <input type="numeric" id="tprov" placeholder="55555555" maxlength="8" /><br>
      <label for="celprov">Celular :</label><br>
      <input type="numeric" id="celprov" placeholder="55555555" maxlength="8"/><br>
      <label for="cprov">Correo Electronico :</label><br>
      <input type="email" id="eprov" placeholder="nombre@proveedor.com.sv"  pattern=".+@"/><br>
      <label for="dprov">Direccion :</label><br>
      <textarea rows="3" cols="30" id="dprov"  placeholder="Ingrese una Direccion..."></textarea> <br>
      <label for="dpprov">Depto. :</label> &nbsp &nbsp' . $vardept . '
      <label for="mprov">Municipio :</label> &nbsp &nbsp <span id="municipiospan"><select  id="mprov"><option value=""></option></select></span> 
      <label for="pprov">Pais :</label> &nbsp &nbsp <select  id="pprov"><option value="El Salvador">El Salvador</option></select><br>
      <label for="dprov">Personas de Contacto :</label><br>
      <textarea rows="3" cols="30" id="ctprov"  placeholder="Ingrese nombres de contacto..."></textarea> <br>
      <label for="iprov">Registro de IVA :</label>
      <input type="text" id="iprov" placeholder="555555-5" maxlength="7"/>
      <label for="nitprov"> N.I.T. :</label>
      <input type="text" id="nitprov" placeholder="5555-555555-555-5" maxlength="14"/><br><br>
      <label for="gprov">Giro :</label> &nbsp &nbsp <select  id="gprov"><option value="Comercial">Comercial</option></select>&nbsp &nbsp<label for="clprov">Clas. DGII :</label> &nbsp &nbsp <select  id="clprov"><option value="Pequeno">Pequeno</option></select>
      <br><br>
      <input  type="button" value="Guardar/Modificar" class="bg-success" ' . $flagmod . ' onClick="guardarmod_proveedor()"> &nbsp&nbsp  <input  type="button" value="Nuevo" class="bg-primary" onClick="nuevo_proveedor()"> &nbsp&nbsp <input  type="button" value="X" class="bg-danger" id="borrarproveedores" onClick="borrar_proveedor()" ' . $flagborrar . '>
    </form><br><br>
    
    <div id="myModalproveedores" style="display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%;
    overflow: auto; /* Enable scroll if needed */
    background-color: gray; /* Fallback color */" > <span class="close">&times;</span>
    <b><label>LISTADO DE PROVEEDORES :</label></b><br>
     ' . $proveedores . ' </div>
       
    ';
    
    echo $retorno;

    }
      
      $retorno = '';

      echo $retorno;

    }


    if ($estado == 'get_municipio') 
    {
        $departamento = $_POST['departamento'];

        $info = new crud();
  
        $result_f = $info->buscar_municipios($departamento);

        $vardept = '';

        $vardept.= '<select  id="mprov" ><option value=""></option>';
        foreach ($result_f as $row)
        {   
        $vardept .=  '<option value="'. $row['MUNICIPIO'] . '">'. $row['MUNICIPIO'] . '</option>';
        }
        $vardept .= '</select>';

        echo $vardept;
      
    }

   //para modal
    function generar_listado_proveedores()
    {

        $info = new crud();

        $result_g = $info->listado_proveedores(); 
          
        $proveedores = '';

        $proveedores .= '<div style="text-align:left">BUSCAR PROVEEDOR :  <input type="text" id="fprov" onkeypress="filtrar_proveedor_key(event)"/> <input  type="button" value="buscar" class="bg-success" onClick="filtrar_proveedor()"  > </div>';

        $proveedores .= '<table id="listprov" class="table table-bordered table-light table-hover" style="font-size:16px;"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>COD_PROVEEDOR</th><th>ESTADO</th><th>NOMBRE</th><th>TELEFONO</th><th>CELULAR</th><th>CORREO</th><th>DIRECCION</th><th>DEPARTAMENTO</th><th>MUNICIPIO</th><th>PAIS</th><th>CONTACTOS</th><th>REG. IVA</th><th>NIT</th><th>GIRO</th><th>CLASIFICACION DGII</th></thead><tr> ' ;


        foreach ($result_g as $row)
        {   
          $proveedores .= '<tr onClick="seleccionar_prov('. $row['PROVEEDOR_ID'] . ')" ><td><b><h8>P-'. $row['PROVEEDOR_ID'] . '</b></h8></td><td>'. $row['ESTADO'] . '</td><td>'. $row['NOMBRE'] . '</td><td>'. $row['TELEFONO'] . '</td><td>'. $row['CELULAR'] . '</td><td>'. $row['CORREO'] . '</td><td>'. $row['DIRECCION'] . '</td><td>'. $row['DEPARTAMENTO'] . '</td><td>'. $row['MUNICIPIO'] . '</td><td>'. $row['PAIS'] . '</td><td>'. $row['CONTACTOS'] . '</td><td>'. $row['REG_IVA'] . '</td><td>'. $row['NIT'] . '</td><td>'. $row['GIRO'] . '</td><td>'. $row['CLASIFICACION_DGII'] . '</td><tr>';
        }

        $proveedores .= '</table>';

        return $proveedores;
        
    }


     if ($estado == 'tab_clientes') 
    {
        $ver = '';

        $info = new crud();
  
        
        $privilegios = $info->get_privilegios($usuario, 9);

        foreach ($privilegios as $row)
        {   
         $ver = $row['VER']; 
         $mod = $row['MODIFICAR'];
         $borrar = $row['BORRAR'];
        }
 
        $flagmod = '';
        $flagborrar = '';

        if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
        if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

    if ($ver == 1)
    {

      $clientes = '';

      $clientes = generar_listado_clientes();

      $retorno = '<form style="padding: 8px;border-radius: 6px;border: 1px solid black;">
      <label for="cprov">Codigo del Cliente :</label><br>
      <input type="text" id="cpprov" Value="C -" disabled style="width:30px;"><input type="text" id="ccliente" placeholder="Cod" disabled style="width:100px;">
      <label for="escliente">Estado :</label>  <select id="escliente" onChange="bgestadocolorc()"><option value="Activo" style="background-color:green">Activo</option><option value="Inactivo" style="background-color:red">Inactivo</option></select>
       <input  type="button"  class="bg-info" id="buscarclientes" style="background:url(images/search.png) no-repeat;background-size: 25px 25px;height:30px;width:30px;" ><br>
      <label for="ncliente">Nombres :</label><br>
      <input type="text" id="ncliente"  placeholder="Nombres" style="width:300px;"><br>
      <label for="acliente">Apellidos :</label><br>
      <input type="text" id="acliente"  placeholder="Apellidos" style="width:300px;"><br>
      <label for="ecliente">Empresa :</label><br>
      <input type="text" id="ecliente"  placeholder="Empresa si tiene" style="width:300px;"><br>
      <label for="tcliente">Telefono :</label><br> 
      <input type="numeric" id="tcliente" placeholder="55555555" maxlength="8" /><br>
      <label for="corcliente">Correo Electronico :</label><br>
      <input type="email" id="corcliente" placeholder="nombre@xxxx.com.sv" /><br>
      <label for="dcliente">DUI :</label><br>
      <input type="text" id="dcliente" placeholder="XXXXXXXX-X" maxlength="9"/><br>
      <label for="fclientec">Fecha de Cumpleaños :</label><br>
      <input type="date" id="fclientec" min="2018-01-01"><br>
      <label for="fcliented">Fecha Conmemorativa :</label><br>
      <input type="date" id="fcliented" min="2018-01-01"><br>
      <label for="notcliente">Notas :</label><br>
      <textarea rows="3" cols="30" id="notcliente"  placeholder="Notas..."></textarea> <br>
      <br><br>
      <input  type="button" value="Guardar/Modificar" class="bg-success" ' . $flagmod . ' onClick="guardarmod_cliente()"> &nbsp&nbsp  <input  type="button" value="Nuevo" class="bg-primary" onClick="nuevo_cliente()"> &nbsp&nbsp <input  type="button" value="X" class="bg-danger" id="borrarclientes" onClick="borrar_cliente()" ' . $flagborrar . '>
    </form><br><br>
    
    <div id="myModalclientes" style="display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%;
    overflow: auto; /* Enable scroll if needed */
    background-color: gray; /* Fallback color */" > <span class="close">&times;</span>
    <b><label>LISTADO DE CLIENTES :</label></b><br>
     ' . $clientes . ' </div>
       
    ';
    
    echo $retorno;

    }
      
      $retorno = '';

      echo $retorno;

    }

    if ($estado == 'tab_clientes_comanda') 
    {
        $ver = '';
        $mod = '';
        $borrar = '';

        $info = new crud();
  
        
        $privilegios = $info->get_privilegios($usuario, 9);

        foreach ($privilegios as $row)
        {   
         $ver = $row['VER']; 
         $mod = $row['MODIFICAR'];
         $borrar = $row['BORRAR'];
        }
 
        $flagmod = '';
        $flagborrar = '';

        if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
        if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

    if ($ver == 1)
    {

      $clientes = '';

      $clientes = generar_listado_clientes_comanda();

      $retorno = '<div style="height:270px;width:600px;overflow:auto;box-sizing: border-box;padding: 10px;border: 3px double black;">
      <button onClick="esconder_clientescomanda()" style="float: right;"> CERRAR </button>
      <br>
       <input type="text" id="cpprov" Value="C -" disabled style="width:30px;"><input type="text" id="ccliente" placeholder="Cod" disabled style="width:100px;">
      <label for="escliente">Estado :</label>  <select id="escliente" onChange="bgestadocolorc()"><option value="Activo" style="background-color:green">Activo</option><option value="Inactivo" style="background-color:red">Inactivo</option></select><br>
      <label for="ncliente">Nombres :</label><input type="text" id="ncliente"  placeholder="Nombres" style="display: inline-block;margin-bottom: 10px;width:100px;">
      <label for="acliente">Apellidos :</label><input type="text" id="acliente"  placeholder="Apellidos" style="display: inline-block;margin-bottom: 10px;width:100px;"><br>
      <label for="ecliente">Empresa :</label><input type="text" id="ecliente"  placeholder="Empresa si tiene" style="display: inline-block;margin-bottom: 10px;width:100px;">
      <label for="tcliente">Telefono :</label><input type="numeric" id="tcliente" placeholder="55555555" maxlength="8" style="display: inline-block;margin-bottom: 10px;width:100px;"/><br>
      <label for="corcliente">Correo Electronico :</label><input type="email" id="corcliente" placeholder="nombre@xxxx.com.sv" style="display: inline-block;margin-bottom: 10px;width:200px;"/>
      <label for="dcliente">DUI :</label><input type="text" id="dcliente" placeholder="XXXXXXXX-X" maxlength="9" style="display: inline-block;margin-bottom: 10px;width:100px;"/><br>
      <label for="fclientec">Fecha de Cumpleaños :</label><input type="date" id="fclientec" min="2018-01-01" style="display: inline-block;margin-bottom: 10px;">
      <label for="fcliented">Fecha Conmemorativa :</label><input type="date" id="fcliented" min="2018-01-01" style="display: inline-block;margin-bottom: 10px;"><br>
      <textarea rows="3" cols="30" id="notcliente"  placeholder="Notas..."></textarea> <br>
      <input  type="button" value="Guardar/Modificar" class="bg-success" ' . $flagmod . ' onClick="guardarmod_cliente()"> &nbsp&nbsp  <input  type="button" value="Nuevo" class="bg-primary" onClick="nuevo_cliente()"> &nbsp&nbsp <input  type="button" value="X" class="bg-danger" id="borrarclientes" onClick="borrar_cliente()" ' . $flagborrar . '>&nbsp doble click en el cliente en la tabla de abajo para seleccionarlo!
    </div>
    
    <div id="myModalclientes" style="height:310px;width:600px;overflow:auto;box-sizing: border-box;padding: 10px;border: 3px double black;"> 
    <b><label>LISTADO DE CLIENTES :</label></b><br>
     ' . $clientes . ' </div>
     
    ';
    
    echo $retorno;

    }
      
      $retorno = '';

      echo $retorno;

    }

   
   //para modal
   function generar_listado_clientes()
   {

       $info = new crud();

       $result_g = $info->listado_clientes(); 
         
       $clientes = '';

       $clientes .= '<div style="text-align:left"> BUSCAR DUI : <input type="text" id="fcliente" onkeypress="filtrar_clientes_key(event)" MaxLength="9"/> <input  type="button" value="buscar" class="bg-success" onClick="filtrar_cliente()"  > </div>';

       $clientes.= '<table id="listclientes" class="table table-bordered table-light table-hover" style="font-size:16px;"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>COD_CLIENTE</th><th>ESTADO</th><th>NOMBRES</th><th>APELLIDOS</th><th>EMPRESA</th><th>DUI</th><th>CORREO</th><th>TELEFONO</th><th>FECHA CUMPLEAÑOS</th><th>FECHA CONMEMORATIVA</th><th>NOTAS</th></thead><tr> ' ;


       foreach ($result_g as $row)
       {   
        $clientes .= '<tr onClick="seleccionar_cliente('. $row['CLIENTE_ID'] . ')" ><td><b><h8>C-'. $row['CLIENTE_ID'] . '</b></h8></td><td>'. $row['ESTADO'] . '</td><td>'. $row['NOMBRES'] . '</td><td>'. $row['APELLIDOS'] . '</td><td>'. $row['EMPRESA'] . '</td><td>'. $row['DUI'] . '</td><td>'. $row['CORREO'] . '</td><td>'. $row['TELEFONO'] . '</td><td>'. $row['FECHA_CUMPLEANOS'] . '</td><td>'. $row['FECHA_CONMEMORATIVA'] . '</td><td>'. $row['NOTAS'] . '</td><tr>';
       }

       $clientes .= '</table>';

       return $clientes;
       
   }

   function generar_listado_clientes_comanda()
   {

       $info = new crud();

       $result_g = $info->listado_clientes(); 
         
       $clientes = '';

       $clientes .= '<div style="text-align:left"> BUSCAR DUI : <input type="text" id="fcliente" onkeypress="filtrar_clientes_key(event)" MaxLength="9"/> <input  type="button" value="buscar" class="bg-success" onClick="filtrar_cliente()"  > </div>';

       $clientes.= '<table id="listclientes" class="table table-bordered table-light table-hover" style="font-size:10px;"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>COD_CLIENTE</th><th>ESTADO</th><th>NOMBRES</th><th>APELLIDOS</th><th>EMPRESA</th><th>DUI</th><th>CORREO</th><th>TELEFONO</th><th>FECHA CUMPLEAÑOS</th><th>FECHA CONMEMORATIVA</th><th>NOTAS</th></thead><tr> ' ;


       foreach ($result_g as $row)
       {   
        $clientes .= '<tr onClick="seleccionar_cliente('. $row['CLIENTE_ID'] . ')" ondblclick="seleccionar_cliente_comanda('. $row['CLIENTE_ID'] . ')"><td><b><h8>C-'. $row['CLIENTE_ID'] . '</b></h8></td><td>'. $row['ESTADO'] . '</td><td>'. $row['NOMBRES'] . '</td><td>'. $row['APELLIDOS'] . '</td><td>'. $row['EMPRESA'] . '</td><td>'. $row['DUI'] . '</td><td>'. $row['CORREO'] . '</td><td>'. $row['TELEFONO'] . '</td><td>'. $row['FECHA_CUMPLEANOS'] . '</td><td>'. $row['FECHA_CONMEMORATIVA'] . '</td><td>'. $row['NOTAS'] . '</td><tr>';
       }

       $clientes .= '</table>';

       return $clientes;
       
   }


   if ($estado == 'tab_mesas') 
   {
    $ver = '';
    $mod = '';
    $borrar = '';

    $info = new crud();

    $privilegios = $info->get_privilegios($usuario, 10);

    foreach ($privilegios as $row)
    {   
     $ver = $row['VER']; 
     $mod = $row['MODIFICAR'];
     $borrar = $row['BORRAR'];
    }

    $flagmod = '';
    $flagborrar = '';

    if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
    if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

        if ($ver == 1)
        {

            $mesas = '';

            $mesas = generar_distribucion_mesas($flagmod);

            $result_g = $info->global_mesas(); 

            $info = new crud();

            $cmesas = '';
            $czonas = '';
    
            foreach ($result_g as $row)
            {   
             $cmesas = $row['MESAS']; 
             $czonas = $row['ZONAS']; 
            }


            //// zonas para mapa
            $mapzona = '';

            $mapzona =  generar_mapa_zonas();;
                 
            $retorno = '<form style="padding: 8px;border-radius: 6px;border: 1px solid black;">
            <h5> CANTIDAD DE ZONAS Y MESAS EXISTENTES  </h5>
             <label for="nzonas">Cantidad de Zonas :</label><br>
            <input type="number" id="nzonas"  style="width:70px;" value='. $czonas . ' > <input  type="button" value="Guardar" class="bg-success" ' . $flagmod . ' onClick="guardar_cantzonas()"><br>
            <label for="nmesas">Cantidad de Mesas :</label><br>
            <input type="number" id="nmesas"  style="width:70px;" value='. $cmesas . '> <input  type="button" value="Guardar" class="bg-success" ' . $flagmod . ' onClick="guardar_cantmesas()"><br><br>
            <p>
            Nota: Si disminuye el valor de Zonas, se borraran las zonas ya existentes con sus respectivas mesas. <br>
            Si disminuye el valor de mesas se eliminaran las mesas existentes tambien y de su zona si ya fue asignada
            </p>
            </form><br>
          
            <form style="padding: 8px;border-radius: 6px;border: 1px solid black;overflow:auto;height:800px"">
            <h5> DISTRIBUCION DE ZONAS-MESAS </h5>
            <div id="Espere" style="color:lightgreen;background-color:black;display:none"><b>Procesando...</b> </div>
            <label for="szona">Zona Seleccionada : </label><input type="number" id="szonas"  style="width:70px;" disabled> 
            <div id="distmesas" style="display: flex;margin-left:-5px; margin-right:-5px;">
            ' . $mesas . '
            </div>
             </form><br>


               <form style="padding: 8px;border-radius: 6px;border: 1px solid black;overflow:auto;height:400px"">
               <h5> UBICACION DE ZONAS EN EL MAPA </h5>
              <div style="display:flex;">
              <div id="mapzon" style="height:200px;width:100px;border-radius: 6px;border: 1px solid black;background-color:lightgreen">
              ' . $mapzona . '
              </div> &nbsp
              <div id="distzonas1" onclick="checkdistzona(this.id)" style="flex:1;border-radius: 6px;border: 1px solid black;background-color:white">
              AREA 1 : <br>
             </div> &nbsp &nbsp
             <div id="distzonas2" onclick="checkdistzona(this.id)" style="flex:1;border-radius: 6px;border: 1px solid black;background-color:white">
             AREA 2 : <br>
             </div> &nbsp &nbsp 
               <div id="distzonas3" onclick="checkdistzona(this.id)" style="flex:0.5;border-radius: 6px;border: 1px solid black;background-color:white">
               AREA 3 : <br>
               </div>
               </div>
               <br>
               <div style="display:flex;">
               <div id="mapzon" style="height:200px;width:100px;border-radius: 6px;border: 1px solid black;visibility: hidden;">
               ' . $mapzona . '
               </div> &nbsp &nbsp
               <div id="distzonas4" onclick="checkdistzona(this.id)" style="flex:1;border-radius: 6px;border: 1px solid black;background-color:white">
               AREA 4 : <br>
               </div> &nbsp &nbsp
               <div id="" style="flex:0.5;border-radius: 6px;border: 1px solid black;visibility: hidden;"">
               </div>
                <div id="" style="flex:1;border-radius: 6px;border: 1px solid black;visibility: hidden;"">
                </div> &nbsp &nbsp 
                </div>



               
                  </form>
                  <script>
                 // dragula([
                   // document.getElementById("distzonas1"),
                   // document.getElementById("distzonas2"),
                   // document.getElementById("distzonas3"),
                   // document.getElementById("distzonas4"),
                   // document.getElementById("mapzon")
                 // ]);
      
                    </script>
               
               <br>
          ';
          
          echo $retorno;

        }

    
   }
   
        function  generar_mapa_zonas()
        {

            $zonas = '';

            $info = new crud();

            $result_g = $info->generar_zonas(); 

            // $zonas.= '<table id="zonamap" class="table table-bordered table-light table-hover" ><tr>';
        
            // $zonas .= '<th class="bg-info">ZONA</th>';
           
            // $zonas .= '<body>';
                
            // foreach ($result_g as $row)
            // {   
            //     $zonas .= '<tr><td><button type="button"  id="MQZ' . $row['ZONA'] . '">ZONA # ' . $row['ZONA'] .' </button></td></tr>';
            // }
    
            // $zonas.= '</table>';

        
            $zonas.= '<b> ZONAS : </b>';  
               
            foreach ($result_g as $row)
            {   
                $zonas .= '<button type="button"  id="MQZ' . $row['ZONA'] . '" onclick="moverazona(this.id)">ZONA # ' . $row['ZONA'] .' </button><br>';
            }
    

            return $zonas;

        }


         //para modal
      function  generar_distribucion_mesas($flagmod)
      {
        $mesas = '';

        $info = new crud();

        $result_g = $info->global_mesas(); 

        $cmesas = '';
        $czonas = '';
        $disablediv = '';
 

        foreach ($result_g as $row)
        {   
         $cmesas = $row['MESAS']; 
         $czonas = $row['ZONAS']; 
        }

        if ($flagmod == 'disabled') 
        {
          $disablediv = 'pointer-events:none;';
        }


        for ($i = 1; $i <= $czonas; $i++) 
        {
                   
        $mesas .= '<div style="flex: 50%;padding: 5px;' . $disablediv . '"> <table id="zona' . $i . '" class="table table-bordered table-light table-hover" ><tr>';
        
        $mesas .= '<th class="bg-info" id="Z' . $i . '" onClick="seleccionar_zona(this.id);"  >ZONA  ' . $i . '</th>';

        $result_mesas = $info->listado_mesas($i);  //buscar mesas de la zona y agregarlas  a la fila

        $mesas .= '</thead><tr>'; 
        $mesas .= '<body>';

        foreach ($result_mesas as $row)
        {   
         $mesas .= '<tr><td id="MQ' . $row['MESA'] . '" onClick="quitarmesa_azona(this.id);"> ' . $row['MESA'] .'  </td></tr>';
        }

        $mesas .= '</body>';

        $mesas .= '</table></div>';
        }

        
        $mesas .= '<div style="flex: 50%;padding: 5px;' . $disablediv . '"> <table id="listclientes" class="table table-bordered table-light table-hover" ><tr>';
        
        $mesas .= '<th class="bg-success">DISPONIBLES</th>';

        $mesas .= '</thead><tr>'; 
        $mesas .= '<body>';


        for ($i = 1; $i <= $cmesas; $i++) 
        {
         $result_existe = $info->existe_mesa($i);  
         if ($result_existe[0] == 0)
         {
         $mesas .= '<tr><td id="M' . $i . '" onClick="agregarmesa_azona(this.id);"   ' . $flagmod . '> ' . $i .'  </td></tr>';
         }
        }

        $mesas .= '</body>';

        $mesas .= '</table></div> ';

        return $mesas;

      }

         //para modal
   function get_productos()
   {


       $info = new crud();

       $result_g = $info->listado_productos(); 
         
       $prods = '';

       $prods .= '<div style="text-align:left"> BUSCAR PRODUCTO : <input type="text" id="fproducto" oninput="filtrar_producto()" MaxLength="9"/> <input  type="button" value="buscar" class="bg-success" onClick="filtrar_producto()"  > </div>';

       $prods .= '<table id="listproductos" class="table table-bordered table-light table-hover" style="font-size:16px;"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>COD_PRODUCTO</th><th>ESTADO</th><th>PRODUCTO</th><th>PRECIO FINAL</th><th>PRECIO SUGERIDO</th><th>CATEGORIA</th><th>MENU</th><th>DESCRIPCION</th><th>CREADO</th><th>DESDE</th><th>HASTA</th><th>L</th><th>M</th><th>MI</th><th>J</th><th>V</th><th>S</th><th>D</th></thead><tr> ' ;


       foreach ($result_g as $row)
       {   
        $lunes = '<td class="bg-secondary"></td>';
        $martes = '<td class="bg-secondary"></td>';
        $miercoles = '<td class="bg-secondary"></td>';
        $jueves = '<td class="bg-secondary"></td>';
        $viernes = '<td class="bg-secondary"></td>';
        $sabado = '<td class="bg-secondary"></td>';
        $domingo = '<td class="bg-secondary"></td>';
        
        if ($row['lunes']  == 'true'){$lunes = '<td class="bg-success"> X </td>';}
        if ($row['martes']  == 'true'){$martes = '<td class="bg-success"> X </td>';}
        if ($row['miercoles']  == 'true'){$miercoles = '<td class="bg-success"> X </td>';}
        if ($row['jueves']  == 'true'){$jueves = '<td class="bg-success"> X </td>';}
        if ($row['viernes']  == 'true'){$viernes = '<td class="bg-success"> X </td>';}
        if ($row['sabado']  == 'true'){$sabado = '<td class="bg-success"> X </td>';}
        if ($row['domingo']  == 'true'){$domingo = '<td class="bg-success"> X </td>';}


        $prods .= '<tr onClick="seleccionar_prod('. $row['producto_id'] . ')" ><td><b><h8>PR-'. $row['producto_id'] . '</b></h8></td><td>'. $row['estado'] . '</td><td>'. $row['nombre_prod'] . '</td><td>$'. $row['precio_final'] . '</td><td>$'. $row['precio_sugerido'] . '</td><td>'. $row['categoria'] . '</td><td>'. $row['menu'] . '</td><td>'. $row['descripcion'] . '</td><td>'. $row['CREADO'] . '</td><td>'. $row['FechaI'] . '</td><td>'. $row['FechaF'] . '</td>'. $lunes . $martes . $miercoles . $jueves . $viernes . $sabado . $domingo . '<tr>';
       }

       $prods .= '</table>';

       return $prods;
       
   }

   if ($estado == 'regenerar_ingredientesasignar') 
   {
                $ingredientesasignar = $_POST['ingredientesasignar'];
                $selecting = '';
                $ver = '';
                $mod = '';
                $borrar = '';
                $info = new crud();

                $privilegios = $info->get_privilegios($usuario, 11);
   
                foreach ($privilegios as $row)
                {   
                 $ver = $row['VER']; 
                 $mod = $row['MODIFICAR'];
                 $borrar = $row['BORRAR'];
                }
            
                $flagmod = '';
                $flagborrar = '';
            
                if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
                if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

                /////////////////////////////
                if ($ingredientesasignar != '')
                {
                foreach ($ingredientesasignar  as $a) {
                    $selecting .= "'" . $a . "'";
                    $selecting .= ",";
                }
                

                $selecting  = substr_replace($selecting ,"",-1);
                }
                else
                {
                    $selecting = '';
                }
                
                $result_h = $info->grid_ingredientesv2($selecting);   
                // retorno de ingredientes
                $retornol = '';

                  
                $retornol .= 'INGREDIENTES DISPONIBLES : <br><table class="table table-bordered table-light table-hover" id="fingredientestable"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>INGREDIENTE</th><th>CANTIDAD</th><th>COSTO</th><th>UNIDAD</th><th>+</th></thead><tr>'; 
    
                $funcion = 'agregar_ingrediente(this.id)';
    
                if ($flagmod == 'disabled')
                {
                    $funcion = '';
                }
    
                foreach ($result_h as $row)
                {   
                    $retornol .= '<tr id="fingre'. $row['INGREDIENTE_ID'] . '" ><td id="ningre'. $row['INGREDIENTE_ID'] . '">'. $row['INGREDIENTE'] . '</td><td><input type="number" id="cingre'. $row['INGREDIENTE_ID'] . '" placeholder="Cant."  style="width:100px;"></td><td>$ <input style="width:50px;" type="number" id="dingre'. $row['INGREDIENTE_ID'] . '" value="'. $row['COSTO'] . '" readonly /></td><td id="uingre'. $row['INGREDIENTE_ID'] . '">'. $row['UNIDAD'] . '</td><td class="bg-success" id="ingre'. $row['INGREDIENTE_ID'] . '" onClick="' .$funcion  . '">+</td></tr>';
                }
    
                $retornol .= '</table>' ;

                echo $retornol;
    

   }

   if ($estado == 'regenerar_productosasignar') 
   {
                $productosasignar = $_POST['productosasignar'];
                $selecting = '';
                $ver = '';
                $mod = '';
                $borrar = '';
                $info = new crud();

                $privilegios = $info->get_privilegios($usuario, 11);
   
                foreach ($privilegios as $row)
                {   
                 $ver = $row['VER']; 
                 $mod = $row['MODIFICAR'];
                 $borrar = $row['BORRAR'];
                }
            
                $flagmod = '';
                $flagborrar = '';
            
                if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
                if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

                /////////////////////////////
                if ($productosasignar != '')
                {
                foreach ($productosasignar  as $a) {
                    $selecting .= "'" . $a . "'";
                    $selecting .= ",";
                }
                

                $selecting  = substr_replace($selecting ,"",-1);
                }
                else
                {
                    $selecting = '';
                }
                
                $result_i = $info->grid_productosv2($selecting); 

                $retornop = '';
    
                $retornop .= 'PRODUCTOS DISPONIBLES : <br><table class="table table-bordered table-light table-hover" id="fproductostable"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>NOMBRE</th><th>CATEGORIA</th><th>CANTIDAD</th><th>PRECIO</th><th>DESCRIPCION</th><th>IMAGEN</th><th>+</th></thead><tr>'; 
    
                $funcion2 = 'agregar_producto(this.id)';
    
                if ($flagmod == 'disabled')
                {
                    $funcion2 = '';
                }
    
                foreach ($result_i as $row)
                {   
                    $retornop .= '<tr id="nprod'. $row['PRODUCTO_ID'] . '" ><td id="npprod'. $row['PRODUCTO_ID'] . '">'. $row['NOMBRE_PROD'] . '</td><td id="catprod'. $row['PRODUCTO_ID'] . '">'. $row['CATEGORIA'] . ' </td><td><input type="number" step="1" pattern="\d*"  onblur="this.value = Math.ceil(parseFloat(this.value));" id="cantprod'. $row['PRODUCTO_ID'] . '" placeholder="Cant."  style="width:50px;"></td><td id="precioprod'. $row['PRODUCTO_ID'] . '">'. $row['PRECIO_FINAL'] . ' </td><td id="descprod'. $row['PRODUCTO_ID'] . '">'. $row['DESCRIPCION'] . ' </td><td id="urlprod'. $row['PRODUCTO_ID'] . '">  <img src="images/productos/'. $row['URLIMG'] . '" style="width:25px;height:25px" title="'. $row['URLIMG'] . '"  ><input type="hidden" value="'. $row['URLIMG'] . '" id="url2prod'. $row['PRODUCTO_ID'] . '"></td><td class="bg-success" id="prod'. $row['PRODUCTO_ID'] . '" onClick="' .$funcion2  . '">+</td></tr>';
                }
    
                $retornop .= '</table>' ;

   
                echo $retornop;

     }


      if ($estado == 'tab_productos') 
      {
       $ver = '';
       $mod = '';
       $borrar = '';
   
       $info = new crud();

       $privilegios = $info->get_privilegios($usuario, 11);
   
       foreach ($privilegios as $row)
       {   
        $ver = $row['VER']; 
        $mod = $row['MODIFICAR'];
        $borrar = $row['BORRAR'];
       }
   
       $flagmod = '';
       $flagborrar = '';
   
       if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
       if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

       $result_f = $info->get_cat_prod();

       $tipoprod = '';

       $tipoprod .= '<select  id="catprod" ><option value=""></option>';
       foreach ($result_f as $row)
       {   
        $tipoprod  .=  '<option value="'. $row['NOMBRE'] . '">'. $row['NOMBRE'] . '</option>';
       }
       $tipoprod  .= '</select>';

       ///
       $result_g = $info->get_subcat_prod();

       $tipoprods = '';

       $tipoprods .= '<select  id="scatprod" ><option value=""></option>';
       foreach ($result_g as $row)
       {   
        $tipoprods  .=  '<option value="'. $row['NOMBRE'] . '">'. $row['NOMBRE'] . '</option>';
       }
       $tipoprods  .= '</select>';
   



            $result_h = $info->grid_ingredientes();   


            // retorno de ingredientes
            $retornol = '';

            $retornol .= 'ASIGNAR INGREDIENTE(S) :';

            //$retornol .= '<div style="display: flex;"><div style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;">INGREDIENTES DISPONIBLES : <br><table class="table table-bordered table-light table-hover" id="fingredientestable"><thead style="position: sticky; top:0;" class="table-primary"><tr><th><input type="text" id="fingreb1" onkeypress="filtrar_ingre1_key(event)" placeholder="INGREDIENTE" size="9px"/> <input  type="button" value="B" class="bg-success" onClick="filtrar_ingre1()"  ></th><th>CANTIDAD</th><th>UNIDAD</th><th>+</th></thead><tr>'; 

            $retornol .= '<div style="display: flex;"><div id="ingredientesasignar" style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;">INGREDIENTES DISPONIBLES : <br><table class="table table-bordered table-light table-hover" id="fingredientestable"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>INGREDIENTE</th><th>CANTIDAD</th><th>COSTO</th><th>UNIDAD</th><th>+</th></thead><tr>'; 

            $funcion = 'agregar_ingrediente(this.id)';

            if ($flagmod == 'disabled')
            {
                $funcion = '';
            }

            foreach ($result_h as $row)
            {   
                $retornol .= '<tr id="fingre'. $row['INGREDIENTE_ID'] . '" ><td id="ningre'. $row['INGREDIENTE_ID'] . '">'. $row['INGREDIENTE'] . '</td><td><input type="number" id="cingre'. $row['INGREDIENTE_ID'] . '" placeholder="Cant."  style="width:100px;"></td><td>$ <input style="width:50px;" type="number" id="dingre'. $row['INGREDIENTE_ID'] . '" value="'. $row['COSTO'] . '" readonly /></td><td id="uingre'. $row['INGREDIENTE_ID'] . '">'. $row['UNIDAD'] . '</td><td class="bg-success" id="ingre'. $row['INGREDIENTE_ID'] . '" onClick="' .$funcion  . '">+</td></tr>';
            }

            $retornol .= '</table></div><div id="ingredientesasignados" style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;" > </div></div><br>' ;


            // retorno de productos

            $result_i = $info->grid_productos();   

            $retornop = '';

            $retornop .= 'COMBINAR PRODUCTO(S) (OPCIONAL PARA COMBO) :';

            $retornop .= '<div  style="display: flex;"><div id="productosasignar" style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;">PRODUCTOS DISPONIBLES : <br><table class="table table-bordered table-light table-hover" id="fproductostable"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>NOMBRE</th><th>CATEGORIA</th><th>CANTIDAD</th><th>PRECIO</th><th>DESCRIPCION</th><th>IMAGEN</th><th>+</th></thead><tr>'; 

            $funcion2 = 'agregar_producto(this.id)';

            if ($flagmod == 'disabled')
            {
                $funcion2 = '';
            }

            foreach ($result_i as $row)
            {   
                $retornop .= '<tr id="nprod'. $row['PRODUCTO_ID'] . '" ><td id="npprod'. $row['PRODUCTO_ID'] . '">'. $row['NOMBRE_PROD'] . '</td><td id="catprod'. $row['PRODUCTO_ID'] . '">'. $row['CATEGORIA'] . ' </td><td><input type="number" step="1" pattern="\d*" onblur="this.value = Math.ceil(parseFloat(this.value));" id="cantprod'. $row['PRODUCTO_ID'] . '" placeholder="Cant."  style="width:50px;"></td><td id="precioprod'. $row['PRODUCTO_ID'] . '">'. $row['PRECIO_FINAL'] . ' </td><td id="descprod'. $row['PRODUCTO_ID'] . '">'. $row['DESCRIPCION'] . ' </td><td id="urlprod'. $row['PRODUCTO_ID'] . '">  <img src="images/productos/'. $row['URLIMG'] . '" style="width:25px;height:25px" title="'. $row['URLIMG'] . '"  ><input type="hidden" value="'. $row['URLIMG'] . '" id="url2prod'. $row['PRODUCTO_ID'] . '"></td><td class="bg-success" id="prod'. $row['PRODUCTO_ID'] . '" onClick="' .$funcion2  . '">+</td></tr>';
            }

            $retornop .= '</table></div><div id="productosasignados" style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;" > </div></div><br> ' ;

           // retorno de productos de busqueda

        
   
           if ($ver == 1)
           {
              $productos ='';

              $productos = get_productos();  
              
              $iva = $info->get_iva();
              $propina =  $info->get_propina();
              $mantenimiento =  $info->get_mantenimiento();
              $ganancia = $info->get_ganancia();
                
              $retorno = '';
   
   
              $retorno = '<form style="padding: 8px;border-radius: 6px;border: 1px solid black;" onLoad="bgestadocolorp()">
                 <div style="text-align:center">
                <label for="ccprod">Codigo del Producto :</label><br>
                <input type="text" id="ccprod" Value="PR -" disabled style="width:30px;"><input type="text" id="cprod" placeholder="Cod" disabled style="width:100px;">
                <label for="eprod">Estado :</label>  <select id="esprod" onChange="bgestadocolorp()" ><option value="Activo" style="background-color:green">Activo</option><option value="Inactivo" style="background-color:red">Inactivo</option></select> <input  type="button"  class="bg-info" id="buscarproductos" style="background:url(images/search.png) no-repeat;background-size: 25px 25px;height:30px;width:30px;" ><br>
                <label for="icprod">Imagen del Producto :</label>
                <br>
                <div style="display: flex;">                
                <div style="height:250px;width:300px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"><br>(Max=20Mb)<br>
                <img src="images/productos/noimg.gif" style="width:150px;height:150px" title="Sin Imagen" id="icprod" >
                <br>
                <input type="file" id="file" name="file"  onchange="PreviewImage();"> 
                </div>
                <div style="height:250px;width:100px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;">
                <br>
                Propina : <br> <input type="number" id="porcpropina" step="0.01" style="width:50px;" value="' .$propina[0] . '"  disabled> %<br>
                Mantenimiento : <br> <input type="number" id="porcmanto" step="0.01" style="width:50px;" value="' . $mantenimiento[0] . '" oninput="calcular_precioiva()" onblur="calcular_precioiva2()" min=0 max=100> %<br>
                Ganancia : <br> <input type="number" id="porcganancia" step="0.01" style="width:50px;" value="' . $ganancia[0] . '" oninput="calcular_precioiva()" onblur="calcular_precioiva2()" min=0 max=100> %<br>
                IVA : <br> <input type="number" id="porciva" step="0.01" style="width:50px;" value="' .$iva[0] . '" disabled title="EL IVA SE MODIFICA EN MANTENIMIENTO DE EMPRESA"> %  <br>
                </div>
                </div>

                             <br>
                Lleva Propina : &nbsp <input type="checkbox" id="propina" value="Lunes" checked><br>
                <label for="nprod" >Nombre del Producto :</label><br>
                <input type="text" id="nprod"  placeholder="Nombre" style="width:300px;">
                <br>
                <label for="catprod" >Categoria del Producto :</label><br>
                ' . $tipoprod . ' 
                <br>
                <label for="scatprod" >Menu del Producto :</label><br>
                ' . $tipoprods . ' 
                <br>
                <label for="descprod">Descripcion del producto :</label><br>
                <textarea rows="3" cols="30" id="descprod"></textarea> <br>
                <fieldset>  
                 
   
                <label>Dias de Servicio :</label><br>  
                <input type="checkbox" id="diasLu" value="Lunes">Lunes     &nbsp 
                <input type="checkbox" id="diasMa" value="Martes">Martes  &nbsp
                <input type="checkbox" id="diasMi" value="Miercoles">Miercoles &nbsp     
                <input type="checkbox" id="diasJu" value="Jueves">Jueves &nbsp
                <input type="checkbox" id="diasVi" value="Viernes">Viernes    &nbsp  
                <input type="checkbox" id="diasSa" value="Sabado">Sabado      &nbsp
                <input type="checkbox" id="diasDo" value="Domingo">Domingo &nbsp <br>
                DESDE:  <input type="date" id="desdeh"> &nbsp <input type="time" id="desdem" value="00:00"> <br>
                HASTA:  <input type="date" id="hastah"> &nbsp <input type="time" id="hastam" value="00:00"><br>
                <input type="checkbox" id="servicioindef" value="servindef" onChange="servicio_indef()">Servir todo el tiempo? &nbsp <br><br>
                <input type="checkbox" id="notaoblig" onChange="preguntas_obligatorias()"> Notas Obligatorias Comanda?  <br>
                <label for="preguntas">Preguntas : <b>( Formato : Pregunta1/Pregunta2)</b></label><br>
                <textarea rows="3" cols="30" id="preguntas" placeholder="Ejemplo:Termino de carne?/Acompañamiento? (La / divide cada pregunta)" disabled></textarea> <br>
                </fieldset> 
                <label for="preguntas">Respuestas : <b>( Formato : respuesta1/respuesta2,respuesta1/respuesta2/respuesta3)</b></label><br>
                <textarea rows="3" cols="30" id="respuestas" placeholder="Ejemplo: medio/crudo,pan/tortilla/papa (La / es para indicar que son respuestas y , que es otro bloque de respuesta)" disabled></textarea> <br>
                </fieldset> 
                 <br>

                <label for="prprod" >Precio Costo :</label>
                $ &nbsp <input type="text" id="prprod"  style="width:100px;" disabled>
                
                <label for="ivaprod" >Precio Sugerido :</label>
                $ &nbsp <input type="number" step="0.01" id="ivaprod" style="width:100px;" disabled>
                
                <label for="finalprod" >Precio Final:</label>
                $ &nbsp<input type="number" step="0.01" id="finalprod" style="width:100px;" onchange="cambiarfinalprod()"><br>
                </div>

                <br>
                <div id="panelprodsingres">
                <input type="text" id="buscaingre" placeholder="Buscar Ingrediente" oninput="filtraringreb()"/><button type="button" onclick="filtraringreb()"><img src="images/search.png" alt="Buscar Producto" border="0" style="width:20px;height:20px;" /></button>&nbsp<button type="button" onclick="qfiltraringreb()">X</button><br>
                ' . $retornol . ' 
                <input type="text" id="buscaprod" placeholder="Buscar Prod" oninput="filtrarprodb()"/><button type="button" onclick="filtrarprodb()"><img src="images/search.png" alt="Buscar Producto" border="0" style="width:20px;height:20px;" /></button>&nbsp<button type="button" onclick="qfiltrarprodb()">X</button><br>
                  ' . $retornop . ' 
                  
                </div>
                <div style="text-align:center">
                <input  type="button" value="Guardar/Modificar" class="bg-success" ' . $flagmod . ' onClick="guardarmod_producto()"> &nbsp&nbsp  <input  type="button" value="Nuevo" class="bg-primary" onClick="nuevo_producto()"> &nbsp&nbsp <input  type="button" value="X" class="bg-danger" id="borrarproductos" onClick="borrar_producto()" ' . $flagborrar . '>
                </div>
                </form><br><br>
                
                <div id="myModalproductos" style="display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%;
                overflow: auto; /* Enable scroll if needed */
                background-color: gray; /* Fallback color */"> <span class="close">&times;</span>
                <b><label>LISTADO DE PRODUCTOS :</label></b><br>
                ' . $productos . ' </div>
                
                ';
                    
             
             echo $retorno;
   
           }
   
       
      } 

      if ($estado == 'tab_ingredientes') 
      {
        $ver = '';
        $mod = '';
        $borrar = '';
    
        $info = new crud();
 
       $privilegios = $info->get_privilegios($usuario, 12);
   
       foreach ($privilegios as $row)
       {   
        $ver = $row['VER']; 
        $mod = $row['MODIFICAR'];
        $borrar = $row['BORRAR'];
       }
   
       $flagmod = '';
       $flagborrar = '';
   
       if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
       if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

      if ($ver == 1)
      {
        $ingredientes = '';
        $ingredientesnoasig = '';

        $ingredientes = generar_listado_ingredientes();

        $result_g = $info->get_unidades();

        $unidades = '';
 
        $unidades .= '<select  id="uniingre" ><option value=""></option>';
        foreach ($result_g as $row)
        {   
         $unidades  .=  '<option value="'. $row['UNIDAD'] . '">'. $row['UNIDAD'] . '</option>';
        }
        $unidades .= '</select>';
                        
        $retorno = '';
      
        $retorno = '<form style="padding: 8px;border-radius: 6px;border: 1px solid black;" onLoad="bgestadocolori()">
          <label for="cingre">Codigo del Ingrediente :</label><br>
          <input type="text" id="ccprod" Value="I -" disabled style="width:30px;"><input type="text" id="cingre" placeholder="Cod" disabled style="width:100px;">
          <label for="esingre">Estado :</label>  <select id="esingre" onChange="bgestadocolori()" ><option value="Activo" style="background-color:green">Activo</option><option value="Inactivo" style="background-color:red">Inactivo</option></select> <input  type="button"  class="bg-info" id="buscaringredientes" style="background:url(images/search.png) no-repeat;background-size: 25px 25px;height:30px;width:30px;" ><br>
          <br>                
          <label for="ningre" >Nombre del Ingrediente :</label><br>
          <input type="text" id="ningre"  placeholder="Nombre" style="width:300px;">
          <br><label for="costingre" >Costo del Ingrediente :</label><br>
          $ &nbsp<input type="number" id="costingre" step="0.01" pattern="[0-9]+([\.,][0-9]+)?"  style="width:100px;" >
          <br>
          <label for="uniingre" >Unidad :</label><br>
          ' . $unidades . '
          <br>Cantidad Elegible (Para Ingrediente compuesto) : <br><input type="number" id="cantelegible"/> <br><br>

          <div id="subingredientesasignados"   style="display: flex;justify-content: center;"> </div><br><br>
          
      
          <input  type="button" value="Guardar/Modificar" class="bg-success" ' . $flagmod . ' onClick="guardarmod_ingrediente()"> &nbsp&nbsp  <input  type="button" value="Nuevo" class="bg-primary" onClick="nuevo_ingrediente()"> &nbsp&nbsp <input  type="button" value="X" class="bg-danger" id="borraringredientes" onClick="borrar_ingrediente()" ' . $flagborrar . '>
          <br>
          *Solo se puede eliminar un ingrediente que no se halla utilizado en ningun producto o transaccion, puede optar por desactivar el ingrediente cambiando su estado

          </form><br><br>
          
          <div id="myModalingredientes" style="display: none; /* Hidden by default */
          position: fixed; /* Stay in place */
          z-index: 1; /* Sit on top */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%;
          overflow: auto; /* Enable scroll if needed */
          background-color: gray; /* Fallback color */"> <span class="close">&times;</span>
          <b><label>LISTADO DE INGREDIENTES :</label></b><br>
          ' . $ingredientes . '          
          </div>  


          
          ';
              

         
       
       echo $retorno;


      }


      }
      

         //para modal
   function generar_listado_ingredientes()
   {

       $info = new crud();

       $result_g = $info->listado_ingredientes(); 
         
       $ingre = '';

       $ingre .= '<div style="text-align:left"> BUSCAR INGREDIENTE : <input type="text" id="fingrediente" oninput="filtrar_ingredientes()" /> <input  type="button" value="buscar" class="bg-success" onClick="filtrar_ingredientes()"  > </div>';

       $ingre.= '<table id="listingredientes" class="table table-bordered table-light table-hover" style="font-size:16px;"><thead style="position: sticky; top:0;" class="table-primary"><tr><th>COD_INGREDIENTE</th><th>ESTADO</th><th>NOMBRE</th><th>COSTO</th><th>UNIDAD</th></thead><tr> ' ;


       foreach ($result_g as $row)
       {   
        $ingre.= '<tr onClick="seleccionar_ingrediente('. $row['INGREDIENTE_ID'] . ')" ><td><b><h8>I-'. $row['INGREDIENTE_ID'] . '</b></h8></td><td>'. $row['ESTADO'] . '</td><td>'. $row['INGREDIENTE'] . '</td><td>$ '. $row['COSTO'] . '</td><td>'. $row['UNIDAD'] . '</td><tr>';
       }

       $ingre .= '</table>';

       return $ingre;
       
   }

   if ($estado == 'llenar_subingredientes') 
   {
       $ingre = $_POST['ingre'];
   
       $info = new crud();
   
        $result_f = generar_listado_ingredientes_sinasig($ingre);

        $result_g = generar_listado_ingredientes_asig($ingre);
     
       echo $result_f . '&nbsp&nbsp' .  $result_g;
   }


   function generar_listado_ingredientes_sinasig($ingre)
   {

    $info = new crud();

    $result_g = $info->listado_ingredientesv2($ingre); 
      
    $ingre = '';

    $ingre.= '<div>  BUSCAR : <input type="textbox" id="buscarsub" onInput="filtrar_subingredientes_key(event)"><br><div id="subingredienteslist" style="display: flex;gap: 50px; justify-content: center;width: 500px;height: 300px;overflow-y: scroll;overflow-x: hidden;" ><table id="listsubingredientest" class="table table-bordered table-light table-hover" style="font-size:16px;"><caption style="caption-side: top; font-weight: bold; text-align: center;position: sticky; top:0;">SUB INGREDIENTES DISPONIBLES</caption><thead style="position: sticky; top:0;" class="table-primary"><tr><th>COD</th><th>NOMBRE</th><th>UNIDAD</th></thead><tr> ' ;


    foreach ($result_g as $row)
    {   
     $ingre.= '<tr onClick="agregar_subingrediente('. $row['INGREDIENTE_ID'] . ')" ><td><b><h8>I-'. $row['INGREDIENTE_ID'] . '</b></h8></td><td>'. $row['INGREDIENTE'] . '</td><td>'. $row['UNIDAD'] . '</td><tr>';
    }

    $ingre .= '</table></div></div><br>';

    return $ingre;

   }

   function generar_listado_ingredientes_asig($ingre)
   {


    $info = new crud();

    $result_g = $info->listado_ingredientesv3($ingre); 
      
    $ingre = '';

    $ingre.= '<div id="subingredienteslist" style="display: flex;gap: 50px;justify-content: center;width: 500px;height: 300px;overflow-y: scroll;overflow-x: hidden;" ><table id="listsubingredientest" class="table table-bordered table-light table-hover" style="font-size:16px;"> <caption style="caption-side: top; font-weight: bold; text-align: center;position: sticky; top:0;">SUB INGREDIENTES ASIGNADOS</caption><thead style="position: sticky; top:0;" class="table-primary"><tr><th>COD</th><th>NOMBRE</th><th>UNIDAD</th></thead><tr> ' ;


    foreach ($result_g as $row)
    {   
     $ingre.= '<tr onClick="quitar_subingrediente('. $row['INGREDIENTE_ID'] . ')" ><td><b><h8>I-'. $row['INGREDIENTE_ID'] . '</b></h8></td><td>'. $row['INGREDIENTE'] . '</td><td>'. $row['UNIDAD'] . '</td><tr>';
    }

    $ingre .= '</table> </div><br>';

    return $ingre;

   }

   if ($estado == 'tab_catprod') 
   {
     $ver = '';
     $mod = '';
     $borrar = '';
 
     $info = new crud();

    $privilegios = $info->get_privilegios($usuario, 13);

    foreach ($privilegios as $row)
    {   
     $ver = $row['VER']; 
     $mod = $row['MODIFICAR'];
     $borrar = $row['BORRAR'];
    }

    $flagmod = '';
    $flagborrar = '';

    if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
    if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

   if ($ver == 1)
   {

     $result_g = $info->get_unidades();

     $unidades = '';

     $unidades .= '<table id="catunidades" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>UNIDAD</th><th>M</th><th>X</th></thead>';
     foreach ($result_g as $row)
     {   
      $unidades  .=  '<tr><td> <input  type="text" value="' . $row['UNIDAD'] . '" id="nombreunidad_'. $row['ID_UNIDAD'] . '"/></td><td><input  type="button" value="M" class="bg-warning" id="modunidad_'. $row['ID_UNIDAD'] . '"  onClick="mod_unidad(this.id)" ' . $flagborrar . '></td><td><input  type="button" value="X" class="bg-danger" id="borraru_'. $row['UNIDAD'] . '"  onClick="borrar_unidad(this.id)" ' . $flagborrar . '></td></tr>';
     }
     $unidades .= '</table>';

     
     $result_h = $info->get_cat_prod();

     $cat = '';

     $cat.= '<table id="categorias" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th>IMAGEN</th><th>M</th><th>X</th></thead>';
     foreach ($result_h as $row)
     {   
      $urlcat =  $row['URLCAT']; 
      $cat  .=  '<tr><td><input  type="text" value="' . $row['NOMBRE'] . '" id="nombrecat_'. $row['CAT_ID'] . '"/></td><td><img src=images/' . $urlcat . ' style="width:16px;height:16px"></td><td><input  type="button" value="M" class="bg-warning" id="modcat_'. $row['CAT_ID'] . '"  onClick="mod_cat(this.id)" ' . $flagborrar . '></td><td><input  type="button" value="X" class="bg-danger" id="borrarcat_'. $row['CAT_ID'] . '"  onClick="borrar_cat(this.id)" ' . $flagborrar . '></td></tr>';
     }
     $cat .= '</table>';

     $result_i = $info->get_subcat_prod();

     $scat = '';

     $scat.= '<table id="categorias" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>MENU</th><th>M</th><th>X</th></thead>';
     foreach ($result_i as $row)
     {   
      $scat  .=  '<tr><td> <input  type="text" value="' . $row['NOMBRE'] . '" id="nombresubcat_'. $row['CAT_ID'] . '"/></td><td><input  type="button" value="M" class="bg-warning" id="modsubcat_'. $row['CAT_ID'] . '"  onClick="mod_subcat(this.id)" ' . $flagborrar . '></td><td><input  type="button" value="X" class="bg-danger" id="borrarscat_'. $row['NOMBRE'] . '"  onClick="borrar_scat(this.id)" ' . $flagborrar . '></td></tr>';
     }
     $scat .= '</table>';

     $result_j = $info->get_cat_prod();

     $catexist = '';

     $catexist .= '<table id="categoriasexistentes" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th>>></th></thead>';
     foreach ($result_j as $row)
     {   
        $catexist .=  '<tr><td> ' . $row['NOMBRE'] . '</td><td><input  type="button" value="VER" class="bg-info" id="'. $row['NOMBRE'] . '"  onClick="mostrar_catexistentes(this.id)" ' . $flagborrar . '></td></tr>';
     }
     $catexist .= '</table>';

     $result_k = $info->get_cat_prod_noasignadas();

     $catexist2 = '';

     $catexist2 .= '<table id="categoriasexistentes2" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th>>></th></thead>';
     foreach ($result_k as $row)
     {   
        $catexist2 .=  '<tr><td> ' . $row['NOMBRE'] . '</td><td><input  type="button" value="A BAR" class="bg-info" id="'. $row['NOMBRE'] . '"  onClick="agregar_abar(this.id)" ' . $flagborrar . '><input  type="button" value="A COCINA" class="bg-primary" id="'. $row['NOMBRE'] . '"  onClick="agregar_acocina(this.id)" ' . $flagborrar . '></td></tr>';
     }
     $catexist2 .= '</table>';

     $result_l = $info->get_cat_prod_barracocina();

     $catexist3 = '';
     $catexist4 = '';

     $catexist3 .= '<table id="categoriasbar" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th><<</th></thead>';
     foreach ($result_l as $row)
     {   
        if ($row['AREA'] == 'BAR')
        {
        $catexist3 .=  '<tr><td> ' . $row['CATEGORIA'] . '</td><td><input  type="button" value="<<" class="bg-danger" id="'. $row['CATEGORIA'] . '"  onClick="quitar_barcocina(this.id)" ' . $flagborrar . '></td></tr>';
        }
     }
     $catexist3 .= '</table>';

     $catexist4 .= '<table id="categoriascocina" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th><<</th></thead>';
     foreach ($result_l as $row)
     {   
        if ($row['AREA'] == 'COCINA')
        {
        $catexist4 .=  '<tr><td> ' . $row['CATEGORIA'] . '</td><td><input  type="button" value="<<" class="bg-danger" id="'. $row['CATEGORIA'] . '"  onClick="quitar_barcocina(this.id)" ' . $flagborrar . '></td></tr>';
        }
     }
     $catexist4 .= '</table>';


      
     $retorno = '';
   
     $retorno = '<form style="padding: 8px;border-radius: 6px;border: 1px solid black;">
      <b>MANTENIMIENTO DE UNIDADES</b><br>
      <div style="display: flex;"> 
       <div style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;">
         <br><br><br><br>
       <label for="nuni" >Nombre de la Unidad de Medida :</label><br><br>
       <input type="text" id="nuni"  placeholder="Nombre de Unidad" style="width:300px;"><br><br>
       <input  type="button" value="Agregar" class="bg-success" ' . $flagmod . ' onClick="guardar_unidad()"> 
       </div>
              <div id="unidadesexistentes" style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       ' . $unidades . '
       </div>
       </div>
       <b>MANTENIMIENTO DE CATEGORIAS PRINCIPALES</b><br>
       <div style="display: flex;"> 
       <div style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;">
       <br><br><br><br>
       <label for="ncat" >Nombre de la Categoria :</label><br><br>
       <input type="text" id="ncat"  placeholder="Nombre de Categoria" style="width:300px;"><br>
       <br>
       <input type="file" id="fcat" ><br>Subir Imagen (no mayor de 32px) <br>
       ejemplo :
       <img src="images/bar.png" title="Ejemplo de tamano de imagen" style="border-radius: 6px;border: 1px solid black;">
       <br><br>
       <input  type="button" value="Agregar" class="bg-success" ' . $flagmod . ' onClick="guardar_categoria()"> 
       </div>
       <div id="categoriasexistentes" style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       ' . $cat . '
       </div>
       </div>
       <b>MANTENIMIENTO DE CATEGORIAS SECUNDARIAS</b><br>
       <div style="display: flex;"> 
       <div style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;">
       <br><br><br><br>
       <label for="ncat" >Nombre del Menu :</label><br><br>
       <input type="text" id="nscat"  placeholder="Nombre de Menu" style="width:300px;"><br><br>
       <input  type="button" value="Agregar" class="bg-success" ' . $flagmod . ' onClick="guardar_scategoria()"> 
       </div>
       <div id="scategoriasexistentes" style="height:300px;overflow:auto;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       ' . $scat . '
       </div>
       </div>
       <b>ASIGNACION DE CATEGORIAS SECUNDARIAS A PRINCIPALES</b><br>
       <div style="overflow:auto;">
       <div style="display: flex;"> 

       <div id="" style="height:320px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       <b>CATEGORIAS EXISTENTES : </b><br>
       <div id="catexistentes" style="height:300px;overflow:auto;font-size: 12px;border-radius: 6px;border: 1px solid black;">
       ' . $catexist . '
       </div>
       </div>

       <div id="" style="height:320px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       <b>MENUS DE : </b><span id="spanasignados" style="background-color:blue"></span> <br>
       <div id="catexistentes_asignados" style="height:300px;overflow:auto;font-size: 12px;border-radius: 6px;border: 1px solid black;"> 
       </div>
       </div>

       <div id="" style="height:320px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       <b>MENUS DISPONIBLES : </b><br>
       <div id="catexistentes_asignar" style="height:300px;overflow:auto;font-size: 12px;border-radius: 6px;border: 1px solid black;"> 
       </div>
       </div>
       </div>

       </div>
  
       <b>ASIGNACION DE BAR Y COCINA (PARA ORDENES)</b><br>
       <div style="overflow:auto;">
       <div style="display: flex;"> 

       <div id="" style="height:320px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       <b>CATEGORIAS EXISTENTES : </b><br>
       <div id="catbarcocina" style="height:300px;overflow:auto;font-size: 12px;border-radius: 6px;border: 1px solid black;">
       ' . $catexist2 . '
       </div>
       </div>

       <div id="catbar" style="height:320px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       <b>ASIGNADOS A BAR : </b><span id="spanasignados" style="background-color:blue"></span> <br>
       <div id="cat_bar" style="height:300px;overflow:auto;font-size: 12px;border-radius: 6px;border: 1px solid black;"> 
       ' . $catexist3 . '
       </div>
       </div>

       <div id="catcocina" style="height:320px;font-size: 12px;flex:1;border-radius: 6px;border: 1px solid black;"> 
       <b>ASIGNADOS A COCINA : </b><br>
       <div id="cat_cocina" style="height:300px;overflow:auto;font-size: 12px;border-radius: 6px;border: 1px solid black;"> 
       ' . $catexist4 . '
       </div>
       </div>
       </div>

       </div>
       </form><br><br>';
           

      
    
    echo $retorno;


   } 
   }

   if ($estado == 'redraw_barcocina')
   {
    $ver = '';
    $mod = '';
    $borrar = '';

    $info = new crud();

   $privilegios = $info->get_privilegios($usuario, 13);

   foreach ($privilegios as $row)
   {   
    $ver = $row['VER']; 
    $mod = $row['MODIFICAR'];
    $borrar = $row['BORRAR'];
   }

   $flagmod = '';
   $flagborrar = '';

   if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
   if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

    $result_k = $info->get_cat_prod_noasignadas();

    $catexist2 = '';

    $catexist2 .= '<table id="categoriasexistentes2" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th>>></th></thead>';
    foreach ($result_k as $row)
    {   
       $catexist2 .=  '<tr><td> ' . $row['NOMBRE'] . '</td><td><input  type="button" value="A BAR" class="bg-info" id="'. $row['NOMBRE'] . '"  onClick="agregar_abar(this.id)" ' . $flagborrar . '><input  type="button" value="A COCINA" class="bg-primary" id="'. $row['NOMBRE'] . '"  onClick="agregar_acocina(this.id)" ' . $flagborrar . '></td></tr>';
    }
    $catexist2 .= '</table>';

    $result_l = $info->get_cat_prod_barracocina();

    $catexist3 = '';
    $catexist4 = '';

    $catexist3 .= '<b>ASIGNADOS A BAR : </b><span id="spanasignados" style="background-color:blue"></span> <br><table id="categoriasbar" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th><<</th></thead>';
    foreach ($result_l as $row)
    {   
       if ($row['AREA'] == 'BAR')
       {
       $catexist3 .=  '<tr><td> ' . $row['CATEGORIA'] . '</td><td><input  type="button" value="<<" class="bg-danger" id="'. $row['CATEGORIA'] . '"  onClick="quitar_barcocina(this.id)" ' . $flagborrar . '></td></tr>';
       }
    }
    $catexist3 .= '</table>';

    $catexist4 .= '<b>ASIGNADOS A COCINA : </b><br><table id="categoriascocina" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th><<</th></thead>';
    foreach ($result_l as $row)
    {   
       if ($row['AREA'] == 'COCINA')
       {
       $catexist4 .=  '<tr><td> ' . $row['CATEGORIA'] . '</td><td><input  type="button" value="<<" class="bg-danger" id="'. $row['CATEGORIA'] . '"  onClick="quitar_barcocina(this.id)" ' . $flagborrar . '></td></tr>';
       }
    }
    $catexist4 .= '</table>';


    $final = array();

    $final[0] = $catexist2; 
    $final[1] = $catexist3;
    $final[2] = $catexist4;   


    echo json_encode($final);

   }

   if ($estado == 'redraw_catexistentes')
   {
    $info = new crud();

    $privilegios = $info->get_privilegios($usuario, 13);

    foreach ($privilegios as $row)
    {   
     $mod = $row['MODIFICAR'];
     $borrar = $row['BORRAR'];
    }

    $flagborrar = '';

    if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
    if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

    $result_j = $info->get_cat_prod();

    $catexist = '';

    $catexist .= '<table id="categoriasexistentes" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th>>></th></thead>';
    foreach ($result_j as $row)
    {   
       $catexist .=  '<tr><td> ' . $row['NOMBRE'] . '</td><td><input  type="button" value="VER" class="bg-info" id="'. $row['NOMBRE'] . '"  onClick="mostrar_catexistentes(this.id)" ' . $flagborrar . '></td></tr>';
    }
    $catexist .= '</table>';

    echo $catexist;

   }
   
   if ($estado == 'redraw_unidades') 
   {
       $ver = '';
       $mod = '';
       $borrar = '';
   
       $info = new crud();
  
      $privilegios = $info->get_privilegios($usuario, 13);
  
      foreach ($privilegios as $row)
      {   
       $borrar = $row['BORRAR'];
      }
  
      $flagborrar = '';

      if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

       $result_g = $info->get_unidades();

       $unidades = '';
  
       $unidades .= '<table id="catunidades" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>UNIDAD</th><th>M</th><th>X</th></thead>';
       foreach ($result_g as $row)
       {   
        $unidades  .=  '<tr><td> <input  type="text" value="' . $row['UNIDAD'] . '" id="nombreunidad_'. $row['ID_UNIDAD'] . '"/></td><td><input  type="button" value="M" class="bg-warning" id="modunidad_'. $row['ID_UNIDAD'] . '"  onClick="mod_unidad(this.id)" ' . $flagborrar . '></td><td><input  type="button" value="X" class="bg-danger" id="borraru_'. $row['UNIDAD'] . '"  onClick="borrar_unidad(this.id)" ' . $flagborrar . '></td></tr>';
       }
       $unidades .= '</table>';

       echo $unidades;
 
   }  

   if ($estado == 'redraw_categoria') 
   {

       $ver = '';
       $mod = '';
       $borrar = '';
   
       $info = new crud();
  
      $privilegios = $info->get_privilegios($usuario, 13);
  
      foreach ($privilegios as $row)
      {   
       $borrar = $row['BORRAR'];
      }
  
      $flagborrar = '';

      if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

      $result_h = $info->get_cat_prod();

      $cat = '';

      $cat.= '<table id="categorias" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>CATEGORIA</th><th>IMAGEN</th><th>M</th><th>X</th></thead>';
      foreach ($result_h as $row)
      {   
       $urlcat =  $row['URLCAT']; 
       $cat  .=  '<tr><td><input  type="text" value="' . $row['NOMBRE'] . '" id="nombrecat_'. $row['CAT_ID'] . '"/></td><td><img src=images/' . $urlcat . ' style="width:16px;height:16px"></td><td><input  type="button" value="M" class="bg-warning" id="modcat_'. $row['CAT_ID'] . '"  onClick="mod_cat(this.id)" ' . $flagborrar . '></td><td><input  type="button" value="X" class="bg-danger" id="borrarcat_'. $row['CAT_ID'] . '"  onClick="borrar_cat(this.id)" ' . $flagborrar . '></td></tr>';
      }
      $cat .= '</table>';

    echo $cat;
 
   }  

   if ($estado == 'redraw_scategoria') 
   {

       $ver = '';
       $mod = '';
       $borrar = '';
   
       $info = new crud();
  
      $privilegios = $info->get_privilegios($usuario, 13);
  
      foreach ($privilegios as $row)
      {   
       $borrar = $row['BORRAR'];
      }
  
      $flagborrar = '';

      if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

      $result_i = $info->get_subcat_prod();

      $scat = '';
 
      $scat.= '<table id="categorias" class="table table-bordered table-light table-hover" style="font-size:14px;" ><thead style="position: sticky; top:0;" class="table-primary"><th>MENU</th><th>M</th><th>X</th></thead>';
      foreach ($result_i as $row)
      {   
       $scat  .=  '<tr><td> <input  type="text" value="' . $row['NOMBRE'] . '" id="nombresubcat_'. $row['CAT_ID'] . '"/></td><td><input  type="button" value="M" class="bg-warning" id="modsubcat_'. $row['CAT_ID'] . '"  onClick="mod_subcat(this.id)" ' . $flagborrar . '></td><td><input  type="button" value="X" class="bg-danger" id="borrarscat_'. $row['NOMBRE'] . '"  onClick="borrar_scat(this.id)" ' . $flagborrar . '></td></tr>';
      }
      $scat .= '</table>';
      

      echo $scat;
 
   } 

   if ($estado == 'agregar_abar')
   {
    $categoria = $_POST['categoria'];

    $info = new crud();

    $result_i = $info->agregar_abar($categoria);

    echo $result_i;

   }

   if ($estado == 'agregar_acocina')
   {
    $categoria = $_POST['categoria'];

    $info = new crud();

    $result_i = $info->agregar_acocina($categoria);

    echo $result_i;

   }

   if ($estado == 'quitar_barcocina')
   {
    $categoria = $_POST['categoria'];

    $info = new crud();

    $result_i = $info->quitar_barcocina($categoria);

    echo $result_i;
   }


   if ($estado == 'tab_empresa') 
   {
     $ver = '';
     $mod = '';
     $borrar = '';

     $codempresa = '';
     $nomcomercial = '';
     $razon = '';
     $direccion = '';
     $iva ='';
     $nit ='';
     $giro ='';
     $caja ='';
     $mensajes = '';
 
     $info = new crud();

    $privilegios = $info->get_privilegios($usuario, 14);

    foreach ($privilegios as $row)
    {   
     $ver = $row['VER']; 
     $mod = $row['MODIFICAR'];
     $borrar = $row['BORRAR'];
    }

    $flagmod = '';
    $flagborrar = '';

    if ($mod != 0){ $flagmod  = 'enabled'; } else { $flagmod = 'disabled'; }
    if ($borrar != 0) { $flagborrar = 'enabled'; } else { $flagborrar = 'disabled'; }

   if ($ver == 1)
   {

     $result_f= $info->global_empresa();

     foreach ($result_f as $row)
     {   
        $codempresa = $row['codempresa'];
        $nomcomercial = $row['nombre_comercial'];
        $razon = $row['razon_social'];
        $direccion = $row['direccion'];
        $nit = $row['conit'];
        $iva = $row['coiva'];
        $giro = $row['giro'];
        $caja = $row['caja'];
        $mensajes = $row['mensajes'];
        $correonoti =  $row['correonoti'];
        $correonoticc =  $row['correonoticc'];
     }   

     $result_g = $info->get_iva();

     $result_h = $info->get_propina();

     $result_i = $info->get_bloqueomesa();

     $result_j = $info->get_refreshmesa();

     $result_k = $info->get_cover();

     $result_l = $info->get_consumo();

     $result_m = $info->get_tiempo_maxordenbar();

     $result_m2 = $info->get_tiempo_maxordencocina();

     $result_n = $info->get_refresh_bar();

     $result_n2 = $info->get_refresh_cocina();

     $result_activadocc = $info->get_estado_cover_cm();

     $estadoc = '';
     $estadocm = '';
    // cover
     $clunes = '';
     $cmartes = '';
     $cmiercoles = '';
     $cjueves = '';
     $cviernes = '';
     $csabado = '';
     $cdomingo = '';
     $choraini = '';
     $chorafin = '';
     //consumo
     $cmlunes = '';
     $cmmartes = '';
     $cmmiercoles = '';
     $cmjueves = '';
     $cmviernes = '';
     $cmsabado = '';
     $cmdomingo = '';
     $cmhoraini = '';
     $cmhorafin = '';

     if ($result_activadocc[0] == 'true')
     {
        $estadoc = 'checked';
     }
     if ($result_activadocc[1] == 'true')
     {
        $estadocm = 'checked';
     }
     if ($result_activadocc[2] == 'true')
     {
        $clunes = 'checked';
     }
     if ($result_activadocc[3] == 'true')
     {
        $cmartes = 'checked';
     }
     if ($result_activadocc[4] == 'true')
     {
        $cmiercoles = 'checked';
     }
     if ($result_activadocc[5] == 'true')
     {
        $cjueves = 'checked';
     }
     if ($result_activadocc[6] == 'true')
     {
        $cviernes = 'checked';
     }
     if ($result_activadocc[7] == 'true')
     {
        $csabado = 'checked';
     }
     if ($result_activadocc[8] == 'true')
     {
        $cdomingo = 'checked';
     }
     if ($result_activadocc[9] != '')
     {
        $choraini = $result_activadocc[9];
     }
     if ($result_activadocc[10] != '')
     {
        $chorafin = $result_activadocc[10];
     }
    /// cm
     if ($result_activadocc[11] == 'true')
     {
        $cmlunes = 'checked';
     }
     if ($result_activadocc[12] == 'true')
     {
        $cmmartes = 'checked';
     }
     if ($result_activadocc[13] == 'true')
     {
        $cmmiercoles = 'checked';
     }
     if ($result_activadocc[14] == 'true')
     {
        $cmjueves = 'checked';
     }
     if ($result_activadocc[15] == 'true')
     {
        $cmviernes = 'checked';
     }
     if ($result_activadocc[16] == 'true')
     {
        $cmsabado = 'checked';
     }
     if ($result_activadocc[17] == 'true')
     {
        $cmdomingo = 'checked';
     }
     if ($result_activadocc[18] != '')
     {
        $cmhoraini = $result_activadocc[18];
     }
     if ($result_activadocc[19] != '')
     {
        $cmhorafin = $result_activadocc[19];
     }


     $retorno = '';
   
     $retorno = '<form style="padding: 8px;border-radius: 6px;border: 1px solid black;">
       <p>
       <p>
       DATOS DEL FIRMANTE EN EL BALANCE :
       </p>
        <label for="codempresa"  >Codigo de la Empresa :</label><br>
       <input type="text" id="codempresa"  class="bg-primary" value="'.  $codempresa . '">
       </p>                
       <p>
       <label for="nomcomercial">Nombre Comercial :</label><br>
       <input type="text" id="nomcomercial" value="'.  $nomcomercial . '" style="width:300px;">
       </p> 
       <p>
       <label for="razonsocial">Razon Social :</label><br>
       <input type="text" id="razonsocial" value="'.  $razon . '">
       </p>      
       <p>
       <label for="dir">Direccion :</label><br>
       <textarea rows="3" cols="30" id="dir" > '.  $direccion . '</textarea> <br>
       </p>
       <p>
       <label for="nit">NIT :</label><br>
       <input type="text" id="nit"  value="'.  $nit . '">
       </p>  
       <p>
       <label for="iva">IVA :</label><br>
       <input type="text" id="iva"  value="'.  $iva . '">
       </p>  
       <p>
       <label for="giro">GIRO :</label><br>
       <input type="text" id="giro"  value="'.  $giro . '">
       </p>  
       <p>
       <label for="caja">CAJA :</label><br>
       <input type="text" id="caja" value="'.  $caja . '">
       </p>  
       <p>
       <label for="mensaje">Mensajes :</label><br>
       <textarea rows="3" cols="30" id="mensaje"> '.  trim($mensajes) . '</textarea> <br>
       </p>
       <p>
       <label for="correonoti">Correo de Notificaciones Principal :</label><br>
       <input type="text" id="correonoti"  value="'.   $correonoti . '" maxlength="35px">
       </p>  
       <p>
       <label for="correonoticc">Correos de Notificaciones Secundarios (separados por coma) :</label><br>
       <textarea rows="3" cols="30" id="correonoticc"> '.  trim($correonoticc) . '</textarea> <br>
       </p>  


   
       <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_empresa()"> 
        </form><br>
        <form style="padding: 8px;border-radius: 6px;border: 1px solid black;">
        <br>
        <p>
        OTRAS VARIABLES :
        </p>
        <p>
        <label for="ivaprod" style="width:200px">IVA de Productos :</label>
        <input type="number" step="0.01" id="ivaprod" style="width:100px;" value="'.  $result_g[0] . '"> %
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_iva_global()"> 
        <br>
        </p>
        <p>
        <label for="propinaprod" style="width:200px">Propina :</label>
        <input type="number" step="0.01" id="propinaprod" style="width:100px;" value="'.  $result_h[0] . '"> %
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_propina_global()"> 
        <br>
        </p>

        <div style="display:flex">
        <div  style="flex:1;padding: 8px;border-radius: 6px;border: 1px solid black;">
        CONFIGURACIONES DE COMANDA :
        <p>
        <label for="bloqueomesa" style="width:200px">Tiempo de bloqueo de mesa (MESEROS) :</label>
        <input type="number" step="1" id="bloqueomesa" style="width:100px;" value="'.  $result_i[0] . '"> mins
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_bloqueomesa_global()"> 
        <br>
        </p>
        <p>
        <label for="refreshmesa" style="width:200px">Tiempo de actualizacion de pantalla de mesas (MESEROS) :</label>
        <input type="number" step="1" id="refreshmesa" style="width:100px;" value="'.  $result_j[0] . '"> mins
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_mesarefresh_global()"> 
        <br>
        </p>       
        </div>

        <div  style="flex:1;padding: 8px;border-radius: 6px;border: 1px solid black;">
        CONFIGURACIONES DE BAR :
        <p>
        <label for="maxbar" style="width:200px">Tiempo Maximo de Orden en BAR:</label>
        <input type="number" step="1" id="maxbar" style="width:100px;" value="'.  $result_m[0] . '"> mins
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_maxbar_global()"> 
        <br>
        </p>
        <p>
        <label for="refreshbar" style="width:200px">Tiempo de actualizacion de pantalla de BAR :</label>
        <input type="number" step="1" id="refreshbar" style="width:100px;" value="'.  $result_n[0] . '"> mins
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_barrefresh_global()"> 
        <br>
        </p>       
        </div>

        <div  style="flex:1;padding: 8px;border-radius: 6px;border: 1px solid black;">
        CONFIGURACIONES DE COCINA :
        <p>
        <label for="maxcocina" style="width:200px">Tiempo Maximo de Orden en COCINA :</label>
        <input type="number" step="1" id="maxcocina" style="width:100px;" value="'.  $result_m2[0] . '"> mins
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_maxcocina_global()"> 
        <br>
        </p>
        <p>
        <label for="refreshcocina" style="width:200px">Tiempo de actualizacion de pantalla de COCINA :</label>
        <input type="number" step="1" id="refreshcocina" style="width:100px;" value="'.  $result_n2[0] . '"> mins
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_cocinarefresh_global()"> 
        <br>
        </p>       
        </div>

        </div>

        </form>

        <form style="padding: 8px;border-radius: 6px;border: 1px solid black;">
        <p>
        COVER Y CONSUMO MINIMO : 
        </p>
        <b>COVER :</b> <br>
        <div style="border-radius: 6px;border: 1px solid black;">
        <input type="checkbox" id="estadocover" value="activado" ' . $estadoc . '>Activado  <br>
        <label for="cover" style="width:200px">COVER :</label>
        $ <input type="number" step="0.01" id="cover" style="width:100px;" value="'.  $result_k[0] . '"> <br>
        <label>Dias de Servicio :</label><br>  
        <input type="checkbox" id="cdiasLu" value="Lunes"  '.  $clunes . '>Lunes     &nbsp 
        <input type="checkbox" id="cdiasMa" value="Martes"  '.  $cmartes . '>Martes  &nbsp
        <input type="checkbox" id="cdiasMi" value="Miercoles" '.  $cmiercoles . '>Miercoles &nbsp     
        <input type="checkbox" id="cdiasJu" value="Jueves" '.  $cjueves . '>Jueves &nbsp
        <input type="checkbox" id="cdiasVi" value="Viernes" '.  $cviernes . '>Viernes    &nbsp  
        <input type="checkbox" id="cdiasSa" value="Sabado" '.  $csabado . '>Sabado      &nbsp
        <input type="checkbox" id="cdiasDo" value="Domingo" '.  $cdomingo . '>Domingo &nbsp DESDE:<input type="time" id="cdesdem" value="'.  $choraini . '">HASTA:<input type="time" id="chastam" value="'.  $chorafin . '"><br>
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_cover()"> 
        <br><br>
        </div>
        <br>
        <b>CONSUMO MINIMO:</b> <br>
        <div style="border-radius: 6px;border: 1px solid black;">
        <input type="checkbox" id="estadoconsumo" value="activado" ' . $estadocm . '>Activado  <br>
        <label for="consumo" style="width:200px">CONSUMO MINIMO :</label>
        $ <input type="number" step="0.01" id="consumo" style="width:100px;" value="'.  $result_l[0] . '"> <br>
        <label>Dias de Servicio :</label><br>  
        <input type="checkbox" id="cmdiasLu" value="Lunes" '.  $cmlunes . '>Lunes     &nbsp 
        <input type="checkbox" id="cmdiasMa" value="Martes" '.  $cmmartes . '>Martes  &nbsp
        <input type="checkbox" id="cmdiasMi" value="Miercoles" '.  $cmmiercoles . '>Miercoles &nbsp     
        <input type="checkbox" id="cmdiasJu" value="Jueves" '.  $cmjueves . '>Jueves &nbsp
        <input type="checkbox" id="cmdiasVi" value="Viernes" '.  $cmviernes . '>Viernes    &nbsp  
        <input type="checkbox" id="cmdiasSa" value="Sabado" '.  $cmsabado . '>Sabado      &nbsp
        <input type="checkbox" id="cmdiasDo" value="Domingo" '.  $cmdomingo . '>Domingo &nbsp 
        DESDE:<input type="time" id="cmdesdem" value="'.  $cmhoraini . '">HASTA:<input type="time" id="cmhastam" value="'.  $cmhorafin . '"><br>
        <input  type="button" value="Modificar" class="bg-success" ' . $flagmod . ' onClick="guardar_consumo()"> <br>
        <br>
        </div>
        </form>
        <br>
        
        ';           

      
    
    echo $retorno;


   }

   

   }

   if ($estado == 'redraw_areas_zonas') 
   {
       $mapzona = '';

       $mapzona = generar_mapa_zonas();

       echo $mapzona;
   }

   if ($estado == 'guardar_cover') 
   {
    $ecover = $_POST['ecover'];
    $cover = $_POST['cover'];
    $cdiasLu = $_POST['cdiasLu'];
    $cdiasMa = $_POST['cdiasMa'];
    $cdiasMi = $_POST['cdiasMi'];
    $cdiasJu = $_POST['cdiasJu'];
    $cdiasVi = $_POST['cdiasVi'];
    $cdiasSa = $_POST['cdiasSa'];
    $cdiasDo = $_POST['cdiasDo'];
    $cdesdem = $_POST['cdesdem'];
    $chastam = $_POST['chastam'];

    $info = new crud();

    $result_f= $info->guardar_cover($ecover,$cover,$cdiasLu,$cdiasMa,$cdiasMi,$cdiasJu,$cdiasVi,$cdiasSa,$cdiasDo,$cdesdem,$chastam);

    echo $result_f;
   }

   if ($estado == 'guardar_consumo') 
   {
    $econsumo = $_POST['econsumo'];
    $consumo = $_POST['consumo'];
    $cmdiasLu = $_POST['cmdiasLu'];
    $cmdiasMa = $_POST['cmdiasMa'];
    $cmdiasMi = $_POST['cmdiasMi'];
    $cmdiasJu = $_POST['cmdiasJu'];
    $cmdiasVi = $_POST['cmdiasVi'];
    $cmdiasSa = $_POST['cmdiasSa'];
    $cmdiasDo = $_POST['cmdiasDo'];
    $cmdesdem = $_POST['cmdesdem'];
    $cmhastam = $_POST['cmhastam'];

    $info = new crud();

    $result_f= $info->guardar_consumo($econsumo,$consumo,$cmdiasLu,$cmdiasMa,$cmdiasMi,$cmdiasJu,$cmdiasVi,$cmdiasSa,$cmdiasDo,$cmdesdem,$cmhastam);

    echo $result_f;
   }
    
?>
