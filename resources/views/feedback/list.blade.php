@extends('layouts.app')

@section('content')
    <span id="url" data-link="{{ asset('users') }}"></span>
    <span id="token" data-token="{{ csrf_token() }}"></span>
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Users Feedback</h2>
        <div class="clearfix"></div>
        <div class="page-divider"></div>
        @if(isset($feedbacks) and count($feedbacks) > 0)
            <div class="table-responsive">
                <table class="table table-list table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Option</th>
                        <th>*</th>
                        <th>Name </th>
                        <th>Designation</th>
                        <th>Section / Division</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feedbacks as $feedback)
                        <?php $user = \App\Users::where('id',$feedback->userid)->first(); ?>
                        <?php $section = \App\Section::where('id', $user->section)->pluck('description')->first(); ?>
                        <?php $division = \App\Division::where('id', $user->division)->pluck('description')->first(); ?>
                        <?php $designation = \App\Designation::where('id', $user->designation)->pluck('description')->first(); ?>

                        <tr>
                            <td><a href="#view" class="btn btn-success" data-id="{{ $feedback->id }}" data-link="{{ asset('view-feedback') }}" class="title-info"><i class="fa fa-eye"></i> View</a></td>
                            <th>
                                @if($feedback->is_read == "0")
                                    <strong><i class="fa fa-envelope" aria-hidden="true" style="color: #ff0000;"></i></strong>
                                @else
                                    <strong><i class="fa fa-check-square" aria-hidden="true" style="color:green;"></i></strong>
                                @endif
                            </th>
                            <td><strong class="text-bold">{{ $user->fname ." ". $user->mname." ".$user->lname }}</strong></td>
                            <td>{{ $designation }}</td>
                            <td>
                                {{ $section }}<br>
                                <em>({{ $division }})</em>
                            </td>
                            <td>
                                <?php
                                    $action = \App\FeedbackStatus::where('id',$feedback->stat_id)->pluck('action')->first();
                                    if(isset($action) and count($action) > 0) {
                                       echo $action;
                                    } else {
                                        echo "No action";
                                    }
                                ?>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $feedbacks->links() }}
        @else
            <div class="alert alert-danger">
                <strong><i class="fa fa-times fa-lg"></i>No users found.</strong>
            </div>
        @endif
    </div>

@endsection
@section('plugin')
    <script src="{{ asset('resources/plugin/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('resources/plugin/daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section('css')
    <link href="{{ asset('resources/plugin/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
@endsection
@section('js')
    @@parent
    <script>
        (function($){
            $('.form-accept').submit(function(event){
                $(this).submit();
            });
            $('a[href="#view"]').on('click',function(e){
                $('#document_form').modal('show');
                $('.modal_content').html(loadingState);
                $('.modal-title').html($(this).html());
                var data = {
                    "id" : $(this).data('id')
                };
                var url = $(this).data('link');
                setTimeout(function() {
                    $.ajax({
                        url: url,
                        data : data,
                        type: 'GET',
                        success: function(data) {
                            $('.modal_content').html(data);
                        }
                    });
                },1000);
            });
        })($);

    </script>
@endsection



