@extends('common.index')
@section('page_title')
    {{trans('admin.edit title')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.edit title')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.edit title')}}</li>
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
                            <h4 class="header2">{{trans('admin.edit title')}}</h4>
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
                                <form class="col s12" method="post" action="{{route('update_title', $titles[0]->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input type="text" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" name="title[1]" value="{{$titles[0]->title}}" required>
                                            <label>{{trans('admin.title')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input type="text" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" name="title[2]" value="{{$titles[1]->title}}" required>
                                            <label>{{trans('admin.title')}} ({{trans('admin.arabic')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <textarea id="textarea3" pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" class="materialize-textarea" name="sub_title[1]" required>{{$titles[0]->sub_title}}</textarea>
                                            <label for="textarea3">{{trans('admin.sub title')}} ({{trans('admin.english')}})</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <textarea id="textarea4" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" class="materialize-textarea" name="sub_title[2]" required>{{$titles[1]->sub_title}}</textarea>
                                            <label for="textarea4">{{trans('admin.sub title')}} ({{trans('admin.arabic')}})</label>
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
