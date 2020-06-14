@extends('common.index')
@section('page_title')
    {{trans('admin.detail invoice')}}
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
                        <h5 class="breadcrumbs-title">{{trans('admin.detail invoice')}}</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{url('/')}}">{{trans('admin.dashboard')}}</a></li>
                            <li class="active">{{trans('admin.detail invoice')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--start container-->
        <div class="container">
            <div id="invoice">
                <div class="invoice-header">
                    <div class="row section">
                        <div class="col s12 m6 l6">
                            <img src="{{asset($orders[0]->administration->logo)}}" width="120px" alt="company logo">
                            <p>{{trans('admin.to')}},
                                <br/>
                                <span class="strong">{{$orders[0]->name}}</span>
                                <br/>
                                <span>{{$orders[0]->street_number}}, {{$orders[0]->address_building}}, {{$orders[0]->floor_name}}, {{$orders[0]->landmark}},</span>
                                <br/>
                                <span>{{$orders[0]->area_name}}, {{$orders[0]->city_name}}</span>
                                <br/>
                                <span>{{$orders[0]->phone}}</span>
                            </p>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="invoce-company-address right-align">
                      <span class="invoice-icon">
                        <i class="material-icons cyan-text">location_city</i>
                      </span>
                                <p>
                                    <span class="strong">{{$orders[0]->administration->name}}</span>
                                    <br/>
                                    <span>125, ABC Street,</span>
                                    <br/>
                                    <span>New Yourk, USA</span>
                                    <br/>
                                    <span>+91-(444)-(333)-(221)</span>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
                <div class="invoice-lable">
                    <div class="row">
                        <div class="slide_show">
                            @foreach($orders[0]->images as $image)
                                <div><img class="materialboxed" width="100" src="{{asset($image->image)}}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr>
                <div class="invoice-table">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div>
                                <h4>{{trans('admin.detail')}}</h4>
                                <p>{{$orders[0]->order_detail}}</p>
                            </div>
                            <div>
                                <div class="cyan white-text p-2">Grand Total</div>
                                <div class="cyan strong white-text">$ 5,871.90</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice-footer">
                    <div class="row">
                        <hr>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">{{trans('admin.history')}}</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                <th scope="col">{{trans('admin.comment')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($histories as $history)
                                <tr>
                                    <td>{{$history->created_at}}</td>
                                    <td>{{$history->status_name}}</td>
                                    <td>{{$history->comment}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="col s12">
                            @if(auth()->guard('admin')->user()->type != 1 && $orders[0]->status_id == 1 || $orders[0]->status_id == 3)
                                <p class="lead">{{trans('admin.status')}}:</p>
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
                                <form action="{{route('status', $orders[0]->id)}}" method="POST">
                                    @csrf
                                    <div class="input-field">
                                        <select class="custom-select" name="status_id" id="selectPrice" required>
                                            <option disabled selected>{{trans('admin.select status')}}</option>
                                            @foreach($status as $stat)
                                                <option value="{{$stat->id}}">{{$stat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="comment" placeholder="{{trans('admin.type comment')}}" pattern="\D\S+(\s+\D\S+)+">
                                    </div>
                                    @if(auth()->guard('admin')->user()->type != 1 && $orders[0]->status_id == 1)
                                    <div class="form-group hide" id="y">
                                        <input type="number" class="x" name="price" placeholder="{{trans('admin.type price')}}" pattern="^\S+$" step=any>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">{{trans('admin.send')}}</button>
                                    </div>
                                </form>
                                <br>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end container-->
    </section>

@endsection
