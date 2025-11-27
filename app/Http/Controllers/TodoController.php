<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todoItems = Todo::where('user_id', Auth::id())
            ->where('status', 'todo')
            ->orderBy('created_at', 'desc')
            ->get();

        $doingItems = Todo::where('user_id', Auth::id())
            ->where('status', 'doing')
            ->orderBy('created_at', 'desc')
            ->get();

        $doneItems = Todo::where('user_id', Auth::id())
            ->where('status', 'done')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('todoItems', 'doingItems', 'doneItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_roles' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $roles = json_decode($request->employee_roles, true);

        if (empty($roles) || !is_array($roles)) {
            return redirect()->back()->withErrors(['employee_roles' => 'At least one role is required.']);
        }

        $primaryRole = $roles[0];

        Todo::create([
            'user_id' => Auth::id(),
            'employee_role' => $primaryRole,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'todo',
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);

        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'employee_roles' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $roles = json_decode($request->employee_roles, true);

        if (empty($roles) || !is_array($roles)) {
            return redirect()->back()->withErrors(['employee_roles' => 'At least one role is required.']);
        }

        $primaryRole = $roles[0];

        $todo->update([
            'employee_role' => $primaryRole,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $todo = Todo::findOrFail($id);

            if ($todo->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized'
                ], 403);
            }

            $request->validate([
                'status' => 'required|in:todo,doing,done'
            ]);

            $todo->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Update status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);

        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todo->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
    }

    public function submitSelected(Request $request)
    {
        try {
            \Log::info('Submit selected todos request:', $request->all());

            $request->validate([
                'todo_ids' => 'required|array',
                'todo_ids.*' => 'required|integer'
            ]);

            $todoIds = $request->todo_ids;
            $userId = Auth::id();

            \Log::info('User ID: ' . $userId . ', Todo IDs: ' . implode(',', $todoIds));

            $deletedCount = Todo::where('user_id', $userId)
                ->whereIn('id', $todoIds)
                ->where('status', 'done')
                ->delete();

            \Log::info('Successfully submitted (soft deleted): ' . $deletedCount . ' todos');

            return response()->json([
                'success' => true,
                'message' => 'Todos submitted successfully',
                'deleted_count' => $deletedCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Submit todos error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableRoles()
    {
        $roles = Todo::where('user_id', Auth::id())
            ->whereNotNull('employee_role')
            ->where('employee_role', '!=', '')
            ->distinct()
            ->pluck('employee_role')
            ->toArray();

        return response()->json([
            'roles' => $roles
        ]);
    }
}
