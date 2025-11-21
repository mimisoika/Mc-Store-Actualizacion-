<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once 'pages/admin/functions/f_configuracion.php';
    $config = obtenerConfiguracion();
    ?>
    <title><?php echo htmlspecialchars($config['nombre_sitio']); ?> | Inicio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <!-- CSS Dinámico -->
    <style>
        <?php echo generarCssDinamico(); ?>
    </style>
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
                            <?php
                            $imagenes = obtenerImagenesCarrusel();
                            foreach ($imagenes as $key => $imagen):
                            ?>
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $key; ?>" 
                                    <?php echo $key === 0 ? 'class="active" aria-current="true"' : ''; ?> 
                                    aria-label="Slide <?php echo $key + 1; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php foreach ($imagenes as $key => $imagen): ?>
                                <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo htmlspecialchars($imagen['imagen_url']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($imagen['titulo']); ?>">
                                    <div class="carousel-caption">
                                        <h1 class="fw-bold"><?php echo htmlspecialchars($imagen['titulo']); ?></h1>
                                        <p><?php echo htmlspecialchars($imagen['descripcion']); ?></p>
                                        <div>
                                            <a href="#productos" class="btn btn-light me-3">Ver Productos</a>
                                            <a href="#contacto" class="btn btn-outline-light">Contáctanos</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: <?php echo htmlspecialchars($config['color_primario']); ?>; color: white;">
                            <i class="fas fa-shipping-fast fs-2"></i>
                        </div>
                        <h4>Envío Gratis</h4>
                        <p class="text-muted">En compras mayores a $500 MXN</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: <?php echo htmlspecialchars($config['color_primario']); ?>; color: white;">
                            <i class="fas fa-undo-alt fs-2"></i>
                        </div>
                        <h4>Devoluciones</h4>
                        <p class="text-muted">30 días para devoluciones</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: <?php echo htmlspecialchars($config['color_primario']); ?>; color: white;">
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
                    <h2 class="display-5 fw-bold mb-4">Acerca de <?php echo htmlspecialchars($config['nombre_sitio']); ?></h2>
                    <p class="lead mb-4"><?php echo nl2br(htmlspecialchars($config['texto_nosotros'])); ?></p>
                    <div class="row text-center">
                        <div class="col-4">
                            <h3 class="display-6 fw-bold" style="color: <?php echo htmlspecialchars($config['color_primario']); ?>;">5000+</h3>
                            <p class="text-muted">Clientes Satisfechos</p>
                        </div>
                        <div class="col-4">
                            <h3 class="display-6 fw-bold" style="color: <?php echo htmlspecialchars($config['color_primario']); ?>;">500+</h3>
                            <p class="text-muted">Productos Disponibles</p>
                        </div>
                        <div class="col-4">
                            <h3 class="display-6 fw-bold" style="color: <?php echo htmlspecialchars($config['color_primario']); ?>;">10+</h3>
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
                        <?php if (!empty($config['direccion'])): ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background-color: <?php echo htmlspecialchars($config['color_primario']); ?>; color: white;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Dirección</h5>
                                    <p class="text-muted mb-0"><?php echo htmlspecialchars($config['direccion']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($config['telefono'])): ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background-color: <?php echo htmlspecialchars($config['color_primario']); ?>; color: white;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Teléfono</h5>
                                    <p class="text-muted mb-0"><?php echo htmlspecialchars($config['telefono']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($config['email'])): ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background-color: <?php echo htmlspecialchars($config['color_primario']); ?>; color: white;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Email</h5>
                                    <p class="text-muted mb-0"><?php echo htmlspecialchars($config['email']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($config['horarios'])): ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background-color: <?php echo htmlspecialchars($config['color_primario']); ?>; color: white;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Horarios</h5>
                                    <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($config['horarios'])); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                </div>
            </div>
        </div>
    </section>

    <?php include 'pages/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="pages/js/index.js"></script>

</body>
</html>