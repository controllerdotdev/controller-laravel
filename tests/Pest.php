<?php

// Configurações globais para os testes
uses()->beforeEach(function () {
    // Preparação global antes de cada teste
})->afterEach(function () {
    \Mockery::close(); // Limpeza após cada teste
})->in(__DIR__);
