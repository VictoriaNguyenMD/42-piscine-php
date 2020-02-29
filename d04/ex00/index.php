<?php
/* Always start a session first */
session_start();
if ($_GET["login"] === "OK") {
	$_SESSION["login"]=$_GET["login"];
	$_SESSION["passwd"]=$_GET["passwd"];
}
?>
<html><body>
<form action="index.html" method="GET">
	Username: <input type="text" name="login" value="<?php echo $_SESSION["login"]; ?>" />
	<br />
	Password: <input type="password" name="passwd" value="<?php echo $_SESSION["passwd"]; ?>" />
	<br />
	<input type="submit" name"submit" value="OK" />
</form>
</body></html>
