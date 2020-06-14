@extends('common.index')
@section('page_title')
{{trans('admin.images')}}
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
                    <h5 class="breadcrumbs-title">{{trans('admin.images')}}</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                        <li class="active">{{trans('admin.images')}}</li>
                    </ol>
                </div>
                <div class="right-align">
                    <a class="waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 mt-3 btn modal-trigger" href="#add_image">{{trans('admin.add image')}}</a>
                    <div id="add_image" class="modal left-align">
                        <div class="modal-content">
                            <h4>{{trans('admin.add image')}}</h4>
                            <form method="POST" enctype="multipart/form-data" id="submit_image">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$id}}">
                                <div class="row">
                                    <div class="file-field input-field col s10">
                                        <div class="btn">
                                            <span>{{trans('admin.upload photo')}}</span>
                                            <input type="file" name="image[]" id="image-selecter" multiple>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn cyan waves-effect waves-light right" type="submit">{{trans('admin.submit')}}
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
    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="divider"></div>
            <!--DataTables example-->
            <div id="table-datatables">
                <h4 class="header">{{trans('admin.all images')}}</h4>
                <div class="row">
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display dataTableImage" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{trans('admin.image')}}</th>
                                <th>{{trans('admin.delete')}}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>{{trans('admin.image')}}</th>
                                <th>{{trans('admin.delete')}}</th>
                            </tr>
                            </tfoot>
                            <tbody class="refresh">
                            @foreach($images as $image)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><img class="materialboxed" width="60" src="{{asset($image->image)}}"></td>
                                <td>
                                    <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_image')}}/" data-id="{{ $image->id }}" data-table="dataTableImage">
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
