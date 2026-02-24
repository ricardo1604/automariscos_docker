<?php

session_start();

require_once "cfg/conexion.php";
require_once "crud/crud.php";

$estado = $_POST['estado'];

if ($estado == 'agregar_usuario') 
{
    $usuario = $_POST['usuario'];
    $password= $_POST['password'];
    $rol = $_POST['rol'];
    $meta= $_POST['meta'];
    $comision = $_POST['comision'];
    $comisionp = $_POST['comisionp'];
    $nombre = $_POST['nombre'];
    $fondo = $_POST['fondo'];


    $info = new crud();

    $result_f = $info->agregar_usuario($usuario, $password, $nombre, $meta, $comision, $rol, $comisionp, $fondo);
  
    echo $result_f;
}

if ($estado == 'borrar_usuario') {
    $usuarioid = $_POST['usuarioid'];
  
  
    $info = new crud();
  
    $result_f = $info->borrar_usuario($usuarioid);
  
    echo $result_f;
  }



  if ($estado == 'modificar_usuario') {
    $usuarioid = $_POST['usuarioid'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $estadouser = $_POST['estadouser'];
    $meta = $_POST['meta'];
    $comision = $_POST['comision'];
    $comisionp = $_POST['comisionp'];
    $rol = $_POST['rol'];
    $fondo = $_POST['fondo'];
    $zonas = $_POST['zonas'];
  
    $info = new crud();
  
    $result_f = $info->modificar_usuario($usuarioid, $password, $nombre, $estadouser, $meta, $comision, $rol, $comisionp, $fondo, $zonas);
  
    echo $result_f;
  }


  /// roles
  if ($estado == 'agregar_rol') 
  {
    $rol = $_POST['rol'];  
  
      $info = new crud();
  
      $result_f = $info->agregar_rol($rol);
    
      echo $result_f;
  }

  if ($estado == 'borrar_rol') {
    $rol = $_POST['rol'];
  
  
    $info = new crud();
  
    $result_f = $info->borrar_rol($rol);
  
    echo $result_f;
  }

  if ($estado == 'modificar_rol') {
    $rolnombre = $_POST['rolnombre'];
    $rol = $_POST['rol'];
  
    $info = new crud();
  
    $result_f = $info->modificar_rol($rolnombre, $rol);
  
    echo $result_f;
  }

  ///grupos

  if ($estado == 'agregar_grupo') 
{
    $grupo= $_POST['grupo'];

    $info = new crud();

    $result_f = $info->agregar_grupo($grupo);
  
    echo $result_f;
}

if ($estado == 'borrar_grupo') {
  $grupo = $_POST['grupo'];


  $info = new crud();

  $result_f = $info->borrar_grupo($grupo);

  echo $result_f;
}

if ($estado == 'modificar_grupo') {
  $grupo = $_POST['grupo'];
  $id = $_POST['id'];

  $info = new crud();

  $result_f = $info->modificar_grupo($grupo,$id);

  echo $result_f;
}


if ($estado == 'agregar_opcion') 
{
    $idfinal = $_POST['idfinal'];
    $grupo = $_POST['grupo'];

    $info = new crud();

     $result_f = $info->agregar_opcion($grupo, $idfinal);
  
    echo json_encode($result_f[0]);
}


if ($estado == 'quitar_opcion') 
{
    $idfinal = $_POST['idfinal'];
    $grupo = $_POST['grupo'];

    $info = new crud();

    $result_f = $info->quitar_opcion($grupo, $idfinal);
  
    echo json_encode($result_f[0]);
}

if ($estado == 'quitar_grupo') 
{
    $userid = $_POST['userid'];
    $grupo = $_POST['grupo'];

    $info = new crud();

    $result_f = $info->quitar_grupo($userid, $grupo);
  
    echo json_encode($result_f[0]);
}

if ($estado == 'agregar_grupod') 
{
    $userid = $_POST['userid'];
    $grupo = $_POST['grupo'];

    $info = new crud();

    $result_f = $info->agregar_grupod($userid, $grupo);
  
    echo json_encode($result_f[0]);
}

if ($estado == 'agregar_privlectura')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privlectura($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_privlectura')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privlectura($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_subingrediente')
{
  $usuario = $_POST['usuario'];
  $idparent = $_POST['idparent'];
  $idchild = $_POST['idchild'];

  $info = new crud();

  $result_f = $info->quitar_subingrediente($idparent, $idchild);

  echo $result_f;

}

if ($estado == 'agregar_subingrediente')
{
  $usuario = $_POST['usuario'];
  $idparent = $_POST['idparent'];
  $idchild = $_POST['idchild'];

  $info = new crud();

  $result_f = $info->agregar_subingrediente($idparent, $idchild);

  echo $result_f;

}



if ($estado == 'agregar_privescritura')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privescritura($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_privescritura')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privescritura($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'agregar_privborrar')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privborrar($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_privborrar')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privborrar($usuario, $priv_id);

  echo $result_f;
}

