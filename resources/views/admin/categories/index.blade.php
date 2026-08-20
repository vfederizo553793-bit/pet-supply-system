@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #546B41;">🗂️ Categories</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">➕ Add Category</a>
</div>

<div class="card" style="border-color: #DCCCAC;">
    <div class="card-body">
        @if($categories->isEmpty())
            <div class="text-center py-4">
                <p class="text-muted">No categories yet.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Add First Category</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead style="background-color: #DCCCAC;">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Pet Type</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if($category->pet_type == 'dog')
                                        🐶 Dog
                                    @else
                                        🐱 Cat
                                    @endif
                                </td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td>
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST"
                                        action="{{ route('categories.destroy', $category) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection