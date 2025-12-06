<div wire:poll.5s class="bg-gray-800 rounded-lg p-6 border border-gray-700 shadow-lg">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h3 class="text-lg font-bold text-white">{{ $displayName }}</h3>
            <p class="text-sm text-gray-400">Serviço: {{ $serviceName }}</p>
            <p class="text-xs text-gray-500 mt-1">Porta: {{ $port }}</p>
        </div>

        <div class="flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold {{ $isOnline ? 'bg-emerald-900 text-emerald-300' : 'bg-red-900 text-red-300' }}">
            <div class="w-2 h-2 rounded-full {{ $isOnline ? 'bg-emerald-400 animate-pulse' : 'bg-red-400' }}"></div>
            {{ $isOnline ? 'ONLINE' : 'OFFLINE' }}
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2 mt-4">
        @if(!$isOnline)
            <button wire:click="startServer" class="bg-emerald-600 hover:bg-emerald-500 text-white py-2 rounded text-sm font-semibold transition">
                <i class="ph ph-play"></i> Iniciar
            </button>
        @else
            <button wire:click="stopServer" class="bg-red-600 hover:bg-red-500 text-white py-2 rounded text-sm font-semibold transition">
                <i class="ph ph-stop"></i> Parar
            </button>
            <button wire:click="restartServer" class="bg-yellow-600 hover:bg-yellow-500 text-white py-2 rounded text-sm font-semibold transition">
                <i class="ph ph-arrows-clockwise"></i> Reiniciar
            </button>
        @endif
    </div>
</div>
