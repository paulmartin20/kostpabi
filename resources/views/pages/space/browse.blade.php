@extends('layouts.app')

@section('content')
<div class="container">
  <x-space></x-space>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">Browse Kost</div>
              <div class="card-body">
                <div id="mapContainer" style="height: 500px"></div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
  <script type="text/javascript">
    window.action = "browse";
  </script>
@endpush
