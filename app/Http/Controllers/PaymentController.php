<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['appointment.service'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $payments = $query->paginate(10)->withQueryString();

        $totalPaid   = Payment::where('status', 'paid')->sum('amount');
        $totalUnpaid = Payment::where('status', 'unpaid')->sum('amount');

        return view('payments.index', compact('payments', 'totalPaid', 'totalUnpaid'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['appointment.service']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $payment->load(['appointment.service']);
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_method'   => 'required|in:cash,gcash,bank_transfer,card',
            'status'           => 'required|in:unpaid,paid',
            'reference_number' => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
        ]);

        if ($validated['status'] === 'paid' && $payment->status !== 'paid') {
            $validated['paid_at'] = now();

            // Mark appointment as completed when paid
            $payment->appointment->update(['status' => 'completed']);
        }

        if ($validated['status'] === 'unpaid') {
            $validated['paid_at'] = null;
        }

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    /**
     * Quick mark-as-paid from appointments view.
     */
    public function markPaid(Payment $payment)
    {
        $payment->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        $payment->appointment->update(['status' => 'completed']);

        return back()->with('success', 'Payment marked as paid!');
    }
}
