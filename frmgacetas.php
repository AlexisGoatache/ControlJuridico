<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATAR LAS VARIABLES DEL FORMULARIO

//$Sistema="Control Jur&iacute;dico";
//$FrmNombre="Gaceta";
//$FrmDescripcion="Maestro de Gaceta";
//$TbNombre="tbgacetas";

$TxtId=isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;
$CmbTipo=isset($_REQUEST['CmbTipo']) ? $_REQUEST['CmbTipo'] : NULL;
$TxtAno=isset($_REQUEST['TxtAno']) ? $_REQUEST['TxtAno'] : NULL;
$TxtMes=isset($_REQUEST['TxtMes']) ? $_REQUEST['TxtMes'] : NULL;
$TxtFecha=isset($_REQUEST['TxtFecha']) ? $_REQUEST['TxtFecha'] : NULL;
$CmbStatus=isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;
$_SESSION['TxtId']= isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;


// VARIABLES DEL FORMULARIO
$Sql="SELECT * FROM tbmenu WHERE mennom='frmcgacetas'";
$Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];
	}


//DESARROLLAR LA LOGICA DE LOS BOTONES

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $TbNombre WHERE gacid='$TxtId';";
     //4. Ejecutar la consulta
      = mysqli_query($Sql) or die( "Error en $Sql: " . mysqli_error() );
     // 5. verificar si lo encontro
     =mysqli_fetch_array();
     if(mysqli_num_rows()>0){
         //6. recuperar registros
         $CmbTipo=['gactip'];
         $TxtAno=['gacano'];
         $TxtMes=['gacmes'];
         $TxtFecha=['gacfec'];
         $TxtStatus=['gacsta'];
         } else {
         ?><script>alert ("<?echo $FrmNombre?> No encontrada!!!");</script><?
         $BtnAccion='Limpiar';}
break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $Sql="UPDATE $TbNombre SET `gactip`='$CmbTipo',
                                `gacano`='$TxtAno',
                                `gacmes`='$TxtMes',
                                `gacsta`='$TxtStatus',
                                `gacfec`='$TxtFecha' WHERE gacid='$TxtId'";

     //4. Ejecutar la consulta
      = mysqli_query($Sql) or die( "Error en $Sql: " . mysqli_error() );
     ?>
     <script>alert ("Los datos de <? echo $FrmNombre;?> fueron modificado con �xito!!!")</script>
     <?
break;


case 'Agregar':
     $Sql="SELECT * FROM $TbNombre WHERE gacid='$TxtId';";
      = mysqli_query($Sql) or die( "Error en $Sql: " . mysqli_error() );
     =mysqli_fetch_array();
     if(mysqli_num_rows()==0){
     $Sql="INSERT INTO $TbNombre VALUES('$TxtId','$CmbTipo','$TxtAno','$TxtMes','$TxtFecha','$CmbStatus');";
     mysqli_query($Sql);
     ?>
       <script>alert ("Los datos de <? echo $FrmNombre;?> fueron registrados con �xito!!!");</script>
     <?
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Esta <? echo $FrmNombre;?> ya est� registrada!!!");</script>
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
           alert('Debe introducir un A�o de <? echo $FrmNombre?>');
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
<body>
      <form action="<? $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form">
      <fieldset>
      <div align=center><h2><?php  echo $_SESSION['FrmDescripcion']; ?></h2></div>

      <label>Id Gaceta:</label>
      <input type='text' size='8' maxlength='8' name='TxtId' value="<? echo $TxtId ?>"><br>

      <label>Tipo Gaceta:</label>
      <select name= "CmbTipo" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $Sql = "SELECT * FROM tbtipogaceta;";
                $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
                while ( $Registro=mysqli_fetch_array($Resultado);){
                      if ($CmbTipo==[tgaid]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"[tgaid]\" $x> [tgades]</option></b>";}
              ?>

       </select><br>

      <label>A�o:</label>
      <input type='text' size='8' maxlength='8' name='TxtAno' value="<? echo $TxtAno ?>"><br>

      <label>Mes:</label>
      <input type='text' size='8' maxlength='8' name='TxtMes' value="<? echo $TxtMes ?>"><br>

      <label>Fecha:</label>
      <input type='text' size='10' maxlength='10' name='TxtFecha' value="<? echo $TxtFecha ?>"><br>

      <label>Status:</label>
      <select name= "CmbStatus" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $Sql = "SELECT * FROM tbstatus;";
                $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
                while ( $Registro=mysqli_fetch_array($Resultado);){
                      if ($CmbTipo==[gacsta]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"[staid]\" $x> [stades]</option></b>";}
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