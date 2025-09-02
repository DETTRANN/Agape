<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Cliente;

class PasswordResetController extends Controller
{
    /**
     * Exibe o formulário de solicitação de redefinição de senha
     */
    public function showLinkRequestForm()
    {
        return view('pwdredefinition');
    }

    /**
     * Processa o envio do link de redefinição de senha
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:clientes,email',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.exists' => 'Este email não está cadastrado em nosso sistema.',
        ]);

        // Buscar o cliente
        $cliente = Cliente::where('email', $request->email)->first();

        if (!$cliente) {
            return back()->withErrors(['email' => 'Email não encontrado.']);
        }

        // Gerar token único
        $token = Str::random(64);

        // Remover tokens antigos para este email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Inserir novo token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // Simular envio de email (em produção você configuraria o email real)
        // Por enquanto, vamos redirecionar com o token para teste
        
        return redirect()->route('password.reset.form', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Exibe o formulário de redefinição de senha
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('pwdreset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Processa a redefinição da senha
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:clientes,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'token.required' => 'Token de redefinição é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.exists' => 'Este email não está cadastrado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        // Verificar se o token existe e é válido
        $passwordReset = DB::table('password_reset_tokens')
                           ->where('email', $request->email)
                           ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token de redefinição inválido.']);
        }

        // Verificar se o token não expirou (válido por 60 minutos)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token de redefinição expirado.']);
        }

        // Verificar se o token coincide
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token de redefinição inválido.']);
        }

        // Atualizar a senha do cliente
        $cliente = Cliente::where('email', $request->email)->first();
        $cliente->senha = Hash::make($request->password);
        $cliente->save();

        // Remover o token usado
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('auth.login.form')
                        ->with('status', 'Senha redefinida com sucesso! Faça login com sua nova senha.');
    }
}
