<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserAvatarController;

// Página inicial
Route::get('/', function () {
    return view('index');
})->name('home');

// Rotas de autenticação
Route::get('/login', function () {
    return view('login');
})->name('auth.login.form');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Views estáticas auxiliares (acesso simples)
Route::get('/views/login', function () {
    return redirect()->route('auth.login.form');
});

Route::get('/views/register', function () {
    return view('register');
});

// Rotas protegidas - apenas para usuários autenticados
Route::middleware(['auth', 'force.auth'])->group(function () {
    // Página do sistema (protegida) - rota principal
    Route::get('/system', [\App\Http\Controllers\SystemController::class, 'index'])->name('system.page');

    // Rotas do estoque
    Route::get('/views/tabela_estoque', [ProdutoController::class, 'index'])->name('tabela_estoque');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::put('/produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
    Route::post('/categoria-config', [ProdutoController::class, 'salvarConfigCategoria'])->name('categoria.config.save');

    // Rota de relatórios
    Route::get('/views/relatorios', [ProdutoController::class, 'relatorios'])->name('relatorios');
    Route::get('/views/graficos-relatorios', [ProdutoController::class, 'relatorios'])->name('graficos.relatorios');

    // Rotas de Transferências
    Route::prefix('transferencias')->name('transferencias.')->group(function () {
        Route::get('/', [App\Http\Controllers\TransferenciaController::class, 'index'])->name('index');
        Route::get('/criar', [App\Http\Controllers\TransferenciaController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\TransferenciaController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\TransferenciaController::class, 'show'])->name('show');
        Route::put('/{id}/iniciar', [App\Http\Controllers\TransferenciaController::class, 'iniciarTransferencia'])->name('iniciar');
        Route::put('/{id}/concluir', [App\Http\Controllers\TransferenciaController::class, 'concluirTransferencia'])->name('concluir');
        Route::put('/{id}/cancelar', [App\Http\Controllers\TransferenciaController::class, 'cancelarTransferencia'])->name('cancelar');
    });

    // Rotas de Auditoria
    Route::prefix('auditoria')->name('auditoria.')->group(function () {
        Route::get('/', [App\Http\Controllers\AuditoriaController::class, 'index'])->name('index');
        Route::get('/produto/{id}', [App\Http\Controllers\AuditoriaController::class, 'show'])->name('show');
        Route::get('/relatorio', [App\Http\Controllers\AuditoriaController::class, 'relatorio'])->name('relatorio');
    });

    // Rotas de Avatar
    Route::post('/user/avatar', [UserAvatarController::class, 'upload'])->name('user.avatar.upload');
    Route::delete('/user/avatar', [UserAvatarController::class, 'remove'])->name('user.avatar.remove');

    // Redireciona a rota antiga para a nova
    Route::get('/views/system', function () {
        return redirect()->route('system.page');
    });
});

// Registro de clientes
Route::get('/register', [ClienteController::class, 'create'])->name('register');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// Rotas de redefinição de senha
Route::get('/password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// Redirecionamento para compatibilidade
Route::get('/views/pwdredefinition', function () {
    return redirect()->route('password.request');
});

// Rota de teste para verificar autenticação
Route::get('/auth-test', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
        'guard' => config('auth.defaults.guard')
    ]);
});

// Rota para forçar logout (teste)
Route::get('/force-logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return response()->json(['message' => 'Logout realizado']);
});

// Rota de contato (apenas para exibir a página)
Route::get('/views/contato', function () {
    return view('contato');
})->name('contato');

Route::get('/views/termos-privacidade', function () {
    return view('termos-privacidade');
})->name('termos.privacidade');