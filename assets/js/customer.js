document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const alertContainer = document.getElementById('alertContainer');
    
    // Handle form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading indicator
            showAlert('Guardando cliente...', 'info');
            
            // Prepare form data - match the field names with your database structure
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('number', document.getElementById('phone').value); // Phone number field
            formData.append('street', document.getElementById('address').value); // Address street field
            formData.append('city', document.getElementById('city').value);
            formData.append('zip_code', document.getElementById('postal_code').value);
            formData.append('country', document.getElementById('pais').value); // Country field
            
            // Send data to server using fetch API
            fetch(window.location.origin + '/tiendamvc/customer/store', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    showAlert('Cliente agregado correctamente', 'success');
                    
                    // Reset form
                    form.reset();
                    
                    // Refresh customer list after 1.5 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    // Show error message
                    showAlert('Error al agregar cliente: ' + (data.message || 'Error desconocido'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error en la conexión. Detalles en la consola.', 'danger');
            });
        });
    }
    
    // Setup delete buttons
    setupDeleteButtons();
    
    function setupDeleteButtons() {
        const deleteButtons = document.querySelectorAll('.delete-customer');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const customerId = this.getAttribute('data-id');
                const customerRow = this.closest('tr');
                const customerName = customerRow.querySelector('td:nth-child(2)').textContent;
                
                if (confirm(`¿Está seguro que desea eliminar el cliente "${customerName}"?`)) {
                    // Send delete request
                    fetch(window.location.origin + `/tiendamvc/customer/delete/${customerId}`, {
                        method: 'POST'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Remove row from table
                            customerRow.remove();
                            showAlert('Cliente eliminado correctamente', 'success');
                            
                            // Check if table is empty
                            const customerList = document.getElementById('customerList');
                            if (customerList.children.length === 0) {
                                document.getElementById('noCustomersMessage').classList.remove('d-none');
                            }
                        } else {
                            showAlert('Error al eliminar cliente: ' + (data.message || 'Error desconocido'), 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Error en la conexión', 'danger');
                    });
                }
            });
        });
    }
    
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
