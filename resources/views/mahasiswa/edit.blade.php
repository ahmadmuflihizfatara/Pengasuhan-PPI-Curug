<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

        .db-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Main */
        .main-content { flex:1; padding:28px 30px; }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #888;
            margin-bottom: 20px;
        }
        .breadcrumb a { color: #5a67d8; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        /* Card */
        .edit-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            max-width: 860px;
        }

        .edit-card-header {
            background: linear-gradient(135deg, #5a67d8, #9f7aea);
            padding: 28px 32px;
            color: white;
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .student-avatar {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }
        .edit-card-header h2 { margin: 0 0 4px 0; font-size: 20px; font-weight: 700; }
        .edit-card-header p { margin: 0; opacity: .8; font-size: 13px; }

        .edit-body { padding: 32px; }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #aab;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0f2f7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 28px;
        }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1/-1; }

        label { font-size: 12px; font-weight: 600; color: #555; }

        .form-control {
            padding: 10px 14px;
            border: 2px solid #e8ebf5;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #333;
            outline: none;
            transition: border .15s;
            background: #fafbff;
        }
        .form-control:focus { border-color: #5a67d8; background: white; }
        .form-control[readonly] { background: #f5f6fa; color: #888; cursor: not-allowed; }

        .input-prefix-wrapper {
            display: flex;
            align-items: center;
            border: 2px solid #e8ebf5;
            border-radius: 10px;
            overflow: hidden;
            background: #fafbff;
            transition: border .15s;
        }
        .input-prefix-wrapper:focus-within { border-color: #5a67d8; background: white; }
        .input-prefix {
            padding: 10px 12px;
            background: #f0f2f9;
            font-size: 12px;
            font-weight: 600;
            color: #777;
            white-space: nowrap;
            border-right: 2px solid #e8ebf5;
        }
        .input-prefix-wrapper .form-control {
            border: none;
            border-radius: 0;
            background: transparent;
        }
        .input-prefix-wrapper .form-control:focus { border: none; background: transparent; }

        .info-box {
            background: #f0f3ff;
            border: 1px solid #d0d9f5;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 12.5px;
            color: #5a67d8;
            margin-bottom: 24px;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .btn-row {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 16px;
            border-top: 1px solid #f0f2f7;
        }
        .btn-primary {
            background: linear-gradient(135deg, #5a67d8, #9f7aea);
            color: white;
            border: none;
            padding: 11px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: opacity .15s;
        }
        .btn-primary:hover { opacity: .85; }
        .btn-secondary {
            background: white;
            color: #555;
            border: 2px solid #e8ebf5;
            padding: 11px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: border .15s;
        }
        .btn-secondary:hover { border-color: #5a67d8; color: #5a67d8; }

        .alert-success {
            background: #e6f9f0;
            border: 1px solid #a0e4c0;
            color: #1e7a4c;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 8px;
            align-items: center;
            font-size: 13px;
        }
        .alert-error {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-size: 13px;
        }
        .class-pill {
            background: #eef0ff;
            color: #5a67d8;
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>

    <div class="db-layout">
        <!-- Sidebar -->
        <x-sidebar active="mahasiswa" />

        <!-- Main -->
        <div class="main-content">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('mahasiswa.index') }}"><i class="fas fa-users"></i> Database Mahasiswa</a>
                <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                <span>Edit Biodata</span>
                <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                <strong style="color:#333;">{{ $student->nama }}</strong>
            </div>

            @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="edit-card">
                <!-- Card Header -->
                <div class="edit-card-header">
                    <div class="student-avatar">
                        {{ strtoupper(substr($student->nickname ?: $student->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h2>{{ $student->nama }}</h2>
                        <p>
                            NPM: {{ $student->npm ?? '-' }} &nbsp;|&nbsp;
                            <span class="class-pill" style="background:rgba(255,255,255,.25); color:white;">{{ $student->kelas ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="edit-body">
                    <div class="info-box">
                        <i class="fas fa-info-circle" style="margin-top:1px;"></i>
                        <span>Data yang ditampilkan di bawah adalah informasi biodata dan akun mahasiswa. Field yang berwarna abu-abu bersifat <strong>read-only</strong> (tidak dapat diubah secara manual).</span>
                    </div>

                    <form method="POST" action="{{ route('mahasiswa.update', $student) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Biodata Section -->
                        <div class="section-title"><i class="fas fa-id-card"></i> &nbsp;Biodata Mahasiswa</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>NPM</label>
                                <input type="text" class="form-control" value="{{ $student->npm ?? '-' }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" value="{{ $student->kelas ?? '-' }}" readonly>
                            </div>
                            <div class="form-group full">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $student->nama) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nickname / Panggilan</label>
                                <input type="text" name="nickname" class="form-control" value="{{ old('nickname', $student->nickname) }}">
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Program Studi</label>
                                <select name="prodi" class="form-control" required>
                                    @foreach(\App\Models\Mahasiswa::PRODI as $kode => $info)
                                    <option value="{{ $kode }}" {{ old('prodi', $student->prodi) === $kode ? 'selected' : '' }}>
                                        {{ $kode }} — {{ $info['nama'] }} ({{ $info['jenjang'] }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tingkat</label>
                                <select name="tingkat" class="form-control" required>
                                    @for($t = 1; $t <= 4; $t++)
                                    <option value="{{ $t }}" {{ (string) old('tingkat', $student->tingkat) === (string) $t ? 'selected' : '' }}>
                                        Tingkat {{ $t }}
                                    </option>
                                    @endfor
                                </select>
                                <span style="font-size:11px; color:#aab;">D-3 hanya sampai tingkat 3.</span>
                            </div>
                        </div>

                        <!-- Akun Section -->
                        <div class="section-title"><i class="fas fa-user-circle"></i> &nbsp;Informasi Akun</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Username</label>
                                <div class="input-prefix-wrapper">
                                    <span class="input-prefix"><i class="fas fa-at"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->user->username ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="form-group full">
                                <label>Email Akun</label>
                                <div class="input-prefix-wrapper">
                                    <span class="input-prefix"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $student->user->email ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="btn-row">
                            <a href="{{ route('mahasiswa.index') }}" class="btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
