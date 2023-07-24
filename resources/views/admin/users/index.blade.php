@extends('layouts.app')

@section('title', 'Admin: Users')
    
@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
      <thead class="table-success small text-secondary">
        <th></th>
        <th>Name</th>
        <th>Email</th>
        <th>CREATED</th>
        <th>STATUS</th>
        <th></th>
      </thead>
      <tbody>
        @foreach ($all_users as $user)
            <tr>
              <td>
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle d-block mx-auto avatar-md">
                @else
                    <i class="fa-solid fa-circle-user d-block text-center icon-md"></i>
                @endif
              </td>
              <td>
                <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
              </td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at }}</td>
              <td>
                {{-- trashed() -- TRUE if deleted_at column is not null --}}
                @if ($user->trashed())
                  <i class="fa-regular text-secondary fa-circle"></i>&nbsp; Inactive
                @else
                  <i class="fa-solid text-success fa-circle"></i>&nbsp; Active
                @endif
              </td>
              <td>
                @if (Auth::user()->id !== $user->id)
                  <div class="dropdown">
                    <button class="btn btn-sm" data-bs-toggle="dropdown">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="dropdown-menu">
                      @if ($user->trashed())
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
                          <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                        </button>
                      @else
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
                          <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                        </button>
                      @endif
                    </div>
                    @include('admin.users.modal.status')
                  </div>
                @endif
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>

    {{ $all_users->links() }}
    {{-- {{ $all_users->links('pagination::bootstrap-5') }} --}}
@endsection