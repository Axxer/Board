<?php
/**
 * @author		SilexBoard Team
 *					Nut
 * @copyright	2011 SilexBoard
 */

// Schutz vor Direktaufruf der Datei
if(!defined('SILEX_VERSION'))
	header('location: ../');

//Falls eingeloggt, auf Startseite weiterleiten.	
if(session::read('userid')) 
	header("Location: index.php");

if(isset($_POST['Register'])) {
	$_SESSION['RegisterName'] = $_POST['Username'];
	$_SESSION['RegisterPass'] = $_POST['Password'];
	header("Location: ?page=Register");	
} else {
	//Formularauswerten
	$userid = login::check_user($_POST['Username'], $_POST['Password']);
	if ($userid) {
		//wen alles stimmt wird engeloggt
		login::DoLogin($userid); 
		session::set('userid', $userid);
		session::set('username', $_POST['Username']);
		$content = ('<p>{lang=com.sbb.login.redirect}</p>
		<p>{lang=com.sbb.login.ifnotredirect}<a href="secret.php">Link</a></p>
		<script type="text/javascript">
			window.setTimeout("window.location.href=\'secret.php\'",2000);
		</script>');
	} else {
		$content = '<p>{lang=com.sbb.login.wrongdata}</p>';
	}
	
	self::$TPL->Assign('Content', $content);
}
?>