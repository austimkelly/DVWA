<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] = 'Source' . $page[ 'title_separator' ].$page[ 'title' ];

if (array_key_exists ("id", $_GET)) {
	/*
The vulnerability in the selected line of code is related to file inclusion attacks. 
An attacker can manipulate the id parameter in the URL to include arbitrary files from the server.
 For example, an attacker can use a URL like view_source_all.php?id=../../../../etc/passwd to include 
 the /etc/passwd file and view its contents.

To fix this vulnerability, the code should validate and sanitize the input before using it in the 
file_get_contents() function. One way to do this is to use a whitelist of allowed file names or 
paths and check if the input matches the whitelist. Another way is to use a regular expression to 
validate the input and remove any characters that are not allowed.
	*/
	$id = $_GET[ 'id' ];

/*
<?php
$id = $_GET[ 'id' ];
if (preg_match('/^[a-zA-Z0-9_]+$/', $id)) {
    $file = "path/to/files/" . $id . ".txt";
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo $content;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid input.";
}
?>
*/

/* 
In this example, the regular expression /^[a-zA-Z0-9_]+$/ is used to validate the input and allow
 only alphanumeric characters and underscores. The input is then concatenated with a fixed path 
 and a .txt extension to form the file name. The file_exists() function is used to check if the file 
 exists before reading its contents with file_get_contents(). If the file does not exist, an error message 
 is displayed. If the input is invalid, another error message is displayed.
*/


	$lowsrc = @file_get_contents("./{$id}/source/low.php");
	$lowsrc = str_replace( array( '$html .=' ), array( 'echo' ), $lowsrc);
	$lowsrc = highlight_string( $lowsrc, true );

	$medsrc = @file_get_contents("./{$id}/source/medium.php");
	$medsrc = str_replace( array( '$html .=' ), array( 'echo' ), $medsrc);
	$medsrc = highlight_string( $medsrc, true );

	$highsrc = @file_get_contents("./{$id}/source/high.php");
	$highsrc = str_replace( array( '$html .=' ), array( 'echo' ), $highsrc);
	$highsrc = highlight_string( $highsrc, true );

	$impsrc = @file_get_contents("./{$id}/source/impossible.php");
	$impsrc = str_replace( array( '$html .=' ), array( 'echo' ), $impsrc);
	$impsrc = highlight_string( $impsrc, true );

	switch ($id) {
		case "javascript" :
			$vuln = 'JavaScript';
			break;
		case "fi" :
			$vuln = 'File Inclusion';
			break;
		case "brute" :
			$vuln = 'Brute Force';
			break;
		case "csrf" :
			$vuln = 'CSRF';
			break;
		case "exec" :
			$vuln = 'Command Injection';
			break;
		case "sqli" :
			$vuln = 'SQL Injection';
			break;
		case "sqli_blind" :
			$vuln = 'SQL Injection (Blind)';
			break;
		case "upload" :
			$vuln = 'File Upload';
			break;
		case "xss_r" :
			$vuln = 'Reflected XSS';
			break;
		case "xss_s" :
			$vuln = 'Stored XSS';
			break;
		case "weak_id" :
			$vuln = 'Weak Session IDs';
			break;
		case "authbypass" :
			$vuln = 'Authorisation Bypass';
			break;
		case "open_redirect" :
			$vuln = 'Open HTTP Redirect';
			break;
		default:
			$vuln = "Unknown Vulnerability";
	}

	$page[ 'body' ] .= "
	<div class=\"body_padded\">
		<h1>{$vuln}</h1>
		<br />

		<h3>Impossible {$vuln} Source</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$impsrc}</div></td>
			</tr>
		</table>
		<br />

		<h3>High {$vuln} Source</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$highsrc}</div></td>
			</tr>
		</table>
		<br />

		<h3>Medium {$vuln} Source</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$medsrc}</div></td>
			</tr>
		</table>
		<br />

		<h3>Low {$vuln} Source</h3>
		<table width='100%' bgcolor='white' style=\"border:2px #C0C0C0 solid\">
			<tr>
				<td><div id=\"code\">{$lowsrc}</div></td>
			</tr>
		</table>
		<br /> <br />

		<form>
			<input type=\"button\" value=\"<-- Back\" onclick=\"history.go(-1);return true;\">
		</form>

	</div>\n";
} else {
	$page['body'] = "<p>Not found</p>";
}

dvwaSourceHtmlEcho( $page );

?>
