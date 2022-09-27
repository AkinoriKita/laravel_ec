<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;

use function PHPSTORM_META\type;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        return view('admin.products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'price' => 'required|integer',
            'filename' => 'file|mimes:jpeg,png,jpg',
            'quantity' => 'required|integer',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $dir = 'images';
                $file_name = $request->filename->getClientOriginalName();
                $request->filename->storeAs('public/' . $dir, $file_name);

                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'filename' => $file_name,
                    'filepath' => 'storage/' . $dir . '/' . $file_name
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity,
                ]);
            }, 2);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('admin.products.index')
            ->with([
                'message' => '商品を登録しました。',
                'status' => 'info'
            ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
            ->sum('quantity');

        return view('admin.products.edit', compact('product', 'quantity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'price' => 'required|integer',
            'filename' => 'file|mimes:jpeg,png,jpg',
            'quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
            ->sum('quantity');
        if ($request->current_quantity !== $quantity) {
            $id = $request->route()->parameter('product');
            return redirect()->route('admin.products.edit', ['product' => $id])
                ->with([
                    'message' => '在庫数が変更されています。再度確認してください。',
                    'status' => 'alert'
                ]);
        } else {
            try {
                DB::transaction(function () use ($request, $product) {
                    $dir = 'images';
                    $file_name = "";
                    if (isset($request->filename)) {
                        // アップロードされたファイル名を取得
                        $file_name = $request->filename->getClientOriginalName();
                        // 取得したファイル名で保存
                        $request->filename->storeAs('public/' . $dir, $file_name);
                    }

                    $product->name = $request->name;
                    $product->information = $request->information;
                    $product->price = $request->price;
                    $product->filename = $request->filename;
                    $product->filepath = 'storage/' . $dir . '/' . $file_name;
                    $product->save();

                    if ($request->type === \Constant::PRODUCT_LIST['add']) {
                        $newQuantity = $request->quantity;
                    }
                    if ($request->type === \Constant::PRODUCT_LIST['reduce']) {
                        $newQuantity = $request->quantity * -1;
                    }

                    Stock::create([
                        'product_id' => $product->id,
                        'type' => $request->type,
                        'quantity' => $newQuantity,
                        'filename' => $file_name,
                        'filepath' => 'storage/' . $dir . '/' . $file_name
                    ]);
                }, 2);
            } catch (Throwable $e) {
                Log::error($e);
                throw $e;
            }

            return redirect()
                ->route('admin.products.edit', ['product' => $product->id])
                ->with([
                    'message' => '商品情報を更新しました。',
                    'status' => 'info'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)
            ->delete();

        return redirect()
            ->route('admin.products.index')
            ->with([
                'message' => '商品を削除しました。',
                'status' => 'alert'
            ]);
    }
}
