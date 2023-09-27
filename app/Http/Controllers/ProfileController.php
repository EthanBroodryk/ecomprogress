<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
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
        return Redirect::route('profile.edit');
    }



    public function updateProfilePic(Request $request)

    {
        $user_id = $request->user_id;
        // dd('USER_ID',$user_id);
        $uploadedFile = $request->avatar;
        $imageName = $uploadedFile->getClientOriginalName();
        $data = $request->validate([
            'avatar'=>'required'
        ]);
        $path = $uploadedFile->storeAs('uploads',$imageName); 
        Image::create(['filename' =>  'http://127.0.0.1:5173/public/uploads/'.$imageName,
        'user_id'=> $user_id,
        ]);
        $sourceFolder = '/home/ethan/Desktop/imageUploadWithLaravelAndVue(sept12)/storage/app/uploads';
        $destinationFolder = '/home/ethan/Desktop/imageUploadWithLaravelAndVue(sept12)/public/uploads';
        $files = scandir($sourceFolder);
        $sourceArray = [];
        $destinationArray = [];

        if($files !== false){
            foreach($files as $file){
                if($file != "." && $file != ".."){
                    $sourceFile = $sourceFolder."/".$file;
                    $destinationFile = $destinationFolder."/".$file;
                    array_push($sourceArray,$sourceFile);
                    array_push($destinationArray,$destinationFile);
            
                    if (rename($sourceFile, $destinationFile)) {
                        echo "Moved $file to $destinationFolder<br>";
                    } else {
                        echo "Failed to move $file<br>";
                    }

                }
             
            }

        }
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
