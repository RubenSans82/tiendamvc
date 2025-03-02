document.addEventListener('DOMContentLoaded', function() {
    // Get all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-order');
    
    // Add click event listener to each delete button
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const orderId = this.getAttribute('data-id');
            
            // Confirm deletion
            if (confirm('¿Estás seguro de que deseas eliminar este pedido?')) {
                // Show loading indicator
                const loadingMessage = document.getElementById('loadingMessage');
                loadingMessage.classList.remove('d-none');
                
                // Send delete request
                fetch(`${window.location.origin}/tiendamvc/order/delete/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadingMessage.classList.add('d-none');
                    
                    if (data.success) {
                        // Remove the row from the table
                        const row = this.closest('tr');
                        row.remove();
                        
                        // Check if there are any orders left
                        const orderList = document.getElementById('orderList');
                        if (orderList.children.length === 0) {
                            document.getElementById('noOrdersMessage').classList.remove('d-none');
                        }
                        
                        // Show success message
                        alert('Pedido eliminado correctamente');
                    } else {
                        // Show error message
                        alert(`Error: ${data.message}`);
                    }
                })
                .catch(error => {
                    loadingMessage.classList.add('d-none');
                    console.error('Error:', error);
                    alert('Ha ocurrido un error al eliminar el pedido');
                });
            }
        });
    });
});
