<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang Keluar - Dapoer Tipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-bg: #1e293b; 
            --primary: #b98f10; 
            --bg-light: #f8fafc; 
            --text-dark: #1e293b; 
            --table-header-text: #64748b;
            --navbar-bg: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-light); display: flex; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar-bg); height: 100vh; color: white; position: fixed; padding: 20px 0; z-index: 1000; }
        .sidebar .brand { padding: 0 25px 30px; font-size: 22px; font-weight: bold; }
        .sidebar a { display: flex; align-items: center; padding: 12px 25px; color: #94a3b8; text-decoration: none; }
        .sidebar a.active { background: #334155; color: white; border-left: 4px solid var(--primary); }
        
        /* Navbar Styling */
        .navbar {
            background: var(--navbar-bg);
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* --- PROFILE POP-UP STYLING (Sama dengan Dashboard) --- */
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

        .user-profile:hover { opacity: 0.8; }

        .profile-info {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .profile-info .greeting { font-size: 12px; color: #64748b; line-height: 1; }
        .profile-info .user-name { font-size: 14px; font-weight: 700; color: var(--text-dark); }

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

        .dropdown-item:hover { background: #f1f5f9; color: var(--primary); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* --- END PROFILE POP-UP --- */

        /* Main Layout */
        .main { margin-left: 260px; width: 100%; min-height: 100vh; }
        .content-body { padding: 30px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; }
        
        /* Form & Table Styles */
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .input-group { display: flex; flex-direction: column; gap: 8px; }
        .input-group label { font-size: 14px; font-weight: 600; }
        .input-group input, .input-group select { padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; }
        .btn-submit { background: #b98f10; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.2s; }
        .btn-submit:hover { opacity: 0.9; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background-color: #f8fafc; }
        th { padding: 16px 20px; text-align: left; color: var(--table-header-text); font-size: 15px; font-weight: 600; border-bottom: 1px solid #f1f5f9; }
        td { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 14px; }
        .text-danger { color: #e11d48; font-weight: bold; }
        
        /* Modal Styling */
        .modal { display: none; position: fixed; z-index: 1100; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 30px; border-radius: 12px; width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">🍳 Dapoer Tipes</div>
        <a href="{{ route('dashboard') }}"><i class="fas fa-chart-line"></i> &nbsp; Dashboard</a>
        <a href="/kategori"><i class="fas fa-tags"></i> &nbsp; Kategori</a>
        <a href="/bahan"><i class="fas fa-box"></i> &nbsp; Bahan Dasar</a>
        <a href="/barang-masuk"><i class="fas fa-arrow-circle-down"></i> &nbsp; Barang Masuk</a>
        <a href="/barang-keluar" class="active"><i class="fas fa-arrow-circle-up"></i> &nbsp; Barang Keluar</a>
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
            <div class="card">
                <h3 style="margin-bottom: 15px;">Tambah Barang Keluar</h3>
                <form action="{{ route('barang-keluar.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Pilih Bahan</label>
                            <select name="bahan_id" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($bahan as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Jumlah Keluar</label>
                            <input type="number" name="jumlah_keluar" placeholder="Contoh: 10" required>
                        </div>
                        <div class="input-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" placeholder="Contoh: Digunakan untuk masak">
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Simpan Barang Keluar</button>
                </form>
            </div>

            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="padding: 20px 25px;">
                    <h3>Riwayat Barang Keluar</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Bahan</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangKeluar as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                            <td>{{ $item->nama_bahan }}</td>
                            <td class="text-danger">- {{ number_format($item->jumlah_keluar, 0, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                <div style="display: flex; gap: 15px;">
                                    <button onclick="openEditModal({{ json_encode($item) }})" style="color: #3b82f6; border:none; background:none; cursor:pointer;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('barang-keluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="color: #ef4444; border:none; background:none; cursor:pointer;" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3 style="margin-bottom: 20px;">Edit Barang Keluar</h3>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="input-group">
                    <label>Bahan</label>
                    <select name="bahan_id" id="edit_bahan_id">
                        @foreach($bahan as $b) 
                            <option value="{{ $b->id }}">{{ $b->nama_bahan }}</option> 
                        @endforeach
                    </select>
                </div><br>
                <div class="input-group">
                    <label>Jumlah Keluar</label>
                    <input type="number" name="jumlah_keluar" id="edit_jumlah_keluar">
                </div><br>
                <div class="input-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" id="edit_keterangan">
                </div><br>
                <button type="submit" class="btn-submit" style="width: 100%; background: #3b82f6;">Update Data</button>
                <button type="button" onclick="closeModal()" style="width: 100%; margin-top:10px; background:#f1f5f9; color: #475569; border:none; padding:10px; border-radius:8px; cursor:pointer; font-weight: 600;">Batal</button>
            </form>
        </div>
    </div>

    <script>
        /* Logic Profile Dropdown (Sesuai Dashboard) */
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');

        profileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
        });

        /* Logic Edit Modal Barang Keluar */
        function openEditModal(item) {
            document.getElementById('editForm').action = '/barang-keluar/' + item.id;
            document.getElementById('edit_bahan_id').value = item.bahan_id;
            document.getElementById('edit_jumlah_keluar').value = item.jumlah_keluar;
            document.getElementById('edit_keterangan').value = item.keterangan || '';
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeModal() { 
            document.getElementById('editModal').style.display = 'none'; 
        }

        /* Close everything when clicking outside */
        window.onclick = function(event) {
            // Close Profile Menu
            if (profileMenu.classList.contains('show')) {
                profileMenu.classList.remove('show');
            }
            // Close Edit Modal
            let modal = document.getElementById('editModal');
            if (event.target == modal) closeModal();
        }
    </script>
</body>
</html>