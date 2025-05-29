<x-default-layout>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white">
                <h3 class="card-title text-center">Create a New Course</h3>
            </div>
            <div class="card-body">
                <!-- Tampilkan Pesan Error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Progress Indicator -->
                <div class="progress mb-4" style="height: 20px;">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 20%;" id="progress-bar">
                        Step 1 of 5
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('courses.store') }}" method="POST" id="course-form">
                    @csrf

                    <!-- Step 1: Basic Info -->
                    <div class="step step-1">
                        <h4 class="mb-3">Basic Information</h4>
                        <div class="row mb-3">
                            
                            <div class="col-md-6">
                                <label for="type" class="form-label">Course Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>Private</option>
                                    <option value="group" {{ old('type') == 'group' ? 'selected' : '' }}>Group</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                            <label for="venue_id" class="form-label">Select Venue</label>
                            <select name="venue_id" id="venue_id" class="form-control" required>
                                <option value="">Select Venue</option>
                                @foreach ($venues as $venue)
                                    <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                        {{ $venue->name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Course Price</label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
                            </div>
                            
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="duration_days" class="form-label">Duration (Days)</label>
                                <input type="number" name="duration_days" id="duration_days" class="form-control" value="{{ old('duration_days') }}" required min="1">
                            </div>
                            <div class="col-md-3">
                                <label for="max_sessions" class="form-label">Max Sessions</label>
                                <input type="number" name="max_sessions" id="max_sessions" class="form-control" value="{{ old('max_sessions') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="valid_until" class="form-label">Valid Until</label>
                                <input type="date" name="valid_until" id="valid_until" class="form-control" value="{{ old('valid_until') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="basic_skills" class="form-label">Basic Skills</label>
                                <textarea name="basic_skills" id="basic_skills" class="form-control" rows="3">{{ old('basic_skills') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Select Students -->
                    <div class="step step-2 d-none">
                        <h4 class="mb-3">Select Students</h4>
                        <div class="mb-3">
                            <label class="form-label">Students</label>
                            <div id="students-container">
                                @foreach ($students as $student)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input student-checkbox" id="student-{{ $student->id }}" name="students[]" value="{{ $student->id }}" {{ in_array($student->id, old('students', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="student-{{ $student->id }}">{{ $student->user->name }} ({{ $student->age_group }})</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Select Materials -->
                    <div class="step step-3 d-none">
                        <h4 class="mb-3">Select Materials</h4>
                        <div class="mb-3">
                            <label class="form-label">Materials</label>
                            <div id="materials-container">
                                @foreach ($materials as $material)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input material-checkbox" id="material-{{ $material->id }}" name="materials[]" value="{{ $material->id }}" {{ in_array($material->id, old('materials', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="material-{{ $material->id }}">{{ $material->name }} ({{ $material->level }})</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Select Trainers -->
                    <div class="step step-4 d-none">
                        <h4 class="mb-3">Select Trainers</h4>
                        <div class="mb-3">
                            <label class="form-label">Trainers</label>
                            <div id="trainers-container">
                                @foreach ($trainers as $trainer)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input trainer-checkbox" id="trainer-{{ $trainer->id }}" name="trainers[]" value="{{ $trainer->id }}" {{ in_array($trainer->id, old('trainers', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trainer-{{ $trainer->id }}">{{ $trainer->user->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Additional Details -->
                    <div class="step step-5 d-none">
                        <h4 class="mb-3">Catatan tambahan</h4>
                        
                        <div class="mb-3">
                            
                            <textarea name="basic_skills" id="basic_skills" class="form-control" rows="4">{{ old('basic_skills') }}</textarea>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary d-none" id="prev-btn">Previous</button>
                        <button type="button" class="btn btn-primary" id="next-btn">Next</button>
                        <button type="submit" class="btn btn-success d-none" id="submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = document.querySelectorAll('.step');
            const progressBar = document.getElementById('progress-bar');
            const nextBtn = document.getElementById('next-btn');
            const prevBtn = document.getElementById('prev-btn');
            const submitBtn = document.getElementById('submit-btn');
            let currentStep = 0;

            function updateStep() {
                steps.forEach((step, index) => {
                    step.classList.toggle('d-none', index !== currentStep);
                });
                progressBar.style.width = `${((currentStep + 1) / steps.length) * 100}%`;
                progressBar.textContent = `Step ${currentStep + 1} of ${steps.length}`;
                prevBtn.classList.toggle('d-none', currentStep === 0);
                nextBtn.classList.toggle('d-none', currentStep === steps.length - 1);
                submitBtn.classList.toggle('d-none', currentStep !== steps.length - 1);
            }

            nextBtn.addEventListener('click', function () {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    updateStep();
                }
            });

            prevBtn.addEventListener('click', function () {
                if (currentStep > 0) {
                    currentStep--;
                    updateStep();
                }
            });

            updateStep();
        });
    </script>
</x-default-layout>