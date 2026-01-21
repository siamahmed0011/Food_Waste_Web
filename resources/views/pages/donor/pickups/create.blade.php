@extends('layouts.main')

@section('title', 'Request Pickup')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Request Pickup</h4>
                    <a href="{{ route('donor.pickups.index') }}" class="btn btn-sm btn-outline-secondary">
                        My Pickup Requests
                    </a>
                </div>

                <div class="card-body">
                    {{-- NOTE: backend e giye action + method set korbo --}}
                    <form>
                        @csrf

                        {{-- Food Details --}}
                        <h5 class="mb-3">Food Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Food Type / Name</label>
                            <input type="text" name="food_type" class="form-control" placeholder="e.g. Biriyani, Fried Rice" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" placeholder="e.g. 20" required min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Unit</label>
                                <select name="unit" class="form-select" required>
                                    <option value="">Select unit</option>
                                    <option value="plates">Plates</option>
                                    <option value="people">People</option>
                                    <option value="kg">Kg</option>
                                    <option value="packets">Packets</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prepared At</label>
                                <input type="datetime-local" name="prepared_at" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Best Before</label>
                                <input type="datetime-local" name="best_before" class="form-control">
                            </div>
                        </div>

                        <hr>

                        {{-- Pickup Details --}}
                        <h5 class="mb-3">Pickup Details</h5>

                        <div class="mb-3">
                            <label class="form-label">Pickup Time (Preferred)</label>
                            <input type="datetime-local" name="pickup_time" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pickup Address</label>
                            <textarea name="pickup_address" rows="3" class="form-control"
                                      placeholder="Full address or landmark" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" name="contact_phone" class="form-control" placeholder="e.g. 01XXXXXXXXX" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes (optional)</label>
                            <textarea name="notes" rows="3" class="form-control"
                                      placeholder="Any special instructions about food or pickup"></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('donor.pickups.index') }}" class="btn btn-light me-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                Submit Pickup Request
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
