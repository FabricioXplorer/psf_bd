<!-- views/socios/eliminar.php -->
<?php
include('../config/db.php');  // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el socio
    $query = "DELETE FROM socios WHERE id_socio = '$id'";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "<p>Socio eliminado con éxito.</p>";
    } else {
        echo "<p>Error al eliminar socio: " . pg_last_error($conn) . "</p>";
    }
}

header("Location: socios.php");  // Redirigir a la lista de socios
exit();
?>
