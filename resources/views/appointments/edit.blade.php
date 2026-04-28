@extends('layouts.salon')
@section('title', 'Edit Appointment')
@section('page-title', 'Edit Appointment')
@section('content')

<div class="mb-4">
    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Appointment #{{ $appointment->id }}</div>
            <div class="card-body p-4">
                <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-medium">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name', $appointment->customer_name) }}">
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-medium">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone"
                                   class="form-control @error('customer_phone') is-invalid @enderror"
                                   value="{{ old('customer_phone', $appointment->customer_phone) }}">
                            @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Email</label>
                        <input type="email" name="customer_email" class="form-control"
                               value="{{ old('customer_email', $appointment->customer_email) }}">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-medium">Service <span class="text-danger">*</span></label>
                            <select name="service_id" class="form-select">
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}"
                                            {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} — ₱{{ number_format($service->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-medium">Status</label>
                            <select name="status" class="form-select">
                                @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $appointment->status) === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="appointment_date" class="form-control"
                               value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-salon px-4">
                            <i class="bi bi-check-lg me-1"></i> Update Appointment
                        </button>
                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection