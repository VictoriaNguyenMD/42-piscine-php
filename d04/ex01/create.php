<?php
//Validation
if ($_POST["login"] === "" || $_POST["passwd"] == "" || $_POST["submit"] !== "OK") {
    echo ("ERROR\n");
    return;
}

//Getting current data content
$data = file_get_contents("./private/passwd");

//If the data is empty then create a new array and make a directory folder
if (!$data) {
    $data = [];
    mkdir("private");
} else //Extracts the data in an array format
    $data = unserialize($data);

//Checks to see if the user is already in the database
foreach ($data as $user) {
    if ($user["login"] === $_POST["login"]) {
        echo "ERROR\n";
        return;
    }
}
    
//Adds the new user into the database
$data[] = [
    "login" => $_POST["login"],
    "passwd" => hash("whirlpool", $_POST["passwd"])
];

file_put_contents("./private/passwd", serialize($data));
echo "OK\n";
?>