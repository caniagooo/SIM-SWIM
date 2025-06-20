<!-- Assign Materials Modal -->
<div class="modal fade" id="assignMaterialsModal-{{ $course->id }}" tabindex="-1" aria-labelledby="assignMaterialsModalLabel-{{ $course->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('courses.assign', $course->id) }}" method="POST" class="form-assign-materials">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignMaterialsModalLabel-{{ $course->id }}">Pilih Materi Kursus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-4">
                        <div class="fs-6">
                            <div class="fw-bold">Catatan terkait murid:</div>
                        </div>
                        <i class="fs-6">{{ $course->basic_skills ?: '-' }}</i>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Pilih Materi:</strong></label>
                        <div class="accordion accordion-icon-toggle" id="materialsAccordion-{{ $course->id }}">
                            @php
                                $groupedMaterials = $allMaterials->groupBy('level');
                                $selectedMaterialIds = $course->materials->pluck('id')->toArray();
                            @endphp
                            @foreach ($groupedMaterials as $level => $materials)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $course->id }}-{{ $level }}">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $course->id }}-{{ $level }}"
                                            aria-expanded="false"
                                            aria-controls="collapse-{{ $course->id }}-{{ $level }}">
                                            <span class="fw-bold">Level {{ $level }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $course->id }}-{{ $level }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="heading-{{ $course->id }}-{{ $level }}"
                                        data-bs-parent="#materialsAccordion-{{ $course->id }}">
                                        <div class="accordion-body p-0">
                                            <div class="list-group list-group-flush">
                                                @forelse ($materials as $material)
                                                    <label class="list-group-item d-flex align-items-center py-3 px-3" style="border-bottom: 1px solid #f1f1f1;">
                                                        <input 
                                                            type="checkbox" 
                                                            name="materials[]" 
                                                            value="{{ $material->id }}" 
                                                            class="form-check-input material-checkbox-{{ $course->id }} me-3 ms-1"
                                                            style="margin-left: 0.5rem; margin-right: 1rem;"
                                                            data-estimasi="{{ $material->estimated_sessions }}"
                                                            data-minscore="{{ $material->minimum_score }}"
                                                            {{ in_array($material->id, $selectedMaterialIds) ? 'checked' : '' }}
                                                        >
                                                        <div class="flex-grow-1">
                                                            <div class="fw-semibold fs-6 mb-1">{{ $material->name }}</div>
                                                            <div class="d-flex flex-wrap gap-3 small text-muted">
                                                                <span><i class="bi bi-clock me-1"></i> Estimasi: <span class="fw-bold">{{ $material->estimated_sessions }}</span> sesi</span>
                                                                <span><i class="bi bi-star me-1"></i> Min. Skor: <span class="fw-bold">{{ $material->minimum_score }}</span></span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                @empty
                                                    <div class="text-muted px-3 py-2">Tidak ada materi pada level ini.</div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="border-top pt-3 mt-3">
                        <div class="row text-center">
                            <div class="col">
                                <div class="fw-bold fs-6">Materi Terpilih</div>
                                <div id="selectedCount-{{ $course->id }}"></div>
                            </div>
                            <div class="col">
                                <div class="fw-bold fs-6">Total Estimasi Sesi</div>
                                <div id="totalSessions-{{ $course->id }}"></div>
                            </div>
                            <div class="col">
                                <div class="fw-bold fs-6">Rata-rata Min. Skor</div>
                                <div id="avgMinScore-{{ $course->id }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>