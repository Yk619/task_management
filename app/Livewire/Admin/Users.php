<?php
namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public $name, $email, $password, $role='user', $userId;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required|in:admin,user',
        'password' => 'nullable|min:6',
    ];

    public function render()
    {
        $users = User::orderBy('created_at','desc')->paginate(10);
        return view('livewire.admin.users', compact('users'));
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $u = User::findOrFail($id);
        $this->userId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->role = $u->role;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if($this->password){
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id'=>$this->userId], $data);

        session()->flash('message', 'User saved.');
        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        $u = User::findOrFail($id);
        $u->delete();
        session()->flash('message','User deleted.');
    }

    private function resetForm()
    {
        $this->reset(['name','email','password','role','userId']);
    }
}