<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \X\Annotation\Access;
use \X\Util\Logger;
use \Sonata\GoogleAuthenticator\GoogleQrUrl;
use \Sonata\GoogleAuthenticator\GoogleAuthenticator;

class Mfa extends AppController {
  protected $model = "AuthSecretService";

  /**
   * @Access(allow_login=true, allow_logoff=false)
   */
  public function index() {
    $g = new GoogleAuthenticator();
    $code = $g->getCode($_SESSION[SESSION_NAME]['secret']);
    $link = GoogleQrUrl::generate($_SESSION[SESSION_NAME]['email'], $_SESSION[SESSION_NAME]['secret'], 'GoogleAuthenticatorExample');
    parent
      ::set('link',$link)
      ::set('code',$code)
      ::view('mfa');
  }
}