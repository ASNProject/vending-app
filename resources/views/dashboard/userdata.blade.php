@extends('layouts.app', ['title' => 'userdata'])

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
                    <h1 class="display-5 fw-bold mb-5">User Data</h1>
               {{-- Show Alert for Success or Error --}}
                    {{-- @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}
                    
                    @if(session('error'))
                        <script>
                            // Menampilkan alert dialog jika ada error
                            alert('{{ session('error') }}');
                        </script>
                    @endif

                    {{-- Form Input --}}
                    <form action="{{ route('user-item-limits.store') }}" method="POST">
                      @csrf
                      <div class="row mb-4">
                          <div class="col-md-3">
                              <label for="uid" class="form-label">UID</label>
                              <input type="text" name="uid" id="uid" class="form-control" required>
                          </div>
                          <div class="col-md-3">
                              <label for="name" class="form-label">Name</label>
                              <input type="text" name="name" id="name" class="form-control" required>
                          </div>
                          <div class="col-md-3">
                              <label for="role" class="form-label">Role</label>
                              <input type="text" name="role" id="role" class="form-control" required>
                          </div>
                          <div class="col-md-3">
                              <label for="limit" class="form-label">Limit</label>
                              <input type="number" name="limit" id="limit" class="form-control" required>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Add Data</button>
                  </form>
                  <hr>
                    {{-- Table to Display Data --}}
                    <table class="table table-striped" style="width: 100%; overflow-x: auto; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th scope="col">UID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Limit</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userItemLimits as $userItemLimit)
                                <tr>
                                    <td>{{ $userItemLimit->uid }}</td>
                                    <td>{{ $userItemLimit->name }}</td>
                                    <td>{{ $userItemLimit->role }}</td>
                                    <td>{{ $userItemLimit->limit }}</td>
                                    <td class="d-flex gap-2">
                                      <button class="btn btn-warning btn-sm mr-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $userItemLimit->id }}">Edit</button>
                                  
                                      <form action="{{ route('user-item-limits.destroy', $userItemLimit->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                    @foreach($userItemLimits as $userItemLimit)
                    <!-- Modal -->
                    <div class="modal fade" id="editModal{{ $userItemLimit->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $userItemLimit->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <form action="{{ route('user-item-limits.update', $userItemLimit->uid) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $userItemLimit->id }}">Edit Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label for="uid{{ $userItemLimit->id }}" class="form-label">UID</label>
                                      <input type="text" name="uid" class="form-control" id="uid{{ $userItemLimit->id }}" value="{{ $userItemLimit->uid }}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="name{{ $userItemLimit->id }}" class="form-label">Name</label>
                                      <input type="text" name="name" class="form-control" id="name{{ $userItemLimit->id }}" value="{{ $userItemLimit->name }}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="role{{ $userItemLimit->id }}" class="form-label">Role</label>
                                      <input type="text" name="role" class="form-control" id="role{{ $userItemLimit->id }}" value="{{ $userItemLimit->role }}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="limit{{ $userItemLimit->id }}" class="form-label">Limit</label>
                                      <input type="number" name="limit" class="form-control" id="limit{{ $userItemLimit->id }}" value="{{ $userItemLimit->limit }}" required>
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
                      {{ $userItemLimits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Link to External CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
</body>
@endsection
