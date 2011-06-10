<?php
/**
 * @author 		Cadillaxx
 * @copyright	© 2011 Silex Bulletin Board - Team
 * @license		GNU GENERAL PUBLIC LICENSE v3
 * @package		SilexBoard.DEV
 * @version		Revision: 12
 */

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE | E_STRICT);

// Include required files
require_once('config.inc.php');
require_once('constants.inc.php');
require_once('functions.inc.php');

// Initial
session_start();	// Start Session
user::Initial();	// Initial Usermanagement







// Info Variables
page::$Info['Site'] = 'Home';

// Connect to MySQL-Database
mysql::Connect($CFG_Host, $CFG_User, $CFG_Password, $CFG_Database);

$language = new language();

// default timezone (for date functions)
date_default_timezone_set('Europe/Berlin');

// template
$tpl = new template('case');

// Language Chooser
$Langs = $language->GetLanguages();
$DefaultLang = $language->Language;
foreach($Langs as $key => $val)
{
	if($DefaultLang == $key)
		$SelectLangs .= '<option selected="selected" value="'.$key.'">'.$val.'</option>';	
	else
		$SelectLangs .= '<option value="'.$key.'">'.$val.'</option>';					
}
$tpl->Assign('Languages',$SelectLangs);

// Breadcrumbstart
crumb::Add('{lang=com.sbb.crumbs.home}', './');

// Menu Parse
$tpl->Assign('Menu', menu::Parse());

// Get The Rights. Not useful at this moment
$group = groups::getRights();

// after 10 minutes you will automatically logged out
login::autoLogout(); 











// Template Stuff
$tpl->Assign(array(
	'Site'			=> 'Seitentitel',
	'Slogan'		=> 'Slogan der Seite',
	'MessageBox'	=> messagebox::GetBoxes(),
	'CSSStyles'		=> css::IncludeCSS()
));
page::Initial($tpl);
$language->Assign($tpl);
$tpl->Display(false, true);
?>