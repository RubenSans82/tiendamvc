<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <script src="<?= base_url() ?>assets/js/product.js" defer></script>
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Productos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=base_url()?>admin/index">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Navbar text with an inline element
                </span>
            </div>
        </div>
    </nav>
    </br>

    <div class="container-fluid">
        <div class="product-container">
            <!-- Columna izquierda - Formulario (30%) -->
            <div class="form-container">
                <h3>Añadir nuevo producto</h3>
                <form id="form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Producto" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Descripción del Producto" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Categoria</label>
                        <select class="form-control" name="category" id="category" required>
                            <option selected>Selecciona...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="provider" class="form-label">Proveedor</label>
                        <select class="form-control" name="provider" id="provider" required>
                            <option selected>Selecciona...</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12 mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" min="0" class="form-control" id="stock" placeholder="Stock" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 mb-3">
                            <label for="price">Precio</label>
                            <input type="number" min="0" class="form-control" id="price" placeholder="Precio" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Guardar</button>
                </form>

                <!-- Contenedor para mensajes de alerta -->
                <div id="alertContainer" class="mt-3"></div>
            </div>

            <!-- Columna derecha - Tabla (70%) -->
            <div class="table-section">


                <div class="table-container ms-auto">
                    <h3>Lista de productos</h3>

                    <!-- Mensaje de carga - inicialmente oculto -->
                    <div id="loadingMessage" class="text-center d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p>Cargando productos...</p>
                    </div>

                    <!-- Mensaje cuando no hay productos -->
                    <div id="noProductsMessage" class="alert alert-info text-center d-none">
                        No hay productos disponibles.
                    </div>
                    <table class="table table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Proveedor</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productList">
                            <!-- Los productos se cargarán aquí dinámicamente desde JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Verifica si hay algún error en la carga de productos
        window.addEventListener('error', function(e) {
            if (e.target.tagName.toLowerCase() === 'script') {
                console.error('Error loading script:', e);
                document.getElementById('loadingMessage').innerHTML =
                    '<div class="alert alert-danger">Error cargando los productos. Por favor, recarga la página.</div>';
            }
        }, true);
    </script>
</body>

</html>