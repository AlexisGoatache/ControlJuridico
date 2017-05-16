<?

//INICIO DE SESION
session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

//VARIABLES DEL FROMULARIO
$FrmNombre="CamposDocumento";
$FrmDescripcion="Campo del Documento";
$TbNombre="tbcamposdoc";

//DESARROLLAR LA LOGICA DE LOS BOTONES

$CmbMateria=$_REQUEST['CmbMateria'];
$TxtTitulo=$_REQUEST['TxtTitulo'];
$TxaDescripcion=$_REQUEST['TxaDescripcion'];
$archivo=$_REQUEST['archivo'];
$BtnAccion = isset($_REQUEST['BtnAccion']) ? $_REQUEST['BtnAccion'] : NULL;

if ($_SESSION['usuario']==NULL){ //comprueba que tenga hecha una session para aportar contenido.
?>
  <script>
      alert ("Para aportar contenido a GuiasUba, debes estar logueado");
      top.frames['mainframe'].location = "http://localhost/ControlJuridico/principal.php";
  </script>

<?
    }else{

switch($BtnAccion){

case 'Guardar':

//accion del boton guardar

     //asigna la carpeta donde debe copiarse el material
     $directorio = $_SERVER['DOCUMENT_ROOT'].'/materias/';

     //ubica la extension del archivo
     $separar = explode(".",$_FILES['archivo']['name']);
     $extension=$separar[1];

     $Sql = mysqli_query("SELECT idmaterial FROM tbmaterialmaterias ORDER BY idmaterial DESC LIMIT 1;");
      = mysqli_fetch_array($Sql);
     $nombre=[0]+1;

     if ($extension=='pdf' or $extension=='doc' or $extension=='docx'){

        $nombrearchivo=$nombre.".".$extension;
        $uploadfile = $directorio . basename($nombrearchivo);
        $subido = move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile);
        $error = $_FILES['archivo']['error'];

        if($subido) {
                    //$Conexion =mysqli_connect ('localhost', 'root', 'oh43ts7259i9q18');
                    //mysqli_select_db('bdguiasuba');
                    $Sql = "INSERT INTO tbmaterialmaterias VALUES ('NULL',
                                                                   '$CmbMateria',
                                                                   '$_SESSION[usuario]',
                                                                   '$TxtTitulo',
                                                                   '$nombrearchivo',
                                                                   '$_POST[TxaDescripcion]','1');";
                    $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
                    echo "<script>alert (\"El archivo fue subido con exito!!!\");</script>";
                    $BtnAccion=='Limpiar';

        } else { echo "<script>alert (\"Error al subir archivo!!\");</script>";}
      } else { echo "<script>alert (\"No puede subir ese tipo de archivo, cambie el formato a .pdf, .doc o .docx!!\");</script>";}

     //echo "$Sql: ".mysqli_error; //Muestra los errores de la BD
     break;

case 'Limpiar':

//accion del boton guardar
     $CmbMateria=0;
     $TxtTitulo='';
     $TxaDescripcion='';
     $archivo='';
     unset($BtnAccion);
     break;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<title>GUIASUBA - APORTA CONTENIDO</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" type="text/css" href="css/basico.css" />


<script>
function validar(form){

    if (form.TxtTitulo.value== ""){
       alert('Debes introducir un Titulo');
       form.TxtTitulo.focus();
       return false;}

       else if (form.CmbMateria.value==0 ){
            alert('Debe seleccionar una Materia');
            form.CmbMateria.focus();
            return false;}

            else if (form.archivo.value==0 ){
                 alert('Debe seleccionar un Archivo');
                 form.archivo.focus();
                 return false;}

     else {return true;}
}
</script>

</head>
<body>
      <form action="<? $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form">
      <div align=center><h2>APORTA CONTENIDO</h2></div>

      <fieldset>
      <!--<legend> FORMULARIO USUARIO </legend>-->
      <label>MATERIA:</label>
      <select name= "CmbMateria" size="1"><br>
              <option value="0" >Seleccione</option>
              <?
                $Sql = "SELECT * FROM tbmateria;";
                $Resultado = mysqli_query($Conexion,$Sql) or die( "Error en Sql: " . mysqli_error($Conexion) );
                while ( $Registro=mysqli_fetch_array($Resultado);){
                      if ($CmbMateria==[0]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"[idmateria]\" $x> [materia]
                 ([idmateria])</option></b>";}
              ?>

       </select><br>

       <label>T&Iacute;TULO:</label>
       <input type='text' size='50' maxlength='50' name='TxtTitulo' value="<? echo $TxtTitulo ?>"><br>
       <label>AUTOR: </label><b><? echo $_SESSION['usuario'] ?> <br></b>
       <label>DESCRIPCI&Oacute;N DEL MATERIAL:</label>
       <textarea rows='10' cols='58' name='TxaDescripcion' maxlength='150' value="<? echo $TxaDescripcion ?>"></textarea><br>
       <label for="archivo"><b>Archivo</b></label>
       <input name='MAX_FILE_SIZE' type='hidden' value='5242880'><!--Sube archivos de hasta 5MB-->
       <input type='file' name='archivo' size='30' value="<? echo $archivo ?>"></td>
       
       <hr />

       <div align=center>
            <input type="submit" name="BtnAccion" value="Guardar" onclick="return validar(this.form);" />
            <input type="submit" name="BtnAccion" value="Limpiar" />
      </div>

     </fieldset>
     </form>
</body>
</html><? } ?>