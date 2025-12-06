<x-layouts.app>
    <livewire:server-stats />
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <livewire:server-card serviceName="minecraft.service" displayName="Mundo Principal" port="25565" />
        <livewire:server-card serviceName="minecraft2.service" displayName="Mundo Vanilla" port="25566" />
        <livewire:server-card serviceName="playit.service" displayName="Túnel Playit" port="Tunnel" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <h2 class="text-white font-bold mb-2">Log do Mundo Principal</h2>
            <livewire:log-viewer serviceName="minecraft.service" />
        </div>
        
        <div>
            <h2 class="text-white font-bold mb-2">Log do Mundo Vanilla</h2>
            <livewire:log-viewer serviceName="minecraft2.service" />
        </div>
    </div>
    <div class="mt-8">
    <h2 class="text-white font-bold mb-4 text-xl">Gerenciamento de Backups</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <livewire:backup-manager 
            serverFolder="server_mine" 
            backupName="principal" 
        />
        
        <livewire:backup-manager 
            serverFolder="server_mine_2" 
            backupName="vanilla" 
        />

    </div>
</x-layouts.app>
