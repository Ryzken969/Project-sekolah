<!DOCTYPE html>
<html>
<head>
    <title>My Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold">Dashboard</a>
        <a href="{{ route('todolist.index') }}" class="nav-link">My Task</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h4>My Tasks</h4>
        <a href="{{ route('todolist.create') }}" class="btn btn-primary">+ Create New Task</a>
    </div>

    @if($lists->count() == 0)
        <div class="text-center mt-5">
            <h5>No tasks found</h5>
            <p>Get started by creating your first task.</p>
            <a href="{{ route('todolist.create') }}" class="btn btn-primary">+ Create Your First Task</a>
        </div>
    @else
        @foreach($lists as $list)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $list->judul }}</h5>
                    <p class="text-muted">Deadline: {{ $list->deadline }}</p>
                    <a href="{{ route('todolist.show', $list->id) }}" class="btn btn-info btn-sm">Detail</a>
                </div>
            </div>
        @endforeach
    @endif
</div>

</body>
</html>
