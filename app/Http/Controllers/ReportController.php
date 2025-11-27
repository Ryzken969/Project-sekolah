<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $activeStats = $this->getActiveStats();

        $allStats = $this->getAllStats();

        $allTodos = Todo::where('user_id', Auth::id())
            ->withTrashed()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('report', compact('activeStats', 'allStats', 'allTodos'));
    }

    private function getActiveStats()
    {
        $todoCount = Todo::where('user_id', Auth::id())
            ->where('status', 'todo')
            ->whereNull('submitted_at')
            ->count();

        $doingCount = Todo::where('user_id', Auth::id())
            ->where('status', 'doing')
            ->whereNull('submitted_at')
            ->count();

        $doneCount = Todo::where('user_id', Auth::id())
            ->where('status', 'done')
            ->whereNull('submitted_at')
            ->count();

        $totalCount = Todo::where('user_id', Auth::id())
            ->whereNull('submitted_at')
            ->count();

        return [
            'todo' => $todoCount,
            'doing' => $doingCount,
            'done' => $doneCount,
            'total' => $totalCount,
        ];
    }

    private function getAllStats()
    {
        $todoCount = Todo::where('user_id', Auth::id())
            ->where('status', 'todo')
            ->withTrashed()
            ->count();

        $doingCount = Todo::where('user_id', Auth::id())
            ->where('status', 'doing')
            ->withTrashed()
            ->count();

        $doneCount = Todo::where('user_id', Auth::id())
            ->where('status', 'done')
            ->withTrashed()
            ->count();

        $submittedCount = Todo::where('user_id', Auth::id())
            ->whereNotNull('submitted_at')
            ->withTrashed()
            ->count();

        $totalCount = Todo::where('user_id', Auth::id())
            ->withTrashed()
            ->count();

        return [
            'todo' => $todoCount,
            'doing' => $doingCount,
            'done' => $doneCount,
            'submitted' => $submittedCount,
            'total' => $totalCount,
        ];
    }

    public function exportCSV()
    {
        $todos = Todo::where('user_id', Auth::id())
            ->withTrashed()
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'tasks-report-' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Employee Role', 'Title', 'Description', 'Status', 'Submitted', 'Created Date'];

        $callback = function () use ($todos, $columns) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($todos as $todo) {
                $row = [
                    $todo->employee_role ? ucfirst(str_replace('_', ' ', $todo->employee_role)) : 'No Role',
                    $todo->title,
                    $todo->description ?? '',
                    ucfirst($todo->status),
                    $todo->submitted_at ? 'Yes (' . $todo->submitted_at->format('Y-m-d') . ')' : 'No',
                    $todo->created_at->format('Y-m-d H:i:s')
                ];

                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
