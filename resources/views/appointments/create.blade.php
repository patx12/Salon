@extends('layouts.salon')
@section('title', 'New Booking')
@section('page-title', 'Create Appointment')
@section('content')

<div class="mb-4">
    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-calendar-plus me-2"></i>New Appointment</div>
            <div class="card-body p-4">
                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <h6 class="text-muted fw-semibold mb-3" style="font-size:.75rem;letter-spacing:1px;text-transform:uppercase;">Customer Information</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-medium">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name') }}" placeholder="e.g. Maria Santos">
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-medium">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone"
                                   class="form-control @error('customer_phone') is-invalid @enderror"
                                   value="{{ old('customer_phone') }}" placeholder="09XX-XXX-XXXX">
                            @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Email Address</label>
                        <input type="email" name="customer_email" class="form-control"
                               value="{{ old('customer_email') }}" placeholder="optional">
                    </div>
                    <hr class="my-4">
                    <h6 class="text-muted fw-semibold mb-3" style="font-size:.75rem;letter-spacing:1px;text-transform:uppercase;">Booking Details</h6>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Select Service <span class="text-danger">*</span></label>
                        <select name="service_id" id="service_id"
                                class="form-select @error('service_id') is-invalid @enderror">
                            <option value="">— Choose a service —</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}"
                                        data-price="{{ $service->price }}"
                                        data-duration="{{ $service->duration }} mins"
                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} — ₱{{ number_format($service->price, 2) }} ({{ $service->duration }} mins)
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div id="service-preview" class="alert alert-info d-none mb-3 py-2">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong id="preview-name"></strong> &bull;
                        Duration: <span id="preview-duration"></span> &bull;
                        Price: <strong class="text-success" id="preview-price"></strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="appointment_date"
                               class="form-control @error('appointment_date') is-invalid @enderror"
                               value="{{ old('appointment_date') }}" min="{{ now()->format('Y-m-d\TH:i') }}">
                        @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"
                                  placeholder="Any special requests...">{{ old('notes') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-salon px-4">
                            <i class="bi bi-calendar-check me-1"></i> Book Appointment
                        </button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const select = document.getElementById('service_id');
    const preview = document.getElementById('service-preview');
    select.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if (!opt.value) { preview.classList.add('d-none'); return; }
        document.getElementById('preview-name').textContent = opt.text.split(' — ')[0];
        document.getElementById('preview-duration').textContent = opt.dataset.duration;
        document.getElementById('preview-price').textContent = '₱' + parseFloat(opt.dataset.price).toFixed(2);
        preview.classList.remove('d-none');
    });
    if (select.value) select.dispatchEvent(new Event('change'));
</script>
@endsection