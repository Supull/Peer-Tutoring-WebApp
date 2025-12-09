<?php
    session_start();
    
    class chat{
        private $chatID;
        private $sessionID;
        private $sourceID;
        private $msg;
        private $createdOn;
        protected $dbConn;

        function setChatID($chatID){$this->chatID = $chatID;}
        function getChatID(){return $this->chatID;}
        function setSessionID($sessionID){$this->sessionID = $sessionID;}
        function getSessionID(){return $this->sessionID;}
        function setSourceID($sourceID){$this->sourceID = $sourceID;}
        function getSourceID(){return $this->sourceID;}
        function setMsg($msg){$this->msg = $msg;}
        function getMsg(){return $this->msg;}
        function setCreatedOn($createdOn){$this->createdOn = $createdOn;}
        function getCreatedOn(){return $this->createdOn;}

        public function __construct(){
            require_once('connDB.php');
            $db = new connDB();
            $this->dbConn = $db->connect();
        }

        public function saveChat(){
            $stmt = $this->dbConn->prepare('INSERT INTO chats VALUES(null, :sessionID, :sourceID, :msg, :created_on)');
            $stmt->bindParam(':sessionID', $this->sessionID);
            $stmt->bindParam(':sourceID', $this->sourceID);
            $stmt->bindParam(':msg', $this->msg);
            $stmt->bindParam(':created_on', $this->createdOn);

            if($stmt->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function getChats($last_chat_id){
            $stmt = $this->dbConn->prepare("
                SELECT source_id, message
                FROM chats
                WHERE session_id = :session_id
                " . 
                (is_null($last_chat_id) ? "AND chat_id < :last_message_id" : "")
                . "
                ORDER BY chat_id ASC
                LIMIT 30;
            ");
            $stmt->bindParam(':session_id', $this->sessionID);
            if (is_null($last_chat_id)){
                $stmt->bindParam(':last_message_id', $last_chat_id);
            };
            $stmt->execute();
            $chatHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $chatHistory;
        }


    }

?>