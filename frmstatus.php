<?
//INICIO DE SESSION DE USUARIO
session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

$Sistema="Control Jur&iacute;dico";
$FrmNombre="Status";
$FrmDescripcion="Maestro de Status";
$TbNombre="tbstatus";



//DESARROLLAR LA LOGICA DE LOS BOTONES
$TxtId=$_REQUEST['TxtId'];
$TxtDescripcion=$_REQUEST['TxtDescripcion'];
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $TbNombre WHERE staid='$TxtId';";
     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     // 5. verificar si lo encontro
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)>0){
         //6. recuperar registros
         $TxtDescripcion=$Registro['stades'];
         } else {
         ?><script>alert ("<?echo $FrmNombre?> No encontrada!!!");</script><?
         $BtnAccion='Limpiar';}
break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $Sql="UPDATE $TbNombre SET `stades`='$TxtDescripcion' WHERE staid='$TxtId'";

     //4. Ejecutar la consulta
     $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     ?>
     <script>alert ("Los datos de <? echo $FrmNombre;?> fueron modificado con �xito!!!")</script>
     <?
break;


case 'Agregar':
     $Sql="SELECT * FROM $TbNombre WHERE staid='$TxtId';";
     $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
     $Registro=mysqli_fetch_array($Resultado);
     if(mysqli_num_rows($Resultado)==0){
     $Sql="INSERT INTO $TbNombre VALUES('','$TxtDescripcion');";
     mysqli_query($Sql);
     ?>
       <script>alert ("Los datos de <? echo $FrmNombre;?> fueron registrados con �xito!!!");</script>
     <?
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Este <? echo $FrmNombre;?> ya est� registrado!!!");</script>
     <?
     }
break;
}

if ($BtnAccion=='Limpiar'){
     $TxtId='';
     $TxtDescripcion='';
     unset($BtnAccion);}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<title><?echo $Sistema?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" type="text/css" href="css/basico.css" />


<script>

function validabuscar(form){

    if (form.TxtId.value== ""){
       alert('Debe introducir un Id');
       form.TxtId.focus();
       return false;}

     else {return true;}
}

function validar(form){

    if (form.TxtId.value== ""){
       alert('Debe introducir un Id');
       form.TxtId.focus();
       return false;}

          else if (form.TxtDescripcion.value== ""){
           alert('Debe introducir una Descripcion de <? echo $FrmNombre?>');
           form.TxtDescripcion.focus();
           return false;}

     else {return true;}
}
</script>

</head>
<body>
      <form action="<? $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form">
      <fieldset>
      <div align=center><h2><?php  echo $_SESSION['FrmDescripcion']; ?></h2></div>

      <label>Id Status:</label>
      <input type='text' size='2' maxlength='2' name='TxtId' value="<? echo $TxtId ?>"><br>

      <label>Descripcion:</label>
      <input type='text' size='20' maxlength='20' name='TxtDescripcion' value="<? echo $TxtDescripcion ?>"><br>

       <hr />

       <div align=center>
            <input type="submit" name="BtnAccion" value="Buscar" onclick="return validabuscar(this.form);" />
            <input type="submit" name="BtnAccion" value="Agregar" onclick="return validar(this.form);" />
            <input type="submit" name="BtnAccion" value="Modificar" onclick="return validar(this.form);" />
            <input type="submit" name="BtnAccion" value="Limpiar" />
      </div>

     </fieldset>
     </form>
</body>


</html>