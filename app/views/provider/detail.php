<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <style>
        .card {
            background-color: #212529;
            color: white;
            margin-bottom: 20px;
        }

        .card .text-muted {
            color: #adb5bd !important;
        }

        #dt-length-0 {
            background-color: #212529;
        }

        .table-responsive {
            color: white !important;
        }
    </style>
    <style>
        .dt-container {
            background: #212529;
            color: white;

        }

        div.dt-container .dt-paging .dt-paging-button.disabled {
            background: #212529;
            color: #6c757d !important;
        }



        .dt-paging-button {
            background: #212529;
            color: white !important;
        }

        select.dt-input option {
            background: #212529;
            color: white !important;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Detalle del Proveedor</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>provider/index">Proveedores</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle del Proveedor</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>
    <div class="container-fluid">
        <div class="row">
            <!-- Provider Info Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Información de <?= $data->name ?></h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nombre:</strong> <?= $data->name ?></p>
                        <p><strong>Sitio Web:</strong> <?= $data->web ?: 'No disponible' ?></p>
                        <p><strong>Fecha de Registro:</strong> <?= $data->created_at ?></p>
                        <p><strong>Última Actualización:</strong> <?= $data->updated_at ?></p>

                        <a href="<?= base_url() ?>provider/edit/<?= $data->provider_id ?>" class="btn btn-outline-warning w-100">
                            <i class="fas fa-edit me-2"></i> Editar Proveedor
                        </a>
                    </div>
                </div>
            </div>

            <!-- Addresses Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Direcciones</h5>
                        <span class="badge bg-secondary"><?= count($data->addresses) ?></span>
                    </div>
                    <div class="card-body">
                        <?php if (count($data->addresses) > 0): ?>
                            <?php foreach ($data->addresses as $clave => $address) { ?>
                                <div class="mb-4 pb-3 border-bottom">
                                    <h6>Dirección #<?= $clave + 1 ?></h6>
                                    <p class="mb-1"><strong>Calle:</strong> <?= $address->street ?></p>
                                    <p class="mb-1"><strong>Ciudad:</strong> <?= $address->city ?></p>
                                    <p class="mb-1"><strong>C.P.:</strong> <?= $address->zip_code ?></p>
                                    <p class="mb-1"><strong>País:</strong> <?= $address->country ?></p>
                                </div>
                            <?php } ?>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                Este proveedor no tiene direcciones registradas.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Phones Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Teléfonos</h5>
                        <span class="badge bg-secondary"><?= count($data->phones) ?></span>
                    </div>
                    <div class="card-body">
                        <?php if (count($data->phones) > 0): ?>
                            <?php foreach ($data->phones as $clave => $phone) { ?>
                                <div class="mb-2">
                                    <strong>Teléfono #<?= $clave + 1 ?>:</strong> <?= $phone->number ?>
                                </div>
                            <?php } ?>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                Este proveedor no tiene teléfonos registrados.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Productos Suministrados</h5>
                        <span class="badge bg-secondary"><?= count($data->products) ?></span>
                    </div>
                    <div class="card-body">
                        <?php if (count($data->products) > 0): ?>
                            <div class="table-responsive">
                                <table id="products_provider" class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Categoría</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data->products as $clave => $product) { ?>
                                            <tr>
                                                <td><?= $product->product_id ?></td>
                                                <td><?= $product->name ?></td>
                                                <td><?= $product->description ?></td>
                                                <td>$<?= number_format($product->price, 2) ?></td>
                                                <td><?= $product->stock ?></td>
                                                <td><?= $product->category_name ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                Este proveedor no tiene productos registrados.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#products_provider', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json',
                },
                lengthMenu: [10, 25, 50, 100],
                columnDefs: [{
                    targets: [0, 3, 4, 5],
                    searchable: false
                }]
            });
        });
    </script>

</body>

</html>