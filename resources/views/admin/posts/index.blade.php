@extends('layouts.app')

@section('title', 'Admin: Posts')
    
@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
      <thead class="table-primary small text-secondary">
        <th></th>
        <th></th>
        <th>CATEGORY</th>
        <th>OWNER</th>
        <th>CREATED AT</th>
        <th>STATUS</th>
        <th></th>
      </thead>
      <tbody>
        @forelse ($all_posts as $post)
            <tr>
              <td class="text-end">{{ $post->id }}</td>
              <td>
                <a href="{{route('post.show', $post->id)}}" class="text-decoration-none text-dark fw-bold">
                  <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="d-block mx-auto image-lg">
                </a>
              </td>
              <td>
                @if ($post->categoryPost->isNotEmpty())
                  @foreach ($post->categoryPost as $category_post)
                    <span class="badge bg-secondary bg-opacity-50">
                      {{ $category_post->category->name }}
                    </span>
                  @endforeach
                @else
                  <span class="badge bg-dark">
                    Uncategoriezed
                  </span>
                @endif
                
              </td>
              <td>
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-dark text-decoration-none">{{ $post->user->name }}</a>
              </td>
              <td>
                {{ $post->created_at }}
              </td>
              <td>
                @if ($post->trashed())
                  <i class="fa-solid fa-circle-minus"></i>&nbsp; Hidden
                @else
                  <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                @endif
              </td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-sm" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis"></i>
                  </button>

                  <div class="dropdown-menu">
                    @if ($post->trashed())
                      <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post-{{ $post->id }}">
                        <i class="fa-solid fa-eye"></i>
                        Unhide Post {{ $post->id }}
                      </button>  
                    @else
                      <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
                        <i class="fa-solid fa-eye-slash"></i>
                        Hide Post {{ $post->id }}
                      </button>
                    @endif
                    
                  </div>
                </div>
                {{-- include the modal here --}}
                @include('admin.posts.modal.status')
              </td>
            </tr>
        @empty
            <tr>
              <td colspan="7" class="lead text-muted text-center">No posts found.</td>
            </tr>
        @endforelse
      </tbody>
    </table>
    {{ $all_posts->links() }}
@endsection