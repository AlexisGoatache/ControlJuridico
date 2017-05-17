<?php
//SEGURIDAD DE ACCESO
require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATE DE VARIABLES DEL FORMULARIO
//$Sistema="Control Jur&iacute;dico";
//$FrmNombre="ConsultaPublicaciones";
//$FrmDescripcion="Consulta de Publicaciones";
//$TbNombre="tbpublicaciones";
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;
$TxtGaceta=isset($_REQUEST['TxtGaceta']) ? $_REQUEST['TxtGaceta'] : NULL;
$TxtNroPub=isset($_REQUEST['TxtNroPub']) ? $_REQUEST['TxtNroPub'] : NULL;
$TxtDescripcion=isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : NULL;
$TxtEntes=isset($_REQUEST['TxtEntes']) ? $_REQUEST['TxtEntes'] : NULL;
$CmbStatus=isset($_REQUEST['CmbStatus']) ? $_REQUEST['CmbStatus'] : NULL;
$_SESSION['FrmNombre']= isset($_REQUEST['FrmNombre']) ? $_REQUEST['FrmNombre'] : NULL;
$_SESSION['FrmDescripcion']= isset($_REQUEST['FrmDescripcion']) ? $_REQUEST['FrmDescripcion'] : NULL;
$_SESSION['TbNombre']= isset($_REQUEST['TbNombre']) ? $_REQUEST['TbNombre'] : NULL;
$_SESSION['TxtId']= isset($_REQUEST['TxtId']) ? $_REQUEST['TxtId'] : NULL;

//VARIABLES DEL FORMULARIO

$Sql="SELECT * FROM tbmenu WHERE mennom='frmconsultapublicaciones'";
$Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
while ($Registro = mysqli_fetch_array($Resultado)) {
	$_SESSION['FrmNombre']=$Registro['mennom'];
	$_SESSION['FrmDescripcion']=$Registro['mendes'];
	$_SESSION['TbNombre']=$Registro['tbmaestra'];	}


// DESARROLLAR LOGICA DE LOS BOTONES

if ($BtnAccion=='Limpiar'){
  $TxtGaceta='';
  $TxtNroPub='';
  $TxtDescripcion='';
  $TxtEntes='';
  $CmbTipos=0;
  $CmbStatus=0;

}

//switch($BtnAccion){
//case '':
//break;}


//FUNCIONES
//FUNCION QUE CONSTRUYE LA CONSULTA

function Query($TbNombre,$TxtGaceta,$TxtEntes,$TxtNroPub,$TxtDescripcion,$CmbStatus){

    $Consulta = '';
    if($TxtGaceta != ''){
      $Consulta = $Consulta." AND $TbNombre.pubgac LIKE '%$TxtGaceta%'";}
    if($TxtEntes != ''){
      $Consulta= $Consulta." AND $TbNombre.pubent LIKE '%$TxtEntes%'";}
    if($TxtNroPub != ''){
      $Consulta= $Consulta." AND $TbNombre.pubnro LIKE '%$TxtNroPub%'";}
    if($TxtDescripcion != ''){
      $Consulta= $Consulta." AND $TbNombre.pubdes LIKE '%$TxtDescripcion%'";}
    if($CmbStatus != 0){
      $Consulta= $Consulta." AND $TbNombre.pubsta= '$CmbStatus'";}

    $Sql="SELECT * FROM $TbNombre,tbstatus WHERE $TbNombre.pubsta=tbstatus.staid $Consulta GROUP BY $TbNombre.pubid ORDER BY $TbNombre.pubgac DESC;";

  // 4 EJECUTA LA CONSULTA
  global $Resultado;
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

          <th>Nro. Gaceta <br> <input type='text' size='15' maxlength='15' name='TxtGaceta' value="<? echo $TxtGaceta ?>"></th>

          <th>Ente Publicador <br> <input type='text' size='50' maxlength='50' name='TxtEntes' value="<? echo $TxtEntes ?>"></th>

          <th>Nro. de Publicaci�n <br> <input type='text' size='20' maxlength='20' name='TxtNroPub' value="<? echo $TxtNroPub ?>"></th>

          <th>Descripci�n <br> <input type='text' size='150' maxlength='150' name='TxtDescripcion' value="<? echo $TxtDescripcion ?>"></th>

          <th>Status <br>
            <select name="CmbStatus">
              <option value="0"><b>Status</b></option>
                <?//CARGA EL COMBO CON LOS TIPOS DE ESTATUS
                // 3. CONSTRUIR CONSULTA
                $Sql="SELECT * FROM tbstatus;";
                // 4 EJECUTA LA CONSULTA
                $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
                // 5 RECORRE EL RESULTADO
                while ($Registro = mysqli_fetch_array($Resultado)) {
                  echo "<option value='$Registro[staid]'>$Registro[stades]</option>";}?>
                </select></td>
          </th>
        </tr>

        <?
        Query($TbNombre,$TxtGaceta,$TxtEntes,$TxtNroPub,$TxtDescripcion,$CmbStatus);

       // 5 RECORRE EL RESULTADO
        $Registro=mysqli_fetch_array($Resultado);
        if(mysqli_num_rows($Resultado)>0){
          $i=0;
          do{
            $i=$i+1;?>
            <tr>
            <td><?echo $i?></td>
            <td><?echo "$Registro[pubid] </a>" ?></td>
            <td><?echo "$Registro[pubgac] </a>"?></td>
            <td><?echo "$Registro[pubent] </a>"?></td>
            <td><?echo "$Registro[pubnro] </a>"?></td>
            <td><?echo "$Registro[pubdes] </a>"?></td>
            <td><?echo "$Registro[stades] </a>"?></td>
            <tr>
          <?}while($Registro=mysqli_fetch_array($Resultado));
            } else {?>
           <script>alert ("No existen registros en la Base de Datos!!!");</script>
         <?}?>
</table>



</body>
</html>


