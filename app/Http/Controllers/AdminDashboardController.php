<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $paidPayments = Payment::where('status', 'paid');

        return view('admin.dashboard', [
            'totalRooms' => Chambre::count(),
            'availableRooms' => Chambre::where('status', 'disponible')->count(),
            'maintenanceRooms' => Chambre::where('status', 'maintenance')->count(),
            'totalReservations' => Reservation::count(),
            'pendingReservations' => Reservation::where('status', 'pending')->count(),
            'confirmedReservations' => Reservation::where('status', 'confirmed')->count(),
            'cancelledReservations' => Reservation::where('status', 'cancelled')->count(),
            'totalRevenue' => (clone $paidPayments)->sum('montant'),
            'stripeRevenue' => (clone $paidPayments)->where('method', 'stripe')->sum('montant'),
            'paypalRevenue' => (clone $paidPayments)->where('method', 'paypal')->sum('montant'),
            'cashRevenue' => (clone $paidPayments)->where('method', 'cash')->sum('montant'),
            'recentReservations' => Reservation::with(['user', 'chambre', 'payment'])
                ->latest('id')
                ->take(6)
                ->get(),
            'roomsByStatus' => Chambre::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
        ]);
    }
}
