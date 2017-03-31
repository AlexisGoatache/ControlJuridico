<?

//INICIO DE SESSION DE USUARIO
session_start();

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATE DE VARIABLES DEL FORMULARIO
$BtnAccion=$_REQUEST['BtnAccion'];
$TxtEnte=$_REQUEST['TxtEnte'];


//VARIABLES DEL FORMULARIO
$Sistema="Control Jur&iacute;dico";
$FrmNombre="ConsultaEntes";
$FrmDescripcion="Consulta de Entes";
$TbNombre="tbentes";


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

  if($TxtEnte == ''){
     $sql="SELECT * FROM $TbNombre ORDER BY $TbNombre.entdes ASC;";
     } else {
     $sql="SELECT * FROM $TbNombre WHERE $TbNombre.entdes LIKE '%$TxtEnte%' ORDER BY entdes ASC;";
     }
  // 4 EJECUTA LA CONSULTA
  global $resultado;
  $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
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
          <th><input type='text' size='100' maxlength='100' name='TxtEnte' value="<? echo $TxtEnte ?>"></th>
        </tr>

        <?

        Query($TbNombre,$TxtEnte);

       // 5 RECORRE EL RESULTADO
        $registro=mysql_fetch_array($resultado);
        if(mysql_num_rows($resultado)>0){
          $i=0;
          do{
            $i=$i+1;?>
            <tr>
            <td><?echo $i?></td>
            <td><?echo "$registro[entid] </a>" ?></td>
            <td><?echo "$registro[entdes] </a>"?></td>
            <tr>
          <?}while($registro=mysql_fetch_array($resultado));
            } else {?>
           <script>alert ("No existen registros en la Base de Datos!!!");</script>
         <?}?>
</table>



</body>
</html>


