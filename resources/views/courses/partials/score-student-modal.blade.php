<!-- Modal Penilaian Modern Metronic -->
<div class="modal fade" id="scoreStudentModal-{{ $student->id }}" tabindex="-1" aria-labelledby="scoreStudentModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <form method="POST"
            action="{{ route('grades.store', [$course->id, $student->id]) }}"
            class="scoreForm w-100"
            data-student-id="{{ $student->id }}"
            data-course-id="{{ $course->id }}">
            @csrf
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header bg-primary px-8 py-5 rounded-top-4 d-flex align-items-center">
                    <div class="symbol symbol-60px me-4">
                        <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
                             alt="Avatar" class="symbol-label rounded-circle border border-3 border-white" width="56" height="56">
                    </div>
                    <div>
                        <div class="fw-bold fs-3 text-white">{{ $student->user->name }}</div>
                        <div class="fs-7 text-white">Usia: 
                            @php
                                $birth = $student->birth_date ?? null;
                                $age = $birth ? \Carbon\Carbon::parse($birth)->age : '-';
                            @endphp
                            {{ $age }}
                            tahun
                        </div>
                    </div>
                    <button type="button" class="btn btn-icon btn-active-light-primary ms-auto" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="bi bi-x-lg text-white"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body px-8 py-6 bg-light rounded-bottom-4">
                    <div class="scoreForm" data-student-id="{{ $student->id }}" data-course-id="{{ $course->id }}">
                        @foreach($course->materials as $material)
                            <div class="mb-4">
                                <label class="fw-semibold mb-2">{{ $material->name }}</label>
                                <div class="btn-group w-100 mb-2" role="group" aria-label="Score buttons">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio"
                                               class="btn-check"
                                               name="grades[{{ $material->id }}][score]"
                                               id="score-{{ $material->id }}-{{ $i }}"
                                               value="{{ $i }}"
                                               autocomplete="off"
                                               {{ old('grades.'.$material->id.'.score', $student->gradeFor($material->id)) == $i ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary px-3 py-2 {{ old('grades.'.$material->id.'.score', $student->gradeFor($material->id)) == $i ? 'active' : '' }}"
                                               for="score-{{ $material->id }}-{{ $i }}">{{ $i }}</label>
                                    @endfor
                                </div>
                                <input type="text"
                                       name="grades[{{ $material->id }}][remarks]"
                                       class="form-control form-control-sm"
                                       placeholder="Catatan (opsional)"
                                       value="{{ old('grades.'.$material->id.'.remarks', $student->remarksFor($material->id)) }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer py-4 px-8 border-0 d-flex justify-content-end bg-white rounded-bottom-4">
                    <button type="submit" class="btn btn-primary btn-sm px-8 py-2 rounded-pill">
                        <i class="bi bi-save me-2"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
