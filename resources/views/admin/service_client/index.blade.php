@extends('common.index')
@section('page_title')
    {{getServiceName($id)->service_name}}
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
                        <h5 class="breadcrumbs-title">{{getServiceName($id)->service_name}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{getServiceName($id)->service_name}}</li>
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
                    <h4 class="header">{{trans('admin.all')}} {{getServiceName($id)->service_name}}</h4>
                    <div class="row">
                        <div class="col s12">
                            <table id="data-table-simple" class="responsive-table display datatableServiceClient centered" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.email')}}</th>
                                    <th>{{trans('admin.phone')}}</th>
                                    <th>{{trans('admin.image')}}</th>
                                    <th>{{trans('admin.users')}}</th>
                                    <th>{{trans('admin.orders')}}</th>
                                    <th>{{trans('admin.products')}}</th>
                                    <th>{{trans('admin.reminders')}}</th>
                                    <th>{{trans('admin.users')}}</th>
                                    <th>{{trans('admin.orders')}}</th>
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('admin.name')}}</th>
                                    <th>{{trans('admin.email')}}</th>
                                    <th>{{trans('admin.phone')}}</th>
                                    <th>{{trans('admin.image')}}</th>
                                    <th>{{trans('admin.users')}}</th>
                                    <th>{{trans('admin.orders')}}</th>
                                    <th>{{trans('admin.products')}}</th>
                                    <th>{{trans('admin.reminders')}}</th>
                                    <th>{{trans('admin.users')}}</th>
                                    <th>{{trans('admin.orders')}}</th>
                                    <th>{{trans('admin.edit')}}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </tfoot>
                                <tbody class="refresh">
                                @foreach($serviceClient as $service)
                                <tr class="{{$service->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$service->name}}</td>
                                    <td>{{$service->email}}</td>
                                    <td>{{$service->phone}}</td>
                                    <td><img class="materialboxed" width="60" src="{{asset($service->image)}}"></td>
                                    <td>{{$service->users}}</td>
                                    <td>{{$service->orders}}</td>
                                    <td>{{$service->products}}</td>
                                    <td>{{$service->reminders}}</td>
                                    <td>
                                        <a class="btn waves-effect waves-light gradient-45deg-green-teal gradient-shadow" href="{{url(route('admin_users', $service->id))}}">
                                            {{trans('admin.users')}}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn waves-effect waves-light gradient-45deg-amber-amber gradient-shadow" href="{{url(route('admin_orders', $service->id))}}">
                                            {{trans('admin.orders')}}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan" href="{{url(route('edit_service_client', $service->id))}}">
                                            <i class="material-icons">mode_edit</i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_service_client')}}/" data-id="{{ $service->id }}" data-table="datatableServiceClient">
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
