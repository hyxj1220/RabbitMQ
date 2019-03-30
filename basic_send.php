<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// 第三参数设置 设置队列是否持久化
$channel->queue_declare('hello', false, true, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

// 在发送端才能获取到挤压的消息数，消费端无法获取队列挤压数【You have an active consumer and no backlog: all routed messages go directly to the consumer.】
$queue_info = $channel->queue_declare('hello', true);
var_dump($queue_info);;
$channel->close();
$connection->close();

?>