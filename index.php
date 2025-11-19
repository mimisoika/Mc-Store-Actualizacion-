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
    
    <section class="inicio" id="inicio">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-7">
                    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="pages/img/slider/slide1.jpg" class="d-block w-100" alt="Repostería Slide 1">
                    <div class="carousel-caption">
                        <h1 class="display-4 fw-bold mb-4">Tu Tienda de Repostería</h1>
                        <p class="lead mb-4">Herramientas, ingredientes y decoraciones para tus creaciones</p>
                        <div class="mb-4">
                            <a href="#productos" class="btn btn-light btn-lg me-3">Ver Productos</a>
                            <a href="#contacto" class="btn btn-outline-light btn-lg">Contáctanos</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="pages/img/slider/slide2.jpg" class="d-block w-100" alt="Repostería Slide 2">
                    <div class="carousel-caption">
                        <h2 class="display-4 fw-bold mb-4">Calidad Garantizada</h2>
                        <p class="lead mb-4">Los mejores productos para tus creaciones</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="pages/img/slider/slide3.jpg" class="d-block w-100" alt="Repostería Slide 3">
                    <div class="carousel-caption">
                        <h2 class="display-4 fw-bold mb-4">Entrega Rápida</h2>
                        <p class="lead mb-4">Recibe tus productos en tiempo récord</p>
                    </div>
                </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Controles -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselInicio" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselInicio" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    </section>


    <section class="productos-destacados py-5" id="productos">
        <!-- EN ESTA SECCION QUIERO QUE SEA UN CARRUCEL CON LOS PRODUCTOS -->
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

    <!-- Sección de algunos productos -->
    <section class="muestras bg-light py-5 text-center justify-content-center align-items-center" id="muestras">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold">Explora nuestros productos...</h2>
                    <p class="lead text-muted">Un poco de nuestro catalogo</p>
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

    <!-- Sección acerca de  -->
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
    <!-- Contacto -->
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
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
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
            </div>
        </div>
    </section>

    <?php include 'pages/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="pages/js/index.js"></script>

</body>
</html>