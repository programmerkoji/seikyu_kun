<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">掲載 - 新規登録</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('posting.store') }}" method="post">
                        @csrf
                        <div class="flex flex-col gap-4 md:flex-row mb-4">
                            <div class="w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">企業名</label>
                                <select name="company_id" class="block mb-2 text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value=""></option>
                                    @foreach ($companies as $company)
                                    <option value="{{$company->id}}" @if((int)old('company_id')===(int)$company->id) selected @endif>{{$company->name}}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">商品名</label>
                                <select name="product_id" class="block mb-2 text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value=""></option>
                                    @foreach ($products as $product)
                                    <option value="{{$product->id}}" @if((int)old('product_id')===(int)$product->id) selected @endif>{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full mb-4">
                            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">掲載内容（キャンペーン名、特別価格など）</label>
                            <input type="text" id="content" name="content" value="{{old('content')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('content')
                            <span class="text-rose-700 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-4 md:flex-row mb-4">
                            <div class="w-full">
                                <label for="posting_start" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">掲載開始日</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="posting_start" name="posting_start" value="{{old('posting_start')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('posting_start')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="posting_term" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">掲載期間</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="posting_term" name="posting_term" value="{{old('posting_term')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"><span class="whitespace-nowrap">週間</span>
                                </div>
                                @error('posting_term')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 md:flex-row mb-4">
                            <div class="w-full">
                                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">数量</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="quantity" name="quantity" value="{{old('quantity')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"><span class="whitespace-nowrap">部</span>
                                </div>
                                @error('quantity')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">金額</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="price" name="price" value="{{old('price')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"><span class="whitespace-nowrap">円</span>
                                </div>
                                @error('price')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full mb-4">
                            <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">その他（備考）</label>
                            <textarea type="text" id="note" name="note" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none h-32">{{old('note')}}</textarea>
                            @error('note')
                            <span class="text-rose-700 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="location.href='{{ route('product.index') }}'" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">戻る</button>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
