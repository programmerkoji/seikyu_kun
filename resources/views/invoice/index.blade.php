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
                    <div class="relative overflow-x-auto mb-4">
                        <form action="{{ route('invoice.downloadMultiplePDFs') }}" id="pdf-form" method="post">
                            @csrf
                            @foreach($totalInvoiceIds as $id)
                                <input type="hidden" name="invoice_ids[]" value="{{ $id }}">
                            @endforeach
                            <div class="mb-4 flex flex-col items-start gap-1">
                                <span class="text-sm font-bold text-gray-500">総件数：<span class="text-lg">{{$invoices->total()}}</span>件</span>
                                <button type="submit" class="text-white bg-orange-500 hover:bg-orange-800focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 hover:opacity-80" @if($invoices->total() >= 100) {{'disabled'}} @endif><i class="fa-solid fa-download mr-2"></i>PDF一括ダウンロード</button>
                            </div>
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            企業名
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            請求年
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            請求月
                                        </th>
                                        <th scope="col" class="px-6 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $key => $invoice)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $invoice->company->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $invoice->billing_year }}年
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $invoice->billing_month }}月
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex gap-2 items-center">
                                                <button type="button" onclick="location.href='{{ route('invoice.show', ['invoice' => $invoice->id]) }}'" class="text-white bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-300 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">詳細</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <x-pagination :pagination="$invoices" />
                </div>
            </div>
        </div>
    </div>
    @if (session('message'))
    <script>
        $(function() {
            toastr.success('{{ session("message") }}')
        });
    </script>
    @endif
</x-app-layout>
