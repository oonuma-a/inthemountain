@extends('layouts.layout')
@section('css')
    <title>Windmill Dashboard</title>
    <link href="{{asset('css/list_style.css')}}" rel="stylesheet" />
    <script src="{{asset('js/charts-lines.js')}}" defer></script>
    <script src="{{asset('js/charts-pie.js')}}" defer></script>
@endsection
@section('content')
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              ユーザー一覧
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
                        @if($data->user_authority == 1)
                          <p class="px-4 py-3 text-sm">管理者</p>
                        @else
                          <p class="px-4 py-3 text-sm">一般</p>
                        @endif
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$data->update_at}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                      <form action="{{route('user.index')}}" method="post" name="deleteform_{{$loop->index}}">
                          @csrf
                          <input type="hidden" name="user_delete_flg" value="1">
                          <input type="hidden" name="id" value="{{$data->id}}">
                          <a class="btn btn-outline-dark" href="javascript:deleteform_{{$loop->index}}.submit()">削除</a>
                      </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    @endsection