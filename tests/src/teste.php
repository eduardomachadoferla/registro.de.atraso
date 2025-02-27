<?php

use PHPUnit\Framework\Teste;

class Relogio {
    public function atualizarRelogio() {
        $agora = new DateTime();
        return $agora->format('H:i:s');
    }
}