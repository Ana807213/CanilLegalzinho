<?php
session_start(); // Inicie a sessão para armazenar os itens do carrinho
include '../banco.php'; // Inclua sua conexão com o banco de dados

// Consulta para buscar todos os produtos
$sql = "SELECT * FROM PRODUTOS";
$result = $con->query($sql);
if (!$result) {
    die("Erro na consulta: " . $con->error);
}

// Calcular o total de itens no carrinho
$totalItens = 0;
if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $totalItens += $item['quantidade'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cães Disponíveis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f3f6;
            color: #333;
            padding: 20px;
        }
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #da70d6;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .cart-icon:hover {
            background-color: #c060c0;
        }
        .dog-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .dog-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            width: 200px;
        }
        .dog-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .dog-card h3 {
            color: #da70d6;
            margin: 10px 0;
        }
        .dog-card p {
            font-size: 0.9rem;
            color: #555;
        }
        .add-to-cart {
            background-color: #da70d6;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .add-to-cart:hover {
            background-color: #c060c0;
        }
    </style>
</head>
<body>
    <!-- Ícone do Carrinho -->
    <div class="cart-icon" onclick="abrirCarrinho()">
        🛒 <span id="cart-count"><?= $totalItens ?></span>
    </div>

    <h1>Cães Disponíveis</h1>
    <div class="dog-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $caminhoImagem = "../categorias/" . $row['FOTO'];
                echo "<div class='dog-card'>
                        <img src='{$caminhoImagem}' alt='{$row['PRODUTO']}'>
                        <h3>" . strtoupper($row['PRODUTO']) . "</h3>
                        <p>Categoria: {$row['CATEGORIA']}</p>
                        <p>Preço: R$ " . number_format($row['VALOR_UNITARIO'], 2, ',', '.') . "</p>
                        <button class='add-to-cart' onclick=\"adicionarAoCarrinho({$row['ID']}, '{$row['PRODUTO']}', '{$caminhoImagem}', {$row['VALOR_UNITARIO']})\">Adicionar ao Carrinho</button>
                      </div>";
            }
        } else {
            echo "<p>Nenhum produto disponível no momento.</p>";
        }
        ?>
    </div>

    <script>
        function adicionarAoCarrinho(id, nome, imagem, preco) {
            fetch('adicionar_carrinho.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, nome, imagem, preco, quantidade: 1 }) // Quantidade padrão é 1
            })
            .then(response => response.json())
            .then(data => {
                alert("Produto adicionado ao carrinho!");
                atualizarCarrinho(data.total);
            });
        }

        function atualizarCarrinho(total) {
            document.getElementById('cart-count').textContent = total;
        }

        function abrirCarrinho() {
            window.location.href = 'carrinho.php'; // Redireciona para a página do carrinho
        }
    </script>
</body>
</html>