// Wrapper para toastr compatible con Vite
import $ from 'jquery';

// Definir toastr manualmente
window.toastr = (function() {
    const toastr = {};
    const container = $('<div id="toast-container" class="toast-top-right"></div>');
    $('body').append(container);

    function show(message, title, type) {
        const toast = $(`
            <div class="toast toast-${type}" aria-live="polite">
                ${title ? `<div class="toast-title">${title}</div>` : ''}
                <div class="toast-message">${message}</div>
            </div>
        `);
        
        container.append(toast);
        toast.fadeIn(300);
        
        setTimeout(() => {
            toast.fadeOut(1000, () => toast.remove());
        }, 5000);
    }

    toastr.success = (message, title) => show(message, title, 'success');
    toastr.error = (message, title) => show(message, title, 'error');
    toastr.info = (message, title) => show(message, title, 'info');
    toastr.warning = (message, title) => show(message, title, 'warning');

    return toastr;
})();

export default window.toastr;
