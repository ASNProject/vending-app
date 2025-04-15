@extends('layouts.app', ['title' => 'Home'])

@section('content')
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        @include('components.sidebar')
        {{-- END Sidebar --}}
        
        {{-- Main Content --}}
        <div class="p-3 w-100">
            <div class="p-3 mb-4 bg-light rounded-3">
                <div class="container-fluid">
                    <h1 class="display-5 fw-bold mb-5">Home</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered full-width-table">
                            <thead>
                                <tr>
                                    <th scope="col">Device</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Limit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($devices as $device)
                                    <tr>
                                        <td>{{ $device->device }}</td>
                                        <td>{{ $device->item->name }}</td> <!-- Akses nama item terkait -->
                                        <td>{{ $device->limit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Menampilkan pagination -->
                    <div class="d-flex justify-content-center">
                      {{ $devices->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Link to External CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">

</body>
@endsection
