<?php

namespace tasks;

class Framework
{
    
    public $token;
    public $urlBase  = 'https://api.telegram.org/bot';
    public $url;
    protected $handlers = [];
    
    public function __construct($t){
        $this->token = $t;
        $this->url = $this->urlBase . $t . '/';
    }

    public function getQuestion($method, array $params=null){
        $myCurl = curl_init();
        curl_setopt_array($myCurl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $this->url.$method,
        ));
        if($params){
            option:curl_setopt_array($myCurl, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($params)
            ));
        }
        $data = curl_exec($myCurl);
        curl_close($myCurl);
        return $data;
    }
    

    public function getInput(){
        return json_decode(file_get_contents('php://input'));
    }

    public function getMe(){
        return $this->getQuestion('getMe');
    }

    /**
     * @param $id
     * @param $text
     * @param array $params
     * @return mixed
     */
    public function sendMessage($id, $text, $params=[]){
        return $this->getQuestion('sendMessage', array_merge($params,[
            'chat_id'=>$id,
            'text' => $text,
        ]));
    }
    public function leaveChat($id){
        return $this->getQuestion('leaveChat', [
            'chat_id'=>$id
        ]);
    }
    public function getPrivateLink($id){
        return $this->getQuestion('exportChatInviteLink', ['chat_id'=>$id]);
    }
    public function getChatMembersCount($id){
        return $this->getQuestion('getChatMembersCount', ['chat_id'=>$id]);
    }
    public function getChat($id, $params=[]){
        return $this->getQuestion('getChat', array_merge([
            'chat_id'=>$id,
        ],$params));
    }
    public function sendChatAction($id, $action){
        return $this->getQuestion('sendChatAction', [
            'chat_id' => $id,
            'action' => $action,
        ]);
    }
    public function deleteMessage($id, $msg_id){
        return $this->getQuestion('deleteMessage', [
           'chat_id' => $id,
           'message_id' => $msg_id,
        ]);
    }
    public function editMessage($id, $text, $msg_id, $params = []){
        return $this->getQuestion('editMessageText', array_merge([
            'chat_id'=>$id,
            'text' => $text,
            'message_id'=>$msg_id
        ], $params));
    }
    public function answerCallbackQuery($id, $text = '', $show_alert = 'false', $params = []){
        return $this->getQuestion('answerCallbackQuery', array_merge([
            'callback_query_id'=>$id,
            'text' => $text,
            'show_alert' => $show_alert,
        ], $params));
    }
    public function sendPhoto($chat_id, $photo, $caption = '', $params = []){
        return $this->getQuestion('sendPhoto', array_merge([
            'chat_id'=>$chat_id,
            'photo' => $photo,
            'caption'=>$caption
        ], $params));
    }
    
     public function sendLocation($chat_id, $latitude,$longitude, $params = []){
        return $this->getQuestion('sendLocation', array_merge([
            'chat_id'=>$chat_id,
            'latitude' => $latitude,
            'longitude'=>$longitude
        ], $params));
    }
    public function editMessageReplyMarkup($chat_id, $msg_id, $reply_markup = "{}", $params = []){
        return $this->getQuestion('editMessageReplyMarkup', array_merge([
            'chat_id'=>$chat_id,
            'message_id'=>$msg_id,
            'reply_markup'=>$reply_markup
        ], $params));
    }
}

