@extends('layouts.layout')
@section('css')
    <title>Windmill Dashboard</title>
    <link href="{{asset('css/list_style.css')}}" rel="stylesheet" />
    <script src="{{asset('js/charts-lines.js')}}" defer></script>
    <script src="{{asset('js/charts-pie.js')}}" defer></script>
@endsection
@section('content')
  <body>
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              商品一覧
            </h2>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">商品ID</th>
                      <th class="px-4 py-3">商品名</th>
                      <th class="px-4 py-3">商品カテゴリー</th>
                      <th class="px-4 py-3">商品価格</th>
                      <th class="px-4 py-3">値引き価格</th>
                      <th class="px-4 py-3">在庫数</th>
                      <th class="px-4 py-3">更新日</th>
                      <th class="px-4 py-3"></th>
                      <th class="px-4 py-3"></th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach($selectItem as $data)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          </div>
                          <div>
                            <p class="font-semibold">{{$data->id}}</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$data->item_name}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$data->item_category}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$data->price}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$data->discount_price}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{$data->item_number}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$data->update_at}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <form action="{{route('item.edit')}}" method="get" name="itemUpdateForm_{{$loop->index}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="hidden" name="item_index_edit" value="1">
                            <div class="text-center">
                              <a class="btn btn-outline-dark" href="javascript:itemUpdateForm_{{$loop->index}}.submit()">編集</a>
                            </div>
                        </form>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        
                        <form action="{{route('item.index')}}" method="post" name="itemDeleteForm_{{$loop->index}}">
                            @csrf
                            <input type="hidden" name="item_delete_flg" value="1">
                            <input type="hidden" name="item_index_delete" value="1">
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <div class="text-center"><a class="btn btn-outline-dark" href="javascript:itemDeleteForm_{{$loop->index}}.submit()">削除</a></div>
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