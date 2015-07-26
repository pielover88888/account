<?php
if(isset($_GET["dump"])){
highlight_string(file_get_contents("index.php") );
}
?>
<?php
ob_start();
function prettyDate($date){
// source: https://gist.github.com/CodeNegar/3713606
    $time = strtotime($date);
    $now = time();
    $ago = $now - $time;
    if($ago < 60){
        $when = round($ago);
        $s = ($when == 1)?"second":"seconds";
        return "$when $s ago";
    }elseif($ago < 3600){
        $when = round($ago / 60);
        $m = ($when == 1)?"minute":"minutes";
        return "$when $m ago";
    }elseif($ago >= 3600 && $ago < 86400){
        $when = round($ago / 60 / 60);
        $h = ($when == 1)?"hour":"hours";
        return "$when $h ago";
    }elseif($ago >= 86400 && $ago < 2629743.83){
        $when = round($ago / 60 / 60 / 24);
        $d = ($when == 1)?"day":"days";
        return "$when $d ago";
    }elseif($ago >= 2629743.83 && $ago < 31556926){
        $when = round($ago / 60 / 60 / 24 / 30.4375);
        $m = ($when == 1)?"month":"months";
        return "$when $m ago";
    }else{
        $when = round($ago / 60 / 60 / 24 / 365);
        $y = ($when == 1)?"year":"years";
        return "$when $y ago";
    }
}
//
// $time =  date ("F d Y H:i:s.", filemtime("msg/"));
// $time = prettyDate($time).".";
// echo $time."<br>";
//
function getMessages($user,$reverse,$last){
 // get messages
 $time =  date ("F d Y H:i:s.", filemtime("msg/".$user));
 $time = prettyDate($time).".";
 if($time == "46 years ago."){$time = "Never ago.";}
 $curtime = date ("F d Y H:i:s.", time());
if(!isset($last)){
 echo "Message last receieved: ".$time." Current time: ".$curtime."<br>\n";
}
 echo "Messages, sorted by recent:<br>\n";
 if(!$reverse){
  $messages = file("msg/".$user);
 } else {
  $messages = array_reverse( file("msg/".$user) );
 }
echo "<div class='scrolls'>";
 foreach($messages as $message){
  highlight_string($message)."<br>";
 }
echo "</div>";
if(isset($_POST["api"])){
die();
}
}

function sendMessage($userfrom,$userto,$title,$message){
  file_put_contents("msg/".$userto,"(".$userfrom."->".$userto.") ".$title.":".$message."\n",FILE_APPEND);
}

function getUsers(){
 $lines = file("../../db"); // load the database into an array, one line (\n or \r\n) per item.
 foreach($lines as $line){
  $data = explode(":",$line); // <li>
  echo "<li>".htmlspecialchars("'".$data[0]."' ")."</li>";
//  return $data[0];
}
}

/*function sendMessage($userfrom,$userto,$title,$message){
file_put_contents("msg/".$user.":".$_POST["message"]."\n");
}*/


function authed($username) {
if(!isset($username)){
session_start();
$_SESSION['login'] = $_POST["username"];
getMessages($_POST["username"],true);
echo "<br>sent msgs:<br>";
getMessages($_POST["username"].".sent",true,false);
} else{
session_start();
$_SESSION['login'] = $username;

getMessages($username,true);
echo "<br>sent msgs:<br>";
getMessages($username.".sent",true,false);
}
if(isset($_POST["api"])){
break;
}
include "form.php";

return true;
}


if(isset($_SESSION['login']) ){
sendMessage($_SESSION["login"],$_POST["to"],$_POST["title"],$_POST["message"]);
sendMessage($_SESSION["login"],$_POST["authed"].".sent","(->".$_POST["to"].") ".$_POST["title"],$_POST["message"]);
echo "Message sent!..Assuming the user exists. if they dont, they can make an account with that name to access the message.<br>";
authed($_POST["authed"]);
//file_put_contents("msg/".$_POST["authed"],$_POST["title"].":".$_POST["message"]."\n");
}

