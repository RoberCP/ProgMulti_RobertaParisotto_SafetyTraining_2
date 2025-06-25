<div class="p-4 space-y-4 bg-white min-h-screen">

    {{-- Menu bar de navegação --}}
    <nav class="flex gap-4 bg-green-50 p-3 rounded shadow mb-4">
        <a href="{{ route('dashboard') }}" class="text-green-700 hover:underline">Dashboard</a>
        <a href="{{ route('empresas') }}" class="text-green-700 hover:underline">Empresas</a>
        <a href="{{ route('usuarios') }}" class="text-green-700 hover:underline">Usuários</a>
        <a href="{{ route('funcionarios') }}" class="text-green-700 font-semibold">Funcionários</a>
        <a href="{{ route('cursos') }}" class="text-green-700 hover:underline">Cursos</a>
        <a href="{{ route('certificados') }}" class="text-green-700 hover:underline">Certificados</a>
    </nav>

    {{-- Mensagem de sucesso --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Modal de confirmação de exclusão --}}
    @if ($confirmingDelete)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold text-gray-800">Tem certeza que deseja excluir este funcionário?</h2>
                <p class="text-gray-600">Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex gap-2 justify-end">
                    <button wire:click="deleteFuncionario" class="border border-red-600 text-red-600 px-4 py-2 rounded hover:bg-red-50 transition">Sim, excluir</button>
                    <button wire:click="$set('confirmingDelete', false)" class="border border-gray-500 text-gray-600 px-4 py-2 rounded hover:bg-gray-50 transition">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulário --}}
    <form wire:submit.prevent="save" class="space-y-2">
        <input wire:model="nome" type="text" placeholder="Nome" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="cpf" type="text" placeholder="CPF" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="setor" type="text" placeholder="Setor" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="cargo" type="text" placeholder="Cargo" class="border border-gray-300 p-2 rounded w-full">

        <select wire:model="empresa_id" class="border border-gray-300 p-2 rounded w-full">
            <option value="">Selecione a empresa</option>
            @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}">{{ $empresa->razao_social }}</option>
            @endforeach
        </select>

        <select wire:model="curso_id" class="border border-gray-300 p-2 rounded w-full">
            <option value="">Selecione o curso ou treinamento</option>
            @foreach ($cursos as $curso)
                <option value="{{ $curso->IdCurso }}">{{ $curso->nomeCurso }}</option>
            @endforeach
        </select>

        <div class="flex gap-2 mt-2">
            <button type="submit" class="border border-green-600 text-green-600 font-semibold px-4 py-2 rounded hover:bg-green-50 transition">
                {{ $isEdit ? 'Atualizar' : 'Cadastrar' }}
            </button>
            @if ($isEdit)
                <button type="button" wire:click="resetForm" class="border border-gray-500 text-gray-600 px-4 py-2 rounded hover:bg-gray-50 transition">
                    Cancelar
                </button>
            @endif
        </div>
    </form>

    <hr class="my-4">

    {{-- Tabela de funcionários --}}
    <table class="table-auto w-full border border-gray-300 bg-white">
        <thead class="bg-green-50 text-green-800">
            <tr>
                <th class="px-2 py-1 border">ID</th>
                <th class="px-2 py-1 border">Nome</th>
                <th class="px-2 py-1 border">CPF</th>
                <th class="px-2 py-1 border">Setor</th>
                <th class="px-2 py-1 border">Cargo</th>
                <th class="px-2 py-1 border">Empresa</th>
                <th class="px-2 py-1 border">Curso</th>
                <th class="px-2 py-1 border">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($funcionarios as $funcionario)
                <tr class="border-t">
                    <td class="px-2 py-1 border">{{ $funcionario->idFuncionario }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->nome }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->cpf }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->setor }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->cargo }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->empresa->razao_social ?? '-' }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->curso->nomeCurso ?? '-' }}</td>
                    <td class="px-2 py-1 border space-x-1">
                        <button wire:click="edit({{ $funcionario->idFuncionario }})" class="border border-blue-600 text-blue-600 px-2 py-1 rounded hover:bg-blue-50">Editar</button>
                        @if(auth()->user()->is_admin)
                            <button wire:click="confirmDelete({{ $funcionario->idFuncionario }})" class="border border-red-600 text-red-600 px-2 py-1 rounded hover:bg-red-50">Excluir</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-2 py-4 text-center text-gray-500">Nenhum funcionário cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
