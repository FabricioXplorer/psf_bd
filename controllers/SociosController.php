<?php
require_once '../models/Socio.php';

class SociosController {
    public function index() {
        $socios = Socio::getAll();
        include '../views/socios/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $socio = new Socio(null, $_POST['nombre'], $_POST['direccion'], $_POST['ci'], $_POST['telefono'], $_POST['fecha_ingreso']);
            $socio->create();
            header('Location: /socios');
        } else {
            include '../views/socios/create.php';
        }
    }

    public function edit($id) {
        $socio = Socio::getById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $socio->nombre = $_POST['nombre'];
            $socio->direccion = $_POST['direccion'];
            $socio->telefono = $_POST['telefono'];
            $socio->update();
            header('Location: /socios');
        } else {
            include '../views/socios/edit.php';
        }
    }

    public function delete($id) {
        $socio = Socio::getById($id);
        $socio->delete();
        header('Location: /socios');
    }
}
?>
