<?php
// lista.php - Lista todos os produtos cadastrados
include_once('config.php');

// Remover item
if (isset($_GET['remover'])) {
    $id = intval($_GET['remover']);
    mysqli_query($conexao, "DELETE FROM produtos WHERE id = $id");
    header('Location: lista.php');
    exit();
}

// Adicionar item
if (isset($_POST['adicionar'])) {
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $quantidade = intval($_POST['quantidade']);
    $preco = floatval($_POST['preco']);
    $status = $_POST['status'];
    $data_validade = $_POST['data_validade'];
    $obs = $_POST['obs'];
    mysqli_query($conexao, "INSERT INTO produtos (nome_produto, descricao, categoria, quantidade, preco, status, data_validade, obs) VALUES ('$nome', '$descricao', '$categoria', $quantidade, $preco, '$status', '$data_validade', '$obs')");
    header('Location: lista.php');
    exit();
}

$where = '';
if (isset($_GET['filtro']) && $_GET['filtro'] !== '') {
    $filtro = mysqli_real_escape_string($conexao, $_GET['filtro']);
    if (!empty($_GET['coluna'])) {
        $coluna = $_GET['coluna'];
        $where = "WHERE $coluna LIKE '%$filtro%'";
    } else {
        $where = "WHERE nome_produto LIKE '%$filtro%' OR categoria LIKE '%$filtro%' OR status LIKE '%$filtro%'";
    }
}
$sql = "SELECT * FROM produtos $where ORDER BY id DESC";
$result = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body { background: #fbeada; }
        .container-lista { max-width: 1200px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #0001; padding: 30px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-novo { background: #3a10e5; color: #fff; border: none; border-radius: 6px; padding: 8px 18px; font-weight: bold; font-size: 16px; cursor: pointer; }
        .btn-remover { background: #e74c3c; color: #fff; border: none; border-radius: 6px; padding: 4px 12px; font-size: 14px; cursor: pointer; }
        .tabela-lista { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabela-lista th { background: #ffe599; color: #222; font-weight: bold; padding: 10px; }
        .tabela-lista td { background: #f9f9f9; padding: 8px; text-align: center; }
        .tabela-lista tr:nth-child(even) td { background: #f3f3f3; }
        .tabela-lista tr:hover td { background: #e6e6e6; }
        .status-ocupado { background: #3a10e5; color: #fff; border-radius: 5px; padding: 2px 10px; font-size: 13px; }
        .status-livre { background: #27ae60; color: #fff; border-radius: 5px; padding: 2px 10px; font-size: 13px; }
        .form-adicionar { display: none; background: #fffbe6; border: 1px solid #ffe599; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .form-adicionar input, .form-adicionar select { margin: 5px 10px 5px 0; padding: 6px; border-radius: 4px; border: 1px solid #ccc; }
        .form-adicionar label { font-size: 14px; margin-right: 5px; }
        .form-adicionar .btn-novo { margin-top: 10px; }
    </style>
    <script>
        function mostrarForm() {
            document.getElementById('formAdicionar').style.display = 'block';
        }
        function esconderForm() {
            document.getElementById('formAdicionar').style.display = 'none';
        }
    </script>
</head>
<body>
<div class="container-lista">
    <div class="top-bar">
        <div style="font-size:18px;font-weight:bold;">Produtos</div>
        <button class="btn-novo" onclick="mostrarForm()">+ Novo</button>
    </div>
    <form id="formAdicionar" class="form-adicionar" method="POST" action="">
        <label>Nome Produto:</label><input name="nome_produto" required>
        <label>Descrição:</label><input name="descricao">
        <label>Categoria:</label><input name="categoria">
        <label>Quantidade:</label><input name="quantidade" type="number" min="1" required>
        <label>Preço Unitário:</label><input name="preco" type="number" step="0.01" required>
        <label>Status:</label>
        <select name="status">
            <option value="Ocupado">Ocupado</option>
            <option value="Livre">Livre</option>
        </select>
        <label>Data Validade:</label><input name="data_validade" type="date">
        <label>Observações:</label><input name="obs">
        <button class="btn-novo" type="submit" name="adicionar">Adicionar</button>
        <button class="btn-novo" type="button" onclick="esconderForm()">Cancelar</button>
    </form>
    <form method="GET" style="margin-bottom:20px;display:flex;gap:10px;align-items:center;">
        <input type="text" name="filtro" placeholder="Digite para filtrar..." value="<?php echo isset($_GET['filtro']) ? htmlspecialchars($_GET['filtro']) : ''; ?>" style="padding:6px;border-radius:4px;border:1px solid #ccc;">
        <select name="coluna" style="padding:6px;border-radius:4px;border:1px solid #ccc;">
            <option value="">Todas as colunas</option>
            <option value="nome_produto" <?php if(isset($_GET['coluna']) && $_GET['coluna']=='nome_produto') echo 'selected'; ?>>Nome Produto</option>
            <option value="categoria" <?php if(isset($_GET['coluna']) && $_GET['coluna']=='categoria') echo 'selected'; ?>>Categoria</option>
            <option value="status" <?php if(isset($_GET['coluna']) && $_GET['coluna']=='status') echo 'selected'; ?>>Status</option>
        </select>
        <button class="btn-novo" type="submit">Filtrar</button>
        <a href="lista.php" class="btn-novo" style="background:#888;">Limpar</a>
    </form>
    <table class="tabela-lista">
        <tr>
            <th>ID Produto</th>
            <th>Status</th>
            <th>Nome Produto</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Data Validade</th>
            <th>Observações</th>
            <th>Ações</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><span class="status-<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></td>
            <td><?php echo $row['nome_produto']; ?></td>
            <td><?php echo $row['descricao']; ?></td>
            <td><?php echo $row['categoria']; ?></td>
            <td><?php echo $row['quantidade']; ?></td>
            <td><?php echo number_format($row['preco'],2,',','.'); ?></td>
            <td><?php echo $row['data_validade']; ?></td>
            <td><?php echo $row['obs']; ?></td>
            <td><a href="?remover=<?php echo $row['id']; ?>" class="btn-remover" onclick="return confirm('Remover este item?')">Remover</a></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
