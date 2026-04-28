@extends('layouts.salon')

@section('title', 'Payment #' . $payment->id)
@section('page-title', 'Payment Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-salon">
        <i class="bi bi-pencil me-1"></i> Update Payment
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-receipt"></i> Payment Receipt
                <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : 'warning text-dark' }} ms-auto">
                    {{ strtoupper($payment->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="text-center py-3 mb-4" style="background:#f8f5f7;border-radius:10px;">
                    @if($payment->status === 'paid')
                        <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    @else
                        <i class="bi bi-hourglass-split text-warning fs-1"></i>
                    @endif
                    <div class="fs-2 fw-bold mt-2">₱{{ number_format($payment->amount, 2) }}</div>
                    @if($payment->paid_at)
                        <div class="text-muted small">Paid on {{ $payment->paid_at->format('F d, Y g:i A') }}</div>
                    @endif
                </div>

                <dl class="row">
                    <dt class="col-sm-5 text-muted">Customer</dt>
                    <dd class="col-sm-7 fw-semibold">{{ $payment->appointment->customer_name }}</dd>

                    <dt class="col-sm-5 text-muted">Phone</dt>
                    <dd class="col-sm-7">{{ $payment->appointment->customer_phone }}</dd>

                    <dt class="col-sm-5 text-muted">Service</dt>
                    <dd class="col-sm-7">{{ $payment->appointment->service->name }}</dd>

                    <dt class="col-sm-5 text-muted">Appointment Date</dt>
                    <dd class="col-sm-7">{{ $payment->appointment->appointment_date->format('M d, Y g:i A') }}</dd>

                    <dt class="col-sm-5 text-muted">Payment Method</dt>
                    <dd class="col-sm-7">{{ $payment->method_label }}</dd>

                    @if($payment->reference_number)
                    <dt class="col-sm-5 text-muted">Reference #</dt>
                    <dd class="col-sm-7">{{ $payment->reference_number }}</dd>
                    @endif

                    @if($payment->notes)
                    <dt class="col-sm-5 text-muted">Notes</dt>
                    <dd class="col-sm-7">{{ $payment->notes }}</dd>
                    @endif
                </dl>

                @if($payment->status !== 'paid')
                <div class="mt-3">
                    <form action="{{ route('payments.mark-paid', $payment) }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100">
                            <i class="bi bi-check2-circle me-2"></i>Mark as Paid
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection