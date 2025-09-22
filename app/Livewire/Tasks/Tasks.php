<?php
namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use App\Models\User;

class Tasks extends Component
{
    use WithPagination;

    public $title, $description, $assignee_id, $start_date, $end_date, $taskId;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'assignee_id' => 'nullable|exists:users,id',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    public function render()
    {
        $users = User::orderBy('name')->get();
        $tasks = Task::with('assignee')
            ->where(function($q){
                $q->where('title','like','%'.$this->search.'%')
                  ->orWhere('description','like','%'.$this->search.'%');
            })
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('livewire.tasks.tasks', compact('tasks','users'));
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->assignee_id = $task->assignee_id;
        $this->start_date = $task->start_date ? $task->start_date->format('Y-m-d') : null;
        $this->end_date = $task->end_date ? $task->end_date->format('Y-m-d') : null;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        Task::updateOrCreate(
            ['id' => $this->taskId],
            [
                'title' => $this->title,
                'description' => $this->description,
                'assignee_id' => $this->assignee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]
        );

        session()->flash('message', 'Task saved.');
        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        $t = Task::findOrFail($id);
        $t->delete();
        session()->flash('message','Task deleted.');
    }

    private function resetForm()
    {
        $this->reset(['title','description','assignee_id','start_date','end_date','taskId','search']);
    }
}

