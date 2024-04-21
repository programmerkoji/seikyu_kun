<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">企業一覧</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex">
                        <button type="button" onclick="location.href='{{ route('company.create') }}'" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">新規登録</button>
                    </div>
                    <x-pagination :pagination="$companies" />
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        企業名
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        住所
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        電話番号
                                    </th>
                                    <th scope="col" class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $company->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $company->address }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $company->tel }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button type="button" class="text-white bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-300 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">編集</button>
                                        <button type="button" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">削除</button>
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
            console.log(e);
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
