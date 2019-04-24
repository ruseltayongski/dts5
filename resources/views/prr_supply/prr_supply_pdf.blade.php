<?php
$total = 0;
$item_no = 1;
use App\Users;
use App\Designation;
?>
        <!DOCTYPE html>
<html>
<title>Purchase Request</title>
<head>
    <link href="{{ realpath(__DIR__ . '/../../..').'/resources/assets/css/print.css' }}" rel="stylesheet">
    <style>
        html {
            margin: 30px;
            font-size:x-small;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        body {
            margin-bottom: 50px;
        }
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
            border:1px solid #000;
        }
        #border-bottom{
            border-collapse: collapse;
            border-bottom: none;
        }
        #border-bottom-t{
            border-collapse: collapse;
            border-top:1px solid red;
            border-bottom:1px solid red;
        }
        #border-left{
            border-collapse: collapse;
            border:1px solid #000;
        }
        .align{
            text-align: center;
        }
        .align-top{
            vertical-align : top;
        }
        .table1 {
            width: 100%;
        }
        .table1 td {
            border:1px solid #000;
            padding: 5px;
        }
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .footer {
            bottom: 45px;
        }
        .pagenum:before {
            content: counter(page);
        }
        .pagenum:before {
            content: counter(page);
        }
        .new-times-roman{
            font-family: "Times New Roman", Times, serif;
            font-size: 9pt;
        }
    </style>
</head>
<div class="footer">
    <hr>
    <div style="position:absolute; left: 30%;" class="align">
        <?php echo DNS1D::getBarcodeHTML(Session::get('route_no'),"C39E",1,28) ?>
        <font class="route_no">{{ Session::get('route_no') }}</font>
    </div>
