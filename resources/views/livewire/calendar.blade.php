<div>
    <div class="border rounded p-3 shadow-sm">
        <h5 class="text-muted mb-3">Calendar</h5>
        <div class="d-flex flex-wrap">
            @foreach (range(1, 31) as $day)
                <div class="border p-2 m-1 text-center" style="width: 100px; cursor: pointer;" wire:click="selectDate('{{ now()->startOfMonth()->addDays($day - 1)->toDateString() }}')">
                    {{ now()->startOfMonth()->addDays($day - 1)->format('d') }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        <h5 class="text-muted">Time Slots</h5>
        
    </div>

    <div class="mt-4">
        <h5 class="text-muted">Summary</h5>
        @if ($summary)
            <p><strong>Course:</strong> {{ $summary['course'] }}</p>
            <p><strong>Students:</strong> {{ $summary['students'] }}</p>
            <p><strong>Trainer(s):</strong> {{ $summary['trainers'] }}</p>
        @else
            <p class="text-muted">Select a date to see the summary.</p>
        @endif
    </div>
</div>
