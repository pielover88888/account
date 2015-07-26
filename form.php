<form method="POST" action="">
<input type="hidden" name="username" value="<?= htmlspecialchars($_POST["username"])?>">
<input type="hidden" name="authed" value="<?= htmlspecialchars($_POST["username"]) ?>">You're signed in as "<?= htmlspecialchars($_POST["username"]) ?>
<br><input type="text" name="to" placeholder="to" value="<?= $_POST["to"]?>"> (case sensitive..)<br>
<input type="text" name="title" placeholder="title"><br>
<input type="text" name="message" placeholder="message">
<input type=submit>
</form>
