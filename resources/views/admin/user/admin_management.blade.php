@extends('admin.main')

@section('content')
<style>
    /* Tombol dengan ukuran konsisten */
    .btn-action {
        padding: 8px 16px;  /* Padding lebih besar agar tombol lebih mudah diklik */
        font-size: 14px;
        text-align: center;
        border-radius: 5px;
        margin: 5px 0;
        width: 100%; /* Tombol mengisi lebar yang tersedia dalam grup */
    }

    /* Tombol dengan titik tiga (ellipsis) */
    .btn-ellipsis {
        background-color: transparent; /* Tanpa latar belakang */
        border: none;
        color: #6c757d;
        font-size: 20px;
        padding: 0;
    }

    .btn-ellipsis:hover {
        color: #0056b3;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        min-width: 220px;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 5px;
    }

    .dropdown-item:hover {
        background-color: #f1f1f1;
    }

    /* Warna untuk pilihan Dropdown */
    .btn-admin {
        background-color: #007bff; /* Biru untuk Admin */
        border-color: #007bff;
        color: white;
    }

    .btn-admin:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-superadmin {
        background-color: #28a745; /* Hijau untuk Superadmin */
        border-color: #28a745;
        color: white;
    }

    .btn-superadmin:hover {
        background-color: #218838;
        border-color: #218838;
    }

    .btn-delete {
        background-color: #dc3545; /* Merah untuk Hapus User */
        border-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
        border-color: #c82333;
    }

    /* Styling untuk tabel */
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    table th, table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    table tbody tr:hover {
        background-color: #f1f1f1;
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
                                        <div class="dropdown">
                                            <!-- Tombol dengan titik tiga (ellipsis) -->
                                            <button class="btn btn-ellipsis btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                ...
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <form action="{{ route('user.promote', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item btn btn-admin btn-sm">Jadikan Admin</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('user.promoteToSuperAdmin', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item btn btn-superadmin btn-sm">Jadikan Superadmin</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('user.destroy', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item btn btn-delete btn-sm">Hapus User</button>
                                                    </form>
                                                </li>
                                            </ul>
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
