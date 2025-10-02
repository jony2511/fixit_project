@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Details</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $user->name }}</dd>

                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9">{{ $user->email }}</dd>

                    <dt class="col-sm-3">Role:</dt>
                    <dd class="col-sm-9">
                        @if($user->role === 'Admin')
                            <span class="badge badge-danger">Admin</span>
                        @elseif($user->role === 'Technician')
                            <span class="badge badge-info">Technician</span>
                        @else
                            <span class="badge badge-secondary">User</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Member Since:</dt>
                    <dd class="col-sm-9">{{ $user->created_at->format('F d, Y') }}</dd>

                    <dt class="col-sm-3">Total Requests:</dt>
                    <dd class="col-sm-9">{{ $user->serviceRequests->count() }}</dd>
                </dl>

                <hr>

                <h5>Service Requests</h5>
                @if($user->serviceRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->serviceRequests as $request)
                            <tr>
                                <td>
                                    <a href="{{ route('service-requests.show', $request) }}">
                                        {{ Str::limit($request->title, 50) }}
                                    </a>
                                </td>
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
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No service requests yet.</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @if($user->id !== Auth::id())
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this user?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endif
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection