@extends('layouts.salon')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-0">Welcome back, {{ auth()->user()->name }}!</h4>
    <p class="text-muted small">Here's what's happening at LuxeNails today.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#f06292,#e91e8c);">
            <div class="stat-label">Total Services</div>
            <div class="stat-value">{{ $stats['total_services'] }}</div>
            <i class="bi bi-stars icon"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#7c4dff,#651fff);">
            <div class="stat-label">Total Appointments</div>
            <div class="stat-value">{{ $stats['total_appointments'] }}</div>
            <i class="bi bi-calendar-check icon"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#ff9800,#ef6c00);">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $stats['pending_appointments'] }}</div>
            <i class="bi bi-clock icon"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#26a69a,#00695c);">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱{{ number_format($stats['total_revenue'], 2) }}</div>
            <i class="bi bi-cash icon"></i>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check me-2"></i>Recent Appointments</span>
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-salon">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Customer</th><th>Service</th><th>Date</th><th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appt)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $appt->customer_name }}</div>
                                    <div class="text-muted small">{{ $appt->customer_phone }}</div>
                                </td>
                                <td>{{ $appt->service->name }}</td>
                                <td class="small">{{ $appt->appointment_date->format('M d, Y g:i A') }}</td>
                                <td><span class="badge bg-{{ $appt->status_badge }}">{{ ucfirst($appt->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No appointments yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-cash-stack me-2"></i>Recent Payments</span>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-salon">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Customer</th><th>Amount</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $pay)
                            <tr>
                                <td class="small">{{ $pay->appointment->customer_name }}</td>
                                <td class="fw-semibold">₱{{ number_format($pay->amount, 2) }}</td>
                                <td><span class="badge bg-{{ $pay->status === 'paid' ? 'success' : 'warning text-dark' }}">{{ ucfirst($pay->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">No payments yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection