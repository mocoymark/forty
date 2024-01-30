<?php
include_once "fortydb.php";

$limit = 12;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$json = array();

$stmt_count = $conn->prepare("SELECT COUNT(*) as total FROM `contacttbl`");
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$row_count = $result_count->fetch_assoc();
$totalRecords = $row_count['total'];

$totalPages = ceil($totalRecords / $limit);

$stmt = $conn->prepare("SELECT firstname, company, phone, email FROM `contacttbl` LIMIT ?, ?");
$stmt->bind_param('ii', $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    array_push($json, $row);
}

$response = array(
    'data' => $json,
    'totalPages' => $totalPages
);

echo json_encode($response);
?>
