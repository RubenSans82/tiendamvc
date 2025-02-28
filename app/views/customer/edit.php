<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Editar Cliente</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>customer/index">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Cliente</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>
    <div class="container2">

        <div class="formEdit">
            <!-- Formulario para editar el nombre del cliente -->
            <form method="POST" action="<?= base_url() ?>customer/edit/<?= $data->customer_id ?>">
                <div class="form-container2">
                    <h5 class="card-title">Datos del Cliente</h5>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $data->name ?>">
                    </div>
                    <input type="hidden" name="form_type" value="customer">
                    <button type="submit" class="btn btn-primary">Actualizar Nombre</button>
                </div>
            </form>

            <?php foreach ($data->addresses as $clave => $address) { ?>
                <form method="POST" action="<?= base_url() ?>customer/edit/<?= $data->customer_id ?>">
                    <div class="form-container2">
                        <h5 class="card-title">Dirección <?= $clave + 1 ?></h5>
                        <div class="mb-3">
                            <label for="street" class="form-label">Calle</label>
                            <input type="text" class="form-control" id="street<?= $address->address_id ?>" name="street" value="<?= $address->street ?>">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="city<?= $address->address_id ?>" name="city" value="<?= $address->city ?>">
                        </div>
                        <div class="mb-3">
                            <label for="zip_code" class="form-label">C.P.</label>
                            <input type="text" class="form-control" id="zip_code<?= $address->address_id ?>" name="zip_code" value="<?= $address->zip_code ?>">
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">País</label>
                            <input type="text" class="form-control" id="country<?= $address->address_id ?>" name="country" value="<?= $address->country ?>">
                        </div>
                        <input type="hidden" name="address_id" value="<?= $address->address_id ?>">
                        <input type="hidden" name="form_type" value="address">
                        <button type="submit" class="btn btn-primary">Editar Direccion</button>
                    </div>
                </form>
            <?php } ?>
            <form method="POST" action="<?= base_url() ?>customer/edit/<?= $data->customer_id ?>">
                <div class="form-container2">
                    <h5 class="card-title">Teléfonos</h5>

                    <?php foreach ($data->phones as $clave => $phone) { ?>
                        <div class="mb-3">
                            <label for="number<?= $phone->phone_id ?>" class="form-label">Teléfono <?= $clave + 1 ?></label>
                            <input type="text" class="form-control" id="number<?= $phone->phone_id ?>"
                                name="phone[<?= $phone->phone_id ?>]" value="<?= $phone->number ?>">
                        </div>
                    <?php } ?>

                    <input type="hidden" name="form_type" value="phone">
                    <button type="submit" class="btn btn-primary">Actualizar Teléfonos</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>