@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Users</h1>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Requests</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'Admin')
                            <span class="badge badge-danger">Admin</span>
                        @elseif($user->role === 'Technician')
                            <span class="badge badge-info">Technician</span>
                        @else
                            <span class="badge badge-secondary">User</span>
                        @endif
                    </td>
                    <td>{{ $user->service_requests_count }}</td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($user->id !== Auth::id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
@endsection
