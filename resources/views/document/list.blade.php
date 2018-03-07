<?php
    use App\Tracking_Details;
?>
@extends('layouts.app')

@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="alert alert-jim" id="inputText">
    <style>
        .action .btn{
            width:100%;
            margin-bottom: 5px;
        }
    </style>
    <h2 class="page-header">Documents</h2>    
    <form class="form-inline" method="POST" action="{{ asset('document') }}" onsubmit="return searchDocument();" id="searchForm">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ Session::get('keyword') }}" autofocus>
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>

            <div class="btn-group">
                <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-plus"></i>  Add New
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="GENERAL">General Document</a> </li>
                    <li class="dropdown-submenu">
                        <a href="#" data-toggle="dropdown">Disbursement Voucher</a>
                        <ul class="dropdown-menu">
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="SAL">Salary, Honoraria, Stipend, Remittances, CHT Mobilization</a></li>
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="TEV">TEV</a></li>
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="BILLS">Bills, Cash Advance Replenishment, Grants/Fund Transfer</a></li>
                            <li class="hide"><a href="#">Supplier (Payment of Transactions with PO)</a></li>
                            <li class="hide"><a href="#">Infra - Contractor</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="#" data-toggle="dropdown">Letter/Mail/Communication</a>
                        <ul class="dropdown-menu">
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="INCOMING">Incoming Mail</a></li>
                            <li class="hide"><a href="#">Outgoing</a></li>
                            <li class="divider"></li>
                            <li class="hide"><a href="#">Service Record</a></li>
                            <li class="hide"><a href="#">SALN</a></li>
                            <li class="hide"><a href="#">Plans (includes Allocation List)</a></li>
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="ROUTE">Routing Slip</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu hide">
                        <a href="#" data-toggle="dropdown">Management System Documents</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Memorandum</a></li>
                            <li><a href="#">ISO Documents</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Appointment</a></li>
                            <li><a href="#">Resolutions</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="#" data-toggle="dropdown">Miscellaneous</a>
                        <ul class="dropdown-menu">
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="WORKSHEET">Activity Worksheet</a></li>
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="JUST_LETTER">Justification</a></li>
                            <li class="hide"><a href="#">Certifications</a></li>
                            <li class="hide"><a href="#">Certificate of Appearance</a></li>
                            <li class="hide"><a href="#">Certificate of Employment</a></li>
                            <li class="hide"><a href="#">Certificate of Clearance</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="#" data-toggle="dropdown">Personnel Related Documents</a>
                        <ul class="dropdown-menu">
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="OFFICE_ORDER">Office Order</a></li>
                            <li class="hide"><a href="#">DTR</a></li>
                            <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="APP_LEAVE">Application for Leave</a></li>
                            <li class="hide"><a href="#">Certificate of Overtime Credit</a></li>
                            <li class="hide"><a href="#">Compensatory Time Off</a></li>
                        </ul>
                    </li>
                    <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="PO">Purchase Order</a></li>
                    <li><a href="#general_form" data-backdrop="static" data-toggle="modal" data-type="PRC">Purchase Request - Cash Advance Purchase</a></li>
                    <!-- <li class="dropdown-submenu">
                        <a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('prr_supply_form') }}">Purchase Request - Regular Purchase</a>
                        <a href="#" data-toogle="dropdown">Purchase Request - Regular Purchase</a>
                        <ul class="dropdown-menu">
                            <li><a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('prr_supply_form') }}">Supplies</a></li>
                            <li><a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('prr_meal_form') }}"> Meal</a></li>
                        </ul>
                    </li> -->
                    <li><a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('prr_supply_form') }}">Purchase Request - Regular Purchase</a></li>
                    <li class="hide"><a href="#">Reports</a></li>
                </ul>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <div class="page-divider"></div>
    @if(count($documents))
    <div class="table-responsive">
        @if(Session::get('updated'))
            <div class="alert alert-info">
                <i class="fa fa-check"></i> Successfully Updated!
            </div>
            <?php Session::forget('updated'); ?>
        @endif
        @if(Session::get('added'))
            <div class="alert alert-success">
                <i class="fa fa-check"></i> Successfully Added!
            </div>
            <?php Session::forget('added'); ?>
        @endif
        @if(Session::get('deleted'))
            <div class="alert alert-warning">
                <i class="fa fa-check"></i> Successfully Deleted!
            </div>
            <?php Session::forget('deleted'); ?>
        @endif
        @if(Session::get('deletedPR'))
            <div class="alert alert-danger">
                <i class="fa fa-check"></i> Successfully Deleted!
            </div>
            <?php Session::forget('deletedPR'); ?>
        @endif

        @if (session('status'))
            <?php
            $status = session('status');
            ?>
            @if($status=='releaseAdded')
                <div class="alert alert-success">
                    <i class="fa fa-check"></i> Successfully released!
                </div>
            @endif
            <hr />
        @endif
        <table class="table table-list table-hover table-striped">
            <thead>
                <tr>
                    <th width="8%"></th>
                    <th width="20%">Route #</th>
                    <th width="15%">Prepared Date</th>
                    <th width="20%">Document Type</th>
                    <th>Remarks / Additional Information</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                <tr>
                    <td class="action">
                        <a href="#track" data-link="{{ asset('document/track/'.$doc->route_no) }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12"><i class="fa fa-line-chart"></i> Track</a>
                        <br />
                        <?php
                            $routed = \App\Tracking_Details::where('route_no',$doc->route_no)
                                ->count();
                        ?>
                        @if($routed < 2)
                            <?php
                                $doc_id = Tracking_Details::where('route_no',$doc->route_no)
                                        ->orderBy('id','desc')
                                        ->first()
                                        ->id;
                            ?>
                            <button data-toggle="modal" data-target="#releaseTo" data-id="{{ $doc_id }}" data-route_no="{{ $doc->route_no }}" onclick="putRoute($(this))" type="button" class="btn btn-info btn-sm">Release To</button>
                        @endif
                    </td>
                    <td>
                        <a class="title-info" data-route="{{ $doc->route_no }}" data-link="{{ asset('/document/info/'.$doc->route_no.'/'.$doc->doc_type) }}" href="#document_info" data-toggle="modal">{{ $doc->route_no }}</a>
                    </td>
                    <td>{{ date('M d, Y',strtotime($doc->prepared_date)) }}<br>{{ date('h:i:s A',strtotime($doc->prepared_date)) }}</td>
                    <td>{{ \App\Http\Controllers\DocumentController::docTypeName($doc->doc_type) }}</td>
                    <td>
                        @if($doc->doc_type == 'PRR_S')
                            {!! nl2br($doc->purpose) !!}
                        @else
                            {!! nl2br($doc->description) !!}
                        @endif
                    </td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $documents->links() }}
    @else
        <div class="alert alert-danger">
            <strong><i class="fa fa-times fa-lg"></i> No documents found! </strong>
        </div>
    @endif
