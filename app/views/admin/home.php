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
    <style>
        .admin-card {
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-align: center;
            height: 100%;
            background-color: #2c3034;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        }
        
        .admin-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        
        .admin-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .admin-card .card-title {
            font-size: 1.5rem;
            font-weight: 500;
            color: #e9ecef;
        }
        
        .logout-link {
            color: #ff6b6b;
        }
        
        .logout-link:hover {
            color: #fa5252;
        }
        
        .card {
            background-color: #343a40;
            color: #e9ecef;
        }
        
        .card-header {
            border-bottom: 1px solid #495057;
        }
        
        h1, h3 {
            color: #e9ecef;
        }

        .border-primary {
            background-color: #3a3f44;
        }

        .border-danger {
            background-color: #3f3a3a;
        }

        .border-success {
            background-color: #3a3f3a;
        }

        .border-warning {
            background-color: #3f3f3a;
        }

        .count-badge {
            background-color: rgba(255,255,255,0.15);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
            border: 2px solid;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row">
                <li class="nav-item ms-3">
                    <a class="nav-link logout-link" href="<?= base_url()?>login/logout" title="Cerrar Sesión">
                        <i class="bi bi-box-arrow-right"></i> Salir
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h1 class="text-center mb-4">Panel de Administración</h1>

        <div class="row justify-content-center">
            <div class="col-11 col-md-10">
                <div class="card shadow mb-4">
                    <div class="card-header bg-dark text-white">
                        <h3 class="mb-0">Secciones</h3>
                    </div>
                    <div class="card-body bg-dark p-4">
                        <div class="row g-4">
                            <!-- Clientes -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <a href="<?= base_url() ?>customer/home" class="text-decoration-none">
                                    <div class="card admin-card border-primary h-100">
                                        <div class="card-body">
                                            <div class="icon text-primary">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="count-badge text-primary" style="border-color: var(--bs-primary);"><?= $data['customerCount'] ?></div>
                                            <h5 class="card-title">Clientes</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Proveedores -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <a href="<?= base_url() ?>provider/home" class="text-decoration-none">
                                    <div class="card admin-card border-danger h-100">
                                        <div class="card-body">
                                            <div class="icon text-danger">
                                                <i class="bi bi-truck"></i>
                                            </div>
                                            <div class="count-badge text-danger" style="border-color: var(--bs-danger);"><?= $data['providerCount'] ?></div>
                                            <h5 class="card-title">Proveedores</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Productos -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <a href="<?= base_url() ?>product/home" class="text-decoration-none">
                                    <div class="card admin-card border-success h-100">
                                        <div class="card-body">
                                            <div class="icon text-success">
                                                <i class="bi bi-box"></i>
                                            </div>
                                            <div class="count-badge text-success" style="border-color: var(--bs-success);"><?= $data['productCount'] ?></div>
                                            <h5 class="card-title">Productos</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Pedidos -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <a href="<?= base_url() ?>order/home" class="text-decoration-none">
                                    <div class="card admin-card border-warning h-100">
                                        <div class="card-body">
                                            <div class="icon text-warning">
                                                <i class="bi bi-receipt"></i>
                                            </div>
                                            <div class="count-badge text-warning" style="border-color: var(--bs-warning);"><?= $data['orderCount'] ?></div>
                                            <h5 class="card-title">Pedidos</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>