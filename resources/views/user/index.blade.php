@extends('layouts.layout')
@section('css')
    <title>Windmill Dashboard</title>
    <link href="{{asset('/css/list_style.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/charts-lines.js')}}" defer></script>
    <script src="{{asset('/js/charts-pie.js')}}" defer></script>
@endsection
@section('content')
  <body>
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Dashboard
            </h2>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">ユーザーID</th>
                      <th class="px-4 py-3">ユーザー名</th>
                      <th class="px-4 py-3">メールアドレス</th>
                      <th class="px-4 py-3">権限</th>
                      <th class="px-4 py-3">更新日時</th>
                      <th class="px-4 py-3"></th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach($userSelect as $data)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          </div>
                          <div>
                            <p class="font-semibold">{{$data->user_id}}</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$data->user_name}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$data->email}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$data->user_authority}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$data->update_at}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                      <form action="{{route('user.index')}}" method="post" name="deleteform_{{$loop->index}}">
                          @csrf
                          <input type="hidden" name="user_delete_flg" value="1">
                          <input type="hidden" name="id" value="{{$data->id}}">
                          <a href="javascript:deleteform_{{$loop->index}}.submit()">削除</a>
                      </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
              >
                <span class="flex items-center col-span-3">
                  Showing 21-30 of 100
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                      <li>
                        <button
                          class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                          aria-label="Previous"
                        >
                          <svg
                            aria-hidden="true"
                            class="w-4 h-4 fill-current"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                              clip-rule="evenodd"
                              fill-rule="evenodd"
                            ></path>
                          </svg>
                        </button>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                        >
                          1
                        </button>
                      </li>
                    </ul>
                  </nav>
                </span>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    @endsection