class TodoDragDrop {
    constructor() {
        this.columns = {};
        this.init();
    }

    init() {
        this.initializeSortable();
        this.setupEventListeners();
        this.setupLoadingStates();
    }

    initializeSortable() {
        const columns = document.querySelectorAll('.todo-column');
        
        columns.forEach(column => {
            const status = column.dataset.status;
            
            this.columns[status] = new Sortable(column, {
                group: 'todos',
                animation: 150,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                chosenClass: 'sortable-chosen',
                filter: '.ignore-drag',
                
                onStart: (evt) => {
                    evt.item.classList.add('dragging');
                    this.showDropZones();
                },
                
                onEnd: (evt) => {
                    evt.item.classList.remove('dragging');
                    this.hideDropZones();
                    
                    const todoId = evt.item.dataset.todoId;
                    const newStatus = evt.to.dataset.status;
                    const oldStatus = evt.from.dataset.status;
                    
                    if (newStatus !== oldStatus) {
                        this.updateTaskStatus(todoId, newStatus, evt.item);
                    }
                },
                
                onAdd: (evt) => {
                    this.updateColumnCounters();
                }
            });
        });
    }

    async updateTaskStatus(todoId, newStatus, element) {
        // Show loading state
        element.classList.add('updating');
        
        try {
            const response = await fetch(`/todos/${todoId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    status: newStatus,
                    _method: 'PATCH'
                })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            
            if (data.success) {
                // Update visual status
                this.updateTaskVisualStatus(element, newStatus);
                this.showNotification('Task status updated successfully!', 'success');
            } else {
                throw new Error('Update failed');
            }
            
        } catch (error) {
            console.error('Error updating task status:', error);
            this.showNotification('Failed to update task status', 'error');
            // Revert visual changes if needed
            this.revertTaskPosition(element);
        } finally {
            element.classList.remove('updating');
        }
    }

    updateTaskVisualStatus(element, newStatus) {
        const statusBadge = element.querySelector('.status-badge');
        if (statusBadge) {
            // Remove existing status classes
            statusBadge.classList.remove(
                'bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-300',
                'bg-blue-200', 'dark:bg-blue-600', 'text-blue-700', 'dark:text-blue-300',
                'bg-green-200', 'dark:bg-green-600', 'text-green-700', 'dark:text-green-300'
            );
            
            // Add new status classes
            const statusClasses = {
                todo: ['bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-300'],
                doing: ['bg-blue-200', 'dark:bg-blue-600', 'text-blue-700', 'dark:text-blue-300'],
                done: ['bg-green-200', 'dark:bg-green-600', 'text-green-700', 'dark:text-green-300']
            };
            
            statusBadge.classList.add(...statusClasses[newStatus]);
            statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
        }
    }

    updateColumnCounters() {
        const columns = document.querySelectorAll('.todo-column');
        columns.forEach(column => {
            const status = column.dataset.status;
            const count = column.querySelectorAll('.todo-card').length;
            const counter = document.querySelector(`.counter-${status}`);
            if (counter) {
                counter.textContent = count;
            }
        });
    }

    showDropZones() {
        document.querySelectorAll('.todo-column').forEach(column => {
            column.classList.add('drop-zone-active');
        });
    }

    hideDropZones() {
        document.querySelectorAll('.todo-column').forEach(column => {
            column.classList.remove('drop-zone-active');
        });
    }

    revertTaskPosition(element) {
        // Implement revert logic if needed
        console.log('Reverting task position');
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    setupEventListeners() {
        // Global click handler to close menus
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.todo-menu')) {
                this.closeAllMenus();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'k') {
                e.preventDefault();
                document.querySelector('[onclick="openAddModal()"]').click();
            }
        });
    }

    setupLoadingStates() {
        // Add loading state for form submissions
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;
                }
            });
        });
    }

    closeAllMenus() {
        document.querySelectorAll('.todo-menu-content').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.todoApp = new TodoDragDrop();
});