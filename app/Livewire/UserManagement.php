<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    public $confirmingDelete = false;
    public $userIdToDelete;

    public function confirmDelete($userId)
{
    $this->confirmingDelete = true;
    $this->userIdToDelete = $userId;
}

    public function deleteUser()
{
    User::find($this->userIdToDelete)->delete();
    $this->confirmingDelete = false;
    $this->userIdToDelete = null;
    session()->flash('message', 'Usuário excluído com sucesso.');
    $this->resetForm();
}

    public $users;
    public $name, $email, $password, $user_id;
    public $isEdit = false;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::all();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => $this->isEdit ? 'nullable|min:8' : 'required|min:8',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEdit) {
            User::find($this->user_id)->update($data);
        } else {
            User::create($data);
        }

        $this->resetForm();
        $this->loadUsers();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->isEdit = true;
    }

    public function resetForm()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.user-management', [
        'users' => User::all(),
        ]);
    }
}