if ($estado == 'agregar_privimprimir')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privimprimir($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_privimprimir')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privimprimir($usuario, $priv_id);

  echo $result_f;
}


if ($estado == 'agregar_privcortesia')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privcortesia($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_privcortesia')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privcortesia($usuario, $priv_id);

  echo $result_f;
}

if ($estado == 'agregar_privprecuenta')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privprecuenta($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_privprecuenta')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privprecuenta($usuario, $priv_id);

  echo $result_f;
}


if ($estado == 'agregar_privseparar')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privseparar($usuario, $priv_id);

  echo $result_f;


}

if ($estado == 'quitar_privseparar')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privseparar($usuario, $priv_id);

  echo $result_f;
}

if ($estado == 'agregar_privop')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->agregar_privop($usuario, $priv_id);

  echo $result_f;
}

if ($estado == 'quitar_privop')
{
  $usuario = $_POST['usuario'];
  $priv_id = $_POST['priv_id'];

  $info = new crud();

  $result_f = $info->quitar_privop($usuario, $priv_id);

  echo $result_f;
}

if ($estado == 'seleccionar_proveedor') 
{
    $proveedor = $_POST['proveedor'];

    $info = new crud();

    $result_f = $info->buscar_proveedor($proveedor);

    $resultado_log = [];

    foreach ($result_f as $row) 
    {
      $proveedor_id =  $row['PROVEEDOR_ID'];
      $nombre =  $row['NOMBRE'];
      $telefono =  $row['TELEFONO'];
      $celular =  $row['CELULAR'];
      $correo =   $row['CORREO'];
      $direccion =   $row['DIRECCION'];
      $departamento =   $row['DEPARTAMENTO'];
      $municipio =   $row['MUNICIPIO'];
      $pais =   $row['PAIS'];
      $contactos =   $row['CONTACTOS'];
      $reg_iva =   $row['REG_IVA'];
      $nit =   $row['NIT'];
      $giro =   $row['GIRO'];
      $dgii =   $row['CLASIFICACION_DGII'];
      $esprov = $row['ESTADO'];
     
    }
   
    $resultado_log[0] = $proveedor_id;
    $resultado_log[1] = $nombre;
    $resultado_log[2] = $telefono;
    $resultado_log[3] = $celular;
    $resultado_log[4] = $correo;
    $resultado_log[5] = $direccion;
    $resultado_log[6] = $departamento;
    $resultado_log[7] = $municipio;
    $resultado_log[8] = $pais;
    $resultado_log[9] = $contactos;
    $resultado_log[10] = $reg_iva;
    $resultado_log[11] = $nit;
    $resultado_log[12] = $giro;
    $resultado_log[13] = $dgii;
    $resultado_log[15] = $esprov;

   //buscar los municipios para llenado
   $result_g = $info->buscar_municipios($departamento);

   $vardept = '';

   $vardept.= '<select  id="mprov" ><option value=""></option>';
   foreach ($result_g as $row)
   {   
   $vardept .=  '<option value="'. $row['MUNICIPIO'] . '">'. $row['MUNICIPIO'] . '</option>';
   }
   $vardept .= '</select>';

   $resultado_log[14] = $vardept;


    echo json_encode($resultado_log);

}

if ($estado == 'seleccionar_cliente') 
{
    $cliente = $_POST['cliente'];

    $info = new crud();

    $result_f = $info->buscar_cliente($cliente);

    $resultado_log = [];

    foreach ($result_f as $row) 
    {
      $CLIENTE_ID =  $row['CLIENTE_ID'];
      $NOMBRES =  $row['NOMBRES'];
      $APELLIDOS =  $row['APELLIDOS'];
      $EMPRESA =  $row['EMPRESA'];
      $DUI =  $row['DUI'];
      $CORREO =  $row['CORREO'];     
      $ESTADO =  $row['ESTADO'];  
      $TELEFONO = $row['TELEFONO'];  
      $CUMPLE = $row['FECHA_CUMPLEANOS'];  
      $COM = $row['FECHA_CONMEMORATIVA'];  
      $NOTAS = $row['NOTAS'];  

    }
   
    $resultado_log[0] = $CLIENTE_ID;
    $resultado_log[1] = $NOMBRES;
    $resultado_log[2] = $APELLIDOS;
    $resultado_log[3] = $EMPRESA;
    $resultado_log[4] = $DUI;
    $resultado_log[5] = $CORREO;
    $resultado_log[6] = $ESTADO;
    $resultado_log[7] = $TELEFONO;
    $resultado_log[8] = $CUMPLE;
    $resultado_log[9] = $COM;
    $resultado_log[10] = $NOTAS;



    echo json_encode($resultado_log);

}


