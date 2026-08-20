@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #546B41;">✏️ Edit Product</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">← Back to Dashboard</a>
</div>

<div class="card" style="border-color: #DCCCAC;">
    <div class="card-body">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"
                    rows="4" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ ucfirst($category->pet_type) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" name="price" class="form-control"
                        step="0.01" min="0"
                        value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock" class="form-control"
                        min="0" value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            style="height: 100px; object-fit: cover;" class="rounded">
                    </div>
                @endif
                <input type="file" name="image" class="form-control"
                    accept="image/jpg,image/jpeg,image/png">
                <small class="text-muted">Leave blank to keep current image.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

@endsection