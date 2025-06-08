<?php
include "conecta.php";

if (!isset($_GET['id'])) {
    die("ID do contato não informado.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM contatos WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Contato não encontrado.");
}

$contato = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Contato</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <div class="container">
    <h1>Editar Contato</h1>
    <form method="POST" action="atualizar_contato.php">
      <input type="hidden" name="id" value="<?php echo $contato['id']; ?>" />
      <input type="text" name="nome" placeholder="Nome" value="<?php echo htmlspecialchars($contato['nome']); ?>" required />
      <input type="email" name="email" placeholder="E-mail" value="<?php echo htmlspecialchars($contato['email']); ?>" required />
      <input type="text" name="telefone" placeholder="Telefone" value="<?php echo htmlspecialchars($contato['telefone']); ?>" required />
      <input type="text" name="endereco" placeholder="Endereço" value="<?php echo htmlspecialchars($contato['endereco']); ?>" />
      <button type="submit">Atualizar Contato</button>
    </form>
    <a href="index.php" class="back">Voltar</a>
  </div>
</body>

</html>
