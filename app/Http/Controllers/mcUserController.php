<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Sentinel;
use Reminder;
use Storage;
use DB;
use Validator;
use Mail;

//use App\Models\mcSettings as mcSettings;
use App\Models\mcUsers as mcUser;
use App\Models\mcInvites as mcInvites;

class mcUserController extends mcBaseController
{
    protected $users;
/**
 *------------------------------------------------------------------------------
 *
 *
 *
 *-------------------------------------------------------------------------------
 */
    public function __construct()
	{
		parent::__construct();

		$this->users = Sentinel::getUserRepository();

		//** создаем роли для пользователей */
		//$role = Sentinel::findRoleByName( 'Administrators' );

		if ( Sentinel::findRoleByName( 'Administrators' ) == null )
		{
			$role = Sentinel::getRoleRepository()->createModel()->create([
    				'name' => 'Administrators',
    				'slug' => 'administrators',
					]);

			$role->permissions = [
		        'user.create' => true,
		        'user.delete' => true,
		        'user.view'   => true,
		        'user.update' => true,
			];

			$role->save();
		}

		if ( Sentinel::findRoleByName( 'Users' ) == null )
		{
			$role = Sentinel::getRoleRepository()->createModel()->create([
    				'name' => 'Users',
    				'slug' => 'users',
					]);

			$role->permissions = [
		        "user.create" => false,
		        "user.delete" => false,
		        "user.view"   => true,
		        "user.update" => false,
			];

			$role->save();
		}

	}

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getLogin()
    {
        return view( 'login' );
    }

/**
 *--------------------------------------------------------------------------
 *
 *
 *
 *--------------------------------------------------------------------------
 */
    public function postLogin( Request $request )
    {
        $this->validate( $request, [
            'uName' => 'required|email|max:255',
            'uPassword' => 'required|max:64'
        ]);

    	$credentials = [
    		'email'    => $request->input( 'uName' ),
    		'password' => $request->input( 'uPassword' )
			];

		try
		{
			if ( Sentinel::authenticateAndRemember( $credentials ) )
			{
				$user = Sentinel::check();

//Пользователя с id=1 добавляем в администраторы
				if ( $user->id == 1 )
				{
					if ( !Sentinel::inRole( 'administrators' ) )
					{
						$role = Sentinel::findRoleByName( 'Administrators' );
						$role->users()->attach( $user );
					}
				}

                return redirect()->route('home')->with( 'msg', 'Добро пожаловать' );

			}

            return redirect()->back()->withInput()->with( 'msg', 'Неверное имя пользователя или пароль' );

		}

		catch ( \Cartalyst\Sentinel\Checkpoints\NotActivatedException $e )
		{
            return redirect()->back()->withInput()->withErrorMessage( 'User Not Activated.' );
        }

        catch ( \Cartalyst\Sentinel\Checkpoints\ThrottlingException $e )
        {
            return redirect()->back()->withInput()->withErrorMessage( $e->getMessage() );
        }

    	return view( 'home' );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getLogout( Request $request )
    {
        Sentinel::logout();
        return redirect()->route( 'index' );
    }

  /**
   * Регистрация пользователя
   *
   * @param Request $request
   *
   * @return redirect()
   *----------------------------------------------------------------------------
   */
    public function postRegister( Request $request )
    {
        $this->validate( $request, [
                'uName' => 'required|email|max:255|unique:users,email',
                'uPassword' => 'required',
                'uPasswordConfirm' =>'same:uPassword',
                'uInviteCode' => 'required'
        ]);

        /** Check invites code */
        $invite = mcInvites::where( 'code', $request->input( 'uInviteCode' ) )->where( 'used', false )->get();

        if ( count( $invite ) == 0 )
        {
          return redirect()->route( 'signup' )->with( 'msg', 'Код приглашения не найден или уже использован' );
        }

/*
        if (  $user = Sentinel::findByCredentials( [ 'email' => $request->input( 'uName' ) ] ) )
        {
            return redirect()->back()->withInput()->with( 'msg', 'Пользователь уже существует' );
        }
*/
        $credentials = [
        'email'    => $request->input( 'uName' ),
        'password' => $request->input( 'uPassword' ),
        ];

        if ( $user = Sentinel::registerAndActivate( $credentials ) )
        {
            /** Find the role using the role name */
            $usersRole = Sentinel::findRoleByName( 'Users' );

            /** Assign the role to the users */
            $usersRole->users()->attach( $user );

            /** Set invites */
            mcInvites::where( 'code', $request->input( 'uInviteCode' ) )
                      ->where( 'used', false )
                      ->update( ['invited_id' => $user->id, 'used' => true ] );

            /** Login user */
            Sentinel::login( $user );

            return redirect()->route( 'home' );

        }

    }

    /**
     *--------------------------------------------------------------------------
     *
     *
     *
     *--------------------------------------------------------------------------
     */
    public function getSettings()
    {
        return view( 'settings', [ 'settings' => $this->settings ] );
    }

    /**
    *---------------------------------------------------------------------------
    * Update user settings
    *
    * @see \App\Http\Controllers\BaseController for $this->settings
    *---------------------------------------------------------------------------
    */
    public function postSettings( Request $request )
    {
        $this->validate( $request, [
                'client_id'     => 'integer',
                'admin_email' => 'email'
        ]);

        $this->settings->update( $request->except( '_token' ) );

        return redirect()->route('settings.main')->with( 'msg', 'Сохранено' );
    }

/**
 * -----------------------------------------------------------------------------
 *  Функция напоминания пароля. Отсылает на указанный адрес код для сброса пароля
 *
 *  @var Request $request
 *
 *------------------------------------------------------------------------------
 */
    public function postReminder( Request $request )
    {
        $this->validate( $request, [
            'uEmail' => 'required|email|max:255'
        ]);

	    $user = Sentinel::findByCredentials( [ 'email' => $request->input( 'uEmail' ) ] );

        if ( !$user )
            return redirect()->route( 'reminder' )->withInput()->with( 'msg' , 'Пользователь не найден' );

        $reminder = Reminder::exists( $user ) ?: Reminder::create( $user );

        Mail::send( 'emails.reminder', ['code' => $reminder->code, 'user_id' => $this->user->id], function($message) use($user)
        {
          $message->from( 'vr5@bk.ru', 'VK Crawler' );
          $message->to( $user->email );
          $message->subject( 'VK Crawler::напоминание пароля' );
        });

        return redirect()->route( 'reminder' )->with( 'msg', 'На указанный вами email отправлены инструкции по сбросу пароля' );

    }

/**
 * Выводим форму сброса пароля. В get-запросе должны присутствовать id-пользователя и код активации
 *
 * @var Request $request
 *
 * return redirect( 'index' ) | view( 'new.reset' )
 */
    public function getReset( Request $request )
    {
        $validator = Validator::make( $request->all(), [ 'user_id' => 'required|integer', 'code' => 'required' ] );

        if ( $validator->fails() )
            return redirect()->route( 'index' );

        $user_id = $request->input( 'user_id' );
        $code = $request->input( 'code' );

        return view( 'new.reset', ['user_id' => $user_id, 'code' => $code] );
    }

/**
 * Получаем от пользователя новый пароль
 *
 *
 */
    public function postReset( Request $request )
    {
        $this->validate( $request, [
             'user_id' => 'required|integer',
             'code' => 'required',
             'uPassword' => 'required|confirmed'
         ] );

        $user = Sentinel::findById( $request->input( 'user_id' ) );

        if ( !$user )
            return redirect()->route( 'password.reminder' )->withInput()->with( 'msg', 'Пользователь не найден' );

        if ( !Reminder::complete( $user, $request->input( 'code' ), $request->input( 'uPassword' ) ) )
        {
            return redirect()->route( 'reminder')->withInput()->with( 'msg', 'Неверный код авторизации. Попробуйте снова' );
        }

        Sentinel::loginAndRemember( $user );

        return redirect()->route( 'home' );
    }

/**
 * Get Invite Codes
 *
 */
    public function getInvites ()
    {
        $invites = mcUser::find( $this->user->id )->invites()->get( );

        $count = $invites->count();

        if ( $count < 10 )
        {
          for ( $i=$count; $i<10; $i++ )
          {
            $invite = new mcInvites();
            $invite->owner_id = $this->user->id;
            $invite->code = substr( sha1( rand()), 0, 12 );
            $invite->used = false;
            $invite->save();
          }
        }

        $invites = mcUser::find( $this->user->id )->invites()->get();

        return view( 'new.invites', [ 'invites' => $invites ] );

    }

}
