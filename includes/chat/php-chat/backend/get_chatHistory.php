<?php   
        header('Content-Type: application/json');
        require_once('../db/chatsDB.php');

        $chatDB = new \chat();
        $sessionID = $_POST['session'];
        $chatDB->setSessionID($sessionID);
        $last_chat_id = $_POST['chat_id'];

        $chatHistory = $chatDB->getChats($last_chat_id);
        foreach ($chatHistory as &$chat) {
        if ($chat['source_id'] == $_SESSION['user_id']) {
                $chat['source_id'] = 'You';
        }
        }

        echo json_encode($chatHistory);
?>