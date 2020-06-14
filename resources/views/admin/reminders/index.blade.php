@extends('common.index')
@section('page_title')
{{trans('admin.reminders')}}
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
                    <h5 class="breadcrumbs-title">{{trans('admin.reminders')}}</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                        <li class="active">{{trans('admin.reminders')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--start container-->
    <div class="container">
        <div class="section">
            <!--Multicolor with icon tabs-->
            <div id="multi-color-tab" class="section">
                <h4 class="header">{{trans('admin.reminders')}}</h4>
                <div class="row">
                    <div class="col s12">
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs tab-demo-active z-depth-1">
                                    <li class="tab col s4"><a class="white-text gradient-45deg-red-pink waves-effect waves-light active" href="#sapien1">{{trans('admin.today')}}</a>
                                    </li>
                                    <li class="tab col s4"><a class="white-text gradient-45deg-amber-amber waves-effect waves-light" href="#activeone1">{{trans('admin.three day')}}</a>
                                    </li>
                                    <li class="tab col s4"><a class="white-text gradient-45deg-green-teal waves-effect waves-light" href="#vestibulum1">{{trans('admin.seven day')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col s12">
                                <div id="sapien1" class="col s12  red lighten-4">
                                    <!--DataTables example-->
                                    <div id="table-datatables">
                                        <div class="row">
                                            <div class="col s12">
                                                <table class="responsive-table display" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>{{trans('admin.name')}}</th>
                                                        <th>{{trans('admin.title')}}</th>
                                                        <th>{{trans('admin.date')}}</th>
                                                        <th>{{trans('admin.amount')}}</th>

                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>{{trans('admin.name')}}</th>
                                                        <th>{{trans('admin.title')}}</th>
                                                        <th>{{trans('admin.date')}}</th>
                                                        <th>{{trans('admin.amount')}}</th>
                                                    </tr>
                                                    </tfoot>
                                                    <tbody class="refresh">
                                                    @foreach($remindersNow as $reminder)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$reminder->name}}</td>
                                                        <td>{{$reminder->reminder_title}}</td>
                                                        <td>{{$reminder->reminder_date}}</td>
                                                        <td>{{$reminder->reminder_amount}}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="activeone1" class="col s12 amber lighten-4">
                                    <!--DataTables example-->
                                    <div id="table-datatables">
                                        <div class="row">
                                            <div class="col s12">
                                                <table class="responsive-table display" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>{{trans('admin.name')}}</th>
                                                        <th>{{trans('admin.title')}}</th>
                                                        <th>{{trans('admin.date')}}</th>
                                                        <th>{{trans('admin.amount')}}</th>

                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>{{trans('admin.name')}}</th>
                                                        <th>{{trans('admin.title')}}</th>
                                                        <th>{{trans('admin.date')}}</th>
                                                        <th>{{trans('admin.amount')}}</th>
                                                    </tr>
                                                    </tfoot>
                                                    <tbody class="refresh">
                                                    @foreach($remindersThree as $reminder)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$reminder->name}}</td>
                                                        <td>{{$reminder->reminder_title}}</td>
                                                        <td>{{$reminder->reminder_date}}</td>
                                                        <td>{{$reminder->reminder_amount}}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="vestibulum1" class="col s12  green lighten-4">
                                    <!--DataTables example-->
                                    <div id="table-datatables">
                                        <div class="row">
                                            <div class="col s12">
                                                <table class="responsive-table display" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>{{trans('admin.name')}}</th>
                                                        <th>{{trans('admin.title')}}</th>
                                                        <th>{{trans('admin.date')}}</th>
                                                        <th>{{trans('admin.amount')}}</th>

                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>{{trans('admin.name')}}</th>
                                                        <th>{{trans('admin.title')}}</th>
                                                        <th>{{trans('admin.date')}}</th>
                                                        <th>{{trans('admin.amount')}}</th>
                                                    </tr>
                                                    </tfoot>
                                                    <tbody class="refresh">
                                                    @foreach($remindersSeven as $reminder)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$reminder->name}}</td>
                                                        <td>{{$reminder->reminder_title}}</td>
                                                        <td>{{$reminder->reminder_date}}</td>
                                                        <td>{{$reminder->reminder_amount}}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end container-->
</section>

@endsection
