<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$withdraw_amount = 100;  // Monto a retirar

// Iniciar transacción
$conn->begin_transaction();

try {
    // Obtener el balance actual
    $sql = "SELECT balance FROM accounts WHERE id = 1 FOR UPDATE";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_balance = $row['balance'];

    // Verificar si el retiro es posible
    if ($current_balance >= $withdraw_amount) {
        // Actualizar balance
        $new_balance = $current_balance - $withdraw_amount;
        $sql = "UPDATE accounts SET balance = $new_balance WHERE id = 1";
        $conn->query($sql);

        // Registrar la transacción
        $sql = "INSERT INTO logs (transaction) VALUES ('Withdrawal of $withdraw_amount')";
        $conn->query($sql);

        // Confirmar transacción
        $conn->commit();
        echo "Retiro exitoso. Nuevo balance: $new_balance";
    } else {
        echo "Fondos insuficientes.";
    }
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
