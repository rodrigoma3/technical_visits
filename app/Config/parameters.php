<?php
$config = array (
  'Parameter' =>
  array (
    'Email' =>
    array (
      'host' => 'smtp.gmail.com',
      'port' => '587',
      'tls' => '0',
      'ssl' => 'ssl://',
      'timeout' => '30',
      'username' => 'rodrigo.ma3@gmail.com',
      'password' => 'lalala',
      'fromName' => 'Rodrigo de Almeida',
      'fromEmail' => 'rodrigo.ma3@gmail.com',
      'replyTo' => '',
    ),
    'Password' =>
    array (
      'size' => '8',
      'uppercase' => '1',
      'number' => '1',
      'symbol' => '0',
    ),
    'Transport' =>
    array (
      'cost_per_km' => '4.99',
    ),
    'System' =>
    array (
      'allowed_actions' =>
      array(
        'AclExtras',
        'login',
        'logout',
        'set_language',
      ),
    ),
  ),
);
