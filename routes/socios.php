<?php
require_once '../controllers/SociosController.php';

$sociosController = new SociosController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        if (isset($_GET['action']) && $_GET['action'] === 'edit') {
            $sociosController->edit($_GET['id']);
        } elseif (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $sociosController->delete($_GET['id']);
        }
    } else {
        $sociosController->index();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sociosController->create();
}
?>
