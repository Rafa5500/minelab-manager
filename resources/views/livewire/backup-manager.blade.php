<div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="ph ph-hard-drives"></i> Backups: {{ ucfirst($backupName) }}
        </h3>

        <button 
            wire:click="createBackup" 
            wire:loading.attr="disabled"
            class="bg-blue-600 hover:bg-blue-500 disabled:opacity-50 text-white px-4 py-2 rounded text-sm font-bold transition flex items-center gap-2"
        >
            <i class="ph ph-download-simple" wire:loading.remove></i>
            <i class="ph ph-spinner animate-spin" wire:loading></i>
            <span wire:loading.remove>Criar Novo</span>
            <span wire:loading>Gerando...</span>
        </button>
    </div>

    <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
        @forelse($backups as $backup)
            <div class="bg-gray-700 p-3 rounded flex justify-between items-center group">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-900 p-2 rounded text-blue-300">
                        <i class="ph ph-file-archive"></i>
                    </div>
                    <div class="text-sm">
                        <p class="text-gray-200 font-mono">{{ basename($backup) }}</p>
                        <p class="text-xs text-gray-500">
                            {{ number_format(Storage::disk('public')->size($backup) / 1024 / 1024, 2) }} MB
                        </p>
                    </div>
                </div>

                <a href="/storage/{{ $backup }}" target="_blank" class="text-gray-400 hover:text-white p-2">
                    <i class="ph ph-download text-xl"></i>
                </a>
            </div>
        @empty
            <div class="text-gray-500 text-sm text-center py-4 border border-dashed border-gray-600 rounded">
                Nenhum backup encontrado.
            </div>
        @endforelse
    </div>
</div>
