@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Assign Technician to Request #{{ $serviceRequest->id }}</h3>
            </div>
            <form action="{{ route('work-orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Request:</strong> {{ $serviceRequest->title }}<br>
                        <strong>Category:</strong> {{ $serviceRequest->category }}
                    </div>

                    <div class="form-group">
                        <label for="technician_id">Select Technician <span class="text-danger">*</span></label>
                        <select class="form-control @error('technician_id') is-invalid @enderror" 
                                id="technician_id" name="technician_id" required>
                            <option value="">-- Select Technician --</option>
                            @foreach($technicians as $technician)
                            <option value="{{ $technician->id }}">
                                {{ $technician->name }} - {{ $technician->skill_area }}
                            </option>
                            @endforeach
                        </select>
                        @error('technician_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="work_notes">Initial Notes (Optional)</label>
                        <textarea class="form-control" id="work_notes" name="work_notes" rows="4">{{ old('work_notes') }}</textarea>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Assign Technician
                    </button>
                    <a href="{{ route('service-requests.show', $serviceRequest) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection