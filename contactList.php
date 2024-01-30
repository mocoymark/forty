
<?php
include_once "fortydb.php";

$json = array();
$sql = "SELECT * FROM `contacttbl`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    array_push($json, $row);
}
echo json_encode($json);
?>
