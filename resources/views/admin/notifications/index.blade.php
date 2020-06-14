@extends('common.index')
@section('page_title')
    {{trans('admin.notifications')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.notifications')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.notifications')}}</li>
                        </ol>
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
                    <h4 class="header">{{trans('admin.notifications')}}</h4>
                    <div class="row">
                        <div class="col s12">
                            <table id="data-table-simple" class="responsive-table display datatableNot" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ trans('admin.name') }}</th>
                                    <th>{{ trans('admin.content') }}</th>
                                    <th>{{ trans('admin.image') }}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ trans('admin.name') }}</th>
                                    <th>{{ trans('admin.content') }}</th>
                                    <th>{{ trans('admin.image') }}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </tfoot>
                                <tbody class="refresh">
                                @foreach($notifications as $notification)
                                <tr class="{{$notification->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$notification->name}}</td>
                                    <td>{{$notification->content}}</td>
                                    <td><img class="materialboxed" width="60" src="{{asset($notification->image)}}"></td>
                                    <td>
                                        <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_notification')}}/" data-id="{{ $notification->id }}" data-table="datatableNot">
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
