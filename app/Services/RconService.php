<?php

namespace App\Services;

class RconService
{
    private $socket;
    private $host;
    private $port;
    private $password;
    private $timeout;
    private $authorized = false;
    private $lastError = '';

    const PACKET_AUTHORIZE = 3;
    const PACKET_COMMAND = 2;
    const SERVERDATA_AUTH_RESPONSE = 2;

    public function __construct($host, $port, $password, $timeout = 3)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->timeout = $timeout;
    }

    public function connect()
    {
        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);

        if (!$this->socket) {
            $this->lastError = $errstr;
            return false;
        }

        // Define timeout do socket
        stream_set_timeout($this->socket, $this->timeout);

        // Autentica
        return $this->authorize();
    }

    public function sendCommand($command)
    {
        if (!$this->authorized && !$this->connect()) {
            return false;
        }

        // Envia pacote de comando
        $this->writePacket(self::PACKET_COMMAND, $command);

        // Lê resposta
        $response = $this->readPacket();

        return $response['body'];
    }

    public function disconnect()
    {
        if ($this->socket) {
            fclose($this->socket);
            $this->socket = null;
        }
    }

    private function authorize()
    {
        $this->writePacket(self::PACKET_AUTHORIZE, $this->password);
        $response = $this->readPacket();

        if ($response['type'] == self::SERVERDATA_AUTH_RESPONSE) {
            // Se o ID retornado for -1, a senha está errada
            if ($response['id'] == -1) {
                return false;
            }
            $this->authorized = true;
            return true;
        }
        return false;
    }

    private function writePacket($type, $body)
    {
        $id = rand(1, 10000); // ID aleatório para o pacote
        $packet = pack("VV", $id, $type) . $body . "\x00\x00";
        $size = strlen($packet);
        
        // Escreve tamanho + pacote
        fwrite($this->socket, pack("V", $size));
        fwrite($this->socket, $packet);
    }

    private function readPacket()
    {
        // Lê os primeiros 4 bytes (tamanho)
        $sizeData = fread($this->socket, 4);
        if (strlen($sizeData) < 4) return ['body' => ''];
        
        $size = unpack("V1size", $sizeData)['size'];
        
        // Lê o resto do pacote
        $packetData = fread($this->socket, $size);
        
        // Desempacota: ID (4 bytes), Type (4 bytes), Body (String)
        // Nota: O formato exato pode variar ligeiramente, mas isso cobre o padrão Source/Minecraft
        $data = unpack("V1id/V1type/a*body", $packetData);
        
        // Remove os dois bytes nulos finais do body
        $data['body'] = substr($data['body'], 0, -2);
        
        return $data;
    }
}
