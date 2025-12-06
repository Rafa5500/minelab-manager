<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Process;

class ServerStats extends Component
{
    public function getStatsProperty()
    {
        // 1. Uso de RAM (free -m)
        // Pega a linha da memória e calcula: (Usado / Total) * 100
        $ramCmd = "free -m | awk 'NR==2{printf \"%.0f\", $3*100/$2 }'";
        $ramUsage = (int) Process::run($ramCmd)->output();

        // 2. Uso de CPU (loadavg)
        // Pegamos a carga do último minuto. Em Linux, isso pode passar de 100% se tiver muitos núcleos,
        // mas para simplificar, vamos limitar visualmente a 100.
        $cpuLoad = sys_getloadavg()[0]; // Ex: 0.50, 1.20
        $cpuUsage = min(100, round($cpuLoad * 100 / 2)); // Assumindo 2 núcleos (ajuste se seu PC tiver mais)

        // 3. Uso de Disco (df -h)
        // Pega a porcentagem de uso da raiz (/)
        $diskCmd = "df -h / | awk 'NR==2{print $5}' | tr -d '%'";
        $diskUsage = (int) Process::run($diskCmd)->output();

        return [
            'cpu' => $cpuUsage,
            'ram' => $ramUsage,
            'disk' => $diskUsage
        ];
    }

    public function render()
    {
        return view('livewire.server-stats', [
            'stats' => $this->getStatsProperty()
        ]);
    }
}
