@extends('common.index')
@section('page_title')
    {{trans('admin.categories')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.categories')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.categories')}}</li>
                        </ol>
                    </div>
                    <div class="right-align">
                        <a class="waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 mt-3 btn modal-trigger" href="#add_category">{{trans('admin.add category')}}</a>
                        <div id="add_category" class="modal left-align">
                            <div class="modal-content">
                                <h4>{{trans('admin.add category')}}</h4>
                                <form method="POST" enctype="multipart/form-data" id="submit_category">
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="name3" type="text" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" name="category_name[1]" value="{{ old('category_name.1') }}" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="name4" type="text" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" name="category_name[2]" value="{{ old('category_name.2') }}" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.arabic')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <p for="color">{{trans('admin.color')}}</p>
                                            <br>
                                            <i class="material-icons prefix">account_circle</i>
                                            <input class="category_color" type="color" name="category_color" value="{{ old('color') }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="file-field input-field col s10">
                                            <div class="btn">
                                                <span>{{trans('admin.upload photo')}}</span>
                                                <input type="file" name="image" id="image-selecter" required>
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate"  type="text">
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
                        <div id="edit_category" class="modal left-align">
                            <div class="modal-content">
                                <h4>{{trans('admin.edit category')}}</h4>
                                <form method="POST" enctype="multipart/form-data" id="update_category">
                                    @csrf
                                    <input type="hidden" class="category_id" name="id" value="">
                                    <input type="hidden" class="old_image" name="old_image" value="">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input class="category_name_first" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" type="text" name="category_name[1]" value="" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input class="category_name_second" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" type="text" name="category_name[2]" value="" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.arabic')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <p for="color">{{trans('admin.color')}}</p>
                                            <br>
                                            <i class="material-icons prefix">account_circle</i>
                                            <input class="category_color" type="color" name="category_color" value="" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="file-field input-field col s10">
                                            <div class="btn">
                                                <span>{{trans('admin.upload photo')}}</span>
                                                <input type="file" name="image" id="image-selecter">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate"  type="text">
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
                    <h4 class="header">{{trans('admin.all categories')}}</h4>
                    <div class="row">
                        <div class="col s12">
                            <table id="data-table-simple" class="responsive-table display dataTableCategory" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.image')}}</th>
                                    <th>{{trans('admin.color')}}</th>
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.image')}}</th>
                                    <th>{{trans('admin.color')}}</th>
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </tfoot>
                                <tbody class="refresh">
                                @foreach($categories as $category)
                                    <tr class="{{$category->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$category->name}}</td>
                                        <td><img class="materialboxed" width="60" src="{{$category->image}}"></td>
                                        <td>{{$category->color}}</td>
                                        <td>
                                            <a class="btn-floating gradient-45deg-light-blue-cyan edit_category" data-id="{{ $category->id }}">
                                                <i class="material-icons">mode_edit</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_category')}}/" data-id="{{ $category->id }}" data-table="dataTableCategory">
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
