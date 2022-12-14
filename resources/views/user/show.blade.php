<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:justify-around">
                        <div class="md:w-1/2 ml-4">
                            @if ($product->filename === null || $product->filename === "")
                            <img alt="ecommerce" class="mx-auto mb-8" src="https://dummyimage.com/420x260">
                            @else
                            <img class="mx-auto mb-8" src="{{ asset($product->filepath) }}">
                            @endif
                            <h1 class="text-gray-900 text-3xl title-font font-medium mb-4">{{ $product->name }}</h1>
                            <p class="leading-relaxed mb-8">{{ $product->information }}</p>
                            <div class="md:flex justify-around items-center">
                                <div>
                                    <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}</span><span class="test-sm text-gray-700">円</span>
                                </div>
                                <form action="{{ route('user.cart.add') }}" method="post">
                                @csrf
                                @if ($quantity === 0)
                                <div class="items-center">
                                    <p class="text-right text-red-500 mb-1">在庫がありません！</p>
                                    <button disabled class="flex pointer-events-none ml-16 text-white bg-gray-500 border-0 py-2 px-6 focus:outline-non rounded">カートに入れる</button>
                                </div>
                                @else
                                <div class="flex items-center">
                                    <span class="mr-3">数量</span>
                                    <div class="relative">
                                      <select name="quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                        @for ($i = 1; $i <= $quantity; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                      </select>
                                    </div>
                                    <button class="flex ml-16 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                                    <input type="hidden" name="product_id" value="{{ $product->id}}"> 
                                </div>
                                @endif
                                
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
