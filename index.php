 <?php 
 //INICIAL EL ARCHIVO DE CONEXION PARA TODA LA PAGINA
require_once('conexion.php');

//INICIO DE SESION
session_unset();
//session_destroy();
session_start();
//var_dump($_SESSION);

//No chequeamos esta pagina en el navegador
session_cache_limiter('nocache,private');

// RESCATE DE VARIABLES DEL FORMULARIO

$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtUsuario = isset($_REQUEST['TxtUsuario']) ? $_REQUEST['TxtUsuario'] : NULL;
$TxtPassword = isset($_REQUEST['TxtPassword']) ? $_REQUEST['TxtPassword'] : NULL;
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;

// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmempresas'";
$Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}


//Comprobacion del envio del nombre de usuario y password

// DESARROLLAR LOGICA DE LOS BOTONES

if ($BtnAccion=='Enviar'){

  $Sql="SELECT * FROM tbempresas WHERE empid='$TxtUsuario'";
  $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );

  if(mysqli_num_rows($Resultado)>0){ //SI LA CANTIDAD DE REGISTROS ES MAYOR QUE 0
    $Registro=mysqli_fetch_array($Resultado); //TRAIGO COMO ARRAY LA INF.
    if ($Registro['empcla']==$TxtPassword){
      $_SESSION['empid']=$TxtUsuario; //APERTURA LA SESION DEL USUARIO
      $_SESSION['empdes']=$Registro['empnom'];
		  ?><script>window.location='frmmenucss.php'; </script><?php
	  }else{?><script>alert('La contrase�a no conincide');</script><?php } 
	  }else{?><script>alert('El usuario: << '+'<?php echo $TxtUsuario?>'+' >> no existe' );</script><?php }
	  }
  ?>	

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title> <?php echo $_SESSION['FrmDescripcion']?> </title>
<link rel="stylesheet" type="text/css" href="css/miestilo.css" />
</head>
<body>

<form action="<?php $PHP_SELF ?>" name="<?php echo $_SESSION[FrmNombre]?>" method="post">
  <fieldset>
    <legend> <?php echo $_SESSION['FrmDescripcion'] ?> </legend>
    <table>
      <tr>
        <td>
          <label>USUARIO:</label>
          <input type="text"
                  name="TxtUsuario"
                  value="<?php echo $TxtUsuario?>"
                  maxlength="10" 
                  placeholder="Usuario"/><br />
        </td>
      </tr>
      <tr>
        <td>
          <label>PASSWORD:</label>
          <input type="password"
                  name="TxtPassword"
                  value="<?php echo $TxtPassword?>"
                  maxlength="10" 
                  placeholder="Password"/><br />
        </td>
      </tr>
</table>
<hr />
 
<div align="center">
    <input type="submit" name="BtnAccion" value="Enviar" /> 
<div>


<div align="center">
  <img src="imagenes/image001.gif" alt="" title="construccionx" width="301" height="351" border="0" />
<div>
</fieldset>
    

</body>

<script>

</script>
</form>
</html>


