<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use App\Notifications\MagicLoginLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MagicLoginController extends Controller
{
    public function sendMagicLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'email' => $request->email,
                'name' => explode('@', $request->email)[0],
                'password' => bcrypt(Str::random(24))
            ]);
        }

        $generator = new LoginUrl($user);
        $url = $generator->generate();

        $user->notify(new MagicLoginLink($url));

        return back()->with('status', 'We have emailed you a magic login link!');
    }
}