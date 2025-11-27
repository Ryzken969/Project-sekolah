<!DOCTYPE html>
<html>
<head>
    <title>Task Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h4>{{ $todolist->judul }}</h4>
    <p>Deadline: {{ $todolist->deadline }}</p>

    {{-- FORM TAMBAH TASK --}}
    <form method="POST" action="{{ route('task.store') }}">
        @csrf
        <input type="hidden" name="todolist_id" value="{{ $todolist->id }}">

        <div class="mb-3">
            <input type="text" class="form-control" name="nama" placeholder="Nama Task" required>
        </div>

        <button class="btn btn-primary">Save Task</button>
    </form>

    <hr>

    {{-- LIST TASK + EMPTY STATE --}}
    @if($todolist->tasks->count())
        @foreach($todolist->tasks as $task)
            <div class="d-flex justify-content-between align-items-center mt-2 border-bottom pb-2">
                <span>{{ $task->nama }}</span>

                <form method="POST" action="{{ route('task.destroy', $task->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">X</button>
                </form>
            </div>
        @endforeach
    @else
        <div class="text-center text-muted mt-4">
            <h5>No tasks found</h5>
            <p>Get started by creating your first task.</p>
        </div>
    @endif

    <a href="{{ route('todolist.index') }}" class="btn btn-secondary mt-3">End</a>

</div>

</body>
</html>
