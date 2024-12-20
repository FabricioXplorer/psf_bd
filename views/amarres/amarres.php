<!-- views/amarres/amarres.php -->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/psf_bd/config/db.php');

// Consultar todos los amarres
$query = "SELECT id, nombre, ubicacion, zona, fecha_asignacion, fecha_compra FROM amarres";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Amarres</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
     <!-- Navbar fijo -->
     <div class="navbar">
        <a href="home.php">Regresar a Home</a>
    </div>
    <div class="container">
        <h1>Lista de Amarres</h1>
        <p><a href="../home.php">Volver al inicio</a></p>
        <p><a href="insertar.php">Agregar Amarre</a></p>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Zona</th>
                    <th>Fecha de Asignación</th>
                    <th>Fecha de Compra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = pg_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['ubicacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['zona']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_asignacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_compra']); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a> |
                            <a href="eliminar.php?id=<?php echo $row['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Liberar resultados y cerrar la conexión
pg_free_result($result);
pg_close($conn);
?>
