<?php
include 'conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['nome'], $_POST['email'], $_POST['telefone']) &&
        !empty($_POST['nome']) &&
        !empty($_POST['email']) &&
        !empty($_POST['telefone'])
    ) {
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : '';

        if (strlen($nome) < 3) {
          die("Erro: o nome deve ter ao menos 3 caracteres.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          die("Erro: e-mail inválido.");
        }

        $nome = mysqli_real_escape_string($conn, $nome);
        $email = mysqli_real_escape_string($conn, $email);
        $telefone = mysqli_real_escape_string($conn, $telefone);
        $endereco = mysqli_real_escape_string($conn, $endereco);

        $sql = "INSERT INTO contatos (nome, email, telefone, endereco) VALUES ('$nome', '$email', '$telefone', '$endereco')";

        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
            exit;
        } else {
            echo "Erro ao salvar o contato: " . mysqli_error($conn);
        }

    } else {
        die("Erro: preencha todos os campos obrigatórios (nome, e-mail e telefone).");
    }
} else {
    header('Location: index.php');
    exit;
}
?>
