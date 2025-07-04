document.addEventListener('DOMContentLoaded', function () {
    let selectedCourseId = null;

    // Tooltip Bootstrap 5
    function initTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
            if (el._tooltip) el._tooltip.dispose();
            el._tooltip = new bootstrap.Tooltip(el);
        });
    }

    // Select2 pada Advanced Filter
    function initSelect2() {
        if (window.jQuery && $('#advancedFilterForm select').length) {
            $('#advancedFilterForm select').select2({
                width: '100%',
                dropdownParent: $('#advancedFilterForm').closest('.dropdown-menu')
            });
        }
    }

    // Inisialisasi event pada modal assign materi
    function initMaterialStats() {
        document.querySelectorAll('[id^=assignMaterialsModal-]').forEach(modal => {
            const courseId = modal.id.split('-').pop();
            modal.addEventListener('shown.bs.modal', function () {
                updateMaterialStats(courseId);
            });
            modal.querySelectorAll(`.material-checkbox-${courseId}`).forEach(cb => {
                cb.addEventListener('change', () => updateMaterialStats(courseId));
            });
        });
    }

    function updateMaterialStats(courseId) {
        const checkboxes = document.querySelectorAll(`.material-checkbox-${courseId}`);
        let selected = 0, totalSessions = 0, totalScore = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                selected++;
                totalSessions += parseInt(cb.dataset.estimasi || 0);
                totalScore += parseFloat(cb.dataset.minscore || 0);
            }
        });
        const elSelected = document.getElementById(`selectedCount-${courseId}`);
        const elSessions = document.getElementById(`totalSessions-${courseId}`);
        const elAvg = document.getElementById(`avgMinScore-${courseId}`);
        if (elSelected) elSelected.textContent = selected;
        if (elSessions) elSessions.textContent = totalSessions;
        if (elAvg) elAvg.textContent = selected ? (totalScore / selected).toFixed(2) : 0;
    }

    // Inisialisasi ulang semua fitur interaktif setelah AJAX load
    function reinitAfterAjax() {
        initTooltips();
        initSelect2();
        initMaterialStats();
    }

    // AJAX: Load courses (for filter & pagination)
    function loadCourses(url, pushUrl = null) {
        const courseList = document.getElementById('courseList');
        courseList.innerHTML = '<div class="text-center py-10"><div class="spinner-border"></div></div>';
        fetch(url)
            .then(res => res.text())
            .then(html => {
                courseList.innerHTML = html;
                window.scrollTo({ top: courseList.offsetTop - 80, behavior: 'smooth' });
                reinitAfterAjax();
            });
        if (pushUrl) {
            history.pushState(null, '', pushUrl);
        }
    }

    // Handler klik Pay Now (delegation)
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('btnPayNow')) {
            selectedCourseId = e.target.getAttribute('data-course-id');
            fetch(`/course-payments/invoice/${selectedCourseId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('invoiceCourseModalBody').innerHTML = `
                        <div class="mb-2"><strong>Nama Kursus:</strong> ${data.course_name || '-'}</div>
                        <div class="mb-2"><strong>Periode:</strong> ${data.start_date || '-'} s/d ${data.valid_until || '-'}</div>
                        <div class="mb-2"><strong>Jumlah Sesi:</strong> ${data.max_sessions || '-'}</div>
                        <div class="mb-2"><strong>Status:</strong> <span class="badge ${data.status === 'paid' ? 'badge-light-success' : 'badge-light-warning'}">${data.status}</span></div>
                        <div class="mb-3">
                            <label for="actualPaymentMethod" class="form-label">Payment Method</label>
                            <select id="actualPaymentMethod" class="form-select">
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                        </div>
                    `;
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('invoice-course-modal')).show();
                })
                .catch(() => {
                    Swal.fire({
                        text: "Gagal mengambil data invoice.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                });
        }
    });

    // Handler submit form invoice payment
    document.body.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.id === 'form-invoice-payment') {
            e.preventDefault();
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const actualPaymentMethod = document.getElementById('actualPaymentMethod')?.value;
            if (!actualPaymentMethod) {
                Swal.fire({
                    text: "Pilih metode pembayaran.",
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-warning" }
                });
                return;
            }
            document.getElementById('confirmInvoicePaymentButton').disabled = true;
            fetch(`/course-payments/process/${selectedCourseId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ payment_method: actualPaymentMethod }),
            })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        text: data.message || 'Pembayaran berhasil.',
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: { confirmButton: "btn btn-primary" }
                    });

                    // Update status di card secara dinamis
                    const card = document.querySelector(`.btnPayNow[data-course-id="${selectedCourseId}"]`)?.closest('.card');
                    if (card) {
                        const header = card.querySelector('.card-header .d-flex.align-items-center.justify-content-between.mb-1.w-100');
                        if (header) {
                            const btnPayNow = header.querySelector('.btnPayNow');
                            if (btnPayNow) btnPayNow.remove();

                            let badge = header.querySelector('.badge');
                            if (!badge) {
                                badge = document.createElement('span');
                                badge.className = 'badge fs-8 fw-semibold px-4 py-2';
                                header.appendChild(badge);
                            }
                            badge.className = 'badge badge-light-success fs-8 fw-semibold px-4 py-2';
                            badge.style = "font-size: 0.85rem; line-height: 1; border-radius: 0.475rem; height: 25px; min-width: 70px; display: inline-flex; align-items: center; justify-content: center;";
                            badge.textContent = 'Aktif';
                        }
                    }
                })
                .catch(() => {
                    Swal.fire({
                        text: "Terjadi kesalahan saat proses pembayaran.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                })
                .finally(() => {
                    document.getElementById('confirmInvoicePaymentButton').disabled = false;
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('invoice-course-modal')).hide();
                });
        }
    });

    // Bersihkan modal setelah ditutup
    document.body.addEventListener('hidden.bs.modal', function (e) {
        if (e.target && e.target.id === 'invoice-course-modal') {
            document.getElementById('invoiceCourseModalBody').innerHTML = '';
        }
    });

    // Handler submit assign trainer/materi (AJAX, update card, tidak reload)
    document.body.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.matches('.form-assign-trainer, .form-assign-materials')) {
            e.preventDefault();

            const submitBtn = form.querySelector('[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;

            const formData = new FormData(form);
            const url = form.getAttribute('action');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const modalEl = form.closest('.modal');
            const courseId = modalEl ? modalEl.id.split('-').pop() : null;

            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            })
                .then(response => {
                    if (!response.ok) throw new Error('Gagal menyimpan data');
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        text: data.message || "Berhasil menyimpan data.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                    if (modalEl) bootstrap.Modal.getInstance(modalEl)?.hide();

                    // Update daftar trainer di card
                    if (Array.isArray(data.trainers) && courseId) {
                        const trainersList = document.getElementById(`trainersList-${courseId}`);
                        if (trainersList) {
                            if (data.trainers.length > 0) {
                                trainersList.innerHTML = data.trainers.map(trainer => `
                                    <span class="d-inline-flex align-items-center mb-1 me-1">
                                        <img src="${trainer.photo}" alt="${trainer.name}" class="rounded-circle border border-2 border-white shadow" style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-right: 6px;">
                                        <span class="badge badge-light-success">${trainer.name}</span>
                                    </span>
                                `).join('');
                            } else {
                                trainersList.innerHTML = `
                                    <span class="text-muted"></span>
                                    <button type="button" class="btn btn-sm btn-light-warning ms-2" data-bs-toggle="modal" data-bs-target="#assignTrainerModal-${courseId}">
                                        <i class="bi bi-person-plus"></i> Pilih Pelatih
                                    </button>
                                `;
                            }
                        }
                    }

                    // Update tombol materi di card
                    if (typeof data.materials_count !== 'undefined' && courseId) {
                        const btn = document.getElementById(`assignMaterialsBtn-${courseId}`);
                        if (btn) {
                            btn.innerHTML = `<i class="bi bi-journal-text"></i> ${data.materials_count} Materi`;
                            btn.classList.remove('btn-light-warning');
                            btn.classList.add('btn-light-success');
                        }
                    }

                    setTimeout(initTooltips, 100);
                })
                .catch(() => {
                    Swal.fire({
                        text: "Terjadi kesalahan saat menyimpan.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                })
                .finally(() => {
                    if (submitBtn) submitBtn.disabled = false;
                });
        }
    });

    // Handler filter status dropdown
    document.querySelectorAll('.status-filter-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const ajaxUrl = this.href.replace('/courses', '/courses/ajax');
            loadCourses(ajaxUrl, this.href);
        });
    });

    // Handle pagination (delegation)
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            const urlObj = new URL(link.href, window.location.origin);
            const params = urlObj.search;
            loadCourses('/courses/ajax' + params, '/courses' + params);
        }
    });

    // Handle advanced filter form
    const advForm = document.getElementById('advancedFilterForm');
    if (advForm) {
        advForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const params = new URLSearchParams(new FormData(this)).toString();
            const normalUrl = '/courses?' + params;
            const ajaxUrl = '/courses/ajax?' + params;
            loadCourses(ajaxUrl, normalUrl);
        });
    }

    // Handle browser back/forward
    window.addEventListener('popstate', function () {
        loadCourses('/courses/ajax' + location.search);
    });

    // Handler search course
    const searchInput = document.getElementById('searchCourseInput');
    if (searchInput) {
        let searchTimeout = null;
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const params = new URLSearchParams(window.location.search);
                params.set('search', this.value);
                const normalUrl = '/courses?' + params.toString();
                const ajaxUrl = '/courses/ajax?' + params.toString();
                loadCourses(ajaxUrl, normalUrl);
            }, 400);
        });
    }

    // Inisialisasi awal
    reinitAfterAjax();
});