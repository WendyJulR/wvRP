<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = "localhost";  
$usuario = "root";     
$contraseña = "";        
$db = "logindb"; 

$conexion = mysqli_connect($server, $usuario, $contraseña, $db) or die("Error en la conexión: " . mysqli_connect_error());

// Obtener datos del formulario
$nombre = $_POST['txtnombre'];
$contra = $_POST['txtContraseña'];

// Consulta para verificar el usuario
$consulta = "SELECT * FROM usuarios WHERE nombre='$nombre'";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Verificar si el usuario existe
if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    
    // Verificar la contraseña
    if (password_verify($contra, $fila['contraseña'])) {
        session_start();
        $_SESSION['usuario'] = $nombre;
        header("Location: admin.html");
        exit();
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }
} else {
    echo "Nombre de usuario o contraseña incorrectos.";
}

mysqli_close($conexion);
?>
