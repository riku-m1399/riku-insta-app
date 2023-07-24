<div class="modal fade" id="edit-category-{{ $category->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-warning">
      <div class="modal-header border-warning">
        <h5 class="modal-title">
          <i class="fa-regular fa-pen-to-square"></i> Edit Category
        </h5>
      </div>

      <div class="modal-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
          @csrf
          @method('PATCH')
          <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
          @error('name')
            <p class="small text-danger">{{ $message }}</p>
          @enderror
          <div class="row mt-4">
            <div class="col text-end">
              <button class="btn btn-outline-warning btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-warning btn-sm">Update</button></div>
          </div>
          
          
        </form>
      </div>
    </div>
  </div>
</div>
