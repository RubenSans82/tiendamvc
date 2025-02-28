<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <script src="<?= base_url() ?>assets/js/customer.js" defer></script>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Clientes</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>

    <div class="container-fluid">
        <div class="product-container">
            <!-- Columna izquierda - Formulario (30%) -->
            <div class="form-container">
                <h3>Añadir nuevo cliente</h3>
                <form id="form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Cliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono del Cliente">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Calle, Número">
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
                        <label for="pais" class="form-label">País</label>
                        <input type="text" class="form-control" id="pais" name="pais" placeholder="País">
                    </div>
                    <button type="submit" class="btn btn-secondary w-100">Guardar</button>
                </form>

                <!-- Contenedor para mensajes de alerta -->
                <div id="alertContainer" class="mt-3"></div>
            </div>

            <!-- Columna derecha - Tabla (70%) -->
            <div class="table-section">
                <div class="table-container ms-auto">
                    <h3>Lista de clientes</h3>

                    <!-- Mensaje de carga - inicialmente oculto -->
                    <div id="loadingMessage" class="text-center d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p>Cargando clientes...</p>
                    </div>

                    <!-- Mensaje cuando no hay clientes -->
                    <div id="noCustomersMessage" class="alert alert-info text-center d-none">
                        No hay clientes disponibles.
                    </div>

                    <table class="table table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col" class="col-8">Nombre</th>
                                <th scope="col" class="col-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="customerList">
                            <?php foreach ($data as $customer) { ?>
                                <tr>
                                    <td><?= $customer->customer_id ?></td>
                                    <td><?= $customer->name ?></td>

                                    <td>
                                        <a href="<?= base_url() ?>customer/show/<?= $customer->customer_id ?>" class="btn btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                        <a href="<?= base_url() ?>customer/edit/<?= $customer->customer_id ?>" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-outline-danger delete-customer" data-id="<?= $customer->customer_id ?>"><i class="fas fa-trash"></i></a>
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
        // Verifica si hay algún error en la carga de clientes
        window.addEventListener('error', function(e) {
            if (e.target.tagName.toLowerCase() === 'script') {
                console.error('Error loading script:', e);
                document.getElementById('loadingMessage').innerHTML =
                    '<div class="alert alert-danger">Error cargando los clientes. Por favor, recarga la página.</div>';
            }
        }, true);
    </script>
</body>

</html>