</div>
@include('modal.release_modal')
@endsection
@section('plugin')
@include('js.release_js')
<script src="{{ asset('resources/plugin/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('resources/plugin/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $('a[href="#general_form"]').on('click',function(){
        var title = $(this).html();
        var type = $(this).data('type');
        <?php echo 'var url ="'.asset('document/create/').'";';?>
        $('#general_form_title').html(title);
        $.ajax({
            url:url+'/'+type,
            type: 'GET',
            success: function(data){
                $('#general_form_content').html(data);
            }
        })
    });
    function searchDocument(){
        $('.loading').show();
        setTimeout(function(){
            return true;
        },2000);
    }

    function putAmount(amount){
        $('.amount').html(amount.val());
        if(amount.valueOf()==null){
            $('.amount').html('0');
        }
    }

    function preparedBy(input)
    {
        var name = input.val();
        $('input[name="fullNameC"]').val(name);
        $('input[name="fullNameD"]').val(name);
        $('input[name="fullNameE"]').val(name);
        $('input[name="fullNameH"]').val(name);
        console.log(name);
    }

    function position(input)
    {
        var name = input.val();
        $('input[name="positionC"]').val(name);
        $('input[name="positionD"]').val(name);
        console.log(name);
    }

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    function append()
    {
        var hr='';
        var mn = '';

        for(i=0;i<=12;i++){
            var tmp = pad(i,2);
            hr += '<option>'+tmp+'</option>';
        }
        for(i=0;i<60;i++){
            var tmp = pad(i,2);
            mn += '<option>'+tmp+'</option>';
        }
        $('#append').append('<tr>' +
                '<td><input type="date" name="date[]" class="form-control"></td>' +
                '<td colspan="2"><input type="text" name="visited[]" class="form-control"></td>' +
                '<td><select name="hourA[]" class="form-control append">' +
                 hr +
                '</select>'+
                '<select name="minA[]" class="form-control">' +
                mn +
                '</select>'+
                '<select name="ampmA[]" class="form-control">' +
                '<option>AM</option>' +
                '<option>PM</option>' +
                '</select>'+
                '</td>' +
                '<td><select name="hourB[]" class="form-control append">' +
                hr +
                '</select>'+
                '<select name="minB[]" class="form-control">' +
                mn +
                '</select>'+
                '<select name="ampmB[]" class="form-control">' +
                '<option>AM</option>' +
                '<option>PM</option>' +
                '</select>'+
                '</td>' +
                '<td><input type="text" name="trans[]" class="form-control"></td>'+
                '<td><input type="text" name="transAllow[]" class="form-control"></td>'+
                '<td><input type="text" name="dailyAllow[]" class="form-control"></td>'+
                '<td><input type="text" name="perDiem[]" class="form-control"></td>'+
                '<td><input type="text" name="total[]" class="form-control"></td>'+
                '</tr>');
    }

    function subTotal(){
        var values = {};
        var total = $('input[name="total[]"]');
        var c = 0;
        total.each(function(){
            values[c] = total.val();
            c++;
        });
        console.log(values);
    }
</script>
@endsection



@section('css')
<link href="{{ asset('resources/plugin/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
@endsection

