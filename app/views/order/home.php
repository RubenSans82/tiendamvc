<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <script src="<?= base_url() ?>assets/js/order.js" defer></script>
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
            <a class="navbar-brand" href="#">Pedidos</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>

    <div class="container-fluid d-flex justify-content-center">
        <div class="order-container" style="width: 60%;">
            <div class="d-flex justify-content-between align-items-center mb-3 bg-dark text-white p-3">
                <h3>Lista de pedidos</h3>
                <a href="<?= base_url() ?>order/create" class="btn btn-outline-primary">Crear Pedido</a>
            </div>

            <!-- Mensaje de carga - inicialmente oculto -->
            <div id="loadingMessage" class="text-center d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p>Cargando pedidos...</p>
            </div>

            <!-- Mensaje cuando no hay pedidos -->
            <div id="noOrdersMessage" class="alert alert-info text-center d-none">
                No hay pedidos disponibles.
            </div>
            <table id="order_table" class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="col-1">Nº Ped.</th>
                        <th scope="col" class="col-4">Cliente</th>
                        <th scope="col" class="col-2">Fecha</th>
                        <th scope="col" class="col-2">Total</th>
                        <th scope="col" class="col-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="orderList">
                    <?php foreach ($data['orders'] as $order): ?>
                        <tr>
                            <td><?= $order->order_id ?></td>
                            <td><?= $order->customer->name ?></td>
                            <td><?= $order->date ?></td>
                            <td><?= $order->total ?>€</td>
                            <td>
                                <a href="<?= base_url() ?>order/show/<?= $order->order_id ?>" class="btn btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                <a href="<?= base_url() ?>order/edit/<?= $order->order_id ?>" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-outline-danger delete-order" data-id="<?= $order->order_id ?>"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Verifica si hay algún error en la carga de pedidos
        window.addEventListener('error', function(e) {
            if (e.target && e.target.tagName && e.target.tagName.toLowerCase() === 'script') {
                console.error('Error loading script:', e);
                const loadingMessage = document.getElementById('loadingMessage');
                if (loadingMessage) {
                    loadingMessage.innerHTML =
                        '<div class="alert alert-danger">Error cargando los pedidos. Por favor, recarga la página.</div>';
                }
            }
        }, true);
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#order_table', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json',
                },
                lengthMenu: [10, 25, 50, 100],
                columnDefs: [{
                    targets: [0, 2, 3, 4],
                    searchable: false
                }]
            });
        });
    </script>
</body>

</html>