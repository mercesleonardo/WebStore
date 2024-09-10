<?php

declare(strict_types = 1);

use Core\Database\Connector;
use Core\Session\Session;
use Core\Validation\Validator;

/** @var Session $session */
$session = container(Session::class);

$validator = new Validator([
    'name'    => ['required', 'min:3', 'max:100'],
    'email'   => ['required', 'email', 'max:100'],
    'source'  => ['required'],
    'message' => ['required', 'max:255'],
], $_POST);

if ($validator->fails()) {
    $session->withErrors($validator->getErrors())->withInput($_POST);

    header('Location: /contact');
    exit;
}

/** @var Connector $db */
$db = container(Connector::class);

$id = $db
    ->query('INSERT INTO messages (name, email, source, message) VALUES (:name, :email, :source, :message)', $_POST)
    ->insert();

$type = 'success';
$message = 'Sua mensagem foi enviada com sucesso!';

if (!$id) {
    $type = 'danger';
    $message = 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.';
}

$session->flash($type, $message);

header('Location: /contact');