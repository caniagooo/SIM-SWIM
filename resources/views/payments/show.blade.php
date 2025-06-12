<x-default-layout>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Invoice #{{ $payment->invoice_number }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Course:</strong> {{ $payment->course->name }}</p>
                <p><strong>Amount:</strong> Rp. {{ number_format($payment->amount) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method ?? 'N/A') }}</p>
            </div>
        </div>
    </div>
</x-default-layout>