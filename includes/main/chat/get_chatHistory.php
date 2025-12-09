<?php   
        header('Content-Type: application/json');
        
        include_once('../../security/config_session.inc.php');
        require_once('../../databases/dbh.inc.php');

        $data = json_decode(file_get_contents('php://input'), true);
        $recipient = $data['recipient'];
        
        // Assuming $pdo is your PDO instance
        try {
                $stmt = $pdo->prepare("SELECT msg 
                                        FROM chats 
                                        WHERE source = :source 
                                        AND recipient = :recipient 
                                        ORDER BY msg_time DESC 
                                        LIMIT 30");

                // Bind parameters
                $stmt->bindParam(':source', $_SESSION['USER_INFO']['username']);
                $stmt->bindParam(':recipient', $recipient);
                
                // Execute the query
                $stmt->execute();
                
                // Fetch results
                $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo json_encode($messages);
        } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
        }

?>