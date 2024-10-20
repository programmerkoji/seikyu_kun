<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">入金詳細 - 新規登録</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg text-gray-600 leading-tight mb-4">登録先請求情報</h3>
                    <dl class="flex flex-col gap-2 md:flex-row">
                        <div>
                            <dt class="text-sm font-medium text-gray-900 dark:text-white mb-1">企業名</dt>
                            <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                {{$invoice->company->name}}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-900 dark:text-white mb-1">請求タイトル</dt>
                            <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                {{$invoice->title}}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-900 dark:text-white mb-1">請求年月</dt>
                            <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                {{$invoice->billing_year}}年{{$invoice->billing_month}}月
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-900 dark:text-white mb-1">請求金額（税抜）</dt>
                            <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                円
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @error('selectedInvoiceId')
                <div class="px-6 pt-6">
                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                </div>
                @enderror
                <div class="p-6 text-gray-900">
                    <form action="{{route('paymentDetail.store')}}" method="post" class="mb-4">
                        @csrf
                        <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                        <div>
                            <div class="flex flex-col gap-4 md:flex-row md:justify-between mb-6">
                                <div class="md:w-1/2">
                                    <label for="payment_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">入金日</label>
                                    <div class="w-full flex items-center gap-1">
                                        <input type="text" id="payment_date" name="payment_date" value="{{old('payment_date')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                    @error('payment_date')
                                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="md:w-1/2">
                                    <label for="payment_category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">入金区分</label>
                                    <div class="flex items-center gap-2">
                                        <select name="payment_category_id" class="block text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value=""></option>
                                            @foreach ($paymentCategories as $paymentCategory)
                                            <option value="{{$paymentCategory->id}}" @if(old('payment_category_id') == $paymentCategory->id) selected @endif>{{$paymentCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('payment_category_id')
                                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="md:w-1/2">
                                    <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">金額</label>
                                    <div class="w-full flex items-center gap-1">
                                        <input type="text" id="amount" name="amount" value="{{old('amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                    @error('amount')
                                    <span class="text-rose-700 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full mb-4">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">その他（備考）</label>
                                <textarea type="text" id="note" name="note" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none h-24">{{old('note')}}</textarea>
                                @error('note')
                                <span class="text-rose-700 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="location.href='{{ route('invoice.index') }}'" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">請求一覧へ</button>
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
