<?php

namespace App\Http\Controllers;

use App\Models\DocumentMaster;
use Illuminate\Http\Request;

class DocumentMasterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $documents = DocumentMaster::latest()
            ->paginate(10);

        return view(

            'document-masters.index',

            compact('documents')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(

            'document-masters.create'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'document_name' =>

                'required|unique:document_masters,document_name'

        ]);

        DocumentMaster::create([

            'document_name' => $request->document_name,

            'description' => $request->description,

            'is_required' => $request->is_required,

            'status' => $request->status

        ]);

        return redirect()

            ->route('document-masters.index')

            ->with(

                'success',

                'Document created successfully'

            );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(DocumentMaster $document_master)
    {
        return view(

            'document-masters.edit',

            compact('document_master')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        DocumentMaster $document_master
    ) {

        $request->validate([

            'document_name' =>

                'required|unique:document_masters,document_name,'

                . $document_master->id

        ]);

        $document_master->update([

            'document_name' => $request->document_name,

            'description' => $request->description,

            'is_required' => $request->is_required,

            'status' => $request->status

        ]);

        return redirect()

            ->route('document-masters.index')

            ->with(

                'success',

                'Document updated successfully'

            );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(DocumentMaster $document_master)
    {
        $document_master->delete();

        return back()->with(

            'success',

            'Document deleted successfully'

        );
    }
}