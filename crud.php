<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logindb"; // Cambia esto por el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["imagen"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$uploadOk = 1;

// Verificar si la imagen es una imagen real
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }
}

// Verificar si el archivo ya existe
if (file_exists($target_file)) {
    echo "Lo sentimos, el archivo ya existe.";
    $uploadOk = 0;
}

// Verificar el tamaño del archivo
if ($_FILES["imagen"]["size"] > 500000) { // Limitar a 500KB
    echo "Lo sentimos, el archivo es demasiado grande.";
    $uploadOk = 0;
}

// Permitir ciertos formatos de archivo
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Lo sentimos, solo se permiten archivos JPG, JPEG, PNG y GIF.";
    $uploadOk = 0;
}

// Verificar si $uploadOk es 0 por un error
if ($uploadOk == 0) {
    echo "Lo sentimos, tu archivo no fue subido.";
} else {
    // Si todo está bien, intenta subir el archivo
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una nueva categoría
            $nombre = $_POST['nombre'];
            $sql = "INSERT INTO categorias (nombre, imagen) VALUES ('$nombre', '$target_file')";
            $conn->query($sql);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            // Actualizar una categoría
            parse_str(file_get_contents("php://input"), $_PUT);
            $id = $_PUT['id'];
            $nombre = $_PUT['nombre'];
            $sql = "UPDATE categorias SET nombre='$nombre' WHERE id='$id'";
            $conn->query($sql);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Eliminar una categoría
            parse_str(file_get_contents("php://input"), $_DELETE);
            $id = $_DELETE['id'];
            $sql = "DELETE FROM categorias WHERE id='$id'";
            $conn->query($sql);
        }
        echo "El archivo ". htmlspecialchars(basename($_FILES["imagen"]["name"])). " ha sido subido.";
    } else {
        echo "Lo sentimos, hubo un error al subir tu archivo.";
    }
}

$conn->close();
?>
