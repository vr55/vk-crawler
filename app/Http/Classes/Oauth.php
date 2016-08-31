<?php
namespace App\Http\Classes;


class OAuth
{
	protected $vkontakte = array(
		'client_id' 	=> 5357974,
		'secret' 		=> 'SHQKDzMf5ZMVfgfTo4u5',
		'redirect' 		=> 'http://www.concrete.monochromatic.ru/index.php/oauth_callback/229',
		'url' 			=> 'https://oauth.vk.com/authorize',
		'token_url' 	=> 'https://oauth.vk.com/access_token',
		'api_url' 		=> 'https://api.vk.com/method',
		'user_id' 		=> '',
		'token' 		=> '',
		'email' 		=> ''
	);

	protected $facebook = array(
		'client_id' 	=> '1650708478527797',
		'secret' 		=> 'cbf230840794e968218318569d55ea73',
		'redirect' 		=> 'http://www.concrete.monochromatic.ru/index.php/oauth_callback/229/',
		'url' 			=> 'https://www.facebook.com/dialog/oauth',
		'token_url' 	=> 'https://graph.facebook.com/oauth/access_token',
		'api_url' 		=> 'https://graph.facebook.com/me',
		'user_id' 		=> '',
		'token' 		=> '',
		'email' 		=> ''
	);

//-------------------------------------------------------------------------------------------------------
	public function GetAuthLink( $network )
	{
		if ( $network == 'vkontakte' )
		{
			$params = array(
				'client_id'		=> $this->vkontakte['client_id'],
				'redirect_uri'  => $this->vkontakte['redirect'],
				'response_type' => 'code',
				'display'		=> 'popup',
				'scope'         => 'email',
				'state'			=> 'vkontakte'

			);
			
			return $this->vkontakte['url'] . '?' . urldecode( http_build_query( $params ) );
		}
		
		else if ( $network == 'facebook' )
		{
			$params = array(
				'client_id'		=> $this->facebook['client_id'],
				'redirect_uri'  => $this->facebook['redirect'],
				'response_type' => 'code',
				'scope'         => 'email',
				'state'			=> 'facebook'
			);
			
			return $this->facebook['url'] . '?' . urldecode( http_build_query( $params ) );
		}

	}
//--------------------------------------------------------------------------------------------------------
	function GetToken( $network, $code )
	{
		$ku = curl_init();

		if ( $network === 'vkontakte' )
		{
			$query = "client_id=" . $this->vkontakte['client_id']
				. "&redirect_uri=" . urldecode( $this->vkontakte['redirect'] )
				. "&client_secret=" . $this->vkontakte['secret']
				. "&code=" . $code;

			curl_setopt( $ku, CURLOPT_URL, $this->vkontakte['token_url'] . "?" . $query );
			curl_setopt( $ku, CURLOPT_RETURNTRANSFER, TRUE );

			$result = curl_exec( $ku );

			if( !$result )
				exit( curl_error( $ku ) );

			curl_close( $ku );
			$result = json_decode( $result );
			//print_r($result);exit;
			$this->vkontakte['user_id'] = $result->user_id;
			$this->vkontakte['token'] = $result->access_token;
			$this->vkontakte['email'] = $result->email;

			if( $result->access_token )
			{
				return $result->access_token;
			}

		}

		if ( $network === 'facebook' )
		{
			$query = "client_id=" . $this->facebook['client_id']
				. "&redirect_uri=" . urldecode( $this->facebook['redirect']  )
				. "&client_secret=" . $this->facebook['secret']
				. "&code=" . $code;

			curl_setopt( $ku, CURLOPT_URL, $this->facebook['token_url']  . "?" . $query );
			curl_setopt( $ku, CURLOPT_RETURNTRANSFER, TRUE );
			$result = curl_exec( $ku );

			if( !$result )
				exit( curl_error( $ku ) );

			curl_close( $ku );
			parse_str( $result, $token );

			if( $token['access_token'] )
			{
				$this->facebook['token'] = $token['access_token'];
				return $token['access_token'];
			}

		}

	}

//--------------------------------------------------------------------------------------------------------------
	function GetUserInfo( $network, $token )
	{
		if ( $network === 'vkontakte' )
		{
			//print_r( $this->vkontakte );
			$ku = curl_init();
			$query = 'user_id=' . $this->vkontakte['user_id']
				. '&fields=sex,bdate,home_town'
				. '&access_token=' . $token;
			curl_setopt( $ku, CURLOPT_URL, $this->vkontakte['api_url'] . "/users.get?" . $query );
			curl_setopt( $ku, CURLOPT_RETURNTRANSFER, TRUE );

			$result = curl_exec( $ku );

			if( !$result )
				exit( curl_error( $ku ) );

			curl_close( $ku );

			$result = json_decode( $result, true );

			if ( empty( $result['response'][0] ) )
            	return false;

			$result = $result['response'][0];

			//приводим результат к формату, аналогичному фейсбук
			// фейсбук ( $u_info =  [id] => 210698999273237 [first_name] => Alexander [last_name] => Volosenkov [birthday] => 12/17/1980 [email] => vr5@bk.ru [gender] => male )
			// вк -  [uid] => 182920738 [first_name] => Александр [last_name] => Волосенков [sex] => 2 [bdate] => 17.12.1980 [home_town] => Смоленск
			$result['id'] = $result['uid'];
			$result['email'] = $this->vkontakte['email'];
			$result['gender'] = ( $result['sex'] == 2 ) ? 'male' : 'female';
			$bdate = explode( '.', $result['bdate'] );
			$result['birthday'] = $bdate[1] . "/" . $bdate[0] . "/" . $bdate[2];

			unset( $result['uid'] );
			unset( $result['sex'] );
			unset( $result['bdate'] );
			return( $result );

		}

		if( $network === 'facebook' )
		{
			$params = array( 'access_token' => $token,
			   'fields' => 'id,first_name,last_name,birthday,email,gender,cover'
			);
			$userInfo = json_decode( file_get_contents( $this->facebook['api_url'] . '?' . urldecode( http_build_query( $params ) ) ), true );

			return $userInfo;

		}

	}
}
