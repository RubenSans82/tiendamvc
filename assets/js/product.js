fetch("http://localhost/tiendamvc/api/categories")
    .then(response => response.json())
    .then(data => {
        let categories = data;
        let select = document.getElementById("category");
        categories.forEach(category => {
            let option = document.createElement("option");
            option.value = category.category_id;
            option.text = category.name;
            select.appendChild(option);
        });
    })
    .catch(error => console.error(error));

fetch("http://localhost/tiendamvc/api/providers")
    .then(response => response.json())
    .then(data => {
        let categories = data;
        let select = document.getElementById("provider");
        categories.forEach(provider => {
            let option = document.createElement("option");
            option.value = provider.provider_id;
            option.text = provider.name;
            select.appendChild(option);
        });
    })
    .catch(error => console.error(error));

document.getElementById("form").addEventListener("submit", function (e) {
    e.preventDefault();
    let product = {
        name: document.getElementById("name").value,
        price: document.getElementById("price").value,
        stock: document.getElementById("stock").value,
        category_id: document.getElementById("category").value,
        provider_id: document.getElementById("provider").value,
        description: document.getElementById("description").value
    }
    console.log(product);

    //ToDo: validar los datos

    // Mostrar mensaje de carga antes de la petición
    document.getElementById('loadingMessage').classList.remove('d-none');

    fetch("http://localhost/tiendamvc/api/newproduct", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(product)
    })
    .then(response => response.json())
    .then(datos => {
        // Actualizar la tabla con los nuevos datos
        showProducts(datos);
        
        // Resetear el formulario
        resetForm();
        
        // Mostrar mensaje de éxito (opcional)
        showSuccessMessage('Producto guardado correctamente');
    })
    .catch(error => {
        console.error('Error:', error);
        // Ocultar el mensaje de carga
        hideLoadingMessage();
        // Opcional: Mostrar mensaje de error
        showErrorMessage('Error al guardar el producto');
    });
});

// Función para resetear todos los campos del formulario
function resetForm() {
    // Resetear campos de texto y número
    document.getElementById("name").value = '';
    document.getElementById("description").value = '';
    document.getElementById("stock").value = '';
    document.getElementById("price").value = '';
    
    // Resetear selects a la opción por defecto
    document.getElementById("category").selectedIndex = 0;
    document.getElementById("provider").selectedIndex = 0;
    
    // Alternativa: usar el método reset del formulario
    // document.getElementById("form").reset();
    
    // Devolver el foco al primer campo
    document.getElementById("name").focus();
}

// Función opcional para mostrar un mensaje de éxito
function showSuccessMessage(message) {
    // Crear un elemento para el mensaje
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Insertar el mensaje antes de la tabla
    const form = document.getElementById('form');
    form.parentNode.insertBefore(alertDiv, form.nextSibling);
    
    // Eliminar el mensaje después de 3 segundos
    setTimeout(() => {
        alertDiv.classList.remove('show');
        setTimeout(() => alertDiv.remove(), 300);
    }, 3000);
}

// Función opcional para mostrar un mensaje de error
function showErrorMessage(message) {
    // Similar a showSuccessMessage pero con clase alert-danger
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const form = document.getElementById('form');
    form.parentNode.insertBefore(alertDiv, form.nextSibling);
    
    setTimeout(() => {
        alertDiv.classList.remove('show');
        setTimeout(() => alertDiv.remove(), 300);
    }, 3000);
}

function showProducts(datos) {
    // Ocultar el mensaje de carga
    hideLoadingMessage();
    
    if (datos && datos.length > 0) {
        const tableBody = document.getElementById('productList');
        
        // Clear existing table content
        tableBody.innerHTML = '';
        
        // Loop through products and add them to the table
        datos.forEach(product => {
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td>${product.product_id}</td>
                <td>${product.name}</td>
                <td>${product.description}</td>
                <td>${product.category_name || product.category_id}</td>
                <td>${product.provider_name || product.provider_id}</td>
                <td>${product.stock}</td>
                <td>${product.price}€</td>
                <td>
                    <button class="btn btn-sm btn-warning edit-btn" data-id="${product.product_id}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${product.product_id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            tableBody.appendChild(row);
        });
        
        // Mostrar la tabla y ocultar mensaje de no hay productos
        document.querySelector('table').classList.remove('d-none');
        document.getElementById('noProductsMessage').classList.add('d-none');
    } else {
        // No hay productos, mostrar mensaje y ocultar tabla
        document.getElementById('noProductsMessage').classList.remove('d-none');
        document.querySelector('table').classList.add('d-none');
        console.error('No products found or data format incorrect');
    }
}

// Función para ocultar el mensaje de carga
function hideLoadingMessage() {
    const loadingMessage = document.getElementById('loadingMessage');
    if (loadingMessage) {
        loadingMessage.classList.add('d-none');
    }
}

// Initial product load - ejecutar inmediatamente cuando la página se carga
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar el mensaje de carga
    document.getElementById('loadingMessage').classList.remove('d-none');
    
    fetch("http://localhost/tiendamvc/api/products")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Products loaded:', data);
            showProducts(data);
        })
        .catch(error => {
            console.error('Error loading products:', error);
            // Ocultar el mensaje de carga y mostrar error
            hideLoadingMessage();
            showErrorMessage('Error al cargar productos: ' + error.message);
        });
});

// Setup event listeners for edit and delete buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-btn') || 
        (e.target.parentElement && e.target.parentElement.classList.contains('edit-btn'))) {
        const button = e.target.classList.contains('edit-btn') ? e.target : e.target.parentElement;
        const productId = button.getAttribute('data-id');
        console.log('Edit product:', productId);
        // Implementar lógica de edición aquí
    }
    
    if (e.target.classList.contains('delete-btn') || 
        (e.target.parentElement && e.target.parentElement.classList.contains('delete-btn'))) {
        const button = e.target.classList.contains('delete-btn') ? e.target : e.target.parentElement;
        const productId = button.getAttribute('data-id');
        console.log('Delete product:', productId);
        
        if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
            // Mostrar el mensaje de carga
            document.getElementById('loadingMessage').classList.remove('d-none');
            
            fetch(`http://localhost/tiendamvc/api/deleteproduct/${productId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                console.log('Product deleted:', data);
                // Recargar la lista de productos
                fetch("http://localhost/tiendamvc/api/products")
                    .then(response => response.json())
                    .then(data => {
                        showProducts(data);
                    });
            })
            .catch(error => {
                console.error('Error deleting product:', error);
                // Ocultar el mensaje de carga
                hideLoadingMessage();
                showErrorMessage('Error al eliminar el producto');
            });
        }
    }
});