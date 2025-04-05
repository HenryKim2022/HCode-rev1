<style>
    .toast .text-muted {
        color: wheat !important;
    }
</style>

<!-- Stacked Toast Container -->
<div id="toast-container" aria-live="polite" aria-atomic="true"
    style="position: fixed; top: 10.8%; right: 0%; z-index: 9999;">
</div>




<script>
    // Function to dynamically create and show a toast
    function showToast(title, message, type = 'info', autohide = true, delay = 3000) {
        // Generate a unique ID for the toast
        const toastId = `toast-${Date.now()}-${Math.floor(Math.random() * 1000)}`;

        // Create the toast element
        const toastEl = document.createElement('div');
        toastEl.id = toastId;
        toastEl.className = 'toast fade';
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        toastEl.style.marginTop = '4px';

        // Create the toast header
        const toastHeader = document.createElement('div');
        toastHeader.className = 'toast-header';

        const logoImg = document.createElement('img');
        logoImg.src = "{{ asset('template/assets/images/logo-sm.png') }}?v={{ time() }}";
        logoImg.alt = "brand-logo";
        logoImg.height = 16;
        logoImg.className = 'me-1';

        const titleStrong = document.createElement('strong');
        titleStrong.className = 'me-auto';
        titleStrong.innerText = title;

        const timestampSmall = document.createElement('small');
        timestampSmall.className = 'text-muted';
        timestampSmall.innerText = 'just now';

        const closeButton = document.createElement('button');
        closeButton.type = 'button';
        closeButton.className = 'btn-close';
        closeButton.setAttribute('data-bs-dismiss', 'toast');
        closeButton.setAttribute('aria-label', 'Close');

        toastHeader.appendChild(logoImg);
        toastHeader.appendChild(titleStrong);
        toastHeader.appendChild(timestampSmall);
        toastHeader.appendChild(closeButton);

        // Create the toast body
        const toastBody = document.createElement('div');
        toastBody.className = 'toast-body';
        toastBody.innerText = message;

        // Append header and body to the toast element
        toastEl.appendChild(toastHeader);
        toastEl.appendChild(toastBody);

        // Define CSS classes for each type
        const typeClasses = {
            success: ['text-bg-success', 'bg-success-subtle'],
            warning: ['text-bg-warning', 'bg-warning-subtle'],
            info: ['text-bg-info', 'bg-info-subtle'],
            error: ['text-bg-danger', 'bg-danger-subtle'],
        };

        // Apply the appropriate type classes
        if (typeClasses[type]) {
            toastHeader.classList.add(typeClasses[type][0]);
            toastBody.classList.add(typeClasses[type][1]);
        } else {
            console.warn(`Unknown toast type: ${type}. Defaulting to 'info'.`);
            toastHeader.classList.add(typeClasses['info'][0]);
            toastBody.classList.add(typeClasses['info'][1]);
        }

        // Append the toast to the container
        const toastContainer = document.getElementById('toast-container');
        toastContainer.appendChild(toastEl);

        // Initialize and show the toast
        const toast = new bootstrap.Toast(toastEl, {
            autohide: autohide,
            delay: delay,
        });
        toast.show();

        // Remove the toast from the DOM after it is hidden
        toastEl.addEventListener('hidden.bs.toast', () => {
            toastEl.remove();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Define an array of messages with types
        const Messages = [
            { title: 'Success', message: 'Your account has been successfully updated.', type: 'success', autohide: true },
            { title: 'Error', message: 'An error occurred while processing your request.', type: 'error', autohide: true },
            { title: 'Info', message: 'This is an informational message.', type: 'info', autohide: true },
            { title: 'Warning', message: 'This action cannot be undone. Proceed with caution.', type: 'warning', autohide: true },
        ];

        // // Loop through the Messages array and display each toast with a 1-second delay
        // Messages.forEach((msg, index) => {
        //     setTimeout(() => {
        //         showToast(msg.title, msg.message, msg.type, msg.autohide, index + 6000);
        //     }, index * 1000); // Add a 1-second delay between each toast
        // });
    });
</script>
