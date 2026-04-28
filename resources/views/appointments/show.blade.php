@extends('layouts.salon')
@section('title', 'Appointment #' . $appointment->id)
@section('page-title', 'Appointment Details')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-salon">
        <i class="bi bi-pencil me-1"></i> Edit
    </a>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-event me-2"></i>Booking Information
                <span class="badge bg-{{ $appointment->status_badge }} ms-2">{{ ucfirst($appointment->status) }}</span>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Customer</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $appointment->customer_name }}</dd>
                    <dt class="col-sm-4 text-muted">Phone</dt>
                    <dd class="col-sm-8">{{ $appointment->customer_phone }}</dd>
                    <dt class="col-sm-4 text-muted">Email</dt>
                    <dd class="col-sm-8">{{ $appointment->customer_email ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Service</dt>
                    <dd class="col-sm-8">{{ $appointment->service->name }}</dd>
                    <dt class="col-sm-4 text-muted">Date & Time</dt>
                    <dd class="col-sm-8">{{ $appointment->appointment_date->format('F d, Y g:i A') }}</dd>
                    <dt class="col-sm-4 text-muted">Duration</dt>
                    <dd class="col-sm-8">{{ $appointment->service->duration }} mins</dd>
                    <dt class="col-sm-4 text-muted">Total Price</dt>
                    <dd class="col-sm-8 fw-bold text-success fs-5">₱{{ number_format($appointment->total_price, 2) }}</dd>
                    @if($appointment->notes)
                    <dt class="col-sm-4 text-muted">Notes</dt>
                    <dd class="col-sm-8">{{ $appointment->notes }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-cash me-2"></i>Payment Status</div>
            <div class="card-body">
                @if($appointment->payment)
                    @php $pay = $appointment->payment; @endphp
                    <div class="text-center mb-3">
                        @if($pay->status === 'paid')
                            <div class="display-6 text-success"><i class="bi bi-check-circle-fill"></i></div>
                            <div class="fw-bold text-success fs-5">PAID</div>
                            <div class="text-muted small">{{ $pay->paid_at?->format('M d, Y g:i A') }}</div>
                        @else
                            <div class="display-6 text-warning"><i class="bi bi-clock-fill"></i></div>
                            <div class="fw-bold text-warning fs-5">UNPAID</div>
                        @endif
                        <div class="fs-4 fw-bold mt-2">₱{{ number_format($pay->amount, 2) }}</div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('payments.edit', $pay) }}" class="btn btn-salon btn-sm">
                            <i class="bi bi-pencil me-1"></i> Process Payment
                        </a>
                        @if($pay->status !== 'paid')
                        <form action="{{ route('payments.mark-paid', $pay) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm w-100">
                                <i class="bi bi-check2 me-1"></i> Quick Mark as Paid
                            </button>
                        </form>
                        @endif
                    </div>
                @else
                    <p class="text-muted small">No payment record found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection