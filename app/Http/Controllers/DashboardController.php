<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        // Admin Dashboard
        if ($user->isAdmin()) {
            $stats = [
                'pending' => ServiceRequest::where('status', 'Pending')->count(),
                'in_progress' => ServiceRequest::where('status', 'In Progress')->count(),
                'completed' => ServiceRequest::where('status', 'Completed')->count(),
                'total' => ServiceRequest::count(),
                'technicians' => Technician::count(),
            ];

            $recentRequests = ServiceRequest::with('user')
                ->latest()
                ->limit(10)
                ->get();

            return view('dashboards.admin', compact('stats', 'recentRequests'));
        }

        // Technician Dashboard
        if ($user->isTechnician()) {
            $technician = Technician::where('name', $user->name)->first();
            
            $assignedJobs = [];
            if ($technician) {
                $assignedJobs = WorkOrder::with(['serviceRequest.user', 'technician'])
                    ->where('technician_id', $technician->id)
                    ->whereNull('completion_date')
                    ->get();
            }

            $stats = [
                'assigned' => $assignedJobs->count(),
                'completed_today' => WorkOrder::where('technician_id', $technician?->id)
                    ->whereDate('completion_date', today())
                    ->count(),
            ];

            return view('dashboards.technician', compact('assignedJobs', 'stats', 'technician'));
        }

        // User Dashboard
        $myRequests = ServiceRequest::where('user_id', $user->id)
            ->with('assignedWorkOrder.technician')
            ->latest()
            ->get();

        $stats = [
            'pending' => $myRequests->where('status', 'Pending')->count(),
            'in_progress' => $myRequests->where('status', 'In Progress')->count(),
            'completed' => $myRequests->where('status', 'Completed')->count(),
        ];

        return view('dashboards.user', compact('myRequests', 'stats'));
    }
}
