<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/chat.css">
    <link rel="stylesheet" href="./css/request.css">
    <link rel="stylesheet" href="./css/pending_requests.css">
    <link rel="stylesheet" href="./css/modals.css">
    <link rel="stylesheet" href="./css/accepted_requests.css">
    <title>Available Tutors</title>
</head>
<body>

    <div id="blur"></div>

    <div class="app">
        <div class="navigation-bar">
            <button id="profile-collapse" onclick="handleProfileCollapse()"></button>
            <button id="sub-collapse" onclick="handleSubCollapse()"></button>
        </div>
        <div id='profile-id' class="profile">
            <div id="usernameDisplay"></div>
        </div>
        <div class="tutors">
            <div class="main" id="onlineUsers">
                <!-- Tutor profiles -->
            </div>
            <div id='sub-id' class="sub">
                <div class="chats" id="incomingRequests">
                    <!-- Incoming requests  -->
                </div>
                <div class="info" id="info">
                    <!-- Accepted requests -->
                </div>
            </div>
        </div>
    </div>

    <!-- CHAT MODAL -->
    <div id="modalChat" class="modal">
        <div id="chatHeader">
            <button onclick=[handleCloseModal(event)] class="close-modal">&times;</button>
        </div>
        <div id="chatContent">
            <div id="chats">
            </div>
            <div id="send-box">
                <input type="text" name="text" id="msg">
                <button id="send">SEND</button>
            </div>
        </div>
    </div>


    <script src="./Javascript/DOM_elements.js"></script>
    <script src="./Javascript/handle_request.js"></script>
    <script src="./Javascript/main.js"></script>
    <script src="./Javascript/chat.js"></script>
    <script src="./Javascript/collapses.js"></script>
    <script src="./Javascript/handle_modals.js"></script>
    
    

</body>
</html>
