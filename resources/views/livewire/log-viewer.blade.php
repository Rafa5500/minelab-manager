<div class="bg-gray-900 rounded-lg border border-gray-700 shadow-lg overflow-hidden flex flex-col h-96">
    <div class="bg-gray-800 p-3 border-b border-gray-700 flex justify-between items-center">
        <h3 class="text-sm font-mono text-gray-300 flex items-center gap-2">
            <i class="ph ph-terminal-window"></i> Console: {{ $serviceName }}
        </h3>
        <span class="text-xs text-emerald-500 animate-pulse">● Ao Vivo</span>
    </div>

    <div 
        wire:poll.2s 
        class="flex-1 overflow-y-auto p-4 font-mono text-xs space-y-1 bg-black text-gray-300"
        id="console-{{ \Illuminate\Support\Str::slug($serviceName) }}"
    >
        @forelse($output as $line)
            <div class="break-words hover:bg-gray-800 p-0.5 rounded">
                {{-- Limpeza básica de data para poupar espaço --}}
                <span class="text-gray-500 select-none mr-2">
                    {{ substr($line, 0, 15) }}...
                </span>

                {{-- Tenta destacar erros em vermelho e infos em azul --}}
                @if(str_contains($line, 'ERROR') || str_contains($line, 'Exception'))
                    <span class="text-red-400">{{ substr($line, 15) }}</span>
                @elseif(str_contains($line, 'WARN'))
                    <span class="text-yellow-400">{{ substr($line, 15) }}</span>
                @elseif(str_contains($line, 'INFO'))
                    <span class="text-blue-300">{{ substr($line, 15) }}</span>
                @else
                    <span class="text-gray-300">{{ substr($line, 15) }}</span>
                @endif
            </div>
        @empty
            <div class="text-gray-600 italic">Nenhum log encontrado ou serviço parado...</div>
        @endforelse
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const consoleDiv = document.getElementById("console-{{ \Illuminate\Support\Str::slug($serviceName) }}");
            // Rola para o fim ao carregar
            consoleDiv.scrollTop = consoleDiv.scrollHeight;

            // Rola para o fim a cada atualização do Livewire
            Livewire.hook('morph.updated', ({ el, component }) => {
                consoleDiv.scrollTop = consoleDiv.scrollHeight;
            });
        });
    </script>
</div>
