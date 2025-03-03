document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const priceInput = document.getElementById('price');
    const discountInput = document.getElementById('discount');
    const customerSelect = document.getElementById('customer_id');
    const addProductBtn = document.getElementById('addProductBtn');
    const saveOrderBtn = document.getElementById('saveOrderBtn');
    const orderProductsTable = document.getElementById('orderProductsTable');
    const orderProductsBody = document.getElementById('orderProducts');
    const noProductsMessage = document.getElementById('noProductsMessage');
    const loadingMessage = document.getElementById('loadingMessage');
    const alertContainer = document.getElementById('alertContainer');
    const subtotalSpan = document.getElementById('subtotal');
    const discountAmountSpan = document.getElementById('discountAmount');
    const totalWithDiscountSpan = document.getElementById('totalWithDiscount');
    const orderTotalSpan = document.getElementById('orderTotal');
    
    // Variables
    let orderId = document.getElementById('order_id').value;
    let orderProducts = [];
    
    // Initialize
    loadOrderData();
    updatePriceFromSelect();
    
    // Event listeners
    productSelect.addEventListener('change', updatePriceFromSelect);
    
    quantityInput.addEventListener('input', function() {
        updatePriceDisplay();
    });
    
    discountInput.addEventListener('input', function() {
        // Ensure discount is between 0 and 100
        if (this.value < 0) this.value = 0;
        if (this.value > 100) this.value = 100;
        
        calculateTotals();
    });
    
    addProductBtn.addEventListener('click', function() {
        addProductToOrder();
    });
    
    saveOrderBtn.addEventListener('click', function() {
        saveOrder();
    });
    
    // Functions
    function updatePriceFromSelect() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            priceInput.value = selectedOption.dataset.price;
            updatePriceDisplay();
        } else {
            priceInput.value = '';
        }
    }
    
    function updatePriceDisplay() {
        // Nothing to update if price is not set
        if (!priceInput.value) return;
    }
    
    function loadOrderData() {
        // Show loading
        loadingMessage.classList.remove('d-none');
        
        // Fetch order data
        fetch(`${window.location.origin}/tiendamvc/order/getOrderData/${orderId}`)
            .then(response => response.json())
            .then(data => {
                loadingMessage.classList.add('d-none');
                
                // Debug data
                console.log("Order data received:", data);
                
                if (data.success) {
                    // Set customer and discount
                    customerSelect.value = data.order.customer_id;
                    discountInput.value = data.order.discount;
                    
                    // Load products
                    if (data.order.products && data.order.products.length > 0) {
                        console.log("First product:", data.order.products[0]);
                        
                        orderProducts = data.order.products.map(product => {
                            // Fix 1: Ensure price is a number by using parseFloat with fallback to 0
                            let price = 0;
                            if (product.pivot && product.pivot.price) {
                                price = parseFloat(product.pivot.price) || 0;
                            } else if (product.price) {
                                price = parseFloat(product.price) || 0;
                            }
                            
                            // Get quantity from pivot or use 1 as default
                            let quantity = 1;
                            if (product.pivot && product.pivot.quantity) {
                                quantity = parseInt(product.pivot.quantity) || 1;
                            }
                            
                            return {
                                id: product.product_id,
                                name: product.name,
                                price: price,
                                quantity: quantity,
                                subtotal: price * quantity
                            };
                        });
                        
                        // Render products and calculate totals
                        renderOrderProducts();
                        calculateTotals();
                    }
                } else {
                    showAlert(`Error: ${data.message}`, 'danger');
                }
            })
            .catch(error => {
                loadingMessage.classList.add('d-none');
                console.error('Error:', error);
                showAlert('Ha ocurrido un error al cargar los datos del pedido', 'danger');
            });
    }
    
    function addProductToOrder() {
        // Validate inputs
        if (!validateProductForm()) return;
        
        const productId = parseInt(productSelect.value);
        const productName = productSelect.options[productSelect.selectedIndex].text;
        const price = parseFloat(priceInput.value);
        const quantity = parseInt(quantityInput.value);
        const subtotal = price * quantity;
        
        // Check if product already exists in the order
        const existingProductIndex = orderProducts.findIndex(p => p.id === productId);
        
        if (existingProductIndex !== -1) {
            // Update existing product quantity
            orderProducts[existingProductIndex].quantity += quantity;
            orderProducts[existingProductIndex].subtotal = orderProducts[existingProductIndex].quantity * price;
        } else {
            // Add new product
            orderProducts.push({
                id: productId,
                name: productName,
                price: price,
                quantity: quantity,
                subtotal: subtotal
            });
        }
        
        // Update UI
        renderOrderProducts();
        calculateTotals();
        
        // Reset product form
        productSelect.selectedIndex = 0;
        quantityInput.value = 1;
        priceInput.value = '';
        
        // Show success message
        showAlert('Producto añadido correctamente', 'success');
    }
    
    function renderOrderProducts() {
        // Clear table
        orderProductsBody.innerHTML = '';
        
        if (orderProducts.length === 0) {
            // Show no products message
            orderProductsTable.classList.add('d-none');
            noProductsMessage.classList.remove('d-none');
            return;
        }
        
        // Show table and hide no products message
        orderProductsTable.classList.remove('d-none');
        noProductsMessage.classList.add('d-none');
        
        // Add products to table
        orderProducts.forEach((product, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>${product.price.toFixed(2)}€</td>
                <td>
                    <div class="input-group">
                        <input type="number" class="form-control form-control-sm quantity-input" value="${product.quantity}" min="1" data-index="${index}">
                    </div>
                </td>
                <td>${product.subtotal.toFixed(2)}€</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-product" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            orderProductsBody.appendChild(row);
        });
        
        // Add event listeners to buttons and inputs
        document.querySelectorAll('.remove-product').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                orderProducts.splice(index, 1);
                renderOrderProducts();
                calculateTotals();
            });
        });
        
        document.querySelectorAll('.increase-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                orderProducts[index].quantity++;
                orderProducts[index].subtotal = orderProducts[index].quantity * orderProducts[index].price;
                renderOrderProducts();
                calculateTotals();
            });
        });
        
        document.querySelectorAll('.decrease-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                if (orderProducts[index].quantity > 1) {
                    orderProducts[index].quantity--;
                    orderProducts[index].subtotal = orderProducts[index].quantity * orderProducts[index].price;
                    renderOrderProducts();
                    calculateTotals();
                }
            });
        });
        
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const index = parseInt(this.dataset.index);
                const newQuantity = parseInt(this.value) || 1;
                
                if (newQuantity < 1) {
                    this.value = 1;
                    orderProducts[index].quantity = 1;
                } else {
                    orderProducts[index].quantity = newQuantity;
                }
                
                orderProducts[index].subtotal = orderProducts[index].quantity * orderProducts[index].price;
                renderOrderProducts();
                calculateTotals();
            });
        });
    }
    
    function calculateTotals() {
        // Calculate subtotal
        const subtotal = orderProducts.reduce((total, product) => total + product.subtotal, 0);
        subtotalSpan.textContent = subtotal.toFixed(2);
        
        // Calculate discount
        const discountPercentage = parseFloat(discountInput.value) || 0;
        const discountAmount = subtotal * (discountPercentage / 100);
        discountAmountSpan.textContent = discountAmount.toFixed(2);
        
        // Calculate total with discount
        const totalWithDiscount = subtotal - discountAmount;
        totalWithDiscountSpan.textContent = totalWithDiscount.toFixed(2);
        orderTotalSpan.textContent = totalWithDiscount.toFixed(2);
        
        // Enable/disable save button
        saveOrderBtn.disabled = orderProducts.length === 0;
    }
    
    function saveOrder() {
        // Validate order
        if (!validateOrderForm()) return;
        
        // Show loading
        loadingMessage.classList.remove('d-none');
        
        // Get customer ID and discount
        const customerId = customerSelect.value;
        const discount = parseFloat(discountInput.value) || 0;
        
        // Prepare order data
        const orderData = {
            order_id: orderId,
            customer_id: customerId,
            discount: discount,
            total: parseFloat(totalWithDiscountSpan.textContent),
            products: orderProducts.map(product => ({
                id: product.id,
                quantity: product.quantity,
                price: product.price
            }))
        };
        
        // Send request
        fetch(`${window.location.origin}/tiendamvc/order/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            loadingMessage.classList.add('d-none');
            
            if (data.success) {
                // Show success message
                showAlert('Pedido actualizado correctamente', 'success');
                
                // Redirect after a short delay
                setTimeout(() => {
                    window.location.href = `${window.location.origin}/tiendamvc/order/index`;
                }, 1500);
            } else {
                // Show error message
                showAlert(`Error: ${data.message}`, 'danger');
            }
        })
        .catch(error => {
            loadingMessage.classList.add('d-none');
            console.error('Error:', error);
            showAlert('Ha ocurrido un error al actualizar el pedido', 'danger');
        });
    }
    
    function validateProductForm() {
        if (!productSelect.value) {
            showAlert('Debes seleccionar un producto', 'danger');
            return false;
        }
        
        if (!quantityInput.value || quantityInput.value < 1) {
            showAlert('La cantidad debe ser al menos 1', 'danger');
            return false;
        }
        
        return true;
    }
    
    function validateOrderForm() {
        if (!customerSelect.value) {
            showAlert('Debes seleccionar un cliente', 'danger');
            return false;
        }
        
        if (orderProducts.length === 0) {
            showAlert('El pedido debe tener al menos un producto', 'danger');
            return false;
        }
        
        return true;
    }
    
    function showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto dismiss after 3 seconds
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => {
                // Fix 2: Check if alert is still in the DOM before removing
                if (alert.parentNode === alertContainer) {
                    alertContainer.removeChild(alert);
                }
            }, 150);
        }, 3000);
    }
});
