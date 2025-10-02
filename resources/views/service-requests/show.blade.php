@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Service Request #{{ $serviceRequest->id }}</h3>
                <div class="card-tools">
                    @if($serviceRequest->status === 'Pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($serviceRequest->status === 'In Progress')
                        <span class="badge badge-info">In Progress</span>
                    @else
                        <span class="badge badge-success">Completed</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Title:</dt>
                    <dd class="col-sm-9">{{ $serviceRequest->title }}</dd>

                    <dt class="col-sm-3">Description:</dt>
                    <dd class="col-sm-9">{{ $serviceRequest->description }}</dd>

                    <dt class="col-sm-3">Category:</dt>
                    <dd class="col-sm-9">
                        <span class="badge badge-secondary">{{ $serviceRequest->category }}</span>
                    </dd>

                    <dt class="col-sm-3">Requested by:</dt>
                    <dd class="col-sm-9">{{ $serviceRequest->user->name }}</dd>

                    <dt class="col-sm-3">Created:</dt>
                    <dd class="col-sm-9">{{ $serviceRequest->created_at->format('F d, Y h:i A') }}</dd>

                    @if($serviceRequest->attachment)
                    <dt class="col-sm-3">Attachment:</dt>
                    <dd class="col-sm-9">
                        @if($serviceRequest->isImage())
                            <img src="{{ $serviceRequest->attachment_url }}" alt="Attachment" class="img-fluid" style="max-width: 500px;">
                        @elseif($serviceRequest->isVideo())
                            <video controls style="max-width: 500px;" class="w-100">
                                <source src="{{ $serviceRequest->attachment_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </dd>
                    @endif
                </dl>

                <!-- Work Orders -->
                @if($serviceRequest->workOrders->count() > 0)
                <hr>
                <h5>Work Orders</h5>
                @foreach($serviceRequest->workOrders as $workOrder)
                <div class="card mb-2">
                    <div class="card-body">
                        <p><strong>Assigned to:</strong> {{ $workOrder->technician->name }}</p>
                        @if($workOrder->work_notes)
                        <p><strong>Notes:</strong> {{ $workOrder->work_notes }}</p>
                        @endif
                        @if($workOrder->completion_date)
                        <p><strong>Completed:</strong> {{ $workOrder->completion_date->format('F d, Y h:i A') }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div class="card-footer">
                @if(Auth::user()->isAdmin() || $serviceRequest->user_id === Auth::id())
                <a href="{{ route('service-requests.edit', $serviceRequest) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endif

                @if(Auth::user()->isAdmin() && $serviceRequest->status === 'Pending')
                <a href="{{ route('work-orders.create', ['service_request_id' => $serviceRequest->id]) }}" 
                   class="btn btn-info">
                    <i class="fas fa-user-plus"></i> Assign Technician
                </a>
                @endif

                @if(Auth::user()->isAdmin())
                <form action="{{ route('service-requests.destroy', $serviceRequest) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this request?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endif

                <a href="{{ route('service-requests.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection