<?

//INICIO DE SESSION DE USUARIO
//session_start();

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATE DE VARIABLES DEL FORMULARIO
$BtnAccion=isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtEnte=isset($_REQUEST['TxtEnte']) ? $_REQUEST['TxtEnte'] : NULL;


//VARIABLES DEL FORMULARIO
$Sistema="Control Jur&iacute;dico";
$FrmNombre="ConsultaEntes";
$FrmDescripcion="Consulta de Entes";
$TbNombre="tbentes";
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;



// DESARROLLAR LOGICA DE LOS BOTONES

//switch($BtnAccion){
//case 'Limpiar':
//break;}

if ($BtnAccion=='Limpiar'){
   $TxtEnte='';
}
   

//FUNCIONES
//FUNCION QUE CONSTRUYE LA CONSULTA
function Query($TbNombre,$TxtEnte){
  global $Resultado,$Conexion;

  if($TxtEnte == ''){
     $Sql="SELECT * FROM $TbNombre ORDER BY $TbNombre.entdes ASC;";
     } else {
     $Sql="SELECT * FROM $TbNombre WHERE $TbNombre.entdes LIKE '%$TxtEnte%' ORDER BY $TbNombre.entdes ASC;";
     }
  // 4 EJECUTA LA CONSULTA
  $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
  return $Resultado;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><?php  echo $_SESSION['FrmDescripcion']; ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" type="text/css" href="css/consulta.css" />
</head>

<body <!--bgcolor="#FFFFFF"-->

<form action="<? $PHP_SELF ?>" name="<?php  echo $_SESSION['FrmDescripcion']; ?>" method="post">
  <fieldset>
    <div align=center><h2><?php  echo $_SESSION['FrmDescripcion']; ?></h2></div>
    <!--legend> <?php  echo $_SESSION['FrmDescripcion']; ?> </legend-->
      <table>
        <tr>
          <div align=center>
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
          </div>
        </tr>
        <hr />
        <tr>
          <th>#</th>
          <th>Id</th>
          <th><input type='text' size='100' maxlength='100' name='TxtEnte' value="<? echo $TxtEnte ?>"></th>
        </tr>

        <?

        Query($TbNombre,$TxtEnte);

       // 5 RECORRE EL RESULTADO
        $Registro=mysqli_fetch_array($Resultado);
        if(mysqli_num_rows($Resultado)>0){
          $i=0;
          do{
            $i=$i+1;?>
            <tr>
            <td><?echo $i?></td>
            <td><?echo "$Registro[entid] </a>" ?></td>
            <td><?echo "$Registro[entdes] </a>"?></td>
            <tr>
          <?}while($Registro=mysqli_fetch_array($Resultado));
            } else {?>
           <script>alert ("No existen registros en la Base de Datos!!!");</script>
         <?}?>
</table>



</body>
</html>


