@extends('layouts.app', ['title' => 'Record'])

@section('content')
<body>
  <div class="d-flex">
    {{-- Sidebar --}}
    @include('components.sidebar')
    {{-- END Sidebar --}}
    <hr>
    {{-- Main Content --}}
    <div class="p-3 w-100">
      <div class="p-3 mb-4 bg-light rounded-3">
        <div class="container-fluid">
          <h1 class="display-5 fw-bold mb-5">Record</h1>
          <a href="{{ route('records.export.excel') }}" class="btn btn-success mb-3">
            Download CSV
          </a>
              {{-- Table to Display Data --}}
            <table class="table table-striped" style="width: 100%; overflow-x: auto; table-layout: fixed;">
              <thead>
                  <tr>
                      <th scope="col">Device</th>
                      <th scope="col">Item</th>
                      <th scope="col">Name</th>
                      <th scope="col">Role</th>
                      <th scope="col">Date</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($records as $record)
                      <tr>
                          <td>{{ $record->device }}</td>
                          <td>{{ $record->item->name }}</td>
                          <td>{{ $record->user->name }}</td>
                          <td>{{ $record->user->role }}</td>
                          <td>{{ $record->created_at}}</td>
                      </tr>
                  @endforeach
              </tbody>
            </table>

            <div class="d-flex justify-content-center">
              {{ $records->links() }}
            </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Link to External CSS --}}
  <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
</body>
@endsection
