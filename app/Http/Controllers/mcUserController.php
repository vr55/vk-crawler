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
use App\Http\Controllers\mcOAuth as mcOAuth;

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
  
          // Add user with id=1 to administrators group
          if ( $user->id == 1 && !Sentinel::inRole( 'administrators' ) )
          {
            $role = Sentinel::findRoleByName( 'Administrators' );
            $role->users()->attach( $user );
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

  /**---------------------------------------------------------------------------
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
   * ---------------------------------------------------------------------------
   * Register new user
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

      /** Check for invite code */
      $invite = mcInvites::where( 'code', $request->input( 'uInviteCode' ) )->where( 'used', false )->get();

      if ( count( $invite ) == 0 )
      {
        return redirect()->route( 'signup' )->with( 'msg', 'Код приглашения не найден или уже использован' );
      }

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
   * -------------------------------------------------------------------------
   * Callback function for OAuth
   *
   * @param Illuminate\Http\Request $request
   *
   * -------------------------------------------------------------------------
   */
  	public function getOAuthCallback( Request $request )
  	{
  		$this->validate( $request, [
				'code' => 'required',
				'state' => 'required'
			]);

			$oauth = new mcOAuth();

      // Get oauth toke
      $token = $oauth->GetToken( $request->input( 'state' ), $request->input( 'code' ) );
      
      // Get user info
      $u_info = $oauth->GetUserInfo( $request->input( 'state' ), $token );

			if ( !isset( $u_info ) || !isset( $token ) )
				return redirect()->route( 'signin' )->with( 'msg', 'Ошибка авторизации' );


			$credentials = [
			    'email' => $u_info['email'],
				];


			// Check, if user exists
			if ( $user = Sentinel::findByCredentials( $credentials ) )
			{
				Sentinel::loginAndRemember( $user );
				return redirect()->route( 'home' );
			}

      // If not, create new user
      else
      {
        // Generate random password
        $password = Math.random().toString(36).slice(2, 2 + Math.max(1, Math.min(n, 10)) );

        // Prepare credentials
        $credentials = [
          'email'    => $u_info['email'],
          'password' => $password
          ];

        // Create new user
        $user = Sentinel::registerAndActivate( $credentials );

        // Assign user's role
        $usersRole = Sentinel::findRoleByName( 'Users' );
        $usersRole->users()->attach( $user );

        // Login new user
        Sentinel::loginAndRemember( $user );

        // Send email to new user with his password
        Mail::send( 'email.password', [ 'password' => $password ], function($message) use($user)
        {
          $message->from( 'admin@vkcrawler.monochromatic.ru', 'vkcrawler' );
          $message->to( $user->email );
          $message->subject( 'VK Crawler::регистрация' );
        });

        return redirect()->route( 'home' )->with( 'msg', 'Добро пожаловать!' );
      }

  	}

  /**
   *--------------------------------------------------------------------------
   * View current user settings
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
    
      // Check if user exists
      $user = Sentinel::findByCredentials( [ 'email' => $request->input( 'uEmail' ) ] );
    
      if ( !$user )
          return redirect()->route( 'reminder' )->withInput()->with( 'msg' , 'Пользователь не найден' );
    
      // Create reminder object
      $reminder = Reminder::exists( $user ) ?: Reminder::create( $user );
    
      Mail::send( 'emails.reminder', ['code' => $reminder->code, 'user_id' => $user->id], function($message) use($user)
      {
        $message->from( 'admin@vkcrawler.monochromatic.ru', 'VK Crawler' );
        $message->to( $user->email );
        $message->subject( 'VK Crawler::напоминание пароля' );
      });
    
      return redirect()->route( 'reminder' )->with( 'msg', 'На указанный вами email отправлены инструкции по сбросу пароля' );
    
    }

  /**
   * Выводим форму сброса пароля. В get-запросе должны присутствовать id-пользователя и код активации
   *
   * @param Request $request
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
           'uPassword' => 'required',
           'uPasswordConfirm' =>'same:uPassword',
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
   * ---------------------------------------------------------------------------
   * Get Invite Codes
   *
   * @return view new.invites
   * ---------------------------------------------------------------------------
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
