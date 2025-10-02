@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Work Orders</h1>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Request</th>
                    <th>Technician</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Completed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workOrders as $workOrder)
                <tr>
                    <td>{{ $workOrder->id }}</td>
                    <td>{{ Str::limit($workOrder->serviceRequest->title, 40) }}</td>
                    <td>{{ $workOrder->technician->name }}</td>
                    <td>
                        @if($workOrder->completion_date)
                            <span class="badge badge-success">Completed</span>
                        @else
                            <span class="badge badge-info">In Progress</span>
                        @endif
                    </td>
                    <td>{{ $workOrder->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($workOrder->completion_date)
                            {{ $workOrder->completion_date->format('M d, Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('work-orders.show', $workOrder) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(!$workOrder->completion_date)
                        <a href="{{ route('work-orders.edit', $workOrder) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No work orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $workOrders->links() }}
    </div>
</div>
@endsection