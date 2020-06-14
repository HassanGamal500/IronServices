@extends('common.index')
@section('page_title')
    {{trans('admin.areas')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.areas')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.areas')}}</li>
                        </ol>
                    </div>
                    <div class="right-align">
                        <a class="waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 mt-3 btn modal-trigger" href="#add_area">{{trans('admin.add area')}}</a>
                        <div id="add_area" class="modal left-align">
                            <div class="modal-content">
                                <h4>{{trans('admin.add area')}}</h4>
                                <form method="POST" enctype="multipart/form-data" id="submit_area">
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="name3" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" type="text" name="area_name[1]" value="{{ old('area_name.1') }}" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="name4" type="text" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" name="area_name[2]" value="{{ old('area_name.2') }}" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.arabic')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select name="city_id">
                                                <option value="" disabled selected>{{trans('admin.choose city')}}</option>
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                            <label>{{trans('admin.select city')}}</label>
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
                        <div id="edit_area" class="modal left-align">
                            <div class="modal-content">
                                <h4>{{trans('admin.edit city')}}</h4>
                                <form method="POST" enctype="multipart/form-data" id="update_area">
                                    @csrf
                                    <input type="hidden" class="area_id" name="id" value="">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input class="area_name_first" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" type="text" name="area_name[1]" value="" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input class="area_name_second" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" type="text" name="area_name[2]" value="" required>
                                            <label>{{trans('admin.name')}} ({{trans('admin.arabic')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select name="city_id">
                                                <option value="" disabled selected>{{trans('admin.choose city')}}</option>
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                            <label>{{trans('admin.select city')}}</label>
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
                    <h4 class="header">{{trans('admin.all areas')}}</h4>
                    <div class="row">
                        <div class="col s12">
                            <table id="data-table-simple" class="responsive-table display dataTableArea" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.city')}}</th>
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.city')}}</th>
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </tfoot>
                                <tbody class="refresh">
                                @foreach($areas as $area)
                                    <tr class="{{$area->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$area->name}}</td>
                                        <td>{{$area->city_name}}</td>
                                        <td>
                                            <a class="btn-floating gradient-45deg-light-blue-cyan edit_area" data-id="{{ $area->id }}">
                                                <i class="material-icons">mode_edit</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_area')}}/" data-id="{{ $area->id }}" data-table="dataTableArea">
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
