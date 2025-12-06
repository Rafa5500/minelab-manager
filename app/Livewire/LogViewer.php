<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Process;

class LogViewer extends Component
{
    public $serviceName;
    public $logs = [];

    public function mount($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    public function getLogsProperty()
    {
        // Pega as últimas 100 linhas
        $cmd = "sudo journalctl -u {$this->serviceName} -n 100 --no-pager";
        $output = Process::run($cmd)->output();

        // Transforma em lista
        $lines = explode("\n", $output);

        // FILTRO: Remove as linhas de spam do RCON
        return array_filter($lines, function($line) {
            // Se a linha estiver vazia, remove
            if (empty(trim($line))) return false;

            // Se for spam de conexão RCON, esconde!
            if (str_contains($line, 'RCON Client')) return false;
            if (str_contains($line, 'RCON Listener')) return false;

            // Se passou pelos testes, mostra a linha
            return true;
        });
    }
    public function render()
    {
        return view('livewire.log-viewer', [
            'output' => $this->getLogsProperty()
        ]);
    }
}
