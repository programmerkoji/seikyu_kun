<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">入金管理 - 詳細</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg text-gray-600 leading-tight mb-4">登録先請求情報</h3>
                    <dl>
                        <div class="flex flex-col gap-2 md:flex-row mb-3">
                            <div class=" flex-shrink">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1">企業No.</dt>
                                <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    {{$invoice->company->id}}
                                </dd>
                            </div>
                            <div class="flex-grow">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1">企業名</dt>
                                <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    {{$invoice->company->name}}
                                </dd>
                            </div>
                            <div class="flex-shrink">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1">入金ステータス</dt>
                                <dd class="md:p-2.5 flex justify-center items-center">
                                    <span class="{{config('constants.statusBgColors')[$invoice->status]}} text-sm text-gray-50 max-w-full md:w-20 py-1 text-center block">
                                        {{ config('constants.billingStatus')[$invoice->status] }}
                                    </span>
                                </dd>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 md:flex-row">
                            <div class="flex-shrink">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1">請求年月</dt>
                                <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    {{$invoice->billing_year}}年{{$invoice->billing_month}}月
                                </dd>
                            </div>
                            <div class="flex-grow">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1">請求タイトル</dt>
                                <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    {{$invoice->title}}
                                </dd>
                            </div>
                            <div class="flex-shrink">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1 md:text-right">金額（税抜）</dt>
                                <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-right">
                                    {{$totalPriceData['formattedTotalPrice']}}円
                                </dd>
                            </div>
                            <div class="flex-shrink">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1 md:text-right">消費税</dt>
                                <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-right">
                                    {{$totalPriceData['formattedTaxAmount']}}円
                                </dd>
                            </div>
                            <div class="flex-shrink">
                                <dt class="px-2.5 text-sm font-medium text-gray-900 dark:text-white mb-1 md:text-right">請求金額</dt>
                                <dd class="block text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-right">
                                    {{$totalPriceData['formattedTotalPriceIncludingTax']}}円
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex">
                        <h3 class="font-semibold text-lg text-gray-600 leading-tight">入金一覧</h3>
                    </div>
                    <div class="relative overflow-x-auto mb-4">
                        @if (isset($paymentDetails))
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        入金日
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        入金種類
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">
                                        入金金額
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentDetails as $key => $paymentDetail)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{$paymentDetail->payment_date}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{$paymentCategoryNames[$key]}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        {{number_format($paymentDetail->amount)}}円
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="font-semibold text-sm text-orange-600 leading-tight">まだ入金の記録がありません。</p>
                        @endif
                    </div>
                    <div>
                        <button type="button" onclick="location.href='{{ route('invoice.paymentDetailCreate', ['invoice' => $invoice->id]) }}'" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">入金登録</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもよいですか？')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
    @if (session('message'))
    <script>
        $(function() {
            toastr.success('{{ session("message") }}')
        });
    </script>
    @endif
</x-app-layout>
