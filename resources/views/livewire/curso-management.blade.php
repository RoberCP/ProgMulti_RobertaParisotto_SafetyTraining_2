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
                <h2 class="text-lg font-semibold">Tem certeza que deseja excluir este curso?</h2>
                <p>Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex gap-2 justify-end">
                    <button wire:click="deleteCurso" class="bg-red-600 text-white px-4 py-2 rounded">Sim, excluir</button>
                    <button wire:click="$set('confirmingDelete', false)" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulário --}}
    <form wire:submit.prevent="save" class="space-y-2">
        <input wire:model="nomeCurso" type="text" placeholder="Nome do Curso" class="border p-2 rounded w-full">
        <input wire:model="cargaHora" type="number" placeholder="Carga Horária" class="border p-2 rounded w-full">
        <input wire:model="instrutor" type="text" placeholder="Instrutor" class="border p-2 rounded w-full">
        <input wire:model="prazoRecicla" type="date" class="border p-2 rounded w-full">
        <input wire:model="status" type="text" placeholder="Status" class="border p-2 rounded w-full">

        <select wire:model="empresa_id" class="border p-2 rounded w-full">
            <option value="">Selecione a empresa</option>
            @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}">{{ $empresa->razao_social }}</option>
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

    {{-- Tabela de cursos --}}
    <table class="table-auto w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-2 py-1 border">ID</th>
                <th class="px-2 py-1 border">Nome</th>
                <th class="px-2 py-1 border">Carga Horária</th>
                <th class="px-2 py-1 border">Instrutor</th>
                <th class="px-2 py-1 border">Prazo Reciclagem</th>
                <th class="px-2 py-1 border">Status</th>
                <th class="px-2 py-1 border">Empresa</th>
                <th class="px-2 py-1 border">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cursos as $curso)
                <tr class="border-t">
                    <td class="px-2 py-1 border">{{ $curso->IdCurso }}</td>
                    <td class="px-2 py-1 border">{{ $curso->nomeCurso }}</td>
                    <td class="px-2 py-1 border">{{ $curso->cargaHora }}</td>
                    <td class="px-2 py-1 border">{{ $curso->instrutor }}</td>
                    <td class="px-2 py-1 border">{{ $curso->prazoRecicla }}</td>
                    <td class="px-2 py-1 border">{{ $curso->status }}</td>
                    <td class="px-2 py-1 border">{{ $curso->empresa->razao_social ?? '-' }}</td>
                    <td class="px-2 py-1 border space-x-2">
                        <button wire:click="edit({{ $curso->IdCurso }})" class="text-blue-600 hover:underline">Editar</button>
                        <button wire:click="confirmDelete({{ $curso->IdCurso }})" class="text-red-600 hover:underline">Excluir</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-2 py-4 text-center text-gray-500">Nenhum curso cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>