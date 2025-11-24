<!DOCTYPE html>
<html>
<head>
    <title>Tambah To-do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="fw-bold mb-4">➕ Tambah To-do List</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('todolist.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('todolist.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
