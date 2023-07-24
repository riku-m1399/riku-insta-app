@extends('layouts.app')

@section('title', 'Message Room')
    
@section('content')
    <div class="card w-50 mx-auto">
      <div class="card-header bg-white py-3">
        <div class="row align-items-center">
          <div class="col-auto">
            <a href="{{ route('profile.show', $user->id) }}">
              @if ($user->avatar)
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
              @else
                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
              @endif
            </a>
          </div>
          <div class="col ps-0">
            <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-secondary">{{ $user->name }}</a>
          </div>
        </div>
      </div>

      <div class="card-body line-bc">
        @foreach ($messages as $message)
            @if ($message->sender_id == Auth::user()->id)
                <div class="mycomment">
                  <p>
                    {{ $message->message }}
                  </p>
                </div>
                <p class="text-uppercase text-muted xsmall p-0 text-end">{{$message->created_at->diffForHumans()}}</p>
            @else
                <div class="balloon">
                  <div class="faceicon">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                    @else
                      <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                    @endif
                  </div>
                  <div class="chatting">
                    <div class="says">
                      <p>{{ $message->message }}</p>
                    </div>
                  </div>
                </div>
                <p class="text-uppercase text-muted xsmall p-0">{{$message->created_at->diffForHumans()}}</p>
            @endif
        @endforeach
        </ul>
        
      </div>

      <div class="card-footer mb-0">
        <form action="{{ route('message.send', $user->id) }}" method="post">
          @csrf
          <div class="row mx-auto">
            <div class="col-10">
              <input type="text" name="message" class="form-controll w-100" placeholder="Input message." autofocus>
            </div>
            <div class="col-2">
              <button type="submit" class="btn btn-primary btn-sm">Send</button>
            </div>
          </div>
         
        </form>
      </div>
    </div>
@endsection