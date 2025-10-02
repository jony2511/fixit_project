@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Technician</h3>
            </div>
            <form action="{{ route('technicians.update', $technician) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $technician->name) }}" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="skill_area">Skill Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('skill_area') is-invalid @enderror" 
                               id="skill_area" name="skill_area" value="{{ old('skill_area', $technician->skill_area) }}" required>
                        @error('skill_area')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="availability">Availability <span class="text-danger">*</span></label>
                        <select class="form-control @error('availability') is-invalid @enderror" 
                                id="availability" name="availability" required>
                            <option value="Available" {{ old('availability', $technician->availability) === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Busy" {{ old('availability', $technician->availability) === 'Busy' ? 'selected' : '' }}>Busy</option>
                            <option value="Unavailable" {{ old('availability', $technician->availability) === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                        @error('availability')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Technician
                    </button>
                    <a href="{{ route('technicians.show', $technician) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection