<!DOCTYPE html>
<html>
<head>
    <base href="../../">
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/facebox.js"></script>
    <script src="js/gameSettings.js"></script>
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
        <h1 id="gameName"><?php echo $game; ?></h1>
        <h3 id="groupName"><?php echo $team; ?></h3>
        <h3>Instruction:</h3>
            <div id="gameDesc" class="jumbotron">
                <?php echo $instruction; ?>
            </div>
        <h3>Leaderboard:</h3>
            <div id="scoreArea", class="jumbotron">
            <?php 
                include "getScore.php";
                $name_escaped = str_replace(' ', '_', $game);
                getScore($game, $scoring);
            ?>
            </div>
        <h3>Settings</h3>
            <form id="gameSettings" class="well">
                <h3> If you want to play in a separate window, press popup</h3>
            </form>
            <?php echo '<iframe src="games/'.$name_escaped.'/'.$index.'" class="game" width="'.$width.'" height="'.$height.'"></iframe>'; ?>
    </article>
    <?php include "footer.php"; ?>
</div>
<script type="text/javascript">
    <?php echo 'newWindowBtn('.$width.','.$height.',"games/'.$name_escaped.'/'.$index.'", []);'; ?>
</script>
</body>
</html>
