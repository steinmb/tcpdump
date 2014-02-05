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

  public function getConfig($key) {
    return $this->config[$key];
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
      foreach ($files as $key => $file) {
        print '/usr/bin/rsync -au ' . $this->getConfig('source') . '/' . $file . ' ' . $this->getConfig('user') . '@' . $this->target . ':' . $this->getConfig('target_dir') . "\n";
        $result = exec('/usr/bin/rsync -au ' . $this->getConfig('source') . '/' . $file . ' ' . $this->getConfig('user') . '@' . $this->target . ':' . $this->getConfig('target_dir'));
      }
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
$options = getopt('hu:t:s:d:');
if (!$options) {
  print "Usage: tcpdump -h \n";
  exit(1);
}

$help = 'Usage: tcdump -u <remote user name> -t <target server (domain name/IP)> -s <source directory> -d <target directory>' . "\n";
foreach ($options as $key => $value) {
  switch ($key) {
    case 'u':
      print "username $value\n";
      $user = $value;
    case 't':
      print "target system $value\n";
      $target = $value;
    case 's':
      print "Source $value\n";
      $source = $value;
    case 'd':
      print "Target dir $value\n";
      $target_dir = $value;
      break;
    case 'h':
      print $help;
      exit(1);
    default:
      print $help;
      exit(1);
  }
}

$log = config::getInstance($target);
$log->setConfig('user', $user);
$log->setConfig('source', $source);
$log->setConfig('target_dir', $target_dir);
$log->send();
