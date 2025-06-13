<div class="p-4 space-y-4">
@if ($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">Tem certeza que deseja excluir?</h2>
            <p>Esta ação não pode ser desfeita.</p>
            <div class="mt-4 flex gap-2">
                <button wire:click="deleteUser" class="bg-red-600 text-white px-4 py-2 rounded">Sim, excluir</button>
                <button wire:click="$set('confirmingDelete', false)" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
            </div>
        </div>
    </div>
@endif
    <form wire:submit.prevent="save">
        <input wire:model="name" type="text" placeholder="Nome" class="border p-1 rounded w-full">
        <input wire:model="email" type="email" placeholder="Email" class="border p-1 rounded w-full mt-2">
        <input wire:model="password" type="password" placeholder="Senha" class="border p-1 rounded w-full mt-2">
        <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">
            {{ $isEdit ? 'Atualizar' : 'Criar' }}
        </button>
        @if ($isEdit)
            <button type="button" wire:click="resetForm" class="mt-2 ml-2 px-4 py-2 bg-gray-400 text-white rounded">Cancelar</button>
        @endif
    </form>

    <hr>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-2 py-1">ID</th>
                <th class="px-2 py-1">Nome</th>
                <th class="px-2 py-1">Email</th>
                <th class="px-2 py-1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t">
                    <td class="px-2 py-1">{{ $user->id }}</td>
                    <td class="px-2 py-1">{{ $user->name }}</td>
                    <td class="px-2 py-1">{{ $user->email }}</td>
                    <td class="px-2 py-1 space-x-2">
                        <button wire:click="edit({{ $user->id }})" class="text-blue-500">Editar</button>
                        <button wire:click="confirmDelete({{ $user->id }})" class="text-red-500">Excluir</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
