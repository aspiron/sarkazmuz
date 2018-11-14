<?php

namespace tasks;
class Keyboard{
    private $data_cb =[];
    private $data_cl =[];
    public function removeCl($selective = false){
        return json_encode([
            'remove_keyboard' => true,
            'selective' => $selective,
        ]);
    }
    public function sendCon(){
        return json_encode([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard'=>[[["text"=>'Отправить номер',
            'request_contact'=>true]]]
            ]);
    }
     public function sendLoc(){
        return json_encode([
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'keyboard'=>[[["text"=>'Отправить локацию',
            'request_location'=>true]]]
            ]);
    }
    
  
     public function classic(...$args){
        $arr = [];
        $i = 0;
        foreach ($args as $arg){
            foreach ($arg as $ar){
                $arr[$i][]=['text'=>$ar.''];
            }
            $i+=2;
        }
        $this->data_cl = array_merge($this->data_cl, $arr);
        return $this;
    }
       public function classic2(...$args){
        $arr = [];
        $i = 0;
        foreach ($args as $ar){
                $arr[$i][]=['text'=> (string)$ar];
            $i++;
        }
        $this->data_cl = array_merge($this->data_cl, $arr);
        return $this;
    }
  public function classic1(...$args){
     
        $this->data_cl = array_merge($this->data_cl, $args);
        return $this;
    }

    public function url($array){
        $this->data_cb[] = $this->replaceKeys($array);
        return $this;
    }

    public function callback($array){
        $this->data_cb[] = $this->replaceKeys($array, false);
        return $this;
    }
    public function getCb(){
        return json_encode(['inline_keyboard'=>$this->data_cb]);
    }
    public function getCl($params = []){
        return json_encode(array_merge(['keyboard'=>$this->data_cl, 'resize_keyboard'=>true], $params));
    }

    private function replaceKeys($array, $is=true){
        $arr = [];
        foreach ($array as $k=>$a){
            $arr[] = ['text'=>''.$a, $is ? 'url' : 'callback_data' =>''.$k];
            #$array[$k] = ['text'=>''.$a[0], $is ? 'url' : 'callback_data' =>''.$a[1]];
        }
        return $arr;
    }

}