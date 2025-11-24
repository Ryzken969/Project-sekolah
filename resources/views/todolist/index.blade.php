<!DOCTYPE html>
<html>
<head>
    <title>Daftar To-do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold">📋 Daftar To-do List</h3>
        <a href="{{ route('todolist.create') }}" class="btn btn-primary">+ Tambah Daftar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th width="60">ID</th>
                        <th>Judul</th>
                        <th>Deadline</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($todolist as $list)
                    <tr>
                        <td class="text-center">{{ $list->id }}</td>
                        <td>{{ $list->judul }}</td>
                        <td>{{ $list->deadline }}</td>
                        <td class="text-center">
                            <a href="{{ route('todolist.show', $list->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                            <a href="{{ route('todolist.edit', $list->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>

                            <form action="{{ route('todolist.destroy', $list->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus daftar ini?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada daftar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>
