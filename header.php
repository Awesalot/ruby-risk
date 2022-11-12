<?php
session_start();
?>

<header>
   <h1>DR. ECCO <?php echo date('Y'); ?></h1>
   <h4><?php
       if (!isset($_SESSION['username'])) {
           echo "<a href='dbman/main_login.php' rel='facebox'>Login</a>";
           echo "\t";
           echo "<a href='dbman/signup.php' rel='facebox'>Register</a>";
       } else {
           setcookie('username', $_SESSION['username'], time() + (86400 * 30), "/");
           echo $_SESSION['username'];
           echo "\t";
           echo "<a href='dbman/logout.php'>Logout</a>";
       }
       ?></php></h4>
</header>
