@extends('common.index')
@section('page_title')
    {{trans('admin.add notification')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.add notification')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.add notification')}}</li>
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
                            <h4 class="header2">{{trans('admin.add notification')}}</h4>
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
                                <form class="col s12" method="post" action="{{route('store_notification')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select class="form-control" name="send" id="selectOption">
                                                <option value="1">{{trans('admin.all')}}</option>
                                                <option value="2">{{trans('admin.someone by email')}}</option>
                                            </select>
                                            <label for="first_name">{{trans('admin.send to')}}</label>
                                        </div>
                                    </div>
                                    <div class="row hide timepicker" id="show_hide">
                                        <div class="input-field col s12">
                                            <select class="form-control browser-default searchOption2" name="email" style="width: 100%">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                                @endforeach
                                            </select>
                                            <!-- <label for="first_name">{{trans('admin.email')}}</label> -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="text" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" name="notification_name[1]" maxlength="80" value="{{old('notification_name.1')}}" required>
                                            <label for="first_name">{{trans('admin.title')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="text" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" name="notification_name[2]" maxlength="80" value="{{old('notification_name.2')}}" required>
                                            <label for="first_name">{{trans('admin.title')}} ({{trans('admin.arabic')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="textarea1" class="materialize-textarea" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" name="notification_content[1]" maxlength="100" required>{{old('notification_content.1')}}</textarea>
                                            <label for="textarea1">{{trans('admin.content')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="textarea1" class="materialize-textarea" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" name="notification_content[2]" maxlength="100" required>{{old('notification_content.2')}}</textarea>
                                            <label for="textarea1">{{trans('admin.content')}} ({{trans('admin.arabic')}})</label>
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
