<?php

namespace App\Http\Controllers;

use Auth;
use App\Document;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    public function search()
    {
        $documents = Document::with('user')
            ->join('users', 'documents.user_id', '=', 'users.id')
            ->where('documents.title', 'LIKE', '%' . request('search') . '%')
            ->orWhere('users.name', 'LIKE', '%' . request('search') . '%');

        $documents = $documents->paginate(5);

        return view('documents.index', compact('documents'));
    }        
}
