<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DB;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $post = DB::table('posts')
      ->join('taxonomies', 'taxonomies.id','=','posts.taxonomy_id')
      ->join('users','users.id','=','posts.user_id')
      ->select('posts.id',
          'posts.user_id',
          'posts.taxonomy_id',
          'taxonomies.taxonomy_name',
          'posts.post_title',
          'posts.post_title_slug',
          'posts.post_excerpt',
          'posts.post_content',
          'posts.post_views',
          'posts.post_status',
          'posts.comment_status',
          'posts.created_at')->get();
      return  $post;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Post::create([
        'user_id' => 33,
        'taxonomy_id' => $request->taxonomy_id,
        'post_title' => $request->post_title,
        'post_title_slug' => Str::slug($request->post_title, '-'),
        'post_excerpt' => $request->post_excerpt,
        'post_content' => $request->post_content,
        'post_views' => 0,
        'post_status' => 0,
        'comment_status' =>(isset( $request->comment_status)) ? 1 : 0
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $postdetail = DB::table('posts')->join('taxonomies', 'taxonomies.id','=','posts.taxonomy_id')
                                    ->where('posts.id', $id)->select('posts.id','posts.taxonomy_id','posts.post_title','posts.post_title_slug','posts.post_excerpt','posts.post_content','posts.post_views','posts.created_at')->get();

      foreach($postdetail as $value){
          $post_id = $value->id;
        $taxonomy_id = $value->taxonomy_id;
      }
      $relatedpost = DB::table('posts')->join('taxonomies', 'taxonomies.id','=','posts.taxonomy_id')
                                    ->where( 'posts.id','<>',$post_id,'and','taxonomies.id', $taxonomy_id )
                                    ->select('posts.id','posts.post_title','posts.post_title_slug','posts.post_excerpt','posts.post_content','posts.post_views','posts.created_at')
                                    ->take(3)
                                    ->get();
      $firstImage = array();
      foreach( $relatedpost as $value)
      {
          $firstImage[$value->id] = $this->getFirstImage($value->post_content);
      }
      return compact('postdetail', 'relatedpost','firstImage');
    }
    public function getFirstImage($strContent)
    {
        $first_img = "";
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $strContent, $matches);
        if(empty($output))
            return asset("public/img/noimage.png");
        else
            return $matches[1][0];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request,  $id)
     {
         $p = Post::find($id);
         $p->taxonomy_id = $request->taxonomy_id;
         $p->post_title = $request->post_title;
         $p->post_title_slug = Str::slug($request->post_title, '-');
         $p->post_excerpt = $request->post_excerpt;
         $p->post_content = $request->post_content;
         $p->comment_status = (isset( $request->comment_status)) ? 1 : 0;
         $p->save();

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $post = Post::find($id);
	    $post->delete();
    }
}
