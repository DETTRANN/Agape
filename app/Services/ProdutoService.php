<?php

namespace App\Services;

use App\Repositories\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProdutoService
{
    protected $produtoRepository;
    protected $auditoriaService;
    protected $estatisticasService;

    public function __construct(
        ProdutoRepositoryInterface $produtoRepository,
        AuditoriaService $auditoriaService,
        EstatisticasService $estatisticasService
    ) {
        $this->produtoRepository = $produtoRepository;
        $this->auditoriaService = $auditoriaService;
        $this->estatisticasService = $estatisticasService;
    }

    /**
     * Busca produtos do usuário
     */
    public function buscarProdutosDoUsuario()
    {
        $produtos = $this->produtoRepository->findByUser(Auth::id());
        return $produtos ?: collect();
    }

    /**
     * Busca categorias únicas dos produtos
     */
    public function buscarCategoriasDoUsuario()
    {
        return $this->buscarProdutosDoUsuario()->pluck('categoria')->unique()->values();
    }

    /**
     * Busca configurações de categorias
     */
    public function buscarConfigsCategorias()
    {
        return \App\Models\CategoriaConfiguracao::where('user_id', Auth::id())
            ->pluck('dias_alerta_validade', 'nome_categoria')
            ->toArray();
    }

    /**
     * Cria um novo produto
     */
    public function criarProduto(array $dados): \App\Models\Produto
    {
        $userId = Auth::id();
        
        // Verificar se o usuário existe (agora usando Cliente)
        if (!$userId || !\App\Models\Cliente::find($userId)) {
            throw new \Exception('Sessão inválida. Faça login novamente.');
        }

        // Gerar próximo ID sequencial para este usuário específico
        $ultimoIdDoUsuario = \App\Models\Produto::where('user_id', $userId)->max('id_item');
        $proximoNumero = $ultimoIdDoUsuario ? (int)$ultimoIdDoUsuario + 1 : 1;
        $dados['id_item'] = (string)$proximoNumero;
        $dados['user_id'] = $userId;

        $produto = $this->produtoRepository->create($dados);

        // Registrar auditoria de criação
        $this->auditoriaService->registrarCriacao($produto->id, 'Produto criado: ' . $produto->nome_item);

        return $produto;
    }

    /**
     * Atualiza um produto
     */
    public function atualizarProduto(int $id, array $dados): \App\Models\Produto
    {
        // Obter produto anterior para auditoria
        $produtoAnterior = $this->produtoRepository->find($id);
        $produto = $this->produtoRepository->update($id, $dados);

        // Registrar alterações na auditoria
        if ($produtoAnterior) {
            foreach ($dados as $campo => $valorNovo) {
                $valorAnterior = $produtoAnterior->$campo ?? null;
                if ($valorAnterior != $valorNovo) {
                    $this->auditoriaService->registrarAtualizacao(
                        $id,
                        $campo,
                        $valorAnterior,
                        $valorNovo,
                        "Campo '{$campo}' alterado"
                    );
                }
            }
        }

        return $produto;
    }

    /**
     * Remove um produto
     */
    public function removerProduto(int $id): bool
    {
        // Obter produto antes da exclusão para auditoria
        $produto = $this->produtoRepository->find($id);
        
        if ($produto) {
            // Registrar auditoria de exclusão
            $this->auditoriaService->registrarExclusao($id, 'Produto removido: ' . $produto->nome_item);
        }
        
        return $this->produtoRepository->delete($id);
    }

    /**
     * Salva configuração de categoria
     */
    public function salvarConfigCategoria(string $nomeCategoria, bool $semValidade = false, int $diasAlerta = 30): void
    {
        $userId = Auth::id();
        
        // Interpretar a opção "Sem validade": armazenar 0 como sentinela para desativar alertas
        $dias = $semValidade ? 0 : $diasAlerta;
        
        // Atualizar ou criar configuração
        \App\Models\CategoriaConfiguracao::updateOrCreate(
            [
                'nome_categoria' => $nomeCategoria,
                'user_id' => $userId
            ],
            [
                'dias_alerta_validade' => $dias
            ]
        );
    }

    /**
     * Gera dados completos para a view do estoque
     */
    public function gerarDadosEstoque(): array
    {
        $produtos = $this->buscarProdutosDoUsuario();
        $estatisticas = $this->estatisticasService->calcularEstatisticasProdutos(Auth::id());
        $categorias = $this->buscarCategoriasDoUsuario();
        $configsCategorias = $this->buscarConfigsCategorias();

        return [
            'produtos' => $produtos,
            'totalItens' => $estatisticas['total_itens'],
            'itensOcupados' => $estatisticas['itens_ocupados'],
            'porcentagemOcupados' => $estatisticas['porcentagem_ocupados'],
            'estoqueAlerta' => $estatisticas['estoque_alerta'],
            'produtosProximosVencimento' => $estatisticas['produtos_proximos_vencimento'],
            'produtosVencidos' => $estatisticas['produtos_vencidos'],
            'categorias' => $categorias,
            'configsCategorias' => $configsCategorias,
        ];
    }
}
