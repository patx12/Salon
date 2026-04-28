@extends('layouts.app')
@section('title', 'Appointments')
@section('page-title', 'Appointment Management')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Appointments</h4>
        <p class="text-muted small mb-0">Manage all bookings and appointments.</p>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn btn-salon">
        <i class="bi bi-plus-lg me-1"></i> New Booking
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-sm-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search name or phone..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-sm-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="pending"   {{ request('status')==='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ request('status')==='confirmed' ? 'selected':'' }}>Confirmed</option>
                    <option value="completed" {{ request('status')==='completed' ? 'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-salon">Filter</button>
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date & Time</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td class="text-muted small">{{ $appt->id }}</td>
                        <td>
                            <div class="fw-medium">{{ $appt->customer_name }}</div>
                            <div class="text-muted small">{{ $appt->customer_phone }}</div>
                        </td>
                        <td>{{ $appt->service->name }}</td>
                        <td class="small">
                            <div>{{ $appt->appointment_date->format('M d, Y') }}</div>
                            <div class="text-muted">{{ $appt->appointment_date->format('g:i A') }}</div>
                        </td>
                        <td class="fw-semibold">₱{{ number_format($appt->total_price, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $appt->status_badge }}">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td>
                            @if($appt->payment)
                                @if($appt->payment->status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <form action="{{ route('payments.mark-paid', $appt->payment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success py-0 px-2" style="font-size:.75rem;">
                                            <i class="bi bi-check2"></i> Mark Paid
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('appointments.show', $appt) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('appointments.edit', $appt) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('appointments.destroy', $appt) }}" method="POST"
                                      onsubmit="return confirm('Delete this appointment?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                            No appointments yet. <a href="{{ route('appointments.create') }}">Create one!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
    <div class="card-footer bg-white">{{ $appointments->links() }}</div>
    @endif
</div>
@endsection