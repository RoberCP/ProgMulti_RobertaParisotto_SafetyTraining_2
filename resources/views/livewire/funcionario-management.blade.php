<div class="p-4 space-y-4">

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
                <h2 class="text-lg font-semibold">Tem certeza que deseja excluir este funcionário?</h2>
                <p>Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex gap-2 justify-end">
                    <button wire:click="deleteFuncionario" class="bg-red-600 text-white px-4 py-2 rounded">Sim, excluir</button>
                    <button wire:click="$set('confirmingDelete', false)" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulário --}}
    <form wire:submit.prevent="save" class="space-y-2">
        <input wire:model="nome" type="text" placeholder="Nome" class="border p-2 rounded w-full">
        <input wire:model="cpf" type="text" placeholder="CPF" class="border p-2 rounded w-full">
        <input wire:model="setor" type="text" placeholder="Setor" class="border p-2 rounded w-full">
        <input wire:model="cargo" type="text" placeholder="Cargo" class="border p-2 rounded w-full">

        <select wire:model="empresa_id" class="border p-2 rounded w-full">
            <option value="">Selecione a empresa</option>
            @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}">{{ $empresa->razao_social }}</option>
            @endforeach
        </select>

        <select wire:model="certificado_id" class="border p-2 rounded w-full">
            <option value="">Selecione o curso ou treinamento</option>
            @foreach ($certificados as $certificado)
                <option value="{{ $certificado->id }}">{{ $certificado->nome }}</option>
            @endforeach
        </select>

        <div class="flex gap-2 mt-2">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                {{ $isEdit ? 'Atualizar' : 'Cadastrar' }}
            </button>
            @if ($isEdit)
                <button type="button" wire:click="resetForm" class="bg-gray-400 text-white px-4 py-2 rounded">
                    Cancelar
                </button>
            @endif
        </div>
    </form>

    <hr class="my-4">

    {{-- Tabela de funcionários --}}
    <table class="table-auto w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-2 py-1 border">ID</th>
                <th class="px-2 py-1 border">Nome</th>
                <th class="px-2 py-1 border">CPF</th>
                <th class="px-2 py-1 border">Setor</th>
                <th class="px-2 py-1 border">Cargo</th>
                <th class="px-2 py-1 border">Empresa</th>
                <th class="px-2 py-1 border">Treinamento</th>
                <th class="px-2 py-1 border">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($funcionarios as $funcionario)
                <tr class="border-t">
                    <td class="px-2 py-1 border">{{ $funcionario->id }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->nome }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->cpf }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->setor }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->cargo }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->empresa->razao_social ?? '-' }}</td>
                    <td class="px-2 py-1 border">{{ $funcionario->certificado->nome ?? '-' }}</td>
                    <td class="px-2 py-1 border space-x-2">
                        <button wire:click="edit({{ $funcionario->id }})" class="text-blue-600 hover:underline">Editar</button>
                        @if(auth()->user()->is_admin)
                            <button wire:click="confirmDelete({{ $funcionario->id }})" class="text-red-600 hover:underline">Excluir</button>
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