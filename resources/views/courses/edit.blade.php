<x-default-layout>
    <div class="container">
        <h1 class="mb-4">Add Course</h1>
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>Private</option>
                    <option value="group" {{ old('type') == 'group' ? 'selected' : '' }}>Group</option>
                    <option value="organization" {{ old('type') == 'organization' ? 'selected' : '' }}>Organization</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sessions" class="form-label">Sessions</label>
                <input type="number" name="sessions" id="sessions" class="form-control" value="{{ old('sessions') }}" required>
            </div>
            <div class="mb-3">
                <label for="venue_id" class="form-label">Venue</label>
                <select name="venue_id" id="venue_id" class="form-control">
                    <option value="">Select Venue</option>
                    @foreach ($venues as $venue)
                        <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                            {{ $venue->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select id="level" class="form-control">
                    <option value="">Select Level</option>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                </select>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="select-materials-btn" data-bs-toggle="modal" data-bs-target="#materialsModal" disabled>
                    Select Materials
                </button>
            </div>
            <div id="selected-materials">
                <!-- Hidden inputs for selected materials -->
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- Modal Box -->
    <div class="modal fade" id="materialsModal" tabindex="-1" aria-labelledby="materialsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="materialsModalLabel">
                        Select Materials for <span id="selected-level" class="fw-bold">[Level]</span>
                    </h5>
                    <button type="button" class="btn btn-icon btn-sm btn-light btn-active-light-primary" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x fs-2"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div id="materials-list" class="d-flex flex-column gap-3">
                        <!-- Materials will be loaded here dynamically -->
                        <p class="text-muted">Please select a level to view materials.</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-materials-btn" data-bs-dismiss="modal">
                        <i class="bi bi-check-circle"></i> Save Selection
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const levelSelect = document.getElementById('level');
        const selectMaterialsBtn = document.getElementById('select-materials-btn');
        const materialsList = document.getElementById('materials-list');
        const selectedMaterialsContainer = document.getElementById('selected-materials');
        const saveMaterialsBtn = document.getElementById('save-materials-btn');
        const selectedLevelDisplay = document.getElementById('selected-level'); // Elemen untuk menampilkan level yang dipilih

        let selectedMaterials = [];

        // Enable the "Select Materials" button when a level is selected
        levelSelect.addEventListener('change', function () {
            if (levelSelect.value) {
                selectMaterialsBtn.disabled = false;
                selectedLevelDisplay.textContent = levelSelect.value; // Perbarui level yang dipilih di modal
                loadMaterials(levelSelect.value);
            } else {
                selectMaterialsBtn.disabled = true;
                selectedLevelDisplay.textContent = '[Level]'; // Reset level di modal
                materialsList.innerHTML = '<p class="text-muted">Please select a level to view materials.</p>';
            }
        });

        // Load materials based on the selected level
        function loadMaterials(level) {
            fetch(`/api/materials?level=${level}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Materials:', data); // Debugging
                    if (data.length > 0) {
                        materialsList.innerHTML = data.map(material => `
                            <div>
                                <input type="checkbox" id="material-${material.id}" value="${material.id}" class="form-check-input" ${selectedMaterials.includes(material.id) ? 'checked' : ''}>
                                <label for="material-${material.id}" class="form-check-label">${material.name} (Sessions: ${material.estimated_sessions}, Min Score: ${material.minimum_score})</label>
                            </div>
                        `).join('');
                    } else {
                        materialsList.innerHTML = '<p class="text-muted">No materials available for this level.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching materials:', error); // Debugging
                });
        }

        // Save selected materials when the modal is closed
        saveMaterialsBtn.addEventListener('click', function () {
            selectedMaterials = Array.from(materialsList.querySelectorAll('input[type="checkbox"]:checked')).map(input => input.value);

            // Update hidden inputs for selected materials
            selectedMaterialsContainer.innerHTML = selectedMaterials.map(id => `
                <input type="hidden" name="materials[]" value="${id}">
            `).join('');
        });
    });
</script>