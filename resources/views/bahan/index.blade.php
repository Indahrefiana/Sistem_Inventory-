<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Bahan Dasar - Dapoer Tipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --primary: #b98f10;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --danger: #ef4444;
            --edit: #3b82f6;
            --navbar-bg: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-light); display: flex; }

        .sidebar { width: 260px; background: var(--sidebar-bg); height: 100vh; color: white; position: fixed; padding: 20px 0; z-index: 1000; }
        .sidebar .brand { padding: 0 25px 30px; font-size: 22px; font-weight: bold; }
        .sidebar a { display: flex; align-items: center; padding: 12px 25px; color: #94a3b8; text-decoration: none; font-size: 15px; }
        .sidebar a:hover, .sidebar a.active { background: #334155; color: white; border-left: 4px solid var(--primary); }
        .sidebar i { width: 25px; }

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

        /* --- STYLING BARU UNTUK POP-UP PROFIL --- */
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
            display: none;
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
        /* --- AKHIR STYLING PROFIL --- */

        .main { margin-left: 260px; width: calc(100% - 260px); display: flex; flex-direction: column; }
        .content-body { padding: 30px; }
        
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; }
        
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; color: #64748b; font-size: 14px; }
        .input-group input { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; }
        
        .btn-submit { background: var(--primary); color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 10px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; background: #f1f5f9; padding: 12px; color: #64748b; font-size: 13px; }
        td { padding: 12px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        
        .success-msg { background: #F5FFFA; color: #2E8B57; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #2E8B57; }

        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 10% auto; padding: 30px; width: 40%; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .modal-header { margin-bottom: 20px; font-size: 18px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 10px; }
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
            @if(session('success'))
                <div class="success-msg"><i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <h3 style="margin-bottom: 15px;">Tambah Data</h3>
                <form action="{{ route('bahan.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Nama Bahan</label>
                            <input type="text" name="nama_bahan" placeholder="Garam, Tepung, dll" required>
                        </div>
                        <div class="input-group">
                            <label>Kategori ID</label>
                            <input type="number" name="kategori_id" placeholder="1" required>
                        </div>
                        <div class="input-group">
                            <label>Satuan (ID)</label>
                            <input type="number" name="satuan" placeholder="1" required>
                        </div>
                        <div class="input-group">
                            <label>Total Stok</label>
                            <input type="number" name="stok" placeholder="50" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Simpan Data</button>
                </form>
            </div>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kat</th>
                            <th>Sat</th>
                            <th>Min (Auto)</th>
                            <th>Skrg (Auto)</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bahan as $b)
                        <tr>
                            <td><strong>{{ $b->nama_bahan }}</strong></td>
                            <td>{{ $b->kategori_id }}</td>
                            <td>{{ $b->satuan }}</td>
                            <td>{{ $b->stok_minimal }}</td>
                            <td>{{ $b->stok_sekarang }}</td>
                            <td>{{ $b->stok }}</td>
                            <td>
                                <div style="display: flex; gap: 15px;">
                                    <button onclick="openEditModal({{ json_encode($b) }})" style="color: #3b82f6; border:none; background:none; cursor:pointer;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="/bahan/{{ $b->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="color: #ef4444; border:none; background:none; cursor:pointer;" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">Data masih kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <div class="modal-header">Edit Bahan Dasar</div>
            <form id="formEdit" method="POST">
                @csrf @method('PUT')
                <div class="input-group">
                    <label>Nama Bahan</label>
                    <input type="text" name="nama_bahan" id="edit_nama" required>
                </div>
                <div class="input-group">
                    <label>Kategori ID</label>
                    <input type="number" name="kategori_id" id="edit_kategori" required>
                </div>
                <div class="input-group">
                    <label>Satuan (ID)</label>
                    <input type="number" name="satuan" id="edit_satuan" required>
                </div>
                <div class="input-group">
                    <label>Total Stok</label>
                    <input type="number" name="stok" id="edit_stok" required>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-submit" style="flex: 2;">Update Data</button>
                    <button type="button" onclick="closeModal()" class="btn-submit" style="flex: 1; background: #64748b;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Logika Dropdown Profil
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');

        profileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
        });

        // Logika Modal Edit
        function openEditModal(data) {
            document.getElementById('edit_nama').value = data.nama_bahan;
            document.getElementById('edit_kategori').value = data.kategori_id;
            document.getElementById('edit_satuan').value = data.satuan;
            document.getElementById('edit_stok').value = data.stok;
            document.getElementById('formEdit').action = '/bahan/' + data.id;
            document.getElementById('modalEdit').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modalEdit').style.display = 'none';
        }

        // Close dropdown/modal saat klik di luar area
        window.onclick = function(event) {
            // Close Modal
            let modal = document.getElementById('modalEdit');
            if (event.target == modal) { closeModal(); }
            
            // Close Dropdown
            if (!event.target.closest('#profileToggle')) {
                if (profileMenu.classList.contains('show')) {
                    profileMenu.classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>