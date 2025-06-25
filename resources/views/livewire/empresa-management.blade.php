<div class="p-4 space-y-4 bg-white min-h-screen">

    {{-- Menu bar de navegação --}}
    <nav class="flex gap-4 bg-green-50 p-3 rounded shadow mb-4">
        <a href="{{ route('dashboard') }}" class="text-green-700 hover:underline">Dashboard</a>
        <a href="{{ route('empresas') }}" class="text-green-700 font-semibold">Empresas</a>
        <a href="{{ route('usuarios') }}" class="text-green-700 hover:underline">Usuários</a>
        <a href="{{ route('funcionarios') }}" class="text-green-700 hover:underline">Funcionários</a>
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
                <h2 class="text-lg font-semibold text-gray-800">Tem certeza que deseja excluir esta empresa?</h2>
                <p class="text-gray-600">Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex gap-2 justify-end">
                    <button wire:click="deleteEmpresa" class="border border-red-600 text-red-600 px-4 py-2 rounded hover:bg-red-50 transition">Sim, excluir</button>
                    <button wire:click="$set('confirmingDelete', false)" class="border border-gray-500 text-gray-600 px-4 py-2 rounded hover:bg-gray-50 transition">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulário --}}
    <form wire:submit.prevent="save" class="space-y-2">
        <input wire:model="razao_social" type="text" placeholder="Razão Social" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="cnpj" type="text" placeholder="CNPJ" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="ramo" type="text" placeholder="Ramo de atuação" class="border border-gray-300 p-2 rounded w-full">

        @if (auth()->user()->is_admin)
            <label class="block mt-2 text-sm text-gray-700 font-medium">Vincular auditores:</label>
            <select wire:model="usuariosSelecionados" multiple class="border border-gray-300 p-2 rounded w-full h-32">
                @foreach($usuarios as $auditor)
                    <option value="{{ $auditor->id }}">{{ $auditor->name }} ({{ $auditor->email }})</option>
                @endforeach
            </select>
        @endif

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

    {{-- Tabela de empresas --}}
    <table class="table-auto w-full border border-gray-300 bg-white">
        <thead class="bg-green-50 text-green-800">
            <tr>
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
                            <button wire:click="edit({{ $empresa->id }})" class="border border-blue-600 text-blue-600 px-2 py-1 rounded hover:bg-blue-50">Editar</button>
                            <button wire:click="confirmDelete({{ $empresa->id }})" class="border border-red-600 text-red-600 px-2 py-1 rounded hover:bg-red-50">Excluir</button>
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