if ($estado == 'seleccionar_ingrediente') 
{
    $ingre = $_POST['ingre'];

    $info = new crud();

    $result_f = $info->buscar_ingrediente($ingre);

    $resultado_log = [];

    foreach ($result_f as $row) 
    {
      $INGREDIENTE_ID =  $row['INGREDIENTE_ID'];
      $INGREDIENTE =  $row['INGREDIENTE'];
      $UNIDAD =  $row['UNIDAD'];
      $ESTADO =  $row['ESTADO'];  
      $COSTO =  $row['COSTO'];
      $CANTELEGIBLE = $row['CANTIDAD_ELEGIBLE'];
    }
   
    $resultado_log[0] = $INGREDIENTE_ID;
    $resultado_log[1] = $INGREDIENTE;
    $resultado_log[2] = $UNIDAD;
    $resultado_log[3] = $ESTADO;
    $resultado_log[4] = $COSTO;
    $resultado_log[5] = $CANTELEGIBLE;

    echo json_encode($resultado_log);

}


if ($estado == 'seleccionar_proveedor_nombre') 
{
    $proveedor = $_POST['proveedor'];

    $info = new crud();

    $result_f = $info->buscar_proveedor_nombre($proveedor);

    $resultado_log = [];

    if (count($result_f) == 0)
    {
      $resultado_log[0] = 'NF';         
    }

   // echo json_encode($resultado_log);

    if (count($result_f) != 0) {
    foreach ($result_f as $row) 
    {
      $proveedor_id =  $row['PROVEEDOR_ID'];
      $nombre =  $row['NOMBRE'];
      $telefono =  $row['TELEFONO'];
      $celular =  $row['CELULAR'];
      $correo =   $row['CORREO'];
      $direccion =   $row['DIRECCION'];
      $departamento =   $row['DEPARTAMENTO'];
      $municipio =   $row['MUNICIPIO'];
      $pais =   $row['PAIS'];
      $contactos =   $row['CONTACTOS'];
      $reg_iva =   $row['REG_IVA'];
      $nit =   $row['NIT'];
      $giro =   $row['GIRO'];
      $dgii =   $row['CLASIFICACION_DGII'];
      $esprov = $row['ESTADO'];
     
    }
   
    $resultado_log[0] = $proveedor_id;
    $resultado_log[1] = $nombre;
    $resultado_log[2] = $telefono;
    $resultado_log[3] = $celular;
    $resultado_log[4] = $correo;
    $resultado_log[5] = $direccion;
    $resultado_log[6] = $departamento;
    $resultado_log[7] = $municipio;
    $resultado_log[8] = $pais;
    $resultado_log[9] = $contactos;
    $resultado_log[10] = $reg_iva;
    $resultado_log[11] = $nit;
    $resultado_log[12] = $giro;
    $resultado_log[13] = $dgii;
    $resultado_log[15] = $esprov;
  

   //buscar los municipios para llenado
   $result_g = $info->buscar_municipios($departamento);

   $vardept = '';

   $vardept.= '<select  id="mprov" ><option value=""></option>';
   foreach ($result_g as $row)
   {   
   $vardept .=  '<option value="'. $row['MUNICIPIO'] . '">'. $row['MUNICIPIO'] . '</option>';
   }
   $vardept .= '</select>';

   $resultado_log[14] = $vardept;

   }

    echo json_encode($resultado_log);

}

