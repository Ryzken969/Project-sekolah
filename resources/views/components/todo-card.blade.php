<div class="todo-card bg-white dark:bg-gray-700 rounded-lg shadow-sm p-4 cursor-move transition-all duration-300 border-l-4 hover:shadow-md border border-gray-200 dark:border-gray-600 group
    @if ($todo->status === 'todo') border-l-gray-500
    @elseif($todo->status === 'doing') border-l-blue-500
    @else border-l-green-500 @endif"
    data-todo-id="{{ $todo->id }}" data-status="{{ $todo->status }}">

    <div class="flex justify-between items-start mb-2">
        <div class="flex-1 mr-2">
            <div class="flex items-center gap-2 mb-1">
                <span
                    class="inline-block bg-purple-100 dark:bg-purple-800 text-purple-600 dark:text-purple-300 text-xs px-2 py-1 rounded-full font-medium">
                    {{ $todo->employee_role ? ucfirst(str_replace('_', ' ', $todo->employee_role)) : 'No Role' }}
                </span>
            </div>
            <h5 class="todo-title font-semibold text-gray-900 dark:text-white text-sm leading-tight mb-1">
                {{ $todo->title }}
            </h5>
        </div>
        <div class="relative todo-menu shrink-0 ml-2">
            <button onclick="toggleMenu(this)"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1 rounded transition-colors duration-200"
                aria-label="Task options">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
            </button>
            <div
                class="todo-menu-content absolute right-0 mt-1 w-36 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 hidden z-20 border border-gray-200 dark:border-gray-700">
                <button
                    onclick="openEditModal({
                    id: {{ $todo->id }},
                    title: `{{ addslashes($todo->title) }}`,
                    description: `{{ addslashes($todo->description ?? '') }}`
                })"
                    class="flex items-center w-full text-left px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </button>

                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="inline w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Kamu yakin nih mau ngehapus tugasnya?')"
                        class="flex items-center w-full text-left px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if ($todo->description)
        <p class="todo-description text-xs text-gray-600 dark:text-gray-400 mb-2 leading-relaxed line-clamp-2">
            {{ $todo->description }}
        </p>
    @endif

    <div class="flex justify-between items-center text-xs mt-2">
        <span class="text-gray-500 dark:text-gray-400 flex items-center">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $todo->created_at->format('M j, Y') }}
        </span>
        <span
            class="status-badge capitalize px-2 py-1 rounded-full text-xs font-medium
            @if ($todo->status === 'todo') bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300
            @elseif($todo->status === 'doing') bg-blue-200 dark:bg-blue-600 text-blue-700 dark:text-blue-300
            @else bg-green-200 dark:bg-green-600 text-green-700 dark:text-green-300 @endif">
            {{ $todo->status }}
        </span>
    </div>
</div>

@if ($loop->first)
    <script>
        function toggleMenu(button) {
            const menu = button.nextElementSibling;
            const isHidden = menu.classList.contains('hidden');

            document.querySelectorAll('.todo-menu-content').forEach(otherMenu => {
                if (otherMenu !== menu) {
                    otherMenu.classList.add('hidden');
                }
            });

            if (isHidden) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.todo-menu')) {
                document.querySelectorAll('.todo-menu-content').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
    </script>
@endif
