<?php 
/**
 * We will be using PHPMailer to solve
 * our mailing needs
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
	
	/**
	 * Debugging mode, set it to true to see
	 * outpun of errors
	 * 
	 * @param bool $debug
	 */
	private $debug = true;

	/**
	 * Hostname or domain of your email
	 * address
	 * 
	 * example: mydomain.godaddy.com
	 * or something, usually your registrar will
	 * give you this params
	 * 
	 * @param string $host
	 */
	private $host;

	/**
	 * Our instance for PHPMailer
	 * will be hold here
	 * 
	 * @param mixed $mailer;
	 */
	private $mailer;

	/**
	 * Credentials from SMTP
	 * You should use your live or remote
	 * server authentication credentials
	 * it will work for testing also and you
	 * wont need to make any changes when 
	 * moving to production
	 * 
	 * @param string $username
	 * @param string $password
	 */
	private $username;
	private $password;

	/**
	 * Message subject
	 * 
	 * @param string $subject
	 */
	private $subject;

	/**
	 * Message alt body
	 * this loads first than everything after
	 * and shows on mobile when you
	 * receive and email inside the notification
	 * 
	 * @param string $alt_body;
	 */
	private $alt_body;

	/**
	 * Body of message, it could be
	 * html or plain text
	 * 
	 * @param string $body
	 */
	private $body;

	/**
	 * Headers of email // we may not used them
	 * 
	 * @param string $headers
	 */
	private $headers;

	/**
	 * Email address to send from
	 * 
	 * @param string $from
	 */
	private $from;

	/**
	 * Emails address to send to
	 * this could be also an array of emails
	 * to send to multiple addresses
	 * 
	 * @param mixed $to
	 */
	private $to;

	/**
	 * Email address to reply to
	 * 
	 * @param string $reply_to
	 */
	private $reply_to;

	/**
	 * Bcc send to email address
	 * this can be also an array of emails to
	 * send to
	 * 
	 * @param mixed $bcc
	 * @param mixed $cc
	 */
	private $bcc;
	private $cc;

	/**
	 * Attachments to add to our
	 * message, one to many
	 * 
	 * @param array $attachments
	 */
	private $attachments;

	/**
	 * Our charset to be used
	 * we recommend to use UTF-8
	 * and nothing else, it depends of where 
	 * you actually live or where your application
	 * will be used (and your users)
	 * 
	 * But usually utf-8 will do for almost
	 * every case
	 * 
	 * @param string $charset
	 */
	private $charset;

	/** PLEASE DEFINE THIS ONES INLINE */

	/**
	 * Set if we are using
	 * SMTP mailing (it's the best option)
	 * default is true
	 * 
	 * Don't worry, you can re set it
	 * everytime you want using
	 * its setter method
	 * 
	 * @param bool $is_smtp
	 */
	private $is_smtp;

	/**
	 * Define this to true if you
	 * will be using html on your emails
	 * by default is set to true
	 * 
	 * @param bool $is_html;
	 */
	private $is_html = true;


	
	function __construct()
	{
		// If we are gonna use SMTP server
		$this->is_smtp = SMTP;

		// Charset to be used UTF-8 by default
		$this->charset = SMTP_CHARSET;

		// We start our instance of PHPMailer
		$this->mailer  = new PHPMailer(); // Pass true

		// If we are going to use SMTP
		// We need to check if everything is set correctly
		if($this->is_smtp){
			$this->host     = SMTP_HOST;
			$this->port     = SMTP_PORT;
			$this->username = SMTP_USERNAME;
			$this->password = SMTP_PASSWORD;

			// We define our SMTP credentials
			$this->mailer->IsSMTP();
			$this->mailer->SMTPAuth      = true;
			$this->mailer->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead

			if(SMTP_SSL === true) {
				$this->mailer->SMTPSecure = "ssl";
			}

			$this->mailer->Host     = $this->host;
			$this->mailer->Username = $this->username;
			$this->mailer->Password = $this->password;
		}

		// Send using mail() function
		$this->mailer->IsMail();
		
		// This will be set either way
		// if we are using or not SMTP
		$this->mailer->CharSet = $this->charset;

		// If we are using html to output our messages
		if($this->is_html){
			$this->mailer->isHTML(true);
		}

		// at this point we already have everything set
		// to send emails
		return $this;
	}

	/**
	 * We set our FROM email address
	 */
	public function setFrom($email , $name = null)
	{
		if(!$this->mailer){
			throw new LumusException(sprintf("No %s instance found",'PHPMailer'), 1);
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new LumusException(sprintf("%s, is not a valid email address.", $email), 1);
		}

		$this->mailer->setFrom($email , $name);

		return true;

	}

	/**
	 * To add our subject to the email
	 * 
	 */
	public function setSubject($subject)
	{

		// We need to know if it's a valid subject
		if(!is_string($subject)){
			throw new LumusException(sprintf("%s is not a valid %s, string needed.",$subject,'subject'), 1);
		}

		// Sanitize subject string, just to remove white spaces
		$this->subject         = trim($subject);
		$this->mailer->Subject = $this->subject;

		return true;

	}

	/**
	 * To add our altbody to the email
	 * 
	 */
	public function setAltBody($alt)
	{
		// Sanitize subject string, just to remove white spaces
		$this->alt_body        = trim($alt);
		$this->mailer->AltBody = $this->alt_body;

		return true;
	}

	/**
	 * To add our main body or message to the email
	 * 
	 */
	public function setBody($body)
	{

		// We need to know if it's a valid subject
		if(!is_string($body)){
			throw new LumusException(sprintf("%s is not a valid %s, %s needed.",$body,'body content','string'), 1);
		}

		// Sanitize subject string, just to remove white spaces
		$this->body         = trim($body);
		$this->mailer->Body = $this->body;
		return true;

	}

	/**
	 * To add addresses to email to
	 * you can use either an array or string
	 */
	public function addAddress($email)
	{

		if(!$this->mailer){
			throw new LumusException(sprintf("No %s instance found",'PHPMailer'), 1);
		}

		if(is_array($email)){
			foreach ($email as $e) {
				echo $e;
				if(!filter_var($e , FILTER_VALIDATE_EMAIL)){
					throw new LumusException(sprintf("%s, is not a valid email address.",$e), 1);
				}

				$this->mailer->addAddress($e);
			}
		} else {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				throw new LumusException(sprintf("%s, is not a valid email address.", $email), 1);
			}
			
			$this->mailer->addAddress($email);
		}
		
		return true;
	}

	public function add_attachment($file)
	{
		if(!is_array($file)){
			if(!is_file($file)){
				throw new LumusException(sprintf('Provided file %s does not exist.' , basename($file)), 1);
			}

			$this->mailer->addAttachment($file);
			return $this;
		}

		/** If it's an array of files */
		foreach ($file as $f) {
			if(!is_file($f)){
				throw new LumusException(sprintf('Provided file %s does not exist.' , basename($f)), 1);
			}

			$this->mailer->addAttachment($f);
		}

		return $this;
	}

	/**
	 * Function to actually send our email
	 * 
	 * @return bool | string error
	 */
	public function send()
	{
		try {
			
			$this->mailer->send();
			$this->mailer->clearAddresses();
			$this->mailer->ClearAllRecipients();
			$this->mailer = null;
			return true;

		} catch (Exception $e) {
			
			if($this->debug){
				echo $e->getMessage();
			}
			
			$this->mailer = null;		
			return false;
		}
	}

	/**
	 * Set set if we are using
	 *
	 * @return  self
	 */ 
	public function setSMTP($is_smtp)
	{
		$this->is_smtp = $is_smtp;

		return $this;
	}

	/**
	 * Tests SMTP connection to server
	 *
	 * @param string $host
	 * @param integer $port
	 * @param string $email
	 * @param string $password
	 * @return void
	 */
	public static function test_connection($host , $port = null , $email , $password , $debug = false)
	{
		//Create a new SMTP instance
		$smtp = new SMTP;

		//Enable connection-level debug output
		if($debug){
			$smtp->do_debug = SMTP::DEBUG_CONNECTION;
		}

		//Connect to an SMTP server
		if (!$smtp->connect($host , $port , 20)) {
			throw new LumusException('La conexión falló, hubo un error.');
		}

		//Say hello
		if (!$smtp->hello(gethostname())) {
			throw new LumusException('EHLO failed: ' . $smtp->getError()['error']);
		}

		//Get the list of ESMTP services the server offers
		$e = $smtp->getServerExtList();

		//If server can do TLS encryption, use it
		if (is_array($e) && array_key_exists('STARTTLS', $e)) {
			$tlsok = $smtp->startTLS();
			if (!$tlsok) {
				throw new LumusException('Failed to start encryption: ' . $smtp->getError()['error']);
			}
			
			//Repeat EHLO after STARTTLS
			if (!$smtp->hello(gethostname())) {
				throw new LumusException('EHLO (2) failed: ' . $smtp->getError()['error']);
			}
			//Get new capabilities list, which will usually now include AUTH if it didn't before
			$e = $smtp->getServerExtList();
		}

		//If server supports authentication, do it (even if no encryption)
		if (is_array($e) && array_key_exists('AUTH', $e)) {
			if ($smtp->authenticate( $email , $password)) {
				$smtp->quit(true);
				return true;
			} else {
				throw new LumusException('La autenticación falló: ' . $smtp->getError()['error']);
			}
		}

		//Whatever happened, close the connection.
		$smtp->quit(true);
		return false;
	}

}