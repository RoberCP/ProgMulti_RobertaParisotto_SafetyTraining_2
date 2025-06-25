<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Auth;

class CertificadoManagement extends Component
{
    public $certificados;
    public $idCertificado, $idCurso, $idFuncionario, $dataEmissao;
    public $carga_horaria, $instrutor, $progresso;
    public $assinatura_instrutor = false, $assinatura_funcionario = false;
    public $isEdit = false;
    public $confirmingDelete = false;
    public $certificadoIdToDelete;

    public $cursos = [];
    public $funcionarios = [];

    public function mount()
    {
        $this->loadCertificados();
        $this->cursos = Curso::all();
        $this->funcionarios = Funcionario::all();
    }

    public function loadCertificados()
    {
        if (Auth::user()->is_admin) {
            $this->certificados = Certificado::with(['curso', 'funcionario'])->get();
        } else {
            $empresaIds = Auth::user()->empresas->pluck('id');
            $this->certificados = Certificado::whereHas('funcionario', function ($q) use ($empresaIds) {
                $q->whereIn('idEmpresa', $empresaIds);
            })->with(['curso', 'funcionario'])->get();
        }
    }

    public function updatedIdCurso($value)
    {
        if (empty($value)) {
            $this->carga_horaria = '';
            $this->instrutor = '';
            $this->progresso = '';
            return;
        }

        $curso = Curso::where('IdCurso', $value)->first();
        if ($curso) {
            $this->carga_horaria = $curso->cargaHora;
            $this->instrutor = $curso->instrutor;
            $this->progresso = 'Não iniciado';
        }
    }

    public function save()
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $this->validate([
            'idCurso' => 'required|exists:cursos,IdCurso',
            'idFuncionario' => 'required|exists:funcionarios,idFuncionario',
            'dataEmissao' => 'required|date',
            'carga_horaria' => 'required|integer|min:1',
            'instrutor' => 'required|string|min:3',
            'progresso' => 'required|string',
        ]);

        $data = [
            'idCurso' => $this->idCurso,
            'idFuncionario' => $this->idFuncionario,
            'dataEmissao' => $this->dataEmissao,
            'carga_horaria' => $this->carga_horaria,
            'instrutor' => $this->instrutor,
            'progresso' => $this->progresso,
            'assinatura_instrutor' => $this->assinatura_instrutor,
            'assinatura_funcionario' => $this->assinatura_funcionario,
        ];

        if ($this->isEdit) {
            Certificado::findOrFail($this->idCertificado)->update($data);
            session()->flash('message', 'Certificado atualizado com sucesso.');
        } else {
            Certificado::create($data);
            session()->flash('message', 'Certificado cadastrado com sucesso.');
        }

        $this->resetForm();
        $this->loadCertificados();
    }

    public function edit($id)
    {
        $certificado = Certificado::findOrFail($id);
        $this->idCertificado = $certificado->idCertificado;
        $this->idCurso = $certificado->idCurso;
        $this->idFuncionario = $certificado->idFuncionario;
        $this->dataEmissao = $certificado->dataEmissao;
        $this->carga_horaria = $certificado->carga_horaria;
        $this->instrutor = $certificado->instrutor;
        $this->progresso = $certificado->progresso;
        $this->assinatura_instrutor = $certificado->assinatura_instrutor;
        $this->assinatura_funcionario = $certificado->assinatura_funcionario;
        $this->isEdit = true;
    }

    public function confirmDelete($id)
    {
        $this->certificadoIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function deleteCertificado()
    {
        Certificado::findOrFail($this->certificadoIdToDelete)->delete();
        $this->resetForm();
        $this->loadCertificados();
        $this->confirmingDelete = false;
        session()->flash('message', 'Certificado excluído com sucesso.');
    }

    public function resetForm()
    {
        $this->idCertificado = null;
        $this->idCurso = '';
        $this->idFuncionario = '';
        $this->dataEmissao = '';
        $this->carga_horaria = '';
        $this->instrutor = '';
        $this->progresso = '';
        $this->assinatura_instrutor = false;
        $this->assinatura_funcionario = false;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.certificado-management');
    }
}
