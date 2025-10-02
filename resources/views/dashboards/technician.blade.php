@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Technician Dashboard</h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-6 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['assigned'] }}</h3>
                <p>Assigned Jobs</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['completed_today'] }}</h3>
                <p>Completed Today</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-double"></i>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Jobs -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Assigned Jobs</h3>
            </div>
            <div class="card-body">
                @forelse($assignedJobs as $workOrder)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $workOrder->serviceRequest->title }}
                            <span class="badge badge-{{ $workOrder->serviceRequest->status === 'In Progress' ? 'info' : 'warning' }} float-right">
                                {{ $workOrder->serviceRequest->status }}
                            </span>
                        </h5>
                        <p class="card-text">
                            <strong>Category:</strong> {{ $workOrder->serviceRequest->category }}<br>
                            <strong>Requested by:</strong> {{ $workOrder->serviceRequest->user->name }}<br>
                            <strong>Description:</strong> {{ Str::limit($workOrder->serviceRequest->description, 100) }}
                        </p>
                        <div class="btn-group">
                            <a href="{{ route('service-requests.show', $workOrder->serviceRequest) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('work-orders.edit', $workOrder) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Update
                            </a>
                            <form action="{{ route('work-orders.complete', $workOrder) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this job as completed?')">
                                    <i class="fas fa-check"></i> Complete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No jobs assigned yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
