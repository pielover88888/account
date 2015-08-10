<div id="sendmes">
<form method="POST" action="" id="sendmes">
<?php
if($_POST["username"]){
$username = $_POST["username"];
} elseif ($_SESSION["login"]){
$username = $_SESSION["login"];
}
?>
<input type="hidden" name="username" value="<?= htmlspecialchars($_POST["username"])?>">
<input type="hidden" name="authed" value="<?= htmlspecialchars($username) ?>">You're signed in as "<?= htmlspecialchars($username) ?>"
<br><input type="text" name="to" placeholder="to ('name,name2' to send to many users)" value="<?= $_POST["to"]?>"> (case sensitive..)<br>
<input type="text" name="title" placeholder="title"><br>
<textarea type="text" name="message" placeholder="message"></textarea>
<input type=submit class="button small">
</form><div class="profile_edit"><a href="/account/?do=profile"><button class="button small">Edit Profile</button></a></div>
</div>
