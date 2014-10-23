How to contribute
=================

If you wish to contribute, please fork this repository and create a new 
branch, preferably with the name `evdo-<summary of contribution>`. When 
you have finished and successfully [built](#building) and tested, you 
may submit a pull request.

If you wish to contribute frequently, you may contact Dojo via private 
message on AoPS with your GitHub username to be accepted as a 
collaborator. Note that you will have to submit your Trello username as 
well, as we use it for communication.

Building
========

We use [Gulp](http://gulpjs.com) as our build system for CSS and JS. To 
use Gulp, make sure you have NodeJS and npm installed on your system, 
then run:

    $ [sudo] npm install -g gulp
    $ [sudo] npm install gulp-changed gulp-csslint gulp-jshint gulp-minify-css gulp-rename gulp-uglify gulp-util minimist

You can then run Gulp with

    $ gulp

Gulp will automatically watch files in `src/css` and `src/js` for you, 
and output the result to `css/` and `js/` respectively. In the case 
that you wish Gulp not watch files, you may add the `--no-watch` flag.

Contact
=======

You may contact us via our [contact form](http://www.everythingdojo.com/contact.php).
