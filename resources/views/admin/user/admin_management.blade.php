@extends('admin.main')

@section('content')
<style>
    /* Tombol dengan ukuran konsisten */
    .btn-action {
        padding: 6px 12px;  /* Lebih kecil paddingnya */
        font-size: 12px; /* Ukuran font lebih kecil */
        text-align: center;
        border-radius: 5px;
        margin: 5px 0;
        width: auto; /* Tombol menyesuaikan dengan ukuran teks */
    }
    
    /* Tombol untuk Superadmin */
    .btn-superadmin {
        background-color: #28a745; /* Hijau untuk Superadmin */
        border-color: #28a745;
    }
    
    .btn-superadmin:hover {
        background-color: #218838;
        border-color: #218838;
    }
    
    /* Tombol untuk Admin */
    .btn-admin {
        background-color: #007bff; /* Biru untuk Admin */
        border-color: #007bff;
    }
    
    .btn-admin:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    
    /* Tombol untuk menghapus Admin */
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #c82333;
    }
    
    /* Tombol dengan beberapa tombol dalam satu baris (Button group) */
    .btn-group {
        display: flex;
        gap: 5px;  /* Lebih sedikit ruang antar tombol */
        justify-content: flex-start;
        width: 100%;
    }
    
    /* Styling untuk tabel */
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    table th, table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    table th {
        background-color: #f8f9fa;
    }
    
    /* Modal styling */
    .modal-dialog {
        max-width: 600px;
    }
    
    /* Responsif untuk mobile */
    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
        }
        table th, table td {
            font-size: 12px;
            padding: 8px;
        }
        .btn-action {
            width: auto;
            padding: 8px;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Button to add new user -->
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addNewUser">Tambah User</button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row mt-4">
        <div class="col-lg-6 col-md-12">
            <div class="card shadow">
                <div class="card-header"><b>User</b></div>
                <div class="card-body">
                    <table id="dataTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }} <span class="badge bg-secondary">{{ $item->payment->count() }} Transaksi</span></td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>
                                    @if (Auth::user()->role == 2) <!-- Only Superadmin can see these buttons -->
                                        <div class="btn-group">
                                            <!-- Promote to Admin -->
                                            <form action="{{ route('user.promote', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-admin btn-sm btn-action">Jadikan Admin</button>
                                            </form>
                                            <!-- Promote to Superadmin -->
                                            <form action="{{ route('user.promoteToSuperAdmin', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-superadmin btn-sm btn-action">Jadikan Superadmin</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Admin Table -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow">
                <div class="card-header"><b>Admin</b></div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><b>{{ $item->name }}</b> ({{ $item->email }})</td>
                                <td>{{ $item->telepon }}</td>
                                <td>
                                    @if ($item->id != Auth::user()->id)
                                        <!-- Demote Admin -->
                                        <form action="{{ route('user.demote', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm btn-action">Cabut Admin</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Add New User -->
<div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.new') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-2">
                        <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nama" required>
                        <label for="floatingName">Nama Lengkap</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" name="telepon" class="form-control" id="floatingtelp" placeholder="Nomor Telepon" required>
                        <label for="floatingtelp">No Telepon</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-4">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
