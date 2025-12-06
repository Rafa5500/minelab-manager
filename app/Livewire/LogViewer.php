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
        // Pega as últimas 50 linhas do log (-n 50) sem paginação (--no-pager)
        // O comando 'tac' inverte a ordem (para o mais recente ficar no topo se quiser, 
        // mas vamos manter padrão).
        $cmd = "sudo journalctl -u {$this->serviceName} -n 100 --no-pager";

        $output = Process::run($cmd)->output();

        // Transforma o texto em um array de linhas e remove linhas vazias
        return array_filter(explode("\n", $output));
    }

    public function render()
    {
        return view('livewire.log-viewer', [
            'output' => $this->getLogsProperty()
        ]);
    }
}
