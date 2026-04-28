@extends('layouts.salon')
@section('title', 'Process Payment')
@section('page-title', 'Process Payment')
@section('content')

<div class="mb-4">
    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-cash-coin me-2"></i>Process Payment for Appointment #{{ $payment->appointment_id }}
            </div>
            <div class="card-body p-4">
                <div class="alert alert-light border mb-4">
                    <div class="fw-semibold">{{ $payment->appointment->customer_name }}</div>
                    <div class="small text-muted">
                        {{ $payment->appointment->service->name }} &bull;
                        {{ $payment->appointment->appointment_date->format('M d, Y g:i A') }}
                    </div>
                    <div class="fs-5 fw-bold text-success mt-1">₱{{ number_format($payment->amount, 2) }}</div>
                </div>

                <form action="{{ route('payments.update', $payment) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-medium">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                            <option value="cash"          {{ old('payment_method', $payment->payment_method) === 'cash'          ? 'selected' : '' }}>Cash</option>
                            <option value="gcash"         {{ old('payment_method', $payment->payment_method) === 'gcash'         ? 'selected' : '' }}>GCash</option>
                            <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="card"          {{ old('payment_method', $payment->payment_method) === 'card'          ? 'selected' : '' }}>Card</option>
                        </select>
                        @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Reference Number</label>
                        <input type="text" name="reference_number" class="form-control"
                               value="{{ old('reference_number', $payment->reference_number) }}"
                               placeholder="GCash ref / transaction ID (optional)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Payment Status <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="paid"
                                       value="paid" {{ old('status', $payment->status) === 'paid' ? 'checked' : '' }}>
                                <label class="form-check-label text-success fw-medium" for="paid">
                                    <i class="bi bi-check-circle me-1"></i> Paid
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="unpaid"
                                       value="unpaid" {{ old('status', $payment->status) === 'unpaid' ? 'checked' : '' }}>
                                <label class="form-check-label text-warning fw-medium" for="unpaid">
                                    <i class="bi bi-clock me-1"></i> Unpaid
                                </label>
                            </div>
                        </div>
                        @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"
                                  placeholder="Any payment notes...">{{ old('notes', $payment->notes) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-salon px-4">
                            <i class="bi bi-check-lg me-1"></i> Save Payment
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection