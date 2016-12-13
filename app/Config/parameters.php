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
      'password' => 'NjFlYzdmZmE1YjZjOGY1NGJmZjE0ZmVkZDI2ZTlkM2EwY2Q3YjhhZDcwY2M2MGQ2ZWQzYjc1NDI0Njk5ZGE2ZK7wLhNGK/mIWNOa85g8wjK5DiplPVwGNibGrjBQNKMI',
      'fromName' => 'Technical Visits',
      'fromEmail' => 'technical.visits@bol.com.br',
      'replyTo' => '',
    ),
    'Transport' => 
    array (
      'costPerKmCampus' => '1.15',
      'costPerKmOutsourced' => '5.3',
    ),
    'System' => 
    array (
      'allowed_actions' => 
      array (
        0 => 'AclExtras',
        1 => 'login',
        2 => 'logout',
        3 => 'set_language',
        4 => 'update_password',
        5 => 'notify_upcoming_visits',
        6 => 'made_visits',
        7 => 'notify_pending_report',
      ),
      'dirReportFiles' => 'files\\reports',
      'notifyPendingReport' => '3',
      'notifyUpcomingVisits' => '3',
      'updatePassword' => 'http://localhost/technical_visits/users/update_password',
    ),
  ),
);