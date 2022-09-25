<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品一覧画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-wrap p-6 bg-white border-b border-gray-200">
                    @foreach ($products as $product)
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                          <div class="-m-4 mx-auto">
                            <div class="md:p-2 lg:p-4 w-full">
                              <a class="block relative h-48 rounded overflow-hidden">
                                <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="https://dummyimage.com/420x260">
                              </a>
                              <div class="mt-4">
                                <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">CATEGORY</h3>
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
