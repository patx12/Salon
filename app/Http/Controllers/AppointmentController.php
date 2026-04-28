<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['service', 'payment'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        $appointments = $query->paginate(10)->withQueryString();

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::all();
        return view('appointments.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'nullable|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'notes'            => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $validated['total_price'] = $service->price;
        $validated['status']      = 'pending';

        $appointment = Appointment::create($validated);

        // Auto-create a payment record as unpaid
        Payment::create([
            'appointment_id' => $appointment->id,
            'amount'         => $appointment->total_price,
            'status'         => 'unpaid',
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully!');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['service', 'payment']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::all();
        return view('appointments.edit', compact('appointment', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'nullable|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'notes'            => 'nullable|string',
            'status'           => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $validated['total_price'] = $service->price;

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }
}