<?php

session_start();



require_once "cfg/conexion.php";
require_once "crud/crud.php";

$estado = $_POST['estado'];



if ($estado == 'loginicial') {

echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="./style.css">
<!-- partial:index.partial.html -->
<div id="login-form-wrap">
<img src="images/autologo.jpg" alt="Chachalacas" width="300" height="300">
  <h2>Ingreso</h2>
  <form id="login-form">
    <p>
    <input type="text" id="user11" name="user11" placeholder="Usuario" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="password" id="pass11" name="pass11" placeholder="contraseña" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="button" class="bg-primary" id="login" value="Ingresar" onClick="logins()">
    </p>
  </form>
  <div id="create-account-wrap">
    <p>Bienvenido, ingrese su usuario y contraseña</a><p>
  </div><!--create-account-wrap-->
</div><!--login-form-wrap-->
<!-- partial -->';

}

if ($estado == 'login')
{
    $ret ='';

    $usuario= $_POST['usuario'];
    $pass = $_POST['pass'];

    $info = new crud();

    $result_validar = $info->validar_contra($usuario,SHA1($pass));
    
    $ret = $result_validar[0];

    $result_licencia = $info->validar_licencia();

     // si la licencia no es la adecuada
    if ($result_licencia[0] != 1)
    {$ret = 99;}

    if ($result_licencia[0] == 100)
    {$ret = 100;}

    if ($ret == 1) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['token'] = 1;
    }
    
    echo $ret;
    exit;
}

if ($estado == 'login_comanda')
{
    $ret ='';

    $usuario= $_POST['usuario'];
    $pass = $_POST['pass'];

    $info = new crud();

    $result_validar = $info->validar_contra_comanda($usuario,SHA1($pass));
    
    $ret = $result_validar[0];
  
    echo $ret;
}

if ($estado == 'login_comanda2')
{
    $ret ='';

    $usuario= $_POST['usuario'];
    $pass = $_POST['pass'];

    $info = new crud();

    $result_validar = $info->validar_contra_comanda2($usuario,SHA1($pass));
    
    $ret = $result_validar[0];
  
    echo $ret;
}

if ($estado == 'opcionesusuario') 
{
    $usuario= $_POST['usuario'];

    $info = new crud();

    $result_f = $info->opciones_usuario($usuario);

    $opciones = '<br><br><br><div id="opciones_menu" style="margin: 0 auto;width: 50%;text-align: center;border-style: double;background:rgba(60, 179, 113, 0.75);" ><br> ';
     
    $i = 1;

     foreach ($result_f as $row)
     {   
   
     $opciones .= '<button type="button" class="btn btn-dark btn-sq-responsive bg-secondary bg-gradient"  onClick="' . $row['FUNCION'] . '" title="' . $row['TITULO'] . '"  style="width: 100px; height: 100px"><img style="width: 75px; height: 75px" src="images/' . $row['ICONO'] . '.png"></button>';

     if (fmod($i,4) == 0)
     {
      $opciones .= '<br>';
     }
      
     $i++;
     
     } 

    $opciones .= '<br><button type="button" class="btn btn-dark btn-sq-responsive bg-danger"  onClick="onClick=salir()" style="width: 100px; height: 100px"><img style="width: 75px; height: 75px" src="images/logout.png"></button>';
   
    $opciones .= '<img src="images/autologo.jpg" width="100px" height="100px">';

    $opciones .=  '<br> <b> Usuario : ' . $usuario . '</b></div><br><br><br><br><br><br><br><br><br>';

    echo $opciones;
    
}

if ($estado == 'fondousuario') 
{
  $usuario= $_POST['usuario'];

  $info = new crud();

  $result_f = $info->fondo_usuario($usuario);
  $res = '';

  if ($result_f[0] == 'celeste')
  {
   $res = 'cyan';
  }
  if ($result_f[0] == 'gris')
  {
   $res = 'gray';
  }
  if ($result_f[0] == 'blanco')
  {
   $res = 'white';
  }
  if ($result_f[0] == 'verde')
  {
   $res = 'green';
  }
  if ($result_f[0] == 'amarillo')
  {
   $res = 'yellow';
  }
  if ($result_f[0] == 'azul')
  {
   $res = 'lightblue';
  }


  echo $res;
}

?>