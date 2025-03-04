<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Editar Producto</a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin/index">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>product/index">Productos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Producto</li>
                </ol>
            </nav>
        </div>
    </nav>
    </br>
    <div class="container2">
        <div>
            <div id="alertContainer" class="mb-3"></div>

            <form id="productEditForm">
                <input type="hidden" id="product_id" value="<?= $data['product']->product_id ?>">
                <div class="form-container3">
                    <h5 class="card-title">Datos de <?= $data['product']->name ?></h5>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($data['product']->name) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($data['product']->description) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categoría</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option selected>Selecciona...</option>
                            <?php foreach ($data['categories'] as $category): ?>
                                <option value="<?= $category->category_id ?>" <?= $category->category_id == $data['product']->category_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="provider_id" class="form-label">Proveedor</label>
                        <select class="form-control" id="provider_id" name="provider_id">
                            <option selected>Selecciona...</option>
                            <?php foreach ($data['providers'] as $provider): ?>
                                <option value="<?= $provider->provider_id ?>" <?= $provider->provider_id == $data['product']->provider_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($provider->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12 mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" min="0" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($data['product']->stock) ?>">
                        </div>
                        <div class="form-group col-md-6 col-sm-12 mb-3">
                            <label for="price">Precio</label>
                            <input type="number" min="0" step="0.01" class="form-control" id="price" name="price" value="<?= htmlspecialchars($data['product']->price) ?>">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                    <a href="<?= base_url() ?>product/index" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    <button type="submit" class="btn btn-outline-primary">Actualizar Producto</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('productEditForm');
            const alertContainer = document.getElementById('alertContainer');
            const productId = document.getElementById('product_id').value;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading message
                showAlert('Actualizando producto...', 'info');

                // Prepare product data object
                const productData = {
                    name: document.getElementById('name').value,
                    description: document.getElementById('description').value,
                    category_id: document.getElementById('category_id').value,
                    provider_id: document.getElementById('provider_id').value,
                    stock: document.getElementById('stock').value,
                    price: document.getElementById('price').value
                };

                // Send data to server
                fetch(`${window.location.origin}/tiendamvc/product/update/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(productData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showAlert('Producto actualizado correctamente', 'success');

                            // Redirect back to product list after 1.5 seconds
                            setTimeout(() => {
                                window.location.href = `${window.location.origin}/tiendamvc/product/index`;
                            }, 1500);
                        } else {
                            showAlert('Error al actualizar el producto: ' + (data.message || 'Error desconocido'), 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Error en la conexión. Detalles en la consola.', 'danger');
                    });
            });

            // Helper function to show alerts
            function showAlert(message, type) {
                alertContainer.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Auto-dismiss after 5 seconds for success and info messages
                if (type === 'success' || type === 'info') {
                    setTimeout(() => {
                        const alert = alertContainer.querySelector('.alert');
                        if (alert) {
                            const bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        }
                    }, 5000);
                }
            }
        });
    </script>
</body>

</html>