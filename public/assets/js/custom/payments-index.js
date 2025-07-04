$(document).ready(function() {
    var table = $('#payments_table').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        pageLength: 10,
        lengthChange: false,
        info: false,
        language: {
            search: "Cari:",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        },
        dom: 't'
    });

    // Custom Info
    function updateInfo() {
        var pageInfo = table.page.info();
        $('#payments_table_info').text(
            'Menampilkan ' + (pageInfo.start + 1) + ' - ' + pageInfo.end + ' dari ' + pageInfo.recordsDisplay + ' data'
        );
    }
    table.on('draw', updateInfo);
    updateInfo();

    // Custom Pagination
    function updatePagination() {
        var pageInfo = table.page.info();
        var html = '';
        if (pageInfo.pages > 1) {
            html += '<nav><ul class="pagination pagination-sm mb-0">';
            html += '<li class="page-item' + (pageInfo.page === 0 ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (pageInfo.page - 1) + '">&laquo;</a></li>';
            for (var i = 0; i < pageInfo.pages; i++) {
                html += '<li class="page-item' + (i === pageInfo.page ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + (i + 1) + '</a></li>';
            }
            html += '<li class="page-item' + (pageInfo.page === pageInfo.pages - 1 ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (pageInfo.page + 1) + '">&raquo;</a></li>';
            html += '</ul></nav>';
        }
        $('#payments_table_paginate').html(html);
    }
    table.on('draw', updatePagination);
    updatePagination();

    // Handle custom pagination click
    $('#payments_table_footer').on('click', '.page-link', function(e) {
        e.preventDefault();
        var page = parseInt($(this).data('page'));
        if (!isNaN(page)) {
            table.page(page).draw('page');
        }
    });

    // Custom page length
    $('#payments_table_length').on('change', function() {
        table.page.len($(this).val()).draw();
    });

    // Input Search
    $('#search-input').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Filter Status
    $('#filter-status').on('change', function() {
        table.column(6).search(this.value).draw();
    });

    // Clear Filter
    $('#clear-filter').on('click', function() {
        $('#filter-status').val('');
        table.column(6).search('').draw();
        $('#search-input').val('');
        table.search('').draw();
    });
});