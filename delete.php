<?php

include_once "fortydb.php";


if(isset($_POST['id']) && is_numeric($_POST['id'])) {
    try {

        $stmt = $conn->prepare("DELETE FROM `contacttbl` WHERE id = ?");
        $stmt->bind_param('i', $_POST['id']);
        

        if ($stmt->execute()) {

            echo json_encode(array('success' => true, 'message' => 'Contact deleted successfully.'));
        } else {

            echo json_encode(array('success' => false, 'message' => 'Failed to delete contact.'));
        }
    } catch (Exception $e) {

        error_log('Error deleting contact: ' . $e->getMessage());

        echo json_encode(array('success' => false, 'message' => 'An unexpected error occurred.'));
    }
} else {

    echo json_encode(array('success' => false, 'message' => 'Invalid contact ID.'));
}
?>
