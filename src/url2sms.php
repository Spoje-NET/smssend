<?php

namespace SmsSend;

require_once '../vendor/autoload.php';

$contact = $_GET['contact'];
$message = $_GET['message'];

\Ease\Shared::init(['MODEM_PASSWORD'], file_exists('../.env') ? '../.env' : '');

if (empty($contact) || empty($message)) {
    echo json_encode(['status' => _('Contact or message is empty'), 'success' => false]);
    exit;
}

$sender = new Sms($contact);

$sender->setMessage($message);
$result = $sender->sendMessage();
echo json_encode($sender->sent ? ['status' => _('Message was sent') . ': ' . $result, 'success' => true,
            'message' => $message, 'number' => $sender->number] : ['status' => _('Message not sent') . ': ' . $result, 'success' => false,
            'message' => $message, 'number' => $sender->number]);
