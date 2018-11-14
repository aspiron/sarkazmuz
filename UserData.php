<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.10.2017
 * Time: 16:03
 */

namespace tasks;
class UserData
{
    private $event = false;
    private $data = [];
    private $user_id;
    private $edited = false;
    private $filename;

    public function __construct($user_id){
        $this->user_id = $user_id;
        $this->filename = "data/users/".$this->user_id;
        if(file_exists($this->filename)){
            $content = json_decode(file_get_contents($this->filename), true);
            $this->event = isset($content['event']) ? $content['event'] : false;
            $this->data = isset($content['data']) ? $content['data'] : [];
            return;
        }
    }
    public function getEvent(){
        return $this->event;
    }
    public function getData(){
        return $this->data;
    }
    public function setEvent($event){
        $this->event = $event;
        $this->edited = true;
        return $this;
    }
    public function setData($data){
        $this->data = $data;
        $this->edited = true;
    }
    public function clearEvent(){
        $this->event = false;
        $this->data = [];
        $this->edited = true;
    }
    public function addData($key, $data){
        $this->data[$key] = $data;
        $this->edited = true;
        return $this;
    }
    public function close(){
        if($this->edited){
            file_put_contents($this->filename, json_encode(['event'=>$this->event, 'data'=>$this->data]));
        }
    }

}






















































