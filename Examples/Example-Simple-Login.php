<?php

require_once('../lib/SessionClass.php');

SESSION::setSessionName("MyTest");
SESSION::init();

$users = array(
    "test" => password_hash("test", PASSWORD_DEFAULT)
);

if (isset(SESSION::$s['TEST_USER']['logged'], $users[SESSION::$s['TEST_USER']['logged']])) {
    echo "Logged: " . SESSION::$s['TEST_USER']['logged'];
    
    if(!isset(SESSION::$s['counter'])) SESSION::$s['counter'] = 0;
    SESSION::$s['counter']++;
    
    echo "<br>";
    echo "Counter: " . SESSION::$s['counter'];
}
elseif (isset($_POST['user'], $_POST['pass'])) {
    if (isset($users[$_POST['user']]) && isset($_POST['pass']) && password_verify($_POST['pass'], $users[$_POST['user']])) {
        SESSION::$s['TEST_USER']['logged'] = $_POST['user'];
    } else {
        unset(SESSION::$s['TEST_USER']['logged']);
    }

    header('Refresh: 0;');
}
else {
    unset(SESSION::$s['TEST_USER']['logged']);

    echo '
    <html>
        <head>
            <title>Test Login</title>
        </head>
        <body>
            <div align="center">
                <h1>Test Login</h1>
                <form method="POST">
                    <input type="text" name="user" required placeholder="Username" autofocus><br><br>
                    <input type="password" name="pass" required placeholder="Password"><br><br>
                    <button type="submit">Login</button>
                </form>
            </div>
         </body>
    </html>';
}

