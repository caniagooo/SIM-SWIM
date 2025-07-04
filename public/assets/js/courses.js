$(document).ready(function() {
    window.sessionsTable = $('#sessionsTable').DataTable({
        language: {
            emptyTable: "Belum ada sesi."
        },
        ordering: false,
        searching: false,
        columnDefs: [
            { targets: '_all', defaultContent: '' }
        ]
    });

    // Penomoran otomatis kolom #
    sessionsTable.on('order.dt search.dt', function () {
        sessionsTable.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

// Event delegation untuk tombol absen
$('#sessionsTable').on('click', '.btnAttendance', function () {
    const sessionId = $(this).data('session-id');
    $('#attendanceModal' + sessionId).modal('show');
});

// Event delegation untuk tombol edit
$('#sessionsTable').on('click', '.btnEditSession', function () {
    const sessionId = $(this).data('session-id');
    $('#editScheduleModal' + sessionId).modal('show');
});

// Event delegation untuk tombol hapus
$('#sessionsTable').on('click', '.btnDeleteSession', function () {
    const sessionId = $(this).data('session-id');
    if (confirm('Yakin ingin menghapus sesi ini?')) {
        $.ajax({
            url: `/courses/${COURSE_ID}/sessions/${sessionId}`,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function () {
                $(`#sessionRow${sessionId}`).remove();
                $(`#attendanceModal${sessionId}`).remove();
                $(`#editScheduleModal${sessionId}`).remove();
                reloadSessionsTable(COURSE_ID); // <-- Tambahkan di sini
                showAlert('success', 'Sesi berhasil dihapus.');
            },
            error: function () {
                showAlert('danger', 'Gagal menghapus sesi.');
            }
        });
    }
});

// Handler submit tambah jadwal sesi
$('#addScheduleForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: `/courses/${COURSE_ID}/sessions`,
        type: 'POST',
        data: $(this).serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            const modalEl = document.getElementById('addScheduleModal-' + COURSE_ID);
            const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modalInstance.hide();

            // Reset form setelah modal benar-benar tertutup
            modalEl.addEventListener('hidden.bs.modal', function () {
                $('#addScheduleForm')[0].reset();
            }, { once: true });

            // (Opsional) Paksa hapus backdrop jika masih bermasalah
            setTimeout(function() {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            }, 500);

            const session = response.data;
            
            
            reloadSessionsTable(COURSE_ID); // <-- Tambahkan di sini
            showAlert('success', 'Jadwal sesi berhasil ditambahkan. Untuk fitur edit/absen, silakan reload halaman.');
        },
        error: function(xhr) {
            let msg = 'Gagal menambah jadwal sesi.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            showAlert('danger', msg);
        }
    });
});

// Handler submit absensi sesi
$('[id^=attendanceForm]').on('submit', function(e) {
    e.preventDefault();
    const $form = $(this);
    const sessionId = $form.find('input[name="course_session_id"]').val();
    const courseId = $form.find('input[name="course_id"]').val();

    $.ajax({
        url: `/courses/${courseId}/sessions/${sessionId}/attendance`,
        type: 'POST',
        data: $form.serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            $('#attendanceModal' + sessionId).modal('hide');
            reloadSessionsTable(COURSE_ID); // <-- Tambahkan di sini
            showAlert('success', 'Absensi berhasil disimpan.');
            // Optional: update status sesi di tabel jika ingin
            $(`#sessionsStatus${sessionId}`)
                .removeClass('badge-info')
                .addClass('badge-success')
                .text('Completed');
        },
        error: function(xhr) {
            let msg = 'Gagal menyimpan absensi.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            showAlert('danger', msg);
        }
    });
});

