<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求 - 新規登録</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @error('selectedInvoiceId')
                <div class="px-6 pt-6">
                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                </div>
                @enderror
                <div class="p-6 text-gray-900">
                    <form action="{{route('invoice.store')}}" method="post" class="mb-4">
                        @csrf
                        @if ($invoiceDatas->isNotEmpty())
                        <div class="mb-4">
                            <p class="py-2 px-4 bg-slate-400 text-white text-md font-medium rounded-sm">下記のいずれかの方法で登録してください</p>
                        </div>
                        <div class="mb-4 js_accordion_btn">
                            <p class="py-2 px-4 border-b text-md font-medium">① すでに登録のある請求に紐づける</p>
                        </div>
                        <div class="pl-8 js_accordion_conts">
                            @foreach ($invoiceDatas as $key => $invoiceData)
                            <div class="flex items-center mb-4 border-b pb-4">
                                <input id="invoiceRadio{{$key}}" type="radio" value="{{$invoiceData->id}}" name="selectedInvoiceId" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="invoiceRadio{{$key}}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer hover:opacity-70">
                                    <div class="flex mb-1">
                                        <div>{{$invoiceData->billing_year}}年</div>
                                        <div>{{$invoiceData->billing_month}}月請求分</div>
                                    </div>
                                    <div>請求タイトル： {{$invoiceData->title}}</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-4 js_accordion_btn">
                            <p class="py-2 px-4 border-b text-md font-medium">② 請求を新規登録する</p>
                        </div>
                        <div class="js_accordion_conts">
                            <div class="flex flex-col gap-4 md:flex-row md:justify-between mb-6">
                                <div class="md:w-1/2">
                                    <label for="billing_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求年</label>
                                    <div class="flex items-center gap-2">
                                        <input type="text" id="billing_year" name="invoice[billing_year]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{old('invoice.billing_year', '2024')}}">
                                        <span class="whitespace-nowrap">年</span>
                                    </div>
                                    @error('invoice.billing_year')
                                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="md:w-1/2">
                                    <label for="billing_month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求月</label>
                                    <div class="flex items-center gap-2">
                                        <select name="invoice[billing_month]" class="block text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value=""></option>
                                            @foreach (config('constants.month') as $value)
                                            <option value="{{$value}}" @if((int)old('invoice.billing_month')===(int)$value) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <span class="whitespace-nowrap">月</span>
                                    </div>
                                    @error('invoice.billing_month')
                                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full mb-4">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">タイトル</label>
                                <input type="text" id="title" name="invoice[title]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{old('invoice.title')}}">
                                @error('invoice.title')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full mb-4">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">その他（備考）</label>
                                <textarea type="text" id="note" name="invoice[note]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none h-32">{{old('invoice.note')}}</textarea>
                                @error('invoice.note')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @else
                        <div>
                            <div class="flex flex-col gap-4 md:flex-row md:justify-between mb-6">
                                <div class="md:w-1/2">
                                    <label for="billing_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求年</label>
                                    <div class="flex items-center gap-2">
                                        <input type="text" id="billing_year" name="invoice[billing_year]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{old('invoice.billing_year', '2024')}}">
                                        <span class="whitespace-nowrap">年</span>
                                    </div>
                                    @error('invoice.billing_year')
                                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="md:w-1/2">
                                    <label for="billing_month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求月</label>
                                    <div class="flex items-center gap-2">
                                        <select name="invoice[billing_month]" class="block text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value=""></option>
                                            @foreach (config('constants.month') as $value)
                                            <option value="{{$value}}" @if((int)old('invoice.billing_month')===(int)$value) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <span class="whitespace-nowrap">月</span>
                                    </div>
                                    @error('invoice.billing_month')
                                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full mb-4">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">タイトル</label>
                                <input type="text" id="title" name="invoice[title]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{old('invoice.title')}}">
                                @error('invoice.title')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full mb-4">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">その他（備考）</label>
                                <textarea type="text" id="note" name="invoice[note]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none h-32">{{old('invoice.note')}}</textarea>
                                @error('invoice.note')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="location.href='{{ route('posting.create') }}'" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">掲載へ戻る</button>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let jsAccordionBtn = document.querySelectorAll('.js_accordion_btn')
        jsAccordionBtn.forEach(function(element) {
            element.addEventListener('click', function(e) {
                let eleHeight = element.nextElementSibling;
                if(element.classList.contains('is_open')){
                    eleHeight.style.height = '0';
                } else {
                    eleHeight.style.height = eleHeight.scrollHeight + 'px';
                }
                element.classList.toggle('is_open');
            });
        });
    </script>
</x-app-layout>
