{{-- Clickable image --}}
<div class="container">
  <a href="{{ route('post.show', $post->id) }}">
    <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
  </a>
</div>
<div class="card-body">
  {{-- Heart button + no of likes a post has --}}
  <div class="row align-items-center">
    <div class="col-auto">
      @if ($post->isLiked())
          <form action="{{ route('like.destroy', $post->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-solid fa-heart text-danger"></i></button>
          </form>
      @else
          <form action="{{ route('like.store', $post->id) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-regular fa-heart"></i></button>
          </form>
      @endif
      
    </div>
    <div class="col-auto px-0">
      <span>{{ $post->likes->count() }}</span>
    </div>
    <div class="col text-end">
      @foreach ($post->categoryPost as $category_post)
          <div class="badge bg-secondary bg-opacity-50">
            {{$category_post->category->name}}
          </div>
      @endforeach
    </div>
  </div>

  {{-- Display the name of the user who creatd the post + decolation --}}
  <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
  &nbsp;
  <p class="d-inline fw-light">{{ $post->description }}</p>
  <p class="text-uppercase text-muted xsmall p-0">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
  <p class="text-muted small p-0">Posted {{$post->created_at->diffForHumans()}}</p>

  {{-- Add comments --}}
  @include('users.posts.contents.comment')

</div>