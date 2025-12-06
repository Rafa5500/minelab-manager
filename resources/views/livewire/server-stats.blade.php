<div wire:poll.3s class="bg-gray-800 rounded-lg p-6 border border-gray-700 shadow-lg mb-6">
    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
        <i class="ph ph-cpu"></i> Status do Servidor
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div>
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-300">CPU Load</span>
                <span class="text-sm font-medium {{ $stats['cpu'] > 80 ? 'text-red-400' : 'text-emerald-400' }}">
                    {{ $stats['cpu'] }}%
                </span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" 
                     style="width: {{ $stats['cpu'] }}%"></div>
            </div>
        </div>

        <div>
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-300">Memória RAM</span>
                <span class="text-sm font-medium {{ $stats['ram'] > 90 ? 'text-red-400' : 'text-purple-400' }}">
                    {{ $stats['ram'] }}%
                </span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
                <div class="bg-purple-600 h-2.5 rounded-full transition-all duration-500" 
                     style="width: {{ $stats['ram'] }}%"></div>
            </div>
        </div>

        <div>
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-300">Disco (SSD)</span>
                <span class="text-sm font-medium {{ $stats['disk'] > 90 ? 'text-red-400' : 'text-yellow-400' }}">
                    {{ $stats['disk'] }}%
                </span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
                <div class="bg-yellow-600 h-2.5 rounded-full transition-all duration-500" 
                     style="width: {{ $stats['disk'] }}%"></div>
            </div>
        </div>

    </div>
</div>
