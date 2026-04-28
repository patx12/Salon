<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_services'      => Service::count(),
            'total_appointments'  => Appointment::count(),
            'pending_appointments'=> Appointment::where('status', 'pending')->count(),
            'total_revenue'       => Payment::where('status', 'paid')->sum('amount'),
            'unpaid_total'        => Payment::where('status', 'unpaid')->sum('amount'),
        ];

        $recentAppointments = Appointment::with(['service', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['appointment.service'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentAppointments', 'recentPayments'));
    }
}
