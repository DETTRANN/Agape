<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Agendar verificação diária de produtos vencidos (executa às 00:05 todos os dias)
Schedule::command('produtos:marcar-vencidos')->dailyAt('00:05');
