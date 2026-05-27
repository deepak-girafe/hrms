<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\EmployeeDocument;
class ProfileController extends Controller
{   
    public function index()
    {
        $user = auth()->user()->load('documents');

        return view(

            'profile.profile',

            compact('user')

        );
    }
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
    /**
     * Change Password
     */
    public function changePassword(Request $request)
    {
        $request->validate([

            'current_password' =>

                'required',

            'password' =>

                'required|min:8|confirmed'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify Current Password
        |--------------------------------------------------------------------------
        */

        if(

            !Hash::check(

                $request->current_password,

                auth()->user()->password

            )

        ) {

            return back()->with(

                'error',

                'Current password is incorrect'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        auth()->user()->update([

            'password' => Hash::make(

                $request->password

            )

        ]);

        return back()->with(

            'success',

            'Password changed successfully'

        );
    }

    /**
     * Upload Image
     */
    public function updateimage(Request $request)
    {
        $request->validate([

            'profile_image' =>

                'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);

        $data = [];

        /*
        |--------------------------------------------------------------------------
        | Upload Profile Image
        |--------------------------------------------------------------------------
        */

        if($request->hasFile('profile_image')) {

            /*
            |--------------------------------------------------------------------------
            | Create Folder If Not Exists
            |--------------------------------------------------------------------------
            */

            if(

                !file_exists(

                    public_path('profile-images')

                )

            ) {

                mkdir(

                    public_path('profile-images'),

                    0777,

                    true

                );
            }

            /*
            |--------------------------------------------------------------------------
            | Upload Image
            |--------------------------------------------------------------------------
            */

            $imageName =

                time()

                . '_'

                . rand(1000,9999)

                . '.'

                . $request->profile_image
                    ->extension();

            $request->profile_image->move(

                public_path('profile-images'),

                $imageName

            );

            $data['profile_image'] = $imageName;
        }

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        auth()->user()->update($data);

        return back()->with(

            'success',

            'Profile image updated successfully'

        );
    }

    /**
     * Upload Documemts
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([

            'document_name' =>

                'required',

            'document_file' =>

                'required|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload File
        |--------------------------------------------------------------------------
        */

        $file = time() . '_' .

        $request->file('document_file')
                ->getClientOriginalName();

        $request->file('document_file')
            ->move(

                public_path('employee-documents'),

                $file

            );

        /*
        |--------------------------------------------------------------------------
        | Save Document
        |--------------------------------------------------------------------------
        */

        EmployeeDocument::create([

            'user_id' => auth()->id(),

            'document_name' => $request->document_name,

            'document_file' => $file

        ]);

        return back()->with(

            'success',

            'Document uploaded successfully'

        );
    }
}
