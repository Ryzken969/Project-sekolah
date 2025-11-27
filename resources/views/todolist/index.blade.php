<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
            font-family: "Inter", sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e0e0e0;
            padding: 25px 20px;
        }

        .logo-row {
            text-align: center;
            margin-bottom: 25px;
        }

        /* ICON (style coding 2) */
        .logo-icon {
            width: 42px;
            opacity: 0.7;
            filter: grayscale(100%);
        }

        /* MENU */
        .menu-title {
            font-size: 13px;
            font-weight: 700;
            color: #9a9a9a;
            margin-bottom: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .menu-item {
            display: block;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 15px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
        }

        .menu-item.active {
            background: #f0f0f0;
        }

        .menu-item:hover {
            background: #f5f5f5;
        }

        /* MAIN CONTENT */
        .main-content {
            padding: 35px;
            width: 100%;
        }

        /* FIX BUTTON (no underline) */
        .btn-grey {
            background: #6c757d;
            color: #fff !important;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            text-decoration: none !important;
            display: inline-block;
        }

        /* FILTER CARD */
        .filter-card {
            background: #fff;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* EMPTY TASK */
        .task-empty-card {
            background: #fff;
            border-radius: 14px;
            padding: 70px 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .task-list-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

    </style>
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo-row">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" class="logo-icon">
        </div>

        <div class="menu-title">Menu</div>

        <a class="menu-item active" href="#">Dashboard</a>
        <a class="menu-item" href="#">My Task</a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- HEADER -->
        <div class="d-flex justify-content-end mb-4">
            <div class="text-end" style="margin-right: 10px;">
                <div class="fw-bold mb-1" style="font-size: 16px;">Demo User</div>

                <!-- spacing diperbaiki -->
                <a href="{{ route('todolist.create') }}" class="btn-grey mt-2">+ Create New Task</a>
            </div>
        </div>

        <!-- FILTER -->
        <div class="filter-card mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label>Status</label>
                    <select class="form-select">
                        <option>All Status</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Project</label>
                    <select class="form-select">
                        <option>All Projects</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Label</label>
                    <select class="form-select">
                        <option>All Labels</option>
                    </select>
                </div>

                <div class="col-md-3 d-grid">
                    <button class="btn btn-dark">Apply Filters</button>
                </div>
            </div>
        </div>

        <!-- TASK LIST -->
        @if($todolists->count() == 0)
            <div class="task-empty-card">
                <div style="font-size:60px;">📋</div>
                <h5 class="fw-bold mt-3">No tasks found</h5>
                <p class="text-muted">Get started by creating your first task.</p>

                <!-- Tombol tanpa garis bawah -->
                <a href="{{ route('todolist.create') }}" class="btn-grey mt-2">
                    + Create Your First Task
                </a>
            </div>
        @else
            <div class="task-list-card">
                @foreach($todolists as $list)
                    <div class="border-bottom py-3">
                        <strong>{{ $list->judul }}</strong>
                        <div class="text-muted small">Deadline: {{ $list->deadline }}</div>

                        <a href="{{ route('todolist.show', $list->id) }}" class="btn btn-sm btn-secondary mt-2">
                            Detail
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

</body>
</html>
