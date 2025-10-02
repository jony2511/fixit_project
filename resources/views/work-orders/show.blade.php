@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Work Order #{{ $workOrder->id }}</h3>
                <div class="card-tools">
                    @if($workOrder->completion_date)
                        <span class="badge badge-success">Completed</span>
                    @else
                        <span class="badge badge-info">In Progress</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <h5>Service Request Details</h5>
                <dl class="row">
                    <dt class="col-sm-4">Request ID:</dt>
                    <dd class="col-sm-8">
                        <a href="{{ route('service-requests.show', $workOrder->serviceRequest) }}">
                            #{{ $workOrder->serviceRequest->id }}
                        </a>
                    </dd>

                    <dt class="col-sm-4">Title:</dt>
                    <dd class="col-sm-8">{{ $workOrder->serviceRequest->title }}</dd>

                    <dt class="col-sm-4">Category:</dt>
                    <dd class="col-sm-8">
                        <span class="badge badge-secondary">{{ $workOrder->serviceRequest->category }}</span>
                    </dd>

                    <dt class="col-sm-4">Requested by:</dt>
                    <dd class="col-sm-8">{{ $workOrder->serviceRequest->user->name }}</dd>
                </dl>

                <hr>

                <h5>Work Order Details</h5>
                <dl class="row">
                    <dt class="col-sm-4">Assigned Technician:</dt>
                    <dd class="col-sm-8">{{ $workOrder->technician->name }}</dd>

                    <dt class="col-sm-4">Work Notes:</dt>
                    <dd class="col-sm-8">{{ $workOrder->work_notes ?: 'No notes yet' }}</dd>

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $workOrder->created_at->format('F d, Y h:i A') }}</dd>

                    @if($workOrder->completion_date)
                    <dt class="col-sm-4">Completed:</dt>
                    <dd class="col-sm-8">{{ $workOrder->completion_date->format('F d, Y h:i A') }}</dd>
                    @endif
                </dl>
            </div>
            <div class="card-footer">
                @if(!$workOrder->completion_date)
                <a href="{{ route('work-orders.edit', $workOrder) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Update
                </a>
                <form action="{{ route('work-orders.complete', $workOrder) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Mark as completed?')">
                        <i class="fas fa-check"></i> Mark Completed
                    </button>
                </form>
                @endif
                
                <a href="{{ route('work-orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection