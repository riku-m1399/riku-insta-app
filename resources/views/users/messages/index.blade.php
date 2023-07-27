@extends('layouts.app')

@section('title', 'Message Index')

@section('content')
    <div class="card w-50 mx-auto">
      <div class="card-header bg-white py-3">
        <h3>Message</h3>
      </div>
      <div class="card-body">
        <table class="table table-hover align-middle bg-white border text-secondary">
          @forelse ($rooms as [$user, $latest_message])
            <tr class="position-relative">
              <td>
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle d-block mx-auto avatar-sm">
                @else
                    <i class="fa-solid fa-circle-user d-block text-center icon-sm"></i>
                @endif
              </td>
              <td>
                <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
              </td>
              <td>
                <a href="{{ route('message.room', $user->id) }}" class="text-decoration-none stretched-link">{{ $latest_message->message }}</a>
              </td>
              <td>
                {{ $latest_message->created_at->diffForHumans() }}
              </td>
            </tr>
          @empty
            <h3 class="text-muted text-center">No Messages Yet</h3>
          @endforelse
        </table>
      </div>
    </div>
@endsection
