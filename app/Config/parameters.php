<?php
$config = array (
  'Parameter' =>
  array (
    'Email' =>
    array (
      'host' => 'smtps.bol.com.br',
      'port' => '587',
      'tls' => '0',
      'ssl' => '',
      'timeout' => '30',
      'username' => 'technical.visits@bol.com.br',
      'password' => '1q2w3e4r',
      'fromName' => 'Technical Visits',
      'fromEmail' => 'technical.visits@bol.com.br',
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
      'cost_per_km_campus' => '4.99',
      'cost_per_km_outsourced' => '4.99',
    ),
    'System' =>
    array (
      'allowed_actions' =>
      array (
        0 => 'AclExtras',
        1 => 'login',
        2 => 'logout',
        3 => 'set_language',
      ),
      'dirReportFiles' => 'files'.DS.'reports',
    ),
  ),
);