// Handler submit edit jadwal sesi
$('[id^=editScheduleForm]').on('submit', function(e) {
    e.preventDefault();
    const $form = $(this);
    const sessionId = $form.find('input[name="course_session_id"]').val();
    const courseId = $form.find('input[name="course_id"]').val();

    $.ajax({
        url: `/courses/${courseId}/sessions/${sessionId}`,
        type: 'PUT',
        data: $form.serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            $('#editScheduleModal' + sessionId).modal('hide');
            reloadSessionsTable(COURSE_ID); // <-- Tambahkan di sini
            showAlert('success', 'Jadwal sesi berhasil di-reschedule.');

            // Update badge status di tabel
            $(`#sessionsStatus${sessionId}`)
                .removeClass('badge-info badge-success')
                .addClass('badge-warning')
                .text('Rescheduled');

            // (Opsional) Update tanggal dan jam di tabel jika ingin
            $(`#sessionRow${sessionId} td:nth-child(2)`).html(`<span class="badge badge-light-primary fs-7">${response.data.session_date_formatted}</span>`);
            $(`#sessionRow${sessionId} td:nth-child(3)`).html(`<span class="badge badge-light-info fs-7">${response.data.start_time}</span>`);
            $(`#sessionRow${sessionId} td:nth-child(4)`).html(`<span class="badge badge-light-info fs-7">${response.data.end_time}</span>`);
        },
        error: function(xhr) {
            let msg = 'Gagal reschedule sesi.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            showAlert('danger', msg);
        }
    });
});

// Handler submit penilaian materi
$(document).on('submit', '.scoreForm', function(e) {
    e.preventDefault();
    const $form = $(this);
    const studentId = $form.data('student-id');
    const courseId = $form.data('course-id');
    $.ajax({
        url: `/courses/${courseId}/students/${studentId}/grades`,
        type: 'POST',
        data: $form.serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            $form.closest('.modal').modal('hide');
            showAlert('success', 'Penilaian berhasil disimpan.');
            // (Opsional) Update nilai di tabel tanpa reload
            // Misal: $(`#averageScore${studentId}`).text(response.average_score);
        },
        error: function(xhr) {
            let msg = 'Gagal menyimpan penilaian.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            showAlert('danger', msg);
        }
    });
});

// Alert helper
function showAlert(type, message) {
    const alertContainer = $('#alertContainer');
    const alertIcon = $('#alertIcon');
    const alertMessage = $('#alertMessage');
    alertContainer.removeClass('d-none alert-success alert-danger alert-info alert-warning');
    alertContainer.addClass(`alert-${type}`);
    alertMessage.text(message);
    alertIcon.removeClass('bi-check-circle bi-x-circle bi-info-circle bi-exclamation-triangle');
    if (type === 'success') {
        alertIcon.addClass('bi-check-circle text-success');
    } else if (type === 'danger') {
        alertIcon.addClass('bi-x-circle text-danger');
    } else if (type === 'info') {
        alertIcon.addClass('bi-info-circle text-info');
    } else if (type === 'warning') {
        alertIcon.addClass('bi-exclamation-triangle text-warning');
    }
    alertContainer.fadeIn();
    setTimeout(() => {
        alertContainer.fadeOut();
    }, 3000);
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    if (isNaN(date)) return dateStr;
    const options = { day: '2-digit', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

function formatTime(timeStr) {
    if (!timeStr) return '';
    if (timeStr.length > 5) {
        return timeStr.substr(11, 5);
    }
    return timeStr.substr(0, 5);
}

function reloadSessionsTable(courseId) {
    $.get(`/courses/${courseId}/sessions/table`, function(html) {
        $('#sessionsTable').closest('.table-responsive').html(html);

        // Destroy DataTable lama jika ada
        if (window.sessionsTable) {
            window.sessionsTable.destroy();
        }

        // Inisialisasi DataTable baru
        window.sessionsTable = $('#sessionsTable').DataTable({
            language: { emptyTable: "Belum ada sesi." },
            ordering: false,
            searching: false,
            columnDefs: [{ targets: '_all', defaultContent: '' }]
        });

        // Penomoran otomatis kolom #
        window.sessionsTable.on('order.dt search.dt', function () {
            window.sessionsTable.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // Aktifkan tooltip ulang
        if (typeof activateSessionTooltips === 'function') {
            activateSessionTooltips();
        }
    });
}