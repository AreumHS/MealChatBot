<?php
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if($verify_token === 'asdf'){    echo $challenge;    }

$input = json_decode(file_get_contents('php://input'), true);   // Get the Senders Graph ID
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];   // App Id
$message = $input['entry'][0]['messaging'][0]['message']['text'];   // App Message

$url = "https://graph.facebook.com/v2.6/me/messages?access_token=EAAf3RB3BKl4BAPV6XB8tRGnqRkNZByRSB3eBctwbncXHfw4G77MCoZCJP6RDTLmS8ZBGcF1TAQZBS43CQGUJlYqj8e1ZBNlCqmIkXXJ6UvP7vu18MoP9aAfpVLQ3kkgDf0rb9LucbPmlK3fkfMRAQMc4VrgGOUu3PKgLjpdOZC4AZDZD";

$ch = curl_init($url);


include "function/main.php";


$jsonData = '{

    "recipient":{
        "id":"' . $sender . '"
    }, 
    "message":{
        "text":"' . $message . '"
    }
}';

//$jsonData = fecebook_reply($sender , $message);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));


if(!empty($input['entry'][0]['messaging'][0]['message'])){    $result = curl_exec($ch);    }

?>