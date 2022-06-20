<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageFollowing;
use App\Models\PersonFollowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    public function follow_person($personId)
    {
        $person_name = User::find($personId)->first_name;

        $allready_follow = PersonFollowing::where([['follower_id', Auth::user()->id], ['person_id', $personId]])->first();

        if ($allready_follow) {
            return response()->json([
                'status' => 200,
                'message' => 'You are already following - ' . $person_name . '!',
            ]);
        } else {

            $follow = new PersonFollowing();
            $follow->person_id = $personId;
            $follow->follower_id = Auth::user()->id;
            $follow->save();

            return response()->json([
                'status' => 200,
                'message' => 'You are following - ' . $person_name . ' Successfully',
            ]);
        }
    }

    public function follow_page($pageId)
    {
        $page_name = Page::find($pageId)->name;

        $allready_follow = PageFollowing::where([['follower_id', Auth::user()->id], ['page_id', $pageId]])->first();

        if ($allready_follow) {
            return response()->json([
                'status' => 200,
                'message' => 'You are already following -' . $page_name . ' Page!',
            ]);
        } else {

            $follow = new PageFollowing();
            $follow->page_id = $pageId;
            $follow->follower_id = Auth::user()->id;
            $follow->save();

            return response()->json([
                'status' => 200,
                'message' => 'You are following ' . $page_name . ' Page Successfully',
            ]);
        }
    }
}
