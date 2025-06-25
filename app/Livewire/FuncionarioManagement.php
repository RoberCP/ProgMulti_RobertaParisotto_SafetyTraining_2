<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Funcionario;
use App\Models\Empresa;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

class FuncionarioManagement extends Component
{
    public $funcionarios;
    public $nome, $cpf, $setor, $cargo, $empresa_id, $curso_id;
    public $funcionario_id;
    public $isEdit = false;
    public $confirmingDelete = false;
    public $funcionarioIdToDelete;

    public $empresas = [];
    public $cursos = [];

    public function mount()
    {
        $this->loadFuncionarios();

        $this->empresas = Auth::user()->is_admin
            ? Empresa::all()
            : Auth::user()->empresas;

        $this->cursos = Curso::all();
    }

    public function loadFuncionarios()
    {
        if (Auth::user()->is_admin) {
            $this->funcionarios = Funcionario::with(['empresa', 'curso'])->get();
        } else {
            $empresaIds = Auth::user()->empresas->pluck('id');
            $this->funcionarios = Funcionario::with(['empresa', 'curso'])
                ->whereIn('idEmpresa', $empresaIds)
                ->get();
        }
    }

    public function save()
    {
        $this->validate([
            'nome' => 'required|string|min:3',
            'cpf' => 'required|string|min:11|max:14',
            'setor' => 'required|string|min:2',
            'cargo' => 'required|string|min:2',
            'empresa_id' => 'required|exists:empresas,id',
            'curso_id' => 'required|exists:cursos,IdCurso',
        ]);

        $data = [
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'setor' => $this->setor,
            'cargo' => $this->cargo,
            'idEmpresa' => $this->empresa_id,
            'curso_id' => $this->curso_id,
        ];

        if ($this->isEdit) {
            Funcionario::find($this->funcionario_id)->update($data);
            session()->flash('message', 'Funcionário atualizado com sucesso.');
        } else {
            Funcionario::create($data);
            session()->flash('message', 'Funcionário cadastrado com sucesso.');
        }

        $this->resetForm();
        $this->loadFuncionarios();
    }

    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        if (!Auth::user()->is_admin && !Auth::user()->empresas->pluck('id')->contains($funcionario->idEmpresa)) {
            abort(403);
        }

        $this->funcionario_id = $funcionario->idFuncionario;
        $this->nome = $funcionario->nome;
        $this->cpf = $funcionario->cpf;
        $this->setor = $funcionario->setor;
        $this->cargo = $funcionario->cargo;
        $this->empresa_id = $funcionario->idEmpresa;
        $this->curso_id = $funcionario->curso_id;
        $this->isEdit = true;
    }

    public function confirmDelete($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $this->funcionarioIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function deleteFuncionario()
    {
        Funcionario::findOrFail($this->funcionarioIdToDelete)->delete();
        $this->resetForm();
        $this->loadFuncionarios();
        $this->confirmingDelete = false;
        $this->funcionarioIdToDelete = null;
        session()->flash('message', 'Funcionário excluído com sucesso.');
    }

    public function resetForm()
    {
        $this->funcionario_id = null;
        $this->nome = '';
        $this->cpf = '';
        $this->setor = '';
        $this->cargo = '';
        $this->empresa_id = '';
        $this->curso_id = '';
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.funcionario-management', [
            'empresas' => $this->empresas,
            'cursos' => $this->cursos,
        ]);
    }
}
