<script>
    window.COURSE_ID = <?php echo json_encode($course->id, 15, 512) ?>;
</script>
<!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">Tambah Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addScheduleForm">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="session_date" class="form-label">Tanggal Sesi</label>
                            <input type="date" class="form-control" id="session_date" name="session_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    </form>
                </div>
            </div>
        </div>
    </div><?php /**PATH C:\Users\JITU\swim\resources\views\courses\partials\add-schedule-modal.blade.php ENDPATH**/ ?>