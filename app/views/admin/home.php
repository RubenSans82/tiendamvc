<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/admin.css">
</head>

<body>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=base_url()?>customer/index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Navbar text with an inline element
                </span>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Panel de Administración</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h3 class="mb-0">Secciones</h3>
                    </div>
                    <div class="card-body bg-secondary">
                        <div class="list-group">
                            <a href="<?= base_url() ?>customer/home" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Clientes
                                <span class="badge bg-primary rounded-pill"><i class="bi bi-people"></i></span>
                            </a>
                            <a href="<?= base_url() ?>provider/home" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Proveedores
                                <span class="badge bg-success rounded-pill"><i class="bi bi-truck"></i></span>
                            </a>
                            <a href="<?= base_url() ?>product/home" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Productos
                                <span class="badge bg-info rounded-pill"><i class="bi bi-box"></i></span>
                            </a>
                            <a href="<?= base_url() ?>category/home" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Categorías
                                <span class="badge bg-warning rounded-pill"><i class="bi bi-tag"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>