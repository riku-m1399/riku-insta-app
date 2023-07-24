<div class="modal fade" id="delete-category-{{ $category->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header border-danger">
        <h5 class="modal-title text-danger">
          <i class="fa-solid fa-trash-can"></i> Delete Category
        </h5>
      </div>

      <div class="modal-body">
        <p class="text-start">Are you sure you want to delete <span class="fw-bold">{{ $category->name }}</span> category?</p>
        <p class="text-start">This action will affect all the posts under this category. Posts without a category will fall under Uncategorized.</p>

        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
          @csrf
          @method('DELETE')
          <div class="row mt-4">
            <div class="col text-end">
              <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger btn-sm">Delete</button></div>
          </div>
          
          
        </form>
      </div>
    </div>
  </div>
</div>
