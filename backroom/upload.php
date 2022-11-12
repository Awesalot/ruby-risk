<?php
require dirname(__FILE__)."/../dbman/includes/functions.php";
require dirname(__FILE__)."/../dbconf.php";
$dbc = new DbConn;

$upload_base = '/web/tl3514/drecco/games/';

function chmod_r($dir) {
  if (is_dir($dir)) {
    chmod($dir, 0775);
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
          chmod_r($dir. DIRECTORY_SEPARATOR .$object);
        else
          chmod($dir. DIRECTORY_SEPARATOR .$object, 0664);
        }
    }
  }
}
function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
          rrmdir($dir. DIRECTORY_SEPARATOR .$object);
        else
          unlink($dir. DIRECTORY_SEPARATOR .$object);
      }
    }
    rmdir($dir);
  }
}
function printError($message) {
  echo '<font color="red">Error: </font>';
  echo $message;
  echo '<br>';
}
function printSuccess($message) {
  echo '<font color="green">Passed: </font>';
  echo $message;
  echo '<br>';
}

function process($name, $dirname, $overwrite) {
  echo "Uploading $name to $dirname ...<br><br>";

  // Sanity checks before unzipping
  $file = $_FILES["file"];
  $message = 'Is zip file.';
  if (strtolower(pathinfo($file["name"],PATHINFO_EXTENSION)) != 'zip') {
    printError($message);
    return FALSE;
  }
  printSuccess($message);

  $message = 'File size less than 20MB.';
  if ($file["size"] > 20000000) {
    printError($message);
    return FALSE;
  }
  printSuccess($message);

  // Check directory
  if (!$overwrite && file_exists($dirname)) {
    printError($dirname.' exists.');
    return FALSE;
  }
  if ($overwrite) {
    printSuccess($dirname.' exists. Will overwrite.');
  } else {
    printSuccess($dirname.' does not exist.');
  }

  // Unzip
  $zip = new ZipArchive;
  $zip->open($file["tmp_name"]);
  mkdir($dirname.'_');
  $message = 'File unzipped successfully.';
  if (!$zip->extractTo($dirname.'_')) {
    printError($message);
    return FALSE;
  }
  $zip->close();
  chmod_r($dirname.'_');
  printSuccess($message);

  // Check index file
  $message = 'Index.php exists.';
  if (!file_exists($dirname.'_/index.php')) {
    printError($message);
    return FALSE;
  }
  printSuccess($message);

  // Finish
  if ($overwrite) {
    rrmdir($dirname);
  }
  rename($dirname.'_', $dirname);
  return TRUE;
}

if (isset($_POST["submit"])) {
  $name = trim($_POST["name"]);
  $name_escaped = str_replace(' ', '_', $name);
  $dirname = $upload_base.$name_escaped;
  $overwrite = $_POST["overwrite"] == 'on';
  if (process($name, $dirname, $overwrite)) {
    printSuccess('Upload success.');

    // Modify database
    $dbc->conn->query("DELETE FROM game WHERE name='$name'");
    $dbc->conn->query("INSERT INTO game(name, dir) VALUES ('$name', 'games/$name_escaped')");
    printSuccess('Database updated.');

    echo '<br>';
    printSuccess('Done.');
  } else {
    // Clean-up
    rrmdir($dirname.'_');
  }
}
