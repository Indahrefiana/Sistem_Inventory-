<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - Dapoer Tipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-bg: #1e293b; 
            --primary: #b98f10; 
            --bg-light: #f8fafc; 
            --danger: #ef4444; 
            --text-dark: #1e293b; 
            --navbar-bg: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-light); display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar-bg); height: 100vh; color: white; position: fixed; padding: 20px 0; z-index: 1000; }
        .sidebar .brand { padding: 0 25px 30px; font-size: 22px; font-weight: bold; }
        .sidebar a { display: flex; align-items: center; padding: 12px 25px; color: #94a3b8; text-decoration: none; transition: 0.2s; }
        .sidebar a.active { background: #334155; color: white; border-left: 4px solid var(--primary); }
        
        /* Main Layout */
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

        /* Profile Dropdown Logic */
        .user-profile-wrapper { position: relative; }
        
        .user-profile {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            user-select: none;
            padding: 5px 10px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .user-profile:hover { background: #f1f5f9; }

        .profile-info { display: flex; flex-direction: column; text-align: right; }
        .profile-info .greeting { font-size: 12px; color: #64748b; line-height: 1; }
        .profile-info .user-name { font-size: 14px; font-weight: 700; color: var(--text-dark); }

        .profile-icon {
            width: 40px; height: 40px;
            background: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--primary);
            border: 1px solid #e2e8f0;
        }

        .profile-dropdown {
            position: absolute;
            top: 110%;
            right: 0;
            width: 180px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            padding: 8px 0;
            display: none;
            z-index: 1001;
        }

        .profile-dropdown.show { display: block; }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .dropdown-item:hover { background: #f8fafc; color: var(--primary); }
        .dropdown-item.text-danger:hover { background: #fff1f2; color: var(--danger); }

        /* Content Area */
        .content-body { padding: 30px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; }
        
        /* Tables & Forms */
        .input-group { display: flex; flex-direction: column; gap: 8px; }
        .input-group label { font-size: 14px; font-weight: 600; color: #64748b; }
        .input-group input { padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; }
        .input-group input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(185, 143, 16, 0.1); }
        
        .btn-submit { background: var(--primary); color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; background: #f8fafc; padding: 16px 20px; color: #64748b; font-size: 14px; border-bottom: 1px solid #f1f5f9; }
        td { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; }

        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 30px; width: 400px; border-radius: 12px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand">🍳 Dapoer Tipes</div>
    <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> &nbsp; Dashboard</a>
    <a href="/kategori" class="active"><i class="fas fa-tags"></i> &nbsp; Kategori</a>
    <a href="/bahan"><i class="fas fa-box"></i> &nbsp; Bahan Dasar</a>
    <a href="/barang-masuk"><i class="fas fa-arrow-circle-down"></i> &nbsp; Barang Masuk</a>
    <a href="/barang-keluar"><i class="fas fa-arrow-circle-up"></i> &nbsp; Barang Keluar</a>
</div>

<div class="main">
    <nav class="navbar">
        <div class="nav-left">
            <h2 style="color: #b48f38ff;">Sistem Inventaris Bahan Baku</h2>
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
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 4px 0;">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <div class="dropdown-item text-danger" onclick="document.getElementById('logoutForm').submit()" style="cursor: pointer; color: #ef4444;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <div class="content-body">
        @if(session('success'))
            <div style="background: #F5FFFA; color: #2E8B57; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #2E8B57;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <h3 style="margin-bottom: 20px;">Tambah Kategori Baru</h3>
            <form action="/kategori/store" method="POST">
                @csrf
                <div class="input-group" style="max-width: 400px; margin-bottom: 20px;">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" placeholder="Contoh: Sayuran, Bumbu" required>
                </div>
                <button type="submit" class="btn-submit">Simpan Kategori</button>
            </form>
        </div>

        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 20px 25px; border-bottom: 1px solid #f1f5f9;">
                <h3>Daftar Kategori Aktif</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Kategori</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $k->nama_kategori }}</strong></td>
                        <td>
                            <div style="display: flex; gap: 15px;">
                                <button onclick="openEditModal('{{ $k->id }}', '{{ $k->nama_kategori }}')" style="color: #3b82f6; border:none; background:none; cursor:pointer;"><i class="fas fa-edit"></i></button>
                                <form action="/kategori/{{ $k->id }}" method="POST" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="color: #ef4444; border:none; background:none; cursor:pointer;"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-edit"></i> Edit Kategori</h3>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="input-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" id="edit_nama" required>
            </div>
            <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 10px;">
                <button type="submit" class="btn-submit" style="background: #3b82f6;">Update</button>
                <button type="button" onclick="closeModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 12px; border-radius: 8px; cursor: pointer;">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle Dropdown Profil
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    profileToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        profileMenu.classList.toggle('show');
    });

    // Close dropdown saat klik di luar
    window.addEventListener('click', () => {
        if (profileMenu.classList.contains('show')) {
            profileMenu.classList.remove('show');
        }
    });

    // Modal Edit Functions
    function openEditModal(id, nama) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('formEdit').action = '/kategori/' + id;
        document.getElementById('modalEdit').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalEdit').style.display = 'none';
    }

    // Close modal on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('modalEdit');
        if (event.target == modal) closeModal();
    }
</script>

</body>
</html>