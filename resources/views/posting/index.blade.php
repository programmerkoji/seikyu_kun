<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">掲載一覧</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-between">
                        <div>
                            <button type="button" onclick="location.href='{{ route('posting.create') }}'" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">新規登録</button>
                        </div>
                        <form action="{{route('posting.index')}}" method="get" class="flex items-center gap-2">
                            <input type="search" name="keyword" value="{{Request::get('keyword')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="キーワードで検索">
                            {{-- <button type="submit" class="focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 border border-gray-300 hover:opacity-80">クリア</button> --}}
                        </form>

                    </div>
                    <x-pagination :pagination="$postings" />
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        企業名
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        プラン
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        掲載内容<br>（キャンペーンなど）
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        掲載開始日
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        掲載期間
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        部数
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">
                                        掲載料金<br>（単価）
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($postings as $posting)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $posting->company->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $posting->product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $posting->content }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $posting->posting_start }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $posting->posting_term }}週間
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $posting->quantity }}部
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        {{ number_format($posting->price) }}円
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex gap-2">
                                            <button type="button" onclick="location.href='{{ route('posting.edit', ['posting' => $posting->id]) }}'" class="focus:outline-none text-white bg-indigo-600 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">編集</button>
                                            <form id="delete_{{ $posting->id }}" action="{{route('posting.destroy', ['posting' => $posting->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" data-id="{{ $posting->id }}" onclick="deletePost(this)" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">削除</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
