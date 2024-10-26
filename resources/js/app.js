require('./bootstrap');

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'select2';
$(document).ready(function() {
    $('.select2').select2();
});

/*

window.showToast = function(type, message) {
    var toastTypeClass = type === 'success' ? 'toast-success' : 'toast-danger';
    var toastCircleClass = type === 'success' ? 'bg-success' : 'bg-danger';
    var toastHTML = `
        <div class="toast ${toastTypeClass}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
            <div class="toast-header">
                <div class="toast-circle ${toastCircleClass} mr-2"></div>
                <strong class="me-auto mr-2">${type === 'success' ? 'Éxito' : 'Error'}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    $('#toast-container').append(toastHTML);
    var toast = new bootstrap.Toast($('#toast-container .toast').last());
    toast.show();
}
*/

(function() {
    const userMenu = document.getElementById('navbarDropdown');
    userMenu.addEventListener('click', function(event) {
        userMenu.classList.toggle('show');
    });

    const sidebarIcon = document.getElementById('sidenav-main-icon');
    sidebarIcon.addEventListener('click', function(event) {
        document.body.classList.toggle('g-sidenav-pinned');
    });
})();
