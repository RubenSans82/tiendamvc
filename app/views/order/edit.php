<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/order.css">
    <script src="<?= base_url() ?>assets/js/order-edit.js" defer></script>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Editar Pedido #<?= $data['order']->order_id ?>
                <span id="orderIdBadge" class="badge bg-secondary">ID: <?= $data['order']->order_id ?></span>
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>order/index">Pedidos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Pedido</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>

    <div class="container-fluid">
        <div class="row">
            <!-- Columna izquierda - Formularios (30%) -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            Datos del Pedido 
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="orderMainForm">
                            <input type="hidden" id="order_id" name="order_id" value="<?= $data['order']->order_id ?>">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12 mb-3">
                                    <label for="customer_id" class="form-label">Cliente</label>
                                    <select class="form-select" name="customer_id" id="customer_id" required>
                                        <option value="" disabled>Selecciona un cliente...</option>
                                        <?php
                                        $sortedCustomers = $data['customers']->sortBy('name');
                                        foreach ($sortedCustomers as $customer): ?>
                                            <option value="<?= $customer->customer_id ?>" <?= $customer->customer_id == $data['order']->customer_id ? 'selected' : '' ?>><?= $customer->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-sm-12 mb-3">
                                    <label for="discount" class="form-label">Descuento (%)</label>
                                    <input type="number" class="form-control" id="discount" name="discount" min="0" max="100" value="<?= $data['order']->discount ?? 0 ?>" step="1" required>
                                </div>
                            </div>
                            <!-- La fecha se genera automáticamente, no se muestra -->
                        </form>
                    </div>
                </div>
                <div class="row equal-height-row">
                    <!-- Product selection card -->
                    <div class="col-md-6 col-sm-12 mb-3 equal-height-col">
                        <div class="card equal-height-card">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">Añadir Productos</h5>
                            </div>
                            <div class="card-body">
                                <form id="productForm">
                                    <div class="mb-3">
                                        <label for="product_id" class="form-label">Producto</label>
                                        <select class="form-select" name="product_id" id="product_id" required>
                                            <option value="" selected disabled>Selecciona un producto...</option>
                                            <?php
                                            $sortedProducts = $data['products']->sortBy('name');
                                            foreach ($sortedProducts as $product): ?>
                                                <option value="<?= $product->product_id ?>" data-price="<?= $product->price ?>"><?= $product->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Cantidad</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Precio (€)</label>
                                        <input type="text" class="form-control" id="price" name="price" readonly>
                                    </div>
                                    <button type="button" id="addProductBtn" class="btn btn-primary w-100">
                                        <i class="fas fa-plus"></i> Añadir Producto
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Total and save order card -->
                    <div class="col-md-6 col-sm-12 mb-3 equal-height-col">
                        <div class="card equal-height-card">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">Resumen del Pedido</h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($data['order']->date)) ?>
                                </div>
                                <div id="orderTotalSection" class="mb-3">
                                    <h5>Total: <span id="orderTotal">0.00</span>€</h5>
                                </div>
                                <div class="mt-auto">
                                    <button type="button" id="saveOrderBtn" class="btn btn-success w-100 mb-2">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                    <a href="<?= base_url() ?>order/index" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contenedor para mensajes de alerta -->
                <div id="alertContainer" class="mt-3"></div>
            </div>

            <!-- Columna derecha - Tabla de productos (70%) -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Productos del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <!-- Mensaje de carga -->
                        <div id="loadingMessage" class="text-center d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p>Procesando...</p>
                        </div>

                        <!-- Mensaje cuando no hay productos -->
                        <div id="noProductsMessage" class="alert alert-info">
                            No hay productos añadidos al pedido.
                        </div>

                        <table id="orderProductsTable" class="table table-striped table-hover d-none">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="col-1">ID </th>
                                    <th scope="col" class="col-5">Producto</th>
                                    <th scope="col" class="col-2">Precio</th>
                                    <th scope="col" class="col-2">Cantidad</th>
                                    <th scope="col" class="col-2">Subtotal</th>
                                    <th scope="col" class="col-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="orderProducts"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                    <td colspan="2"><span id="subtotal">0.00</span>€</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Descuento:</strong></td>
                                    <td colspan="2"><span id="discountAmount">0.00</span>€</td>
                                </tr>
                                <tr class="table-active">
                                    <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                    <td colspan="2"><strong><span id="totalWithDiscount">0.00</span>€</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
