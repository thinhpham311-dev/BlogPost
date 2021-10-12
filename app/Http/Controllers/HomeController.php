<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;

class HomeController extends Controller
{
    public function getFirstImage($strContent)
    {
        $first_img = "";
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $strContent, $matches);
        if(empty($output))
            return asset("public/images/capture.jpg");
        else
            return $matches[1][0];
    }
    public function index(){
        $post = DB::table('posts')->select("posts.id","posts.post_title","posts.post_title_slug","posts.post_excerpt","posts.post_content","posts.post_views")->take(12)->get();

        $firstImage = array();
        foreach($post as $value)
        {
            $firstImage[$value->id] = $this->getFirstImage($value->post_content);
        }
        return compact('post','firstImage');
    }
}
