<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Datos de la conexión a la base de datos
$server = "localhost";  
$usuario = "root";     
$contraseña = "";        
$db = "logindb"; 

// Conectar a la base de datos
$conexion = mysqli_connect($server, $usuario, $contraseña, $db) or die("Error en la conexión: " . mysqli_connect_error());

// Obtener los datos del formulario
$nombreJugador = $_POST['nombreJugador'];
$posicionJugador = $_POST['posicionJugador'];
$edadJugador = $_POST['edadJugador'];
$nacionalidadJugador = $_POST['nacionalidadJugador'];

// Consulta para insertar el nuevo jugador
$insertarJugador = "INSERT INTO jugadores (nombre, posicion, edad, nacionalidad) 
                    VALUES ('$nombreJugador', '$posicionJugador', '$edadJugador', '$nacionalidadJugador')";

// Ejecutar la consulta
if (mysqli_query($conexion, $insertarJugador)) {
    echo "Jugador agregado correctamente.";
    // Redirigir a otra página, como una lista de jugadores o una página de administración
    header("Location: admin.html");
    exit();
} else {
    echo "Error al agregar el jugador: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
