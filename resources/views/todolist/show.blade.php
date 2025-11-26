<!DOCTYPE html>
<html>
<head>
    <title>Detail To-do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="fw-bold mb-4">📄 Detail To-do List</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <h4>{{ $list->judul }}</h4>
            <p class="text-muted">Deadline: <strong>{{ $list->deadline }}</strong></p>

            <hr>

            {{-- FORM TAMBAH TASK --}}
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="todolist_id" value="{{ $list->id }}">

                <div class="input-group mb-3">
                    <input type="text" name="nama" class="form-control" placeholder="Tambah task" required>
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>

            {{-- DAFTAR TASK --}}
            <h5 class="fw-bold">Daftar Task</h5>

            @if($list->tasks->count() == 0)
                <p class="text-muted">Belum ada task.</p>
            @else
                <ul class="list-group mb-3">
                    @foreach($list->tasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $task->nama }}

                            <div>
                                <span class="badge {{ $task->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $task->status ? 'Selesai' : 'Belum' }}
                                </span>

                                <form action="{{ route('tasks.destroy', $task->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm ms-2">X</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <a href="{{ route('todolist.index') }}" class="btn btn-secondary">⬅ Kembali</a>

        </div>
    </div>

</div>

</body>
</html>
