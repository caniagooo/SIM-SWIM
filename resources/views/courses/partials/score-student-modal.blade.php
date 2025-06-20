<!-- Modal Penilaian -->
<div class="modal fade" id="gradeModal{{ $student->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('grades.store', [$course->id, $student->id]) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian: {{ $student->user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach($course->materials as $material)
                        @php
                            $grade = $student->grades->where('material_id', $material->id)->first();
                        @endphp
                        <div class="mb-3">
                            <label class="form-label">{{ $material->name }}</label>
                            <select name="grades[{{ $material->id }}][score]" class="form-select">
                                <option value="">-</option>
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{ $i }}" @selected(optional($grade)->score == $i)>{{ $i }}</option>
                                @endfor
                            </select>
                            <input type="text" name="grades[{{ $material->id }}][remarks]" class="form-control mt-1" placeholder="Catatan" value="{{ $grade->remarks ?? '' }}">
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>