<form method="POST" action="">
<?php
if($_POST["username"]){
$username = $_POST["username"];
} elseif ($_SESSION["login"]){
$username = $_SESSION["login"];
}
?>
<input type="hidden" name="username" value="<?= htmlspecialchars($_POST["username"])?>">
<input type="hidden" name="authed" value="<?= htmlspecialchars($username) ?>">You're signed in as "<?= htmlspecialchars($username) ?>"
<br><input type="text" name="to" placeholder="to" value="<?= $_POST["to"]?>"> (case sensitive..)<br>
<input type="text" name="title" placeholder="title"><br>
<input type="text" name="message" placeholder="message">
<input type=submit>
</form>
