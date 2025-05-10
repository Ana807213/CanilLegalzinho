<?php
include 'C:\xampp\htdocs\Canil\admin\banco.php'; // Inclua sua conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria'];
    $produto = $_POST['produto'];
    $quantidade = (int) $_POST['quantidade'];
    $valor_unitario = (float) $_POST['valor_unitario'];
    $valor_total = $quantidade * $valor_unitario;

    // Verificar se o arquivo foi enviado
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $fotoNome = basename($_FILES['foto']['name']);
        $fotoDestino = "uploads/" . $fotoNome;

        // Criar o diretório de uploads, se não existir
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        // Mover o arquivo para o diretório de destino
        if (move_uploaded_file($fotoTmp, $fotoDestino)) {
            // Preparar a query
            $sql = "INSERT INTO PRODUTOS (CATEGORIA, PRODUTO, QUANTIDADE, VALOR_UNITARIO, VALOR_TOTAL, FOTO) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssidds", $categoria, $produto, $quantidade, $valor_unitario, $valor_total, $fotoDestino);

                if ($stmt->execute()) {
                    echo "<script>
                        alert('Produto cadastrado com sucesso!');
                        window.location.href = 'categorias/index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Erro ao cadastrar produto: " . $stmt->error . "');
                        window.location.href = 'categorias/index.php';
                    </script>";
                }

                $stmt->close();
            } else {
                echo "<script>
                    alert('Erro na preparação da consulta: " . $con->error . "');
                    window.location.href = 'categorias/index.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Erro ao fazer upload da foto.');
                window.location.href = 'categorias/index.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Nenhuma foto foi enviada ou ocorreu um erro.');
            window.location.href = 'categorias/index.php';
        </script>";
    }

    $con->close();
}
?>