<?php
/**
*-------------------------------------------------------------------------------
* Project Name::VK Crawler
* @filename mcUpdateController.php
*
* @author Alexander Volosenkov
* @copyright monochromatic.ru
*-------------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl;
use Mail;
use DB;

use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Client as Client;
use Fabiang\Xmpp\Protocol\Message as Message;

use \App\Models\mcPosts as mcPost;
use \App\Models\mcComunities as mcComunities;
use \App\Models\mcKeywords as mcKeywords;
use \App\Models\mcSettings as mcSettings;
use \App\Models\mcProposals as mcProposal;
use \App\Models\mcUsers as mcUser;

class mcUpdateController extends mcBaseController
{
    /** @var \App\Models\mcSettings $settings */
    //private $settings;
    private $useragent = array(
          'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0'
    );

  /**
  *-----------------------------------------------------------------------------
  * Get comunities data from vk by user id
  *
  * @param integer $user_id
  *
  * @return mixed $data
  *-----------------------------------------------------------------------------
  */
  private function get_comunities_data( $user_id )
  {
    $data = array();

    /** Get user's communities list */
    $comunities = mcUser::find( $user_id )->comunities;

    /** Get personal user settings */
    $settings = mcUser::find( $user_id )->settings;

    foreach ( $comunities as $key => $comunity )
    {
      /** Clean up community url */
      $comunity->url = str_replace( 'https://vk.com/', '', $comunity->url );

      /** Get community data from vk */
      $content = Curl::to( 'http://api.vk.com/method/wall.get' )
                  ->withData([ 'domain' => $comunity->url, 'v' => '5.52', 'count' => $settings->scan_depth ] )
                  ->withOption( 'USERAGENT', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0' )
                  ->get();

      $content = json_decode( $content );

      /** Check for errors */
      if ( !isset( $content ) || isset( $content->error ) )
        continue;

      foreach( $content->response->items as $item )
      {
        if ( !isset( $item->is_pinned ) )
        {
          $item->owner_name = $comunity->name;
          $item->comunity_id = $comunity->id;
          array_push( $data, $item );
        }
      }

      usleep( rand( 20000, 100000 ) );
    }

    return $data;
  }

  /**
  *-----------------------------------------------------------------------------
  *
  * @param integer $user_id
  * @param mcPost $data
  *-----------------------------------------------------------------------------
  */
  private function process_comunities_data( &$data, $user_id )
  {
    /** Get user's keywords list */
    $keywords = mcUser::find( $user_id )->keywords;

    foreach( $data as $key => $item )
    {
      /** Check, if post already exists */
      $post = mcPost::where( 'user_id', $user_id )->where( 'vk_id', '=', $item->id )->first();

      if ( $post )
        continue;

      /** Search keywords in entire data */
      if ( $this->analyse_data( $item, $keywords ) == false )
      {
        /** Unset element if keyword not found */
        unset( $data[ $key ] );

        /** Process next element */
        continue;
      }

      /** Send message to user's xmpp messenger */
      //$this->send_xmpp_message( 'VK Crawler::Привет::Новое объявление' . PHP_EOL . $item->owner_name . PHP_EOL . $item->text  );

      $item->text = $this->format_html( $item->text );

      $item->user_id = $user_id;
      $this->create_post_from_comunity_data( $item );

    }

  }

  /**
  *-----------------------------------------------------------------------------
  * Format HTML from entire text
  *
  * @param string $text
  *
  * @return string $text
  *-----------------------------------------------------------------------------
  */
  private function format_html( $text )
  {
    //replace http://vk.com/id12356 на кликабельную ссылку
    $text = preg_replace( '/(http\S*)/', '<br><a href=$1>$1</a>' , $text );

    //replace [id123456|имя] на ссылку на профиль
    $text = preg_replace( '/\[(id[\d]*)\|(\S.*)\]/', '<a target="_blank" href="https://vk.com/$1">$2</a>', $text );

    $text = str_replace(array( "\r\n", "\r", "\n" ), "<br />", $text );

    return $text;
  }

  /**
  *-----------------------------------------------------------------------------
  *
  * @param vk_response $data
  *
  *-----------------------------------------------------------------------------
  */
  private function create_post_from_comunity_data( $data )
  {
    $post = new mcPost();
    $post->vk_id = $data->id;
    $post->owner_id = $data->owner_id;
    $post->from_id = $data->from_id;
    $post->signer_id = isset( $data->signer_id ) ? $data->signer_id : false;
    $post->text = $data->text;
    $post->date = $data->date;
    $post->owner_name = $data->owner_name;
    $post->user_id = $data->user_id;

    print_r( $post );
    //$post->save();
  }

  /**
  *-----------------------------------------------------------------------------
  *
  *
  *
  *-----------------------------------------------------------------------------
  */
    public function getData( )
    {
        $comunities = mcUser::find( $this->user->id )->comunities;
        $keywords = mcUser::find( $this->user->id )->keywords;

        $data = array();

        /** Перебираем все сообщества */
      /*  foreach ( $comunities as $key => $comunity )
        {
            $comunity->url = str_replace( 'https://vk.com/', '', $comunity->url );
            $content = Curl::to('https://api.vk.com/method/wall.get' )
                        ->withData([ 'domain' => $comunity->url, 'v' => '5.52', 'count' => $this->settings->scan_depth ] )
                        ->withOption( 'USERAGENT', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0' )
                        ->get();

            $content = json_decode( $content );
            if ( !isset( $content ) || isset( $content->error ) )
                continue;

            foreach( $content->response->items as $item )
            {
                if ( !isset( $item->is_pinned ) )
                {
                    $item->owner_name = $comunity->name;
                    $item->comunity_id = $comunity->id;
                    array_push( $data, $item );
                }
            }

            usleep( rand( 500000, 2000000 ) );
        }
*/
      $data = $this->get_comunities_data( $this->user->id );
      $this->process_comunities_data( $data, $this->user->id );

exit;
        $posts = array();
        foreach( $data as $item )
        {
            $post = mcPost::where( 'user_id', $this->user->id )->where( 'vk_id', '=', $item->id )->first();

            /** Пост уже обработали, он находится в базе, пропускаем его */
            if ( $post )
                continue;

            if ( $this->analyse_data( $item, $keywords ) == false )
                continue;

            /** Отправляем сообщение в мессенджер */
          //  $this->send_xmpp_message( 'VK Crawler::Привет::Новое объявление' . PHP_EOL . $item->owner_name . PHP_EOL . $item->text  );

          /*  if( $item->owner_id < 0 && !isset( $item->signer_id ) )
            {
                //пытаемся найти в тексте ссылку на автора
                $c = preg_match_all( '/https?:\/\/vk.com\/(?!wall|topic)\S+/', $item->text , $matches );
                if( $c == 1 )
                {
                    $domain = preg_replace( '/(https:\/\/vk.com\/)/', '', $matches[0][0] );
                    $item->signer_id = $this->get_user_id_by_domain( $domain );
                }
            }
            */
            $item->text = str_replace(array( "\r\n", "\r", "\n" ), "<br />", $item->text );

            /** добавляем перенос строки перед элементом нумерованного списка */
            //$item->text = preg_replace( '/(\d\.)[^\d]/', '<br>$1', $item->text );

            //добавляем перенос строки перед хэш тэгом
            //$item->text = preg_replace( '/(#\S*)/', '<br>$1', $item->text );

            //replace http://vk.com/id12356 на кликабельную ссылку
            $item->text = preg_replace( '/(http\S*)/', '<br><a href=$1>$1</a>' , $item->text );

            //replace [id123456|имя] на ссылку на профиль
            $item->text = preg_replace( '/\[(id[\d]*)\|(\S.*)\]/', '<a target="_blank" href="https://vk.com/$1">$2</a>', $item->text );

            //print_r( $item->text );
            echo $item->text;
            exit;


/*
            $post_type = $item->post_type;
            $comments = $item->comments;
*/
            $post = new mcPost();
            $post->vk_id = $item->id;
            $post->owner_id = $item->owner_id;
            $post->from_id = $item->from_id;
            $post->signer_id = isset( $item->signer_id ) ? $item->signer_id : false;
            $post->text = $item->text;
            $post->date = $item->date;
            $post->owner_name = $item->owner_name;
            $post->user_id = $this->user->id;

            //отправляем персональные сообщения
            /*
            if( $this->settings->send_proposal )
            {
                $sent = $this->sendMessageToPostOwner( $post );

                if ( isset( $sent ) )
                    $post->sent = true;
            }
            */

            $post->save();
            array_push( $posts, $post );

            /** Увеличиваем счетчик эффективности на 1 */
            //mcComunities::find( $item->comunity_id )->increment('efficiency');
            mcUser::find( $this->user->id )->comunities()->where( 'id', $item->comunity_id )->where( 'owner_id', $this->user->id )->increment( 'efficiency' );

        }

        //отправляем email администратору со всей информацией
        $this->sendMail( $posts );

        return redirect()->route( 'home' )->with( 'msg', 'Обновлено' );
    }

  /**
  * ----------------------------------------------------------------------------
  * Ищем ключевые слова в массиве элементов
  *
  * @param mixed $item
  * @param \App\Models\mcKeywords array $keywords
  * @see \App\Models\mcKeywords for $keywords
  *
  * @return bool
  *-----------------------------------------------------------------------------
  */
  private function analyse_data( &$item, $keywords )
  {
    setlocale ( LC_ALL, 'ru_RU' );

    foreach( $keywords as $word )
    {
      $pattern = '/\s' . $word->keyword . '\s/i';

      /** Search pattern in entire text */
      if( preg_match( $pattern, $item->text ) )
      {
        /** Bold searched pattern */
        $item->text = preg_replace( $pattern, '<b> ' . $word->keyword . ' </b>', $item->text );

        /** Increase keyword efficiency by one */
        $word->increment( 'efficiency' );

        return true;
      }
    }
    return false;
  }

  /**
  *-------------------------------------------------------------------------------
  *
  * @var string $domain Доменное имя пользователя vk
  *
  * @return integer|0 $id Идентификатор пользователя
  *-------------------------------------------------------------------------------
  */
  private function get_user_id_by_domain( $domain )
  {
    $content = Curl::to('https://api.vk.com/method/users.get' )
                ->withData([ 'user_ids' => $domain, 'v' => '5.52' ] )
                ->withOption( 'USERAGENT', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7' )
                ->get();

    $content = json_decode( $content );

    if ( !isset( $content ) || isset( $content->error ) )
      return 0;

    return $content->response[0]->id;
  }
/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getSendMessage( Request $request, $id )
    {
        $sent = $this->sendMessageToPostOwner( null, $id );
        $msg = isset( $sent ) ? "Сообщение отправлено" : 'Ошибка при отправке сообщения';
        return redirect()->route( 'home' )->with( 'msg', $msg );
    }

    /**
    *--------------------------------------------------------------------------
    * Отправляем персональное сообщение пользователю ВК
    *
    * @var vk_post $post
    *
    * @var int|null $user_id
    *
    * @return boolean
    *--------------------------------------------------------------------------
    */
    private function sendMessageToPostOwner( $post, $user_id = null )
    {
        if ( !isset( $this->settings->access_token ) && !$this->settings->send_proposal )
            return false;

        if( isset( $post->signer_id ) && !isset( $user_id ) )
          $id = $post->signer_id;

        else if( isset( $post) && $post->owner_id > 0 && !isset( $user_id ) )
          $id = $post->owner_id;

        else if( isset( $user_id ) )
          $id = $user_id;

        else
        return false;


        $message = mcProposal::where( 'owner_id', $this->user->id )->get()->random(1);
        //$message = mcUser::find( $this->user->id )->proposals()->random(1);

        if ( !$message )
            return false;

        $response = Curl::to( 'https://api.vk.com/method/messages.send' )
                ->withData(['user_id' => $id, 'message' => $message->text, 'v' => '5.52', 'access_token' => $this->settings->access_token ])
                ->post();

        $response = json_decode( $response );

        if ( isset( $response->error ) )
        {
            return false;
        }

        return true;
    }

    /**
    *-------------------------------------------------------------------------------
    * Send email with items information to administrator
    *
    * @var $items Items list
    * @todo вынести в админские настройки адрес отправителя
    *-------------------------------------------------------------------------------
    */
    public function sendMail( $items )
    {
      if ( $this->settings->admin_email )
      {
        Mail::queue( 'emails.welcome', ['items' => $items], function( \Illuminate\Mail\Message $message )
        {
          $message->to( $this->settings->admin_email, 'Admin' );
          $message->subject( 'Новые сообщения' );
          $message->from( 'admin@promo.monochromatic.ru', 'VK Crawler' );
        });
      }
    }

    /**
    *---------------------------------------------------------------------------
    *
    *
    *
    *---------------------------------------------------------------------------
    */
    private function send_xmpp_message( $text )
    {

        //$settings = mcSettings::firstOrFail();

        if ( !$this->settings->xmpp )
          return;

        $options = new Options( 'tcp://xmpp.ru:5222' );
        $options->setUsername( 'vk_crawler' )
        ->setPassword( 'owi78gip' );

        $client = new Client( $options );

        // optional connect manually
        $client->connect();

        if ( $this->settings->xmpp )
        {
            $message = new Message;
            $message->setMessage( $text )
            ->setTo( $this->settings->xmpp );
            $client->send( $message );
        }

        if( $this->settings->xmpp2 )
        {
            $message = new Message;
            $message->setMessage( $text )
            ->setTo( $this->settings->xmpp2 );
            $client->send( $message );
        }

        if( $this->settings->xmpp3 )
        {
            $message = new Message;
            $message->setMessage( $text )
            ->setTo( $this->settings->xmpp3 );
            $client->send( $message );
        }

        $client->disconnect();

    }

}
