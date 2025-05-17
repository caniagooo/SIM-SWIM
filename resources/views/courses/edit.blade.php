<x-default-layout>
    <div class="container">
        <h1 class="mb-4">Add Course</h1>
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf

            <!-- Tipe Kursus -->
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="">Select Course Type</option>
                    <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>Private</option>
                    <option value="group" {{ old('type') == 'group' ? 'selected' : '' }}>Group</option>
                    <option value="organization" {{ old('type') == 'organization' ? 'selected' : '' }}>Organization</option>
                </select>
            </div>

            <!-- Tabel Murid -->
            <div class="mb-3">
                <label class="form-label">Selected Students</label>
                <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#groupStudentModal">
                    Select Students
                </button>
                <table class="table table-bordered" id="students-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="no-students-row">
                            <td colspan="3" class="text-center text-muted">No students selected.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Tabel Materi -->
            <div class="mb-3">
                <label class="form-label">Selected Materials</label>
                <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#materialsModal">
                    Select Materials
                </button>
                <table class="table table-bordered" id="materials-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Material Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="no-materials-row">
                            <td colspan="2" class="text-center text-muted">No materials selected.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Lokasi Latihan -->
            <div class="mb-3">
                <label for="venue_id" class="form-label">Venue</label>
                <select name="venue_id" id="venue_id" class="form-control" required>
                    <option value="">Select Venue</option>
                    @foreach ($venues as $venue)
                        <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                            {{ $venue->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pelatih Utama -->
            <div class="mb-3">
                <label for="trainer_id" class="form-label">Assigned Trainer</label>
                <select name="trainer_id" id="trainer_id" class="form-control" required>
                    <option value="">Select Trainer</option>
                    @foreach ($trainers as $trainer)
                        <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                            {{ $trainer->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jumlah Sesi -->
            <div class="mb-3">
                <label for="sessions" class="form-label">Sessions</label>
                <input type="number" name="sessions" id="sessions" class="form-control" value="{{ old('sessions') }}" required>
            </div>

            <!-- Harga -->
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
            </div>

            <!-- Catatan Kemampuan Dasar -->
            <div class="mb-3">
                <label for="basic_skills" class="form-label">Basic Skills Notes</label>
                <textarea name="basic_skills" id="basic_skills" class="form-control" rows="4" required>{{ old('basic_skills') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- Modal Box untuk Group -->
    <div class="modal fade" id="groupStudentModal" tabindex="-1" aria-labelledby="groupStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="groupStudentModalLabel">Select Students</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="student-list">
                        @foreach ($students as $student)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input student-checkbox" id="student-{{ $student->id }}" value="{{ $student->id }}">
                                <label class="form-check-label" for="student-{{ $student->id }}">
                                    {{ $student->user->name }} ({{ $student->age }} tahun)
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-students-btn" data-bs-dismiss="modal">Save Selection</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Box untuk Materials -->
    <div class="modal fade" id="materialsModal" tabindex="-1" aria-labelledby="materialsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materialsModalLabel">Select Materials</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="materials-list">
                        @foreach ($materials as $material)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input material-checkbox" id="material-{{ $material->id }}" value="{{ $material->id }}">
                                <label class="form-check-label" for="material-{{ $material->id }}">
                                    {{ $material->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-materials-btn" data-bs-dismiss="modal">Save Selection</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentsTable = document.getElementById('students-table').querySelector('tbody');
            const materialsTable = document.getElementById('materials-table').querySelector('tbody');
            const saveStudentsBtn = document.getElementById('save-students-btn');
            const saveMaterialsBtn = document.getElementById('save-materials-btn');

            // Save selected students
            saveStudentsBtn.addEventListener('click', function () {
                const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
                studentsTable.innerHTML = '';

                if (selectedCheckboxes.length === 0) {
                    studentsTable.innerHTML = '<tr id="no-students-row"><td colspan="3" class="text-center text-muted">No students selected.</td></tr>';
                } else {
                    selectedCheckboxes.forEach((checkbox, index) => {
                        const label = checkbox.nextElementSibling.textContent.trim();
                        const age = label.match(/\((\d+) tahun\)/)?.[1] || '-';
                        studentsTable.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${label.split(' (')[0]}</td>
                                <td>${age}</td>
                            </tr>
                        `;
                    });
                }
            });

            // Save selected materials
            saveMaterialsBtn.addEventListener('click', function () {
                const selectedCheckboxes = document.querySelectorAll('.material-checkbox:checked');
                materialsTable.innerHTML = '';

                if (selectedCheckboxes.length === 0) {
                    materialsTable.innerHTML = '<tr id="no-materials-row"><td colspan="2" class="text-center text-muted">No materials selected.</td></tr>';
                } else {
                    selectedCheckboxes.forEach((checkbox, index) => {
                        const label = checkbox.nextElementSibling.textContent.trim();
                        materialsTable.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${label}</td>
                            </tr>
                        `;
                    });
                }
            });
        });
    </script>
</x-default-layout>