if(!isset($_POST["signup"]) and !isset($_POST["signin"]) and !isset($_POST["authed"])){
include "sexy-form.php";
die();
}


if(isset($_POST["signup"])  ){ // if signing up
$pass = substr_replace(sha1($_POST["password"]), sha1(sha1($_POST["password"])), 20, 0);
 //$pass = sha1($_POST["password"]) . sha1(sha1($_POST["password"])); // hash it, add salting eventually
 file_put_contents("../../db",$_POST["username"].":".$pass."\n", FILE_APPEND); // add to database
 // explode by : to get it right
echo "Account created-- ".htmlspecialchars($_POST["username"])."<br>";
}

if(isset($_POST["signin"]) || $_SESSION['login']){
 $lines = file("../../db"); // load the database into an array, one line (\n or \r\n) per item.
 foreach($lines as $line){
  $data = explode(":",$line);
  //^get the data from the line (e.g username:hash) // , $data[0] is the username and$data[1] is the hash
   if($_POST["username"] == $data[0] ){
    if(!isset($_POST["api"])){
            echo "your username exists.<br>";
    }
$exists = 1;
$pass = substr_replace(sha1($_POST["password"]), sha1(sha1($_POST["password"])), 20, 0) . "\n";
     $oldpass = sha1($_POST["password"] ) . sha1(sha1($_POST["password"])) . "\n"; // \n fixes a glitch
//check for password being same
  if($pass == $data[1] OR $oldpass == $data[1]){ // SCORE, signin works.
 //     header("Location: /account/?signin=".$_POST["username"]);
//      echo "heyy";
//      setcookie("signin", $_POST["username"], time()+3600);
	$_SESSION['login'] = true;
      authed();
    if(isset($_POST["api"])){
        ob_get_clean();
        getMessages($_POST["username"]);
    }
      break; // exit the foreach loop
    } else { // if given-passwords' hash != stored hash
//      echo $pass ." is not ".$data[1];
//      echo "<br> and..".$oldpass ." is not ".$data[1];
	echo "That is not the stored password.";
	include "sexy-form.php";
	break; // this really is needed otherwise it lets you ..do bad things
  }
//end check
   } else {
    $exists = 0;
//      echo " username does no existo.<br>";
// do nothing because we're scanning each line, and each line of != would be spam..
   }

    }//end foreach
 if($exists == 0){
    echo "username no existo<br>";
 }
} // end if($_POST["signin"])
//echo $HTTP_COOKIE_VARS["signin"]; //these dont work, ignore..
//echo $_COOKIES["signin"]; //these dont work, ignore..

ob_end_flush();
?>
<link rel='stylesheet prefetch' href='http://cdn.jsdelivr.net/foundation/5.2.1/css/foundation.min.css'>
<style>
code{
word-wrap: break-word;
width:400px;
}
.scrolls{
/*height:230px;
width:800px;
overflow:scroll;*/
}
#backtologin{
position:fixed;
right:0px;
top:0px;
content:hi;
}
form{
width:400px;
}
</style>
<div id="backtologin">
<a href="/account?<?= rand()?>">Back to login page</a>
</div>
<form method="POST" action="">
Add account.
<input type="hidden" name="signup" value="true">
<input type="text" name="username" placeholder="Username">
<input type="password" name="password" placeholder="Password">
<input type="submit">
</form>
<form method="POST" action="">
Sign in.
<input type="hidden" name="signin" value="true">
<input type="text" name="username" placeholder="Username">
<input type="password" name="password" placeholder="Password">
api mode: <input type="checkbox" name="api">
<input type="submit">
</form>

<form method="GET" action="">
<input type="hidden" name="dump" value="true">
<input type="submit" value="get sourcecode">
</form>
<!--form method="GET" action="">
<input type="hidden" name="getUsers" value="true">
<input type="submit" value="get users">
</form-->
<script>
function st(str){
  return str.replace(/./g, function(chr){
    return chr + '\u0336';
  });
}
//alert(st("LOL"))
</script>
<div class="small-3 columns">
<div class="row">
<?php getUsers(); ?>
</div></div>
<?php echo "you are signed in as ".$_SESSION['login']; ?>
