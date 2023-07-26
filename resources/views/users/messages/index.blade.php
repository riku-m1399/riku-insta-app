@extends('layouts.app')

@section('title', 'Message Index')

@section('content')
    <div class="card w-50 mx-auto">
      <div class="card-header bg-white py-3">
        <h3>Message</h3>
      </div>
      <div class="card-body">
        {{-- @forelse ($users_message as $user_message)
            
        @empty
          <h3 class="text-muted text-center">No Messages Yet</h3>
        @endforelse --}}
      </div>
    </div>
@endsection
