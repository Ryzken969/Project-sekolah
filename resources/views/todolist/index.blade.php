<!DOCTYPE html>
<html>
<head>
    <title>Daftar To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📋 Daftar To-Do List</h3>
        <a href="{{ route('todolist.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($lists->count() == 0)
        <div class="card">
            <div class="card-body text-center text-muted">Belum ada daftar</div>
        </div>
    @else
        <div class="row g-3">
            @foreach($lists as $list)
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $list->judul }}</h5>
                            <p class="card-text text-muted mb-2">
                                Deadline: {{ \Carbon\Carbon::parse($list->deadline)->format('d M Y') }}
                            </p>

                            <a href="{{ route('todolist.show', $list->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('todolist.edit', $list->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('todolist.destroy', $list->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus daftar ini?')"
                                    class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

</body>
</html>
