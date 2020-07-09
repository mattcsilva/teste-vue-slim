<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require __DIR__ . '/../vendor/autoload.php';

$config['displayErrorDetails'] = false;
$config['addContentLengthHeader'] = false;

// Database
$config['db']['host']   = 'localhost';
$config['db']['user']   = 'root';
$config['db']['pass']   = '';
$config['db']['dbname'] = 'aplicacao';

// Instancia a aplicação
$app = new \Slim\App(['settings' => $config]);

// Cria container para inserir configurações personalizadas
$container = $app->getContainer();

// Configura logs da aplicação
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

// Configuração conexão padrão com PDO
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// Importa todas as rotas
require __DIR__ . '/../src/routes/vendedor.php';
require __DIR__ . '/../src/routes/venda.php';
require __DIR__ . '/../src/routes/mail.php';

$app->run();