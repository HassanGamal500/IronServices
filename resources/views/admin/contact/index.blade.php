@extends('common.index')
@section('page_title')
    {{trans('admin.contact')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.contact')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.contact')}}</li>
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
                    <h4 class="header">{{trans('admin.contact')}}</h4>
                    <div class="row">
                        <div class="col s12">
                            <table id="data-table-simple" class="responsive-table display datatableContact" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ trans('admin.name') }}</th>
                                    <th>{{ trans('admin.message') }}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ trans('admin.name') }}</th>
                                    <th>{{ trans('admin.message') }}</th>
                                    <th>{{trans('admin.delete')}}</th>
                                </tr>
                                </tfoot>
                                <tbody class="refresh">
                                @foreach($contacts as $contact)
                                <tr class="{{$contact->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$contact->name}}</td>
                                    <td>{{$contact->message}}</td>
                                    <td>
                                        <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('contact_delete')}}/" data-id="{{ $contact->id }}" data-table="datatableContact">
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
