<?php
  class RequestResponse {
    public $success;
    public $message;

    function __construct ($success, $message) {
      $this->success = $success;
      $this->message = $message;
    }
  }
?>