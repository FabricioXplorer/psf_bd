<?php
// Conexión a la base de datos
$host = 'localhost';
$port = '5432';
$dbname = 'club_naut';
$user = 'postgres';
$password = 'fabricio';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_socio = $_POST['id_socio'];
    $id_amarre = $_POST['id_amarre'];
    $fecha_compra = $_POST['fecha_compra'];

    // Insertar los datos en la tabla propiedad_amarres
    $query_insert = "INSERT INTO propiedad_amarres (id_socio, id_amarre, fecha_compra) 
                     VALUES ($id_socio, $id_amarre, '$fecha_compra')";

    $result_insert = pg_query($conn, $query_insert);

    if ($result_insert) {
        echo "Registro agregado exitosamente.";
    } else {
        echo "Error al agregar el registro: " . pg_last_error($conn);
    }
}

// Consultar los socios
$query_socios = "SELECT id_socio, nombre FROM socios";
$result_socios = pg_query($conn, $query_socios);

// Consultar los amarres
$query_amarres = "SELECT id_amarre, numero FROM amarres";
$result_amarres = pg_query($conn, $query_amarres);

// Consultar los registros de propiedad_amarres desde la vista propiedad_amarre_socio
$query_registros = "SELECT id_socio, nombre_socio, id_amarre, numero, zona, fecha_asignacion, fecha_compra 
                    FROM propiedad_amarre_socio";
$result_registros = pg_query($conn, $query_registros);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Propiedad de Amarre</title>
    <link rel="stylesheet" href="styleempzo.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Propiedad de Amarre</h1>

        <!-- Formulario para insertar datos -->
        <form action="" method="POST">
            <label for="id_socio">Seleccionar Socio:</label>
            <select name="id_socio" id="id_socio" required>
                <option value="">Seleccione un socio</option>
                <?php while ($row_socio = pg_fetch_assoc($result_socios)): ?>
                    <option value="<?php echo $row_socio['id_socio']; ?>">
                        <?php echo $row_socio['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="id_amarre">Seleccionar Amarre:</label>
            <select name="id_amarre" id="id_amarre" required>
                <option value="">Seleccione un amarre</option>
                <?php while ($row_amarre = pg_fetch_assoc($result_amarres)): ?>
                    <option value="<?php echo $row_amarre['id_amarre']; ?>">
                        <?php echo $row_amarre['numero']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="fecha_compra">Fecha de Compra:</label>
            <input type="date" id="fecha_compra" name="fecha_compra" required><br><br>

            <button type="submit">Agregar</button>
        </form>

        <h2>Registros de Propiedad de Amarre</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Socio</th>
                    <th>Amarre</th>
                    <th>Zona</th>
                    <th>Fecha de Asignación</th>
                    <th>Fecha de Compra</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_registro = pg_fetch_assoc($result_registros)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row_registro['nombre_socio']); ?></td>
                        <td><?php echo htmlspecialchars($row_registro['numero']); ?></td>
                        <td><?php echo htmlspecialchars($row_registro['zona']); ?></td>
                        <td><?php echo htmlspecialchars($row_registro['fecha_asignacion']); ?></td>
                        <td><?php echo htmlspecialchars($row_registro['fecha_compra']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
pg_close($conn);
?>
