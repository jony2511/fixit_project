<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\ServiceRequest;
use App\Models\Technician;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of work orders
     */
    public function index()
    {
        $workOrders = WorkOrder::with(['serviceRequest', 'technician'])
            ->latest()
            ->paginate(15);

        return view('work-orders.index', compact('workOrders'));
    }

    /**
     * Show the form for creating a new work order
     */
    public function create()
    {
        $requests = ServiceRequest::where('status', 'Pending')->get();
        $technicians = Technician::all();

        return view('work-orders.create', compact('requests', 'technicians'));
    }

    /**
     * Store a newly created work order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'technician_id' => 'required|exists:technicians,id',
            'assigned_date' => 'required|date',
            'completion_date' => 'nullable|date|after_or_equal:assigned_date',
        ]);

        WorkOrder::create($validated);

        // Update request status
        ServiceRequest::where('id', $validated['service_request_id'])
            ->update(['status' => 'In Progress']);

        return redirect()->route('work-orders.index')
            ->with('success', 'Work order created successfully.');
    }

    /**
     * Display the specified work order
     */
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load(['serviceRequest.user', 'technician']);
        return view('work-orders.show', compact('workOrder'));
    }

    /**
     * Show the form for editing the work order
     */
    public function edit(WorkOrder $workOrder)
    {
        $requests = ServiceRequest::all();
        $technicians = Technician::all();

        return view('work-orders.edit', compact('workOrder', 'requests', 'technicians'));
    }

    /**
     * Update the specified work order
     */
    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'technician_id' => 'required|exists:technicians,id',
            'assigned_date' => 'required|date',
            'completion_date' => 'nullable|date|after_or_equal:assigned_date',
        ]);

        $workOrder->update($validated);

        // If completed, mark request completed
        if ($validated['completion_date']) {
            $workOrder->serviceRequest->update(['status' => 'Completed']);
        }

        return redirect()->route('work-orders.index')
            ->with('success', 'Work order updated successfully.');
    }

    /**
     * Remove the specified work order
     */
    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();
        return redirect()->route('work-orders.index')
            ->with('success', 'Work order deleted successfully.');
    }
}
