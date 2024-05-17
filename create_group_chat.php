<?php
// create_group_chat.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs as needed
    $groupName = $_POST['group_name'];
    $userIds = $_POST['user_ids']; // Assuming this is an array of user IDs

    // Example database connection
    include_once "php/config.php";

    // Insert group chat into database
    $stmt = $conn->prepare("INSERT INTO group_chats (group_name) VALUES (?)");
    $stmt->bind_param("s", $groupName);
    $stmt->execute();
    $groupChatId = $stmt->insert_id;

    // Handle database errors
    if ($stmt->errno) {
        $response = [
            'success' => false,
            'message' => 'Database error: ' . $stmt->error,
        ];
        echo json_encode($response);
        exit;
    }

    // Insert users into group chat members
    foreach ($userIds as $userId) {
        $stmt = $conn->prepare("INSERT INTO group_chat_members (group_chat_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $groupChatId, $userId);
        $stmt->execute();

        // Handle database errors
        if ($stmt->errno) {
            $response = [
                'success' => false,
                'message' => 'Database error: ' . $stmt->error,
            ];
            echo json_encode($response);
            exit;
        }
    }

    // Respond with success and group chat ID
    $response = [
        'success' => true,
        'group_id' => $groupChatId,
    ];
    echo json_encode($response);
    exit;
} else {
    http_response_code(405); // Method Not Allowed
    exit(json_encode(['success' => false, 'message' => 'Invalid request method']));
}
?>
