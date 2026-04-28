@extends('layouts.salon')
@section('title', 'Add Service')
@section('page-title', 'Add New Service')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Add New Service</h4>
        <p class="text-muted small mb-0">Fill in the details below.</p>
    </div>
    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('services.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Service Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Price (₱)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                           class="form-control @error('price') is-invalid @enderror" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Duration (mins)</label>
                    <input type="number" name="duration" value="{{ old('duration') }}"
                           class="form-control @error('duration') is-invalid @enderror" required>
                    @error('duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Description</label>
                    <textarea name="description" rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-salon px-4">
                    <i class="bi bi-check-lg me-1"></i> Save Service
                </button>
                <a href="{{ route('services.index') }}" class="btn btn-outline-secondary px-4">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection