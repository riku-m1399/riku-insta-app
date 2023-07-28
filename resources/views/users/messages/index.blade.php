@extends('layouts.app')

@section('title', 'Message Index')

@section('content')
    <div class="w-50 mx-auto">
      
        <h3 class="ms-2 mb-3">Message</h3>
      
      
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
              <td class="text-decoration-none text-muted fw-bold">
                {{ $user->name }}
              </td>
              <td>
                <a href="{{ route('message.room', $user->id) }}" class="text-decoration-none stretched-link text-dark">{{ Str::limit($latest_message->message,10,'...') }}</a>
              </td>
              <td class="text-muted">
                {{ $latest_message->created_at->diffForHumans() }}
              </td>
            </tr>
          @empty
            <h3 class="text-muted text-center">No Messages Yet</h3>
          @endforelse
        </table>
      
    </div>
@endsection
