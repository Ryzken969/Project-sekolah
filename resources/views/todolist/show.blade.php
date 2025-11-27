<!DOCTYPE html>
<html>
<head>
    <title>Task Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h4>{{ $list->judul }}</h4>
    <p>Deadline: {{ $list->deadline }}</p>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="hidden" name="todolist_id" value="{{ $list->id }}">

        <div class="mb-3">
            <input type="text" class="form-control" name="nama" placeholder="Nama Task">
        </div>

        <button class="btn btn-primary">Save Task</button>
    </form>

    <hr>

    @foreach($list->tasks as $task)
        <div class="d-flex justify-content-between mt-2">
            <span>{{ $task->nama }}</span>
            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">X</button>
            </form>
        </div>
    @endforeach

    <a href="{{ route('todolist.index') }}" class="btn btn-secondary mt-3">End</a>
</div>

</body>
</html>
