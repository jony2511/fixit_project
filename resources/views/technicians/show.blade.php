@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Technician Details</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $technician->name }}</dd>

                    <dt class="col-sm-3">Skill Area:</dt>
                    <dd class="col-sm-9">{{ $technician->skill_area }}</dd>

                    <dt class="col-sm-3">Availability:</dt>
                    <dd class="col-sm-9">
                        @if($technician->availability === 'Available')
                            <span class="badge badge-success">Available</span>
                        @elseif($technician->availability === 'Busy')
                            <span class="badge badge-warning">Busy</span>
                        @else
                            <span class="badge badge-danger">Unavailable</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Total Jobs:</dt>
                    <dd class="col-sm-9">{{ $technician->workOrders->count() }}</dd>
                </dl>

                <hr>

                <h5>Work History</h5>
                @if($technician->workOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Request</th>
                                <th>Status</th>
                                <th>Assigned</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($technician->workOrders as $workOrder)
                            <tr>
                                <td>
                                    <a href="{{ route('service-requests.show', $workOrder->serviceRequest) }}">
                                        {{ $workOrder->serviceRequest->title }}
                                    </a>
                                </td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No work orders assigned yet.</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('technicians.edit', $technician) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('technicians.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection