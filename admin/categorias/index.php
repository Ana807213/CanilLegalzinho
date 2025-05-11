<?php
include '../banco.php'; // Inclua sua conexão com o banco de dados

// EXCLUSÃO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];

    // Excluir o produto do banco de dados
    $sql = "DELETE FROM PRODUTOS WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Produto excluído com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao excluir o produto.');</script>";
    }
    // Redirecionar para a mesma página
    header("Location: " . $_SERVER['PHP_SELF']); // Evitar reenvio do formulário
if ($stmt->execute()) {
    echo "<script>alert('Produto cadastrado com sucesso!');</script>";
    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para evitar reenvio
    exit;
} else {
    echo "<script>alert('Erro ao cadastrar o produto.');</script>";
}
    exit;
}
// CADASTRO E EDIÇÃO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $categoria = isset($_POST['categoria']) ? strtoupper($_POST['categoria']) : null; // Maiúsculas
    $produto = isset($_POST['produto']) ? strtoupper($_POST['produto']) : null; // Maiúsculas
    $quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : null;
    $valor_unitario = isset($_POST['valor_unitario']) ? (float) $_POST['valor_unitario'] : null;

    // Verificar se todos os campos obrigatórios estão preenchidos
    if ($categoria && $produto && $quantidade && $valor_unitario) {
        $valor_total = $quantidade * $valor_unitario;

        // Verificar se é edição ou cadastro
        if ($id) {
            // Atualizar produto
            $sql = "UPDATE PRODUTOS SET CATEGORIA = ?, PRODUTO = ?, QUANTIDADE = ?, VALOR_UNITARIO = ?, VALOR_TOTAL = ? WHERE ID = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssiddi", $categoria, $produto, $quantidade, $valor_unitario, $valor_total, $id);
            if ($stmt->execute()) {
                echo "<script>alert('Produto atualizado com sucesso!');</script>";
                header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para evitar reenvio
                exit;
            } else {
                echo "<script>alert('Erro ao atualizar o produto.');</script>";
            }
        } else {
            // Cadastrar novo produto
            $fotoDestino = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $fotoTmp = $_FILES['foto']['tmp_name'];
                $fotoNome = basename($_FILES['foto']['name']);
                $fotoDestino = "uploads/" . $fotoNome;

                if (!is_dir("admin/uploads")) {
                mkdir("admin/uploads", 0777, true);
}

                move_uploaded_file($fotoTmp, $fotoDestino);
                if (move_uploaded_file($fotoTmp, $fotoDestino)) {
                echo "Imagem salva em: " . $fotoDestino;  // Debug
                } else {
                    echo "<script>alert('Erro ao mover a imagem.');</script>";
                }
            }

            $sql = "INSERT INTO PRODUTOS (CATEGORIA, PRODUTO, QUANTIDADE, VALOR_UNITARIO, VALOR_TOTAL, FOTO) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssidds", $categoria, $produto, $quantidade, $valor_unitario, $valor_total, $fotoDestino);
            if ($stmt->execute()) {
                echo "<script>alert('Produto cadastrado com sucesso!');</script>";
                header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para evitar reenvio
                exit;
            } else {
                echo "<script>alert('Erro ao cadastrar o produto.');</script>";
            }
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }
}
?>
<!-- filepath: c:\xampp\htdocs\Canil\admin\categorias\index.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Categorias</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: pink;
        color: #333;
    }
    table {
        width: 80%; /* Reduz a largura da tabela */
        margin: 20px auto; /* Centraliza a tabela horizontalmente */
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f4f4f4;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    tfoot td {
        text-align: center;
    }
    table img {
        width: 50px; /* Define a largura da imagem */
        height: 50px; /* Define a altura da imagem */
        object-fit: cover; /* Garante que a imagem se ajuste ao tamanho definido */
    }

    /* Estilo do formulário */
    #form-container {
        width: 80%; /* Define a largura do formulário */
        margin: 20px auto; /* Centraliza o formulário horizontalmente */
        padding: 20px;
        background-color: #fff; /* Fundo branco para destacar o formulário */
        border-radius: 8px; /* Bordas arredondadas */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra para destacar */
    }

    #form-container form {
    display: grid;
    grid-template-columns: 1fr 2fr; /* Define duas colunas: uma para as labels e outra para os campos */
    gap: 10px; /* Espaçamento entre os elementos */
    align-items: center; /* Alinha verticalmente as labels e os campos */
}

#form-container label {
    text-align: right; /* Alinha o texto das labels à direita */
    margin-right: 10px;
}

#form-container input[type="text"],
#form-container input[type="number"],
#form-container input[type="file"] {
    width: 100%; /* Faz os campos ocuparem toda a largura disponível */
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-transform: uppercase; /* Transforma o texto em maiúsculas */
}

#form-container button {
    grid-column: span 2; /* Faz o botão ocupar as duas colunas */
    padding: 10px;
    background-color: rgb(186, 12, 131); /* Cor do botão */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

#form-container button:hover {
    background-color:rgba(160, 69, 130, 0.37); /* Cor ao passar o mouse */
}
.btn-deletar {
    padding: 5px 10px;
    background-color: #e74c3c; /* Vermelho */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-deletar:hover {
    background-color: #c0392b; /* Vermelho mais escuro */
}
</style>
</head>
<body>
    <body>

<!-- 🟣 MENU DE NAVEGAÇÃO -->
<div style="background-color: #c2185b; padding: 10px;">
  <a href="index.php" style="color: white; margin-right: 20px; text-decoration: none;">📋 Cadastro de Categorias</a>
  <a href="vendas.php" style="color: white; text-decoration: none;">💰 Relatório de Vendas</a>
</div>

<!-- FORMULÁRIO DE CADASTRO EXISTENTE ABAIXO -->
<h1>Bem vindo, Admin !</h1>
<form method="POST" enctype="multipart/form-data" action="salvar.php">
  <!-- campos do formulário -->
</form>
    <h1>Cadastro de Categorias</h1>

    <!-- Formulário para cadastro -->
    <div id="form-container" class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id">
        
        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <label for="categoria">Categoria:</label>
        <input type="text" id="categoria" name="categoria" required>

        <label for="produto">Produto:</label>
        <input type="text" id="produto" name="produto" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" required>

        <label for="valor_unitario">Valor Unitário:</label>
        <input type="number" step="0.01" id="valor_unitario" name="valor_unitario" required>

        <button type="submit" id="submit-button">➕ Cadastrar Produto</button>
    </form>
</div>

    <!-- Tabela de Produtos -->
    <table>
        <thead> 
            <tr>
                <th>📷 Foto</th>
                <th>🏷️ Categoria</th>
                <th>📦 Produto</th>
                <th>🔢 Quantidade</th>
                <th>💲 Valor Unitário</th>
                <th>💰 Valor Total</th>
                <th>✏️ Editar</th>
                <th>🗑️ Deletar</th>
            </tr>
        </thead>
        <tbody>
<?php
include '../banco.php'; // Inclua sua conexão com o banco de dados

$sql = "SELECT * FROM PRODUTOS";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td><img src='{$row['FOTO']}' alt='Foto do Produto'>
            <td>{$row['CATEGORIA']}</td>
            <td>{$row['PRODUTO']}</td>
            <td>{$row['QUANTIDADE']}</td>
            <td>R$ " . number_format($row['VALOR_UNITARIO'], 2, ',', '.') . "</td>
            <td>R$ " . number_format($row['VALOR_TOTAL'], 2, ',', '.') . "</td>
            <td>
                <button type='button' class='btn-editar' 
                    onclick=\"editarProduto(
                        {$row['ID']}, 
                        '" . addslashes($row['CATEGORIA']) . "', 
                        '" . addslashes($row['PRODUTO']) . "', 
                        {$row['QUANTIDADE']}, 
                        {$row['VALOR_UNITARIO']}
                    )\">
                    ✏️ Editar
                </button>
            </td>
            <td>
                <button type='button' class='btn-deletar' 
                    onclick='confirmarDelecao(" . $row['ID'] . ")'>
                    🗑️ Deletar
                </button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7'>Nenhum produto cadastrado.</td></tr>";
}
$con->close();
?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7"><a href="../index.php">Voltar para o Menu Principal</a></td>
            </tr>
        </tfoot>
    </table>

    <script>
    function editarProduto(id, categoria, produto, quantidade, valorUnitario) {
        document.getElementById('id').value = id;
        document.getElementById('categoria').value = categoria;
        document.getElementById('produto').value = produto;
        document.getElementById('quantidade').value = quantidade;
        document.getElementById('valor_unitario').value = valorUnitario;
        document.getElementById('submit-button').textContent = '✏️ Atualizar Produto';
    }
    </script>
    <script>
function confirmarDelecao(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        // Envia o ID para exclusão via POST usando um formulário oculto
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = ''; // A mesma página

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_id';
        input.value = id;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
</body>
</html>
           