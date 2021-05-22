@extends('layouts.app')

@section('content')
<div class="container">
  <x-space></x-space>
    <div class="row justify-content-center">
        <div class="col-md-8">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif

          @foreach($space as $spaces)
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                {{$spaces->title}}
                @if($spaces->user_id == Auth::user()->id)
                <form class="" action="{{route('space.destroy', $spaces->id)}}" method="post">
                  {{csrf_field()}}
                  @method('DELETE')
                  <button type="submit" name="button" class="btn btn-sm btn-danger float-right" onclick="return confirm('are you sure want to delete it ?')">Del</button>
                  <a href="{{route('space.edit', $spaces->id)}}" class="btn btn-sm btn-primary float-right text-white">Edit</a>
                </form>
                @endif
              </h5>
              <h6 class="card-subtitle">{{$spaces->address}}</h6>
              <p class="card-text">{{$spaces->description}}</p>
              <a href="#" onclick="openDirection({{$spaces->latitude}}, {{$spaces->longitude}}, {{$spaces->id}})" class="card-link">Direction</a>
            </div>
          </div>
          @endforeach
        </div>
    </div>
    <div class="row justify-content-center">
      {{$space->links()}}
    </div>
</div>
@endsection
