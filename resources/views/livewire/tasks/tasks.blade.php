<div>
    <div class="d-flex justify-content-between mb-3">
        <input wire:model.debounce.300ms="search" 
               class="form-control w-50" 
               placeholder="🔍 Search tasks...">
        <button wire:click="create" class="btn btn-sm btn-success">
            <i class="bi bi-plus-circle"></i> New Task
        </button>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Assignee</th>
                <th>Start</th>
                <th>End</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>
                    <span class="badge bg-info">
                        {{ $task->assignee?->name ?? 'Unassigned' }}
                    </span>
                </td>
                <td>{{ $task->start_date }}</td>
                <td>{{ $task->end_date }}</td>
                <td>
                    <button wire:click="edit({{ $task->id }})" 
                            class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button wire:click="delete({{ $task->id }})" 
                            class="btn btn-sm btn-outline-danger"
                            onclick="confirm('Delete this task?') || event.stopImmediatePropagation()">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No tasks found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div>{{ $tasks->links() }}</div>
</div>
