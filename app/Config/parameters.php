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
      'costPerKmCampus' => '2.15',
      'costPerKmOutsourced' => '3.40',
    ),
    'System' =>
    array (
      'allowed_actions' =>
      array (
        0 => 'AclExtras',
        1 => 'login',
        2 => 'logout',
        3 => 'set_language',
        4 => 'reset_password',
        5 => 'notify_upcoming_visits',
        6 => 'made_visits',
        7 => 'notify_pending_report',
      ),
      'dirReportFiles' => 'files\\reports',
      'notifyPendingReport' => '3',
      'notifyUpcomingVisits' => '3'
    ),
  ),
);
