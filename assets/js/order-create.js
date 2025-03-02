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
    let orderId = null;
    let orderProducts = [];
    let isDraft = true;
    
    // Initialize
    loadOrderDraft();
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
        saveOrderDraft();
    });
    
    customerSelect.addEventListener('change', function() {
        saveOrderDraft();
    });
    
    addProductBtn.addEventListener('click', function() {
        addProductToOrder();
    });
    
    saveOrderBtn.addEventListener('click', function() {
        saveOrder();
    });
    
    // Add a clear draft button
    const clearDraftBtn = document.createElement('button');
    clearDraftBtn.type = 'button';
    clearDraftBtn.className = 'btn btn-outline-secondary w-100 mt-2';
    clearDraftBtn.innerHTML = '<i class="fas fa-trash"></i> Limpiar Borrador';
    clearDraftBtn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas eliminar el borrador del pedido?')) {
            clearOrderDraft();
            window.location.reload();
        }
    });
    saveOrderBtn.parentNode.appendChild(clearDraftBtn);
    
    // Add notification about draft
    const draftNotice = document.createElement('div');
    draftNotice.className = 'alert alert-info mt-2 text-center';
    draftNotice.innerHTML = '<small><i class="fas fa-info-circle"></i> Los cambios se guardan automáticamente como borrador</small>';
    saveOrderBtn.parentNode.appendChild(draftNotice);
    
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
        
        // Save draft
        saveOrderDraft();
        
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
                <td>${product.quantity}</td>
                <td>${product.subtotal.toFixed(2)}€</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-product" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            orderProductsBody.appendChild(row);
        });
        
        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-product').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                orderProducts.splice(index, 1);
                renderOrderProducts();
                calculateTotals();
                saveOrderDraft();
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
        fetch(`${window.location.origin}/tiendamvc/order/store`, {
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
                // Clear draft since order is successfully saved
                clearOrderDraft();
                
                // Show success message
                showAlert('Pedido guardado correctamente', 'success');
                
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
            showAlert('Ha ocurrido un error al guardar el pedido', 'danger');
        });
    }
    
    function saveOrderDraft() {
        // Don't save if we're not in draft mode
        if (!isDraft) return;
        
        // Get current form state
        const draftData = {
            customer_id: customerSelect.value || '',
            discount: discountInput.value || 0,
            products: orderProducts,
            lastUpdated: new Date().toISOString()
        };
        
        // Save to localStorage
        localStorage.setItem('orderDraft', JSON.stringify(draftData));
        
        // Show autosave indication (optional)
        const saveIndicator = document.createElement('div');
        saveIndicator.className = 'text-muted text-end';
        saveIndicator.style.fontSize = '0.8rem';
        saveIndicator.innerHTML = '<i class="fas fa-save"></i> Guardado automáticamente';
        
        // Remove any existing save indicator
        document.querySelectorAll('.autosave-indicator').forEach(el => el.remove());
        saveIndicator.classList.add('autosave-indicator');
        
        draftNotice.parentNode.appendChild(saveIndicator);
        
        // Remove the indicator after a short time
        setTimeout(() => {
            saveIndicator.remove();
        }, 2000);
    }
    
    function loadOrderDraft() {
        // Check if there's a draft in localStorage
        const draftData = localStorage.getItem('orderDraft');
        if (!draftData) return;
        
        try {
            const draft = JSON.parse(draftData);
            
            // Check if draft has data
            if (draft.customer_id) {
                customerSelect.value = draft.customer_id;
            }
            
            if (draft.discount) {
                discountInput.value = draft.discount;
            }
            
            if (draft.products && Array.isArray(draft.products) && draft.products.length > 0) {
                orderProducts = draft.products;
                renderOrderProducts();
                calculateTotals();
                
                // Show notification
                showAlert(`Se ha cargado un borrador guardado (${new Date(draft.lastUpdated).toLocaleString()})`, 'info');
            }
        } catch (error) {
            console.error('Error loading draft:', error);
            // If there's an error, clear the corrupted draft
            clearOrderDraft();
        }
    }
    
    function clearOrderDraft() {
        localStorage.removeItem('orderDraft');
        isDraft = true;
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
                alertContainer.removeChild(alert);
            }, 150);
        }, 3000);
    }
});
