document.addEventListener('DOMContentLoaded', function () {
    // Tooltip Bootstrap untuk semua elemen dengan data-bs-toggle="tooltip"
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});