<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \X\Util\Logger;
use \Google\Authenticator\GoogleAuthenticator;

class AuthSecretService extends \AppModel
{
  protected $model = 'AuthSecretModel';

  public function getSecretByUid(string $id) {
    // Find secret that matches your user id.
    $auth = $this->AuthSecretModel
      ->where('uid', $id)
      ->get()
      ->row_array();

    // no secret is found.
    if (empty($auth))
      return null;

    return $auth['secret'];
  }

  public function checkCode(string $id,string $code) {
    $secret = $this->getSecretByUid($id);
    $g = new GoogleAuthenticator();
    $isValid = $g->checkCode($secret, $code);
    if (!empty($isValid)){
      return true;
    }

    return false;
  }

  public function insertSecret(string $id,string $secret) {
    $this->AuthSecretModel
      ->set('secret', $secret)
      ->set('uid', $id)
      ->insert();
  }
}