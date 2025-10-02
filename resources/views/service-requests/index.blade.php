@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Service Requests</h1>
    </div>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('service-requests.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ request('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <option value="IT" {{ request('category') === 'IT' ? 'selected' : '' }}>IT</option>
                        <option value="Plumbing" {{ request('category') === 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                        <option value="Electrical" {{ request('category') === 'Electrical' ? 'selected' : '' }}>Electrical</option>
                        <option value="Other" {{ request('category') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('service-requests.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Requests Table -->
<div class="card">
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
                @forelse($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ Str::limit($request->title, 50) }}</td>
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
                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('service-requests.show', $request) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(Auth::user()->isAdmin() || $request->user_id === Auth::id())
                        <a href="{{ route('service-requests.edit', $request) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
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
    <div class="card-footer">
        {{ $requests->links() }}
    </div>
</div>
@endsection
