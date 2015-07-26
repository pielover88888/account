<html>
<head>
<meta charset='UTF-8'>
<!-- http://codepen.io/johngerome/pen/pdrgk -->
  <link rel='stylesheet prefetch' href='http://cdn.jsdelivr.net/foundation/5.2.1/css/foundation.min.css'>
<style class="cp-pen-styles">
  body {
    background: #F0F0F3;
  }
div{
display:inline-block;
}
.large-3{
display:block;
}
.login-box{
display:block;
}
.row{
display:block;
}

  .login-box {
    background: #fff;
    border: 1px solid #ddd;
    margin: 100px 0;
    padding: 40px 20px 0 20px;
  }
</style>
<script>
function switch(){
//document.getElementById('submit').value = 'Sign up';
 if(document.getElementById('submit').value === "Sign Up"){
   document.getElementById('submit').value = "Log In"
 } else {
   document.getElementById('submit').value = "Sign Up"
 }
}
</script>
</head>
<body>
<div class="large-3 large-centered columns">
  <div class="login-box">
  <div class="row">
  <div class="large-12 columns">
    <form method="POST" action="">
       <div class="row">
         <div class="large-12 columns">
<?php
if($_GET["yes"] == "no"){
	$output = "The password was wrong";
} elseif($_GET["user"] == "no"){
	$output = "The username specified does not exist yet!";
}
?>

<?= $output ?><br>
<input type="checkbox" id="slideThree" class="slide" name="signup" value="true" onclick="switch();">Sign Up
<input type="checkbox" class="slidehree" name="signin" value="true" checked>Sign In
<input type="hidden" name="signin" value="true">
<input type="text" name="username" placeholder="Username">
         </div>
       </div>
      <div class="row">
         <div class="large-12 columns">
             <input type="password" name="password" placeholder="Password" />
         </div>
      </div>
	<div class="row">
	api mode: <input type="checkbox" name="api">
</div>
      <div class="row">
        <div class="large-12 large-centered columns">
          <input type="submit" id="submit" class="button expand" value="Log In" />
        </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>

</div>
<div class="large-3 large-centered columns" style="width:60%;margin-top:-90px;left:0px;">
	  <div class="login-box"  style="padding:00px;">
		  <div class="row"  style="padding:0px;">
		  <div class="large-12 columns" style="padding:20px;">
		       		<div class="row">
			        	 <div class="large-12 columns">
						<?php getUsers(); ?>
					</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>

</body>
</html>
