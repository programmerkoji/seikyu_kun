<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">企業 - 編集画面</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('company.update', ['company' => $company->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="w-full mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">企業名</label>
                            <input type="text" id="name" name="name" value="{{$company->name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('name')
                            <span class="text-rose-700 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-4 md:flex-row mb-4">
                            <div class="w-1/4">
                                <label for="post_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">郵便番号</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="post_code" name="post_code" value="{{$company->post_code}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('post_code')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-3/4">
                                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">住所</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="address" name="address" value="{{$company->address}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('address')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 md:flex-row mb-4">
                            <div class="w-full">
                                <label for="tel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">電話番号</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="tel" name="tel" value="{{$company->tel}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('tel')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="ceo_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">代表者名</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="ceo_name" name="ceo_name" value="{{$company->ceo_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('ceo_name')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="responsible_person_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">担当者名</label>
                                <div class="w-full flex items-center gap-1">
                                    <input type="text" id="responsible_person_name" name="responsible_person_name" value="{{$company->responsible_person_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('responsible_person_name')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full mb-4">
                            <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">その他（備考）</label>
                            <textarea type="text" id="note" name="note" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none h-32">{{$company->note}}</textarea>
                            @error('note')
                            <span class="text-rose-700 mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="location.href='{{ route('company.index') }}'" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">戻る</button>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('error'))
    <script>
        $(function() {
            toastr.error('{{ session("error") }}')
        });
    </script>
    @endif
</x-app-layout>
