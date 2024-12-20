<?php
include($_SERVER['DOCUMENT_ROOT'] . '/psf_bd/config/db.php');

// Comprobar si se ha enviado un parámetro de búsqueda
if (isset($_GET['ci']) && !empty($_GET['ci'])) {
    // Escapar el valor del CI para evitar inyecciones SQL
    $ci = pg_escape_string($conn, $_GET['ci']);
    // Consulta para buscar por CI
    $query = "SELECT * FROM socios WHERE ci = '$ci'";
} else {
    // Consulta para mostrar todos los socios
    $query = "SELECT * FROM socios";
}

$result = pg_query($conn, $query);
?>

<head>
    <!-- Enlace al archivo CSS externo -->
    <link rel="stylesheet" href="styleso.css">
</head>

<body>

<div class='container'>
    <h1>Lista de Socios</h1>

    <!-- Formulario de Búsqueda -->
    <form action="socios.php" method="get">
        <label for="ci">Buscar por Cédula de Identidad (CI):</label>
        <input type="text" id="ci" name="ci" placeholder="Ingrese el CI" value="<?php echo isset($_GET['ci']) ? htmlspecialchars($_GET['ci']) : ''; ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php
    // Mostrar los resultados en una tabla
    echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>CI</th>
                    <th>Teléfono</th>
                    <th>Fecha Ingreso</th>
                    <th>Acciones</th>
                </tr>";

    if (pg_num_rows($result) > 0) {
        while ($row = pg_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id_socio']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['direccion']}</td>
                    <td>{$row['ci']}</td>
                    <td>{$row['telefono']}</td>
                    <td>{$row['fecha_ingreso']}</td>
                    <td>
                        <a href='editar.php?id={$row['id_socio']}'>Editar</a> | 
                        <a href='eliminar.php?id={$row['id_socio']}'>Eliminar</a>
                    </td>
                </tr>";
        } 
    } else {
        echo "<tr><td colspan='7'>No se encontraron socios.</td></tr>";
    }

    echo "</table>";
    ?>

</div>

</body>

<?php
pg_close($conn);
?>

