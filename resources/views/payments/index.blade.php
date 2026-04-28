@extends('layouts.salon')
@section('title', 'Payments')
@section('page-title', 'Payment Management')
@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-0">Payments</h4>
    <p class="text-muted small mb-0">Track and manage all payment transactions.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#26a69a,#00695c);">
            <div class="stat-label">Total Revenue (Paid)</div>
            <div class="stat-value">₱{{ number_format($totalPaid, 2) }}</div>
            <i class="bi bi-cash-stack icon"></i>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#ef5350,#b71c1c);">
            <div class="stat-label">Outstanding (Unpaid)</div>
            <div class="stat-value">₱{{ number_format($totalUnpaid, 2) }}</div>
            <i class="bi bi-clock icon"></i>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-sm-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="paid"   {{ request('status')==='paid'   ? 'selected':'' }}>Paid</option>
                    <option value="unpaid" {{ request('status')==='unpaid' ? 'selected':'' }}>Unpaid</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select name="method" class="form-select form-select-sm">
                    <option value="">All Methods</option>
                    <option value="cash"          {{ request('method')==='cash'          ? 'selected':'' }}>Cash</option>
                    <option value="gcash"         {{ request('method')==='gcash'         ? 'selected':'' }}>GCash</option>
                    <option value="bank_transfer" {{ request('method')==='bank_transfer' ? 'selected':'' }}>Bank Transfer</option>
                    <option value="card"          {{ request('method')==='card'          ? 'selected':'' }}>Card</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-salon">Filter</button>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
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
                        <th>#</th><th>Customer</th><th>Service</th><th>Amount</th><th>Method</th><th>Paid At</th><th>Status</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $pay)
                    <tr>
                        <td class="text-muted small">{{ $pay->id }}</td>
                        <td>
                            <div class="fw-medium">{{ $pay->appointment->customer_name }}</div>
                            <div class="text-muted small">{{ $pay->appointment->customer_phone }}</div>
                        </td>
                        <td class="small">{{ $pay->appointment->service->name }}</td>
                        <td class="fw-semibold">₱{{ number_format($pay->amount, 2) }}</td>
                        <td class="small">{{ $pay->method_label }}</td>
                        <td class="small">{{ $pay->paid_at ? $pay->paid_at->format('M d, Y') : '—' }}</td>
                        <td>
                            <span class="badge bg-{{ $pay->status === 'paid' ? 'success' : 'warning text-dark' }}">
                                {{ ucfirst($pay->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('payments.show', $pay) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('payments.edit', $pay) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                @if($pay->status !== 'paid')
                                <form action="{{ route('payments.mark-paid', $pay) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" title="Mark Paid"><i class="bi bi-check2"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-cash-coin fs-2 d-block mb-2"></i>No payment records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
    <div class="card-footer bg-white">{{ $payments->links() }}</div>
    @endif
</div>
@endsection