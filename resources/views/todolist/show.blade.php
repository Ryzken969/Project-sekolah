<!DOCTYPE html>
<html>
<head>
    <title>Detail To-do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <h3 class="fw-bold mb-3">📄 Detail</h3>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5>{{ $list->judul }}</h5>
            <p class="text-muted">Deadline: {{ \Carbon\Carbon::parse($list->deadline)->format('d M Y') }}</p>
        </div>
    </div>

    {{-- Form tambah task --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('tasks.store') }}" method="POST" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="todolist_id" value="{{ $list->id }}">
                <input type="text" name="nama" class="form-control" placeholder="Tambah task..." required>
                <button class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    {{-- Daftar task --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="mb-3">Daftar Task</h6>

            @if($list->tasks->count() == 0)
                <p class="text-muted">Belum ada task.</p>
            @else
                <ul class="list-group">
                    @foreach($list->tasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $task->nama }}
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="mb-0">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">X</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif

            <a href="{{ route('todolist.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

</div>
</body>
</html>
