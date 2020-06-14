@extends('common.index')
@section('page_title')
    {{trans('admin.add product')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.add product')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.add product')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--start container-->
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12">
                        <div class="card-panel">
                            <h4 class="header2">{{trans('admin.add product')}}</h4>
                            <div class="row">
                                @if(session()->has('message'))
                                    <div id="card-alert" class="card gradient-45deg-green-teal">
                                        <div class="card-content white-text">
                                            <p>
                                                <i class="material-icons">check</i> {{session()->get('message')}}</p>
                                        </div>
                                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @elseif(session()->has('error'))
                                    <div id="card-alert" class="card gradient-45deg-red-pink">
                                        <div class="card-content white-text">
                                            <p>
                                                <i class="material-icons">error</i> {{session()->get('error')}}</p>
                                        </div>
                                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @endif
                                <form class="col s12" method="post" action="{{route('store_product')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id type="text" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" name="product_name[1]" value="{{ old('product_name.1') }}" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input type="text" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" name="product_name[2]" value="{{ old('product_name.2') }}" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.arabic')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="file-field input-field col s10">
                                            <div class="btn">
                                                <span>{{trans('admin.upload photo')}}</span>
                                                <input type="file" name="product_image" id="image-selecter" required>
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate"  type="text">
                                            </div>
                                        </div>
                                        <div class="col s2">
                                            <img id="image_preview_container" src="{{ asset('images/product/avatar_product.png') }}"
                                                 alt="preview image" style="max-height: 100px;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input type="text" pattern="^[0-9.]+$" name="discount" value="{{ old('discount') }}" required>
                                            <label>{{trans('admin.discount')}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input type="text" pattern="^[0-9.]+$" name="price" value="{{ old('price') }}" required>
                                            <label>{{trans('admin.price')}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select name="category_id">
                                                <option value="" disabled selected>{{trans('admin.choose category')}}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            <label>{{trans('admin.select category')}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select name="brand_id">
                                                <option value="" disabled selected>{{trans('admin.choose brand')}}</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            <label>{{trans('admin.select brand')}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">{{trans('admin.submit')}}
                                                <i class="material-icons right">send</i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->
    </section>

@endsection
