<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <style>
        /* Style to ensure cards have dark theme */
        .card {
            background-color: #212529;
            color: white;
        }
        
        .card .text-muted {
            color: #adb5bd !important;
        }
        
        /* Order info list styling */
        .order-info-list {
            list-style: none;
            padding-left: 0;
        }
        
        .order-info-list li {
            padding: 8px 0;
            border-bottom: 1px solid #495057;
        }
        
        .order-info-list li:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Detalles del Pedido</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>order/index">Pedidos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalles del Pedido</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>

    <div class="container-fluid">
        <div class="row">
            <!-- Order Details Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            Detalles del Pedido #<?= $data['order']->order_id ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="order-info-list">
                            <li>
                                <i class="fas fa-user me-2"></i>
                                <strong>Cliente:</strong> 
                                <span class="float-end"><?= $data['order']->customer->name ?></span>
                            </li>
                            <li>
                                <i class="fas fa-calendar-alt me-2"></i>
                                <strong>Fecha:</strong> 
                                <span class="float-end"><?= date('d/m/Y H:i', strtotime($data['order']->date)) ?></span>
                            </li>
                            <?php if(isset($data['order']->discount) && $data['order']->discount > 0): ?>
                            <li>
                                <i class="fas fa-percent me-2"></i>
                                <strong>Descuento:</strong> 
                                <span class="float-end"><?= $data['order']->discount ?>%</span>
                            </li>
                            <?php endif; ?>
                            <li>
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <strong>Total:</strong> 
                                <span class="float-end fw-bold"><?= $data['order']->total ?>€</span>
                            </li>
                            <?php if(isset($data['order']->status)): ?>
                            <li>
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Estado:</strong> 
                                <span class="float-end"><?= $data['order']->status ?></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?= base_url() ?>order/index" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-info dropdown-toggle" type="button" id="invoiceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-invoice"></i> Factura
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="invoiceDropdown">
                                <li><a class="dropdown-item" href="<?= base_url() ?>order/invoice/<?= $data['order']->order_id ?>/pdf" target="_blank"><i class="fas fa-file-pdf me-2"></i>Descargar PDF</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>order/invoice/<?= $data['order']->order_id ?>/xml" download><i class="fas fa-file-code me-2"></i>Descargar XML</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#emailInvoiceModal"><i class="fas fa-envelope me-2"></i>Enviar por email</a></li>
                            </ul>
                        </div>
                        <a href="<?= base_url() ?>order/edit/<?= $data['order']->order_id ?>" class="btn btn-outline-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products Table Card -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Desglose del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-dark table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-1">ID</th>
                                    <th scope="col" class="col-6">Producto</th>
                                    <th scope="col" class="col-2">Precio/ud</th>
                                    <th scope="col" class="col-2">Cantidad</th>
                                    <th scope="col" class="col-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal = 0;
                                foreach ($data['order']->products as $product): 
                                    $quantity = $product->pivot->quantity ?? 1;
                                    $price = $product->pivot->price ?? $product->price;
                                    $productSubtotal = $quantity * $price;
                                    $subtotal += $productSubtotal;
                                ?>
                                <tr>
                                    <td><?= $product->product_id ?></td>
                                    <td><?= $product->name ?></td>
                                    <td><?= number_format($price, 2) ?>€</td>
                                    <td><?= $quantity ?></td>
                                    <td><?= number_format($productSubtotal, 2) ?>€</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                    <td><?= number_format($subtotal, 2) ?>€</td>
                                </tr>
                                <?php if(isset($data['order']->discount) && $data['order']->discount > 0): 
                                    $discountAmount = $subtotal * ($data['order']->discount / 100);
                                ?>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Descuento (<?= $data['order']->discount ?>%):</strong></td>
                                    <td><?= number_format($discountAmount, 2) ?>€</td>
                                </tr>
                                <?php endif; ?>
                                <tr class="table-active">
                                    <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                    <td><strong><?= $data['order']->total ?>€</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Invoice Modal -->
    <div class="modal fade" id="emailInvoiceModal" tabindex="-1" aria-labelledby="emailInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailInvoiceModalLabel">Enviar Factura por Email</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="emailInvoiceForm" action="<?= base_url() ?>order/sendInvoice/<?= $data['order']->order_id ?>" method="post">
                        <div class="mb-3">
                            <label for="emailTo" class="form-label">Email de destino</label>
                            <input type="email" class="form-control bg-dark text-light" id="emailTo" name="emailTo" required>
                        </div>
                        <div class="mb-3">
                            <label for="format" class="form-label">Formato</label>
                            <select class="form-select bg-dark text-light" id="format" name="format">
                                <option value="pdf">PDF</option>
                                <option value="xml">XML</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="emailInvoiceForm" class="btn btn-outline-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
