<?php 
session_start();

// Obtener los datos del formulario de login
$user_admin = $_POST['user_admin'];
$password = $_POST['password'];

require("../modelo/m_admin.php");

// Verificar las credenciales
$admin = VerificarAdmin($user_admin, $password);

// Si existe este usuario
if ($admin) {
    // Crear variables de sesión
    $_SESSION['autentificado'] = TRUE;
    $_SESSION['id_session'] = $admin; // Guardamos el ID del administrador

    // Redirigir al menú principal
    echo "<script type='text/javascript'>window.location.href = '../MenuV.php';</script>";
    exit();
} else {
    // Mostrar mensaje de error y redirigir
    echo "<script>
        alert('Usuario o contraseña incorrectos.');
        window.location.href = '../login.php';
    </script>";
    exit();
}
?>

