<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求詳細</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-4 md:flex-row mb-4">
                        <dl class="w-full">
                            <dt class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">企業名</dt>
                            <dd class="block mb-2 text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$invoice->company->name}}</dd>
                        </dl>
                        <dl class="w-full">
                            <dt class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求年</dt>
                            <dd class="block mb-2 text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$invoice->billing_year}}年</dd>
                        </dl>
                        <dl class="w-full">
                            <dt class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">請求月</dt>
                            <dd class="block mb-2 text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$invoice->billing_month}}月</dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">掲載詳細</p>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                            プラン
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                            掲載内容
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                            掲載開始日
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                            掲載期間
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                            掲載料金
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice->postings as $posting)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{$posting->product->name}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{$posting->content}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{$posting->posting_start}}〜
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{$posting->posting_term}}週間
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{number_format($posting->price)}}円
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <dl class="w-full mb-4">
                        <dt class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">その他（備考）</dt>
                        <dd class="block mb-2 text-sm font-medium w-full bg-gray-50 border-b border-gray-400 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$invoice->note}}</dd>
                    </dl>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="location.href='{{ route('invoice.index') }}'" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">戻る</button>
                        <button type="button" onclick="location.href='{{ route('invoice.edit', ['invoice' => $invoice->id]) }}'" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">編集</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
