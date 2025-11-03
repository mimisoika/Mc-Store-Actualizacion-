<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MC Store | Inicio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <?php include 'pages/header.php'; ?>
    
    <?php
    require_once 'pages/functions/f_index.php';
    ?>
    
    <section class="inicio bg-primary text-white py-5" id="inicio">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Tu Tienda de Repostería</h1>
                    <p class="lead mb-4">Herramientas, ingredientes y decoraciones para tus creaciones</p>
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-check-circle me-2 fs-4"></i>
                                <span class="fw-semibold">Calidad Garantizada</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-clock me-2 fs-4"></i>
                                <span class="fw-semibold">Entrega Rápida</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#productos" class="btn btn-light btn-lg me-3">Ver Productos</a>
                        <a href="#contacto" class="btn btn-outline-light btn-lg">Contáctanos</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="productos-destacados py-5" id="productos">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold">Productos Destacados</h2>
                    <p class="lead text-muted">Los mejores productos para tus creaciones</p>
                </div>
            </div>
            <div class="row g-4">
                <?php mostrarProductosDestacados(); ?>
            </div>
        </div>
    </section>

    <!-- Sección de Servicios -->
    <section class="servicios bg-light py-5 text-center justify-content-center align-items-center" id="servicios">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold">Nuestros Servicios</h2>
                    <p class="lead text-muted">Beneficios que ofrecemos a nuestros clientes</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-shipping-fast fs-2"></i>
                        </div>
                        <h4>Envío Gratis</h4>
                        <p class="text-muted">En compras mayores a $500 MXN</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-undo-alt fs-2"></i>
                        </div>
                        <h4>Devoluciones</h4>
                        <p class="text-muted">30 días para devoluciones</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt fs-2"></i>
                        </div>
                        <h4>Compra Segura</h4>
                        <p class="text-muted">Pagos protegidos y seguros</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Acerca de -->
    <section class="acerca-de py-5" id="acerca">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4">Acerca de MC Store</h2>
                    <p class="lead mb-4">Somos una tienda especializada en repostería con más de 10 años de experiencia. Nos dedicamos a proporcionar las mejores herramientas, ingredientes y decoraciones para que puedas crear obras maestras culinarias.</p>
                    <p class="mb-4">Nuestra misión es hacer que la repostería sea accesible para todos, desde principiantes hasta profesionales, ofreciendo productos de alta calidad a precios competitivos.</p>
                    <div class="row text-center">
                        <div class="col-4">
                            <h3 class="display-6 fw-bold text-primary">5000+</h3>
                            <p class="text-muted">Clientes Satisfechos</p>
                        </div>
                        <div class="col-4">
                            <h3 class="display-6 fw-bold text-primary">500+</h3>
                            <p class="text-muted">Productos Disponibles</p>
                        </div>
                        <div class="col-4">
                            <h3 class="display-6 fw-bold text-primary">10+</h3>
                            <p class="text-muted">Años de Experiencia</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="pages/img/tienda-mc.jpg" class="img-fluid rounded shadow" alt="Nuestra Tienda">
                </div>
            </div>
        </div>
    </section>

    <section class="contacto py-5" id="contacto">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold">Contáctanos</h2>
                    <p class="lead text-muted">Estamos aquí para ayudarte</p>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Dirección</h5>
                                    <p class="text-muted mb-0">Av. Principal 123, Ciudad, País</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Teléfono</h5>
                                    <p class="text-muted mb-0">+1 (555) 123-4567</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Email</h5>
                                    <p class="text-muted mb-0">info@mcstore.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Horarios</h5>
                                    <p class="text-muted mb-0">Lun - Vie: 9:00 AM - 6:00 PM<br>Sáb: 9:00 AM - 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="bg-light p-4 rounded">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="asunto" class="form-label">Asunto</label>
                            <input type="text" class="form-control" id="asunto" required>
                        </div>
                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="mensaje" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Enviar Mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'pages/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="pages/js/index.js"></script>

</body>
</html>