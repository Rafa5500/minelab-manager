use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Process;

// Agendamento do Backup (Todo dia às 04:00)
Schedule::call(function () {
    // Backup do Servidor 1
    Process::run('sudo /usr/local/bin/mine-backup.sh server_mine principal_auto');

    // Backup do Servidor 2
    Process::run('sudo /usr/local/bin/mine-backup.sh server_mine_2 vanilla_auto');
})->dailyAt('04:00');

// Limpeza de Backups Antigos (Opcional: roda todo domingo)
// Apaga arquivos .zip com mais de 7 dias para não encher o disco
Schedule::exec('find /var/www/minelab/storage/app/public/backups -name "*.zip" -mtime +7 -delete')
        ->weekly();
