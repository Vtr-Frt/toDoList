<?php

require_once __DIR__ . '/config.php';


function db($useDbName = true): PDO {
  static $pdo = [];
  $key = $useDbName ? 'withdb' : 'nodb';
  if (isset($pdo[$key])) return $pdo[$key];

  $dsn = 'mysql:host=' . DB_HOST . ';charset=' . DB_CHARSET;
  if ($useDbName) {
    $dsn .= ';dbname=' . DB_NAME;
  }

  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ];

  $pdo[$key] = new PDO($dsn, DB_USER, DB_PASS, $options);
  return $pdo[$key];
}
