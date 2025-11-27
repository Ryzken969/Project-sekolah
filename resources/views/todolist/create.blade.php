<!DOCTYPE html>
<html>
<head>
    <title>Create List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h4>Create List</h4>

    <form method="POST" action="{{ route('todolist.store') }}">
        @csrf
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" class="form-control" name="judul">
        </div>

        <div class="mb-3">
            <label>Deadline</label>
            <input type="date" class="form-control" name="deadline">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('todolist.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