</div>
    <body>
        <div class="new-times-roman">
            <table cellpadding="0" cellspacing="0" class="table1">
                <tr>
                    <td class="align" id="border"><img src="{{ realpath(__DIR__ . '/../../..').'/resources/img/doh.png' }}" width="100"></td>
                    <td width="100%" id="border">
                        <div class="align small-text">
                            Republic of the Philippines<br>
                            DEPARTMENT OF HEALTH<br>
                            <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                            Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                            Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                            Official Website: http://www.ro7.doh.gov.ph Email Address: dohro7@gmail.com<br>
                        </div>
                    </td>
                    <td class="align" id="border"><img src="{{ realpath(__DIR__ . '/../../..').'/resources/img/f1.jpg' }}" width="100"></td>
                </tr>
            </table>
            <br>
            <table class="table1" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="7" class="align">
                        <strong>PURCHASE REQUEST</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Department:</td>
                    <td rowspan="3" colspan="2">{{ $division->description }}<br> {{ $section->description }}</td>
                    <td colspan="2">PR No:</td>
                    <td><small>Date: {{ substr($tracking->prepared_date,5,2).'/'.substr($tracking->prepared_date,8,2).'/'.substr($tracking->prepared_date,2,2) }}</small></td>
                </tr>
                <tr>
                    <td colspan="2">Section:</td>
                    <td colspan="2">SAI No.:</td>
                    <td>Date: </td>
                </tr>
                <tr>
                    <td colspan="2">Unit:</td>
                    <td colspan="2">ALOBS No.:</td>
                    <td>Date: </td>
                </tr>
                <tr>
                    <th width="5%" id="border-left">Item No</th>
                    <th width="5%" id="border-right">Qty</th>
                    <th width="5%" id="border-right">Unit of Issue</th>
                    <th width="50%" id="border-right">Item Description</th>
                    <th  id="border-right">Stock No.</th>
                    <th >Estimated Unit Cost</th>
                    <th  id="border-right">Estimated Cost</th>
                </tr>
                <tbody>
                @foreach($meal as $row)
                    <tr>
                        <td id="border-bottom" class="align-top">{{ $item_no }}</td>
                        <td id="border-bottom" class="align-top">{{ $row->qty }}</td>
                        <td id="border-bottom" class="align-top">{{ $row->issue }}</td>
                        <td id="border-bottom">
                            <div>
                                <?php
                                $total += $row->estimated_cost;
                                $count = 0;
                                $item_no++;
                                echo "<strong>".$row->description."</strong>".$row->specification;
                                ?>
                            </div>
                        </td>

                        <td id="border-bottom"></td>
                        <td id="border-bottom" class="align-top">
                            <strong><span style="font-family: DejaVu Sans;">&#x20b1; </span> {{ number_format($row->unit_cost,2) }}</strong>
                        </td>
                        <td id="border-bottom" class="align-top">
                            <strong style="color: mediumvioletred;"><span style="font-family: DejaVu Sans;">&#x20b1; </span> {{ number_format($row->estimated_cost,2) }}</strong>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tr>
                    <td class="align" colspan="6"><b>TOTAL</b></td>
                    <td class="align-top"><strong style="color: red;"><span style="font-family: DejaVu Sans;">&#x20b1; </span> {{ number_format($total,2) }}</strong></td>
                </tr>
            </table>
            <table class="letter-head" cellpadding="0" style="" cellspacing="0">
                <tr>
                    <td colspan="7" class="align"><b style="margin-right:5%;">CERTIFICATION</b></td>
                </tr>
                <tr>
                    <td id="border-bottom" colspan="7">This is to certify that diligent efforts have been exerted to ensure that the price/s indicated above (in relation to the specification) is/are within the prevailing market price/s.</td>
                </tr>
                <tr>
                    <td colspan="7" id="border-bottom">Purpose: <b>{{ $tracking->purpose }}</b></td>
                </tr>
                <tr>
                    <td colspan="4" width="57.9%">Chargeable to: <b>{{ $tracking->source_fund }}</b></td>
                    <td colspan="3">Cash Advance of: {{ $tracking->cash_advance_of }}</td>
                </tr>
            </table>
            <table class="table1" cellpadding="0" cellspacing="0">
                <tr>
                    <td id="border-bottom" width="15%"></td>
                    <td id="border-bottom" width="40%">&nbsp;Recommending Approval:</td>
                    <td id="border-bottom" width="40%">&nbsp;&nbsp;&nbsp;Approved By:</td>
                </tr>
                <tr>
                    <td id="border-top border-bottom">&nbsp;Signature:</td>
                    <td id="border-top border-bottom"></td>
                    <td id="border-top border-bottom"></td>
                </tr>
                <tr>
                    <td id="border-top border-bottom">&nbsp;Printed Name:</td>
                    <td id="border-top border-bottom" class="align">
                        <u><b>
                            <?php
                                $division_name = Users::find($tracking->division_head)->fname.' '.Users::find($tracking->division_head)->mname.' '.Users::find($tracking->division_head)->lname;
                                switch($tracking->division_head){
                                    /*case 36:
                                        echo $division_name.', CPA,MBA,CEO VI';
                                    break;*/
                                    case 72:
                                        echo substr($division_name,4).', MD, MPH';
                                    break;
                                    case 225:
                                        echo "<span style='font-size: 10pt;'>".substr($division_name,4).", MD, RPT, RN, FPSMS, MBA-HM"."</span>";
                                    break;
                                    case 51:
                                        echo substr($division_name,4).', MD, DPSP';
                                    break;
                                    default:
                                        echo $division_name;
                                }
                            ?>
                        </b></u>
                    </td>
                    <td id="border-top border-bottom" class="align"><u><b>Jaime S. Bernadas, MD, MGM, CESO III</b></u></td>
                </tr>
                <tr>
                    <td id="border-top" >&nbsp;Designation:</td>
                    <td id="border-top" class="align">
                        <?php
                            $division_designation = \App\Designation::find(Users::find($tracking->division_head)->designation)->description;
                            switch($tracking->division_head){
                                case 225:
                                    echo "<span style='font-size: 9.5pt'>".$division_designation."<span>";
                                break;
                                default:
                                    echo $division_designation;
                            }
                        ?>
                    </td>
                    <td id="border-top" class="align">Director IV</td>
                </tr>
            </table>
        </div>
    </body>
</html>