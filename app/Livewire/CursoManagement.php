<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;

class CursoManagement extends Component
{
    public $cursos;
    public $nomeCurso, $cargaHora, $instrutor, $prazoRecicla, $status, $empresa_id;
    public $curso_id;
    public $isEdit = false;
    public $confirmingDelete = false;
    public $cursoIdToDelete;
    public $empresas = [];

    public function mount()
    {
        $this->loadCursos();
        $this->empresas = Empresa::all();
    }

    public function loadCursos()
    {
        if (Auth::user()->is_admin) {
            $this->cursos = Curso::with('empresa')->get();
        } else {
            $empresaIds = Auth::user()->empresas->pluck('id');
            $this->cursos = Curso::with('empresa')
                ->whereIn('empresa_id', $empresaIds)
                ->get();
        }
    }

    public function save()
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $this->validate([
            'nomeCurso' => 'required|string|min:3',
            'cargaHora' => 'required|integer|min:1',
            'instrutor' => 'required|string|min:3',
            'prazoRecicla' => 'required|date',
            'status' => 'required|string',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        $data = [
            'nomeCurso' => $this->nomeCurso,
            'cargaHora' => $this->cargaHora,
            'instrutor' => $this->instrutor,
            'prazoRecicla' => $this->prazoRecicla,
            'status' => $this->status,
            'empresa_id' => $this->empresa_id,
        ];

        if ($this->isEdit) {
            Curso::findOrFail($this->curso_id)->update($data);
            session()->flash('message', 'Curso atualizado com sucesso.');
        } else {
            Curso::create($data);
            session()->flash('message', 'Curso cadastrado com sucesso.');
        }

        $this->resetForm();
        $this->loadCursos();
    }

    public function edit($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $curso = Curso::findOrFail($id);
        $this->curso_id = $curso->IdCurso;
        $this->nomeCurso = $curso->nomeCurso;
        $this->cargaHora = $curso->cargaHora;
        $this->instrutor = $curso->instrutor;
        $this->prazoRecicla = $curso->prazoRecicla;
        $this->status = $curso->status;
        $this->empresa_id = $curso->empresa_id;
        $this->isEdit = true;
    }

    public function confirmDelete($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $this->cursoIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function deleteCurso()
    {
        Curso::findOrFail($this->cursoIdToDelete)->delete();
        $this->resetForm();
        $this->loadCursos();
        $this->confirmingDelete = false;
        $this->cursoIdToDelete = null;
        session()->flash('message', 'Curso excluído com sucesso.');
    }

    public function resetForm()
    {
        $this->curso_id = null;
        $this->nomeCurso = '';
        $this->cargaHora = '';
        $this->instrutor = '';
        $this->prazoRecicla = '';
        $this->status = 'Ativo';
        $this->empresa_id = '';
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.curso-management');
    }
}