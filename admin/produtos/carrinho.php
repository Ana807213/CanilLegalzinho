<?php
session_start();

// Verifica se o botão "Comprar" foi clicado
if (isset($_POST['comprar'])) {
    // Redireciona para a página de login/cadastro se o usuário não estiver logado
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['redirect_after_login'] = 'pagamento.php'; // Salva a página de destino após o login
        header("Location: login_cadastro.php");
        exit;
    }

    // Usuário está logado, redireciona para a página de pagamento
    header("Location: pagamento.php");
    exit;
}

// Verifica se há itens no carrinho
$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];

// Calcula o total de produtos no carrinho
$totalProdutos = 0;
foreach ($carrinho as $item) {
    $totalProdutos += $item['preco'] * $item['quantidade'];
}

// Salva o total da compra na sessão
$_SESSION['total_compra'] = $totalProdutos;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Carrinho</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f3f6;
            color: #333;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #da70d6;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 10px 0;
            padding: 15px;
        }
        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cart-item h3 {
            margin: 0;
            font-size: 1rem;
            color: #da70d6;
        }
        .cart-item p {
            margin: 5px 0;
            font-size: 0.9rem;
            color: #555;
        }
        .frete-container {
            margin-top: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .frete-container input {
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .frete-container button {
            background-color: #da70d6;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }
        .frete-container button:hover {
            background-color: #c060c0;
        }
        .frete-result {
            margin-top: 10px;
            font-size: 1rem;
            color: #555;
        }
        .resumo-container {
            margin-top: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .resumo-container h3 {
            margin: 0 0 10px;
            font-size: 1.2rem;
            color: #333;
        }
        .resumo-container p {
            margin: 5px 0;
            font-size: 1rem;
            color: #555;
        }
        .resumo-container .total {
            font-weight: bold;
            font-size: 1.2rem;
            color: #333;
        }
        .resumo-container button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 10px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .resumo-container button:hover {
            background-color: #218838;
        }
        .resumo-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #555;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .resumo-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Seu Carrinho</h1>
    <?php if (count($carrinho) > 0): ?>
        <!-- Produtos no carrinho -->
        <?php foreach ($carrinho as $item): ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($item['imagem']) ?>" alt="<?= htmlspecialchars($item['nome']) ?>">
                <div>
                    <h3><?= htmlspecialchars($item['nome']) ?></h3>
                    <p>Preço unitário: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
                    <p>Total: R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Frete e prazo -->
        <div class="frete-container">
            <h3>Frete e prazo</h3>
            <input type="text" id="cep" placeholder="Insira o CEP" maxlength="8">
            <button onclick="calcularFrete()">Buscar</button>
            <div id="frete-result" class="frete-result"></div>
            <div id="endereco-container" style="display: none; margin-top: 10px;">
                <p><strong>Endereço:</strong> <span id="endereco"></span></p>
                <input type="text" id="numero" placeholder="Número da residência">
            </div>
        </div>

        <!-- Resumo do pedido -->
        <div class="resumo-container">
            <h3>Resumo do pedido</h3>
            <p>Produtos (<?= count($carrinho) ?>): R$ <?= number_format($totalProdutos, 2, ',', '.') ?></p>
            <p>Frete: <span id="frete-valor">R$ 0,00</span></p>
            <p class="total">Total: <span id="total-valor">R$ <?= number_format($totalProdutos, 2, ',', '.') ?></span></p>
            <form method="POST" action="carrinho.php">
                <button type="submit" name="comprar">Comprar</button>
            </form>
            <a href="caes_disponiveis.php">Comprar mais produtos</a>
        </div>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>

    <script>
        let frete = 0;

        function calcularFrete() {
            const cep = document.getElementById('cep').value;

            if (!cep || cep.length !== 8 || isNaN(cep)) {
                alert('Por favor, insira um CEP válido com 8 dígitos.');
                return;
            }

            // Busca o endereço usando a API ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado. Verifique e tente novamente.');
                        return;
                    }

                    // Exibe o endereço
                    const enderecoContainer = document.getElementById('endereco-container');
                    const enderecoSpan = document.getElementById('endereco');
                    enderecoSpan.textContent = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
                    enderecoContainer.style.display = 'block';
                })
                .catch(error => {
                    console.error('Erro ao buscar o endereço:', error);
                    alert('Erro ao buscar o endereço. Tente novamente mais tarde.');
                });

            // Calcula o frete
            fetch('calcular_frete.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cep })
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('frete-result');
                if (data.success) {
                    frete = data.frete;
                    resultDiv.textContent = `Frete: R$ ${data.frete.toFixed(2)} - Prazo: ${data.prazo} dias`;
                    document.getElementById('frete-valor').textContent = `R$ ${data.frete.toFixed(2)}`;
                    const total = <?= $totalProdutos ?> + frete;
                    document.getElementById('total-valor').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
                } else {
                    resultDiv.textContent = 'Erro ao calcular o frete. Tente novamente.';
                }
            })
            .catch(error => {
                console.error('Erro ao calcular o frete:', error);
            });
        }
    </script>
</body>
</html>