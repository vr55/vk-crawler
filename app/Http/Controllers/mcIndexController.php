<?php
/**
 *
 *
 *
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl;

use App\Models\mcKeywords as mcKeywords;
use App\Models\mcComunities as mcComunities;
use App\Models\mcPosts as mcPosts;
use App\Models\mcSettings as mcSettings;
use App\Models\mcProposals as mcProposals;
use App\Models\mcUsers as mcUser;

class mcIndexController extends mcBaseController
{
/**
*-------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getIndex()
    {
        $posts = mcUser::find( $this->user->id )->posts()->orderBy( 'date', 'desc' )->paginate( 15 );
        return view( 'index', ['posts' => $posts] );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getKeywords()
    {
        $keywords = mcUser::find( $this->user->id )->keywords()->orderBy( 'id', 'desc' )->paginate(30);
        return view( 'keywords', ['keywords' => $keywords] );
    }

/**-----------------------------------------------------------------------------
 *
 * Save keyword to database
 *
 * @return redirect()
 *------------------------------------------------------------------------------
*/
    public function postKeywords( Request $request )
    {
        $this->validate( $request, [
            'keyword' => 'required'
        ]);

        $keyword = new mcKeywords();
        $keyword->keyword = $request->input( 'keyword' );
        $keyword->owner_id = $this->user->id;
        $keyword->save();

        return redirect()->route( 'keywords' );
    }

/**
  *
  *-----------------------------------------------------------------------------
  *
  *
  * @see /App/Http/Controllers/BaseController $this->user
  *-----------------------------------------------------------------------------
*/
    public function getDeleteKeyword( Request $request, $id )
    {
        $keyword = mcKeywords::where( 'id', $id )->where( 'owner_id', $this->user->id );

        if ( $keyword )
            $keyword->delete();

        return redirect()->route( 'keywords' )->with( 'msg', 'Удалено' );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getComunities()
    {
        //$comunities = mcComunities::paginate(15);
        $comunities = mcUser::find( $this->user->id )->comunities()->orderBy( 'id' )->paginate( 15 );
        return view( 'comunities', ['comunities' => $comunities] );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function postComunities( Request $request )
    {
        $this->validate( $request, [
                'url' => 'required|url'
                ]);
        //Вытаскиваем имя сообщества
        $name = str_replace( 'https://vk.com/', '', $request->input( 'url' ) );

        $content = Curl::to('https://api.vk.com/method/groups.getById' )
                    ->withData([ 'group_id' => $name, 'v' => '5.52' ] )
                    ->withOption('USERAGENT', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7' )
                    ->get();
        $content = json_decode( $content );

        if ( !isset( $content->error ) )
        {
            $name = $content->response[0]->name;
        }

        $comunitie = new mcComunities();
        $comunitie->url = $request->input( 'url' );
        $comunitie->name = $name;
        $comunitie->owner_id = $this->user->id;

        $comunitie->save();

        return redirect()->back()->with( 'msg', 'Добавлено' );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getDeleteComunity( Request $request, $id )
    {
        //$comunity = mcComunities::find( $id );
        $comunity = mcComunities::where( 'id', $id )->where( 'owner_id', $this->user->id );
        if ( $comunity )
            $comunity->delete();

        return redirect( 'comunities' )->with( 'msg', 'Удалено' );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getProposals()
    {
        $proposals = mcUser::find( $this->user->id)->proposals()->paginate( 15 );

        return view( 'proposals', ['proposals' => $proposals] );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function postProposals( Request $request )
    {
        $this->validate( $request, [ 'proposal' => 'max:255'] );

        $proposal = new mcProposals();
        $proposal->text = $request->input( 'proposal' );
        $proposal->owner_id = $this->user->id;
        $proposal->save();
        return redirect()->route( 'proposal' );
    }

/**
*-------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getDeleteProposal( Request $request, $id )
    {
        //$proposal = mcProposals::findOrFail( $id );
        $proposal = mcUser::find( $this->user->id )->proposals()->where( 'id', $id )->where( 'owner_id', $this->user->id );

        if ( $proposal )
            $proposal->delete();

        return redirect()->back()->with( 'msg', 'Удалено' );
    }

/*------------------------------------------------------------------------------
*
*
*
*-------------------------------------------------------------------------------
*/
    public function getDeletePost( Request $request, $id )
    {
        $post = mcUser::find( $this->user->id )->posts()->where( 'id', $id )->where( 'user_id', $this->user->id );
        $post->delete();

        return redirect()->back()->with( 'msg', 'Удалено' );
    }

/**
 *-------------------------------------------------------------------------------
 *
 * Send message to VK user
 *
 * @var integer $id VK user id
 * @var @string $mesage Message text
 *
 *-------------------------------------------------------------------------------
 */
    public function sendMessage( $id, $message )
    {
        //*https://api.vk.com/method/messages.send?user_id=6269901&message=habrahabr&v=5.37&access_token=000000*/
        //token - 96b974f939195cfd6660abb4073b43f8d3fb41529ffe9b287137953a776a52e36b5e4ee089027548c4842
        //$settings = mcSettings::first();

        $response = Curl::to('https://api.vk.com/method/messages.send')
                ->withData([
                    /*'domain' => 'volosenkov',*/
                    'user_id' => $id,
                    'message' => $message,
                    'random_id' => rand( 0, 255 ),
                    'v' => '5.52',
                    'access_token' => $this->settings->access_token/*'96b974f939195cfd6660abb4073b43f8d3fb41529ffe9b287137953a776a52e36b5e4ee089027548c4842'*/
                ])->post();

        $response = json_decode( $response );

        if ( isset( $response->error ) )
        {
            return false;
        }

        return true;
    }
}
