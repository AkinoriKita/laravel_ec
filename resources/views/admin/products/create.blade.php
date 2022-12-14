<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品登録画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-24 mx-auto">
                          <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">商品登録</h1>
                          </div>
                          <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form action="{{ route('admin.products.store', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="flex flex-wrap -m-2">
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                      <input type="text" id="name" name="name" value="{{ old('name')}}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="information" class="leading-7 text-sm text-gray-600">説明文</label>
                                      <textarea id="information" name="information" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old('information') }}</textarea>
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="filename" class="leading-7 text-sm text-gray-600">商品画像</label>
                                      <input type="file" id="filename" name="filename" accept="image/png,image/jpeg,image/jpg" value="{{ old('filename') }}" >
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                      <input type="number" id="price" name="price" value="{{ old('price') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <div class="relative">
                                      <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫</label>
                                      <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                  </div>
                                  <div class="p-2 w-full">
                                    <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                  </div>
                                </div>
                            </form>
                          </div>
                        </div>
                      </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
