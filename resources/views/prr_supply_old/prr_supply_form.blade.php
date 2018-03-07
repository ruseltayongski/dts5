<?php
Use App\Division;
Use App\Section;
Use App\Designation;
?>
<link href="{{ asset('resources/assets/css/print.css') }}" rel="stylesheet">
<style>
    #border{
        border-collapse: collapse;
        border: none;
    }
    #border-top{
        border-collapse: collapse;
        border-top: none;
    }
    #border-right{
        border-collapse: collapse;
        border-right: none;
    }
    #border-bottom{
        border-collapse: collapse;
        border-bottom: none;
    }
    #border-left{
        border-collapse: collapse;
        border-left: none;
    }
    .align{
        text-align: center;
    }
    .align-top{
        vertical-align: top;
    }
    .table1 {
        width: 100%;
    }
    .table1 td {
        border:1px solid #000;
    }
    small{
        color:red;
    }
</style>
<form method="post" id="form" action="{{ asset('prr_supply_post') }}">
    {{ csrf_field() }}
    <span id="getDesignation" data-link="{{ asset('getDesignation') }}"></span>
    <span id="url" data-link="{{ asset('prr_supply_append') }}"></span>
    <span id="token" data-token="{{ csrf_token() }}"></span>
    <input type="hidden" name="doc_type" value="PRR_S">
    <input type="hidden" value="{{ Auth::user()->id }}" name="prepared_by">
    <div class="modal-body">
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="invoice">
                <div class="table-responsive">
                    <table class="letter-head" cellpadding="0" cellspacing="0">
                        <tr>
                            <td id="border" class="align"><img src="{{ asset('resources/img/doh.png') }}" width="100"></td>
                            <td width="90%" id="border">
                                <div class="align" style="margin-top:-10px;">
                                    <center>
                                        Republic of the Philippinesss<br>
                                        <strong>DEPARTMENT OF HEALTH REGIONAL OFFICE NO. VII</strong><br>
                                        Osmeña Boulevard, Cebu City, 6000 Philippines<br>
                                        Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                                        Official Website: http://www.ro7.doh.gov.ph Email Address: dohro7@gmail.com<br>
                                    </center>
                                </div>
                            </td>
                            <td id="border" class="align"><img src="{{ asset('resources/img/ro7.png') }}" width="100"></td>
                        </tr>
                    </table>
                    <table class="letter-head" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <td colspan="7" class="align">
                                <strong>PURCHASE REQUEST</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Department:</td>
                            <td colspan="2">{{ Division::find(Auth::user()->division)->description }}</td>
                            <td colspan="2">PR No:</td>
                            <td>Date:<input class="form-control datepickercalendar" name="prepared_date" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">Section:</td>
                            <td colspan="2">{{ Section::find(Auth::user()->section)->description }}</td>
                            <td colspan="2">SAI No.:</td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td colspan="2">Unit:</td>
                            <td colspan="2"></td>
                            <td colspan="2">ALOBS No.:</td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td ><b>Option</b></td>
                            <td ><b>Qty</b></td>
                            <td ><b>Unit of Issue</b></td>
                            <td width="40%"><b>Item Description</b></td>
                            <td><b>Stock No.</b></td>
                            <td><b>Unit Cost</b></td>
                            <td><b>Estimated Cost</b></td>
                        </tr>
                        </thead>
                        <tbody class="input_fields_wrap">
                        <tr>
                            <td id="border-bottom" ></td>
                            <td id="border-bottom" class="qty1 align-top">
                                <input type="text" name="qty[]" id="qty1" class="form-control" onkeydown="trapping(event,true)" onkeyup="trapping(event,true)" required>
                                <small id="E_qty1">required!</small>
                            </td>
                            <td id="border-bottom" class="issue1 align-top">
                                <input type="text" name="issue[]" id="issue1" class="form-control" onkeyup="trapping()" required>
                                <small id="E_issue1">required!</small>
                            </td>
                            <td id="border-bottom" class="description1 align-top">
                                <input type="text" name="description[]" id="description1" class="form-control" onkeyup="trapping()" required><small id="E_description1">required!</small>
                                <br><strong><i>Specification(s)</i></strong>
                                <textarea class="textarea" placeholder="Place some text here" style="width: 100%;font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="specification[]" id="specification1" onkeyup="trapping()" required></textarea><small id="E_specification1"></small>
                            </td>
                            <td id="border-bottom"></td>
                            <td id="border-bottom" class="unit_cost1 align-top"><input type="text" name="unit_cost[]" id="unit_cost1" class="form-control" onkeydown="trapping(event,true)" onkeyup="trapping(event,true)" required><small id="E_unit_cost1">required!</small></td>
                            <td id="border-bottom" class="estimated_cost1 align-top">
                                <input type="hidden" name="estimated_cost[]" id="estimated_cost1" class="form-control">
                                <strong style="color:green;">&#x20b1;</strong><strong style="color:green" id="e_cost1"></strong>
                            </td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"><a onclick="add();" href="#">Add new</a></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"><br><br> Prepared By:<br><br><u>{{ Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname }}</u><br>{{ Designation::find(Auth::user()->designation)->description }}</td>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                            <td id="border-top"></td>
                        </tr>
                        <tr>
                            <td class="align" colspan="6"><b>TOTAL</b></td>
                            <td class="align-top">
                                <input type="hidden" name="amount" id="amount">
                                <strong style="color: red;">&#x20b1;</strong><strong style="color:red" id="total"></strong>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <h3>Certification</h3>
                        <address>This is to certify that dilligent efforts have been exerted to ensure that the price/s indicated above(in relation to the specifications) is/are within the prevailing market price/s.
                        </address>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Requested By:</label>
                            <div class="col-sm-10">
                                <select  class="chosen-select-static form-control" onchange="get_designation($(this),'section')" name="requested_by" required>
                                    <option value="">Select Name</option>
                                    @foreach($section_head as $row)
                                        <option value="{{ $row['id'] }}">{{ $row['fname'].' '.$row['mname'].' '.$row['lname'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Designation:</label>
                            <div class="col-sm-10">
                                <input id="section_head" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="purpose" class="col-sm-2 control-label">Purpose:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="purpose" name="purpose" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="chargeable" class="col-sm-2 control-label">Chargeable to:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="charge_to" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <center>
                        <h4><strong class="lean">Recommending Approval:</strong></h4>
                        </center>
                    </div>
                    <div class="col-md-6">
                        <center>
                        <h4><strong class="lean text-center">Approved:</strong></h4>
                        </center>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6">
                        <label class="col-sm-4 control-label">Printed Name:</label>
                        <div class="col-sm-10">
                            <select class="chosen-select-static form-control" onchange="get_designation($(this),'division');" name="division_head" required>
                                <option value="">Select Name</option>
                                @foreach($division_head as $row)
                                    <option value="{{ $row['id'] }}">{{ $row['fname'].' '.$row['mname'].' '.$row['lname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <center>
                            <strong>JAIME S. BERNADAS, MD, MGM, CESO III</strong><br>
                            Director IV
                        </center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-sm-4 control-label">Designation:</label>
                        <div class="col-sm-10">
                            <input id="division_head" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success pull-left" onclick="haha();" style="margin-right: 5px;">
                            <i class="fa fa-send"></i> Submit
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>
<!-- /.content -->
<div class="clearfix"></div>
<script>
    $('.chosen-select-static').chosen();
    var width = $("#my_modal").width() + 100;
    /*$("#my_modal").css("width", width);*/
    $(".textarea").wysihtml5();

    var count = 1;
    var limit = 10;
    var ok = '';
    var wrapper= $(".input_fields_wrap"); //Fields wrapper
    function add(){

        ok = "true";
        trapping();

        if(count < limit) {
            count++;
            var url = $("#url").data('link');
            url += "?count=" + count;
            $.get(url, function (result) {
                $(wrapper).append(result);
            });
        }
    }

    function trapping(event,flag)
    {
        if(flag)
            key_code(event);

        var estimated_cost = 0;
        var total = 0;
        for(var i=1; i<=count; i++)
        {
            if($("#qty"+i).val() == '' || $("#issue"+i).val() == '' || $("#description"+i).val() == '' || $("#unit_cost"+i).val() == '' || $("#specification"+i).val() == ''){
                ok = "false";
            }
            $("#qty"+i).val() == '' ? ($(".qty"+i).addClass("has-error"),$("#E_qty"+i).show()) :($(".qty"+i).removeClass("has-error"),$("#E_qty"+i).hide()) ;
            $("#issue"+i).val() == '' ? ($(".issue"+i).addClass("has-error"),$("#E_issue"+i).show()) : ($(".issue"+i).removeClass("has-error"),$("#E_issue"+i).hide());
            $("#description"+i).val() == '' ? ($(".description"+i).addClass("has-error"),$("#E_description"+i).show()) : ($(".description"+i).removeClass("has-error"),$("#E_description"+i).hide());
            $("#unit_cost"+i).val() == '' ? ($(".unit_cost"+i).addClass("has-error"),$("#E_unit_cost"+i).show()) : ($(".unit_cost"+i).removeClass("has-error"),$("#E_unit_cost"+i).hide());
            $("#specification"+i).val() == '' ? ($(".specification"+i).addClass("has-error"),$("#E_specification"+i).show()) : ($(".specification"+i).removeClass("has-error"),$("#E_specification"+i).hide());

            var noComma = parseFloat(numeral($("#unit_cost"+i).val()).format('0,0.00').replace(/,/g, ''));
            $("#qty"+i).val() && $("#unit_cost"+i).val() !== '' ? (parseFloat($("#estimated_cost"+i).val($("#qty"+i).val()*noComma))) : $("#estimated_cost"+i).val('');
            $("#qty"+i).val() && $("#unit_cost"+i).val() !== '' ? ($("#e_cost"+i).text(numeral($("#qty"+i).val()*noComma).format('0,0.00')),estimated_cost = $("#estimated_cost"+i).val()) : ($("#e_cost"+i).text(''),estimated_cost = 0);

            total += parseFloat(estimated_cost);
        }
        $("#total").text(numeral(total).format('0,0.00'));
        $("#amount").val(numeral(total).format('0,0.00'));
    }

    function key_code(e){
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }

    function get_designation(result,request){
        var url = $("#getDesignation").data('link')+'/'+result.val();
        $.get(url, function(designation){
            request == 'section' ?
                    result.val() ? $("#section_head").val(designation) : $("#section_head").val('') :
                    result.val() ? $("#division_head").val(designation) : $("#division_head").val('');
        });
    }

    function haha(){
        console.log(count);
    }

    function erase(result){
        limit++;
        $("#"+result.val()).remove();
        /*trapping();*/
    }

    document.onkeydown = function(evt) {
        evt = evt || window.event;
        var isEscape = false;
        if ("key" in evt) {
            isEscape = (evt.key == "Escape" || evt.key == "Esc");
        } else {
            isEscape = (evt.keyCode == 27);
        }
        if (isEscape) {
            /*$("#my_modal").css("width", width-100);*/
        }
    };

    $("form").submit(function () {
    });


</script>