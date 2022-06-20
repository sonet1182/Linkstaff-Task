<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageFollowing;
use App\Models\PersonFollowing;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function person_post(Request $request)
    {
        $post = new Post();
        $post->person_id = Auth::user()->id;
        $post->post_content = $request->input('post_content');
        $post->save();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Post has been submitted Successfully',
        ]);
    }

    public function page_post(Request $request, $pageId)
    {
        $page = Page::find($pageId);

        if (empty($page)) {
            return response()->json([
                'status' => 200,
                'message' => 'Page is not exist!',
            ]);
        } else {
            if ($page->user_id != Auth::user()->id) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Access Denied, Page is not own by you!',
                ]);
            } else {
                $post = new Post();
                $post->page_id = $pageId;
                $post->post_content = $request->input('post_content');
                $post->save();

                return response()->json([
                    'status' => 200,
                    'post' => $post,
                    'message' => 'Post has been submitted Successfully',
                ]);
            }
        }
    }

    public function index()
    {
        $following_pages = PageFollowing::select('page_id')->where('follower_id',Auth::user()->id)->get();
        $following_persons = PersonFollowing::select('person_id')->where('follower_id',Auth::user()->id)->get();

        $posts = Post::whereIn('page_id',$following_pages)->orWhereIn('person_id',$following_persons)->latest()->get();

        return response()->json([
            'status' => 200,
            'posts' => $posts,
            'message' => 'Post List Submitted by your following Persons & Pages',
        ]);
    }
}
