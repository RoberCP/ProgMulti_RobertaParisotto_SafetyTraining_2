<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmpresaManagement extends Component
{
    public $empresas;
    public $razao_social, $cnpj, $ramo;
    public $empresa_id;
    public $isEdit = false;
    public $confirmingDelete = false;
    public $empresaIdToDelete;

    public $usuarios = [];
    public $usuariosSelecionados = [];

    public function mount()
    {
        $this->loadEmpresas();
        $this->usuarios = User::where('is_admin', false)->get(); // apenas auditores
    }

    public function loadEmpresas()
    {
        if (Auth::user()->is_admin) {
            $this->empresas = Empresa::with('users')->get();
        } else {
            $this->empresas = Auth::user()->empresas()->with('users')->get(); // erro? A tela funciona normalmente, mas o erro é exibido no console
        }
    }

    public function save()
    {
        $this->validate([
            'razao_social' => 'required|string|min:3',
            'cnpj' => 'required|string|unique:empresas,cnpj,' . ($this->empresa_id ?: 'NULL'),
            'ramo' => 'required|string|min:3',
        ]);

        $data = [
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'ramo' => $this->ramo,
        ];

        if ($this->isEdit) {
            $empresa = Empresa::find($this->empresa_id);
            $empresa->update($data);
        } else {
            $empresa = Empresa::create($data);
        }

        $empresa->users()->sync($this->usuariosSelecionados);

        session()->flash('message', $this->isEdit ? 'Empresa atualizada com sucesso.' : 'Empresa cadastrada com sucesso.');
        $this->resetForm();
        $this->loadEmpresas();
    }

    public function edit($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $empresa = Empresa::findOrFail($id);
        $this->empresa_id = $empresa->id;
        $this->razao_social = $empresa->razao_social;
        $this->cnpj = $empresa->cnpj;
        $this->ramo = $empresa->ramo;
        $this->usuariosSelecionados = $empresa->users->pluck('id')->toArray();
        $this->isEdit = true;
    }

    public function confirmDelete($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $this->empresaIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function deleteEmpresa()
    {
        Empresa::findOrFail($this->empresaIdToDelete)->delete();
        $this->resetForm();
        $this->loadEmpresas();
        $this->confirmingDelete = false;
        $this->empresaIdToDelete = null;
        session()->flash('message', 'Empresa excluída com sucesso.');
    }

    public function resetForm()
    {
        $this->empresa_id = null;
        $this->razao_social = '';
        $this->cnpj = '';
        $this->ramo = '';
        $this->usuariosSelecionados = [];
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.empresa-management');
    }
}
