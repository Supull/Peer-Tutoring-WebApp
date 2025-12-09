<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use PDO;

date_default_timezone_set('UTC');



class Chat implements MessageComponentInterface {

    protected $clients;
    private $pdo;
    public function __construct() {

        $this->clients = new \SplObjectStorage;

        require_once('../../../databases/dbh.inc.php');
        $this->pdo = $pdo;

        echo 'server started and connected to database';
    }

    public function onOpen(ConnectionInterface $conn) {
        
        // Store the new connection to send messages to later

        parse_str($conn->httpRequest->getUri()->getQuery(), $queryParams);
        if (isset($queryParams['username'])) {
            $username = $queryParams['username'];
            
            $this->clients->attach($conn);
            echo "New connection! ({$conn->resourceId})\n";

            $stmt = $this->pdo->prepare('
            UPDATE users
            SET conn_id = :conn_id
            WHERE username = :username
            ');

            $stmt->bindValue(':conn_id', $conn->resourceId, PDO::PARAM_INT);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
        }
    }



    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        // $msg = [
        //     'type' => '',
        //     'source' => ,
        //     'recipient' => '',
        //     'msg_time' => '',
        //     'msg'=> 'this is the message'
        // ];

        if($data['type'] == 'msg'){
            echo "{$data['source']}:{$data['recipient']}=> {$data['msg']}\n";

            //Implemt a system to skip webscoket sending message if tutor is not onlinw

            //Save the message in chats



            //Extract the recipient ID using session ID and email and password of the source

            // $stmt = $this->pdo->prepare("
            //     SELECT user_id, is_tutor 
            //     FROM users 
            //     WHERE email = :email AND password = :password
            //     ");

            //     $stmt->bindParam(':email', $data['user'][0], PDO::PARAM_STR);
            //     $stmt->bindParam(':password', $data['user'][1], PDO::PARAM_STR);

            // $stmt->execute();

            // $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // $chatDB = new \chat();
            // $chatDB->setSessionID($data['session']);
            // $chatDB->setSourceID($from->user_id);
            // $chatDB->setMsg($data['msg']);
            // $chatDB->setCreatedOn(date("Y-m-d H:m:s"));

            // if($chatDB->saveChat()){
            //     echo '[SERVER] Chat saved to database';
            // }


            // $Srole = $user['is_tutor'] ? 'tutor' : 'student';
            // $Rrole = $user['is_tutor'] ? 'student' : 'tutor';

            $stmt = $this->pdo->prepare("SELECT conn_id FROM users WHERE username = :username");
            $stmt->bindParam(':username', $data['recipient']); 
            $stmt->execute();
            $recipient_conn = $stmt->fetchColumn();
            //-------------------


            //Send message to recipient
            foreach ($this->clients as $client) {
                if ($from !== $client && $recipient_conn == $client->resourceId) {
                    // The sender is not the receiver, send to each client connected and send to correct recipient
                    $client->send($msg);
                }
            }
        } 
    }



    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        $stmt = $this->pdo->prepare('
        UPDATE users
        SET conn_id = NULL
        WHERE conn_id = :conn_id
        ');

        $stmt->bindValue(':conn_id', $conn->resourceId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}