if ($estado == 'seleccionar_producto') 
{
    $producto_id = $_POST['producto_id'];

    $info = new crud();

    $result_f = $info->buscar_producto($producto_id);

    $resultado_log = [];

    foreach ($result_f as $row) 
    {
      $PRODUCTO_ID =  $row['PRODUCTO_ID'];
      $URLIMG =  $row['URLIMG'];
      $PRODUCTO = $row['NOMBRE_PROD'];
      $PRECIO = $row['PRECIO_FINAL'];
      $IVA = $row['PRECIO_SUGERIDO'];
      $CAT = $row['CATEGORIA'];
      $SCAT = $row['MENU'];
      $DESC = $row['DESCRIPCION'];
      $ESTADOP = $row['ESTADO'];
      $LUNES = $row['LUNES'];
      $MARTES = $row['MARTES'];
      $MIERCOLES = $row['MIERCOLES'];
      $JUEVES = $row['JUEVES'];
      $VIERNES = $row['VIERNES'];
      $SABADO = $row['SABADO'];
      $DOMINGO = $row['DOMINGO'];
      $FECHAD = $row['FECHADESDE'];
      $HORAD = $row['HORADESDE'];
      $FECHAH = $row['FECHAHASTA'];
      $HORAH = $row['HORAHASTA'];
      $PORCMANT = $row['PORCMANT'];
      $PORCGANANCIA = $row['PORCGANANCIA'];
      $SERVICIO =  $row['SERVICIO'];
      $PROPINA = $row['PROPINA'];
      $NOTAOBLIG = $row['NOTAS_OBLIGATORIAS'];
      $PREGUNTAS = $row['PREGUNTAS'];
      $RESPUESTAS = $row['RESPUESTAS'];
    }
   
    $resultado_log[0] = $PRODUCTO_ID;
    $resultado_log[1] = $URLIMG;
    $resultado_log[2] = $PRODUCTO;
    $resultado_log[3] = $PRECIO;
    $resultado_log[4] = $IVA;
    $resultado_log[5] = $CAT;
    $resultado_log[6] = $SCAT;
    $resultado_log[7] = $DESC;
    $resultado_log[8] = $ESTADOP;
    $resultado_log[9] = $LUNES;
    $resultado_log[10] = $MARTES;
    $resultado_log[11] = $MIERCOLES;
    $resultado_log[12] = $JUEVES;
    $resultado_log[13] = $VIERNES;
    $resultado_log[14] = $SABADO;
    $resultado_log[15] = $DOMINGO;
    $resultado_log[16] = $FECHAD;
    $resultado_log[17] = $HORAD;
    $resultado_log[18] = $FECHAH;
    $resultado_log[19] = $HORAH;

    //HACER SELECT DE LOS INGREDIENTES Y ENVIAR ARRAY
    $result_i = $info-> buscar_ingredientes_asignados($PRODUCTO_ID);

    $ingredientes_asignados = [];
    $tingredientes_asignados = [];
    $ingredientes_asignados2 = [];

    $prprod = 0;

    foreach ($result_i as $row)
    {   
      array_push($tingredientes_asignados, $row['INGREDIENTE_ID'], $row['INGREDIENTE'], $row['CANTIDAD'], $row['UNIDAD'], $row['COSTOT']);
      array_push($ingredientes_asignados, $tingredientes_asignados);

      array_push($ingredientes_asignados2, $row['INGREDIENTE_ID']);
      
      $tingredientes_asignados = [];
      //acum de precio actual
      $prprod = $prprod + $row['COSTOT'];
    }

    $resultado_log[20] = $ingredientes_asignados;

    //HACER SELECT DE LOS PRODS (SI HAY) Y ENVIAR ARRAY
    $result_j = $info-> buscar_subproductos_asignados($PRODUCTO_ID);

    $productos_asignados = [];
    $tproductos_asignados = [];
    $productos_asignados2 = [];

    foreach ($result_j as $row)
    {   
      array_push($tproductos_asignados, $row['SUBPRODUCTO_ID'], $row['SUBPRODUCTO'], $row['CATEGORIA'], $row['CANTIDAD'], $row['DESCRIPCION'], $row['URLIMG']);
      array_push($productos_asignados, $tproductos_asignados);

      array_push($productos_asignados2, $row['SUBPRODUCTO_ID']);

      $tproductos_asignados = [];
    }

    $resultado_log[21] = $productos_asignados;
    $resultado_log[22] = $PORCMANT;
    $resultado_log[23] = $PORCGANANCIA;
    $resultado_log[24] = $SERVICIO;
    $resultado_log[25] = $PROPINA;
    $resultado_log[26] = $prprod;
    $resultado_log[27] = $ingredientes_asignados2; //ARREGLO
    $resultado_log[28] = $productos_asignados2; ///ARREGLO
    $resultado_log[29] = $NOTAOBLIG;
    $resultado_log[30] = $PREGUNTAS;
    $resultado_log[31] = $RESPUESTAS;

    echo json_encode($resultado_log);

}


