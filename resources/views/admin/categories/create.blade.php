@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #546B41;">➕ Add Category</h2>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">← Back to Categories</a>
</div>

<div class="card" style="border-color: #DCCCAC;">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Pet Type</label>
                <select name="pet_type" class="form-select" required>
                    <option value="">Select pet type...</option>
                    <option value="dog" {{ old('pet_type') == 'dog' ? 'selected' : '' }}>🐶 Dog</option>
                    <option value="cat" {{ old('pet_type') == 'cat' ? 'selected' : '' }}>🐱 Cat</option>
                </select>
                @error('pet_type')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>
</div>

@endsection