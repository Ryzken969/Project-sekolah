<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tasks Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .stats {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
        }

        .submitted {
            color: #10b981;
        }

        .not-submitted {
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Tasks Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
        <p>User: {{ $user->name }}</p>
    </div>

    <div class="stats">
        <h3>Statistics</h3>
        <p>Total Tasks: {{ $stats['total'] }}</p>
        <p>Todo: {{ $stats['todo'] }} | Doing: {{ $stats['doing'] }} | Done: {{ $stats['done'] }}</p>
        <p>Submitted: {{ $stats['submitted'] }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todos as $todo)
                <tr>
                    <td>{{ $todo->title }}</td>
                    <td>{{ $todo->description ?? '-' }}</td>
                    <td>{{ ucfirst($todo->status) }}</td>
                    <td class="{{ $todo->submitted_at ? 'submitted' : 'not-submitted' }}">
                        {{ $todo->submitted_at ? 'Yes (' . $todo->submitted_at->format('M j, Y') . ')' : 'No' }}
                    </td>
                    <td>{{ $todo->created_at->format('M j, Y') }}</td>
                    <td>{{ $todo->updated_at->format('M j, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