if ($estado == 'guardarmod_proveedor') 
{
  $tipo =  $_POST['tipo'];
  $codigo =  $_POST['codigo'];
  $nombre =  $_POST['nombre'];
  $telefono =  $_POST['telefono'];
  $cel =  $_POST['cel'];
  $email =  $_POST['email'];
  $direccion =  $_POST['direccion'];
  $departamento =  $_POST['departamento'];
  $municipio =  $_POST['municipio'];
  $pais =  $_POST['pais'];
  $contacto =  $_POST['contacto'];
  $iva =  $_POST['iva'];
  $nit =  $_POST['nit'];
  $giro =  $_POST['giro'];
  $dgii =  $_POST['dgii'];
  $estadop = $_POST['estadop'];

  if ($tipo == 'insertar')
  {
    $info = new crud();

    $result_f = $info->agregar_proveedor($nombre,$telefono,$cel,$email,$direccion,$departamento,$municipio,$pais,$contacto,$iva,$nit,$giro,$dgii,$estadop);

    echo $result_f;
  }
  else if  ($tipo == 'modificar')
  {
    $info = new crud();

    $result_f = $info->modificar_proveedor($codigo,$nombre,$telefono,$cel,$email,$direccion,$departamento,$municipio,$pais,$contacto,$iva,$nit,$giro,$dgii,$estadop);

    echo $result_f;

  }


}

if ($estado == 'guardarmod_cliente') 
{
  $estadop =  $_POST['estadop'];
  $tipo =  $_POST['tipo'];
  $codigo =  $_POST['codigo'];
  $nombre =  $_POST['nombre'];
  $apellido =  $_POST['apellido'];
  $empresa=  $_POST['empresa'];
  $email =  $_POST['email'];
  $dui =  $_POST['dui'];
  $telefono =  $_POST['telefono'];
  $cumple =  $_POST['cumple'];
  $com =  $_POST['com'];
  $notas =  $_POST['notas'];
  
  $info = new crud();

  $result_z = $info-> existe_dui_cliente($dui);


  if ($tipo == 'insertar')
  {
    if ($result_z[0] == 0)  
    {
    $result_f = $info->agregar_cliente($nombre,$apellido,$empresa,$email,$dui,$estadop,$telefono,$cumple,$com,$notas);

    echo $result_f;
  }
  else
  {
    $result_f = "Repetido";
    echo $result_f;
  }
  }
  else if  ($tipo == 'modificar')
  {
    $result_f = $info->modificar_cliente($codigo,$nombre,$apellido,$empresa,$email,$dui,$estadop,$telefono,$cumple,$com,$notas);

    echo $result_f;

  }



}

if ($estado == 'guardarmod_ingrediente') 
{
  $tipo =  $_POST['tipo'];
  $estadoi =  $_POST['estadoi'];
  $nombre =  $_POST['nombre'];
  $unidad =  $_POST['unidad'];
  $ingreid =  $_POST['ingreid'];
  $costoingre =  $_POST['costingre'];
  $cantelegible =  $_POST['cantelegible'];
  
  $info = new crud();

  $result_z = $info-> existe_ingrediente($nombre);


  if ($tipo == 'insertar')
  {
    //quita el error de comerse los IDS
  if ($result_z[0] == 0)  
  {
    $result_f = $info->agregar_ingrediente($estadoi,$nombre,$unidad,$costoingre,$cantelegible);

    echo $result_f;
  }
  else
  {
    $result_f = "Repetido";
    echo $result_f;
  }
  }
  else if  ($tipo == 'modificar')
  {
    $result_f = $info->modificar_ingrediente($estadoi,$nombre,$unidad,$ingreid,$costoingre,$cantelegible);

    echo $result_f;

  }

 // echo $result_z[0];
}

if ($estado == 'borrar_proveedor') {
  $provid = $_POST['provid'];

  $info = new crud();

  $result_f = $info->borrar_proveedor($provid);

  echo $result_f;
}

if ($estado == 'borrar_producto') {
  $prodid = $_POST['prodid'];

  $info = new crud();

  $result_f = $info->borrar_producto($prodid);

  echo $result_f;
}

if ($estado == 'borrar_cliente') {
  $clienteid = $_POST['clienteid'];

  $info = new crud();

  $result_f = $info->borrar_cliente($clienteid);

  echo $result_f;
}


if ($estado == 'borrar_ingrediente') {
  $ingreid = $_POST['ingreid'];

  $info = new crud();

  $result_g = $info->uso_ingrediente($ingreid);

  if ($result_g[0] == 0)
  {
    $result_f = $info->borrar_ingrediente($ingreid);
    echo $result_f;
  }
  else
  {
    echo 99;
  } 
}


