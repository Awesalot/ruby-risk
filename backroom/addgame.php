<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
</head>
<body>
<div class="container">
<h2>Backroom</h2>
  <div class="jumbotron">
  <form action="upload.php" method="post" enctype="multipart/form-data">
    Game name: <input type="text" name="name"><br>
    Select zip file to upload:
    <input type="file" name="file"><br>
    Overwrite: <input type="checkbox" name="overwrite"><br>
    <input type="submit" value="Upload" name="submit">
  </form>
  </div>
</div>
</body>
</html>
