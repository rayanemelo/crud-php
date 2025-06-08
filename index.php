<?php
include "conecta.php";

$sql = "SELECT * FROM contatos";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agenda de Contatos</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="container">
    <h1>Agenda de Contatos</h1>
    <button id="open-modal-btn">Novo Contato</button>

    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>Endereço</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="contact-list">
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row["nome"]); ?></td>
              <td><?php echo htmlspecialchars($row["email"]); ?></td>
              <td><?php echo htmlspecialchars($row["telefone"]); ?></td>
              <td><?php echo htmlspecialchars($row["endereco"]); ?></td>
              <td class="actions">
                <a href="editar_contato.php?id=<?php echo $row['id']; ?>"><button class="edit">Editar</button></a>
                <button class="delete-btn" data-id="<?php echo $row['id']; ?>">Excluir</button>
              </td>
            </tr>
            <?php
              endwhile; ?>
            <?php
              else: ?>
                      <tr>
                        <td colspan="5" style="text-align:center;">Nenhum usuário encontrado.</td>
                      </tr>
                    <?php
          endif; ?>
      </tbody>
    </table>
  </div>

  <div class="modal" id="modal">
    <div class="modal-content">
      <h2>Adicionar Novo Contato</h2>
      <button class="close-btn" id="close-modal-btn">&times;</button>
      <form id="contact-form" method="POST" action="salvar_contato.php">
        <input type="text" name="nome" placeholder="Nome" required />
        <input type="email" name="email" placeholder="E-mail" required />
        <input type="text" name="telefone" placeholder="Telefone" oninput="formatarTelefone(this)" required />
        <input type="text" name="endereco" placeholder="Endereço" />
        <button type="submit">Adicionar Contato</button>
      </form>
    </div>
  </div>


  <div class="modal" id="delete-modal" style="display:none; justify-content:center; align-items:center;">
  <div class="modal-content">
    <h2>Confirmar Exclusão</h2>
    <p>Tem certeza que deseja excluir este contato?</p>
    <div class="modal-actions">
      <button id="confirm-delete-btn" style="margin-right: 10px;">Sim, excluir</button>
      <button id="cancel-delete-btn">Cancelar</button>
    </div>
  </div>
</div>

  <script>
    const openBtn = document.getElementById('open-modal-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const modal = document.getElementById('modal');

    openBtn.addEventListener('click', () => {
      modal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });

    function formatarTelefone(input) {
      let valor = input.value.replace(/\D/g, '');  

      if (valor.length > 11) {
        valor = valor.slice(0, 11);  
      }

      if (valor.length <= 10) {
        valor = valor.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
      } else {
        valor = valor.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
      }

      input.value = valor;
    }

    const deleteModal = document.getElementById('delete-modal');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');

    let userIdToDelete = null;

    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        userIdToDelete = e.target.getAttribute('data-id');
        deleteModal.style.display = 'flex';
      });
    });

    cancelDeleteBtn.addEventListener('click', () => {
      deleteModal.style.display = 'none';
      userIdToDelete = null;
    });

    confirmDeleteBtn.addEventListener('click', () => {
      if (!userIdToDelete) return;

      fetch(`excluir_contato.php?id=${userIdToDelete}`, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert('Erro ao excluir o contato.');
          }
        })
        .catch(() => alert('Erro ao excluir o contato.'))
        .finally(() => {
          deleteModal.style.display = 'none';
          userIdToDelete = null;
        });
    });

  </script>
</body>

</html>
