<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Providers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <script src="<?= base_url() ?>assets/js/provider.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
</head>

<body>

    <style>
        .dt-container {
            background: #212529;
            color: white;
            padding-top: 5px;
            padding-bottom: 5px;

        }

        div.dt-container .dt-paging .dt-paging-button.disabled {
            background: #212529;
            color: #6c757d !important;
        }

        div.dt-layout-start {
            padding: 0 20px;
        }

        .dt-search {
            padding: 0 20px;
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

    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Proveedores</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>

    <div class="container-fluid">
        <div class="product-container">
            <div class="form-container">
                <h3>Añadir nuevo proveedor</h3>
                <form id="form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Proveedor" required>
                    </div>
                    <div class="mb-3">
                        <label for="web" class="form-label">Web</label>
                        <input type="text" class="form-control" id="web" name="web" placeholder="Sitio web del Proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono del Proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="street" class="form-label">Calle</label>
                        <input type="text" class="form-control" id="street" name="street" placeholder="Calle del Proveedor">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12 mb-3">
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Ciudad">
                        </div>
                        <div class="form-group col-md-6 col-sm-12 mb-3">
                            <label for="postal_code">Código Postal</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Código Postal">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">País</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="País del Proveedor">
                    </div>
                    <button type="submit" class="btn btn-outline-secondary w-100">Guardar</button>
                </form>
                <div id="alertContainer" class="mt-3"></div>
            </div>

            <div class="table-section">
                <div class="table-container ms-auto">
                    <h3>Lista de proveedores</h3>
                    <div id="loadingMessage" class="text-center d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p>Cargando proveedores...</p>
                    </div>
                    <div id="noProvidersMessage" class="alert alert-info text-center d-none">
                        No hay proveedores disponibles.
                    </div>
                    <table id="provider_table" class="table table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col" class="col-8">Nombre</th>
                                <th scope="col" class="col-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="providerList">
                            <?php foreach ($data as $provider) { ?>
                                <tr>
                                    <td><?= $provider->provider_id ?></td>
                                    <td><?= $provider->name ?></td>
                                    <td>
                                        <a href="<?= base_url() ?>provider/show/<?= $provider->provider_id ?>" class="btn btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                        <a href="<?= base_url() ?>provider/edit/<?= $provider->provider_id ?>" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-outline-danger delete-provider" data-id="<?= $provider->provider_id ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteProvider(providerId) {
            if (confirm('Are you sure you want to delete this provider?')) {
                fetch('<?= base_url() ?>provider/delete/' + providerId, {
                        method: 'POST'
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    });
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#provider_table', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json',
                },
                lengthMenu: [10, 25, 50, 100],
                columnDefs: [{
                    targets: [0, 2],
                    searchable: false
                }]
            });
        });
    </script>
</body>

</html>