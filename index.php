<html lang="en">
<?php
//phpinfo();
?>
<head>
    <title>AUTOMARISCOS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <script src="jquery/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script disable-devtool-auto src='js/disable-devtool/disabledev.js'></script>
    <!-- <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="css/form-elements.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="jquery/jquery-3.6.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body style="background-image: url('images/bgauto.jpg'); " >

    <!-- Top content -->
<div class="top-content">
<!-- <link rel="stylesheet" href="./style.css"> -->
<!-- partial:index.partial.html -->
<div id="login-form-wrap" style="width:400px;">
<img src="images/autologo.jpg" alt="Chachalacas" width="200" height="200">
  <h2>Ingreso</h2>
    <form id="login-form">
    <p>
    <input type="text" id="user11" name="user11" placeholder="Usuario" required><i class="validation"></i>
    </p>
    <p> 
    <input type="password" id="pass11" name="pass11" placeholder="contraseña" required><i class="validation"></i>
    </p>
    <p>
    <input type="button" class="bg-primary" id="login" value="Ingresar" onClick="logins()">
    </p>
    </form>
    <div id="create-account-wrap">
    <p>Bienvenido, ingrese su usuario y contraseña</a><p>
    </div><!--create-account-wrap-->
    </div><!--login-form-wrap-->
         <!-- partial -->
       <div><label bgcolor="black"> Ver. 1.0.0</label></div>
    </div>

</body>

       
<script type="text/javascript">

  function logins()
  {
    var usuario = document.getElementById('user11').value;
      //si esta logeado crear el menu
      $.ajax({
        type: "POST",
        url: "inter_log.php",
        datatype: "html",
        data: {
           estado: 'login',
           usuario: document.getElementById('user11').value,
           pass:  document.getElementById('pass11').value,
        },
        beforeSend: function() {

        },
        success: function(r) {
          //si fue exitoso se logea y se guarda
      
          if (r==1)
          {
          // guarda usuario logeado
           sessionStorage.setItem('currentloggedin', document.getElementById('user11').value);
           //abre pag principal
           window.location = "main_page.php";
          } else if (r == 99) 
          {
            Swal.fire({
                    icon: 'info',
                    title: 'ERROR DE LICENCIA DEL SISTEMA',
                    html: 'Licencia invalida! contacte al Administrador de Sistema <br> No esta autorizado a ingresar al sistema'
                }).then(function() {
                });
          }
          else if (r == 100) 
          {
            Swal.fire({
                    icon: 'info',
                    title: 'ERROR DE LICENCIA DEL SISTEMA',
                    html: 'La licencia en el servidor esta corrupta, contacte al Administrador de sistema'
                }).then(function() {
                });
          }
          else
          {
            Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: 'Ingrese un Usuario/Password valido!'
                }).then(function() {
                });
          }

        }

      });
  }
  
    
</script>

</html>