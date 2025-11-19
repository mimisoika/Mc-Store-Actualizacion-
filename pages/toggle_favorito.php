<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
if ($producto_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
    exit;
}

if (!isset($_SESSION['favoritos']) || !is_array($_SESSION['favoritos'])) {
    $_SESSION['favoritos'] = [];
}

$index = array_search($producto_id, $_SESSION['favoritos']);
if ($index === false) {
    // agregar
    $_SESSION['favoritos'][] = $producto_id;
    $action = 'added';
} else {
    // quitar
    unset($_SESSION['favoritos'][$index]);
    $_SESSION['favoritos'] = array_values($_SESSION['favoritos']);
    $action = 'removed';
}

echo json_encode(['success' => true, 'action' => $action, 'favoritos' => $_SESSION['favoritos']]);
