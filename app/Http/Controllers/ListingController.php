<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{

    public function index()
    {
        $listings = Listing::where('est_active', true)->with('tags')->latest()->get();
        return view('listings.index', compact('listings'));
    }
}
