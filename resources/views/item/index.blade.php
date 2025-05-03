@extends('layouts.layout')
@section('css')
    <title>商品一覧</title>
    <link href="{{asset('/css/list_style.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/charts-lines.js')}}" defer></script>
    <script src="{{asset('/js/charts-pie.js')}}" defer></script>
    <link href="{{asset('/css/homepage_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/homepage_scripts.js')}}"></script>
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
            <!-- Section-->
            <!-- 検索フォーム -->
            <div class="item-view-option-right">
                <!-- セール中の商品 -->
                <form action="{{route('item.index')}}" method="get" name="saleform">
                    @foreach(request()->except('page', 'sale_search') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label style="display: flex; align-items: center; gap: 0.3rem;">
                      <input type="checkbox" name="sale_search" onchange="submit()"
                          @if(!empty($inputs['sale_search']))
                              value=""
                              {{ $inputs['sale_search'] ? 'checked' : '' }}
                          @else
                              value="1"
                          @endif
                      >
                      セール中の商品
                  </label>
                </form>

                <!-- アイテムカテゴリ検索 -->
                <form action="{{route('item.index')}}" method="get">
                    @foreach(request()->except('page', 'detail_select') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="category_search"  class="dropdown-category-item" onchange="submit()">
                        <li>
                            <option class="dropdown-item bg-white" disabled selected>カテゴリー</option>
                        </li>
                        @foreach($categories as $category)
                            <li>
                            <option class="dropdown-item bg-white" value="{{$category}}"
                                @if(!empty($inputs['category_search']))
                                    {{ $category == $inputs['category_search'] ? 'selected' : '' }}
                                @endif
                            >
                                {{$category}}
                            </option>
                            </li>
                        @endforeach
                    </select>
                </form>
                <!-- 商品検索 -->
                <form method="get" action="{{ route('shop.index') }}" name="searchform">
                    @foreach(request()->except('page', 'item_name_search') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <div class="search-area">
                        <input type="text" name="item_name_search" class="search-item"
                            value="{{ request('item_name_search', '') }}" placeholder="商品名を検索する">
                        <button type="submit" class="search-icon">
                            <img src="{{ asset('image/search-icon.png') }}" alt="">
                        </button>
                    </div>
                </form>

                <!-- 表示件数 -->
                <div class="view-option-right-bottom">
                    <form action="{{route('item.index')}}" method="get" class="item-pagination-form">
                        @foreach(request()->except('page', 'paginateChangeValue') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        表示件数：<select name="paginateChangeValue"  onchange="submit()" class="item-select">
                            @foreach($pagedata['paginateArray'] as $paginate)
                                @if($pagedata['paginateChangeValue'] == $paginate)
                                    <option value="{{$paginate}}" selected>{{$paginate}}件</option>
                                @else
                                    <option value="{{$paginate}}">{{$paginate}}件</option>
                                @endif
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- ページネーション -->
            <div class="pagination">
                {{ $itemdata->appends(request()->all())->links() }}
            </div>

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-3 py-2">商品ID</th>
                      <th class="px-3 py-2">商品名</th>
                      <th class="px-3 py-2">商品カテゴリー</th>
                      <th class="px-3 py-2">商品価格</th>
                      <th class="px-3 py-2">値引き価格</th>
                      <th class="px-3 py-2">在庫数</th>
                      <th class="px-3 py-2">更新日</th>
                      <th class="px-3 py-2"></th>
                      <th class="px-3 py-2"></th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach($itemdata as $data)
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
                        <a href="{{route('item.view', ['id' => $data->id, 'from' => 'item'])}}" style="border-bottom: 1px solid #000;">
                          {{$data->item_name}}
                        </a>
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
                          <a class="btn btn-outline-dark" href="{{route('item.edit', ['id' => $data->id, 'from' => 'item'])}}">編集</a>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <form action="{{route('item.destroy', ['id' => $data->id, 'from' => 'item'])}}" method="post">
                            @csrf
                            <div class="text-center">
                                <input type="submit" class="btn btn-outline-dark" value="商品を削除">
                            </div>
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