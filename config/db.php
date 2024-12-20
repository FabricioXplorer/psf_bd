<!-- <?php
$host = 'localhost';
$port = '5432';
$dbname = 'club_naut';
$user = 'postgres';
$password = 'fabricio';


$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión a la base de datos: " . pg_last_error());
} else {
    echo "Conexión exitosa a la base de datos PostgreSQL.";
}
?> -->
<?php
$host = 'localhost';
$port = '5432';
$dbname = 'club_naut';
$user = 'postgres';
$password = 'fabricio';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión a la base de datos: " . pg_last_error());
}
?>
