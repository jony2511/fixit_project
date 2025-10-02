@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Work Order #{{ $workOrder->id }}</h3>
            </div>
            <form action="{{ route('work-orders.update', $workOrder) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Request:</strong> {{ $workOrder->serviceRequest->title }}<br>
                        <strong>Assigned to:</strong> {{ $workOrder->technician->name }}
                    </div>

                    <div class="form-group">
                        <label for="work_notes">Work Notes</label>
                        <textarea class="form-control @error('work_notes') is-invalid @enderror" 
                                  id="work_notes" name="work_notes" rows="6">{{ old('work_notes', $workOrder->work_notes) }}</textarea>
                        @error('work_notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">
                            Add your progress updates, findings, or notes about the work.
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="mark_complete" name="mark_complete">
                            <label class="form-check-label" for="mark_complete">
                                Mark as Completed
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="completion_date" id="completion_date" value="">
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Work Order
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#mark_complete').on('change', function() {
    if ($(this).is(':checked')) {
        $('#completion_date').val(new Date().toISOString().slice(0, 19).replace('T', ' '));
    } else {
        $('#completion_date').val('');
    }
});
</script>
@endpush