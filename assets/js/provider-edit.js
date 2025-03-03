document.addEventListener('DOMContentLoaded', function() {
    // Function to validate phone number format
    function validatePhone(phone) {
        // Basic validation - customize as needed for your region's format
        return /^[0-9\+\-\s]{6,20}$/.test(phone);
    }

    // Function to validate URL format
    function validateUrl(url) {
        if (!url) return true; // Allow empty values
        return /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/.test(url);
    }

    // Validate web URL
    const webInput = document.getElementById('web');
    if (webInput) {
        webInput.addEventListener('input', function() {
            if (!validateUrl(this.value.trim()) && this.value.trim().length > 0) {
                this.classList.add('is-invalid');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.innerText = 'Por favor, ingrese una URL válida';
                    this.parentNode.insertBefore(feedback, this.nextSibling);
                }
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }

    // Form validation for new address
    const newAddressForm = document.getElementById('newAddressForm');
    if (newAddressForm) {
        newAddressForm.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validate street
            const street = document.getElementById('new_street');
            if (!street.value.trim()) {
                street.classList.add('is-invalid');
                isValid = false;
            } else {
                street.classList.remove('is-invalid');
            }
            
            // Validate city
            const city = document.getElementById('new_city');
            if (!city.value.trim()) {
                city.classList.add('is-invalid');
                isValid = false;
            } else {
                city.classList.remove('is-invalid');
            }
            
            // Validate zip code
            const zipCode = document.getElementById('new_zip_code');
            if (!zipCode.value.trim()) {
                zipCode.classList.add('is-invalid');
                isValid = false;
            } else {
                zipCode.classList.remove('is-invalid');
            }
            
            // Validate country
            const country = document.getElementById('new_country');
            if (!country.value.trim()) {
                country.classList.add('is-invalid');
                isValid = false;
            } else {
                country.classList.remove('is-invalid');
            }
            
            // If form is not valid, prevent submission
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    // Form validation for new phone
    const newPhoneForm = document.getElementById('newPhoneForm');
    if (newPhoneForm) {
        newPhoneForm.addEventListener('submit', function(event) {
            const phone = document.getElementById('new_phone');
            
            if (!validatePhone(phone.value.trim())) {
                phone.classList.add('is-invalid');
                event.preventDefault();
            } else {
                phone.classList.remove('is-invalid');
            }
        });
    }

    // Real-time validation for phone field
    const phoneInput = document.getElementById('new_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            if (!validatePhone(this.value.trim()) && this.value.trim().length > 0) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }

    // Add success message when redirected after form submission
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    const successAction = getUrlParameter('success');
    const successType = getUrlParameter('type');
    
    if (successAction === 'added' && successType) {
        const messageContainer = document.getElementById('successMessages');
        const message = successType === 'address' ? 
            'Nueva dirección agregada correctamente.' : 
            'Nuevo teléfono agregado correctamente.';
            
        const alertElement = document.createElement('div');
        alertElement.className = 'alert alert-success alert-dismissible fade show';
        alertElement.role = 'alert';
        alertElement.innerHTML = `
            <i class="fas fa-check-circle me-2"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        messageContainer.appendChild(alertElement);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertElement);
            bsAlert.close();
        }, 5000);
    }
});
