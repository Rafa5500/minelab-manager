<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Process;

class ServerCard extends Component
{
    public $serviceName; // Ex: minecraft.service
    public $displayName; // Ex: Mundo Survival
    public $port;        // Ex: 25565

    public function render()
    {
        // Verifica o status no Linux
        $status = trim(Process::run("systemctl is-active {$this->serviceName}")->output());
        $isOnline = ($status === 'active');

        return view('livewire.server-card', [
            'isOnline' => $isOnline
        ]);
    }

    // Funções para os botões clicarem
    public function startServer()
    {
        Process::run("sudo systemctl start {$this->serviceName}");
    }

    public function stopServer()
    {
        Process::run("sudo systemctl stop {$this->serviceName}");
    }

    public function restartServer()
    {
        Process::run("sudo systemctl restart {$this->serviceName}");
    }
}
