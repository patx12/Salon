@extends('layouts.salon')

@section('title', 'Services')
@section('page-title', 'Service Management')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Salon Services</h4>
        <p class="text-muted small mb-0">Manage all your salon service offerings.</p>
    </div>
    <a href="{{ route('services.create') }}" class="btn btn-salon">
        <i class="bi bi-plus-lg me-1"></i> Add Service
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $service->name }}</td>

                        <td class="text-muted small" style="max-width:200px;">
                            {{ $service->description 
                                ? Str::limit($service->description, 60) 
                                : '—' }}
                        </td>

                        <td class="fw-semibold text-success">
                            ₱{{ number_format($service->price, 2) }}
                        </td>

                        <td>{{ $service->duration }} mins</td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('services.edit', $service) }}" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('services.destroy', $service) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Delete this service?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-stars fs-2 d-block mb-2"></i>
                            No services yet. 
                            <a href="{{ route('services.create') }}">Add one!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($services->hasPages())
    <div class="card-footer bg-white">
        {{ $services->links() }}
    </div>
    @endif
</div>

@endsection