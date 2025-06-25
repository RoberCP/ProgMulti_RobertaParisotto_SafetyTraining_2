<div class="p-4 space-y-4 bg-white min-h-screen">

    {{-- Menu bar de navegação --}}
    <nav class="flex gap-4 bg-green-50 p-3 rounded shadow mb-4">
        <a href="{{ route('dashboard') }}" class="text-green-700 hover:underline">Dashboard</a>
        <a href="{{ route('empresas') }}" class="text-green-700 hover:underline">Empresas</a>
        <a href="{{ route('usuarios') }}" class="text-green-700 hover:underline">Usuários</a>
        <a href="{{ route('funcionarios') }}" class="text-green-700 hover:underline">Funcionários</a>
        <a href="{{ route('cursos') }}" class="text-green-700 hover:underline">Cursos</a>
        <a href="{{ route('certificados') }}" class="text-green-700 font-semibold">Certificados</a>
    </nav>

    {{-- Mensagem de sucesso --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Modal de confirmação --}}
    @if ($confirmingDelete)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold text-gray-800">Tem certeza que deseja excluir este certificado?</h2>
                <p class="text-gray-600">Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex gap-2 justify-end">
                    <button wire:click="deleteCertificado" class="border border-red-600 text-red-600 px-4 py-2 rounded hover:bg-red-50 transition">Sim, excluir</button>
                    <button wire:click="$set('confirmingDelete', false)" class="border border-gray-500 text-gray-600 px-4 py-2 rounded hover:bg-gray-50 transition">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulário --}}
    <form wire:submit.prevent="save" class="space-y-2">
        <select wire:model="idCurso" class="border border-gray-300 p-2 rounded w-full">
            <option value="">Selecione o curso</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso->IdCurso }}">{{ $curso->nomeCurso }}</option>
            @endforeach
        </select>

        <select wire:model="idFuncionario" class="border border-gray-300 p-2 rounded w-full">
            <option value="">Selecione o funcionário</option>
            @foreach($funcionarios as $funcionario)
                <option value="{{ $funcionario->idFuncionario }}">{{ $funcionario->nome }}</option>
            @endforeach
        </select>

        <input wire:model="dataEmissao" type="date" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="carga_horaria" type="number" placeholder="Carga horária" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="instrutor" type="text" placeholder="Instrutor" class="border border-gray-300 p-2 rounded w-full">
        <input wire:model="progresso" type="text" placeholder="Progresso" class="border border-gray-300 p-2 rounded w-full">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Assinatura do Instrutor --}}
            <div>
                <label class="block mb-1 font-semibold">Assinatura do Instrutor:</label>
                <div class="border border-gray-300 rounded bg-white">
                    <canvas id="canvasInstrutor" class="w-full h-40"></canvas>
                </div>
                <button type="button" onclick="clearSignature('instrutor')" class="mt-1 text-sm text-red-500 hover:underline">Limpar</button>
            </div>

            {{-- Assinatura do Funcionário --}}
            <div>
                <label class="block mb-1 font-semibold">Assinatura do Funcionário:</label>
                <div class="border border-gray-300 rounded bg-white">
                    <canvas id="canvasFuncionario" class="w-full h-40"></canvas>
                </div>
                <button type="button" onclick="clearSignature('funcionario')" class="mt-1 text-sm text-red-500 hover:underline">Limpar</button>
            </div>
        </div>

        <input type="hidden" wire:model.defer="assinaturaInstrutorBase64" id="assinaturaInstrutorBase64">
        <input type="hidden" wire:model.defer="assinaturaFuncionarioBase64" id="assinaturaFuncionarioBase64">


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

    {{-- Tabela --}}
    <table class="table-auto w-full border border-gray-300 bg-white">
        <thead class="bg-green-50 text-green-800">
            <tr>
                <th class="px-2 py-1 border">ID</th>
                <th class="px-2 py-1 border">Curso</th>
                <th class="px-2 py-1 border">Funcionário</th>
                <th class="px-2 py-1 border">Data Emissão</th>
                <th class="px-2 py-1 border">Instrutor</th>
                <th class="px-2 py-1 border">Progresso</th>
                <th class="px-2 py-1 border">Assinaturas</th>
                <th class="px-2 py-1 border">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($certificados as $certificado)
                <tr class="border-t">
                    <td class="px-2 py-1 border">{{ $certificado->idCertificado }}</td>
                    <td class="px-2 py-1 border">{{ $certificado->curso->nomeCurso ?? 'N/A' }}</td>
                    <td class="px-2 py-1 border">{{ $certificado->funcionario->nome ?? 'N/A' }}</td>
                    <td class="px-2 py-1 border">{{ $certificado->dataEmissao }}</td>
                    <td class="px-2 py-1 border">{{ $certificado->instrutor }}</td>
                    <td class="px-2 py-1 border">{{ $certificado->progresso }}</td>
                    <td class="px-2 py-1 border">
                        Instrutor: {{ $certificado->assinatura_instrutor ? '✔' : '✘' }}<br>
                        Funcionário: {{ $certificado->assinatura_funcionario ? '✔' : '✘' }}
                    </td>
                    <td class="px-2 py-1 border space-x-2">
                        <button wire:click="edit({{ $certificado->idCertificado }})" class="border border-blue-600 text-blue-600 px-2 py-1 rounded hover:bg-blue-50">Editar</button>
                        <button wire:click="confirmDelete({{ $certificado->idCertificado }})" class="border border-red-600 text-red-600 px-2 py-1 rounded hover:bg-red-50">Excluir</button>
                        <a href="{{ route('certificado.pdf', $certificado->idCertificado) }}" target="_blank"
                            class="border border-green-600 text-green-600 px-2 py-1 rounded hover:bg-green-50">PDF</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-4">Nenhum certificado cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Script de assinatura --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        let padInstrutor, padFuncionario;

        function resizeCanvas(canvas, pad) {
            const ratio = window.devicePixelRatio || 1;
            const styles = getComputedStyle(canvas);
            const width = parseInt(styles.width);
            const height = parseInt(styles.height);

            canvas.width = width * ratio;
            canvas.height = height * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            pad.clear();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const canvasInstrutor = document.getElementById('canvasInstrutor');
            const canvasFuncionario = document.getElementById('canvasFuncionario');

            padInstrutor = new SignaturePad(canvasInstrutor);
            padFuncionario = new SignaturePad(canvasFuncionario);

            resizeCanvas(canvasInstrutor, padInstrutor);
            resizeCanvas(canvasFuncionario, padFuncionario);

            // Reajusta o canvas se a tela for redimensionada
            window.addEventListener('resize', () => {
                resizeCanvas(canvasInstrutor, padInstrutor);
                resizeCanvas(canvasFuncionario, padFuncionario);
            });

            document.querySelector('form').addEventListener('submit', () => {
                if (!padInstrutor.isEmpty()) {
                    document.getElementById('assinaturaInstrutorBase64').value = padInstrutor.toDataURL();
                }
                if (!padFuncionario.isEmpty()) {
                    document.getElementById('assinaturaFuncionarioBase64').value = padFuncionario.toDataURL();
                }
            });
        });

        function clearSignature(tipo) {
            if (tipo === 'instrutor') {
                padInstrutor.clear();
                document.getElementById('assinaturaInstrutorBase64').value = '';
            } else {
                padFuncionario.clear();
                document.getElementById('assinaturaFuncionarioBase64').value = '';
            }
        }
    </script>

</div>