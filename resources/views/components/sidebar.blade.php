<div class="bg-light sidebar p-3 d-flex flex-column" style="width: 250px; height: 100vh; border-right: 2px solid #ddd;">
    <h3 class="text-left mb-4">Vending</h3>
    <ul class="nav flex-column mb-auto" id="sidebar">
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('dashboard.home') }}">
                Home
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('userdata') ? 'active' : '' }}" href="{{ route('dashboard.userdata') }}">
                User Data
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('nama-item') ? 'active' : '' }}" href="{{ route('dashboard.nama-item') }}">
                Item
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('data-pengguna') ? 'active' : '' }}" href="{{ route('dashboard.data-pengguna') }}">
                Device
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('record') ? 'active' : '' }}" href="{{ route('dashboard.record') }}">
                Record
            </a>
        </li>
    </ul>

    {{-- Logout Button --}}
    <form class="form-inline mt-auto" action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to logout?')">
        @csrf
        <button class="btn btn-outline-danger w-100" type="submit" style="font-weight: 600;">Logout</button>
    </form>
</div>
