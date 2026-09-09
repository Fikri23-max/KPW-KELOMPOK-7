<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    const SESSION_KEY = 'cart';

    public function index()
    {
        $cart = Session::get(self::SESSION_KEY, []);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function store(Request $request, Menu $menu)
    {
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $request->integer('quantity', 1);
        $cart = Session::get(self::SESSION_KEY, []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] += $quantity;
        } else {
            $cart[$menu->id] = [
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'price' => (float) $menu->price,
                'image' => $menu->image_url,
                'quantity' => $quantity,
            ];
        }

        Session::put(self::SESSION_KEY, $cart);

        return back()->with('success', "{$menu->name} ditambahkan ke keranjang.");
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = Session::get(self::SESSION_KEY, []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] = $request->integer('quantity');
            Session::put(self::SESSION_KEY, $cart);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $cart = Session::get(self::SESSION_KEY, []);
        unset($cart[$menu->id]);
        Session::put(self::SESSION_KEY, $cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
