<?php

namespace App\Http\Controllers;
use App\Models\CarakerjaPost;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class CarakerjaPostController extends Controller
{
    public function index()
    {
        $carakerjaPosts = CarakerjaPost::all();
        $ulasans = Ulasan::all();

        return view('index', compact(['carakerjaPosts', 'ulasans']));    
    }


}
