@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Admin Dashboard</h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending'] }}</h3>
                <p>Pending Requests</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Requests</p>
            </div>
            <div class="icon">
                <i class="fas fa-tasks"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Requests -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Service Requests</h3>
                <div class="card-tools">
                    <a href="{{ route('service-requests.index') }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ Str::limit($request->title, 40) }}</td>
                            <td><span class="badge badge-secondary">{{ $request->category }}</span></td>
                            <td>{{ $request->user->name }}</td>
                            <td>
                                @if($request->status === 'Pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($request->status === 'In Progress')
                                    <span class="badge badge-info">In Progress</span>
                                @else
                                    <span class="badge badge-success">Completed</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->diffForHumans() }}</td>
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
