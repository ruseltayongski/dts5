<?php
    use App\prr_supply;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Section Logs</title>
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        table tr th {
            color:#fff;
            font-size: 1.1em;
        }
    </style>
</head>
<body style="background:#ccc;">
    <div class="col-sm-12" style="margin-top:20px;">
        <table class="table table-bordered table-hover" style="background: #fff;">
            <thead>
            <tr style="background:#1c2d3f">
                @if(Session::get('doc_type') == 'Purchase Request - Regular Purchase - Supply')
                <th width="10%">Route # / Remarks</th>
                <th width="35%">Item Description</th>
                @else
                <th width="35%">Route # / Remarks</th>
                @endif
                <th width="14%">Received Date</th>
                <th width="14%">Received From</th>
                <th width="14%">Released Date</th>
                <th width="14%">Released To</th>
                <th width="9%">Duration</th>
            </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                @foreach($documents as $doc)
                <?php
                    $duration = '';
                    $over = 'valid';
                    $trClass = '';
                    $out = \App\Http\Controllers\DocumentController::deliveredDocument($doc->route_no,$doc->received_by,$doc->doc_type);

                    if($out):
                    $duration = \App\Http\Controllers\ReleaseController::duration($doc->date_in,$out->date_in);
                    $diff = \App\Http\Controllers\ReleaseController::hourDiff($doc->date_in,$out->date_in);
                    if($diff > 16)
                    {
                        if($doc->doc_type==='SAL' || $doc->doc_type==='TEV' || $doc->doc_type==='BILLS' || $doc->doc_type==='PAYMENT' || $doc->doc_type==='INFRA' || $doc->doc_type==='PO')
                        {
                            $counter++;
                            $over = 'over';
                            $trClass = 'bg-danger';
                        }
                    }
                    endif;
                ?>
                <tr class="documents {{ $over }} {{ $trClass }}">
                    <td><strong>{{ $doc->route_no }}</strong><br />{!! nl2br($doc->description) !!}</td>
                    @if($doc->doc_type == 'PRR_S')
                        <td>
                            @foreach(prr_supply::where('route_no',$doc->route_no)->where('status',1)->get() as $row)
                                <li>{{ $row->description }}</li>
                            @endforeach
                        </td>
                    @endif
                    <td>{{ date('M d, Y',strtotime($doc->date_in)) }}<br>{{ date('h:i:s A',strtotime($doc->date_in)) }}</td>
                    <td>
                        <?php $user = App\Users::find($doc->delivered_by);?>
                        @if($user)
                            <strong>
                            {{ $user->fname }}
                            {{ $user->lname }}
                            </strong>
                            <br>
                            <em>({{ App\Section::find($user->section)->description }})</em>
                        @endif
                    </td>
                    @if($out)
                        <td>{{ date('M d, Y',strtotime($out->date_in)) }}<br>{{ date('h:i:s A',strtotime($out->date_in)) }}</td>
                        <td>
                            <?php $user = App\Users::find($out->received_by);?>
                            @if($user)
                                <strong>
                                {{ $user->fname }}
                                {{ $user->lname }}
                                </strong>
                                <br>
                                <em>({{ App\Section::find($user->section)->description }})</em>
                            @else
                                <?php
                                $x = App\Tracking_Details::where('received_by',0)
                                        ->where('id',$out->id)
                                        ->where('route_no',$out->route_no)
                                        ->first();
                                $string = $x->code;


                                $temp1   = explode(';',$string);
                                $temp2   = array_slice($temp1, 1, 1);
                                $section_id = implode(',', $temp2);
                                $x_section=null;
                                if($section_id)
                                {
                                    $x_section = App\Section::find($section_id)->description;
                                }
                                ?>
                                <font class="text-bold text-danger">
                                    {{ $x_section }}<br />
                                    <em>(Unconfirmed)</em>
                                </font>
                            @endif
                        </td>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                    <td class="text-success">
                        <strong>{{ $duration }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(Auth::user()->section==6)
        <div class="alert alert-info text-bold" style="font-weight: bold; font-size:1.2em">
            SUMMARY: <a href="#" class="show_all"> {{ count($documents) }} total documents received.</a>
            @if($counter>0)
                <a class="text-danger show_over" style="cursor: pointer;">{{ $counter }} {{ ($counter==1) ? 'document' : 'documents' }} over 16 hrs.</a>
            @endif
        </div>
        @endif
    </div>
    <script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
    <script>
        $('.show_over').on('click',function(){
            $('.valid').hide();
        });
        $('.show_all').on('click',function(){
            $('.valid').show();
        });
    </script>
</body>
</html>



