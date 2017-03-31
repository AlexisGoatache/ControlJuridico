<?
//INICIO DE SESSION DE USUARIO
session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

$Sistema="Control Jur&iacute;dico";
$FrmNombre="Ente";
$FrmDescripcion="Maestro de Entes";
$TbNombre="tbentes";

//DESARROLLAR LA LOGICA DE LOS BOTONES
$TxtId=$_REQUEST['TxtId'];
$TxtDescripcion=$_REQUEST['TxtDescripcion'];
$BtnAccion=$_REQUEST['BtnAccion'];

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM $TbNombre WHERE entid='$TxtId';";
     //4. Ejecutar la consulta
     $resultado=mysql_query($sql);
     // 5. verificar si lo encontro
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)>0){
         //6. recuperar registros
         $TxtDescripcion=$registro['entdes'];
         } else {
         ?>
         <script>alert ("Registro No encontrado!!!");</script>
         <?
         $BtnAccion='Limpiar';}
break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE $TbNombre SET `entdes`='$TxtDescripcion' WHERE entid='$TxtId'";

     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     ?>
     <script>alert ("Los datos de <? echo $FrmNombre;?> fueron modificado con éxito!!!")</script>
     <?
break;

case 'Agregar':
     $sql="SELECT * FROM $TbNombre WHERE entdes='$TxtDescripcion';";
     $resultado=mysql_query($sql);
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)==0){
     $sql="INSERT INTO $TbNombre VALUES('','$TxtDescripcion');";
     mysql_query($sql);
     ?>
       <script>alert ("Los datos de <? echo $FrmNombre;?> fueron registrados con éxito!!!");</script>
     <?
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Este <? echo $FrmNombre;?> ya está registrado!!!");</script>
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
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/basico.css" />

<script>
function validabuscar(form){

    if (form.TxtId.value== ""){
       alert('Debe introducir un Id');
       form.TxtId.focus();
       return false;}

       elseif (form.TxtDescripcion.value== ""){
       alert('Debe introducir una Descripcion');
       form.TxtDescripcion.focus();
       return false;}

     else {return true;}
}

function validar(form){

    if (form.TxtId.value== ""){
       alert('Debe introducir un Id');
       form.TxtId.focus();
       return false;}

       else if (form.TxtDescripcion.value== ""){
       alert('Debe introducir una Descripcion');
       form.TxtDescripcion.focus();
       return false;}

     else {return true;}
}
</script>

</head>
<body bgcolor="#FFFFFF">
      <form action="<? $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form">
      <fieldset>
      <div align=center><h2><?echo $FrmDescripcion?></h2></div>

      <label>Id Ente:</label>

      <input type='text' size='2' maxlength='2' name='TxtId' value="<? echo $TxtId ?>"><br>

      <label>Descripci&oacute;n:</label>
      <input type='text' size='100' maxlength='100' name='TxtDescripcion' value="<? echo $TxtDescripcion ?>"></textarea><br>

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