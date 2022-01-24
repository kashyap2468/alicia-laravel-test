<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Favourites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function welcome(Request $request)
    {
        $myfavourites = [];
        if (Auth::user()) {
            $myfavouritesData = Favourites::where('user_id', Auth::user()->id)->get()->toArray();
            foreach ($myfavouritesData as $favouriteList) {
                $myfavourites[] = $favouriteList['image_id'];
            }
        }
        return view('welcome', compact('myfavourites'));
    }

    public function addImagetoFavourite(Request $request, $imageId)
    {
        if (Auth::user()) {
            //Add Image in Favourite
            Favourites::create(['user_id' => Auth::user()->id, 'image_id' => $imageId]);
            return response()->json(['status' => 200, 'is_login' => 1, 'msg' => 'Image added to favourite.']);
        } else {
            return response()->json(['status' => 500, 'is_login' => 0, 'msg' => 'Please login to avail this feature']);
        }
    }

    public function removeImageFavourite(Request $request, $imageId)
    {
        if (Auth::user()) {
            //Add Image in Favourite
            Favourites::where('user_id', Auth::user()->id)->where('image_id', $imageId)->delete();

            $myfavouritesData = Favourites::where('user_id', Auth::user()->id)->get()->toArray();
            foreach ($myfavouritesData as $favouriteList) {
                $myfavourites[] = $favouriteList['image_id'];
            }


            return response()->json(['status' => 200, 'is_login' => 1, 'msg' => 'Image removed from favourite.','myfavourites'=>$myfavourites]);
        } else {
            return response()->json(['status' => 500, 'is_login' => 0, 'msg' => 'Please login to avail this feature']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function login(Request $request)
    {
        $userData = Auth::user();
        if (!empty($userData)) {
            return redirect()->route('welcome');
        } else {
            if (isset($request->email) && isset($request->password)) {
                $credentials = [
                    'email' => $request->email,
                    'password' => $request->password
                ];
                if (Auth::attempt($credentials)) {
                    return response()->json(['status' => 200, 'message' => 'Logged in successfully']);
                }
                return response()->json(['status' => 500, 'message' => 'Username or password is wrong.']);

            } else {
                return response()->json(['status' => 500, 'message' => 'Username or password is wrong.']);
            }
        }
    }

    public function goToRegister(Request $request)
    {
        return view('auth.register');
    }

    public function process_signup(Request $request)
    {
        // $this->validate($request, [ 
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required|min:6',
        // ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->save();

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        Auth::attempt($credentials);

        return response()->json(
            [
                'success' => true,
                'message' => 'Registration is completed'
            ]
        );

    }
}
