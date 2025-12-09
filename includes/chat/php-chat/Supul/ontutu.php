<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/about.css">
    <title>Available Tutors</title>
    <style>

            /* CSS integrated here */
            .filter-options {
                margin-top: -100px; 
            }
            .filter-options button {
                margin-left: 10px; 
            }
            .error {
                color: red;
            }
            .white-box {
                background-color: #fff;
                border-radius: 10px;
                padding: 15px;
                margin: 10px 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                position: relative;
            }
            .request-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }
            .request-info1 {
                font-size: 1.2em;
                font-weight: bold;
                color: #000;
            }
            .request-info2 {
                font-size: 1.2em;
                font-weight: bold;
                color: #000;
            }
            .request-info3 {
                font-size: 0.7em; /* Keep the font size the same */
                font-weight: bold; /* Keep the text bold */
                color: black; /* Keep the text color green */
                padding: 5px 30px 5px 5px;
                margin-bottom: 8px; /* Reduce the space below each item */
                margin-left: 20px;
                float: right; /* Float the box to the right */
            }
            .accept-button, .chat-button {
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 10px;
                border-radius: 5px;
                cursor: pointer;
            }
            .accept-button:disabled, .chat-button:disabled {
                background-color: #ccc;
            }
            .pending {
                background-color: #ff9800;
            }
            .chat-button {
                background-color: #2196F3;
            }

    #usernameDisplay {
        font-size: 1.8em; /* Adjust the font size */
        font-weight: bold; /* Make the font bold */
        color: white; /* Choose a text color */
        margin-left: -70px;
    }

    #statusForm button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 1em;
        margin: -130px 2px;
        cursor: pointer;
        border-radius: 5px;
    
    }

    #statusForm button:hover {
        background-color: #45a049;
    }

    #status-dropdown {
        font-size: 1em;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        color: #333;
        cursor: pointer;
        margin: 140px 2px;
        
    }

    #status-dropdown:focus {
        border-color: #4CAF50;
        outline: none;
    }


    #incomingRequests {
        background-color: #212121; /* Light background color for the section */
        border-radius: 10px; /* Rounded corners */
        padding: 15px; /* Padding inside the section */
        margin: 10px 10px; /* Margin around the section */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
        max-height: 350px;
        max-width: 300px;
        overflow-y: auto; /* Enable vertical scrolling */
        
    }

    #info {
        background-color: #212121; /* Light background color for the section */
        border-radius: 10px; /* Rounded corners */
        padding: 15px; /* Padding inside the section */
        margin: 10px 10px; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        max-height: 430px;
        max-width: 300px;
        overflow-y: auto; 

    }

    

    .sort-options {
        position: relative; /* Ensure the container is the reference point for absolute positioning */

    }

    #subject-dropdown {
        position: absolute; /* Take the dropdown out of the normal flow */
        right: -1020px; /* Move the dropdown 10px from the right edge of its parent container */
        top: 40px; /* Align the dropdown to the top of its parent container */
        z-index: 10; /* Ensure it is above other elements */
    }

    .tutors {
        display: flex;
        flex-grow: 1;  
        flex-direction: row;
        border-radius: 10px;
        margin-left: -100px;
    }

    .tutors .main {
        display: flex;
        padding: 20px;
        background-color: #212121;
        flex-grow: 1;
        border-radius: 10px;
        flex-direction: column;
        z-index: 0;
    }
    .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .time-slot.selected {
            background-color: #4CAF50;
            color: white;
        }

        button {
            margin-top: 10px;
        }

        .schedule-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .schedule-table td.disabled {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }

        .schedule-table td.selected {
            background-color: #4CAF50;
            color: white;
        }
        .hidden-chat {
            display: none;
        }


        
    </style>
</head>
<body>

    <div id="blur"></div>

    <div class="app">
        <div class="navigation-bar">
            <button id="profile-collapse" onclick="handleProfileCollapse()"></button>
            <button id="sub-collapse" onclick="handleSubCollapse()"></button>
        </div>
        <div id='profile-id' class="profile">
            <form id="statusForm" class="filter-options">
                <label for="status-dropdown">Status:</label>
                <select id="status-dropdown" name="status">
                    <option value="online" selected>Online</option>
                    <option value="away">Away</option>
                </select>
                <button type="submit">Update Status</button>
            </form>
            <div id="usernameDisplay"></div>
        </div>
        <div class="tutors">
            <div class="sort-options">
                <label for="subject-dropdown">Sort by Subject:</label>
                <select id="subject-dropdown">
                    <option value="all">All</option>
                    <option value="math">Math</option>
                    <option value="chemistry">Chemistry</option>
                    <option value="biology">Biology</option>
                    <option value="geography">Geography</option>
                    <option value="history">History</option>
                    <option value="physics">Physics</option>
                    <option value="english_language">English Language</option>
                    <option value="english_literature">English Literature</option>
                    <option value="economics">Economics</option>
                    <option value="computer_science">Computer Science</option>
                </select>
            </div>

            <div class="main white-box" id="onlineUsers">
                <!-- Tutor profiles -->
            </div>
            <div id='sub-id' class="sub">
                <div class="chats white-box" id="incomingRequests">
                    <!-- Incoming requests  -->
                </div>
                <div class="info" id="info">
                    <!-- Accepted requests -->
                </div>
            </div>
        </div>
    </div>

    <div id="scheduleModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Schedule your session here.</p>
            <form id="scheduleForm">
                <table id="scheduleTable">
                    <thead>
                        <tr>
                            <!-- The day names will be filled in by JavaScript -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Time slots will be filled in by JavaScript -->
                    </tbody>
                </table>
                <input type="hidden" id="requestId" name="requestId" required>
                <input type="hidden" id="requester" name="requester" required>
                <input type="hidden" id="tutor" name="tutor" required>
                <input type="hidden" id="scheduleDateTime" name="scheduleDateTime" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>


    <script src="./jsfiles/collapses.js"></script>
    <script src="./jsfiles/main1.js"></script>

</body>
</html>
