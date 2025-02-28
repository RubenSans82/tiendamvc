document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const alertContainer = document.getElementById('alertContainer');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading indicator
            showAlert('Guardando proveedor...', 'info');

            // Prepare form data
            const formData = new FormData(form);

            // Send data to server using fetch API
            fetch(window.location.origin + '/tiendamvc/provider/store', {
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
                    showAlert('Proveedor agregado correctamente', 'success');

                    // Reset form
                    form.reset();

                    // Refresh provider list after 1.5 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    // Show error message
                    showAlert('Error al agregar proveedor: ' + (data.message || 'Error desconocido'), 'danger');
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
        const deleteButtons = document.querySelectorAll('.delete-provider');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const providerId = this.getAttribute('data-id');

                if (confirm('Are you sure you want to delete this provider?')) {
                    // Send delete request
                    fetch(window.location.origin + `/tiendamvc/provider/delete/${providerId}`, {
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
                            this.closest('tr').remove();
                            showAlert('Proveedor eliminado correctamente', 'success');

                            // Check if table is empty
                            const providerList = document.getElementById('providerList');
                            if (providerList.children.length === 0) {
                                document.getElementById('noProvidersMessage').classList.remove('d-none');
                            }
                        } else {
                            showAlert('Error al eliminar proveedor: ' + (data.message || 'Error desconocido'), 'danger');
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
