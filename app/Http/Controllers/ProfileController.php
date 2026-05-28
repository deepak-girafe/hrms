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
use App\Models\DocumentMaster;
class ProfileController extends Controller
{   
    public function index()
    {
        $user = auth()->user()->load([

            'documents',

            'documents.documentMaster'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Active Document Masters
        |--------------------------------------------------------------------------
        */

        $documentMasters = DocumentMaster::where(

                'status',

                'Active'

            )

            ->orderBy('document_name')

            ->get();
            
        return view(

            'profile.profile',

            compact(

                'user',

                'documentMasters'

            )

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

        'document_master_id' =>

            'required|exists:document_masters,id',

        'document_file' =>

            'required|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'

    ]);

    /*
    |--------------------------------------------------------------------------
    | Create Folder
    |--------------------------------------------------------------------------
    */

    $folderPath = public_path(

        'employee-documents'

    );

    if(!file_exists($folderPath)) {

        mkdir(

            $folderPath,

            0777,

            true

        );
    }

    /*
    |--------------------------------------------------------------------------
    | File Upload
    |--------------------------------------------------------------------------
    */

    $uploadedFile = $request->file('document_file');

    $extension = strtolower(

        $uploadedFile->getClientOriginalExtension()

    );

    $fileName =

        time()

        . '_'

        . rand(1000,9999)

        . '.'

        . $extension;

    $fullPath =

        $folderPath

        . '/'

        . $fileName;

    /*
    |--------------------------------------------------------------------------
    | Compress Image Files
    |--------------------------------------------------------------------------
    */

    if(

        in_array(

            $extension,

            [

                'jpg',

                'jpeg',

                'png'

            ]

        )

    ) {

        /*
        |--------------------------------------------------------------------------
        | Create Image Resource
        |--------------------------------------------------------------------------
        */

        if($extension == 'png') {

            $sourceImage = imagecreatefrompng(

                $uploadedFile

            );

        } else {

            $sourceImage = imagecreatefromjpeg(

                $uploadedFile

            );
        }

        /*
        |--------------------------------------------------------------------------
        | Image Dimensions
        |--------------------------------------------------------------------------
        */

        $width = imagesx($sourceImage);

        $height = imagesy($sourceImage);

        $maxWidth = 1200;

        /*
        |--------------------------------------------------------------------------
        | Resize Large Images
        |--------------------------------------------------------------------------
        */

        if($width > $maxWidth) {

            $newWidth = $maxWidth;

            $newHeight = floor(

                $height *

                ($newWidth / $width)

            );

            $compressedImage = imagecreatetruecolor(

                $newWidth,

                $newHeight

            );

            imagecopyresampled(

                $compressedImage,

                $sourceImage,

                0,

                0,

                0,

                0,

                $newWidth,

                $newHeight,

                $width,

                $height

            );

        } else {

            $compressedImage = $sourceImage;
        }

        /*
        |--------------------------------------------------------------------------
        | Save Compressed JPEG
        |--------------------------------------------------------------------------
        */

        imagejpeg(

            $compressedImage,

            $fullPath,

            60

        );

        /*
        |--------------------------------------------------------------------------
        | Free Memory
        |--------------------------------------------------------------------------
        */

        imagedestroy($sourceImage);

        imagedestroy($compressedImage);
    }

    /*
    |--------------------------------------------------------------------------
    | Other Files
    |--------------------------------------------------------------------------
    */

    else {

        $uploadedFile->move(

            $folderPath,

            $fileName

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Save Document
    |--------------------------------------------------------------------------
    */

    EmployeeDocument::create([

        'user_id' => auth()->id(),

        'document_master_id' =>

            $request->document_master_id,

        'document_file' => $fileName

    ]);

    return back()->with(

        'success',

        'Document uploaded successfully'

    );
}
}
