<?php

abstract class config {
  protected $config = array();
  protected $target;

  public function __construct($target) {
    $this->target = $target;
  }

  public function setConfig($key, $value) {
    $this->config[$key] = $value;
  }

  public function getAllConfig() {
    return $this->config;
  }

  public function getTarget() {
    return $this->target;
  }

  static function getInstance($target) {
    return new sendInfo($target);
  }

  abstract function send();
  abstract function archive();
}

class sendInfo extends config {

  public function archive() {}

  public function send() {
    if ($this->checkConfig()) {
      $files = $this->getFiles();
    }
  }

  protected function checkConfig() {
    if (is_dir($this->config['source'])) {
      return TRUE;
    }
    return FALSE;
  }

  protected function getFiles() {
    $content = scandir($this->config['source']);
    $files = array();
    if ($content) {
      foreach(array_diff($content, array('.', '..')) as $item) {
        if (!is_dir($this->config['source'] . '/' . $item)) {
          $files[] = $item;
        }
      }
    }
    return $files;
  }
}

/* Client code */
$log = config::getInstance('smbjorklund.no');
$log->setConfig('source', '/Users/steinmb/tcplog');
$log->send();
