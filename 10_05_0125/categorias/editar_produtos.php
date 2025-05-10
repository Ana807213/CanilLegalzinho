<!-- filepath: c:\xampp\htdocs\Canil\admin\categorias\editar_produto.php -->
<?php
include '../banco.php'; // Inclua sua conexão com o banco de dados

// Verificar se o ID foi passado
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Buscar os dados do produto no banco
    $sql = "SELECT * FROM PRODUTOS WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
    } else {
        echo "<script>
            alert('Produto não encontrado.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('ID do produto não informado.');
        window.location.href = 'index.php';
    </script>";
    exit;
}

// Atualizar os dados do produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria'];
    $produto = $_POST['produto'];
    $quantidade = (int) $_POST['quantidade'];
    $valor_unitario = (float) $_POST['valor_unitario'];
    $id = (int) $_POST['id'];

    $sql = "UPDATE PRODUTOS SET CATEGORIA = ?, PRODUTO = ?, QUANTIDADE = ?, VALOR_UNITARIO = ? WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssidi", $categoria, $produto, $quantidade, $valor_unitario, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Produto atualizado com sucesso!');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao atualizar o produto.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <form action="editar_produto.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $produto['ID']; ?>">

        <label for="categoria">Categoria:</label>
        <input type="text" id="categoria" name="categoria" value="<?php echo $produto['CATEGORIA']; ?>" required>

        <label for="produto">Produto:</label>
        <input type="text" id="produto" name="produto" value="<?php echo $produto['PRODUTO']; ?>" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" value="<?php echo $produto['QUANTIDADE']; ?>" required>

        <label for="valor_unitario">Valor Unitário:</label>
        <input type="number" step="0.01" id="valor_unitario" name="valor_unitario" value="<?php echo $produto['VALOR_UNITARIO']; ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>