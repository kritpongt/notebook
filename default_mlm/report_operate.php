<? session_start();
require_once("connectmysql.php"); 
require_once("adminchecklogin.php");
require_once("global.php"); 
require_once("logtext.php");
require_once("function.log.inc.php");
include_once("../backoffice/linkheader.php");
include_once("../backoffice/linkjs.php");
// chk_click();

if(isset($_POST)){ getDataPOSTForm(); }

func_java_alert("Error!");exit;
logtext(true, $uid, "Log insert.", $ins_id);

func_java_alert('', "window.location='?sessiontab=".$_GET["sessiontab"]."&sub=".$_GET["sub"]."';"); 
exit;
?>