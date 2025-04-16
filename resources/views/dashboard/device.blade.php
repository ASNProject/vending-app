@extends('layouts.app', ['title' => 'Data Pengguna'])

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
    
            <h1 class="display-5 fw-bold mb-5">Device</h1>
            @if(session('error'))
                <script>
                    // Menampilkan alert dialog jika ada error
                    alert('{{ session('error') }}');
                </script>
            @endif
            {{-- Form Add Data --}}
            <form action="{{ route('device.store') }}" method="POST">
              @csrf
              <div class="row mb-3">
                  <div class="col-md-4">
                      <label for="device" class="form-label">Nama Device</label>
                      <input type="text" class="form-control" id="device" name="device" required>
                  </div>
              </div>

              <div id="item-limit-group">
                  <div class="row mb-2 item-limit-row">
                      <div class="col-md-4">
                          <label class="form-label">Item</label>
                          <select name="items[0][item_id]" class="form-control" required>
                              <option value="" disabled selected>Pilih Item</option>
                              @foreach(App\Models\Item::all() as $item)
                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label">Limit</label>
                          <input type="number" class="form-control" name="items[0][limit]" min="1" required>
                      </div>
                      <div class="col-md-4 d-flex align-items-end">
                          <button type="button" class="btn btn-danger remove-row">Hapus</button>
                      </div>
                  </div>
              </div>

              <button type="button" class="btn btn-secondary mb-3" id="add-item">+ Tambah Item</button>
              <br>
              <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
            {{-- Table to Display Data --}}
            <table class="table table-striped" style="width: 100%; overflow-x: auto; table-layout: fixed;">
            <thead>
                <tr>
                    <th scope="col">Device</th>
                    <th scope="col">Item</th>
                    <th scope="col">Limit</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                    <tr>
                        <td>{{ $device->device }}</td>
                        <td>{{ $device->item->name }}</td>
                        <td>{{ $device->limit }}</td>
                        <td class="d-flex gap-2">
                          <button class="btn btn-warning btn-sm mr-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $device->id }}">Edit</button>
                      
                          <form action="{{ route('device.destroy', $device->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                          </form>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModal{{ $device->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $device->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('device.update', $device->device) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $device->id }}">Edit Limit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="item_id" value="{{ $device->item_id }}">
                                <div class="mb-3">
                                    <label class="form-label">Device</label>
                                    <input type="text" class="form-control" value="{{ $device->device }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Item</label>
                                    <input type="text" class="form-control" value="{{ $device->item->name }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Limit</label>
                                    <input type="number" name="limit" class="form-control" value="{{ $device->limit }}" min="1" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
                <!-- Menampilkan pagination -->
                <div class="d-flex justify-content-center">
                    {{ $devices->links() }}
                </div>
          </div>
        </div>

      </div>
  </div>
  {{-- Link to External CSS --}}
  <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
</body>
<script>
  let itemIndex = 1;

  document.getElementById('add-item').addEventListener('click', function () {
      const group = document.getElementById('item-limit-group');
      const row = document.createElement('div');
      row.classList.add('row', 'mb-2', 'item-limit-row');

      row.innerHTML = `
          <div class="col-md-4">
              <select name="items[${itemIndex}][item_id]" class="form-control" required>
                  <option value="" disabled selected>Pilih Item</option>
                  @foreach(App\Models\Item::all() as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
              </select>
          </div>
          <div class="col-md-4">
              <input type="number" class="form-control" name="items[${itemIndex}][limit]" min="1" required>
          </div>
          <div class="col-md-4 d-flex align-items-end">
              <button type="button" class="btn btn-danger remove-row">Hapus</button>
          </div>
      `;
      group.appendChild(row);
      itemIndex++;
  });

  // Event delegation to remove item rows
  document.addEventListener('click', function (e) {
      if (e.target && e.target.classList.contains('remove-row')) {
          e.target.closest('.item-limit-row').remove();
      }
  });
</script>


@endsection
