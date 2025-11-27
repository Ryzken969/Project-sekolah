<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tasks {{ Auth::user()->name }}</h3>
                <button onclick="openAddModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                    + Add Task
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Todo</h4>
                        <span
                            class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-full text-sm counter-todo">
                            {{ $todoItems->count() }}
                        </span>
                    </div>
                    <div id="todo-column" class="space-y-3 min-h-[200px] todo-column" data-status="todo">
                        @forelse($todoItems as $todo)
                            @include('components.todo-card', ['todo' => $todo])
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p>No tasks in Todo</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Doing</h4>
                        <span
                            class="bg-blue-200 dark:bg-blue-700 text-blue-600 dark:text-blue-300 px-2 py-1 rounded-full text-sm counter-doing">
                            {{ $doingItems->count() }}
                        </span>
                    </div>
                    <div id="doing-column" class="space-y-3 min-h-[200px] todo-column" data-status="doing">
                        @forelse($doingItems as $todo)
                            @include('components.todo-card', ['todo' => $todo])
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <p>No tasks in Progress</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Done</h4>
                        <div class="flex items-center space-x-2">
                            <span
                                class="bg-green-200 dark:bg-green-700 text-green-600 dark:text-green-300 px-2 py-1 rounded-full text-sm counter-done">
                                {{ $doneItems->count() }}
                            </span>
                            @if ($doneItems->count() > 0)
                                <button onclick="openSubmitModal()"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Submit
                                </button>
                            @endif
                        </div>
                    </div>
                    <div id="done-column" class="space-y-3 min-h-[200px] todo-column" data-status="done">
                        @forelse($doneItems as $todo)
                            @include('components.todo-card', ['todo' => $todo])
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p>No completed tasks</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-4">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Add New Task</h3>

            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Manage List</h4>
                    <button type="button" onclick="openAddRoleModal()"
                        class="text-xs bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded transition duration-200">
                        + Add List
                    </button>
                </div>

                <div id="selectedRoles" class="flex flex-wrap gap-2 mb-3 min-h-8">
                    <span class="text-xs text-gray-500 dark:text-gray-400">No list added</span>
                </div>

                <div id="roleValidation" class="text-xs text-red-600 dark:text-red-400 hidden">
                    Tambahkan setidaknya satu list tugas
                </div>
            </div>

            <form id="taskForm" method="POST">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">
                <input type="hidden" id="todoId" name="id">
                <input type="hidden" id="selected_employee_roles" name="employee_roles">

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Task Title *
                    </label>
                    <input type="text" id="title" name="title" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="Enter task title">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3" placeholder="Enter task description (optional)"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" disabled
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-400 rounded-md transition duration-200 cursor-not-allowed">
                        Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="addRoleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Add New List</h3>

            <div class="mb-4">
                <label for="newRoleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    List Name *
                </label>
                <input type="text" id="newRoleName"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Enter list name (e.g., PPLG )">
                <div id="roleError" class="text-xs text-red-600 dark:text-red-400 mt-1 hidden"></div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeAddRoleModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                    Cancel
                </button>
                <button type="button" onclick="addNewRole()"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition duration-200">
                    Add List
                </button>
            </div>
        </div>
    </div>

    <div id="submitModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Selesaikan Todo</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pilih todo yang sudah selesai untuk disubmit:</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">"kalo tombol submit tidak muncul, refresh
                halaman setelah tugas update status ke selesai agar tombol submit muncul"</p>

            <div id="submitTodoList" class="max-h-60 overflow-y-auto mb-4">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeSubmitModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                    Batal
                </button>
                <button type="button" onclick="submitSelectedTodos()"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition duration-200">
                    Submit
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            console.log('Todo app scripts loaded');

            let customRoles = [];

            function openAddModal() {
                console.log('Opening add modal');
                document.getElementById('modalTitle').textContent = 'Add New Task';
                document.getElementById('taskForm').action = "{{ route('todos.store') }}";
                document.getElementById('formMethod').value = 'POST';

                document.getElementById('title').value = '';
                document.getElementById('description').value = '';
                document.getElementById('todoId').value = '';

                customRoles = [];
                updateSelectedRolesDisplay();
                updateSubmitButtonState();

                document.getElementById('taskModal').classList.remove('hidden');

                setTimeout(() => {
                    document.getElementById('title').focus();
                }, 100);
            }

            function openEditModal(todo) {
                console.log('Opening edit modal for todo:', todo);

                if (!todo || !todo.id) {
                    console.error('Invalid todo object:', todo);
                    alert('Error: Cannot edit this task');
                    return;
                }

                document.getElementById('modalTitle').textContent = 'Edit Task';

                const updateUrl = "/todos/" + todo.id;
                console.log('Update URL:', updateUrl);

                document.getElementById('taskForm').action = updateUrl;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('title').value = todo.title || '';
                document.getElementById('description').value = todo.description || '';
                document.getElementById('todoId').value = todo.id;

                customRoles = todo.employee_role ? [todo.employee_role] : [];
                updateSelectedRolesDisplay();
                updateSubmitButtonState();

                document.getElementById('submitBtn').innerHTML = 'Update Task';
                document.getElementById('taskModal').classList.remove('hidden');

                setTimeout(() => {
                    document.getElementById('title').focus();
                }, 100);
            }

            function closeModal() {
                document.getElementById('taskModal').classList.add('hidden');
            }

            function openAddRoleModal() {
                document.getElementById('newRoleName').value = '';
                document.getElementById('roleError').classList.add('hidden');
                document.getElementById('addRoleModal').classList.remove('hidden');

                setTimeout(() => {
                    document.getElementById('newRoleName').focus();
                }, 100);
            }

            function closeAddRoleModal() {
                document.getElementById('addRoleModal').classList.add('hidden');
            }

            function addNewRole() {
                const roleName = document.getElementById('newRoleName').value.trim();
                const roleError = document.getElementById('roleError');

                if (!roleName) {
                    roleError.textContent = 'Role name is required';
                    roleError.classList.remove('hidden');
                    return;
                }

                if (customRoles.includes(roleName)) {
                    roleError.textContent = 'This role already exists';
                    roleError.classList.remove('hidden');
                    return;
                }

                customRoles.push(roleName);
                updateSelectedRolesDisplay();
                updateSubmitButtonState();
                closeAddRoleModal();
            }

            function removeRole(roleName) {
                customRoles = customRoles.filter(role => role !== roleName);
                updateSelectedRolesDisplay();
                updateSubmitButtonState();
            }

            function updateSelectedRolesDisplay() {
                const selectedRolesContainer = document.getElementById('selectedRoles');
                const roleValidation = document.getElementById('roleValidation');

                if (customRoles.length === 0) {
                    selectedRolesContainer.innerHTML =
                        '<span class="text-xs text-gray-500 dark:text-gray-400">No List added</span>';
                    roleValidation.classList.remove('hidden');
                } else {
                    selectedRolesContainer.innerHTML = '';
                    customRoles.forEach(role => {
                        const roleBadge = document.createElement('span');
                        roleBadge.className =
                            'inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 text-xs rounded-full';
                        roleBadge.innerHTML = `
                        ${role}
                        <button type="button" onclick="removeRole('${role}')" class="ml-1 text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-100">
                            ×
                        </button>
                    `;
                        selectedRolesContainer.appendChild(roleBadge);
                    });
                    roleValidation.classList.add('hidden');
                }

                document.getElementById('selected_employee_roles').value = JSON.stringify(customRoles);
            }

            function updateSubmitButtonState() {
                const submitBtn = document.getElementById('submitBtn');
                const hasRoles = customRoles.length > 0;
                const hasTitle = document.getElementById('title').value.trim() !== '';

                if (hasRoles && hasTitle) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('bg-blue-400', 'cursor-not-allowed');
                    submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
                    submitBtn.textContent = document.getElementById('formMethod').value === 'PUT' ? 'Update Task' : 'Save Task';
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
                    submitBtn.classList.add('bg-blue-400', 'cursor-not-allowed');
                    submitBtn.textContent = document.getElementById('formMethod').value === 'PUT' ? 'Update Task' : 'Save Task';
                }
            }

            document.getElementById('taskForm').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                const title = document.getElementById('title').value.trim();

                if (!title) {
                    e.preventDefault();
                    alert('Title is required!');
                    document.getElementById('title').focus();
                    return;
                }

                if (customRoles.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one role!');
                    return;
                }

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${document.getElementById('formMethod').value === 'PUT' ? 'Updating...' : 'Saving...'}
                `;
                }
            });

            document.getElementById('title').addEventListener('input', updateSubmitButtonState);
            document.getElementById('taskModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            document.getElementById('addRoleModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeAddRoleModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                    closeAddRoleModal();
                }
            });

            document.getElementById('newRoleName').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addNewRole();
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                console.log('Initializing drag and drop...');

                const columns = document.querySelectorAll('.todo-column');

                columns.forEach(column => {
                    new Sortable(column, {
                        group: 'todos',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        dragClass: 'sortable-drag',

                        onStart: function(evt) {
                            evt.item.classList.add('dragging');
                            console.log('Drag started:', evt.item.dataset.todoId);
                        },

                        onEnd: function(evt) {
                            evt.item.classList.remove('dragging');

                            const todoId = evt.item.dataset.todoId;
                            const oldStatus = evt.from.dataset.status;
                            const newStatus = evt.to.dataset.status;

                            console.log('Drag ended:', {
                                todoId,
                                oldStatus,
                                newStatus
                            });

                            if (newStatus !== oldStatus) {
                                updateTaskStatus(todoId, newStatus, evt.item);
                            }
                        }
                    });
                });

                window.testEdit = function() {
                    const testTodo = {
                        id: 1,
                        title: 'Test Task',
                        description: 'Test Description',
                        employee_role: 'programmer'
                    };
                    openEditModal(testTodo);
                };
            });

            async function updateTaskStatus(todoId, newStatus, element) {
                console.log('Updating task status:', {
                    todoId,
                    newStatus
                });

                element.classList.add('updating');

                try {
                    const response = await fetch(`/todos/${todoId}/status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    });

                    const data = await response.json();
                    console.log('Server response:', data);

                    if (response.ok && data.success) {
                        updateTaskVisual(element, newStatus);
                        updateColumnCounters();
                        showNotification('Status tugas berhasil diperbaharui!', 'success');
                    } else {
                        throw new Error(data.error || 'Update failed');
                    }

                } catch (error) {
                    console.error('Error updating task status:', error);
                    showNotification('Gagal melakukan update tugas: ' + error.message, 'error');

                    const oldStatus = element.getAttribute('data-status');
                    updateTaskVisual(element, oldStatus);
                } finally {
                    element.classList.remove('updating');
                }
            }

            function updateTaskVisual(element, newStatus) {
                element.setAttribute('data-status', newStatus);

                element.classList.remove('border-l-gray-500', 'border-l-blue-500', 'border-l-green-500');

                if (newStatus === 'todo') {
                    element.classList.add('border-l-gray-500');
                } else if (newStatus === 'doing') {
                    element.classList.add('border-l-blue-500');
                } else if (newStatus === 'done') {
                    element.classList.add('border-l-green-500');
                }

                const statusBadge = element.querySelector('.status-badge');
                if (statusBadge) {
                    statusBadge.classList.remove(
                        'bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-300',
                        'bg-blue-200', 'dark:bg-blue-600', 'text-blue-700', 'dark:text-blue-300',
                        'bg-green-200', 'dark:bg-green-600', 'text-green-700', 'dark:text-green-300'
                    );

                    if (newStatus === 'todo') {
                        statusBadge.classList.add('bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-300');
                    } else if (newStatus === 'doing') {
                        statusBadge.classList.add('bg-blue-200', 'dark:bg-blue-600', 'text-blue-700', 'dark:text-blue-300');
                    } else if (newStatus === 'done') {
                        statusBadge.classList.add('bg-green-200', 'dark:bg-green-600', 'text-green-700', 'dark:text-green-300');
                    }

                    statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                }
            }

            function updateColumnCounters() {
                const statuses = ['todo', 'doing', 'done'];
                statuses.forEach(status => {
                    const column = document.getElementById(`${status}-column`);
                    const count = column ? column.querySelectorAll('.todo-card').length : 0;
                    const counter = document.querySelector(`.counter-${status}`);
                    if (counter) {
                        counter.textContent = count;
                    }
                });
            }

            function showNotification(message, type = 'info') {
                document.querySelectorAll('.custom-notification').forEach(notif => notif.remove());

                const notification = document.createElement('div');
                notification.className = `custom-notification fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
                notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        ${
                            type === 'success' ?
                            '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>' :
                            type === 'error' ?
                            '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>' :
                            '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>'
                        }
                    </svg>
                    <span>${message}</span>
                </div>
            `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            function openSubmitModal() {
                console.log('Opening submit modal');

                const doneTodos = document.querySelectorAll('#done-column .todo-card');
                const submitList = document.getElementById('submitTodoList');

                submitList.innerHTML = '';

                if (doneTodos.length === 0) {
                    submitList.innerHTML = `
                    <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                        <p>Tidak ada tugas yang diselesaikan</p>
                    </div>
                `;
                } else {
                    doneTodos.forEach(todoCard => {
                        const todoId = todoCard.dataset.todoId;
                        const todoTitle = todoCard.querySelector('.todo-title').textContent;
                        const todoDescription = todoCard.querySelector('.todo-description')?.textContent || '';

                        const todoItem = document.createElement('div');
                        todoItem.className =
                            'flex items-start space-x-3 p-3 border border-gray-200 dark:border-gray-600 rounded-lg mb-2';
                        todoItem.innerHTML = `
                        <div class="flex items-start h-5">
                            <input type="checkbox" id="todo-${todoId}" name="selected_todos[]" value="${todoId}" 
                                   class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2 mt-1">
                        </div>
                        <div class="flex-1">
                            <label for="todo-${todoId}" class="text-sm font-medium text-gray-900 dark:text-white cursor-pointer">
                                ${todoTitle}
                            </label>
                            ${todoDescription ? `<p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${todoDescription}</p>` : ''}
                        </div>
                    `;

                        submitList.appendChild(todoItem);
                    });
                }

                document.getElementById('submitModal').classList.remove('hidden');
            }

            function closeSubmitModal() {
                document.getElementById('submitModal').classList.add('hidden');
            }

            async function submitSelectedTodos() {
                const selectedCheckboxes = document.querySelectorAll('#submitTodoList input[type="checkbox"]:checked');
                const selectedTodoIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

                console.log('Pilih Todo untuk submit:', selectedTodoIds);

                if (selectedTodoIds.length === 0) {
                    alert('Pilih Todo buat selesain nya dong!');
                    return;
                }

                const submitBtn = document.querySelector('#submitModal button[onclick="submitSelectedTodos()"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...
            `;
                submitBtn.disabled = true;

                try {
                    const response = await fetch('/todos/submit-selected', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            todo_ids: selectedTodoIds
                        })
                    });

                    const data = await response.json();
                    console.log('Submit response:', data);

                    if (response.ok && data.success) {
                        showNotification(`${data.deleted_count} Todos berhasil dikirim dan terhapus!`, 'success');

                        selectedTodoIds.forEach(todoId => {
                            const todoElement = document.querySelector(`.todo-card[data-todo-id="${todoId}"]`);
                            if (todoElement) {
                                todoElement.remove();
                            }
                        });

                        updateColumnCounters();

                        closeSubmitModal();

                        const remainingDoneTodos = document.querySelectorAll('#done-column .todo-card').length;
                        if (remainingDoneTodos === 0) {
                            const submitBtn = document.querySelector('#done-column button[onclick="openSubmitModal()"]');
                            if (submitBtn) {
                                submitBtn.remove();
                            }
                        }

                    } else {
                        throw new Error(data.error || 'Submit failed');
                    }

                } catch (error) {
                    console.error('Gagal mengirim todos:', error);
                    showNotification('Gagal menyelesaikan todos: ' + error.message, 'error');
                } finally {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }

            document.getElementById('submitModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSubmitModal();
                }
            });
        </script>
    @endpush
</x-app-layout>
