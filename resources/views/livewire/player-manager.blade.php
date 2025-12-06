<div class="bg-gray-800 rounded-lg p-6 border border-gray-700 shadow-lg" wire:poll.5s>
    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
        <i class="ph ph-users"></i> Jogadores: {{ $serverName }}
    </h3>

    <div class="space-y-2 mb-6">
        @php $players = $players; @endphp
        
        @if(isset($players['error']))
            <div class="text-red-400 text-sm bg-red-900/30 p-2 rounded">
                <i class="ph ph-warning"></i> {{ $players['error'] }}
            </div>
        @elseif(count($players) > 0)
            @foreach($players as $player)
                <div class="bg-gray-700 p-2 rounded flex justify-between items-center group">
                    <div class="flex items-center gap-2">
                        <img src="https://minotar.net/avatar/{{ $player }}/32" class="rounded">
                        <span class="text-white font-semibold">{{ $player }}</span>
                    </div>
                    
                    <div class="opacity-100 flex gap-1">
                        <button wire:click="gamemode('{{ $player }}', 'creative')" title="Criativo" class="p-1 text-blue-400 hover:bg-blue-900 rounded"><i class="ph ph-magic-wand"></i></button>
                        <button wire:click="gamemode('{{ $player }}', 'survival')" title="Sobrevivência" class="p-1 text-green-400 hover:bg-green-900 rounded"><i class="ph ph-heart"></i></button>
                        <button wire:click="kickPlayer('{{ $player }}')" title="Expulsar" class="p-1 text-red-400 hover:bg-red-900 rounded"><i class="ph ph-boot"></i></button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-gray-500 text-sm italic text-center py-4">
                Nenhum jogador online.
            </div>
        @endif
    </div>

    <form wire:submit.prevent="sendCommand" class="flex gap-2">
        <input type="text" wire:model="commandInput" placeholder="/say Olá mundo..." class="bg-gray-900 border border-gray-600 text-white text-sm rounded block w-full p-2.5 focus:border-emerald-500 focus:ring-emerald-500">
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 rounded font-bold">
            <i class="ph ph-paper-plane-right"></i>
        </button>
    </form>

    @if(count($commandLog) > 0)
        <div class="mt-4 text-xs font-mono bg-black rounded p-2 max-h-32 overflow-y-auto space-y-1">
            @foreach($commandLog as $log)
                <div>
                    <span class="text-gray-500">[{{ $log['time'] }}]</span>
                    <span class="text-emerald-400">> {{ $log['cmd'] }}</span>
                    <span class="text-gray-300"> -> {{ $log['response'] }}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
