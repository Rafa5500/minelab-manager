<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class BackupManager extends Component
{
    public $serverFolder; // ex: server_mine
    public $backupName;   // ex: principal
    public $isCreating = false;

    public function mount($serverFolder, $backupName)
    {
        $this->serverFolder = $serverFolder;
        $this->backupName = $backupName;
    }

    public function createBackup()
    {
        $this->isCreating = true;

        // Chama nosso script passando os argumentos
        Process::run("sudo /usr/local/bin/mine-backup.sh {$this->serverFolder} {$this->backupName}");

        $this->isCreating = false;

        // Avisa o usuário (opcional, requer configuração de flash message, mas vamos simplificar)
    }

    public function getBackupsProperty()
    {
        // Lista os arquivos .zip na pasta, ordenados do mais recente
        $files = Storage::disk('public')->files('backups');

        // Filtra apenas os que pertencem a este servidor (pelo nome)
        $myBackups = array_filter($files, fn($f) => str_contains($f, $this->backupName));

        return array_reverse($myBackups); // Mais recente primeiro
    }

    public function render()
    {
        return view('livewire.backup-manager', [
            'backups' => $this->getBackupsProperty()
        ]);
    }
}
