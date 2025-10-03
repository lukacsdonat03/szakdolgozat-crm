<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=crm',
    'username' => 'root',
    'password' => '',
    'attributes' => [PDO::ATTR_CASE => PDO::CASE_LOWER], // MYSQL 8+
    'charset' => 'utf8mb4',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 86400, // 1 nap
    'schemaCache' => 'cache',
];