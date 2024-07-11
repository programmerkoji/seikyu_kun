<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求 - 新規登録</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('invoice.store')}}" method="post">
                        @csrf
                        <div class="flex flex-col gap-4 md:flex-row md:justify-between mb-6">
                            <div class="md:w-1/3">
                                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">企業名</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="company" name="company_name" value="{{old('company_name')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="企業名を検索">
                                    <input type="hidden" id="company_id" name="company_id" value="{{ old('company_id') }}">
                                </div>
                                @error('company_id')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:w-1/3">
                                <label for="billing_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求年</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" id="billing_year" name="billing_year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{old('billing_year', date('Y'))}}">
                                    <span class="whitespace-nowrap">年</span>
                                </div>
                                @error('billing_year')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:w-1/3">
                                <label for="billing_month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求月</label>
                                <div class="flex items-center gap-2">
                                    <select name="billing_month" class="block text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value=""></option>
                                        @foreach (config('constants.month') as $value)
                                        <option value="{{$value}}" @if((int)old('billing_month')===(int)$value) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <span class="whitespace-nowrap">月</span>
                                </div>
                                @error('billing_month')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full mb-4">
                            <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">タイトル</label>
                            <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{old('title')}}">
                            @error('title')
                            <span class="text-rose-700 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full mb-4">
                            <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">その他（備考）</label>
                            <textarea type="text" id="note" name="note" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none h-32">{{old('note')}}</textarea>
                            @error('note')
                            <span class="text-rose-700 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="location.href='{{ route('invoice.index') }}'" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">戻る</button>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/autocomplete.js', 'resources/css/autocomplete.css'])
</x-app-layout>
