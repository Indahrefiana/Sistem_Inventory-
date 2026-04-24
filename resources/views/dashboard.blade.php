<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard - Dapoer Tipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --primary: #b98f10; /* Warna Emas Dapoer Tipes */
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --success-bg: #ecfdf5;
            --navbar-bg: #ffffff;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Inter', sans-serif; 
        }

        body { 
            background-color: var(--bg-light); 
            display: flex; 
            min-height: 100vh;
            /* Perbaikan agar halaman tidak bisa digeser/swipe */
            overflow-x: hidden; 
            position: relative;
            width: 100%;
            overscroll-behavior-x: none; /* Mencegah pull-to-refresh/swipe back di browser */
        }

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

        .sidebar .brand {
            padding: 0 25px 30px;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #94a3b8;
            text-decoration: none;
            transition: 0.2s;
            font-size: 15px;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #334155;
            color: white;
            border-left: 4px solid var(--primary);
        }

        .sidebar i { width: 25px; font-size: 18px; }

        /* Main Content Area */
        .main {
            margin-left: 260px;
            width: calc(100% - 260px);
            display: flex;
            flex-direction: column;
            min-width: 0; /* Mencegah flex child meluap */
        }

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

        /* --- BAGIAN PROFILE POP-UP --- */
        .user-profile-wrapper {
            position: relative;
        }

        .user-profile {
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            user-select: none;
        }

        .user-profile:hover {
            opacity: 0.8;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .profile-info .greeting {
            font-size: 12px;
            color: #64748b;
            line-height: 1;
        }

        .profile-info .user-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            background: var(--bg-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            border: 1px solid #e2e8f0;
        }

        /* Menu Dropdown Style */
        .profile-dropdown {
            position: absolute;
            top: 120%;
            right: 0;
            width: 200px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            padding: 8px 0;
            display: none; /* Sembunyi default */
            z-index: 1001;
        }

        .profile-dropdown.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* --- AKHIR BAGIAN PROFILE POP-UP --- */

        /* Dashboard Content */
        .content-body {
            padding: 30px;
            overflow-x: hidden; /* Tambahan keamanan di level konten */
        }

        /* Statistics Cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info .label { 
            color: #64748b; 
            font-size: 14px; 
            font-weight: 500; 
            display: block;
            margin-bottom: 5px;
        }

        .stat-info .value { 
            font-size: 28px; 
            font-weight: 700; 
            color: var(--text-dark); 
        }

        .icon-box {
            background: var(--success-bg);
            color: var(--primary);
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .logout-section {
            margin-top: auto;
            padding-bottom: 20px;
        }

        .logout-btn {
            padding: 12px 25px;
            color: #ef4444;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
        }
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
                <span style="font-weight: 500; color: #b48f38ff;"><h2>Sistem Inventaris Bahan Baku</h2></span>
            </div>
            
            <div class="user-profile-wrapper">
                <div class="user-profile" id="profileToggle">
                    <div class="profile-info">
                        <span class="greeting">Halo,</span>
                        <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                    <div class="profile-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                <div class="profile-dropdown" id="profileMenu">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user-edit"></i> Edit Profil
                    </a>
                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 5px 0;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; cursor: pointer; color: #ef4444;">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="content-body">
            <div class="grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="label">Total Unit Bahan</span>
                        <span class="value">{{ number_format($totalBahan ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="icon-box"><i class="fas fa-boxes-stacked"></i></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="label">Barang Masuk</span>
                        <span class="value">{{ number_format($barangMasuk ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="icon-box"><i class="fas fa-truck-loading"></i></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="label">Barang Keluar</span>
                        <span class="value">{{ number_format($barangKeluar ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="icon-box"><i class="fas fa-dolly"></i></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="label">Total Kategori</span>
                        <span class="value">{{ number_format($totalKategori ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="icon-box"><i class="fas fa-list"></i></div>
                </div>
            </div>

            <div style="margin-top: 30px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 15px; color: var(--text-dark);">Informasi Sistem</h3>
                <p style="color: #64748b; line-height: 1.6;">
                    Sistem inventaris **Dapoer Tipes** memantau jumlah unit bahan secara otomatis berdasarkan field `stok`. Pastikan penginputan data barang masuk dan keluar dilakukan dengan teliti agar nilai stok tetap sinkron dengan kondisi fisik di gudang.
                </p>
            </div>
        </div>
    </div>

    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');

        profileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
        });

        window.addEventListener('click', function() {
            if (profileMenu.classList.contains('show')) {
                profileMenu.classList.remove('show');
            }
        });
    </script>
</body>
</html>