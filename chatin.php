<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/chatin.css">
    <title>Chat Session</title>
</head>
<body>
    <div class="navigation">
        <form action="chatinphp/minimize.php" method="post">
            <button type="submit" name="minimize">Minimize</button>
        </form>
        
        <form action="chatinphp/end_session.php" method="post">
            <button type="submit" name="end_session">Cancel Session</button>
        </form>

        <form action="chatinphp/tutored.php" method="post">
            <button type="submit" name="tutored">Tutored</button>
        </form>
    </div>

    <div class="container">
        <div class="chat-box">
            <div class="message">
                <p class="inside">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, ut.</p>
            </div>
            <div class="message">
                <p class="outside">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure nobis odit ex. Facilis enim quibusdam consequatur aperiam, labore atque assumenda. Qui consequuntur vitae, quaerat animi, corporis aliquam obcaecati aut magni eaque magnam unde fugiat.</p>
            </div>
            <!-- More messages -->
        </div>

        <div class="type-box">
            <div class="middle">
                <button class="image"><img src="./paper-clip.png" alt="" width="30px"></button>
                <input type="text" placeholder="type here..." class="message-box">
                <button class="enter"></button>
            </div>
        </div>
    </div>
</body>
</html>
