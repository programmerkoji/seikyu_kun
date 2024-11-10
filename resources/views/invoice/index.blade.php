<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求一覧</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 w-full flex justify-end">
                        <form action="{{route('invoice.index')}}" method="get" class="flex flex-col md:flex-row gap-2 w-full md:w-3/4">
                            <div class="flex gap-2 w-full justify-end">
                                <select name="searchYear" class="block text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">年</option>
                                    @foreach ($years as $year)
                                    <option value="{{$year}}" {{$year===(int)$searchYear ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                                <select name="searchMonth" class="block text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">月</option>
                                    @foreach ($months as $month)
                                    <option value="{{$month}}" {{$month===(int)$searchMonth ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2 w-full justify-end">
                                <input type="search" name="keyword" value="{{Request::get('keyword')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-3/4" placeholder="キーワードで検索">
                                <button type="submit" class="focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 border border-gray-300 hover:opacity-80 w-1/4">検索</button>
                            </div>
                        </form>
                    </div>
                    <form action="{{ route('invoice.downloadMultiplePDFs') }}" id="pdf-form" method="post">
                        @csrf
                        @foreach($totalInvoiceIds as $id)
                        <input type="hidden" name="invoice_ids[]" value="{{ $id }}">
                        @endforeach
                        <div class="mb-4 flex flex-col items-start gap-1">
                            <span class="text-sm font-bold text-gray-500">総件数：<span class="text-lg">{{$invoices->total()}}</span>件</span>
                            <button type="submit" class="text-white bg-orange-500 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 hover:opacity-80" @if($invoices->total() >= 100) {{'disabled'}} @endif><i class="fa-solid fa-download mr-2"></i>PDF一括ダウンロード</button>
                        </div>
                        <div class="relative overflow-x-auto mb-4">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">
                                            企業No.
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                            企業名
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                            請求年月
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">
                                            入金ステータス
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap"></th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $key => $invoice)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            {{$invoice->id}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $invoice->company->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $invoice->billing_year }}年{{ $invoice->billing_month }}月
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button type="button" data-micromodal-trigger="modal-{{$invoice->id}}" class="{{$statusBgColors[$key]}} text-sm text-gray-50 max-w-full w-20 py-1 cursor-pointer hover:opacity-80">
                                                {{ config('constants.billingStatus')[$invoice->status] }}
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('invoice.show', ['invoice' => $invoice->id]) }}" class="text-sm underline">請求詳細へ</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('invoice.paymentDetails', ['invoice' => $invoice->id]) }}" class="text-sm underline">入金管理へ</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <x-pagination :pagination="$invoices" />
                </div>
            </div>
        </div>
    </div>
    @foreach ($invoices as $invoice)
    <div class="modal micromodal-slide" id="modal-{{$invoice->id}}" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container_wrap">
                <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-{{$invoice->id}}-title">
                    <header class="modal__header">
                        <h2 class="modal__title" id="modal-{{$invoice->id}}-title">入金ステータスの変更</h2>
                        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                    </header>
                    <main class="modal__content">
                        <form action="{{route('invoice.update', ['invoice' => $invoice->id])}}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{$invoice->title}}">
                            <div class="flex gap-2">
                                <select name="status" class="block text-sm font-medium w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach (config('constants.billingStatus') as $key => $billingStatus)
                                    <option value="{{$key}}" {{$key === $invoice->status ? 'selected' : ''}}>{{$billingStatus}}</option>
                                    @endforeach
                                </select>
                                <button class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 whitespace-nowrap">登録</button>
                            </div>
                        </form>
                    </main>
                    <footer class="modal__footer">
                        <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @if (session('message'))
    <script>
        $(function() {
            toastr.success('{{ session("message") }}')
        });
    </script>
    @endif
    @vite(['resources/js/micromodal.js'])
</x-app-layout>
