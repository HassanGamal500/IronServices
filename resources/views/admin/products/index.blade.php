@extends('common.index')
@section('page_title')
{{trans('admin.products')}}
@endsection
@section('content')
<section id="content">
    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper">
        <!-- Search for small screen -->
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">{{trans('admin.products')}}</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                        <li class="active">{{trans('admin.products')}}</li>
                    </ol>
                </div>
                <div class="right-align">
                    <a class="waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 mt-3" href="{{url('add_product')}}">{{trans('admin.add product')}}</a>
                </div>
            </div>
        </div>
    </div>
    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="divider"></div>
            <!--DataTables example-->
            <div id="table-datatables">
                <h4 class="header">{{trans('admin.all products')}}</h4>
                <div class="row">
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display datatableProduct" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{trans('admin.name')}}</th>
                                <th>{{trans('admin.image')}}</th>
                                <th>{{trans('admin.price')}}</th>
                                <th>{{trans('admin.discount')}}</th>
                                <th>{{trans('admin.titles')}}</th>
                                <th>{{trans('admin.images')}}</th>
                                <th>{{trans('admin.edit')}}</th>
                                <th>{{trans('admin.delete')}}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>{{trans('admin.name')}}</th>
                                <th>{{trans('admin.image')}}</th>
                                <th>{{trans('admin.price')}}</th>
                                <th>{{trans('admin.discount')}}</th>
                                <th>{{trans('admin.titles')}}</th>
                                <th>{{trans('admin.images')}}</th>
                                <th>{{trans('admin.edit')}}</th>
                                <th>{{trans('admin.delete')}}</th>
                            </tr>
                            </tfoot>
                            <tbody class="refresh">
                            @foreach($products as $product)
                            <tr class="{{$product->product_id}}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$product->product_name}}</td>
                                <td><img class="materialboxed" width="60" src="{{asset($product->product_image)}}"></td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->discount}}</td>
                                <td>
                                    <a class="btn waves-effect waves-light gradient-45deg-green-teal gradient-shadow" href="{{url(route('all_titles', $product->product_id))}}">
                                        {{trans('admin.titles')}}
                                    </a>
                                </td>
                                <td>
                                    <a class="btn waves-effect waves-light gradient-45deg-amber-amber gradient-shadow" href="{{url(route('all_images', $product->product_id))}}">
                                        {{trans('admin.images')}}
                                    </a>
                                </td>
                                <td>
                                    <a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan" href="{{url(route('edit_product', $product->product_id))}}">
                                        <i class="material-icons">mode_edit</i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_product')}}/" data-id="{{ $product->product_id }}" data-table="datatableProduct">
                                        <i class="material-icons">clear</i>
                                    </a>
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
    <!--end container-->
</section>

@endsection
