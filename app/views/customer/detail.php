<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <style>
        /* Styles to ensure cards have dark theme */
        .card {
            background-color: #212529;
            color: white;
            margin-bottom: 20px;
        }
        
        .card .text-muted {
            color: #adb5bd !important;
        }
        
        /* Customer info styling */
        .customer-info-list {
            list-style: none;
            padding-left: 0;
        }
        
        .customer-info-list li {
            padding: 8px 0;
            border-bottom: 1px solid #495057;
        }
        
        .customer-info-list li:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Detalle de Cliente</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>customer/index">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle de Cliente</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>

    <div class="container-fluid">
        <div class="row">
            <!-- Customer Info Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            Información del Cliente 
                            <span class="badge bg-success">#<?= $data->customer_id ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="customer-info-list">
                            <li>
                                <i class="fas fa-user me-2"></i>
                                <strong>Nombre:</strong> 
                                <span class="float-end"><?= $data->name ?></span>
                            </li>
                            <?php if(isset($data->email)): ?>
                            <li>
                                <i class="fas fa-envelope me-2"></i>
                                <strong>Email:</strong> 
                                <span class="float-end"><?= $data->email ?></span>
                            </li>
                            <?php endif; ?>
                            <?php if(isset($data->created_at)): ?>
                            <li>
                                <i class="fas fa-calendar-alt me-2"></i>
                                <strong>Fecha de registro:</strong> 
                                <span class="float-end"><?= date('d/m/Y', strtotime($data->created_at)) ?></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?= base_url() ?>customer/index" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <a href="<?= base_url() ?>customer/edit/<?= $data->customer_id ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Customer Details Column -->
            <div class="col-md-8">
                <!-- Addresses Card -->
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Direcciones</h5>
                        <span class="badge bg-secondary"><?= count($data->addresses) ?></span>
                    </div>
                    <div class="card-body">
                        <?php if(count($data->addresses) > 0): ?>
                            <table class="table table-striped table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Calle</th>
                                        <th scope="col">Ciudad</th>
                                        <th scope="col">C.P.</th>
                                        <th scope="col">País</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data->addresses as $address): ?>
                                        <tr>
                                            <th scope="row"><?= $address->address_id ?></th>
                                            <td><?= $address->street ?></td>
                                            <td><?= $address->city ?></td>
                                            <td><?= $address->zip_code ?></td>
                                            <td><?= $address->country ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                Este cliente no tiene direcciones registradas.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Phones Card -->
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Teléfonos</h5>
                        <span class="badge bg-secondary"><?= count($data->phones) ?></span>
                    </div>
                    <div class="card-body">
                        <?php if(count($data->phones) > 0): ?>
                            <table class="table table-striped table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-2">#</th>
                                        <th scope="col" class="col-10">Número</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data->phones as $phone): ?>
                                        <tr>
                                            <th scope="row"><?= $phone->phone_id ?></th>
                                            <td><?= $phone->number ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                Este cliente no tiene teléfonos registrados.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>