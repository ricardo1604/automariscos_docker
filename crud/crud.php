<?php

class crud
{
    public function validar_contra($u1, $p1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = '" . $u1 . "' AND password = '" . $p1 . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
       // mysqli_query($conexion, $sql);
       // return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function validar_contra_comanda($u1, $p1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = '" . $u1 . "' AND password = '" . $p1 . "' AND ROL = 'MESERO';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
       // mysqli_query($conexion, $sql);
       // return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function validar_contra_comanda2($u1, $p1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = '" . $u1 . "' AND password = '" . $p1 . "' AND ROL <> 'MESERO';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
       // mysqli_query($conexion, $sql);
       // return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function opciones_usuario($u1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT nombre as NOMBRE, icono as ICONO, funcion as FUNCION, titulo as TITULO FROM vista_accesos_usuarios WHERE usuario = '" . $u1 . "' order by opcion_id asc;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fondo_usuario($u1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT FONDO FROM usuarios WHERE usuario = '" . $u1 . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function grid_usuarios()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT USUARIO_ID, USUARIO, NOMBRE, ESTADO, ROL, META, COMISION_VENTA, COMISION_PROPINA, FONDO FROM usuarios order by usuario_id asc;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_roles()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT nombrerol, rol_id FROM roles_fijos;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    
    public function grid_usuarios_buscar($buscar)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT USUARIO_ID, USUARIO, NOMBRE, ESTADO, ROL, META, COMISION_VENTA, COMISION_PROPINA, FONDO FROM usuarios WHERE USUARIO like  '%" . $buscar . "%' order by usuario_id asc;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_privilegios($u, $priv)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT a.VER as VER, a.MODIFICAR as MODIFICAR, a.BORRAR as BORRAR, a.PRECUENTA AS PRECUENTA,a.SEPARAR AS SEPARAR,a.CORTESIA AS CORTESIA,a.IMPRIMIR AS IMPRIMIR FROM usuarios_privilegios a, usuarios b WHERE a.USUARIO_ID = b.USUARIO_ID AND b.USUARIO = '" . $u . "' AND a.PRIV_ID = '" . $priv . "';";
        //$resultado = mysqli_query($conexion, $sql);
        //return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        $resultado = mysqli_query($conexion, $sql);
        if ($resultado === false) {
            die(
                "SQL ERROR get_privilegios(): " . mysqli_error($conexion) .
                "\nSQL: " . $sql
            );
        }

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);  
        mysqli_close($conexion);
    }

    public function agregar_usuario($usuario, $password, $nombre, $meta, $COMISION_VENTA, $rol, $comisionp, $fondo)
    {
        date_default_timezone_set('America/El_Salvador');
        $fecha = date('Y-m-d H:i:s');

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO usuarios (USUARIO,PASSWORD,NOMBRE,META,ROL,COMISION_VENTA,ESTADO,FECHA_CREACION,COMISION_PROPINA,FONDO) 
        VALUES ('" . strtoupper($usuario) . "',SHA('" . strtoupper($password) . "'), '"
         . strtoupper($nombre) . "','" . strtoupper($meta) . "','" . strtoupper($rol) . "','" . strtoupper($COMISION_VENTA) . "','ACTIVO','" . $fecha . "','" . strtoupper($comisionp) . "','" . $fondo . "');";
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function borrar_usuario($usuarioid)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM usuarios WHERE usuario_id = '" . $usuarioid . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function modificar_usuario($usuarioid, $password, $nombre, $estadouser, $meta, $COMISION_VENTA, $rol, $comisionp, $fondo, $zonas)
    {
        $zonaValues = array();
         
        //son 10 asi que rellenar las vacias
        for ($i = 0; $i <= 9; $i++) {
           if($zonas[$i] == '')
           {
            $zonaValues[$i] = 'false';
           }
           else
           {
            $zonaValues[$i] = $zonas[$i];
           }
         }


        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($password != ''){
           $sql = "UPDATE usuarios SET PASSWORD = SHA('" . strtoupper($password) . "'), ROL = '" . strtoupper($rol) . "', NOMBRE  = '" . strtoupper($nombre) . "', ESTADO = '" . strtoupper($estadouser) . "', META = '" . $meta . "', COMISION_VENTA = '" . $COMISION_VENTA . "', COMISION_PROPINA = '" . $comisionp . "', FONDO = '" . $fondo . "'   WHERE USUARIO_ID =  '" . $usuarioid . "';";
        }
        else
        {
           $sql = "UPDATE usuarios SET ROL = '" . strtoupper($rol) . "', NOMBRE  = '" . strtoupper($nombre) . "', ESTADO = '" . strtoupper($estadouser) . "', META = '" . $meta . "', COMISION_VENTA = '" . $COMISION_VENTA . "', COMISION_PROPINA = '" . $comisionp . "', FONDO = '" . $fondo . "', ZONA1 = '" . $zonaValues[0]  . "', ZONA2 = '" . $zonaValues[1]  . "', ZONA3 = '" . $zonaValues[2]  . "', ZONA4 = '" . $zonaValues[3]  . "', ZONA5 = '" . $zonaValues[4]  . "', ZONA6 = '" . $zonaValues[5]  . "', ZONA7 = '" . $zonaValues[6]  . "', ZONA8 = '" . $zonaValues[7]  . "', ZONA9 = '" . $zonaValues[8]  . "', ZONA10 = '" . $zonaValues[9]  . "'  WHERE USUARIO_ID =  '" . $usuarioid . "';";   
        }
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    //roles
    public function borrar_rol($rol)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM roles_fijos WHERE rol_id = '" . $rol . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function agregar_rol($rol)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO roles_fijos (NOMBREROL) VALUES ('" . strtoupper($rol) . "');";
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function modificar_rol($rolnombre, $rol)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE roles_fijos SET NOMBREROL = '" . strtoupper($rolnombre) . "'  WHERE ROL_ID =  '" . $rol . "';";   
 
 
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    // MENU DE GRUPOS
    public function get_grupos()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT GRUPO_ID, GRUPO_NOMBRE FROM grupos_accesos ORDER BY GRUPO_ID ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_grupo($buscar)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT GRUPO_ID, GRUPO_NOMBRE FROM grupos_accesos WHERE GRUPO_NOMBRE LIKE '%" . $buscar . "%' ORDER BY GRUPO_ID ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    //grupos
    
    public function agregar_grupo($grupo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO grupos_accesos (GRUPO_NOMBRE) VALUES ('" . strtoupper($grupo) . "');";
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function borrar_grupo($grupo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  

        $sql = "DELETE FROM usuarios_asignaciones WHERE GRUPO_ID = '" . $grupo . "';";
        mysqli_query($conexion, $sql);

        $sql = "DELETE FROM roles WHERE GRUPO_ID = '" . $grupo . "';";
        mysqli_query($conexion, $sql);


        $sql = "DELETE FROM grupos_accesos WHERE GRUPO_ID = '" . $grupo . "';";
        mysqli_query($conexion, $sql);

        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function modificar_grupo($grupo,$id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE grupos_accesos SET GRUPO_NOMBRE = '" . strtoupper($grupo) . "'  WHERE GRUPO_ID =  '" . $id . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function buscar_grupo_opciones($grupo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT OPCION_ID AS OPCION_ID, NOMBRE AS NOMBRE FROM vista_grupo_opcion WHERE GRUPO_NOMBRE = '" . $grupo . "' ORDER BY OPCION_ID ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_opciones($grupo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT OPCION_ID,  NOMBRE  FROM opciones_menu ORDER BY OPCION_ID ASC;";
        $sql = " SELECT d.nombre as NOMBRE, d.opcion_id as OPCION_ID FROM (
            SELECT opcion_id as OPCION_ID, nombre as NOMBRE FROM vista_grupo_opcion WHERE grupo_nombre = '" . $grupo . "') A
            RIGHT JOIN opciones_menu d ON a.OPCION_ID = d.opcion_id
            WHERE a.nombre IS NULL"; 
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function agregar_opcion($grupo,$idfinal)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = " INSERT INTO roles (grupo_id, opcion_id) VALUES ((SELECT grupo_id FROM grupos_Accesos WHERE grupo_nombre = '" . $grupo . "'),'" . $idfinal . "');";
        mysqli_query($conexion, $sql);
        
        $sql = "SELECT grupo_id FROM grupos_Accesos WHERE grupo_nombre = '" . $grupo . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function quitar_opcion($grupo,$idfinal)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM roles where GRUPO_ID = CAST((SELECT grupo_id FROM grupos_Accesos WHERE grupo_nombre = '" . $grupo . "') AS UNSIGNED)  AND OPCION_ID = '" . $idfinal . "';";
        mysqli_query($conexion, $sql);
        
        $sql = "SELECT grupo_id FROM grupos_Accesos WHERE grupo_nombre = '" . $grupo . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function buscar_grupo_usuario($usuariob)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT GRUPO_ID AS GRUPO_ID, GRUPO_NOMBRE AS GRUPO_NOMBRE, USUARIO_ID AS USUARIO_ID, USUARIO AS USUARIO FROM vista_grupo_usuarios WHERE USUARIO = '" . $usuariob . "' ORDER BY USUARIO_ID ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    // busca el user name con el user id
    public function buscar_grupo_usuarioa($usuariob)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT USUARIO FROM usuarios WHERE USUARIO_ID = '" . $usuariob . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_grupos_filtrados($usuariob)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT b.grupo_id as GRUPO_ID, b.grupo_nombre AS GRUPO_NOMBRE FROM 
        (SELECT a.grupo_id, grupo_nombre, a.usuario_id, a.usuario 
        FROM vista_grupo_usuarios a WHERE a.usuario_id = '" . $usuariob . "') A
        RIGHT JOIN grupos_accesos b ON a.grupo_id = b.grupo_id
        WHERE a.grupo_id IS NULL ORDER BY b.grupo_id ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function quitar_grupo($userid,$grupo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM usuarios_asignaciones where GRUPO_ID = '" . $grupo . "' AND USUARIO_ID = '" . $userid . "';";
        mysqli_query($conexion, $sql);

        // quitar privilegios de fabrica
        $sql = "DELETE FROM usuarios_privilegios WHERE grupo_id = '" . $grupo . "' AND usuario_id = '" . $userid . "';";
        mysqli_query($conexion, $sql);

         // quitar privilegios MISC O AGREGADOS
        $sql = "DELETE FROM usuarios_privilegios WHERE grupo_id = '8' AND usuario_id = '" . $userid . "';";
        mysqli_query($conexion, $sql);

        
        $sql = "SELECT USUARIO_ID FROM usuarios WHERE USUARIO_ID = '" . $userid . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    
    public function agregar_grupod($userid,$grupo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO usuarios_asignaciones (usuario_id,grupo_id) VALUES ('" . $userid . "','" . $grupo . "');";
        mysqli_query($conexion, $sql);

        // agregar privilegios de fabrica
        $sql = "INSERT INTO usuarios_privilegios (priv_id,usuario_id,grupo_id) SELECT priv_id,'" . $userid . "','" . $grupo . "' FROM privilegios WHERE opcion_id IN (SELECT opcion_id FROM roles WHERE grupo_id = '" . $grupo . "');" ;
        mysqli_query($conexion, $sql);

        $sql = "SELECT USUARIO_ID FROM usuarios WHERE USUARIO_ID = '" . $userid . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }


    public function buscar_usuario_privilegio($usuariob)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT grupo_id AS GRUPO_ID,grupo_nombre AS GRUPO_NOMBRE, priv_id as PRIV_ID,privilegio as PRIVILEGIO, ver AS VER, modificar AS MODIFICAR, borrar AS BORRAR, imprimir AS IMPRIMIR, cortesia AS CORTESIA, precuenta AS PRECUENTA, separar AS SEPARAR FROM vista_privilegios WHERE USUARIO_ID = '" . $usuariob . "' ORDER BY GRUPO_ID, PRIV_ID ASC;"; 
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_privilegios_filtrados($usuariob)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT priv_id AS PRIV_ID, privilegio AS PRIVILEGIO FROM privilegios WHERE priv_id NOT IN (SELECT priv_id FROM usuarios_privilegios WHERE usuario_id = '" . $usuariob . "');";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function agregar_privlectura($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET VER = '1'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privlectura($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET VER = '0'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_subingrediente($idparent, $idchild)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM ingredientes_sub WHERE id_ingrediente = '" . $idparent . "'  AND id_sub = '" . $idchild . "' ;";

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_subingrediente($idparent, $idchild)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO ingredientes_sub (id_ingrediente,id_sub) VALUES ('" . $idparent . "','" . $idchild . "');";

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_privescritura($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET MODIFICAR = '1'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privescritura($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET MODIFICAR = '0'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_privborrar($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET BORRAR = '1'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privborrar($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET BORRAR = '0'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_privimprimir($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET IMPRIMIR = '1'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privimprimir($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET IMPRIMIR = '0'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_privcortesia($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET CORTESIA = '1'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privcortesia($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET CORTESIA = '0'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_privprecuenta($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET PRECUENTA = '1'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privprecuenta($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET PRECUENTA = '0'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_privseparar($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET SEPARAR = '1'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privseparar($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE usuarios_privilegios SET SEPARAR = '0'  WHERE PRIV_ID =  '" . $priv_id . "' AND USUARIO_ID =  '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_privop($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO usuarios_privilegios (GRUPO_ID,PRIV_ID,USUARIO_ID) VALUES ('8','" . $priv_id . "','" . $usuario . "');"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_privop($usuario, $priv_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM usuarios_privilegios WHERE PRIV_ID = '" . $priv_id . "' AND USUARIO_ID = '" . $usuario . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }


    public function buscar_departamentos()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT DEPARTAMENTO FROM localizacion ORDER BY DEPARTAMENTO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_municipios($departamento)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT MUNICIPIO FROM localizacion WHERE DEPARTAMENTO = '" . $departamento . "'  ORDER BY MUNICIPIO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function listado_proveedores()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PROVEEDOR_ID, NOMBRE, TELEFONO, CELULAR, CORREO, DIRECCION, DEPARTAMENTO, MUNICIPIO, PAIS, CONTACTOS, REG_IVA, NIT, GIRO, CLASIFICACION_DGII, ESTADO FROM proveedores;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_proveedor($proveedor)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PROVEEDOR_ID, NOMBRE, TELEFONO, CELULAR, CORREO, DIRECCION, DEPARTAMENTO, MUNICIPIO, PAIS, CONTACTOS, REG_IVA, NIT, GIRO, CLASIFICACION_DGII, ESTADO FROM proveedores WHERE PROVEEDOR_ID = '" . $proveedor . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_cliente($clienteid)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CLIENTE_ID, NOMBRES, APELLIDOS, EMPRESA, DUI, CORREO, ESTADO, TELEFONO, FECHA_CUMPLEANOS, FECHA_CONMEMORATIVA, NOTAS FROM clientes WHERE CLIENTE_ID = '" . $clienteid . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_cliente_delinea($dui)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT CONCAT(NOMBRES,' ',APELLIDOS) AS NOMBRES FROM clientes WHERE DUI = '" . $dui . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_ingrediente($ingre)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT INGREDIENTE_ID, INGREDIENTE, UNIDAD, ESTADO, ROUND(COSTO,3) AS COSTO, CANTIDAD_ELEGIBLE FROM ingredientes WHERE INGREDIENTE_ID = '" . $ingre . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_proveedor_nombre($proveedor)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PROVEEDOR_ID, NOMBRE, TELEFONO, CELULAR, CORREO, DIRECCION, DEPARTAMENTO, MUNICIPIO, PAIS, CONTACTOS, REG_IVA, NIT, GIRO, CLASIFICACION_DGII, ESTADO FROM proveedores WHERE NOMBRE = '" . $proveedor . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function listado_clientes()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

   
       $sql = "SELECT CLIENTE_ID, NOMBRES, APELLIDOS, EMPRESA, DUI, CORREO, ESTADO, TELEFONO, DATE_FORMAT(FECHA_CUMPLEANOS,'%d/%m/%Y') as FECHA_CUMPLEANOS  ,  DATE_FORMAT(FECHA_CONMEMORATIVA,'%d/%m/%Y') as FECHA_CONMEMORATIVA, NOTAS FROM clientes";

       $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function global_mesas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ZONAS, mesas FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_cantzonas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ZONAS FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_allzonas($id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ZONA1, ZONA2, ZONA3, ZONA4, ZONA5, ZONA6, ZONA7, ZONA8, ZONA9, ZONA10  FROM usuarios WHERE USUARIO_ID =  '" . $id . "' ";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }
    
    

    public function get_iva()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT round(IVA,2) as IVA FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_propina()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT round(propina,2) as PROPINA FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_bloqueomesa()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT round(BLOQUEO_COMANDA,0) as BLOQUEO_COMANDA FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_refreshmesa()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT round(REFRESCAR_COMANDA,0) as REFRESCAR_COMANDA FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_cover()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COVER FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_consumo()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONSUMO FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_estado_cover_cm()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADOCOVER, ESTADOCONSUMO, CLUNES, CMARTES, CMIERCOLES, CJUEVES, CVIERNES, CSABADO, CDOMINGO, CHORAINI, CHORAFIN, CMLUNES, CMMARTES, CMMIERCOLES, CMJUEVES, CMVIERNES, CMSABADO, CMDOMINGO, CMHORAINI, CMHORAFIN FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function guardar_cover($ecover,$cover,$cdiasLu,$cdiasMa,$cdiasMi,$cdiasJu,$cdiasVi,$cdiasSa,$cdiasDo,$cdesdem,$chastam)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET ESTADOCOVER = '" . $ecover . "', COVER = '" . $cover . "', CLUNES = '" . $cdiasLu . "', CMARTES = '" . $cdiasMa . "', CMIERCOLES = '" . $cdiasMi . "', CJUEVES = '" . $cdiasJu . "', CVIERNES = '" . $cdiasVi . "', CSABADO = '" . $cdiasSa . "', CDOMINGO = '" . $cdiasDo . "', CHORAINI = '" . $cdesdem . "', CHORAFIN = '" . $chastam . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function guardar_consumo($econsumo,$consumo,$cmdiasLu,$cmdiasMa,$cmdiasMi,$cmdiasJu,$cmdiasVi,$cmdiasSa,$cmdiasDo,$cmdesdem,$cmhastam)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET ESTADOCONSUMO = '" . $econsumo . "', CONSUMO = '" . $consumo . "', CMLUNES = '" . $cmdiasLu . "', CMMARTES = '" . $cmdiasMa . "', CMMIERCOLES = '" . $cmdiasMi . "', CMJUEVES = '" . $cmdiasJu . "', CMVIERNES = '" . $cmdiasVi . "', CMSABADO = '" . $cmdiasSa . "', CMDOMINGO = '" . $cmdiasDo . "', CMHORAINI = '" . $cmdesdem . "', CMHORAFIN = '" . $cmhastam . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function lleva_cover()
    {
        date_default_timezone_set('America/El_Salvador');
        
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COVER, CLUNES, CMARTES, CMIERCOLES, CJUEVES, CVIERNES, CSABADO, CDOMINGO, ESTADOCOVER FROM globales
        WHERE
          (choraini > chorafin AND (TIME(NOW()) >= choraini OR TIME(NOW()) <= chorafin))
          OR
          (choraini <= chorafin AND TIME(NOW()) BETWEEN choraini AND chorafin);";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function lleva_consumo()
    {
        date_default_timezone_set('America/El_Salvador');
       
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONSUMO, CMLUNES, CMMARTES, CMMIERCOLES, CMJUEVES, CMVIERNES, CMSABADO, CMDOMINGO, ESTADOCONSUMO
        FROM globales
        WHERE
          (cMhoraini > cMhorafin AND (TIME(NOW()) >= cMhoraini OR TIME(NOW()) <= cMhorafin))
          OR
          (cMhoraini <= cMhorafin AND TIME(NOW()) BETWEEN cMhoraini AND cMhorafin);";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_mantenimiento()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT round(mantenimiento,2) as MANTENIMIENTO FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_ganancia()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT round(ganancia,2) as GANANCIA FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function listado_mesas($zona)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT MESA FROM mesas WHERE ZONA = '" . $zona . "' ORDER BY MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function listado_mesas_all()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT MESA FROM mesas ORDER BY MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function listado_ingredientes()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT INGREDIENTE_ID, INGREDIENTE, UNIDAD, ESTADO, ROUND(COSTO,3) AS COSTO FROM ingredientes ORDER BY INGREDIENTE_ID ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function listado_ingredientesv2($ingre)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT INGREDIENTE_ID, INGREDIENTE, UNIDAD, ESTADO, ROUND(COSTO,3) AS COSTO FROM ingredientes WHERE INGREDIENTE_ID not in ('" . $ingre . "') ORDER BY INGREDIENTE_ID ASC;";
        $sql = "SELECT INGREDIENTE_ID, INGREDIENTE, UNIDAD, ESTADO, ROUND(COSTO,3) AS COSTO FROM ingredientes WHERE INGREDIENTE_ID NOT IN ('" . $ingre . "') AND INGREDIENTE_ID NOT IN (SELECT ID_SUB FROM ingredientes_sub WHERE ID_INGREDIENTE = '" . $ingre . "') ORDER BY INGREDIENTE_ID ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }



    public function listado_ingredientesv3($ingre)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT a.id_sub as INGREDIENTE_ID, b.ingrediente as INGREDIENTE, b.unidad as UNIDAD FROM ingredientes_sub a, ingredientes b WHERE a.id_sub = b.ingrediente_id AND a.id_ingrediente in ('" . $ingre . "');";
        
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function agregar_proveedor($nombre,$telefono,$cel,$email,$direccion,$departamento,$municipio,$pais,$contacto,$iva,$nit,$giro,$dgii,$estadop)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO proveedores (NOMBRE,TELEFONO,CELULAR,CORREO,DIRECCION,DEPARTAMENTO,MUNICIPIO,PAIS,CONTACTOS,REG_IVA,NIT,GIRO,CLASIFICACION_DGII,ESTADO) VALUES ('" . $nombre . "','" . $telefono . "','" . $cel . "','" . $email . "','" . $direccion . "','" . $departamento . "','" . $municipio . "','" . $pais . "','" . $contacto . "','" . $iva . "','" . $nit . "','" . $giro . "','" . $dgii . "','" . $estadop . "');"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function modificar_proveedor($codigo,$nombre,$telefono,$cel,$email,$direccion,$departamento,$municipio,$pais,$contacto,$iva,$nit,$giro,$dgii,$estadop)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE proveedores SET NOMBRE = '" . $nombre . "', TELEFONO = '" . $telefono . "', CELULAR = '" . $cel . "' ,CORREO = '" . $email . "' ,DIRECCION = '" . $direccion . "' ,DEPARTAMENTO = '" . $departamento . "' , MUNICIPIO = '" . $municipio . "' ,PAIS = '" . $pais . "',CONTACTOS = '" . $contacto . "' ,REG_IVA = '" . $iva . "' ,NIT = '" . $nit . "',GIRO = '" . $giro . "' , CLASIFICACION_DGII = '" . $dgii . "',ESTADO = '" . $estadop . "' WHERE PROVEEDOR_ID = '" . $codigo . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function agregar_cliente($nombre,$apellido,$empresa,$email,$dui,$estadop,$telefono,$cumple,$com,$notas)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($cumple == '' && $com == '')
        { 
            $sql = "INSERT INTO clientes (NOMBRES, APELLIDOS,EMPRESA,DUI,CORREO,ESTADO,TELEFONO,FECHA_CUMPLEANOS,FECHA_CONMEMORATIVA,NOTAS) VALUES ('" . strtoupper($nombre) . "','" . strtoupper($apellido) . "','" . strtoupper($empresa) . "','" . $dui . "','" . strtolower($email) . "','" . $estadop . "','" . $telefono . "',null, null,'" . strtolower($notas) . "');"; 
        } 
        else if ($cumple == '') 
        {
            $sql = "INSERT INTO clientes (NOMBRES, APELLIDOS,EMPRESA,DUI,CORREO,ESTADO,TELEFONO,FECHA_CUMPLEANOS,FECHA_CONMEMORATIVA,NOTAS) VALUES ('" . strtoupper($nombre) . "','" . strtoupper($apellido) . "','" . strtoupper($empresa) . "','" . $dui . "','" . strtolower($email) . "','" . $estadop . "','" . $telefono . "',null,'" . $com . "','" . strtolower($notas) . "');"; 
        }
        else if ($com == '') 
        {
            $sql = "INSERT INTO clientes (NOMBRES, APELLIDOS,EMPRESA,DUI,CORREO,ESTADO,TELEFONO,FECHA_CUMPLEANOS,FECHA_CONMEMORATIVA,NOTAS) VALUES ('" . strtoupper($nombre) . "','" . strtoupper($apellido) . "','" . strtoupper($empresa) . "','" . $dui . "','" . strtolower($email) . "','" . $estadop . "','" . $telefono . "','" . $cumple . "',null,'" . strtolower($notas) . "');"; 
        }
        else
        {
            $sql = "INSERT INTO clientes (NOMBRES, APELLIDOS,EMPRESA,DUI,CORREO,ESTADO,TELEFONO,FECHA_CUMPLEANOS,FECHA_CONMEMORATIVA,NOTAS) VALUES ('" . strtoupper($nombre) . "','" . strtoupper($apellido) . "','" . strtoupper($empresa) . "','" . $dui . "','" . strtolower($email) . "','" . $estadop . "','" . $telefono . "','" . $cumple . "','" . $com . "','" . strtolower($notas) . "');"; 
        }

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function modificar_cliente($codigo,$nombre,$apellido,$empresa,$email,$dui,$estadop,$telefono,$cumple,$com,$notas)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($cumple == '' && $com == '')
        { 
            $sql = "UPDATE clientes SET NOMBRES = '" . strtoupper($nombre) . "', APELLIDOS = '" . strtoupper($apellido) . "', EMPRESA = '" . strtoupper($empresa) . "' , CORREO = '" . strtolower($email) . "' , DUI = '" . $dui . "', ESTADO = '" . $estadop . "', NOTAS = '" . $notas . "' , FECHA_CUMPLEANOS = null , FECHA_CONMEMORATIVA = null WHERE CLIENTE_ID = '" . $codigo . "';";     
        } 
        else if ($cumple == '') 
        {
            $sql = "UPDATE clientes SET NOMBRES = '" . strtoupper($nombre) . "', APELLIDOS = '" . strtoupper($apellido) . "', EMPRESA = '" . strtoupper($empresa) . "' , CORREO = '" . strtolower($email) . "' , DUI = '" . $dui . "', ESTADO = '" . $estadop . "', NOTAS = '" . $notas . "' , FECHA_CUMPLEANOS = null , FECHA_CONMEMORATIVA = '" . $com . "' WHERE CLIENTE_ID = '" . $codigo . "';";     
        }
        else if ($com == '') 
        {
            $sql = "UPDATE clientes SET NOMBRES = '" . strtoupper($nombre) . "', APELLIDOS = '" . strtoupper($apellido) . "', EMPRESA = '" . strtoupper($empresa) . "' , CORREO = '" . strtolower($email) . "' , DUI = '" . $dui . "', ESTADO = '" . $estadop . "', NOTAS = '" . $notas . "' , FECHA_CUMPLEANOS = '" . $cumple . "', FECHA_CONMEMORATIVA = null WHERE CLIENTE_ID = '" . $codigo . "';";     
        }
        else
        {
            $sql = "UPDATE clientes SET NOMBRES = '" . strtoupper($nombre) . "', APELLIDOS = '" . strtoupper($apellido) . "', EMPRESA = '" . strtoupper($empresa) . "' , CORREO = '" . strtolower($email) . "' , DUI = '" . $dui . "', ESTADO = '" . $estadop . "', NOTAS = '" . $notas . "' , FECHA_CUMPLEANOS = '" . $cumple . "', FECHA_CONMEMORATIVA = '" . $com . "' WHERE CLIENTE_ID = '" . $codigo . "';";     
        }


        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function agregar_ingrediente($estadoi,$nombre,$unidad,$costoingre,$cantelegible)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO ingredientes (INGREDIENTE,UNIDAD,ESTADO,COSTO,CANTIDAD_ELEGIBLE) VALUES ('" . strtoupper($nombre) . "','" . $unidad . "','" . $estadoi . "','" . $costoingre . "','" . $cantelegible . "');"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function modificar_ingrediente($estadoi,$nombre,$unidad,$ingreid,$costoingre,$cantelegible)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE ingredientes SET INGREDIENTE = '" . strtoupper($nombre) . "', UNIDAD = '" . strtoupper($unidad) . "', ESTADO = '" . $estadoi . "', COSTO = '" . $costoingre . "', CANTIDAD_ELEGIBLE = '" . $cantelegible . "' WHERE INGREDIENTE_ID = '" . $ingreid . "';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function borrar_proveedor($provid)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM proveedores WHERE proveedor_id = '" . $provid . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function borrar_producto($prodid)
    {
    //debe borrar de productos el producto_id
    //debe borrar de ingredientes_Asignados el id (producto_id)
    //debe borrar de  subproductos_asignados (producto_id)
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        //ingredientes ASIGNADOS
        $sql = "DELETE FROM ingredientes_asignados WHERE PRODUCTO_ID = '" . $prodid . "';";
        mysqli_query($conexion, $sql);

        //SUBPRODUCTOS SI LOS HAY ASIGNADOS
        $sql = "DELETE FROM subproductos_asignados WHERE PRODUCTO_ID = '" . $prodid . "';";
        mysqli_query($conexion, $sql);

        //CROSSREFERNECE A SUBPRODUCTO OSEA SUBPRODUCTO_id SI LOS HAY ASIGNADOS
        $sql = "DELETE FROM subproductos_asignados WHERE SUBPRODUCTO_ID = '" . $prodid . "';";
        mysqli_query($conexion, $sql);

        //PRODUCTO EN SI
        $sql = "DELETE FROM productos WHERE PRODUCTO_ID = '" . $prodid . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function borrar_cliente($clienteid)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM clientes WHERE cliente_id = '" . $clienteid . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function borrar_ingrediente($ingreid)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM ingredientes WHERE INGREDIENTE_ID = '" . $ingreid . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function uso_ingrediente($ingreid)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "SELECT COUNT(*) FROM ingredientes_asignados WHERE INGREDIENTE_ID = '" . $ingreid . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function existe_dui_cliente($dui)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) FROM clientes WHERE dui = '" . $dui . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function existe_ingrediente($nombre)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) FROM ingredientes WHERE INGREDIENTE =  RTRIM(LTRIM('" . $nombre . "')) ;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function existe_producto($nombre)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) FROM productos WHERE NOMBRE_PROD = RTRIM(LTRIM('" . $nombre . "')) ;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function existe_mesa($mesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) FROM mesas WHERE MESA = '" . $mesa . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function agregar_mesa_zona($mesa,$zona)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO mesas (MESA,ZONA) VALUES ('" . $mesa . "','" . $zona . "');"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function quitar_mesa_zona($mesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM mesas WHERE MESA = '" . $mesa . "';"; 

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function guardar_cantzonas($zonas)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET ZONAS = '" . $zonas . "' WHERE ZONAS <> '';"; 
        mysqli_query($conexion, $sql);
     
        $sql = "DELETE FROM mesas WHERE ZONA > '" . $zonas . "';"; 
        mysqli_query($conexion, $sql);

        // por si fue asignada borrarla del mapa
        $sql = "DELETE FROM mapa_area_zonas WHERE ZONA > '" . $zonas . "';"; 
        mysqli_query($conexion, $sql);
        
        mysqli_close($conexion);

        return mysqli_errno($conexion);


    }

    public function guardar_cantmesas($mesas)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET mesas = '" . $mesas. "' WHERE mesas <> '';"; 
        mysqli_query($conexion, $sql);
     
        $sql = "DELETE FROM mesas WHERE MESA > '" . $mesas . "';"; 
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);

        return mysqli_errno($conexion);


    }

    public function get_unidades()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT ID_UNIDAD, UNIDAD FROM unidades;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function get_cat_prod()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT NOMBRE, URLCAT, CAT_ID FROM productos_categorias WHERE TIPO = 'categoria' ORDER BY NOMBRE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_cat_prod_noasignadas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT A.NOMBRE AS NOMBRE, A.URLCAT AS URLCAT, A.CAT_ID AS CAT_ID FROM productos_categorias A WHERE A.CAT_ID NOT IN (
            SELECT Z.CAT_ID AS CAT_ID FROM productos_categorias Z, productos_comanda_cat B
                    WHERE Z.TIPO = 'categoria' AND Z.NOMBRE = B.CATEGORIA) AND A.TIPO = 'categoria' ;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_cat_prod_barracocina()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CATEGORIA, AREA FROM productos_comanda_cat ORDER BY CATEGORIA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_cat_prod_asig($cat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT NOMBRE, CAT_ID FROM productos_categorias WHERE ASIGNADO = (SELECT CAT_ID FROM productos_categorias WHERE NOMBRE = '" . $cat. "' AND TIPO = 'categoria');";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_cat_prod_asig2($cat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT A.CAT_ID AS CAT_ID, A.NOMBRE AS NOMBRE, if (A.ASIGNADO IS NULL,'NO ASIGNADO',
        (SELECT B.NOMBRE FROM productos_categorias B WHERE B.CAT_ID = A.ASIGNADO)) AS ESTADO
        FROM productos_categorias A
        WHERE A.CAT_ID NOT IN (SELECT CAT_ID FROM productos_categorias WHERE ASIGNADO = (SELECT CAT_ID FROM productos_categorias WHERE NOMBRE = '" . $cat. "' AND TIPO = 'categoria'))
        AND TIPO = 'subcategoria' ";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_subcat_prod()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT CAT_ID, NOMBRE FROM productos_categorias WHERE TIPO = 'subcategoria' ORDER BY NOMBRE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_subcat_prod_id($id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT NOMBRE FROM productos_categorias WHERE TIPO = 'subcategoria' ORDER BY NOMBRE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_subcat_prod_list($cat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT SUBCAT AS SUBCAT FROM vista_subcategorias_asignadas WHERE CAT = '" . $cat. "' ORDER BY SUBCAT ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_prods_seleccion($subcat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PRECIO_FINAL, PRODUCTO_ID, NOMBRE_PROD, URLIMG, PROPINA, SERVICIO, LUNES, MARTES, MIERCOLES, JUEVES, VIERNES, SABADO, DOMINGO, NOTAS_OBLIGATORIAS, PREGUNTAS, RESPUESTAS, get_ifsubingrediente(PRODUCTO_ID) as SUBINGRE FROM productos WHERE MENU = '" . $subcat. "' ORDER BY NOMBRE_PROD ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_ingredientesmandatorios($id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT a.producto_id AS PRODUCTO_ID, a.nombre_prod AS NOMBRE, b.ingrediente_id AS INGREDIENTE_ID , d.ingrediente AS INGREDIENTE,
        (SELECT z.cantidad_elegible FROM ingredientes z WHERE z.ingrediente_id = b.ingrediente_id ) CANTIDAD_ELEGIBLE
        FROM productos a
        INNER JOIN ingredientes_asignados b ON a.producto_id = b.producto_id
        INNER JOIN ingredientes_sub c ON b.ingrediente_id = c.id_ingrediente
        INNER JOIN ingredientes d ON c.id_sub = d.ingrediente_id
        WHERE a.producto_id = '" . $id. "'
        ORDER BY d.ingrediente ASC";

        $resultado = mysqli_query($conexion, $sql);
        if ($resultado === false) {
            die("SQL ERROR: " . mysqli_error($conexion) . " | SQL: " . $sql);
        }

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function convertid_tomenu($idfinal)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT NOMBRE FROM productos_categorias WHERE CAT_ID = '" . $idfinal . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }


    public function grid_ingredientes()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT INGREDIENTE_ID, INGREDIENTE, UNIDAD, round(COSTO,3) as COSTO FROM ingredientes WHERE ESTADO = 'Activo'  ORDER BY INGREDIENTE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grid_ingredientesv2($selecting)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        if ($selecting == '')
        {
            $sql = "SELECT INGREDIENTE_ID, INGREDIENTE, UNIDAD, round(COSTO,3) as COSTO FROM ingredientes WHERE ESTADO = 'Activo' ORDER BY INGREDIENTE ASC;";
        }
        else
        {
            $sql = "SELECT INGREDIENTE_ID, INGREDIENTE, UNIDAD, round(COSTO,3) as COSTO FROM ingredientes WHERE ESTADO = 'Activo' AND INGREDIENTE_ID NOT IN (" . $selecting. ")   ORDER BY INGREDIENTE ASC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grid_productos()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PRODUCTO_ID, NOMBRE_PROD, DESCRIPCION, CATEGORIA, URLIMG, round(PRECIO_FINAL,3) as PRECIO_FINAL FROM productos WHERE ESTADO = 'Activo' ORDER BY NOMBRE_PROD, CATEGORIA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grid_productosv2($selecting)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($selecting == '')
        {
           $sql = "SELECT PRODUCTO_ID, NOMBRE_PROD, DESCRIPCION, CATEGORIA, URLIMG, round(PRECIO_FINAL,3) as PRECIO_FINAL FROM productos WHERE ESTADO = 'Activo' ORDER BY NOMBRE_PROD, CATEGORIA ASC;";
        }
        else
        {
            $sql = "SELECT PRODUCTO_ID, NOMBRE_PROD, DESCRIPCION, CATEGORIA, URLIMG, round(PRECIO_FINAL,3) as PRECIO_FINAL FROM productos WHERE ESTADO = 'Activo' AND PRODUCTO_ID NOT IN (" . $selecting. ") ORDER BY NOMBRE_PROD, CATEGORIA ASC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function guardar_unidad($unidad)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO unidades (UNIDAD) VALUES ('" . strtolower($unidad) . "');"; 
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_abar($cat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO productos_comanda_cat (CATEGORIA,AREA) VALUES ('" . $cat . "', 'BAR');"; 
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function agregar_acocina($cat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO productos_comanda_cat (CATEGORIA,AREA) VALUES ('" . $cat . "', 'COCINA');"; 
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function quitar_barcocina($id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM productos_comanda_cat WHERE CATEGORIA = '" . $id . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function borrar_unidad($unidad)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM unidades WHERE UNIDAD = '" . $unidad . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function guardar_categoria($cat,$filecat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO productos_categorias (TIPO,NOMBRE,ASIGNADO,URLCAT) VALUES ('categoria','" . strtoupper($cat) . "','0','" . $filecat . "');"; 
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function borrar_categoria($cat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM productos_categorias WHERE CAT_ID = '" . $cat . "' AND TIPO = 'categoria';";
        mysqli_query($conexion, $sql);

        $sql = "DELETE FROM productos_categorias WHERE ASIGNADO = '" . $cat . "' AND TIPO = 'subcategoria';";
        mysqli_query($conexion, $sql);

        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function modificar_categoria($cat, $nuevon, $anterior)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
     
        //CAMBIA EN LA TABLA PRINCIPAL AL NUEVO NOMBRE
        $sql = "UPDATE productos_categorias SET NOMBRE = '" . strtoupper($nuevon) . "' WHERE CAT_ID = '" . $cat . "' AND TIPO = 'categoria';";
        mysqli_query($conexion, $sql);

        //CAMBIA EN ESTA TABLA DE productos ASIGNADOS TAMBIEN
        $sql = "UPDATE productos_comanda_cat SET CATEGORIA = '" . strtoupper($nuevon) . "' WHERE CATEGORIA = '" . $anterior . "';";
        mysqli_query($conexion, $sql);

        //CAMBIAR A LOS productos YA EXISTENTES
        $sql = "UPDATE productos SET CATEGORIA = '" . strtoupper($nuevon) . "' WHERE CATEGORIA = '" . $anterior . "';";
        mysqli_query($conexion, $sql);

        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function modificar_subcategoria($cat, $nuevon, $anterior)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
     
        //CAMBIA EN LA TABLA PRINCIPAL AL NUEVO NOMBRE
        $sql = "UPDATE productos_categorias SET NOMBRE = '" . strtoupper($nuevon) . "' WHERE CAT_ID = '" . $cat . "' AND TIPO = 'subcategoria';";
        mysqli_query($conexion, $sql);

        //CAMBIAR A LOS productos YA EXISTENTES
        $sql = "UPDATE productos SET MENU = '" . strtoupper($nuevon) . "' WHERE MENU = '" . $anterior . "';";
        mysqli_query($conexion, $sql);

        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function modificar_unidad($idunidad, $nuevounidad, $anterior)
    {
 
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
     
        //MODIFICAR UNIDAD DE TABLA
        $sql = "UPDATE unidades SET UNIDAD = '" . strtoupper($nuevounidad) . "' WHERE ID_UNIDAD = '" . $idunidad . "';";
        mysqli_query($conexion, $sql);

        //MODIFICAR UNIDAD DE TABLA ingredientes
        $sql = "UPDATE ingredientes SET UNIDAD = '" . strtoupper($nuevounidad) . "' WHERE UNIDAD = '" . $anterior . "';";
        mysqli_query($conexion, $sql);

        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function get_productoanterior($cat)
    {
        //--SI DA CERO NO ESTA OCUPADA
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT NOMBRE FROM productos_categorias WHERE CAT_ID = '" . $cat . "' AND TIPO = 'categoria';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_subproductoanterior($cat)
    {
        //--SI DA CERO NO ESTA OCUPADA
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT NOMBRE FROM productos_categorias WHERE CAT_ID = '" . $cat . "' AND TIPO = 'subcategoria';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_unidadanterior($iduni)
    {
        //--SI DA CERO NO ESTA OCUPADA
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT UNIDAD FROM unidades WHERE ID_UNIDAD = '" . $iduni . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function guardar_scategoria($scat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO productos_categorias (TIPO,NOMBRE) VALUES ('subcategoria','" . strtoupper($scat) . "');"; 
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function borrar_scategoria($scat)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM productos_categorias WHERE NOMBRE = '" . $scat . "' AND TIPO = 'subcategoria';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function guardar_producto($estadopr,$filename1,$producto,$precio,$iva,$categoria,$scategoria,$desc,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$fdesde,$fhasta,$mdesde,$mhasta,$servicio,$propina,$porcmanto,$porcganancia,$notaoblig,$preguntas,$respuestas)
    {
        date_default_timezone_set('America/El_Salvador');
        $fecha = date('Y-m-d');

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
         
        if ($fdesde != '')
        {
           $sql = "INSERT INTO productos (nombre_prod,precio_final,precio_sugerido,categoria,menu,descripcion,estado,creado,urlimg,fechadesde,horadesde,fechahasta,horahasta,lunes,martes,miercoles,jueves,viernes,sabado,domingo,servicio,propina,porcmant,porcganancia,notas_obligatorias,preguntas,respuestas) VALUES ('" . strtoupper($producto). "','" . $precio . "','" . $iva . "','" . $categoria . "','" . $scategoria . "','" . strtoupper($desc) . "','" . $estadopr . "', '" . $fecha . "','" . $filename1 . "','" . $fdesde . "','" . $mdesde . "','" . $fhasta . "','" . $mhasta . "','" . $lunes . "','" . $martes . "','" . $miercoles . "','" . $jueves . "','" . $viernes . "','" . $sabado . "','" . $domingo . "','" . $servicio . "','" . $propina . "','" . $porcmanto . "','" . $porcganancia . "','" . $notaoblig . "','" . $preguntas . "','" . $respuestas . "');"; 
        }
        else
        {
            $sql = "INSERT INTO productos (nombre_prod,precio_final,precio_sugerido,categoria,menu,descripcion,estado,creado,urlimg,lunes,martes,miercoles,jueves,viernes,sabado,domingo,servicio,propina,porcmant,porcganancia,notas_obligatorias,preguntas,respuestas) VALUES ('" . strtoupper($producto)  . "','" . $precio . "','" . $iva . "','" . $categoria . "','" . $scategoria . "','" . strtoupper($desc) . "','" . $estadopr . "', '" . $fecha . "','" . $filename1 . "','true','true','true','true','true','true','true','" . $servicio . "','" . $propina . "','" . $porcmanto . "','" . $porcganancia . "','" . $notaoblig . "','" . $preguntas . "','" . $respuestas . "');";     
        }
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    

    
    public function get_producto_id($nombre)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PRODUCTO_ID FROM productos WHERE NOMBRE_PROD = '" . $nombre . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function asociar_ingredientes($insertIng)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "INSERT INTO ingredientes_asignados (producto_id, ingrediente_id, cantidad, costot) VALUES " . $insertIng . ";";
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function listado_productos()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT producto_id, estado, nombre_prod, round(precio_final,3) as precio_final, round(precio_sugerido,3) as precio_sugerido, categoria, menu, descripcion, DATE_FORMAT(creado,'%d/%m/%Y') AS CREADO, CONCAT(DATE_FORMAT(fechadesde,'%d/%m/%Y'),' ',horadesde) AS FechaI, CONCAT(DATE_FORMAT(fechahasta,'%d/%m/%Y'),' ',horahasta) AS FechaF, lunes,martes,miercoles,jueves,viernes,sabado,domingo FROM productos;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function asociar_productos($insertProd)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "INSERT INTO subproductos_asignados (producto_id, subproducto_id, cantidad) VALUES " . $insertProd . ";";
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    public function buscar_producto($producto_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADO, PRODUCTO_ID, URLIMG, NOMBRE_PROD, round(precio_final,3) as PRECIO_FINAL, round(precio_sugerido,3) as PRECIO_SUGERIDO, CATEGORIA, MENU, DESCRIPCION, LUNES, MARTES, MIERCOLES, JUEVES, VIERNES, SABADO, DOMINGO, FECHADESDE, HORADESDE, FECHAHASTA, HORAHASTA, PORCMANT, PORCGANANCIA, SERVICIO, PROPINA, NOTAS_OBLIGATORIAS, PREGUNTAS, RESPUESTAS  FROM productos WHERE PRODUCTO_ID = '" . $producto_id . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_ingredientes_asignados($producto_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT a.INGREDIENTE_ID AS INGREDIENTE_ID,b.INGREDIENTE AS INGREDIENTE,round(a.CANTIDAD,3) AS CANTIDAD,b.UNIDAD AS UNIDAD, round((a.CANTIDAD*b.costo),3) as COSTOT FROM ingredientes_asignados a, ingredientes b
        WHERE a.PRODUCTO_ID = '" . $producto_id . "'
        AND a.INGREDIENTE_ID = b.INGREDIENTE_ID;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function buscar_subproductos_asignados($producto_id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT a.subproducto_id AS SUBPRODUCTO_ID, b.nombre_prod AS SUBPRODUCTO,b.categoria AS CATEGORIA, ROUND(a.cantidad,3) AS CANTIDAD, b.descripcion AS DESCRIPCION, b.urlimg AS URLIMG
        FROM subproductos_asignados a, productos b
        WHERE a.PRODUCTO_ID = '" . $producto_id . "'
        AND a.SUBPRODUCTO_ID = b.PRODUCTO_ID;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function global_empresa()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT codempresa, nombre_comercial, razon_social, direccion, conit, coiva, giro, caja, mensajes, correonoti, correonoticc FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_global_empresa()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT codempresa, nombre_comercial, razon_social, direccion, conit, coiva, giro, caja, mensajes, correonoti, correonoticc FROM globales";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    function guardar_empresa($codempresa, $nomcomercial, $razonsocial, $dir, $nit, $iva, $giro, $caja, $mensaje, $correonoti, $correonoticc)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET CODEMPRESA = '" . strtoupper($codempresa) . "', NOMBRE_COMERCIAL = '" . strtoupper($nomcomercial) . "', razon_social = '" . strtoupper($razonsocial) . "', DIRECCION = '" . strtoupper($dir) . "', CONIT = '" . strtoupper($nit) . "', COIVA = '" . strtoupper($iva) . "', GIRO = '" . strtoupper($giro) . "', CAJA = '" . strtoupper($caja) . "', MENSAJES = '" . strtoupper($mensaje) . "', CORREONOTI = '" . strtolower($correonoti) . "', CORREONOTICC = '" . strtolower($correonoticc) . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function guardar_inactividad($tusuario)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET INACTIVIDAD = '" . $tusuario . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function guardar_iva($ivaprod)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET IVA = '" . $ivaprod . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function guardar_bloqueomesa($bloqueo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET BLOQUEO_COMANDA = '" . $bloqueo . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function guardar_refreshmesa($refreshmesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET REFRESCAR_COMANDA = '" . $refreshmesa . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function guardar_refreshbar($refreshbar)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET REFRESCAR_BAR = '" . $refreshbar. "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function guardar_refreshcocina($refreshcocina)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET REFRESCAR_COCINA = '" . $refreshcocina. "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function guardar_maxbar($maxbar)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET MAX_ORDEN_BAR = '" . $maxbar. "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }


    function guardar_maxcocina($maxcocina)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET MAX_ORDEN_COCINA = '" . $maxcocina. "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function get_refresh_mesas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT REFRESCAR_COMANDA FROM globales  WHERE FILA = '1';";     
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);

    }

    function get_refresh_bar()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT REFRESCAR_BAR FROM globales  WHERE FILA = '1';";     
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);

    }

    function guardar_propina($propina)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE globales SET PROPINA = '" . $propina . "' WHERE FILA = '1';";     

        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }

    function validar_licencia()
    {
        $existe = '';

        $existe = file_exists("key.txt");
      
        if ($existe == false)  {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            //valida licencia del key.txt contra la guardada en la base en SHA
            $sql = "SELECT 100 FROM dual;";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_row($resultado);
            mysqli_close($conexion);
        }
         else
        {
        $filename = "key.txt";
        $file = fopen( $filename, "r" );
      
        $filesize = filesize( $filename );
        $filetext = fread( $file, $filesize );
        fclose( $file );
        
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        //valida licencia del key.txt contra la guardada en la base en SHA
        $sql = "SELECT COUNT(*) FROM licencia WHERE clave = '" . SHA1($filetext) . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
       }
    }

    function mod_producto_noattach($codprod,$estadopr,$producto,$precio,$iva,$categoria,$scategoria,$desc,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$fdesde,$fhasta,$mdesde,$mhasta,$servicio,$propina,$porcmanto,$porcganancia,$notaoblig,$preguntas,$respuestas)
    {
        date_default_timezone_set('America/El_Salvador');
        $fecha = date('Y-m-d');

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

      
        if ($fdesde != '')
        {
            $sql = "UPDATE productos SET NOMBRE_PROD = '" . strtoupper($producto) . "', ESTADO = '" . $estadopr . "', PRECIO_FINAL = '" . $precio . "', PRECIO_SUGERIDO = '" . $iva . "', CATEGORIA = '" . $categoria . "', MENU = '" . $scategoria . "', DESCRIPCION = '" . $desc . "', CREADO = '" . $fecha . "', FECHADESDE = '" . $fdesde . "', HORADESDE = '" . $mdesde . "', FECHAHASTA = '" . $fhasta . "', HORAHASTA = '" . $mhasta . "', LUNES = '" . $lunes . "', MARTES = '" . $martes . "', MIERCOLES = '" . $miercoles . "', JUEVES = '" . $jueves . "', VIERNES = '" . $viernes . "', SABADO = '" . $sabado . "', DOMINGO = '" . $domingo . "', SERVICIO = '" . $servicio . "', PROPINA = '" . $propina . "', PORCMANT = '" . $porcmanto . "', PORCGANANCIA = '" . $porcganancia . "', NOTAS_OBLIGATORIAS = '" . $notaoblig . "', PREGUNTAS = '" . $preguntas . "', RESPUESTAS = '" . $respuestas . "' WHERE PRODUCTO_ID = '" . $codprod . "';";    
        }
        else
        {
            $sql = "UPDATE productos SET NOMBRE_PROD = '" . strtoupper($producto) . "', ESTADO = '" . $estadopr . "', PRECIO_FINAL = '" . $precio . "', PRECIO_SUGERIDO = '" . $iva . "', CATEGORIA = '" . $categoria . "', MENU = '" . $scategoria . "', DESCRIPCION = '" . $desc . "', CREADO = '" . $fecha . "', FECHADESDE = NULL, HORADESDE = NULL, FECHAHASTA = NULL, HORAHASTA = NULL, LUNES = 'true', MARTES = 'true', MIERCOLES = 'true', JUEVES = 'true', VIERNES = 'true', SABADO = 'true', DOMINGO = 'true', SERVICIO = '" . $servicio . "', PROPINA = '" . $propina . "', PORCMANT = '" . $porcmanto . "', PORCGANANCIA = '" . $porcganancia . "', NOTAS_OBLIGATORIAS = '" . $notaoblig . "', PREGUNTAS = '" . $preguntas . "', RESPUESTAS = '" . $respuestas . "' WHERE PRODUCTO_ID = '" . $codprod . "';";    
        }

        mysqli_query($conexion, $sql);
                
        //BORRAR ingredientes ACTUALES Y SUBPRODUCTOS SI HAY PARA LLENARLOS DE NUEVO
        $sql = "DELETE FROM ingredientes_asignados WHERE PRODUCTO_ID = '" . $codprod . "';";
        mysqli_query($conexion, $sql);
 
        $sql = "DELETE FROM subproductos_asignados WHERE PRODUCTO_ID = '" . $codprod . "';";
        mysqli_query($conexion, $sql);

        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    function mod_producto_attach ($codprod,$estadopr,$filename1,$producto,$precio,$iva,$categoria,$scategoria,$desc,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$fdesde,$fhasta,$mdesde,$mhasta,$servicio,$propina,$porcmanto,$porcganancia,$notaoblig,$preguntas,$respuestas)
    {
        date_default_timezone_set('America/El_Salvador');
        $fecha = date('Y-m-d');

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

      
        if ($fdesde != '')
        {
            $sql = "UPDATE productos SET URLIMG = '" . $filename1 . "', NOMBRE_PROD = '" . strtoupper($producto) . "', ESTADO = '" . $estadopr . "', PRECIO_FINAL = '" . $precio . "', PRECIO_SUGERIDO = '" . $iva . "', CATEGORIA = '" . $categoria . "', MENU = '" . $scategoria . "', DESCRIPCION = '" . $desc . "', CREADO = '" . $fecha . "', FECHADESDE = '" . $fdesde . "', HORADESDE = '" . $mdesde . "', FECHAHASTA = '" . $fhasta . "', HORAHASTA = '" . $mhasta . "', LUNES = '" . $lunes . "', MARTES = '" . $martes . "', MIERCOLES = '" . $miercoles . "', JUEVES = '" . $jueves . "', VIERNES = '" . $viernes . "', SABADO = '" . $sabado . "', DOMINGO = '" . $domingo . "', SERVICIO = '" . $servicio . "', PROPINA = '" . $propina . "', PORCMANT = '" . $porcmanto . "', PORCGANANCIA = '" . $porcganancia . "', NOTAS_OBLIGATORIAS = '" . $notaoblig . "', PREGUNTAS = '" . $preguntas . "', RESPUESTAS = '" . $respuestas . "' WHERE PRODUCTO_ID = '" . $codprod . "';";    
        }
        else
        {
            $sql = "UPDATE productos SET URLIMG = '" . $filename1 . "', NOMBRE_PROD = '" . strtoupper($producto) . "', ESTADO = '" . $estadopr . "', PRECIO_FINAL = '" . $precio . "', PRECIO_SUGERIDO = '" . $iva . "', CATEGORIA = '" . $categoria . "', MENU = '" . $scategoria . "', DESCRIPCION = '" . $desc . "', CREADO = '" . $fecha . "', FECHADESDE = NULL, HORADESDE = NULL, FECHAHASTA = NULL, HORAHASTA = NULL, LUNES = 'true', MARTES = 'true', MIERCOLES = 'true', JUEVES = 'true', VIERNES = 'true', SABADO = 'true', DOMINGO = 'true', SERVICIO = '" . $servicio . "', PROPINA = '" . $propina . "', PORCMANT = '" . $porcmanto . "', PORCGANANCIA = '" . $porcganancia . "', NOTAS_OBLIGATORIAS = '" . $notaoblig . "', PREGUNTAS = '" . $preguntas . "', RESPUESTAS = '" . $respuestas . "' WHERE PRODUCTO_ID = '" . $codprod . "';";    
        }

        mysqli_query($conexion, $sql);
                
        //BORRAR ingredientes ACTUALES Y SUBPRODUCTOS SI HAY PARA LLENARLOS DE NUEVO
        $sql = "DELETE FROM ingredientes_asignados WHERE PRODUCTO_ID = '" . $codprod . "';";
        mysqli_query($conexion, $sql);
 
        $sql = "DELETE FROM subproductos_asignados WHERE PRODUCTO_ID = '" . $codprod . "';";
        mysqli_query($conexion, $sql);

        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }
    
    public function generar_zonas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT ZONA FROM mesas WHERE ZONA NOT IN (
            SELECT DISTINCT A.ZONA AS ZONA FROM mesas A 
            RIGHT JOIN mapa_area_zonas B
            ON A.ZONA = B.ZONA) order by zona asc;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function guardar_area_zona($area,$zona)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM mapa_area_zonas WHERE AREA = '" . $area . "' AND ZONA = '" . $zona . "' ;";
        mysqli_query($conexion, $sql);
 
        $sql = "INSERT INTO mapa_area_zonas (AREA,ZONA) VALUES ('" . $area . "','" . $zona . "');";
        mysqli_query($conexion, $sql);

        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function borrar_area_zona($zona)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM mapa_area_zonas WHERE ZONA = '" . $zona . "' ;";
        mysqli_query($conexion, $sql);
 
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function adquirir_azonas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT AREA, ZONA FROM mapa_area_zonas;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_mapa($n)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT ZONA, MESA FROM mesas WHERE ZONA IN (SELECT ZONA FROM mapa_area_zonas WHERE AREA = '1') ORDER BY ZONA,MESA ASC;";
        $sql = "SELECT A.ZONA AS ZONA, A.MESA AS MESA, B.COLOR AS COLOR, B.MESERO as MESERO, B.MESA_PRINCIPAL, B.ORDEN_ACTUAL as ORDEN_ACTUAL FROM mesas A LEFT JOIN mesas_estado B ON A.MESA = B.MESA WHERE A.ZONA IN (SELECT C.ZONA FROM mapa_area_zonas C WHERE C.AREA = '" . $n . "') ORDER BY A.ZONA,A.MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_mapacaja()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT ZONA, MESA FROM mesas WHERE ZONA IN (SELECT ZONA FROM mapa_area_zonas WHERE AREA = '1') ORDER BY ZONA,MESA ASC;";
        $sql = "SELECT A.ZONA AS ZONA, A.MESA AS MESA, B.COLOR AS COLOR, B.MESERO as MESERO, B.MESA_PRINCIPAL, B.ORDEN_ACTUAL as ORDEN_ACTUAL,DATE_FORMAT(B.MODIFICADO,'%d/%m/%Y %h:%i:%s %p') AS MODIFICADO FROM mesas A LEFT JOIN mesas_estado B ON A.MESA = B.MESA WHERE A.ZONA IN (SELECT C.ZONA FROM mapa_area_zonas C)  AND B.ORDEN_ACTUAL IS NOT NULL ORDER BY B.ORDEN_ACTUAL ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function borrar_scat($scat)
    {
     //ACTUALIZAR A NULL
     $obj = new conectar();
     $conexion = $obj->conexionMySQL();

     $sql = "UPDATE productos_categorias SET ASIGNADO = NULL  WHERE CAT_ID =  '" . $scat . "';";
     mysqli_query($conexion, $sql);
     return mysqli_errno($conexion);
     mysqli_close($conexion);

    }

    public function asignar_scat($scat,$cat)
    {
     //ACTUALIZAR A NULL
     $obj = new conectar();
     $conexion = $obj->conexionMySQL();
     $q1 ='';

     $sql1 = "SELECT CAT_ID FROM productos_categorias WHERE NOMBRE = '" . $cat . "';";
     $a = mysqli_query($conexion, $sql1);

     while ($row = $a->fetch_assoc()) {
        $q1 = $row['CAT_ID'];
     }

     $sql = "UPDATE productos_categorias SET ASIGNADO = '" . $q1 . "' WHERE CAT_ID =  '" . $scat . "';";
     mysqli_query($conexion, $sql);
     return mysqli_errno($conexion);
     mysqli_close($conexion);

    }

    public function get_meseros_users()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT USUARIO_ID, USUARIO, NOMBRE FROM usuarios WHERE ROL IN ('BARTENDER','MESERO') AND ESTADO = 'ACTIVO' ORDER BY NOMBRE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_meseros_users_bar()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT USUARIO_ID, USUARIO, NOMBRE FROM usuarios WHERE ROL IN ('BARTENDER','MESERO') AND ESTADO = 'ACTIVO' ORDER BY NOMBRE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_meseros_users_cocina()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT USUARIO_ID, USUARIO, NOMBRE FROM usuarios WHERE ROL IN ('COCINERO','BARTENDER','MESERO') AND ESTADO = 'ACTIVO' ORDER BY NOMBRE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    
    public function bloquear_mesa($mesa, $usuario)
    {
        if ($usuario != 'ADMIN')
        {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        // si no existe la tabla en estado de mesas se creara primero
        $sql = "INSERT INTO mesas_estado (MESA,ESTADO,COLOR,MODIFICADO) VALUES ('" . $mesa . "','libre','green',NOW());";
        mysqli_query($conexion, $sql);
        //si es 2da o otra vez q pasa aca se resetea el tiempo por el mismo usuario
        $sql = "UPDATE mesas_estado SET TIEMPO_CORRIENDO = '0', MODIFICADO = NOW() WHERE ESTADO = 'bloqueada' AND MESERO = '" . $usuario . "' AND MESA = '" . $mesa . "';";
        mysqli_query($conexion, $sql);
        //actualiza por primera vez si esta desbloqueada y es mi usuario
        $sql = "UPDATE mesas_estado SET ESTADO = 'bloqueada', COLOR = 'yellow', TIEMPO_CORRIENDO = '0', MESERO = '" . $usuario . "', MODIFICADO = NOW()  WHERE ESTADO =  'libre' AND MESERO IS NULL AND MESA = '" . $mesa . "';";
        mysqli_query($conexion, $sql);

        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
        }
        else
        {
            return 1;
        }
    }

    public function bloquear_mesa_ylog($submesa, $usuario, $mesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        // si no existe la tabla en estado de mesas se creara primero
        $sql = "INSERT INTO mesas_estado (MESA,ESTADO,COLOR,MODIFICADO) VALUES ('" . $submesa . "','libre','green',NOW());";
        mysqli_query($conexion, $sql);
        //si es 2da o otra vez q pasa aca se resetea el tiempo por el mismo usuario
        $sql = "UPDATE mesas_estado SET TIEMPO_CORRIENDO = '0', MODIFICADO = NOW() WHERE ESTADO = 'bloqueada' AND MESERO = '" . $usuario . "' AND MESA = '" . $submesa . "';";
        mysqli_query($conexion, $sql);
        //actualiza por primera vez si esta desbloqueada y es mi usuario
        $sql = "UPDATE mesas_estado SET ESTADO = 'bloqueada', COLOR = 'yellow', TIEMPO_CORRIENDO = '0', MESERO = '" . $usuario . "', MODIFICADO = NOW()  WHERE ESTADO =  'libre' AND MESERO IS NULL AND MESA = '" . $submesa . "';";
        mysqli_query($conexion, $sql);

                //y actualiza la mesa principal a la que va pertenecer la mesa en pantalla
                $sql = "UPDATE mesas_estado SET MESA_PRINCIPAL = '" . $mesa . "' WHERE ESTADO = 'bloqueada' AND MESERO = '" . $usuario . "' AND MESA = '" . $submesa . "';";
                mysqli_query($conexion, $sql);

        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function get_zonas_usuario($usuarioc)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ZONA1,ZONA2,ZONA3,ZONA4,ZONA5,ZONA6,ZONA7,ZONA8,ZONA9,ZONA10 FROM usuarios WHERE USUARIO = '" . $usuarioc . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_zonas($zona)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT MESA FROM mesas WHERE ZONA = '" . $zona . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    

    public function get_zonas_a($zona,$mesaactual)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT ZONA, MESA FROM mesas WHERE ZONA = '" . $zona . "' AND MESA NOT IN ('" . $mesaactual . "') ORDER BY MESA ASC;";
        $sql = "SELECT A.ZONA, A.MESA, B.ESTADO FROM mesas A LEFT JOIN mesas_estado B ON A.MESA = B.MESA WHERE A.MESA NOT IN ('" . $mesaactual . "')
        AND B.ESTADO IN ('libre')
        AND A.ZONA = '" . $zona . "'
        ORDER BY A.MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_zonas_aliberar($zona)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT ZONA, MESA FROM mesas WHERE ZONA = '" . $zona . "' AND MESA NOT IN ('" . $mesaactual . "') ORDER BY MESA ASC;";
        $sql = "SELECT A.ZONA, A.MESA, B.ESTADO FROM mesas A LEFT JOIN mesas_estado B ON A.MESA = B.MESA WHERE B.ESTADO NOT IN ('libre')
        AND A.ZONA = '" . $zona . "'
        ORDER BY A.MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function zonas($usuarioc)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT A.ZONA,
        (SELECT
             CASE A.ZONA
                 WHEN 1 THEN zona1
                 WHEN 2 THEN zona2
                 WHEN 3 THEN zona3
                 WHEN 4 THEN zona4
                 WHEN 5 THEN zona5
                 WHEN 6 THEN zona6
                 WHEN 7 THEN zona7
                 WHEN 8 THEN zona8
                 WHEN 9 THEN zona9
                 WHEN 10 THEN zona10
             END
         FROM usuarios WHERE USUARIO = '" . $usuarioc . "') AS ZONAX
            FROM (
                SELECT DISTINCT ZONA FROM mapa_area_zonas 
            ) A
            ORDER BY A.ZONA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    
    public function zonas_all()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT ZONA FROM mapa_area_zonas ORDER BY ZONA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function tarea_zonasuser()
    {
     //ACTUALIZAR A NULL
     $obj = new conectar();
     $conexion = $obj->conexionMySQL();

     $sql = "UPDATE usuarios SET ZONA1 = 'true',ZONA2 = 'true',ZONA3 = 'true',ZONA4 = 'true',ZONA5 = 'true',ZONA6 = 'true',ZONA7 = 'true',ZONA8 = 'true',ZONA9 = 'true',ZONA10 = 'true' WHERE rol =  'MESERO';";
     mysqli_query($conexion, $sql);
     return mysqli_errno($conexion);
     mysqli_close($conexion);

    }

    public function get_vista_detallada()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT B.ZONA AS ZONA, A.MESA AS MESA, A.ESTADO AS ESTADO, A.COLOR AS COLOR, A.TIEMPO_CORRIENDO AS TIEMPO_CORRIENDO
        , A.MESERO AS MESERO, DATE_FORMAT(A.MODIFICADO,'%d/%m/%Y %h:%i:%s %p') as MODIFICADO, IF(A.ORDEN_ACTUAL = 0, '-', A.ORDEN_ACTUAL) AS ORDEN_ACTUAL, IF(A.NUM_PERSONAS = 0, '-', A.NUM_PERSONAS) AS NUM_PERSONAS, IF(A.MESA_PRINCIPAL = 0, '-', A.MESA_PRINCIPAL) AS MESA_PRINCIPAL FROM mesas_estado A, mesas B
        WHERE A.MESA = B.MESA
        ORDER BY B.ZONA, A.MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_vista_detallada_sum()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADO as ESTADO, COUNT AS COUNT, POR AS POR from vista_resumen_mesas;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function verificar_mesaocupada($submesa)
    {
        //--SI DA CERO NO ESTA OCUPADA
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(1) AS CUENTA FROM mesas_estado WHERE MESA = '" . $submesa . "' AND ESTADO = 'ocupada' ;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function verificar_mesausuario($usuarioc, $submesa)
    {
        //--SI DA 1 ENTONCES SI ES DE LAS MIAS
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(1) AS CUENTA
        FROM mesas_estado
        WHERE MESA = '" . $submesa . "' AND (MESERO IN ('" . $usuarioc . "') OR MESERO IS NULL);";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function desocupar_submesa($submesa)
    {
     //ACTUALIZAR A NULL
     $obj = new conectar();
     $conexion = $obj->conexionMySQL();

     $sql = "UPDATE mesas_estado SET ESTADO = 'libre', COLOR = 'green',MODIFICADO = NOW(), TIEMPO_CORRIENDO = '0', MESERO = NULL WHERE MESA = '" . $submesa . "'  ;";
     mysqli_query($conexion, $sql);

     
                //y actualiza la mesa principal a la que va pertenecer la mesa en pantalla
                $sql = "UPDATE mesas_estado SET MESA_PRINCIPAL = '0' WHERE ESTADO = 'libre' AND MESA = '" . $submesa . "';";
                mysqli_query($conexion, $sql);

     return mysqli_errno($conexion);
     mysqli_close($conexion);

    }


    public function liberar_mesao($mesa)
    {
     //ACTUALIZAR A NULL
     $obj = new conectar();
     $conexion = $obj->conexionMySQL();
    //borra la mesa actual
     $sql = "UPDATE mesas_estado SET MESA_PRINCIPAL = '0', ESTADO = 'libre', TIEMPO_CORRIENDO = 0, MESERO = NULL, COLOR = 'green', orden_actual = 0, num_personas = 0, ORDEN_BUSQUEDA = 0 WHERE MESA = '" . $mesa . "';";
     mysqli_query($conexion, $sql);
    //por si tenia hijos
    $sql = "UPDATE mesas_estado SET MESA_PRINCIPAL = '0', ESTADO = 'libre', TIEMPO_CORRIENDO = 0, MESERO = NULL, COLOR = 'green', orden_actual = 0, num_personas = 0, ORDEN_BUSQUEDA = 0 WHERE MESA_PRINCIPAL = '" . $mesa . "';";
    mysqli_query($conexion, $sql);

     return mysqli_errno($conexion);
     mysqli_close($conexion);

    }


    
    public function estado_submesa($mesa,$smesa)
    {
     //ACTUALIZAR A NULL
     $obj = new conectar();
     $conexion = $obj->conexionMySQL();
    //borra la mesa actual
     $sql = "UPDATE ordenes SET SUBMESAS = REPLACE(SUBMESAS,'," . $mesa . "','') WHERE MESA = '" . $smesa . "';";
     mysqli_query($conexion, $sql);
     $sql = "UPDATE ordenes SET SUBMESAS = REPLACE(SUBMESAS,'" . $mesa . ",','') WHERE MESA = '" . $smesa . "';";
     mysqli_query($conexion, $sql);
     $sql = "UPDATE ordenes SET SUBMESAS = REPLACE(SUBMESAS,'" . $mesa . "','') WHERE MESA = '" . $smesa . "';";
     mysqli_query($conexion, $sql);
     $sql = "UPDATE ordenes SET SUBMESAS = REPLACE(SUBMESAS,' ','') WHERE MESA = '" . $smesa . "';";
     mysqli_query($conexion, $sql);

     return mysqli_errno($conexion);
     mysqli_close($conexion);

    }

    public function estado_mesa_cancelar($mesa)
    {
     //ACTUALIZAR A NULL
     $obj = new conectar();
     $conexion = $obj->conexionMySQL();
    //borra la mesa actual
     $sql = "UPDATE ordenes SET ESTADO = 'cancelada' WHERE MESA = '" . $mesa . "';";
     mysqli_query($conexion, $sql);

     return mysqli_errno($conexion);
     mysqli_close($conexion);

    }


    public function insertar_ordentable($mesa,$submesa,$mesero,$usuario,$ordenm,$ordend,$ordena,$llevar,$dui,$num_personas)
    {
       if ($llevar == 'SI')
       {
        $mesa = 0;
       }

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO ordenes (MESA,SUBMESAS,MESERO,USUARIO,ORDEN_M,ORDEN_D,ORDEN_A,LLEVAR,DUI,NUM_PERSONAS) VALUES ('" . $mesa . "','" . $submesa . "','" . $mesero . "','" . $usuario . "','" . $ordenm . "','" . $ordend . "','" . $ordena . "','" . $llevar . "','" . $dui . "','" . $num_personas . "');";
        mysqli_query($conexion, $sql);
        return mysqli_insert_id($conexion);
        mysqli_close($conexion);
    }

    public function actualizar_ordentable($mesaori,$mesa,$submesa,$usuariob,$usuario,$llevar,$num_personas)
    {
       if ($llevar == 'SI')
       {
        $mesa = 0;
       }

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "UPDATE ordenes (MESA,SUBMESAS,MESERO,USUARIO,ORDEN_M,ORDEN_D,ORDEN_A,LLEVAR,DUI,NUM_PERSONAS) VALUES ('" . $mesa . "','" . $submesa . "','" . $mesero . "','" . $usuario . "','" . $ordenm . "','" . $ordend . "','" . $ordena . "','" . $llevar . "','" . $dui . "','" . $num_personas . "');";
        $sql = "UPDATE ordenes SET MESA  = '" . $mesa . "' , SUBMESAS = '" . $submesa . "', MESERO = '" . $usuariob . "' , USUARIO = '" . $usuario . "' ,LLEVAR = '" . $llevar . "' , NUM_PERSONAS = '" . $num_personas . "' WHERE ESTADO = 'abierta' AND MESA = '" . $mesaori . "';";
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function enviar_comanda($num_personas,$mesa,$value,$ordenm,$ordend,$ordena,$orden,$ordenzeros,$ordenmasked,$usuarioc,$usuario,$propina)
    {
        date_default_timezone_set('America/El_Salvador');
        $fecha = date('Y-m-d H:i:s');

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
          // guardar las lineas basado en los datos de la orden para linkear
         //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
        // cuenta, idprod, nombre, precio, unidad, propina, pregunta

        $newValuenombre = str_replace('EXTRA_', '', $value[2]);

        if ($value[5] == 'false')
        {
           $propina = 0; 
        }
  
        if ($value[1] == 'CM' || $value[1] == 'CV')
        {
        $sql = "INSERT INTO ordenes_lineas (CANTIDAD_PERSONAS,MESA,CUENTA,PRODUCTO_ID,DETALLE,PRECIO_UNI,CANTIDAD,PROPINA,NOTAS,PRECIO_STOT,ORDEN_M,ORDEN_D,ORDEN_A,ORDEN_NUM,ORDEN,ORDEN_CORRELATIVO,ORDEN_CORRELATIVOTXT,MESERO,USUARIO,FECHA_CREADO,FECHA_MODIFICADO,PROPINA_PORC,PROPINA_VAL,PRECIO_TOT,ESTADO) VALUES ('" . $num_personas . "','" . $mesa . "','" . $value[0] . "','" . $value[1] . "','" . $newValuenombre . "','" . $value[3] . "','" . $value[4] . "','" . $value[5] . "','" . $value[6] . "','" . $value[3]*$value[4] . "','" . $ordenm . "','" . $ordend . "','" . $ordena . "','" . $orden . "','" . $ordenzeros . "','" . $ordenmasked . "','" . $ordenmasked . "','" . $usuarioc . "','" . $usuario . "','" . $fecha . "','" . $fecha . "','" . $propina . "','" . ($propina*($value[3]*$value[4]))/100 . "', '" . ($value[3]*$value[4] + ($propina*($value[3]*$value[4]))/100). "','despacho');";
        mysqli_query($conexion, $sql);    
        }        
        else
        {
            for ($x = 1; $x <= $value[4]; $x++) {
            $sql = "INSERT INTO ordenes_lineas (CANTIDAD_PERSONAS,MESA,CUENTA,PRODUCTO_ID,DETALLE,PRECIO_UNI,CANTIDAD,PROPINA,NOTAS,PRECIO_STOT,ORDEN_M,ORDEN_D,ORDEN_A,ORDEN_NUM,ORDEN,ORDEN_CORRELATIVO,ORDEN_CORRELATIVOTXT,MESERO,USUARIO,FECHA_CREADO,FECHA_MODIFICADO,PROPINA_PORC,PROPINA_VAL,PRECIO_TOT) VALUES ('" . $num_personas . "','" . $mesa . "','" . $value[0] . "','" . $value[1] . "','" . $newValuenombre . "','" . $value[3] . "','1','" . $value[5] . "','" . $value[6] . "','" . $value[3]*1 . "','" . $ordenm . "','" . $ordend . "','" . $ordena . "','" . $orden . "','" . $ordenzeros . "','" . $ordenmasked . "','" . $ordenmasked . "','" . $usuarioc . "','" . $usuario . "','" . $fecha . "','" . $fecha . "','" . $propina . "','" . ($propina*($value[3]*1))/100 . "', '" . ($value[3]*1 + ($propina*($value[3]*1))/100). "');";
            mysqli_query($conexion, $sql);    
            }
        } 
        
        return mysqli_errno($conexion);
        mysqli_close($conexion);
        
    }


    public function get_total_linea($ordenactual)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT SUM(PRECIO_TOT) AS TOTAL FROM ordenes_lineas WHERE ORDEN_CORRELATIVOTXT = '" . $ordenactual . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);

    }

    public function ocupar_mesa($mesa,$submesa,$num_personas,$usuarioc,$orden,$ordenmasked)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        //si es 2da o otra vez q pasa aca se resetea el tiempo por el mismo usuario
        $sql = "UPDATE mesas_estado SET TIEMPO_CORRIENDO = '0', MODIFICADO = NOW(), COLOR = 'red', ESTADO = 'ocupada', MESERO = '" . $usuarioc . "', ORDEN_ACTUAL = '" . $ordenmasked . "', ORDEN_BUSQUEDA = '" . $orden . "', NUM_PERSONAS = '" . $num_personas . "'  WHERE MESA = '" . $mesa . "';";
        mysqli_query($conexion, $sql);
        //actualiza por primera vez si esta desbloqueada y es mi usuario
        if ($submesa != '')
        {
        $sql = "UPDATE mesas_estado SET TIEMPO_CORRIENDO = '0', COLOR = 'red', MODIFICADO = NOW(), ESTADO = 'ocupada', MESERO = '" . $usuarioc . "', ORDEN_ACTUAL = '" . $ordenmasked . "', ORDEN_BUSQUEDA = '" . $orden . "', MESA_PRINCIPAL = '" . $mesa . "'  WHERE MESA IN (" . $submesa . ");";
        mysqli_query($conexion, $sql);
        }
        
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    public function ocupar_mesa_affectrows($mesa,$submesa,$num_personas,$usuarioc,$orden,$ordenmasked)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        //si es 2da o otra vez q pasa aca se resetea el tiempo por el mismo usuario
        $sql = "UPDATE mesas_estado SET TIEMPO_CORRIENDO = '0', MODIFICADO = NOW(), COLOR = 'red', ESTADO = 'ocupada', MESERO = '" . $usuarioc . "', ORDEN_ACTUAL = '" . $ordenmasked . "', ORDEN_BUSQUEDA = '" . $orden . "', NUM_PERSONAS = '" . $num_personas . "'  WHERE MESA = '" . $mesa . "';";
        mysqli_query($conexion, $sql);
        //actualiza por primera vez si esta desbloqueada y es mi usuario
        if ($submesa != '')
        {
        $sql = "UPDATE mesas_estado SET TIEMPO_CORRIENDO = '0', COLOR = 'red', MODIFICADO = NOW(), ESTADO = 'ocupada', MESERO = '" . $usuarioc . "', ORDEN_ACTUAL = '" . $ordenmasked . "', ORDEN_BUSQUEDA = '" . $orden . "', MESA_PRINCIPAL = '" . $mesa . "'  WHERE MESA IN (" . $submesa . ");";
        mysqli_query($conexion, $sql);
        }
        
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function get_orden_estado($mesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COALESCE(IF(ORDEN_ACTUAL IS NULL, 0, ORDEN_ACTUAL), 0) AS ORDEN
        FROM (SELECT '" . $mesa . "' AS MESA) m
        LEFT JOIN mesas_estado e ON m.MESA = e.MESA;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    // public function get_busqueda_orden($orden)
    // {
    // // guardar las lineas basado en los datos de la orden para linkear
    //  //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
    // // cuenta, idprod, nombre, precio, unidad, propina, pregunta
    // $obj = new conectar();
    // $conexion = $obj->conexionMySQL();

    // $sql = "SELECT CUENTA, PRODUCTO_ID, DETALLE, PRECIO_UNI, CANTIDAD, PROPINA, NOTAS, REGISTRO_ID from ordenes_lineas WHERE ORDEN_CORRELATIVOTXT = '" . $orden . "' ;";
    // $resultado = mysqli_query($conexion, $sql);

    // // $result_array = array();
    // // while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
    // //     $subarray = array(
    // //         $row[0],
    // //         $row[1],
    // //         $row[2],
    // //         $row[3],
    // //         $row[4],
    // //         $row[5],
    // //         $row[6],
    // //         $row[7], //agrege regid
    // //     );
    // //     $result_array[] = $subarray;
    // // }

    // $result_array = array();
    // $product_quantities = array();
    // while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
    //     $product_id = $row[1];
    //     if (!isset($product_quantities[$product_id])) {
    //         $product_quantities[$product_id] = 0;
    //     }
    //     $product_quantities[$product_id] += $row[4];

    //     $row_already_exists = false;
    //     foreach ($result_array as $existing_row) {
    //         if ($existing_row[1] === $row[1]) {
    //             $row_already_exists = true;
    //             break;
    //         }
    //     }

    //     if (!$row_already_exists) {
    //         $subarray = array(
    //             $row[0],
    //             $row[1],
    //             $row[2],
    //             $row[3],
    //             $row[4],
    //             $row[5],
    //             $row[6],
    //             $row[7],
    //         );
    //         $result_array[] = $subarray;
    //     }
    // }

    // // Update the CANTIDAD values based on the summed quantities
    // foreach ($result_array as &$subarray) {
    //     $product_id = $subarray[1];
    //     $subarray[4] = $product_quantities[$product_id];
    // }

    // mysqli_close($conexion);

    // return $result_array;
    // }


    public function get_busqueda_orden($orden)
{
    $obj = new conectar();
    $conexion = $obj->conexionMySQL();

    //$sql = "SELECT CUENTA, PRODUCTO_ID, DETALLE, PRECIO_UNI, CANTIDAD, PROPINA, NOTAS, REGISTRO_ID from ordenes_lineas WHERE ORDEN_CORRELATIVOTXT = '" . $orden . "' ;";
    $sql = "SELECT CUENTA, PRODUCTO_ID , MAX(DETALLE) AS DETALLE, MAX(PRECIO_UNI) AS PRECIO_UNI, SUM(CANTIDAD) AS CANTIDAD, MAX(PROPINA) AS PROPINA, MAX(NOTAS) AS NOTAS, MAX(REGISTRO_ID) AS REGISTRO_ID FROM ordenes_lineas WHERE ORDEN_CORRELATIVOTXT = '" . $orden . "'
    GROUP BY CUENTA, PRODUCTO_ID;";
    $resultado = mysqli_query($conexion, $sql);

        $result_array = array();
    while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
        $subarray = array(
            $row[0],
            $row[1],
            $row[2],
            $row[3],
            $row[4],
            $row[5],
            $row[6],
            $row[7], //agrege regid
        );
        $result_array[] = $subarray;
    }



    // $result_array = array();
    // $product_quantities = array();
    // while ($row = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
    //     $product_id = $row[1];
    //     if (!isset($product_quantities[$product_id])) {
    //         $product_quantities[$product_id] = 0;
    //     }
    //     $product_quantities[$product_id] += $row[4];

    //     $row_already_exists = false;
    //     foreach ($result_array as &$existing_row) {
    //         if ($existing_row[1] === $row[1]) { // Check product ID instead of CUENTA
    //             $row_already_exists = true;
    //             $existing_row[4] += $row[4]; // Add to the existing quantity
    //             break;
    //         }
    //     }

    //     if (!$row_already_exists) {
    //         $subarray = array(
    //             $row[0],
    //             $row[1],
    //             $row[2],
    //             $row[3],
    //             $row[4],
    //             $row[5],
    //             $row[6],
    //             $row[7],
    //         );
    //         $result_array[] = $subarray;
    //     }
    // }

    mysqli_close($conexion);

    return $result_array;
}


    public function get_orden_header($mesa)
    {
    // guardar las lineas basado en los datos de la orden para linkear
     //   0   ,    1  ,   2   ,    3   ,  4   ,   5    , 6
    // cuenta, idprod, nombre, precio, unidad, propina, pregunta
    $obj = new conectar();
    $conexion = $obj->conexionMySQL();

    $sql = "SELECT SUBMESAS,DUI,NUM_PERSONAS from ordenes WHERE MESA = '" . $mesa . "' and ESTADO = 'abierta';";
    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_close($conexion);
    }

    function lleva_propina($prod)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PROPINA FROM productos WHERE PRODUCTO_ID =  '" . $prod . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    function get_permisos_comanda($usuario)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PRECUENTA as PRECUENTA, SEPARAR AS SEPARAR, CORTESIA AS CORTESIA, IMPRIMIR AS IMPRIMIR FROM vista_privilegios WHERE USUARIO =  '" . $usuario . "' AND PRIV_ID = '7';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    function guardar_hist_impresion($usuario,$tipo,$nota,$mesa,$orden,$txthist)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "INSERT INTO historial_impresion (TIPO,USUARIO,NOTAS_IMPRESION,MESA,ORDEN,ARCHIVO,ESTADO) VALUES ('" . $tipo . "','" . $usuario . "','" . $nota . "','" . $mesa . "','" . $orden . "','" . $txthist . "','encola');";
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);
    }

    function get_tickets_bar()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
       // $sql = "SELECT REGISTRO_ID AS REGISTRO_ID, MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE, CANTIDAD AS CANTIDAD, NOTAS AS NOTAS, ESTADO AS ESTADO, TIMESTAMPDIFF(MINUTE, FECHA_CREADO, CURRENT_TIMESTAMP) AS TIEMPO_ITEM FROM vista_tickets_activos WHERE AREA = 'BAR';";
       $sql = "SELECT MAX(REGISTRO_ID) AS REGISTRO_ID, MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE, SUM(CANTIDAD) AS CANTIDAD, MAX(NOTAS) AS NOTAS, ESTADO AS ESTADO, 
       MAX(TIMESTAMPDIFF(MINUTE, FECHA_CREADO, CURRENT_TIMESTAMP)) AS TIEMPO_ITEM  FROM vista_tickets_activos WHERE AREA = 'BAR'
       GROUP BY MESA, ORDEN_ACTUAL, PRODUCTO_ID, DETALLE, ESTADO;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function get_tickets_cocina()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        //$sql = "SELECT REGISTRO_ID AS REGISTRO_ID, MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE, CANTIDAD AS CANTIDAD, NOTAS AS NOTAS, ESTADO AS ESTADO, TIMESTAMPDIFF(MINUTE, FECHA_CREADO, CURRENT_TIMESTAMP) AS TIEMPO_ITEM  FROM vista_tickets_activos WHERE AREA = 'COCINA';";
        $sql = "SELECT MAX(REGISTRO_ID) AS REGISTRO_ID, MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE, SUM(CANTIDAD) AS CANTIDAD, MAX(NOTAS) AS NOTAS, ESTADO AS ESTADO, 
        MAX(TIMESTAMPDIFF(MINUTE, FECHA_CREADO, CURRENT_TIMESTAMP)) AS TIEMPO_ITEM  FROM vista_tickets_activos WHERE AREA = 'COCINA'
        GROUP BY MESA, ORDEN_ACTUAL, PRODUCTO_ID, DETALLE, ESTADO;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function get_ticket_bar($mesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        //$sql = "SELECT REGISTRO_ID AS REGISTRO_ID, MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE, CANTIDAD AS CANTIDAD, NOTAS AS NOTAS, ESTADO AS ESTADO FROM vista_tickets_activos WHERE AREA = 'BAR' AND MESA = '" . $mesa . "' ORDER BY MESA ASC;";
        $sql = "SELECT MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE,
        SUM(CANTIDAD) AS CANTIDAD, NOTAS AS NOTAS, ESTADO AS ESTADO FROM vista_tickets_activos WHERE AREA = 'BAR' AND MESA = '" . $mesa . "' 
        GROUP BY MESA,ORDEN,PRODUCTO_ID,DETALLE,NOTAS,ESTADO
        ORDER BY MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function get_ticket_cocina($mesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        //$sql = "SELECT REGISTRO_ID AS REGISTRO_ID, MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE, CANTIDAD AS CANTIDAD, NOTAS AS NOTAS, ESTADO AS ESTADO FROM vista_tickets_activos WHERE AREA = 'COCINA' AND MESA = '" . $mesa . "' ORDER BY MESA ASC;";
        $sql = "SELECT MESA AS MESA, ORDEN_ACTUAL AS ORDEN, PRODUCTO_ID AS PRODUCTO_ID, DETALLE AS DETALLE,
        SUM(CANTIDAD) AS CANTIDAD, NOTAS AS NOTAS, ESTADO AS ESTADO FROM vista_tickets_activos WHERE AREA = 'COCINA' AND MESA = '" . $mesa . "' 
        GROUP BY MESA,ORDEN,PRODUCTO_ID,DETALLE,NOTAS,ESTADO
        ORDER BY MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function get_tickets_bar_ordenes()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = "
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
            SELECT A.MESA AS MESA, ORDEN_ACTUAL AS ORDEN_ACTUAL, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, Z.FECHA_CREADO, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
            TIMESTAMPDIFF(MINUTE, Z.FECHA_CREADO, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
            (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
             WHERE B.ORDEN_CORRELATIVOTXT = A.ORDEN_ACTUAL
             AND C.PRODUCTO_ID = B.PRODUCTO_ID
             AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
             AND B.ESTADO IN ('abierta','preparacion')
             AND C.CATEGORIA = D.CATEGORIA
             AND D.AREA = 'BAR'
            )  AS CT
            FROM mesas_estado A, ordenes Z
            WHERE A.ORDEN_ACTUAL <> 0
            AND A.ORDEN_ACTUAL = CONCAT(Z.ORDEN_M,Z.ORDEN_D,Z.ORDEN_A,LPAD(Z.ORDEN, 6, '0'))) B
            WHERE CT > 0
            UNION        
            SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
           SELECT CONCAT('LLEVAR_',A.ORDEN_D,A.ORDEN_A,A.ORDEN) AS MESA, 
           CONCAT(A.ORDEN_M,A.ORDEN_D,A.ORDEN_A,LPAD(A.ORDEN, 6, '0')) AS ORDEN_ACTUAL,
           SEC_TO_TIME(TIMESTAMPDIFF(SECOND, A.fecha_creado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
            TIMESTAMPDIFF(MINUTE, A.fecha_creado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
            (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
             WHERE B.ORDEN_CORRELATIVOTXT = ORDEN_ACTUAL
             AND C.PRODUCTO_ID = B.PRODUCTO_ID
             AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
             AND B.ESTADO IN ('abierta','preparacion')
             AND C.CATEGORIA = D.CATEGORIA
             AND D.AREA = 'BAR'
            )  AS CT
            FROM ordenes A WHERE A.LLEVAR = 'SI' ) E
            WHERE CT > 0
            ORDER BY ORDEN_ACTUAL ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function get_tickets_cocina_ordenes()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = "
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
            SELECT A.MESA AS MESA, ORDEN_ACTUAL AS ORDEN_ACTUAL, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, Z.FECHA_CREADO, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
            TIMESTAMPDIFF(MINUTE, Z.FECHA_CREADO, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
            (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
             WHERE B.ORDEN_CORRELATIVOTXT = A.ORDEN_ACTUAL
             AND C.PRODUCTO_ID = B.PRODUCTO_ID
             AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
             AND B.ESTADO IN ('abierta','preparacion')
             AND C.CATEGORIA = D.CATEGORIA
             AND D.AREA = 'COCINA'
            )  AS CT
            FROM mesas_estado A, ordenes Z
            WHERE A.ORDEN_ACTUAL <> 0
            AND A.ORDEN_ACTUAL = CONCAT(Z.ORDEN_M,Z.ORDEN_D,Z.ORDEN_A,LPAD(Z.ORDEN, 6, '0'))) B
            WHERE CT > 0
        UNION        
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
       SELECT CONCAT('LLEVAR_',A.ORDEN_D,A.ORDEN_A,A.ORDEN) AS MESA, 
       CONCAT(A.ORDEN_M,A.ORDEN_D,A.ORDEN_A,LPAD(A.ORDEN, 6, '0')) AS ORDEN_ACTUAL,
       SEC_TO_TIME(TIMESTAMPDIFF(SECOND, A.fecha_creado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
        TIMESTAMPDIFF(MINUTE, A.fecha_creado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
        (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
         WHERE B.ORDEN_CORRELATIVOTXT = ORDEN_ACTUAL
         AND C.PRODUCTO_ID = B.PRODUCTO_ID
         AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
         AND B.ESTADO IN ('abierta','preparacion')
         AND C.CATEGORIA = D.CATEGORIA
         AND D.AREA = 'COCINA'
        )  AS CT
        FROM ordenes A WHERE A.LLEVAR = 'SI' ) E
        WHERE CT > 0
        ORDER BY ORDEN_ACTUAL ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    
    function get_tickets_bar_ordenesv2()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = "
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
        SELECT A.MESA AS MESA, ORDEN_ACTUAL AS ORDEN_ACTUAL, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, modificado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
        TIMESTAMPDIFF(MINUTE, modificado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
        (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
         WHERE B.ORDEN_CORRELATIVOTXT = A.ORDEN_ACTUAL
         AND C.PRODUCTO_ID = B.PRODUCTO_ID
         AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
         AND B.ESTADO IN ('abierta','preparacion','despacho')
         AND C.CATEGORIA = D.CATEGORIA
         AND D.AREA = 'BAR'
        )  AS CT
        FROM mesas_estado A
        WHERE A.ORDEN_ACTUAL <> 0) B
        WHERE CT > 0
        UNION        
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
       SELECT CONCAT('LLEVAR_',A.ORDEN_D,A.ORDEN_A,A.ORDEN) AS MESA, 
       CONCAT(A.ORDEN_M,A.ORDEN_D,A.ORDEN_A,LPAD(A.ORDEN, 6, '0')) AS ORDEN_ACTUAL,
       SEC_TO_TIME(TIMESTAMPDIFF(SECOND, A.fecha_creado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
        TIMESTAMPDIFF(MINUTE, A.fecha_creado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
        (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
         WHERE B.ORDEN_CORRELATIVOTXT = ORDEN_ACTUAL
         AND C.PRODUCTO_ID = B.PRODUCTO_ID
         AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
         AND B.ESTADO IN ('abierta','preparacion','despacho')
         AND C.CATEGORIA = D.CATEGORIA
         AND D.AREA = 'BAR'
        )  AS CT
        FROM ordenes A WHERE A.LLEVAR = 'SI' ) E
        WHERE CT > 0
        ORDER BY MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function get_tickets_cocina_ordenesv2()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = "
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
        SELECT A.MESA AS MESA, ORDEN_ACTUAL AS ORDEN_ACTUAL, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, modificado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
        TIMESTAMPDIFF(MINUTE, modificado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
        (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
         WHERE B.ORDEN_CORRELATIVOTXT = A.ORDEN_ACTUAL
         AND C.PRODUCTO_ID = B.PRODUCTO_ID
         AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
         AND B.ESTADO IN ('abierta','preparacion','despacho')
         AND C.CATEGORIA = D.CATEGORIA
         AND D.AREA = 'COCINA'
        )  AS CT
        FROM mesas_estado A
        WHERE A.ORDEN_ACTUAL <> 0) B
        WHERE CT > 0
        UNION        
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
       SELECT CONCAT('LLEVAR_',A.ORDEN_D,A.ORDEN_A,A.ORDEN) AS MESA, 
       CONCAT(A.ORDEN_M,A.ORDEN_D,A.ORDEN_A,LPAD(A.ORDEN, 6, '0')) AS ORDEN_ACTUAL,
       SEC_TO_TIME(TIMESTAMPDIFF(SECOND, A.fecha_creado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
        TIMESTAMPDIFF(MINUTE, A.fecha_creado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
        (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
         WHERE B.ORDEN_CORRELATIVOTXT = ORDEN_ACTUAL
         AND C.PRODUCTO_ID = B.PRODUCTO_ID
         AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
         AND B.ESTADO IN ('abierta','preparacion','despacho')
         AND C.CATEGORIA = D.CATEGORIA
         AND D.AREA = 'COCINA'
        )  AS CT
        FROM ordenes A WHERE A.LLEVAR = 'SI' ) E
        WHERE CT > 0
        ORDER BY MESA ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function mostrar_componentes_ingre($id)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = "SELECT NOMBRE_PROD AS NOMBRE_PROD, INGREDIENTE AS INGREDIENTE, CANTIDAD AS CANTIDAD, UNIDAD AS UNIDAD, URLIMG AS URLIMG FROM vista_prods_ingredientes WHERE PRODUCTO_ID = '" . $id . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    function get_tiempo_maxordenbar()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT MAX_ORDEN_BAR FROM globales  WHERE FILA = '1';";     
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    function get_tiempo_maxordencocina()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT MAX_ORDEN_COCINA FROM globales  WHERE FILA = '1';";     
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    function accion_item($usuario,$usuariob,$registro,$estadoitem,$idprod,$cant,$orden)
    {
        date_default_timezone_set('America/El_Salvador');
        $fecha = date('Y-m-d H:i:s');

         $obj = new conectar();
         $conexion = $obj->conexionMySQL();
          
         //$sql = "UPDATE ordenes_lineas SET FECHA_MODIFICADO = '" . $fecha . "',  USUARIO = '" . $usuario . "', COCINA_BAR = '" . $usuariob . "', ESTADO = '" . $estadoitem . "'  WHERE REGISTRO_ID = '" . $registro . "';";

         if ($estadoitem == 'preparacion')
         {
            for ($x = 0; $x <= $cant; $x++) 
            {
                $sql = "UPDATE ordenes_lineas AS ol1
                JOIN (
                  SELECT PRODUCTO_ID, MAX(REGISTRO_ID) AS max_registro_id
                  FROM ordenes_lineas
                  WHERE PRODUCTO_ID = '" . $idprod . "' 
                    AND ORDEN_CORRELATIVOTXT = '" . $orden . "'
                    AND ESTADO = 'abierta'
                  GROUP BY PRODUCTO_ID
                ) AS ol2
                ON ol1.PRODUCTO_ID = ol2.PRODUCTO_ID
                SET ol1.FECHA_MODIFICADO = '" . $fecha . "', 
                    ol1.USUARIO = '" . $usuario . "', 
                    ol1.COCINA_BAR = '" . $usuariob . "', 
                    ol1.ESTADO = 'preparacion'  
                WHERE ol1.PRODUCTO_ID = '" . $idprod . "' 
                  AND ol1.REGISTRO_ID = ol2.max_registro_id;";
                  mysqli_query($conexion, $sql);
            }
         }
         else if ($estadoitem == 'despacho')
         {
            for ($x = 0; $x <= $cant; $x++) 
            {
                $sql = "UPDATE ordenes_lineas AS ol1
                JOIN (
                  SELECT PRODUCTO_ID, MAX(REGISTRO_ID) AS max_registro_id
                  FROM ordenes_lineas
                  WHERE PRODUCTO_ID = '" . $idprod . "' 
                    AND ORDEN_CORRELATIVOTXT = '" . $orden . "'
                    AND ESTADO = 'preparacion'
                  GROUP BY PRODUCTO_ID
                ) AS ol2
                ON ol1.PRODUCTO_ID = ol2.PRODUCTO_ID
                SET ol1.FECHA_MODIFICADO = '" . $fecha . "', 
                    ol1.USUARIO = '" . $usuario . "', 
                    ol1.COCINA_BAR = '" . $usuariob . "', 
                    ol1.ESTADO = 'despacho'  
                WHERE ol1.PRODUCTO_ID = '" . $idprod . "' 
                  AND ol1.REGISTRO_ID = ol2.max_registro_id;";
                  mysqli_query($conexion, $sql);
            }
         }
         else if ($estadoitem == 'abierta')
         {
            for ($x = 0; $x <= $cant; $x++) 
            {
                $sql = "UPDATE ordenes_lineas AS ol1
                JOIN (
                  SELECT PRODUCTO_ID, MAX(REGISTRO_ID) AS max_registro_id
                  FROM ordenes_lineas
                  WHERE PRODUCTO_ID = '" . $idprod . "' 
                    AND ORDEN_CORRELATIVOTXT = '" . $orden . "'
                    AND ESTADO = 'despacho'
                  GROUP BY PRODUCTO_ID
                ) AS ol2
                ON ol1.PRODUCTO_ID = ol2.PRODUCTO_ID
                SET ol1.FECHA_MODIFICADO = '" . $fecha . "', 
                    ol1.USUARIO = '" . $usuario . "', 
                    ol1.COCINA_BAR = '" . $usuariob . "', 
                    ol1.ESTADO = 'abierta'  
                WHERE ol1.PRODUCTO_ID = '" . $idprod . "' 
                  AND ol1.REGISTRO_ID = ol2.max_registro_id;";
                  mysqli_query($conexion, $sql);
            }
         }


         return mysqli_errno($conexion);
         mysqli_close($conexion);

    }

    function get_refresh_cocina()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT REFRESCAR_COCINA FROM globales  WHERE FILA = '1';";     
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);

    }

    function get_cuentatotalbar()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = " SELECT COUNT(*) AS CTT FROM (
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
            SELECT A.MESA AS MESA, ORDEN_ACTUAL AS ORDEN_ACTUAL, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, Z.FECHA_CREADO, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
            TIMESTAMPDIFF(MINUTE, Z.FECHA_CREADO, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
            (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
             WHERE B.ORDEN_CORRELATIVOTXT = A.ORDEN_ACTUAL
             AND C.PRODUCTO_ID = B.PRODUCTO_ID
             AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
             AND B.ESTADO IN ('abierta','preparacion')
             AND C.CATEGORIA = D.CATEGORIA
             AND D.AREA = 'BAR'
            )  AS CT
            FROM mesas_estado A, ordenes Z
            WHERE A.ORDEN_ACTUAL <> 0
            AND A.ORDEN_ACTUAL = CONCAT(Z.ORDEN_M,Z.ORDEN_D,Z.ORDEN_A,LPAD(Z.ORDEN, 6, '0'))) B
            WHERE CT > 0
        UNION        
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
       SELECT CONCAT('LLEVAR_',A.ORDEN_D,A.ORDEN_A,A.ORDEN) AS MESA, 
       CONCAT(A.ORDEN_M,A.ORDEN_D,A.ORDEN_A,LPAD(A.ORDEN, 6, '0')) AS ORDEN_ACTUAL,
       SEC_TO_TIME(TIMESTAMPDIFF(SECOND, A.fecha_creado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
        TIMESTAMPDIFF(MINUTE, A.fecha_creado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
        (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
         WHERE B.ORDEN_CORRELATIVOTXT = ORDEN_ACTUAL
         AND C.PRODUCTO_ID = B.PRODUCTO_ID
         AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
         AND B.ESTADO IN ('abierta','preparacion')
         AND C.CATEGORIA = D.CATEGORIA
         AND D.AREA = 'BAR'
        )  AS CT
        FROM ordenes A WHERE A.LLEVAR = 'SI' ) E
        WHERE CT > 0
        ORDER BY ORDEN_ACTUAL ASC) A;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    function get_cuentatotalcocina()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = " SELECT COUNT(*) AS CTT FROM (
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
            SELECT A.MESA AS MESA, ORDEN_ACTUAL AS ORDEN_ACTUAL, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, Z.FECHA_CREADO, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
            TIMESTAMPDIFF(MINUTE, Z.FECHA_CREADO, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
            (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
             WHERE B.ORDEN_CORRELATIVOTXT = A.ORDEN_ACTUAL
             AND C.PRODUCTO_ID = B.PRODUCTO_ID
             AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
             AND B.ESTADO IN ('abierta','preparacion')
             AND C.CATEGORIA = D.CATEGORIA
             AND D.AREA = 'COCINA'
            )  AS CT
            FROM mesas_estado A, ordenes Z
            WHERE A.ORDEN_ACTUAL <> 0
            AND A.ORDEN_ACTUAL = CONCAT(Z.ORDEN_M,Z.ORDEN_D,Z.ORDEN_A,LPAD(Z.ORDEN, 6, '0'))) B
            WHERE CT > 0
        UNION        
        SELECT MESA, ORDEN_ACTUAL, TIEMPO_ORDEN, TIEMPO_MINUTOS, CT FROM (
       SELECT CONCAT('LLEVAR_',A.ORDEN_D,A.ORDEN_A,A.ORDEN) AS MESA, 
       CONCAT(A.ORDEN_M,A.ORDEN_D,A.ORDEN_A,LPAD(A.ORDEN, 6, '0')) AS ORDEN_ACTUAL,
       SEC_TO_TIME(TIMESTAMPDIFF(SECOND, A.fecha_creado, CURRENT_TIMESTAMP)) AS TIEMPO_ORDEN, 
        TIMESTAMPDIFF(MINUTE, A.fecha_creado, CURRENT_TIMESTAMP) AS TIEMPO_MINUTOS,
        (SELECT COUNT(*) FROM ordenes_lineas B,productos C, productos_comanda_cat D
         WHERE B.ORDEN_CORRELATIVOTXT = ORDEN_ACTUAL
         AND C.PRODUCTO_ID = B.PRODUCTO_ID
         AND B.DETALLE NOT IN('PENDIENTE X CONSUMIR','COVER')
         AND B.ESTADO IN ('abierta','preparacion')
         AND C.CATEGORIA = D.CATEGORIA
         AND D.AREA = 'COCINA'
        )  AS CT
        FROM ordenes A WHERE A.LLEVAR = 'SI' ) E
        WHERE CT > 0
        ORDER BY ORDEN_ACTUAL ASC) A;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function revisar_ordenproceso($orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(*) AS CT FROM ordenes_lineas
        WHERE ESTADO <> 'abierta'
        AND ORDEN_CORRELATIVOTXT = '" . $orden . "'";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_extra_det($idprod)
    {
    //get prod name, precio, propina
    $obj = new conectar();
    $conexion = $obj->conexionMySQL();

    $sql = "SELECT NOMBRE_PROD, PRECIO_FINAL, PROPINA from productos WHERE PRODUCTO_ID = '" . $idprod . "' and ESTADO = 'Activo';";
    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_row($resultado);
    mysqli_close($conexion);
    }

    public function borrar_extras_cm($orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM ordenes_lineas WHERE producto_id = 'CM' and orden_correlativotxt = '" . $orden . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function borrar_extras_cv($orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
  
        $sql = "DELETE FROM ordenes_lineas WHERE producto_id = 'CV' and orden_correlativotxt = '" . $orden . "';";
        mysqli_query($conexion, $sql);
        return mysqli_affected_rows($conexion);
        mysqli_close($conexion);
    }

    public function listado_print_ordenesbar($orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        
        $sql = "SELECT B.detalle AS DETALLE, SUM(B.CANTIDAD) AS CANT, B.ESTADO AS ESTADO FROM ordenes_lineas B,productos C, productos_comanda_cat D
        WHERE B.orden_correlativotxt = '" . $orden . "'
        AND B.PRODUCTO_ID NOT IN ('CV','CM')
        AND C.PRODUCTO_ID = B.PRODUCTO_ID
        AND C.CATEGORIA = D.CATEGORIA
        AND D.AREA = 'BAR'
        GROUP BY B.detalle, B.estado
        ORDER BY B.detalle ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_facturar_estado_mesa($orden)
    {
    //get prod name, precio, propina
 
    $obj = new conectar();
    $conexion = $obj->conexionMySQL();

    $sql = "SELECT COUNT(1) FROM ordenes_lineas WHERE ORDEN_CORRELATIVOTXT = '" . $orden . "'
    AND PRODUCTO_ID NOT IN ('CM','CV') AND ESTADO NOT IN ('despacho');";

    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_row($resultado);
    mysqli_close($conexion);
    }

    public function get_orden_caja($mesa)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ORDEN_ACTUAL FROM mesas_estado WHERE MESA = '" . $mesa . "';";
        $resultado = mysqli_query($conexion, $sql);
        mysqli_close($conexion);
        return mysqli_fetch_row($resultado);
    }

    public function facturar_orden($orden, $cajero,$metodo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($orden != ''){
           $sql = "UPDATE ordenes_lineas SET ESTADO = 'facturada', CAJERO = '" . $cajero . "', METODO_PAGO= '" . $metodo . "'   WHERE ORDEN_CORRELATIVOTXT =  '" . $orden . "';";
        }
        
        mysqli_query($conexion, $sql);
        return mysqli_errno($conexion);
        mysqli_close($conexion);

    }  
    
    public function get_totales_nofacturados()
    {
    //get prod name, precio, propina
 
    $obj = new conectar();
    $conexion = $obj->conexionMySQL();

    $sql = "SELECT SUM(TOTAL) AS TOTAL, SUM(CANT_PERSONAS) AS CANT FROM reporte_ordenes_nofacturadas";

    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_row($resultado);
    mysqli_close($conexion);
    }
}
