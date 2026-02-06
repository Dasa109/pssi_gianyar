<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::latest()->get();
        return view('pages.clubs.index', compact('clubs'));
    }

    public function show($slug)
    {
        $club = Club::where('slug', $slug)->firstOrFail();
        return view('pages.clubs.show', compact('club'));
    }
}