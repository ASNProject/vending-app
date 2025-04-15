@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="bg-light sidebar p-3 d-flex flex-column" style="width: 250px; height: 100vh; border-right: 2px solid #ddd;">
            <h3 class="text-left mb-4">Vending App</h3>
            <ul class="nav flex-column mb-auto" id="sidebar">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="#" data-url="{{ route('dashboard.home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('userdata') ? 'active' : '' }}" href="#" data-url="{{ route('dashboard.userdata') }}">
                        userdata
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('nama-item') ? 'active' : '' }}" href="#" data-url="{{ route('dashboard.nama-item') }}">
                        Nama Item
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('atur-item') ? 'active' : '' }}" href="#" data-url="{{ route('dashboard.atur-item') }}">
                        Atur Item
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('data-pengguna') ? 'active' : '' }}" href="#" data-url="{{ route('dashboard.data-pengguna') }}">
                        Data Pengguna
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('record') ? 'active' : '' }}" href="#" data-url="{{ route('dashboard.record') }}">
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
        {{-- END Sidebar --}}
        
        {{-- Main Content --}}
        <div id="main-content" class="flex-grow-1 p-3">
            <!-- Default content for Home will load here -->
        </div>
        {{-- END Main Content --}}
    </div>

    {{-- Add custom styling --}}
    <style>
        /* Hover effect for sidebar links */
        .nav-link {
            font-size: 16px;
            font-weight: 600;
            color: #6c757d; /* Text color gray */
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        /* Hover effect for links */
        .nav-link:hover {
            color: white;
            background-color: #ffc107;
            border-radius: 5px;
        }

        /* Active link styling */
        .nav-link.active {
            color: white;
            background-color: #ffc107;
            border-radius: 5px;
        }

        /* Icon and link styling */
        .nav-link i {
            margin-right: 10px;
        }

        /* Logout button hover effect */
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>

    {{-- Add JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.nav-link');
            
            // Handle Sidebar Link Click
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove 'active' class from all links
                    links.forEach(link => link.classList.remove('active'));

                    // Add 'active' class to the clicked link
                    this.classList.add('active');

                    // Get the URL from data-url attribute
                    const url = this.getAttribute('data-url');

                    // Use AJAX to fetch the content and update main content
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('main-content').innerHTML = html;
                        })
                        .catch(error => console.error('Error loading content:', error));
                });
            });

            // Load default content for Home on page load
            const homeLink = document.querySelector('.nav-link[data-url="{{ route('dashboard.home') }}"]');
            if (homeLink) {
                homeLink.classList.add('active');
                const url = homeLink.getAttribute('data-url');
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('main-content').innerHTML = html;
                    })
                    .catch(error => console.error('Error loading default content:', error));
            }
        });
    </script>
</body>
@endsection
