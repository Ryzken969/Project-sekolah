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

            <h5 class="fw-bold">Daftar Task</h5>

            @if($list->tasks->count() == 0)
                <p class="text-muted">Belum ada task.</p>
            @else
                <ul class="list-group">
                    @foreach($list->tasks as $task)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $task->nama }}

                            <span class="badge {{ $task->status ? 'bg-success' : 'bg-secondary' }}">
                                {{ $task->status ? 'Selesai' : 'Belum' }}
                            </span>
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
