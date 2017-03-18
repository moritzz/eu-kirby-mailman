<?php
/**
 * EU-KIRBY-MAILMAN
 *
 * This is a Kirby snippet (to be used with the Kirby CMS.
 * It provides a seamless (un)subscription form for GNU Mailman.
 *
 * @version   0.1
 * @author    error:undefined design <http://error-undefined.de>
 * @link      https://github.com/errorundefined/eu-kirby-mailman
 * @license   MIT <http://opensource.org/licenses/MIT>
 *
 * FIELD REQUIREMENTS
 *
 * $site->mailmanurl() ---> url to mailman itself (like so: 'https://lists.example.org/cgi-bin/mailman/') [1]
 * $site->mailmanlist() ---> name of your mailman list (like so: 'info') [1]
 *
 * [1] = note that you can also add more than one list,
 * that's done by putting stuff in both the fields, only
 * seperating each instance by a semicolon (`;`)
 */

// DATA FROM SITE'S OPTIONS
$mailman = $site->mailmanurl();
$listname = $site->mailmanlist();

// THINGS ARE VERY WRONG
$email = false;
$multilist = false;

// IS THERE MORE THAN ONE LIST?
if ( strpos($mailman, ';') !== FALSE ){

	$multilist = true;

	// MAKE ARRAYS OUT OF THAT STUFF
	$mailmen = explode( ';', $mailman );
	$listnames = explode( ';', $listname );

	// MAKE SURE THERE'S NO TRAILING SLASH
	function slashtrim( $string ) {
		return rtrim( $string, '/' );
	}
	$mailmen = array_map( 'slashtrim', $mailmen );

	// COMBINE THAT IN ONE ARRAY
	$lists_array = array_combine( $mailmen, $listnames );

} else {

	// MAKE SURE THERE'S NO TRAILING SLASH
	$mailman = rtrim( $mailman, '/' );

}

// DATA FROM PAGE'S FORM
if ( isset($_POST['email']) ){
	$email = $_POST['email'];
}

// FUNCTION TO GET MAILMAN RESPONSE
function eu_mailman_getresponse( $mailman, $listname, $url ){

	$response = '';

	function make_warning_an_exception() {
		throw new Exception('The listserver did not respond.');
	}

	set_error_handler('make_warning_an_exception', E_WARNING);

	try {
		$response = file_get_contents( $url );

	} catch(Exception $e) {
		echo '<p class="eu-mailman__message error"><strong>Error:</strong> The listserver did not respond. <a href="' . $mailman  . '/listinfo/' . $listname . '" target="_blank">Try manually?</a></p>';
	}

	restore_error_handler();
	
	return $response;

}

// FUNCTION TO PARSE MAILMAN RESPONSE
function eu_mailman_parseresponse( $listname, $request, $response ) {

	if( !empty( $response ) ){

		$dom = new domDocument( '1.0', 'utf-8' ); 
		$dom->loadHTML( mb_convert_encoding( $response, 'HTML-ENTITIES', 'UTF-8' ) );
		$dom->preserveWhiteSpace = false;

		if( $request == 'subscribe' ){
			
			$heading = $dom->getElementsByTagName('h1')->item(0)->nodeValue;
			$address = $dom->getElementsByTagName('address')->item(0)->nodeValue;

			$theresponse = str_replace( $heading, '', $dom->textContent );
			$theresponse = str_replace( $address, '', $theresponse );

		} elseif( $request == 'unsubscribe' ){
			$theresponse = $dom->getElementsByTagName('h3')->item(0)->nodeValue;

		}

		echo '<p class="eu-mailman__message"><strong>"' . $listname  .'"-'. $request . ':</strong> ' . $theresponse . '</p>';
	
	}
}

?>
<form class="eu-mailman" method="post">

	<?php if( $multilist ){

		echo '<div class="eu-mailman__options">';

		foreach( $lists_array as $mailman => $listname ){?>

		<input type="radio" name="listname" value="<?php echo $listname ?>" id="<?php echo $listname ?>"  required/><label for="<?php echo $listname ?>"> <?php echo $listname ?></label><?php
		}

		echo '</div>';
	}?>

	<input type="email" name="email" placeholder="E-Mail" />
	
	<div class="eu-mailman__buttons">
		<input type="submit" name="unsubscribe" value="unsubscribe" />
		<input type="submit" name="subscribe" value="subscribe" />
	</div>

	<?php // RESPOND TO FORM INPUT
	if ( isset($_POST['subscribe']) && $email != false ) {

		// GET VARS FOR MULTILIST
		if ( $multilist ){
			$listname = $_POST['listname'];
			$mailman = array_search( $listname, $lists_array );
		}

		// SUBSCRIBE ADDRESS
		$url = $mailman . '/subscribe/' . $listname . '/info?email=' . $email;

		$response = eu_mailman_getresponse( $mailman, $listname, $url );

		eu_mailman_parseresponse( $listname, 'subscribe', $response );

	} elseif( isset($_POST['unsubscribe']) && $email != false ) {

		// GET VARS FOR MULTILIST
		if ( $multilist ){
			$listname = $_POST['listname'];
			$mailman = array_search( $listname, $lists_array );
		}

		// UNSUBSCRIBE ADDRESS
		$url = $mailman . '/options/' . $listname . '?email=' . $email . '&password=&login-unsub=1';

		$response = eu_mailman_getresponse( $mailman, $listname, $url );

		eu_mailman_parseresponse( $listname, 'unsubscribe', $response );

	} elseif( isset($_POST['email']) && filter_var( $email, FILTER_VALIDATE_EMAIL ) === false ) {
		echo '<p class="eu-mailman__message error"><strong>Error:</strong> Please provide a valid email address!</p>';
	} ?>

</form>