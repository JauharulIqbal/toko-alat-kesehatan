<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard - Toko Alkes' }}</title>

    {{-- CSS --}}
    @vite('resources/js/admin.js')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar-active {
            background-color: #0d6efd !important;
            color: #fff !important;
            border-radius: 0.375rem;
        }

        .sidebar-active .icon-wrapper i {
            color: #fff !important;
        }

        .icon-wrapper i {
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
</head>

<body class="bg-light">

    <div class="d-flex min-vh-100" id="wrapper">
        {{-- Sidebar --}}
        <aside class="bg-white border-end shadow-sm" id="sidebar" style="width: 250px; flex-shrink: 0;">
            <x-admin.sidebar />
        </aside>

        {{-- Page Content --}}
        <div id="page-content-wrapper" class="flex-grow-1 d-flex flex-column">
            {{-- Navbar --}}
            <x-admin.navbar />

            {{-- Main Content --}}
            <main class="flex-grow-1 p-4 bg-light">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </main>

            {{-- Footer --}}
            <footer class="text-center py-4 text-muted small bg-light">
                Developed by Admin Toko Alkes ❤️
            </footer>
        </div>
    </div>

    {{-- JS --}}
    @stack('scripts')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('d-none');
        });
    </script>
</body>

</html>