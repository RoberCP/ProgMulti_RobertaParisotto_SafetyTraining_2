<div class="p-4 space-y-4 bg-white min-h-screen">

    {{-- Menu bar de navegação --}}
    <nav class="flex gap-4 bg-green-50 p-3 rounded shadow mb-4">
        <a href="{{ route('dashboard') }}" class="text-green-700 hover:underline">Dashboard</a>
        <a href="{{ route('empresas') }}" class="text-green-700 hover:underline">Empresas</a>
        <a href="{{ route('usuarios') }}" class="text-green-700 font-semibold">Usuários</a>
        <a href="{{ route('funcionarios') }}" class="text-green-700 hover:underline">Funcionários</a>
        <a href="{{ route('cursos') }}" class="text-green-700 hover:underline">Cursos</a>
        <a href="{{ route('certificados') }}" class="text-green-700 hover:underline">Certificados</a>
    </nav>

    {{-- Modal de confirmação de exclusão --}}
    @if ($confirmingDelete)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold text-gray-800">Tem certeza que deseja excluir?</h2>
                <p class="text-gray-600">Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex gap-2">
                    <button wire:click="deleteUser" class="border border-red-600 text-red-600 px-4 py-2 rounded hover:bg-red-50 transition">Sim, excluir</button>
                    <button wire:click="$set('confirmingDelete', false)" class="border border-gray-500 text-gray-600 px-4 py-2 rounded hover:bg-gray-50 transition">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulário --}}
    <form wire:submit.prevent="save" class="space-y-2">
        <input wire:model="name" type="text" placeholder="Nome" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="email" type="email" placeholder="Email" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="password" type="password" placeholder="Senha" class="border border-gray-300 p-2 rounded w-full">

        <div class="flex gap-2 mt-2">
            <button type="submit" class="border border-green-600 text-green-600 font-semibold px-4 py-2 rounded hover:bg-green-50 transition">
                {{ $isEdit ? 'Atualizar' : 'Criar' }}
            </button>
            @if ($isEdit)
                <button type="button" wire:click="resetForm" class="border border-gray-500 text-gray-600 px-4 py-2 rounded hover:bg-gray-50 transition">
                    Cancelar
                </button>
            @endif
        </div>
    </form>

    <hr class="my-4">

    {{-- Tabela --}}
    <table class="table-auto w-full border border-gray-300 bg-white">
        <thead class="bg-green-50 text-green-800">
            <tr>
                <th class="px-2 py-1 border">ID</th>
                <th class="px-2 py-1 border">Nome</th>
                <th class="px-2 py-1 border">Email</th>
                <th class="px-2 py-1 border">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-t">
                    <td class="px-2 py-1 border">{{ $user->id }}</td>
                    <td class="px-2 py-1 border">{{ $user->name }}</td>
                    <td class="px-2 py-1 border">{{ $user->email }}</td>
                    <td class="px-2 py-1 border space-x-1">
                        <button wire:click="edit({{ $user->id }})" class="border border-blue-600 text-blue-600 px-2 py-1 rounded hover:bg-blue-50 transition">Editar</button>
                        <button wire:click="confirmDelete({{ $user->id }})" class="border border-red-600 text-red-600 px-2 py-1 rounded hover:bg-red-50 transition">Excluir</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-2 py-4 text-center text-gray-500">Nenhum usuário cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
