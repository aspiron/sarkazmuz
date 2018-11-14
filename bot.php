<?php
header('Content-type: text/plain; charset=utf-8');
date_default_timezone_set('Asia/Tashkent');
mb_internal_encoding('UTF-8');
require_once 'Framework.php';
require_once 'Keyboard.php';
require_once 'UserData.php';
require_once 'functions.php';
require_once 'config.php';
require_once 'vendor/autoload.php';
use tasks\Framework;
use tasks\Keyboard;
use tasks\UserData;

define('MY_DATE', 'Y-m-d H:i:s');

$lstr = array_map('mb_strtolower', $str);
$aspiron = 00000000; //telegram id


$bot = new Framework(Config::token);


$wh = $bot->getInput();
//$bot->sendMessage($aspiron, '<pre>' . json_encode($wh, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '/</pre>', ['parse_mode' => 'HTML']);
//if you uncomment above you may see the logs

if (isset($wh->message)) {
    $type = $wh->message->chat->type;
    $chat_id = $wh->message->chat->id;
    if ($type == 'private') {
        $firstname = $wh->message->from->first_name;
        $user = new UserData($chat_id);
        $event = $user->getEvent();
        if (isset($wh->message->text)) {
            $text = $wh->message->text;
            $ltext = mb_strtolower($text);
            if (($data = startCommand('start', $ltext . ' ')) !== false) {

                $bot->sendMessage($chat_id, "<b>Helloooo, " . clearHtml($firstname) . "!</b>\nSend me message you want to stamp, like\n/img bla bla bla", ['parse_mode' => 'HTML']);

            }

            elseif ($ltext == '/otmen') {
                $keyboard = new Keyboard();
                $bot->sendMessage($chat_id, 'Главное меню', ['reply_markup' => $keyboard->getCl()]);
            }


            elseif (($data = startCommand('img', $text . ' ')) !== false) {

                $bot->sendMessage($chat_id, $data."\n/txt ga ozgratirudim");
            }

            elseif (($data = startCommand('txt', $text . ' ')) !== false) {
                $num = substr_count($data, "\n" );
                // Create image
                $image = new \NMC\ImageWithText\Image(dirname(__FILE__) . '/source2.png');
                //     $text1 = new \NMC\ImageWithText\Text( $data, $num, 65);
                $text1 = new \NMC\ImageWithText\Text( $data, 7, 100);
                $text1->align = 'left';
                $text1->color = '000000';
                $text1->font = dirname(__FILE__) . '/Ubuntu-Medium.ttf';
                $text1->lineHeight = 60;
                $text1->size = 13;
                $text1->startX = 20;
                $text1->startY = 0;
                $image->addText($text1);

                // Add another styled text to image
                $text2 = new \NMC\ImageWithText\Text('t.me/sarkazm_uz', 1, 30);
                $text2->align = 'right';
                $text2->color = '000000';
                $text2->font = dirname(__FILE__) . '/Ubuntu-Medium.ttf';
                $text2->lineHeight = 20;
                $text2->size = 14;
                $text2->startX = 20;
                $text2->startY = 240;
                $image->addText($text2);

                $time = date(MY_DATE);
                // Render image
                $image->render(dirname(__FILE__).'/img/'.$time.'.jpg');
                $bot->sendPhoto($chat_id, "https://zehn.uz/bots/sarkazm/img/$time.jpg");
            }


            //  elseif ($event) {
            //   }

            elseif ($ltext == '/admin')
            {
                $bot->sendMessage($chat_id, "Admin: @aspiron");
            }
            else $bot->sendMessage($chat_id, $ltext);
        }

        $user->close();
    }


}
