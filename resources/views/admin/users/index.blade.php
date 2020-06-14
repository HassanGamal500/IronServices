@extends('common.index')
@section('page_title')
    {{trans('admin.users')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.users')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.users')}}</li>
                        </ol>
                    </div>
                    @if(auth()->guard('admin')->user()->id != 1)
                    <div class="right-align">
                        <a class="waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 mt-3" href="{{url('add_user')}}">{{trans('admin.add user')}}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!--start container-->
        <div class="container">
            <div class="section">
                <div class="divider"></div>
                <!--DataTables example-->
                <div id="table-datatables">
                    <h4 class="header">{{trans('admin.all user')}}</h4>
                    <div class="row">
                        <div class="col s12">
                            <table id="data-table-simple" class="responsive-table display datatableUser" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.email')}}</th>
                                    <th>{{trans('admin.phone')}}</th>
                                    <th>{{trans('admin.image')}}</th>
                                    @if(auth()->guard('admin')->user()->id != 1)
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.email')}}</th>
                                    <th>{{trans('admin.phone')}}</th>
                                    <th>{{trans('admin.image')}}</th>
                                    @if(auth()->guard('admin')->user()->id != 1)
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                    @endif
                                </tr>
                                </tfoot>
                                <tbody class="refresh">
                                @foreach($users as $user)
                                <tr class="{{$user->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td><img class="materialboxed" width="60" src="{{asset($user->image)}}"></td>
                                    @if(auth()->guard('admin')->user()->id != 1)
                                    <td>
                                        <a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan" href="{{url(route('edit_user', $user->id))}}">
                                            <i class="material-icons">mode_edit</i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_user')}}/" data-id="{{ $user->id }}"  data-table="datatableUser">
                                            <i class="material-icons">clear</i>
                                        </a>
                                    </td>
                                    @endif
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
