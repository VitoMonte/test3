<?php

namespace App\Http\Controllers;

use Auth;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $queries =[];

        $documents = Document::query()
            ->join('users', 'documents.user_id', '=', 'users.id')
            ->select('documents.id', 'documents.file_puth', 'users.name', 'documents.created_at', 'documents.title');

        if (request()->has('sort_by')) {
            $documents = $documents->orderBy(request('sort_by'), request('sort'));
        } else {            
            $documents = $documents->orderBy('users.name', request('sort'));
        }     

        $queries['sort'] = request('sort'); 
        $queries['sort_by'] = request('sort_by');
        

        $documents = $documents->paginate(5)->appends($queries);
        
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.upload-form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;        
        $file = $request->file('file');         
        $title = $request->input('title');

        $this->validate($request, [
            'title' =>'required',
            'file' => 'required|file|mimes:txt,pdf,doc,docx,ppt,pptx,jpg,jpeg,png'
        ]);        

        $file_puth = $this->upload($file, $title);

        Document::create([
            'title' => $title,            
            'user_id'   => $user,             
            'file_puth' => $file_puth,
        ]);

        return redirect()->route('index');
    }

    /**
     * Upload file in storage\app\document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string $name - name uploaded file
     */
    public function upload($file, $name=null)
    {   
        //$path = Storage::putFileAs('documents', $file, $name);
        $name = time() . '_' . $name . '.' . $file->getClientOriginalExtension();
        $path = Storage::putFileAs('documents', $file, $name);
        
        return "$name";       
    }
    /**
     * Download file.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function download(Request $request)
    {
        $file = $request->filename;
        $storagePath  = Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix();
        $filePath = $storagePath . $file;

        return response()->download($filePath);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        $entity = $document;       

        return view('documents.upload-form', compact(['entity']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $this->validate($request, ['title' =>'required']);
        $document->update($request->all());

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {   
        $file = $document->file_puth;
        $document->delete();
        Storage::delete('documents/' .$file);

        return redirect()->route('index');
    }
}
