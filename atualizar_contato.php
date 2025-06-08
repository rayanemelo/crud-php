<?php
include "conecta.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $endereco = trim($_POST['endereco']);

    $errors = [];

    if ($id <= 0) {
        $errors[] = "ID inválido.";
    }

    if (empty($nome)) {
        $errors[] = "O nome é obrigatório.";
    }

    if (empty($email)) {
        $errors[] = "O e-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Formato de e-mail inválido.";
    }

    if (empty($telefone)) {
        $errors[] = "O telefone é obrigatório.";
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<p><a href='javascript:history.back()'>Voltar</a></p>";
        exit();
    }

    $nome = mysqli_real_escape_string($conn, $nome);
    $email = mysqli_real_escape_string($conn, $email);
    $telefone = mysqli_real_escape_string($conn, $telefone);
    $endereco = mysqli_real_escape_string($conn, $endereco);

    $sql = "UPDATE contatos SET 
              nome = '$nome', 
              email = '$email', 
              telefone = '$telefone', 
              endereco = '$endereco'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar contato: " . mysqli_error($conn);
    }
} else {
    echo "Método inválido.";
}
?>
