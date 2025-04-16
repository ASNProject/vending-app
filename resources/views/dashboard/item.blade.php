@extends('layouts.app', ['title' => 'Nama Item'])

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
            {{-- @session('success')
                <div class="alert alert-success" role="alert"> 
                  {{ $value }}
                </div>
            @endsession --}}
    
            <h1 class="display-5 fw-bold mb-5">Item</h1>
            @if(session('error'))
                <script>
                    // Menampilkan alert dialog jika ada error
                    alert('{{ session('error') }}');
                </script>
            @endif
            {{-- Form Input --}}
            <form action="{{ route('item.store') }}" method="POST">
              @csrf
              <div class="row mb-4">
                  <div class="col-md-3">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" id="name" class="form-control" required>
                  </div>
              </div>
              <button type="submit" class="btn btn-primary">Add Data</button>
          </form>
          <hr>
          {{-- Table to Display Data --}}
          <table class="table table-striped" style="width: 100%; overflow-x: auto; table-layout: fixed;">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="d-flex gap-2">
                          <button class="btn btn-warning btn-sm mr-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</button>
                      
                          <form action="{{ route('item.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                          </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Dialod Edit --}}
        @foreach($items as $item)
        <!-- Modal -->
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
          <div class="modal-dialog">
            <form action="{{ route('item.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="mb-3">
                          <label for="name{{ $item->id }}" class="form-label">Name</label>
                          <input type="text" name="name" class="form-control" id="name{{ $item->id }}" value="{{ $item->name }}" required>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </div>
            </form>
          </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
          {{ $items->links() }}
        </div>
      </div>
  </div>
  {{-- Link to External CSS --}}
  <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
</body>
@endsection
