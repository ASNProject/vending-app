@extends('layouts.app', ['title' => 'Record'])

@section('content')
<body>
    <div class="d-flex">
        <div class="py-1">
            <div class="p-3 mb-4 bg-light rounded-3">
              <div class="container-fluid">
                {{-- @session('success')
                    <div class="alert alert-success" role="alert"> 
                      {{ $value }}
                    </div>
                @endsession --}}
        
                <h1 class="display-5 fw-bold">Hi, {{ auth()->user()->name }}</h1>
                <p class="col-md-8 fs-4">Welcome to Record.<br/>Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
                <button class="btn btn-primary btn-lg" type="button">Dashboard</button>
              </div>
            </div>
        
          </div>
    </div>
</body>
@endsection
