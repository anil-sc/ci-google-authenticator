<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \X\Annotation\Access;
use \X\Util\Logger;
use \Sonata\GoogleAuthenticator\GoogleQrUrl;

class Mfa extends AppController {

  /**
   * @Access(allow_login=true, allow_logoff=false)
   */
  public function index() {
    $link = GoogleQrUrl::generate($_SESSION[SESSION_NAME]['email'], $_SESSION[SESSION_NAME]['secret'], 'GoogleAuthenticatorExample');
    parent
      ::set('link',$link)
      ::view('mfa');
  }
}