<?php 
/**
 * start page for webaccess
 * redirect the user to the supported page type by the users webbrowser (js available or not)
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PSI
 * @author    Michael Cramer <BigMichi1@users.sourceforge.net>
 * @copyright 2009 phpSysInfo
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @version   SVN: $Id: index.php 404 2010-11-16 11:46:01Z jacky672 $
 * @link      http://phpsysinfo.sourceforge.net
 */
 /**
 * define the application root path on the webserver
 * @var string
 */
define('APP_ROOT', dirname(__FILE__));

/**
 * internal xml or external
 * external is needed when running in static mode
 *
 * @var boolean
 */
define('PSI_INTERNAL_XML', false);

if (version_compare("5.2", PHP_VERSION, ">")) {
    die("PHP 5.2 or greater is required!!!");
}

require_once APP_ROOT.'/includes/autoloader.inc.php';

// redirect to page with and without javascript
$display = isset($_GET['disp']) ? $_GET['disp'] : "";
switch ($display) {
case "static":
    $webpage = new WebpageXSLT();
    $webpage->run();
    break;
case "dynamic":
    $webpage = new Webpage();
    $webpage->run();
    break;
case "xml":
    $webpage = new WebpageXML(true, null);
    $webpage->run();
    break;
default:
    echo "<?xml version=\"1.0\" encoding=\"utf-8\">\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD  XHTML 1.0  Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
    echo "  <head>\n";
    echo "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
    echo "    <meta http-equiv=\"Content-Script-Type\" content=\"text/javascript\" />\n";
    echo "    <meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />\n";
    echo "    <link href=\"gfx/favicon.png\" rel=\"shortcut icon\" />";
    echo "    <link type=\"text/css\" rel=\"stylesheet\" href=\"./templates/two.css\" />\n";
    echo "    <title>Redirection</title>\n";
    echo "    <noscript>\n";
    echo "      <meta http-equiv=\"refresh\" content=\"2; URL=index.php?disp=static\" />\n";
    echo "    </noscript>\n";
    echo "    <script type=\"text/JavaScript\" language=\"JavaScript\">\n";
    echo "      <!--\n";
    echo "      var sTargetURL = \"index.php?disp=dynamic\";\n";
    echo "      function doRedirect() {\n";
    echo "        setTimeout( \"window.location.href = sTargetURL\", 2*1000 );\n";
    echo "      }\n";
    echo "      //-->\n";
    echo "    </script>\n";
    echo "    <script type=\"text/JavaScript\" language=\"JavaScript1.1\">\n";
    echo "      <!--\n";
    echo "      function doRedirect() {\n";
    echo "        window.location.replace( sTargetURL );\n";
    echo "      }\n";
    echo "      doRedirect();\n";
    echo "      //-->\n";
    echo "    </script>\n";
    echo "  </head>\n";
    echo "  <body onload=\"doRedirect()\">\n";
    echo "    <h1>REDIRECTING ... </h1>\n";
    echo "    <div style=\"position:absolute;top:150px;text-align:center;width:95%;\">\n";
    echo "      <p style=\"margin:12pt;\">Loading <a href=\"index.php?disp=static\">redirection target</a></p>\n";
    echo "      <p style=\"margin:12pt;\">In approx. 2 seconds the redirection target page should load.<br/>\n";
    echo "      If it doesn't please select the link above.</p>\n";
    echo "      <p style=\"margin:12pt;\">Generated by&nbsp;<a href=\"http://phpsysinfo.sourceforge.net/\">phpSysInfo&nbsp;-&nbsp;".CommonFunctions::PSI_VERSION."</a></p>\n";
    echo "    </div>\n";
    echo "  </body>\n";
    echo "</html>\n";
    break;
}
die();
?>
