<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Dapoer Tipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --primary: #b98f10;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --navbar-bg: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body { background-color: var(--bg-light); display: flex; min-height: 100vh; }

        /* Sidebar Navigation */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            height: 100vh;
            color: white;
            position: fixed;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar .brand { padding: 0 25px 30px; font-size: 22px; font-weight: bold; display: flex; align-items: center; gap: 10px; }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #94a3b8;
            text-decoration: none;
            transition: 0.2s;
            font-size: 15px;
        }

        .sidebar a:hover, .sidebar a.active { background: #334155; color: white; border-left: 4px solid var(--primary); }
        .sidebar i { width: 25px; font-size: 18px; }

        /* Main Content Area */
        .main { margin-left: 260px; width: calc(100% - 260px); display: flex; flex-direction: column; }

        /* Top Navbar */
        .navbar {
            height: 70px;
            background: var(--navbar-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .user-profile { cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .profile-info { display: flex; flex-direction: column; text-align: right; }
        .profile-info .greeting { font-size: 12px; color: #64748b; line-height: 1; }
        .profile-info .user-name { font-size: 14px; font-weight: 700; color: var(--text-dark); }
        .profile-icon { width: 40px; height: 40px; background: var(--bg-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); border: 1px solid #e2e8f0; }

        /* Content Body */
        .content-body { padding: 30px; }
        .section-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .logout-section { margin-top: auto; padding-bottom: 20px; }
        .logout-btn {
            padding: 12px 25px; color: #ef4444; cursor: pointer; border: none; background: none;
            width: 100%; text-align: left; font-size: 15px; display: flex; align-items: center; gap: 10px; transition: 0.2s;
        }
        .logout-btn:hover { background: rgba(239, 68, 68, 0.1); }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">🍳 Dapoer Tipes</div>
        
        <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="/kategori" class="{{ Request::is('kategori*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Kategori
        </a>
        <a href="/bahan" class="{{ Request::is('bahan*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Bahan Dasar
        </a>
        <a href="/barang-masuk"><i class="fas fa-arrow-circle-down"></i> Barang Masuk</a>
        <a href="/barang-keluar"><i class="fas fa-arrow-circle-up"></i> Barang Keluar</a>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="main">
        <nav class="navbar">
            <div class="nav-left">
                <h2 style="font-weight: 600; color: var(--text-dark); font-size: 1.25rem;">Pengaturan Profil</h2>
            </div>
            
            <a href="{{ route('profile.edit') }}" class="user-profile">
                <div class="profile-info">
                    <span class="greeting">Halo,</span>
                    <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
                <div class="profile-icon">
                    <i class="fas fa-user"></i>
                </div>
            </a>
        </nav>

        <div class="content-body">
            <div class="max-w-4xl">
                
                <div class="section-card">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="section-card">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="section-card">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>