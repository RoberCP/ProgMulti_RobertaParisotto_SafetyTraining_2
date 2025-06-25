<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-green-700">
                <h1 class="text-3xl font-bold mb-6">Bem-vindo ao Safety Training!</h1>
                <p class="mb-6 text-gray-700">Escolha uma das opções abaixo para começar:</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('empresas') }}" class="flex items-center justify-center bg-white border border-green-600 rounded-lg shadow p-6 hover:bg-green-50 transition">
                        <span class="text-green-700 font-bold">Gerenciar Empresas</span>
                    </a>
                    <a href="{{ route('usuarios') }}" class="flex items-center justify-center bg-white border border-green-600 rounded-lg shadow p-6 hover:bg-green-50 transition">
                        <span class="text-green-700 font-bold">Gerenciar Usuários</span>
                    </a>
                    <a href="{{ route('funcionarios') }}" class="flex items-center justify-center bg-white border border-green-600 rounded-lg shadow p-6 hover:bg-green-50 transition">
                        <span class="text-green-700 font-bold">Gerenciar Funcionários</span>
                    </a>
                    <a href="{{ route('cursos') }}" class="flex items-center justify-center bg-white border border-green-600 rounded-lg shadow p-6 hover:bg-green-50 transition">
                        <span class="text-green-700 font-bold">Gerenciar Cursos</span>
                    </a>
                    <a href="{{ route('certificados') }}" class="flex items-center justify-center bg-white border border-green-600 rounded-lg shadow p-6 hover:bg-green-50 transition">
                        <span class="text-green-700 font-bold">Gerenciar Certificados</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