if ($estado == 'agregar_mesa') 
{
    $mesa = $_POST['mesa'];
    $zona = $_POST['zona'];
    
    $info = new crud();

    $result_f = $info->agregar_mesa_zona($mesa,$zona);
  
    echo $result_f;
}


if ($estado == 'quitar_mesa') 
{
    $mesa = $_POST['mesa'];
        
    $info = new crud();

    $result_f = $info->quitar_mesa_zona($mesa);
  
    echo $result_f;
}

if ($estado == 'guardar_cantzonas') 
{
    $zonas= $_POST['zonas'];
    
    $info = new crud();

    $result_f = $info->guardar_cantzonas($zonas);
  
    echo $result_f;
}

if ($estado == 'guardar_cantmesas') 
{
    $mesas= $_POST['mesas'];
    
    $info = new crud();

    $result_f = $info->guardar_cantmesas($mesas);
  
    echo $result_f;
}

if ($estado == 'get_iva') 
{
  // hace todos los calculos, si el iva es diferente al del menu principal no usarlo
    $precio = $_POST['precio'];
    //$porcpropina = $_POST['porcpropina'];
    $porcmanto = $_POST['porcmanto'];
    $porcganancia = $_POST['porcganancia'];

    $acummanto = '';
    $acumganancia = '';
    //$acumpropina = '';
    $acumiva = '';
 

    // agregando manto
    $acummanto = $precio + $precio*($porcmanto/100);
    // agregando ganancia
    $acumganancia = $acummanto + $acummanto*($porcganancia/100);
    // agregando propina si lleva
    // lo quite por que Vidal dijo que solo el checkbox esto al momento de facturar se le agrega
    // $acumpropina = ($acumganancia + ($acumganancia*$porcpropina)/100);
    // agregando iva
    
     $info = new crud();

     $result_f = $info->get_iva();
 
     $resultado_log = [];

    //$resultado_log[0] = round(($acumpropina + ($acumpropina*$result_f[0])/100),2) ;
     // mas iva
     $acumiva = $acumganancia  + $acumganancia *(number_format($result_f[0])/100);


     $resultado_log[0] = $acumiva;

     
    echo json_encode($resultado_log);
   
}

if ($estado == 'guardar_unidad') 
{
    $unidad = $_POST['unidad'];
    
    $info = new crud();

    $result_f = $info->guardar_unidad($unidad);
  
    echo $result_f;
}

if ($estado == 'borrar_unidad') {
  $unidad = $_POST['unidad'];

  $info = new crud();

  $result_f = $info->borrar_unidad($unidad);

  echo $result_f;
}

if ($estado == 'guardar_categoria') 
{
    $cat = $_POST['cat'];
    $filecat = $_POST['filecat'];
    
    $info = new crud();

    $result_f = $info->guardar_categoria($cat,$filecat);
  
    echo $result_f;
}

if ($estado == 'borrar_categoria') {
  $cat = $_POST['cat'];

  $info = new crud();

  $result_f = $info->borrar_categoria($cat);

  echo $result_f;
}

if ($estado == 'modificar_categoria') {
  $cat = $_POST['cat'];
  $nuevon = $_POST['nuevon'];

  $info = new crud();

  $anterior = $info->get_productoanterior($cat);

  $result_f = $info->modificar_categoria($cat,$nuevon,$anterior[0]);

  echo $result_f;
}

if ($estado == 'modificar_subcategoria') {
  $cat = $_POST['cat'];
  $nuevon = $_POST['nuevon'];

  $info = new crud();

  $anterior = $info->get_subproductoanterior($cat);

  $result_f = $info->modificar_subcategoria($cat,$nuevon,$anterior[0]);

  echo $result_f;
}

if ($estado == 'modificar_unidad') {
  $idunidad = $_POST['idunidad'];
  $nuevounidad = $_POST['nuevounidad'];

  $info = new crud();

  $anterior = $info->get_unidadanterior($idunidad);

  $result_f = $info->modificar_unidad($idunidad,$nuevounidad,$anterior[0]);

  echo $result_f;
}

if ($estado == 'guardar_scategoria') 
{
    $scat = $_POST['scat'];
    
    $info = new crud();

    $result_f = $info->guardar_scategoria($scat);
  
    echo $result_f;
}

if ($estado == 'borrar_scategoria') {
  $scat = $_POST['scat'];

  $info = new crud();

  $result_f = $info->borrar_scategoria($scat);

  echo $result_f;
}

