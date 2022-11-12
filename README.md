# DrEcco (2022)

## For HPS colleagues developing games

All games that need to be uploaded on the website must implement the following items:

1. The game must be submitted as a ZIP archive, which unzips into files directly (not a directory containing those files).
2. The main entry point to your game as an HTML file. (`iframe.html` in the example.)
3. Various metadata and configurations in `index.php`. (See example.)

In addition, there are 3 APIs that may be helpful:

1. saveData API

Source code is in `dbman/saveData.php`. If your game need to save intermediate state between each new games, saveData provides a VARCHAR(255) to save that state. It returns 200 if save success; 404 if username does not exist.

Usage:
* Send `GET` request to `dbman/saveData.php`

Parameters:
* type: `save` or `load`
* user: username of the current player
* game: game name
* data: a string less than 255 (only for type=save)

2. saveScore API

Source code is in `dbman/saveScore.php`. saveScore provides a VARCHAR(255) to store the game score. If your game does not have an actual score, just send "WIN", "LOSE" or "TIE". If your game have several roles, say Hunter and Prey, please come up a single score which makes sense to all roles.

Usage:
* Send `GET` request to `dbman/saveScore.php`

Parameters:
* gamename: name of your game, should be the same as `$game` in `index.php`
* playername: default player1/2/3 or any name user sets in this game
* score: "WIN", "LOSE", "TIE" or a numeric score.

3. getScore API

Source code is in `getScore.php`. It displays a scoreboard and is automatically included in `index.php` from a template.

### index.php

This file defines various metadata for your game and also serves as the entry point on Dr.Ecco website. Most of it should be self-explanatory. Note that you may use inline HTML in the instruction part. Finally, do not change the last line and take a note of your game's name (the `$game` variable) as you need it to upload your game.

### Upload your game

After finishing your game and `index.php`, put everything into a ZIP file. Then, go to [Backroom](https://cims.nyu.edu/~tl3514/drecco/backroom/addgame.php).

* Game name: This must be exactly the same as `$game` in your `index.php`.
* Select zip file to upload: The ZIP file you just made, which must contain `index.php` and be 20MB or less.
* Overwrite: You should only set it when you need to update your game. Never set it when uploading for the first time.

Click "Upload". The server will do some basic checks and then update server-side stuffs automatically. If you see
```
Passed: Done.
```
then you are good to go and should see your game on the website immediately. Otherwise, it will point out the error you need to fix.

* Error: File size less than 20MB.
  * Did you include `node_modules` in your ZIP file? You probably don't need them in the production build.
* Error: /web/tl3514/drecco/games/Game_Name exists.
  * If it's your first time uploading a game, then its name conflicts with some others' existing game. Otherwise, check "Overwrite".
* Error: Index.php exists.
  * Did you zipped the whole folder instead of these files directly?


## For future architects

**Important Note**: The file named `dbconf.php` must NOT be shared with anyone under any circumstances as it contains the main DB password for the Dr Ecco website. Please mask the login infomation in `dbconf.php` before sharing these instructions with the class.

This GitHub repository contains the whole server and select games as examples (in `/games/`). The only thing missing from the production server is the database password, which you need to provide on your own if you want to run a self-hosted copy.

### Setting up the database:
* Go to [CIMS guide](https://cims.nyu.edu/webapps/content/systems/userservices/databases) and follow instructions there and create a database.
  * create database called drecco, and your net id will be prepend as tl3514_drecco.

### Transferring the webpage to your cims account
Login to access.cims.nyu.edu
```
cd /web/$USER
git clone https://github.com/09fl/drecco.git
cd drecco/
```

### Changing the required parts to run your web page and connect to database.
You need to change the database information and/or file upload destination:
| File Path  | Lines to Change |
| ------------- | ------------- |
| backroom/upload.php  | 6  |
| dbconf.php  | 4-6  |

### Updating folder and file permissions to public access
Make sure that all **required** files are in `rw-r--r--` mode and all folders are in `rwxr-xr-x` mode (except `/games`, which requires `rwxrwxrwx` to allow file uploading) at a minimum.
```
chmod -R u+rwX,go+rX .
chmod 777 games
```

### Initialize database
Go to https://cims.nyu.edu/~tl3514/drecco/backroom/initdb.php. If you see `Database initialized` then the initialization script has done its job.

To check its results, go to https://cims.nyu.edu/phpMyAdmin/index.php to see the newly created tables.

### Adding a new game
Once we are done with the permission, we can add a game now. Refer to the guide above to see how to add a new game.

**Note again**: Do not share the main DB passwd with anyone.
