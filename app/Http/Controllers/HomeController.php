<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{

	public function index()
	{
		$categories = Category::take(6)->get();

		return view('home', compact( 'categories'));
	}

}


