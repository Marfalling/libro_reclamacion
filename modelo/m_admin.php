<?php
function VerificarAdmin($user_admin, $pass) {
    require("conexion.php");

    // Consulta preparada para evitar inyecciones SQL
    $sql = "SELECT id_admin, pass FROM admin WHERE user_admin = ?";
    $stmt = $con->prepare($sql); // Preparar consulta
    $stmt->bind_param("s", $user_admin); // Pasar parámetros de manera segura
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el usuario
    if ($result && $row = $result->fetch_assoc()) {
        // Comparar contraseña en texto plano
        if ($pass === $row['pass']) {
            $stmt->close();
            $con->close();
            return $row['id_admin']; // Retorna el ID del administrador
        }
    }

    // Si no se encuentra el usuario o la contraseña es incorrecta
    $stmt->close();
    $con->close();
    return false;
}
?>
