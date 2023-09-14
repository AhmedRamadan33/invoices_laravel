<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('users.editprofile');
    }

    public function update(Request $request )
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['max:255'],
            'address' => ['string','max:255'],
            'country' => ['string','max:255'],
            'Twitter' => ['max:255'],
            'Facebook' => ['max:255'],
            'Linkedin' => ['max:255'],
            'Google' => ['max:255'],
            'Github' => ['max:255'],
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = request('name');
        $user->phone = request('phone');
        $user->address = request('address');
        $user->country = request('country');
        $user->Twitter = request('Twitter');
        $user->Facebook = request('Facebook');
        $user->Linkedin = request('Linkedin');
        $user->Google = request('Google');
        $user->Github = request('Github');

        //start upload file code
        $file = $request->file('profile_pic');
        if ($file != null) {
            $fileName = time() . $file->getClientOriginalName();
            $location = public_path('./files/');
            $file->move($location, $fileName);
            $path = public_path('./files/') . $user->image;
            if ($path != public_path('./files/') . 'F.B.fack.png')  {
                unlink($path);
            }
        } else {
            $fileName = $user->image;
        }
        $user->image = $fileName;
        //End upload file code
        $user->save();
        return redirect()->route('profile.edit')->with('status', 'تم تحديث البروفايل بنجاح');
    }
   
}

