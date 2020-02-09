<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat - Customer Module</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>
<body>
<div class="navbar">
        <a style="text-align:center; display:inline-grid;" href="mainpage.html">Back to Home</a> <!-- FIX LINK -->
        <link rel="stylesheet" href="mainpage.html">
        <div class="dropdown">
          <button class="dropbtn">Other 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="journal.html">Journal</a>
            <a href="exercise.html">Exercise Calendar</a>
            <a href="checklist.html">Check List</a>
            <a href="index.php">Community</a>
          </div>
        </div> 
      </div>
</body>
<br>
<?php
session_start();
 
function loginForm(){
    echo'
    <div id="loginform">
    <form action="index.php" method="post">
        <p>Enter in an anonymous name and enter the chatroom to communicate with others</p>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" />
        <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
    <img src="img/loveGif.gif" alt="love" style="width:100px;height:100px;">
    </div>
    ';
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        $fp = fopen("log.html", 'a');
        fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has entered the chat session.</i><br></div>");
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}

if(isset($_GET['logout'])){ 
     
    //Simple exit message
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
    fclose($fp);
     
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
?>

<style>
 body {
  font-family: Arial, Helvetica, sans-serif;
}

.navbar {
  overflow: hidden;
  background-color: #4a2700;
  margin-top: -26px;
  padding: 8px 100px;
}

.navbar a {
  font-size: 16px;
  color: white;
  padding: 8px 16px;
  text-decoration: none;
  margin-left: -30px;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 8px 25px;
  background-color: inherit;
  font-family: inherit;

}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #664c30;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 20px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 40px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
  background-color: #ddd;
  padding: 12px 10px;
  margin-left: 0px;
}

.dropdown:hover .dropdown-content {
  display: block;
  padding: 12px 10px;
  margin-left: -50px;
}

/* CSS Document */
body {
    font-family: "Verdana", sans-serif;
    color: #222;
    text-align:center;
    padding:35px; 
    font-size: 12px;}
  
form, p, span {
    margin:0;
    padding:0; }
  
input {font-size: 12px;
      font-family: "Verdana", sans-serif;  }
  
a {
    color:#0000FF;
    text-decoration:none; }
  
    a:hover { text-decoration:underline; }
  
#wrapper, #loginform {
    margin:0 auto;
    padding-bottom:25px;
    background:#ffdbfc;
    width:504px;
    border-radius: 20px;
    border:1px solid #f7b7f2;
}
  
#loginform { 
    padding-top:18px; 
    border-radius: 20px; }
  
    #loginform p { margin: 5px; }
  
#chatbox {
    text-align:left;
    margin:0 auto;
    margin-bottom:25px;
    padding:10px;
    background:#fff;
    height:270px;
    width:430px;
    border:1px solid #f7b7f2;
    overflow:auto; }
  
#usermsg {
    width:395px;
    border:1px solid #f7b7f2; }
  
#submit { width: 60px; }
  
.error { color: #ff0000; }
  
#menu { padding:12.5px 25px 12.5px 25px; }
  
.welcome { float:left; }
  
.logout { float:right; }
  
.msgln { margin:0 0 2px 0; }
</style>

<?php
if(!isset($_SESSION['name'])){
    loginForm();
}
else{
?>
<div id="wrapper">
    <div id="menu">
        <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
        <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        <div style="clear:both"></div>
    </div>    
    <div id="chatbox"><?php
    if(file_exists("log.html") && filesize("log.html") > 0){
        $handle = fopen("log.html", "r");
        $contents = fread($handle, filesize("log.html"));
        fclose($handle);
     
        echo $contents;
    }
    ?></div>
     
    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" size="63" />
        <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
    </form>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
    $("#exit").click(function(){
		var exit = confirm("Are you sure you want to leave the chatroom?");
		if(exit==true){window.location = 'index.php?logout=true';}		
	});
    $("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		return false;
	});
});

function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
				//Auto-scroll			
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
setInterval (loadLog, 2500);	
</script>
<?php
}
?>

</body>
</html>