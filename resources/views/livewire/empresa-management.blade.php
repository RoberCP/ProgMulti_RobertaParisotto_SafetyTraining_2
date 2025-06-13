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
                <h2 class="text-lg font-semibold">Tem certeza que deseja excluir esta empresa?</h2>
                <p>Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex gap-2 justify-end">
                    <button wire:click="deleteEmpresa" class="bg-red-600 text-white px-4 py-2 rounded">Sim, excluir</button>
                    <button wire:click="$set('confirmingDelete', false)" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulário --}}
    <form wire:submit.prevent="save" class="space-y-2">
        <input wire:model="razao_social" type="text" placeholder="Razão Social" class="border p-2 rounded w-full">
        <input wire:model="cnpj" type="text" placeholder="CNPJ" class="border p-2 rounded w-full">
        <input wire:model="ramo" type="text" placeholder="Ramo de atuação" class="border p-2 rounded w-full">

        @if (auth()->user()->is_admin)
            <label class="block mt-2 text-sm text-gray-700 font-medium">Vincular auditores:</label>
            <select wire:model="usuariosSelecionados" multiple class="border p-2 rounded w-full h-32">
                @foreach($usuarios as $auditor)
                    <option value="{{ $auditor->id }}">{{ $auditor->name }} ({{ $auditor->email }})</option>
                @endforeach
            </select>
        @endif

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

    {{-- Tabela de empresas --}}
    <table class="table-auto w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-2 py-1 border">ID</th>
                <th class="px-2 py-1 border">Razão Social</th>
                <th class="px-2 py-1 border">CNPJ</th>
                <th class="px-2 py-1 border">Ramo</th>
                <th class="px-2 py-1 border">Auditores</th>
                <th class="px-2 py-1 border">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($empresas as $empresa)
                <tr class="border-t">
                    <td class="px-2 py-1 border">{{ $empresa->id }}</td>
                    <td class="px-2 py-1 border">{{ $empresa->razao_social }}</td>
                    <td class="px-2 py-1 border">{{ $empresa->cnpj }}</td>
                    <td class="px-2 py-1 border">{{ $empresa->ramo }}</td>
                    <td class="px-2 py-1 border">
                        @foreach($empresa->users as $user)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">
                                {{ $user->name }}
                            </span>
                        @endforeach
                    </td>
                    <td class="px-2 py-1 border space-x-2">
                        @if (auth()->user()->is_admin)
                            <button wire:click="edit({{ $empresa->id }})" class="text-blue-600 hover:underline">Editar</button>
                            <button wire:click="confirmDelete({{ $empresa->id }})" class="text-red-600 hover:underline">Excluir</button>
                        @else
                            <span class="text-gray-400 italic">Acesso restrito</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-2 py-4 text-center text-gray-500">Nenhuma empresa cadastrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
