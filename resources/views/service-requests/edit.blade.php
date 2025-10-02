@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Service Request #{{ $serviceRequest->id }}</h3>
            </div>
            <form action="{{ route('service-requests.update', $serviceRequest) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $serviceRequest->title) }}" required>
                        @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description', $serviceRequest->description) }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select class="form-control @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            <option value="IT" {{ old('category', $serviceRequest->category) === 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="Plumbing" {{ old('category', $serviceRequest->category) === 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                            <option value="Electrical" {{ old('category', $serviceRequest->category) === 'Electrical' ? 'selected' : '' }}>Electrical</option>
                            <option value="Other" {{ old('category', $serviceRequest->category) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    @if(Auth::user()->isAdmin())
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Pending" {{ old('status', $serviceRequest->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ old('status', $serviceRequest->status) === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ old('status', $serviceRequest->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    @endif

                    @if($serviceRequest->attachment)
                    <div class="form-group">
                        <label>Current Attachment:</label>
                        <div>
                            @if($serviceRequest->isImage())
                                <img src="{{ $serviceRequest->attachment_url }}" alt="Current" style="max-width: 200px;">
                            @elseif($serviceRequest->isVideo())
                                <video controls style="max-width: 200px;">
                                    <source src="{{ $serviceRequest->attachment_url }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="attachment">New Attachment (Optional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.mp4">
                            <label class="custom-file-label" for="attachment">Choose file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Leave empty to keep current attachment. Max 10MB.
                        </small>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('service-requests.show', $serviceRequest) }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
