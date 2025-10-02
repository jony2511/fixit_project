@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">My Dashboard</h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending'] }}</h3>
                <p>Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['in_progress'] }}</h3>
                <p>In Progress</p>
            </div>
            <div class="icon">
                <i class="fas fa-spinner"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['completed'] }}</h3>
                <p>Completed</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<!-- New Request Button -->
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('service-requests.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Create New Service Request
        </a>
    </div>
</div>

<!-- My Requests -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Service Requests</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ Str::limit($request->title, 40) }}</td>
                            <td><span class="badge badge-secondary">{{ $request->category }}</span></td>
                            <td>
                                @if($request->status === 'Pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($request->status === 'In Progress')
                                    <span class="badge badge-info">In Progress</span>
                                @else
                                    <span class="badge badge-success">Completed</span>
                                @endif
                            </td>
                            <td>
                                @if($request->assignedWorkOrder)
                                    {{ $request->assignedWorkOrder->technician->name }}
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('service-requests.show', $request) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No requests found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
