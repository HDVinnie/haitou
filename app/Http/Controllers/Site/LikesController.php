<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function likePost(Request $request, $post_id)
    {
        $post = Post::findOrFail($post_id);

        $user = $request->user();

        $postUrl = "forum/topic/{$post->topic->id}.{$post->topic->slug}?page={$post->pageNumber()}#post-{$post_id}";

        $like = $user->likes()->where('post_id', '=', $post->id)->first();

        if ($like) {
//            toastr()->warning('Você já deu like deste post!', 'Aviso');
            return response()->json('voted');
        } elseif ($post->user_id == $user->id) {
//            toastr()->info('Você não pode dar like do seu próprio post!', 'Aviso');
            return response()->json('owner');
        } else {
            $new = new Like();
            $new->user_id = $user->id;
            $new->post_id = $post->id;
            $new->save();

//            toastr()->success('Like aplicado com sucesso!', 'Like');
            return response()->json('success');
        }
    }

}
