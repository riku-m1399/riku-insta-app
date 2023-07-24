@extends('layouts.app')

@section('title', 'Admin: Categories')
    
@section('content')
    <form action="{{ route('admin.categories.store') }}" method="post">
      @csrf
      <div class="row">
        <div class="col-6">
          <input type="text" name="name" class="form-control" placeholder="Add a category...">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
      </div>
      @error('name')
          <p class="small text-danger">{{ $message }}</p>
      @enderror
    </form>

    <table class="table table-hover align-middle bg-white border text-secondary mt-4 w-75">
      <thead class="table-warning small text-secondary text-center">
        <th>#</th>
        <th>NAME</th>
        <th>COUNT</th>
        <th>LAST UPDATED</th>
        <th></th>
      </thead>
      <tbody>
        @forelse ($all_categories as $category)
            <tr class="text-center">
              <td>{{ $category->id }}</td>
              <td>{{ $category->name }}</td>
              <td>{{ count($category->categoryPost) }}</td>
              <td>
                {{ $category->updated_at }}
              </td>
              <td>
                <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                  <i class="fa-solid fa-pen"></i>
                </button>
                {{-- include the modal here --}}
                @include('admin.categories.modal.edit')
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
                {{-- include the modal here --}}
                @include('admin.categories.modal.delete')
              </td>
            </tr>
        @empty
            <tr>
              <td colspan="7" class="lead text-muted text-center">No categories found.</td>
            </tr>
        @endforelse
        <tr class="text-center">
          <td></td>
          <td class="text-muted">
            Uncategorized
            <br>
            <span class="small">Hidden posts are not included</span>
          </td>
          <td>{{ count($uncategorized_post) }}</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
@endsection