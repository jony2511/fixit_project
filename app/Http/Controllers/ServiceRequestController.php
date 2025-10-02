<?php
// app/Http/Controllers/ServiceRequestController.php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Notifications\ServiceRequestStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of service requests
     */
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['user', 'assignedWorkOrder.technician']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Only show user's own requests if not admin/technician
        if (!Auth::user()->isAdmin() && !Auth::user()->isTechnician()) {
            $query->where('user_id', Auth::id());
        }

        $requests = $query->latest()->paginate(15);

        return view('service-requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new service request
     */
    public function create()
    {
        return view('service-requests.create');
    }

    /**
     * Get AI suggestions for category and quick reply
     */
    public function getSuggestions(Request $request)
    {
        $description = $request->input('description', '');
        
        return response()->json([
            'suggested_category' => ServiceRequest::suggestCategory($description),
            'quick_reply' => ServiceRequest::suggestQuickReply($description),
        ]);
    }

    /**
     * Store a newly created service request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:IT,Plumbing,Electrical,Other',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240', // 10MB max
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Pending';

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/requests', $filename);
            $validated['attachment'] = $filename;
        }

        ServiceRequest::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Service request submitted successfully!');
    }

    /**
     * Display the specified service request
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['user', 'workOrders.technician']);
        
        // Check permission
        if (!Auth::user()->isAdmin() && 
            !Auth::user()->isTechnician() && 
            $serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('service-requests.show', compact('serviceRequest'));
    }

    /**
     * Show the form for editing the service request
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        // Only admin or request owner can edit
        if (!Auth::user()->isAdmin() && $serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('service-requests.edit', compact('serviceRequest'));
    }

    /**
     * Update the specified service request
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        // Only admin or request owner can update
        if (!Auth::user()->isAdmin() && $serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:IT,Plumbing,Electrical,Other',
            'status' => 'nullable|in:Pending,In Progress,Completed',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240',
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($serviceRequest->attachment) {
                Storage::delete('public/requests/' . $serviceRequest->attachment);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/requests', $filename);
            $validated['attachment'] = $filename;
        }

        // Track status change for notification
        $oldStatus = $serviceRequest->status;
        
        $serviceRequest->update($validated);

        // Send notification if status changed
        if (isset($validated['status']) && $oldStatus !== $validated['status']) {
            $serviceRequest->user->notify(new ServiceRequestStatusChanged($serviceRequest));
        }

        return redirect()->route('service-requests.show', $serviceRequest)
            ->with('success', 'Service request updated successfully!');
    }

    /**
     * Remove the specified service request
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        // Only admin can delete
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete attachment file if exists
        if ($serviceRequest->attachment) {
            Storage::delete('public/requests/' . $serviceRequest->attachment);
        }

        $serviceRequest->delete();

        return redirect()->route('service-requests.index')
            ->with('success', 'Service request deleted successfully!');
    }
}
