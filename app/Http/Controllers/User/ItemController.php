<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(20);

        $keyword = $request->input('keyword');

        $query = Product::query();
        // 検索フォームにキーワードが入力されたら
        if (!is_null($keyword)) {
            $spaceConvert = mb_convert_kana($keyword, 's');

            $keywords = preg_split('/[\s]+/', $spaceConvert, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($keywords as $word) {
                $query->where('products.name', 'like', '%' . $word . '%');
            }

            $products = $query->paginate(20);

            if (!$query->exists()) {
                return redirect()
                    ->route('user.items.index')
                    ->with([
                        'message' => '検索キーワードと一致する結果が見つかりませんでした。',
                        'status' => 'alert'
                    ]);
            }
        }

        return view('user.index', compact('products', 'keyword'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
            ->sum('quantity');

        if ($quantity > 10) {
            $quantity = 10;
        }

        return view('user.show', compact('product', 'quantity'));
    }
}
