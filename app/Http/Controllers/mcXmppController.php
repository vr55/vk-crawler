<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Client as Client;
use Fabiang\Xmpp\Protocol\Message as Message;

//use App\Models\mcSettings as mcSettings;

class mcXmppController extends mcBaseController
{
    public function getSendMessage( Request $request )
    {
        //$settings = mcSettings::firstOrFail();

        if ( !$this->settings->xmpp )
            return redirect()->back()->with( 'msg', 'Ошибка! Вы не указали адрес jabber. Заполните хотя-бы одно поле и нажмите "Сохранить"' );

        $options = new Options( 'tcp://xmpp.ru:5222' );
        $options->setUsername( 'vk_crawler' )
        ->setPassword( 'owi78gip' );

        $client = new Client($options);

        // optional connect manually
        $client->connect();

        if ( $this->settings->xmpp )
        {
            $message = new Message;
            $message->setMessage( 'VK Crawler::Привет как дела))' )
            ->setTo( $this->settings->xmpp );
            $client->send( $message );
        }

        if( $this->settings->xmpp2 )
        {
            $message = new Message;
            $message->setMessage( 'VK Crawler::Привет как дела))' )
            ->setTo( $this->settings->xmpp2 );
            $client->send( $message );
        }

        if( $this->settings->xmpp3 )
        {
            $message = new Message;
            $message->setMessage( 'VK Crawler::Привет как дела))' )
            ->setTo( $this->settings->xmpp3 );
            $client->send( $message );
        }


        $client->disconnect();

        return redirect()->back()->with( 'msg', 'На месседжер администратора отправлено проверочное сообщение' );
    }
}
