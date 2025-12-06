<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\RconService;

class PlayerManager extends Component
{
    public $port; // 25575 ou 25576
    public $password;
    public $serverName;
    
    // Comando para enviar (input)
    public $commandInput = '';
    public $commandLog = [];

    public function mount($port, $password, $serverName)
    {
        $this->port = $port;
        $this->password = $password;
        $this->serverName = $serverName;
    }

    public function getPlayersProperty()
    {
        // Conecta no RCON
        $rcon = new RconService('127.0.0.1', $this->port, $this->password);
        
        if (!$rcon->connect()) {
            return ['error' => 'Offline ou Senha Incorreta'];
        }

        // Pede a lista
        $response = $rcon->sendCommand('list');
        // Exemplo de resposta: "There are 2 of 20 players online: Rafael, Notch"
        
        $rcon->disconnect();

        // Processa o texto para pegar só os nomes
        if (strpos($response, ':') !== false) {
            $parts = explode(':', $response);
            $namesList = trim($parts[1]);
            if (empty($namesList)) return []; // Ninguém online
            
            return array_map('trim', explode(',', $namesList));
        }

        return [];
    }

    public function sendCommand($cmd = null)
    {
        $commandToSend = $cmd ?? $this->commandInput;
        
        if (empty($commandToSend)) return;

        $rcon = new RconService('127.0.0.1', $this->port, $this->password);
        if ($rcon->connect()) {
            $response = $rcon->sendCommand($commandToSend);
            
            // Adiciona ao log visual
            array_unshift($this->commandLog, [
                'cmd' => $commandToSend,
                'response' => $response,
                'time' => now()->format('H:i:s')
            ]);
            
            $rcon->disconnect();
        }
        
        $this->commandInput = '';
    }

    public function kickPlayer($player)
    {
        $this->sendCommand("kick $player Expulso pelo Painel Web");
    }
    
    public function gamemode($player, $mode)
    {
        $this->sendCommand("gamemode $mode $player");
    }

    public function render()
    {
        return view('livewire.player-manager', [
            'players' => $this->getPlayersProperty()
        ]);
    }
}