if ($estado == 'guardarmod_producto') 
{
  $estadopr = $_POST['estadopr'];
  $tipo = $_POST['tipo'];
  $codprod = $_POST['codprod'];
  $filename1 = $_POST['filename1'];
  $producto = $_POST['producto'];
  $precio = $_POST['precio'];
  $iva = $_POST['iva'];
  $categoria = $_POST['categoria'];
  $scategoria = $_POST['scategoria'];
  $desc = $_POST['desc'];
  $lunes = $_POST['lunes'];
  $martes = $_POST['martes'];
  $miercoles = $_POST['miercoles'];
  $jueves = $_POST['jueves'];
  $viernes = $_POST['viernes'];
  $sabado = $_POST['sabado'];
  $domingo = $_POST['domingo'];
  $fdesde = $_POST['fdesde'];
  $fhasta = $_POST['fhasta'];
  $mdesde = $_POST['mdesde'];
  $mhasta = $_POST['mhasta'];
  $servicio = $_POST['servicio'];
  //
  $propina = $_POST['propina'];
  $porcmanto = $_POST['porcmanto'];
  $porcganancia = $_POST['porcganancia'];
  //
  $notaoblig = $_POST['notaoblig'];
  $preguntas = $_POST['preguntas'];
  $respuestas = $_POST['respuestas'];

  // INGREDIENTES Y PRODUCTOS COMPUESTOS QUE IRAN DE LA MANO DEL PRODUCTO
  // PRODUCTO NO ES OBLIGATORIO POR QUE PUEDE SER SIMPLE
  $tingredientes = $_POST['tingredientes'];
  $tproductos = $_POST['tproductos'];
  $producto_id = '';
  $insertIng = '';
  $insertProd = '';

  if ($tipo == 'insertar')
  {

  $info = new crud();

  // INSERTAR LO GENERAL DEL PROD
  $result_z = $info-> existe_producto($producto);
  
  if ($result_z[0] == 0)
  {
  $result_f = $info->guardar_producto($estadopr,$filename1,$producto,$precio,$iva,$categoria,$scategoria,$desc,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$fdesde,$fhasta,$mdesde,$mhasta,$servicio,$propina,$porcmanto,$porcganancia,$notaoblig,$preguntas,$respuestas);
  }
  else
  {
    //ya existe
    $result_f = '999';
  }
  // RETORNAR ID DEL PROD CREADO
  if ($result_f == 0)
  {
    //el id recien creado
    $result_y = $info-> get_producto_id($producto);

    foreach ($result_y as $row)
    {   
    $producto_id =  $row['PRODUCTO_ID'];
    }
    

  //CREAR INGREDIENTES REF > PROD ID
  //crear cadena de ingredientes
  
  foreach ($tingredientes as [$a, $b, $c, $d, $e]) {
   $insertIng .= "('" .  $producto_id . "','" . $a . "','" . $c . "','" . $e . "'),";
  }
   
  $insertIng = substr_replace($insertIng ,"",-1);
  
  $result_g = $info->asociar_ingredientes($insertIng);

  //CREAR PRODUCTO REF > SUB PROD ID

  if ($tproductos != '') // guardar producto combinado
  {
     foreach ($tproductos as [$a, $b, $c, $d, $e, $f]) {
      $insertProd .= "('" .  $producto_id . "','" . $a . "','" . $d . "'),";
     }

     $insertProd= substr_replace($insertProd ,"",-1);

     $result_p = $info->asociar_productos($insertProd);

  }

  }
  ///  echo $result_g;
  echo $result_z[0];
  } // hasta aqui insertar

  if ($tipo == 'modificar')
  {
    $info = new crud();

    $result_z = $info-> existe_producto($producto);

    if ($result_z[0] >= 2)
    {
            //ya existe
            $result_f = '999';
    }
    else
    {
      if ($filename1 == 'no')
      {
        //guardar sin attachment por cod prod, hacerdelete antes de guardar
        $result_f = $info->mod_producto_noattach($codprod,$estadopr,$producto,$precio,$iva,$categoria,$scategoria,$desc,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$fdesde,$fhasta,$mdesde,$mhasta,$servicio,$propina,$porcmanto,$porcganancia,$notaoblig,$preguntas,$respuestas);
      }
      else
      {
        //guardar con attachment por cod prod, hacerdelete antes de guardar
        $result_f = $info->mod_producto_attach($codprod,$estadopr,$filename1,$producto,$precio,$iva,$categoria,$scategoria,$desc,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$fdesde,$fhasta,$mdesde,$mhasta,$servicio,$propina,$porcmanto,$porcganancia,$notaoblig,$preguntas,$respuestas);
      }
    }

    
    foreach ($tingredientes as [$a, $b, $c, $d, $e]) {
      $insertIng .= "('" .  $codprod . "','" . $a . "','" . $c . "','" . $e . "'),";
     }
      
     $insertIng = substr_replace($insertIng ,"",-1);
     
     $result_g = $info->asociar_ingredientes($insertIng);
   
     //CREAR PRODUCTO REF > SUB PROD ID
   
     if ($tproductos != '') // guardar producto combinado
     {
        foreach ($tproductos as [$a, $b, $c, $d, $e, $f]) {
         $insertProd .= "('" .  $codprod . "','" . $a . "','" . $d . "'),";
        }
   
        $insertProd= substr_replace($insertProd ,"",-1);
   
        $result_p = $info->asociar_productos($insertProd);
    }
    
    echo $result_g;

  }  


 
  

}

