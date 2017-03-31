<?

//INICIO DE SESSION DE USUARIO
session_start();

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATE DE VARIABLES DEL FORMULARIO
$BtnAccion=$_REQUEST['BtnAccion'];
$TxtGaceta=$_REQUEST['TxtGaceta'];
$TxtNroPub=$_REQUEST['TxtNroPub'];
$TxtDescripcion=$_REQUEST['TxtDescripcion'];
$TxtEntes=$_REQUEST['TxtEntes'];
$CmbStatus=$_REQUEST['CmbStatus'];


//VARIABLES DEL FORMULARIO
$Sistema="Control Jur&iacute;dico";
$FrmNombre="ConsultaPublicaciones";
$FrmDescripcion="Consulta de Publicaciones";
$TbNombre="tbpublicaciones";


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
  global $resultado;
  $resultado = mysql_query($Sql) or die( "Error en $Sql: " . mysql_error() );
  return $resultado;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><?echo $FrmDescripcion?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/consulta.css" />
</head>

<body <!--bgcolor="#FFFFFF"-->

<form action="<? $PHP_SELF ?>" name="<?echo $FrmDescripcion?>" method="post">
  <fieldset>
    <div align=center><h2><?echo $FrmDescripcion?></h2></div>
    <!--legend> <?echo $FrmDescripcion?> </legend-->
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

          <th>Nro. de Publicación <br> <input type='text' size='20' maxlength='20' name='TxtNroPub' value="<? echo $TxtNroPub ?>"></th>

          <th>Descripción <br> <input type='text' size='150' maxlength='150' name='TxtDescripcion' value="<? echo $TxtDescripcion ?>"></th>

          <th>Status <br>
            <select name="CmbStatus">
              <option value="0"><b>Status</b></option>
                <?//CARGA EL COMBO CON LOS TIPOS DE ESTATUS
                // 3. CONSTRUIR CONSULTA
                $sql="SELECT * FROM tbstatus;";
                // 4 EJECUTA LA CONSULTA
                $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
                // 5 RECORRE EL RESULTADO
                while ($registro = mysql_fetch_array($resultado)) {
                  echo "<option value='$registro[staid]'>$registro[stades]</option>";}?>
                </select></td>
          </th>
        </tr>

        <?
        Query($TbNombre,$TxtGaceta,$TxtEntes,$TxtNroPub,$TxtDescripcion,$CmbStatus);

       // 5 RECORRE EL RESULTADO
        $registro=mysql_fetch_array($resultado);
        if(mysql_num_rows($resultado)>0){
          $i=0;
          do{
            $i=$i+1;?>
            <tr>
            <td><?echo $i?></td>
            <td><?echo "$registro[pubid] </a>" ?></td>
            <td><?echo "$registro[pubgac] </a>"?></td>
            <td><?echo "$registro[pubent] </a>"?></td>
            <td><?echo "$registro[pubnro] </a>"?></td>
            <td><?echo "$registro[pubdes] </a>"?></td>
            <td><?echo "$registro[stades] </a>"?></td>
            <tr>
          <?}while($registro=mysql_fetch_array($resultado));
            } else {?>
           <script>alert ("No existen registros en la Base de Datos!!!");</script>
         <?}?>
</table>



</body>
</html>


