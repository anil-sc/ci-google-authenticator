<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \X\Annotation\Access;
use \X\Util\Logger;
use const \X\Constant\HTTP_BAD_REQUEST;
use const \X\Constant\HTTP_CREATED;
use const \X\Constant\HTTP_NO_CONTENT;
use \Sonata\GoogleAuthenticator\GoogleAuthenticator;

class Mfa extends AppController {

  protected $model = ['UserService','AuthSecretService'];

  /**
   * Authenticate with username and password.
   * 
   * @Access(allow_login=true, allow_logoff=false)
   */
  public function checkCode() {

    Logger::debug('Parameters:', $this->input->post());

    try {
      // Check input data.
      $this->form_validation
        ->set_data($this->input->post())
        ->set_rules('mfa', 'mfa', 'required');
      if (!$this->form_validation->run()) {
        Logger::error($this->form_validation->error_array());
        return parent::set('error', 'input_error')::set('error_description', $this->form_validation->error_array())::json();
      }
      // Authenticate MFA code
      $secret = $this->AuthSecretService->checkCode($_SESSION[SESSION_NAME]['id'],$this->input->post('mfa'));
      parent::set($secret)::json();
    } catch (\Throwable $e) {
      Logger::error($e);
      parent::error($e->getMessage(), HTTP_BAD_REQUEST);
    }
  }
}