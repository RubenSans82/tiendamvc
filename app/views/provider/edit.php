<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <style>
        .card {
            background-color: #212529;
            color: white;
            margin-bottom: 20px;
        }

        .card .text-muted {
            color: #adb5bd !important;
        }

        .form-container2 {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #212529;
            border-radius: 5px;
        }

        .accordion-button:not(.collapsed) {
            background-color: #2c3136;
            color: white;
        }

        .accordion-button {
            background-color: #343a40;
            color: white;
        }

        .accordion-body {
            background-color: #212529;
        }

        /* Fix for labels in accordion */
        .accordion-body label {
            color: white !important;
            display: block;
            margin-bottom: 0.5rem;
        }

        .accordion-item {
            border-color: #495057;
            background-color: #212529;
        }

        /* Feedback styling */
        .invalid-feedback {
            display: none;
            color: #ff6b6b;
            margin-top: 0.25rem;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }

        .is-invalid {
            border-color: #ff6b6b !important;
        }

        /* Success message styling */
        .alert-success {
            background-color: #2b573f;
            color: white;
            border: none;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Editar Proveedor</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>provider/index">Proveedores</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Proveedor</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>
    <div class="container-fluid">
        <div id="successMessages"></div>

        <div class="row">
            <!-- Left column (30%) - Provider info and adding new items -->
            <div class="col-md-4">
                <!-- Provider Info Card -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            Información de <?= $data->name ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Formulario para editar datos básicos del proveedor -->
                        <form method="POST" action="<?= base_url() ?>provider/edit/<?= $data->provider_id ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $data->name ?>">
                            </div>
                            <div class="mb-3">
                                <label for="web" class="form-label">Sitio Web</label>
                                <input type="text" class="form-control" id="web" name="web" value="<?= $data->web ?>">
                            </div>
                            <input type="hidden" name="form_type" value="provider">
                            <button type="submit" class="btn btn-outline-primary w-100">Actualizar Información</button>
                        </form>
                    </div>
                </div>

                <!-- Accordion for adding new items -->
                <div class="accordion" id="addNewItemsAccordion">
                    <!-- Add New Address -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addAddressCollapse" aria-expanded="false" aria-controls="addAddressCollapse">
                                <i class="fas fa-map-marker-alt me-2"></i> Agregar Nueva Dirección
                            </button>
                        </h2>
                        <div id="addAddressCollapse" class="accordion-collapse collapse" data-bs-parent="#addNewItemsAccordion">
                            <div class="accordion-body">
                                <form id="newAddressForm" method="POST" action="<?= base_url() ?>provider/edit/<?= $data->provider_id ?>">
                                    <div class="mb-3">
                                        <label for="new_street" class="form-label">Calle</label>
                                        <input type="text" class="form-control" id="new_street" name="street" required>
                                        <div class="invalid-feedback">Por favor, ingrese una calle válida</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_city" class="form-label">Ciudad</label>
                                        <input type="text" class="form-control" id="new_city" name="city" required>
                                        <div class="invalid-feedback">Por favor, ingrese una ciudad válida</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_zip_code" class="form-label">C.P.</label>
                                        <input type="text" class="form-control" id="new_zip_code" name="zip_code" required>
                                        <div class="invalid-feedback">Por favor, ingrese un código postal válido</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_country" class="form-label">País</label>
                                        <input type="text" class="form-control" id="new_country" name="country" required>
                                        <div class="invalid-feedback">Por favor, ingrese un país válido</div>
                                    </div>
                                    <input type="hidden" name="form_type" value="new_address">
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fas fa-plus-circle me-2"></i> Agregar Dirección
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Phone -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addPhoneCollapse" aria-expanded="false" aria-controls="addPhoneCollapse">
                                <i class="fas fa-phone me-2"></i> Agregar Nuevo Teléfono
                            </button>
                        </h2>
                        <div id="addPhoneCollapse" class="accordion-collapse collapse" data-bs-parent="#addNewItemsAccordion">
                            <div class="accordion-body">
                                <form id="newPhoneForm" method="POST" action="<?= base_url() ?>provider/edit/<?= $data->provider_id ?>">
                                    <div class="mb-3">
                                        <label for="new_phone" class="form-label">Número de Teléfono</label>
                                        <input type="text" class="form-control" id="new_phone" name="new_phone" required>
                                        <div class="invalid-feedback">Por favor, ingrese un número telefónico válido</div>
                                    </div>
                                    <input type="hidden" name="form_type" value="new_phone">
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fas fa-plus-circle me-2"></i> Agregar Teléfono
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column (70%) - Edit existing addresses and phones -->
            <div class="col-md-8">
                <!-- Addresses Card -->
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Direcciones</h5>
                        <span class="badge bg-secondary"><?= count($data->addresses) ?></span>
                    </div>
                    <div class="card-body">
                        <?php if (count($data->addresses) > 0): ?>
                            <?php foreach ($data->addresses as $clave => $address) { ?>
                                <form method="POST" action="<?= base_url() ?>provider/edit/<?= $data->provider_id ?>" class="mb-4">
                                    <h6 class="border-bottom pb-2 mb-3">Dirección #<?= $clave + 1 ?></h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="street" class="form-label">Calle</label>
                                            <input type="text" class="form-control" id="street<?= $address->address_id ?>" name="street" value="<?= $address->street ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">Ciudad</label>
                                            <input type="text" class="form-control" id="city<?= $address->address_id ?>" name="city" value="<?= $address->city ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="zip_code" class="form-label">C.P.</label>
                                            <input type="text" class="form-control" id="zip_code<?= $address->address_id ?>" name="zip_code" value="<?= $address->zip_code ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="country" class="form-label">País</label>
                                            <input type="text" class="form-control" id="country<?= $address->address_id ?>" name="country" value="<?= $address->country ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="address_id" value="<?= $address->address_id ?>">
                                    <input type="hidden" name="form_type" value="address">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-save me-2"></i> Guardar Cambios
                                    </button>
                                </form>
                            <?php } ?>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                Este proveedor no tiene direcciones registradas.
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
                        <?php if (count($data->phones) > 0): ?>
                            <form method="POST" action="<?= base_url() ?>provider/edit/<?= $data->provider_id ?>">
                                <div class="row">
                                    <?php foreach ($data->phones as $clave => $phone) { ?>
                                        <div class="col-md-6 mb-3">
                                            <label for="number<?= $phone->phone_id ?>" class="form-label">Teléfono #<?= $clave + 1 ?></label>
                                            <input type="text" class="form-control" id="number<?= $phone->phone_id ?>"
                                                name="phone[<?= $phone->phone_id ?>]" value="<?= $phone->number ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                                <input type="hidden" name="form_type" value="phone">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-save me-2"></i> Actualizar Teléfonos
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                Este proveedor no tiene teléfonos registrados.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript for form validations and notifications -->
    <script src="<?= base_url() ?>assets/js/provider-edit.js"></script>
</body>

</html>