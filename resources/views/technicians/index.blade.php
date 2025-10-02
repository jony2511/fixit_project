@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Technicians</h1>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('technicians.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Technician
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
                    <th>Skill Area</th>
                    <th>Availability</th>
                    <th>Active Jobs</th>
                    <th>Total Jobs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($technicians as $technician)
                <tr>
                    <td>{{ $technician->id }}</td>
                    <td>{{ $technician->name }}</td>
                    <td>{{ $technician->skill_area }}</td>
                    <td>
                        @if($technician->availability === 'Available')
                            <span class="badge badge-success">Available</span>
                        @elseif($technician->availability === 'Busy')
                            <span class="badge badge-warning">Busy</span>
                        @else
                            <span class="badge badge-danger">Unavailable</span>
                        @endif
                    </td>
                    <td>{{ $technician->active_work_orders_count }}</td>
                    <td>{{ $technician->work_orders_count }}</td>
                    <td>
                        <a href="{{ route('technicians.show', $technician) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('technicians.edit', $technician) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('technicians.destroy', $technician) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this technician?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No technicians found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $technicians->links() }}
    </div>
</div>
@endsection