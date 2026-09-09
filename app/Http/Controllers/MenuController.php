<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $menus = Menu::query()
            ->with('category')
            ->where('is_available', true)
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->integer('category'));
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->string('q') . '%');
            })
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('menu.index', compact('categories', 'menus'));
    }
}
