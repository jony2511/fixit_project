@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Create New Service Request</h3>
            </div>
            <form action="{{ route('service-requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        
                        <!-- AI Quick Reply Suggestion -->
                        <div id="ai-suggestion" class="alert alert-info mt-2" style="display: none;">
                            <strong><i class="fas fa-lightbulb"></i> Quick Tip:</strong>
                            <p id="suggestion-text"></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select class="form-control @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            <option value="">-- Select Category --</option>
                            <option value="IT" {{ old('category') === 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="Plumbing" {{ old('category') === 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                            <option value="Electrical" {{ old('category') === 'Electrical' ? 'selected' : '' }}>Electrical</option>
                            <option value="Other" {{ old('category') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-robot"></i> Category will be auto-suggested based on your description
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="attachment">Attachment (Image or Video)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('attachment') is-invalid @enderror" 
                                   id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.mp4">
                            <label class="custom-file-label" for="attachment">Choose file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Accepted formats: JPG, PNG, MP4 (Max 10MB)
                        </small>
                        @error('attachment')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Request
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
let suggestionTimeout;

$('#description').on('input', function() {
    clearTimeout(suggestionTimeout);
    const description = $(this).val();
    
    if (description.length > 20) {
        suggestionTimeout = setTimeout(function() {
            $.ajax({
                url: '/service-requests/suggestions',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    description: description
                },
                success: function(response) {
                    if (response.suggested_category && !$('#category').val()) {
                        $('#category').val(response.suggested_category);
                    }
                    
                    if (response.quick_reply) {
                        $('#suggestion-text').text(response.quick_reply);
                        $('#ai-suggestion').slideDown();
                    } else {
                        $('#ai-suggestion').slideUp();
                    }
                }
            });
        }, 1000);
    }
});

$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').html(fileName);
});
</script>
@endpush
