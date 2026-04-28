<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Salon Management') – LuxeNails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --salon-pink: #f06292;
            --salon-rose: #e91e8c;
            --salon-dark: #2c2c3e;
            --sidebar-w:  250px;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; height: 100%; font-family: 'Poppins', sans-serif; background: #f8f5f7; color: #333; }

        /* FLEXBOX LAYOUT - no fixed positioning */
        .wrapper { display: flex; min-height: 100vh; }

        #sidebar {
            width: var(--sidebar-w);
            min-width: var(--sidebar-w);
            flex-shrink: 0;
            background: linear-gradient(180deg, var(--salon-dark) 0%, #1a1a2e 100%);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar-brand { padding: 1.5rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.08); }
        .brand-name { font-size: 1.3rem; font-weight: 700; color: var(--salon-pink); }
        .brand-sub { font-size: .65rem; color: rgba(255,255,255,.4); letter-spacing: 2px; text-transform: uppercase; }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-section-label { font-size: .65rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,.3); padding: .75rem 1.25rem .25rem; }
        .sidebar-nav .nav-link { display: flex; align-items: center; gap: .75rem; color: rgba(255,255,255,.65); padding: .65rem 1.25rem; font-size: .88rem; transition: all .2s; border-left: 3px solid transparent; border-radius: 0; }
        .sidebar-nav .nav-link i { font-size: 1.1rem; }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active { color: #fff; background: rgba(240,98,146,.2); border-left-color: var(--salon-pink); }
        .sidebar-footer { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,.08); }

        /* MAIN - takes remaining width */
        #main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .topbar { background: #fff; border-bottom: 1px solid #eee; padding: .75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .page-content { padding: 1.75rem; flex: 1; }

        /* COMPONENTS */
        .stat-card { border-radius: 12px; padding: 1.25rem 1.5rem; color: #fff; position: relative; overflow: hidden; min-height: 110px; }
        .stat-card .icon { font-size: 2.5rem; opacity: .2; position: absolute; right: 1rem; bottom: .5rem; }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; }
        .stat-card .stat-label { font-size: .78rem; opacity: .85; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .card-header { background: #fff; border-bottom: 1px solid #f0e6ec; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.25rem; font-weight: 600; }
        .btn-salon { background: linear-gradient(135deg, var(--salon-pink), var(--salon-rose)); color: #fff !important; border: none; border-radius: 8px; }
        .btn-salon:hover { opacity: .9; }
        .table th { font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #888; }
        .table td { vertical-align: middle; font-size: .9rem; }
        .badge { font-weight: 500; padding: .35em .7em; border-radius: 6px; }
        .alert { border: none; border-radius: 10px; }
        .form-control:focus, .form-select:focus { border-color: var(--salon-pink); box-shadow: 0 0 0 .2rem rgba(240,98,146,.2); }
    </style>
</head>
<body>

<div class="wrapper">
    <div id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-name"><i class="bi bi-scissors me-2"></i>LuxeNails</div>
            <div class="brand-sub">Salon Management</div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <div class="nav-section-label">Manage</div>
            <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <i class="bi bi-stars"></i> Services
            </a>
            <a href="{{ route('appointments.index') }}" class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Appointments
            </a>
            <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Payments
            </a>
        </nav>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div id="main">
        <div class="topbar">
            <span class="fw-semibold text-muted small">@yield('page-title', 'Dashboard')</span>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle fs-5 text-muted"></i>
                <span class="small fw-medium">{{ auth()->user()->name }}</span>
            </div>
        </div>
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>