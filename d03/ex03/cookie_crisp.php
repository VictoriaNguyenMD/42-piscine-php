<?php
switch ($_GET["action"]) {
	case "set":
		setcookie($_GET["name"], $_GET["value"]);
		break;
	case "get":
		if (!isset($_GET['name']) || !isset($_COOKIE[$_GET['name']]))
			break;
		echo $_COOKIE[$_GET['name']];
        break;	
	case "del";
		setcookie($_GET["name"], "", time() - 3600);
		break;
}
?>
