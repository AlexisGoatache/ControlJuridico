<?
//INICIO DE SESSION DE USUARIO
session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

$Sistema="Control Jur&iacute;dico";
$FrmNombre="Publicacion";
$FrmDescripcion="Maestro de Publicaciones";
$TbNombre="tbpublicaciones";



//DESARROLLAR LA LOGICA DE LOS BOTONES
$TxtId=$_REQUEST['TxtId'];
$CmbGaceta=$_REQUEST['CmbGaceta'];
$CmbEnte=$_REQUEST['CmbEnte'];
$CmbTipo=$_REQUEST['CmbTipo'];
$TxtNroPub=$_REQUEST['TxtNroPub'];
$TxaDesPub=$_REQUEST['TxaDesPub'];
$CmbStatus=$_REQUEST['CmbStatus'];
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $Sql="SELECT * FROM $TbNombre WHERE pubid='$TxtId';";
     //4. Ejecutar la consulta
      = mysqli_query($Sql) or die( "Error en $Sql: " . mysqli_error() );
     // 5. verificar si lo encontro
     =mysqli_fetch_array();
     if(mysqli_num_rows()>0){
         //6. recuperar registros
         $CmbGaceta=['gacid'];
         $CmbEnte=['entid'];
         $CmbTipo=['tinid'];
         $TxtNroPub=['pubnro'];
         $TxaPubDes=['pubdes'];
         $CmbStatus=['staid'];
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
     $Sql="INSERT INTO $TbNombre VALUES('','$CmbTipo','$Cmb','$TxtMes','$TxtFecha','$TxtStatus');";
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
     $CmbGaceta=0;
     $CmbEnte=0;
     $CmbTipo=0;
     $TxtNroPub='';
     $TxaPubDes='';
     $CmbStatus=0;
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

         if (form.CmbGaceta.value==0){
           alert('Debe introducir un Nro de Gaceta');
           form.CmbGaceta.focus();
           return false;}

         else if (form.CmbEnte.value==0){
         alert('Debe introducir un Ente de <? echo $FrmNombre?>');
         form.CmbEnte.focus();
         return false;}

         else if (form.CmbTipo.value==0){
         alert('Debe introducir un Tipo de <? echo $FrmNombre?>');
         form.CmbTipo.focus();
         return false;}

         else if (form.TxaDesPub.value==""){
         alert('Debe introducir una Descripcion de <? echo $FrmNombre?>');
         form.TxaDesPub.focus();
         return false;}

         else if (form.CmbStatus.value==0){
         alert('Debe introducir el Status de <? echo $FrmNombre?>');
         form.CmbStatus.focus();
         return false;}

     else {return true;}
}
</script>

</head>
<body>
      <form action="<? $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form">
      <fieldset>
      <div align=center><h2><?php  echo $_SESSION['FrmDescripcion']; ?></h2></div>

      <label>Id Publicacion:</label>
      <input type='text' size='8' maxlength='8' name='TxtId' value="<? echo $TxtId ?>"><br>

      <label>Gaceta:</label>
      <select name= "CmbGaceta" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $Sql = "SELECT gacid FROM tbgacetas ORDER BY gacid ASC;";
                $Resultado=mysqli_query($Conexion,$Sql);
                while ( = mysqli_fetch_array()){
                      if ($CmbGaceta==[gacid]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"[gacid]\" $x> [gacid]</option></b>";}
              ?>

       </select><br>

      <label>Ente:</label>
      <select name= "CmbEnte" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $Sql = "SELECT * FROM tbentes ORDER BY entdes ASC;";
                $Resultado=mysqli_query($Conexion,$Sql);
                while ( = mysqli_fetch_array()){
                      if ($CmbEnte==[entid]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"[entid]\" $x> [entdes]</option></b>";}
              ?>
       </select><br>

      <label>Tipo Publicaci&oacute;:</label>
      <select name= "CmbTipo" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $Sql = "SELECT * FROM tbtipoinstrumentos ORDER BY tindes ASC;";
                $Resultado=mysqli_query($Conexion,$Sql);
                while ( = mysqli_fetch_array()){
                      if ($CmbEnte==[tinid]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"[tinid]\" $x> [tindes]</option></b>";}
              ?>
       </select><br>

      <label>Nro Publicacion:</label>
      <input type='text' size='8' maxlength='8' name='TxtNroPub' value="<? echo $TxtNroPub ?>"><br>

      <label>Descripcion:</label>
      <textarea rows='10' cols='58' name='TxaDesPub' maxlength='2000' value="<? echo $TxaDesPub ?>"></textarea><br>

      <label>Status:</label>
      <select name= "CmbStatus" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $Sql = "SELECT * FROM tbstatus;";
                $Resultado=mysqli_query($Conexion,$Sql);
                while ( = mysqli_fetch_array()){
                      if ($CmbTipo==[staid]){$x='Selected'; }else{$x='';}
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