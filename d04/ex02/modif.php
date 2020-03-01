<?php
if (!$_POST["login"] || !$_POST['oldpw'] || !$_POST['newpw'] || !$_POST['submit'] || $_POST['submit'] !== "OK" || !file_exists('../private/passwd')) {
    echo "ERROR\n";
    return;
} else {
    $data = unserialize(file_get_contents('../private/passwd'));
    foreach ($data as $index=>$usr) {
        if ($usr['login'] === $_POST['login'] && $usr['passwd'] === hash('whirlpool', $_POST['oldpw'])) {
            $data[$index]['passwd'] = hash('whirlpool', $_POST['newpw']);
            echo $data[$index]['passwd'] . "\n";
            file_put_contents('../private/passwd', serialize($data));
            $found =  true;
        }
    }
}
if (!$found)
    echo "ERROR\n";
?>