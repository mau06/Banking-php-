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

$sql = "SELECT * FROM logs";
$result = $conn->query($sql);

echo "<table border='1'>
<tr>
<th>ID</th>
<th>Transacción</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['transaction'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
