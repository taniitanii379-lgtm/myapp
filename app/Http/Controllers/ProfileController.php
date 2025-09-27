<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User; // 🔽 Userモデルを追加
use App\Models\Event; // 🔽 Eventモデルを追加

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(User $user)
    {
        // ユーザーのデータと、そのユーザーのフォロー情報を取得
        // 🔽 $user->load(['follows', 'followers']) を $user->loadCount(['follows', 'followers']) に修正します
        //    これにより、リレーション先のデータを全て取得する代わりに、カウント（人数）のみを効率的に取得できます。
        $user->loadCount(['follows', 'followers']); 

        // 🔽 ログインユーザーのページかどうかで表示するイベントを切り替える
        if (auth()->user()->is($user)) {
            // 自分のページの場合: 自分のイベント + フォローユーザーのイベント
            $events = Event::query()
                ->where('user_id', $user->id)  // 自分のイベント
                ->orWhereIn('user_id', $user->follows->pluck('id')) // フォローしているユーザーのイベント
                ->with(['user', 'joinedUsers']) // ユーザー名と参加者情報も取得
                ->latest()
                ->paginate(10);
        } else {
            // 他のユーザーのページの場合: そのユーザーのイベントのみ
            $events = $user
                ->events()
                ->with(['user', 'joinedUsers'])
                ->latest()
                ->paginate(10);
        }
        
        // 🔽 変数名を $tweets から $events に修正（$tweetsは削除）
        return view('profile.show', compact('user', 'events')); 
    }
}
