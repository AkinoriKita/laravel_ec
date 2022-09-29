<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Validation\Rules\Unique;
use Image;

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
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(20);

        $keyword = $request->input('keyword');

        $query = Product::query();

        if (!is_null($keyword)) {
            $spaceConvert = mb_convert_kana($keyword, 's');

            $keywords = preg_split('/[\s]+/', $spaceConvert, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($keywords as $word) {
                $query->where('products.name', 'like', '%' . $word . '%');
            }

            $products = $query->paginate(20);

            if (!$query->exists()) {
                return redirect()
                    ->route('admin.products.index')
                    ->with([
                        'message' => '結果が見つかりませんでした。',
                        'status' => 'alert'
                    ]);
            }
        }

        return view('admin.products.index', compact('products', 'keyword'));
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
                $fileNameToStore = "";
                if ($request->filename !== null) {
                    $imageFile = $request->filename;
                    $fileName = uniqid(rand() . '_');
                    $extension =  $imageFile->extension();
                    $fileNameToStore = $fileName . '.' . $extension;

                    Image::make($imageFile)->resize(420, 260)->encode()->save(public_path("storage/images/{$fileNameToStore}"));
                }
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'filename' => $fileNameToStore,
                    'filepath' => 'storage/images/' . $fileNameToStore
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
                    $fileNameToStore = "";
                    if (isset($request->filename)) {
                        $imageFile = $request->filename;
                        $fileName = uniqid(rand() . '_');
                        $extension =  $imageFile->extension();
                        $fileNameToStore = $fileName . '.' . $extension;

                        Image::make($imageFile)->resize(420, 260)->encode()->save(public_path("storage/images/{$fileNameToStore}"));
                    }

                    $product->name = $request->name;
                    $product->information = $request->information;
                    $product->price = $request->price;
                    $product->filename = $fileNameToStore;
                    $product->filepath = 'storage/images/' . $fileNameToStore;
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
                        'filename' => $fileNameToStore,
                        'filepath' => 'storage/images/' . $fileNameToStore
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
