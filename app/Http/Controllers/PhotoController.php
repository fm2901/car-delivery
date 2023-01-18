<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;


class PhotoController extends Controller
{
    public function get($filename) {
        return Storage::disk('public')->download($filename);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