if ($estado == 'guardar_empresa') 
{
    $codempresa = $_POST['codempresa'];  
    $nomcomercial = $_POST['nomcomercial'];  
    $razonsocial = $_POST['razonsocial'];  
    $dir = $_POST['dir'];  
    $nit = $_POST['nit'];  
    $iva = $_POST['iva'];  
    $giro = $_POST['giro'];  
    $caja = $_POST['caja'];  
    $mensaje = $_POST['mensaje'];  
    $correonoti = $_POST['correonoti'];  
    $correonoticc = $_POST['correonoticc'];  

    $info = new crud();

    $result_f = $info->guardar_empresa($codempresa, $nomcomercial, $razonsocial, $dir, $nit, $iva, $giro, $caja, $mensaje, $correonoti, $correonoticc);
  
    echo $result_f;
}

if ($estado == 'guardar_iva') 
{
    $ivaprod = $_POST['ivaprod'];  
    
    $info = new crud();

    $result_f = $info->guardar_iva($ivaprod);
  
    echo $result_f;
}

if ($estado == 'guardar_propina') 
{
    $ivaprod = $_POST['ivaprod'];  
    
    $info = new crud();

    $result_f = $info->guardar_propina($ivaprod);
  
    echo $result_f;
}

if ($estado == 'guardar_bloqueomesa') 
{
    $bloqueo = $_POST['bloqueo'];  
    
    $info = new crud();

    $result_f = $info->guardar_bloqueomesa($bloqueo);
  
    echo $result_f;
}

if ($estado == 'refresh_mesa') 
{
    $refreshmesa = $_POST['refreshmesa'];  
    
    $info = new crud();

    $result_f = $info->guardar_refreshmesa($refreshmesa);
  
    echo $result_f;
}

if ($estado == 'refresh_bar') 
{
    $refreshbar = $_POST['refreshbar'];  
    
    $info = new crud();

    $result_f = $info->guardar_refreshbar($refreshbar);
  
    echo $result_f;
}

if ($estado == 'refresh_cocina') 
{
    $refreshcocina = $_POST['refreshcocina'];  
    
    $info = new crud();

    $result_f = $info->guardar_refreshcocina($refreshcocina);
  
    echo $result_f;
}

if ($estado == 'max_bar') 
{
    $tmaxbar = $_POST['tmaxbar'];  
    
    $info = new crud();

    $result_f = $info->guardar_maxbar($tmaxbar);
  
    echo $result_f;
}

if ($estado == 'max_cocina') 
{
    $tmaxcocina = $_POST['tmaxcocina'];  
    
    $info = new crud();

    $result_f = $info->guardar_maxcocina($tmaxcocina);
  
    echo $result_f;
}


if ($estado == 'guardar_area_zona') 
{
    $area = $_POST['area'];  
    $zona = $_POST['zona'];  
    
    $info = new crud();

    $result_f = $info->guardar_area_zona($area,$zona);
  
    echo $result_f;
}

if ($estado == 'borrar_area_zona') 
{
    $zona = $_POST['zona'];  
    
    $info = new crud();

    $result_f = $info->borrar_area_zona($zona);
  
    echo $result_f;
}

if ($estado == 'adquirir_azonas1') 
{
    $area = [];
    $zona = [];
    $todo = [];
    $result = [];
   
    $info = new crud();

    $result_f = $info->adquirir_azonas();

    $i = 0;
    $j = 0;
    foreach ($result_f as $row)
    {   
      $area[$i] =  $row['AREA'];
      $zona[$i] =  $row['ZONA'];
      $i++;
    }

    $todo[0] = $area;
    $todo[1] = $zona;

  
    echo json_encode($todo);
}


?>