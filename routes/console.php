<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Http; // <--- Importante para enviar a requisição

// Funçãozinha para mandar mensagem pro Discord
function sendDiscord($message, $type = 'info') {
    $url = env('DISCORD_WEBHOOK_URL');
    
    if (!$url) return;

    // Cores: Verde (info) ou Vermelho (error)
    $color = $type === 'error' ? 15548997 : 5763719;

    Http::post($url, [
        'embeds' => [[
            'title' => '🔔 Notificação do MineLab',
            'description' => $message,
            'color' => $color,
            'timestamp' => now()->toISOString()
        ]]
    ]);
}

// O Agendamento
Schedule::call(function () {
    try {
        // Backup 1
        Process::run('sudo /usr/local/bin/mine-backup.sh server_mine principal_auto');
        
        // Backup 2
        Process::run('sudo /usr/local/bin/mine-backup.sh server_mine_2 vanilla_auto');

        // Se chegou aqui, deu certo!
        sendDiscord("✅ **Backup Automático Concluído!**\nOs mundos Principal e Vanilla foram salvos com sucesso.", 'info');

    } catch (\Exception $e) {
        // Se deu erro
        sendDiscord("⚠️ **Falha no Backup!**\nOcorreu um erro ao tentar salvar os mundos.", 'error');
    }
})->dailyAt('04:00');

// Limpeza semanal
Schedule::exec('find /var/www/minelab/storage/app/public/backups -name "*.zip" -mtime +7 -delete')
        ->weekly();
