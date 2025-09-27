<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(User $user)
    {
        Auth::user()->follows()->syncWithoutDetaching([$user->id]);
        return back()->with('success', 'フォローしました');
    }

    public function destroy(User $user)
    {
        Auth::user()->follows()->detach($user->id);
        return back()->with('success', 'フォローを解除しました');
    }
}