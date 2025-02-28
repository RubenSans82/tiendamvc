<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Detalle del Proveedor</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>provider/home">Proveedores</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle del Proveedor</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>
    <div class="container">
        <h1 class="mt-5"><?= $data->name ?></h1>
        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong>Nombre:</strong> <?= $data->name ?></p>
                <p><strong>Web:</strong> <?= $data->web ?></p>
                <p><strong>Teléfono:</strong> <?= $data->phone ?></p>
                <p><strong>Calle:</strong> <?= $data->street ?></p>
                <p><strong>Ciudad:</strong> <?= $data->city ?></p>
                <p><strong>Código Postal:</strong> <?= $data->zip_code ?></p>
                <p><strong>País:</strong> <?= $data->country ?></p>
            </div>
        </div>
        <a href="<?= base_url() . 'provider/edit/' . $data->provider_id ?>" class="btn btn-primary mt-3">Editar</a>
        <a href="<?= base_url() . 'provider' ?>" class="btn btn-secondary mt-3">Volver a la Lista</a>
    </div>
</body>

</html>