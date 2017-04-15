<?
//INICIO DE SESSION DE USUARIO
session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

$Sistema="Control Jur&iacute;dico";
$FrmNombre="Gaceta";
$FrmDescripcion="Maestro de Gaceta";
$TbNombre="tbgacetas";



//DESARROLLAR LA LOGICA DE LOS BOTONES
$TxtId=$_REQUEST['TxtId'];
$CmbTipo=$_REQUEST['CmbTipo'];
$TxtAno=$_REQUEST['TxtAno'];
$TxtMes=$_REQUEST['TxtMes'];
$TxtFecha=$_REQUEST['TxtFecha'];
$CmbStatus=$_REQUEST['CmbStatus'];
$BtnAccion=$_REQUEST['BtnAccion'];

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM $TbNombre WHERE gacid='$TxtId';";
     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     // 5. verificar si lo encontro
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)>0){
         //6. recuperar registros
         $CmbTipo=$registro['gactip'];
         $TxtAno=$registro['gacano'];
         $TxtMes=$registro['gacmes'];
         $TxtFecha=$registro['gacfec'];
         $TxtStatus=$registro['gacsta'];
         } else {
         ?><script>alert ("<?echo $FrmNombre?> No encontrada!!!");</script><?
         $BtnAccion='Limpiar';}
break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE $TbNombre SET `gactip`='$CmbTipo',
                                `gacano`='$TxtAno',
                                `gacmes`='$TxtMes',
                                `gacsta`='$TxtStatus',
                                `gacfec`='$TxtFecha' WHERE gacid='$TxtId'";

     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     ?>
     <script>alert ("Los datos de <? echo $FrmNombre;?> fueron modificado con éxito!!!")</script>
     <?
break;


case 'Agregar':
     $sql="SELECT * FROM $TbNombre WHERE gacid='$TxtId';";
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)==0){
     $sql="INSERT INTO $TbNombre VALUES('$TxtId','$CmbTipo','$TxtAno','$TxtMes','$TxtFecha','$CmbStatus');";
     mysql_query($sql);
     ?>
       <script>alert ("Los datos de <? echo $FrmNombre;?> fueron registrados con éxito!!!");</script>
     <?
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Esta <? echo $FrmNombre;?> ya está registrada!!!");</script>
     <?
     }
break;
}

if ($BtnAccion=='Limpiar'){
     $TxtId='';
     $CmbTipo=0;
     $TxtAno='';
     $TxtMes='';
     $TxtFecha='';
     $CmbStatus='';
     unset($BtnAccion);}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<title><?echo $Sistema?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/basico.css" />

<!--alert('Bienvenido '+ '<? echo $_SESSION['usuario']?>' + ' ahora puedes aportar contenido a GuiasUba!!!');-->

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

       else if (form.CmbTipo.value==0){
         alert('Debe introducir un Tipo de <? echo $FrmNombre?>');
         form.CmbTipo.focus();
         return false;}

         else if (form.TxtAno.value== ""){
           alert('Debe introducir un Año de <? echo $FrmNombre?>');
           form.TxtAno.focus();
           return false;}

         else if (form.TxtMes.value== ""){
           alert('Debe introducir un Mes de <? echo $FrmNombre?>');
           form.TxtMes.focus();
           return false;}

           else if (form.TxtFecha.value== ""){
           alert('Debe introducir una Fecha de <? echo $FrmNombre?>');
           form.TxtFecha.focus();
           return false;}

     else {return true;}
}
</script>

</head>
<body bgcolor="#FFFFFF">
      <form action="<? $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form">
      <fieldset>
      <div align=center><h2><?echo $FrmDescripcion?></h2></div>

      <label>Id Gaceta:</label>
      <input type='text' size='8' maxlength='8' name='TxtId' value="<? echo $TxtId ?>"><br>

      <label>Tipo Gaceta:</label>
      <select name= "CmbTipo" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $sql = "SELECT * FROM tbtipogaceta;";
                $resultado=mysql_query($sql);
                while ($registro = mysql_fetch_array($resultado)){
                      if ($CmbTipo==$registro[tgaid]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"$registro[tgaid]\" $x> $registro[tgades]</option></b>";}
              ?>

       </select><br>

      <label>Año:</label>
      <input type='text' size='8' maxlength='8' name='TxtAno' value="<? echo $TxtAno ?>"><br>

      <label>Mes:</label>
      <input type='text' size='8' maxlength='8' name='TxtMes' value="<? echo $TxtMes ?>"><br>

      <label>Fecha:</label>
      <input type='text' size='10' maxlength='10' name='TxtFecha' value="<? echo $TxtFecha ?>"><br>

      <label>Status:</label>
      <select name= "CmbStatus" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $sql = "SELECT * FROM tbstatus;";
                $resultado=mysql_query($sql);
                while ($registro = mysql_fetch_array($resultado)){
                      if ($CmbTipo==$registro[gacsta]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"$registro[staid]\" $x> $registro[stades]</option></b>";}
              ?>

       </select><br>

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