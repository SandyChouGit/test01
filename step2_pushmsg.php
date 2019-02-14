<?php
    $json_str = file_get_contents('php://input'); //接收request的body
    $json_obj = json_decode($json_str); //轉成json格式
  
    $myfile = fopen("log_step2.txt", "w+") or die("Unable to open file!"); //設定一個log.txt來印訊息
    //fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  
    $sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
    $sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
  
    $response = array (
        "to" => $sender_userid,
        "messages" => array (
            array (
                "type" => "text",
                "text" => "Hello. You say...". $sender_txt
            )
        )
    );
  
    fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
    $header[] = "Content-Type: application/json";
    $header[] = "Authorization: Bearer m8bKf5cqedDaS2NNPET5aitH6WHJckE0uKCJ+y8wby3BJkxXzdYiQZ3RS4qjLS5KiNA51Ihb9hHypT9a1ZznEr7K72ZJhXUDGIZVwcwJ8don6PLuFsFRPnlYoBwC8WrwW9/ba/DBLRwbMamXrYrCtAdB04t89/1O/w1cDnyilFU=";
    $ch = curl_init("https://api.line.me/v2/bot/message/push");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
    $result = curl_exec($ch);
    curl_close($ch);
?>