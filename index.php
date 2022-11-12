<!DOCTYPE html>
<html>
<head>
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/facebox.js"></script>
    <link rel="stylesheet" type="text/css" href="css/facebox.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox()
        })
    </script>
</head>
<body>
<div class="container">
    <?php include "header.php"; ?>
<nav>
  <ul>
      <li><a href="">Home</a></li>
  </ul>
    <?php include "leftMenuGame.php"; ?>
</nav>
<article>
<div id="intro", class="jumbotron">
	<strong>Welcome</strong></br>
	<p>This website contains competitive puzzles
for your mathematical/logical pleasure. All games 
were built by students in 
the class Heuristic Problem Solving at NYU.</p>
	</br>
	<p><i><b>For HPS colleagues: </b></i>Upload your games from the backroom.</p>
	<p><i><b>For external puzzle lovers: </b></i>You can register to play games and beat the leaderboard or just enjoy as a guest: only registered users may use the save/load functions on supported games.</p>
</div>
<!--h2><a href="images/loading.gif" rel="facebox">text</a-->
</article>
    <?php include "footer.php"; ?>
</div>

</body>
</html>
