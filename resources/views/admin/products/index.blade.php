<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              商品管理画面
          </h2>
          <form action="{{ route('admin.products.index') }}" method="get">
            <div class="flex space-x-2 items-center">
              <div><input name="keyword" class="border border-gray-500 px-2 py-2" value="{{ $keyword }}" placeholder="キーワード"></div>
              <div><button class="ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">検索</button></div>
            </div>
          </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-wrap p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font mx-auto">
                      <div class="container px-5 py-8 mx-auto">
                        <x-flash-message status="session('status')" />
                        <div class="w-full mx-auto overflow-auto mt-8">
                          <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                              <tr>
                                <th class="text-center px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">商品名</th>
                                <th class="text-center px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                                <th class="text-center px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">更新日時</th>
                                <th class="text-center px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                              </tr>
                            </thead>
                            @foreach ($products as $product)
                            <tbody>
                              <tr>
                                <td class="text-center px-4 py-3">{{ $product->name }}</td>
                                <td class="text-center px-4 py-3">{{ number_format($product->price) }}円</td>
                                <td class="text-center px-4 py-3">{{ $product->updated_at->format('Y年m月d日H時i分') }}</td>
                                <td class="text-center px-4 py-3"><button onclick="location.href='{{ route('admin.products.edit', ['product' => $product->id]) }}'" class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">編集</button></td>
                              </tr>
                            </tbody>
                            @endforeach
                          </table>
                        </div>
                      </div>
                      {{ $products->links() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
