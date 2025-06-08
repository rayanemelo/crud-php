<?php
include "conecta.php";

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  
  $sql = "DELETE FROM contatos WHERE id = $id";
  if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false]);
  }
} else {
  echo json_encode(['success' => false]);
}
?>
