<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-around items-center">
          <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品一覧画面
            </h2>
          </div>
          <div>
            <form action="{{ route('user.items.index') }}" method="get">
              <div class="flex space-x-2 items-center">
                <div><input name="keyword" class="border border-gray-500 px-2 py-2" value="{{ $keyword }}" placeholder="キーワード"></div>
                <div><button class="ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">検索</button></div>
              </div>
            </form>
          </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <x-flash-message status="session('status')" />
                <div class="flex flex-wrap p-6 bg-white border-b border-gray-200">
                    @foreach ($products as $product)
                    <section class="text-gray-600 body-font">
                      <div class="container px-5 py-24 mx-auto">
                        <div class="-m-4 mx-auto">
                          <div class="md:p-2 lg:p-4 w-full">
                                <a class="block relative h-48 rounded overflow-hidden" href="{{ route('user.items.show', ['item' => $product->id]) }}">
                                  <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="https://dummyimage.com/420x260">
                                </a>
                                <div class="mt-4">
                                  <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                  <p class="mt-1">{{ number_format($product->price) }}円</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                    @endforeach
                    {{ $products->links() }}
                  </div>
                </div>
        </div>
    </div>
</x-app-layout>
