<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品情報編集画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-12 mx-auto">
                        <x-flash-message status="session('status')" />
                          <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">商品情報編集</h1>
                          </div>
                          <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="flex flex-wrap -m-2">
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                      <input type="text" id="name" name="name" value="{{ $product->name }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="information" class="leading-7 text-sm text-gray-600">説明文</label>
                                      <textarea id="information" name="information" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ $product->information }}</textarea>
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                      <input type="number" id="price" name="price" value="{{ $product->price }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="current_quantity" class="leading-7 text-sm text-gray-600">現在の在庫数</label>
                                      <input type="hidden" id="current_quantity" name="current_quantity" value="{{ $quantity }}">
                                      <div class="w-full bg-gray-100 bg-opacity-50 rounded text-base outline-none text-gray-700 py-1 px-3 leading-8">{{ $quantity }}</div>
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="quantity" class="leading-7 text-sm text-gray-600">数量</label>
                                      <input type="number" id="quantity" name="quantity" value="0" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                  </div>
                                  <div class="p-2 w-full mt-4 mb-6">
                                    <div class="relative flex justify-around">
                                      <div><input type="radio" name="type" value="{{ \Constant::PRODUCT_LIST['add'] }}" class="mr-2" checked>入荷</div>
                                      <div><input type="radio" name="type" value="{{ \Constant::PRODUCT_LIST['reduce'] }}" class="mr-2">出荷</div>
                                    </div>
                                  </div>
                                  <div class="flex justify-center p-2 w-full">
                                    <button class="mr-8 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                                  </form>
                                    <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="POST">
                                      @csrf
                                      @method('delete')
                                      <button class="ml-8 text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</button>
                                    </form>
                                  </div>
                                </div>
                          </div>
                        </div>
                      </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
