<?php

# Database link credentials
define ("DBNAME", "photogallery");
define ("DBUSER", "root");
define ("DBPASS", "");
define ("DBHOST", "localhost");

# App name
define ("WEB_TITLE", "Web app");

# App main folder name
define ("MAIN", "php-photo-gallery"); # App containing folder
define ("PATH", MAIN); # Add container folder if required

# PATH to media files and site root constants
define ("SITE_ROOT", "/" . PATH);
define ("MEDIA", SITE_ROOT . "/" . "common");
define ("HTML", "common" . DS . "html");
define ("SECTION", "common" . DS . "section");
define ("UPLOAD", "common/upload/");

# Default states
define ("DEFAULT_CONTROLLER", "gallery");
define ("DEFAULT_METHOD", "index");
define ("NOT_FOUND", "not_found");

# Startup Locales
define ("LOCALES", 
        array(
          "SITE_ROOT" => SITE_ROOT,
          "MEDIA" => MEDIA
        ));
