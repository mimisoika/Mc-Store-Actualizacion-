<?php 
include '../php/database.php';
include 'functions/f_carrito.php';

session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al login si no está autenticado
    header('Location: login.php');
    exit;
}

// Usar el ID del usuario logueado
$usuario_id = $_SESSION['usuario_id'];

manejarAccionesCarrito();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carrito de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-4">CARRITO DE COMPRAS</h2>
                
                <?php
                if (!verificarSesionUsuario()) {
                    echo '<p class="alert alert-warning">Debes iniciar sesión para ver tu carrito.</p>';
                } else {
                    $usuario_id = $_SESSION['usuario_id'];
                    $productos = obtenerProductosCarrito($conexion, $usuario_id);
                    echo generarHTMLProductosCarrito($productos);
                }
                ?>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">RESUMEN DEL PEDIDO</h6>
                    </div>
                    <div class="card-body" id="resumen-pedido">
                        <?php
                        if (verificarSesionUsuario()) {
                            $totales = calcularTotales($conexion, $_SESSION['usuario_id']);
                            echo generarHTMLResumenPedido($totales);
                        } else {
                            echo '<p class="text-muted">Inicia sesión para ver el resumen</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/carrito.js"></script>
</body>
</html>