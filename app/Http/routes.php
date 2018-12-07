<?php
Use App\Tracking;
use App\User;
Route::auth();

//jimzky
Route::get('/','HomeController@index');

Route::get('home', 'HomeController@index');
Route::get('home/chart', 'HomeController@chart');

Route::get('document', 'DocumentController@index');
Route::post('document', 'DocumentController@search');

//Route::get('document/accept', 'DocumentController@accept')->middleware('access');
Route::get('document/accept', 'DocumentController@accept');
Route::get('document/destroy/{route_no}', 'DocumentController@cancelRequest');

Route::post('document/accept', 'DocumentController@saveDocument'); //for manual accepting
Route::get('document/accept/{id}', 'DocumentController@updateDocument'); //for button accepting


Route::get('document/info/{route}', 'DocumentController@show');
Route::get('document/info/{route}/{doc_type}', 'DocumentController@show');
Route::get('document/removepending/{id}','DocumentController@removePending');
Route::get('document/removeOutgoing/{id}','DocumentController@removeOutgoing');
Route::get('document/removeIncoming/{id}','DocumentController@removeIncoming');
Route::get('document/track/{route_no}','DocumentController@track');
Route::get('document/list','AdminController@allDocuments');
Route::post('document/list','AdminController@searchDocuments');
Route::post('document/update','DocumentController@update');
Route::get('document/create/{type}','DocumentController@formDocument');
Route::post('document/create','DocumentController@createDocument');
Route::get('document/viewPending','DocumentController@countPendingDocuments');

Route::match(['GET','POST'],'document/pending','DocumentController@allPendingDocuments');
Route::post('document/pending/return','DocumentController@returnDocument');
Route::post('document/pending/accept','DocumentController@acceptDocument');

Route::post('document/release','ReleaseController@addRelease');
Route::get('document/report/{id}','ReleaseController@addReport');
Route::get('document/report/{id}/{cancel}','ReleaseController@addReport');
Route::get('document/report/{id}/{cancel}/{status}','ReleaseController@addReport');

Route::get('document/alert/{level}/{id}','ReleaseController@alert');
Route::get('reported','ReleaseController@viewReported');


Route::get('getsections/{id}','ReleaseController@getSections');
Route::get('document/doctype/{doctype}',function($doctype){
    return \App\Http\Controllers\DocumentController::docTypeName($doctype);
});

// FOR ACCOUNTING SECTION
Route::get('accounting/accept','AccountingController@accept');
Route::post('accounting/accept','AccountingController@save');

//FOR BUDGET SECTION
Route::get('budget/accept','BudgetController@accept');
Route::post('budget/accept','BudgetController@save');


Route::get('document/filter', 'FilterController@index');
Route::post('document/filter', 'FilterController@update');

Route::get('document/received', 'DocumentController@receivedDocument');
Route::post('document/received', 'DocumentController@receivedDocument');

Route::get('document/logs','DocumentController@logsDocument');
Route::post('document/logs','DocumentController@searchLogs');
Route::get('document/section/logs','DocumentController@sectionLogs');
Route::post('document/section/logs','DocumentController@searchSectionLogs');


Route::get('form/salary','SalaryController@index');
Route::post('form/salary','SalaryController@store');

Route::get('form/tev', 'TevController@index');
Route::post('form/tev', 'TevController@store');

Route::get('form/bills','BillsController@index');
Route::post('form/bills','BillsController@store');

Route::get('pdf/v1/{size}', function($size){
    $display = view("pdf.pdf",['size'=>$size]);
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML($display);
    return $pdf->setPaper($size, 'portrait')->stream();
});

//PRINT LOGS
Route::get('pdf/track','PrintLogsController@printTrack');
Route::get('pdf/logs/{doc_type}', 'PrintLogsController@printLogs');

//PRINT REPORT
Route::get('report','AdminController@report');
Route::get('reportedDocuments/{year}','AdminController@reportedDocuments');
Route::get('report/logs/section', 'PrintLogsController@sectionLogs');

//ONLINE
Route::get('online','OnlineController@online');

//LOGOUT
Route::get('logout',function(){
    $user = Auth::user();
    echo $id = $user->id;
    \App\Http\Controllers\SystemController::logDefault('Logged Out');
    Auth::logout();
    User::where('id',$id)
        ->update(['status' => 0]);
    \Illuminate\Support\Facades\Session::flush();
    return redirect('login');
});
//endjimzky

//rusel
//PURCHASE REQUEST/REGULAR SUPPLY
Route::get('prr_supply_form','PurchaseRequestController@prr_supply_form');
Route::post('prr_supply_post','PurchaseRequestController@prr_supply_post');
Route::get('prr_supply_pdf','PurchaseRequestController@prr_supply_pdf');
Route::get('prr_supply_pdf/{paperSize}','PurchaseRequestController@prr_supply_pdf');
Route::get('prr_supply_page','PurchaseRequestController@prr_supply_page');
Route::post('prr_supply_update','PurchaseRequestController@prr_supply_update');
Route::get('prr_supply_history','PurchaseRequestController@prr_supply_history');
Route::get('prr_supply_append','PurchaseRequestController@prr_supply_append');
Route::post('prr_supply_remove','PurchaseRequestController@prr_supply_remove');
//PURCHASE REQUEST/REGULAR MEAL
Route::get('prr_meal_form','PurchaseRequestController@prr_meal_form');
Route::post('prr_meal_post','PurchaseRequestController@prr_meal_post');
Route::get('prr_meal_append','PurchaseRequestController@prr_meal_append');
Route::get('prr_meal_page','PurchaseRequestController@prr_meal_page');
Route::get('prr_meal_history','PurchaseRequestController@prr_meal_history');
Route::post('prr_meal_update','PurchaseRequestController@prr_meal_update');
Route::get('prr_meal_pdf','PurchaseRequestController@prr_meal_pdf');
Route::get('prr_meal_category', 'PurchaseRequestController@prr_meal_category');
//PURCHASE REQUEST/ADVANCE
Route::get('prCashAdvance','PurchaseRequestController@prCashAdvance');
Route::post('prCashAdvance','PurchaseRequestController@savePrCashAdvance');
//PURCHASE ORDER
Route::get('PurchaseOrder','PurchaseOrderController@PurchaseOrder');
Route::post('PurchaseOrder','PurchaseOrderController@PurchaseOrderSave');
//DIVISION
Route::get('division','DivisionController@division');
Route::get('addDivision','DivisionController@addDivision');
Route::post('addDivision','DivisionController@addDivisionSave');
Route::get('deleteDivision/{id}','DivisionController@deleteDivision');
Route::get('updateDivision/{id}/{head}','DivisionController@updateDivision');
Route::post('updateDivisionSave','DivisionController@updateDivisionSave');
Route::post('searchDivision','DivisionController@searchDivision');
Route::get('searchDivision','DivisionController@searchDivisionSave');
//SECTION
Route::get('section','SectionController@section');
Route::post('section','SectionController@searchSection');
Route::get('addSection','SectionController@addSection');
Route::post('addSection','SectionController@addSectionSave');
Route::get('deleteSection/{id}','SectionController@deleteSection');
Route::get('updateSection/{id}/{division}/{head}','SectionController@updateSection');
Route::post('updateSectionSave','SectionController@updateSectionSave');
Route::post('searchSection','SectionController@searchSection');
Route::get('searchSection','SectionController@searchSectionSave');
//CHECK SECTION
Route::get('checkSection','SectionController@checkSection');
Route::get('checkSectionUpdate','SectionController@checkSectionUpdate');
//CHECK DIVISION
Route::get('checkDivision','DivisionController@checkDivision');
Route::get('checkDivisionUpdate','DivisionController@checkDivisionUpdate');
Route::get('date_in/{count}','DocumentController@get_date_in');
//GET DESIGNATION
Route::get('getDesignation/{id}','PurchaseRequestController@getDesignation');
//APPOINTMENT
Route::get('appointment','AppointmentController@appointment');
Route::post('appointment','AppointmentController@appointmentSave');
//PR PDF
Route::get('pdf_pr','PurchaseRequestController@prr_pdf');
//CALENDAR
Route::get('calendar',function(){
    return view('calendar.calendar');
});
Route::get('calendar_form',function(){
    return view('calendar.calendar_form');
});
Route::post('calendar_save','PurchaseRequestController@calendar');
Route::get('calendar_event',function(){
    return \App\Calendar::all(['title','start','end','backgroundColor','borderColor']);
});

Route::get('sendemail', function () {

    $data = array(
        'name' => "Learning Laravel",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('nevermoretayong@gmail.com', 'Learning Laravel');

        $message->to('ruseltayong@gmail.com')->subject('Learning Laravel test email');

    });

    return "Your email has been sent successfully";
});

//traya
//routing slip
Route::get('/form/routing/slip', 'RoutingController@routing_slip');
Route::post('/form/routing/slip', 'RoutingController@create');
//incoming letter
Route::match(['get','post'],'/form/incoming/letter', 'MailLetterIncomingController@incoming_letter');
//APP LEAVE CDO
Route::get('/form/application/leave', 'AppLeaveController@index');
Route::post('/form/application/leave', 'AppLeaveController@create');
//JUSTIFICTION LETTER
Route::match(['get','post'], '/form/justification/letter','JustificationController@index');
//OFFICE ORDER
Route::match(['get','post'] ,'/form/office-order', 'OfficeOrderController@create');
/*
Route::get('/form/office-order','OfficeOrderController@index');
Route::post('/form/office-order','OfficeOrderController@create');
*/
//ACTIVITY WORKSHEET
Route::get('/form/worksheet','ActivityWorksheetController@index');
Route::post('/form/worksheet', 'ActivityWorksheetController@create');
//GENERAL DOC
Route::match(['get','post'],'general', 'GeneralDocument@create');
//CHANGE PASSWORD
Route::get('/change/password', 'PasswordController@change_password');
Route::post('/change/password', 'PasswordController@save_changes');
Route::get('/form/incoming/letter', 'MailLetterIncomingController@incoming_letter');
Route::get('/session','DocumentController@session');

//ADMIN CONTROLLER
//users
Route::get('users', 'AdminController@users');
Route::match(['get','post'],'user/new','AdminController@user_create');
Route::match(['get','post'],'user/edit','AdminController@user_edit');
Route::get('/get/section', 'AdminController@section');
Route::get('/search/user','AdminController@search');
Route::post('/user/remove','AdminController@remove');
Route::get('/check/user','AdminController@check_user');
//designation
Route::get('/designation', 'DesignationController@index');
Route::match(['get','post'],'/designation/create','DesignationController@create');
Route::match(['get','post'],'/edit/designation', 'DesignationController@edit');
Route::get('/search/designation', 'DesignationController@search');
Route::post('/remove/designation', 'DesignationController@remove');
//feedback
Route::post("sendFeedback","Feedback1Controller@sendFeedback");
Route::match(['get','post'] ,'feedback', 'FeedbackController@index');
Route::match(['get','post'], 'users/feedback', 'FeedbackController@view_feedback');
Route::match(['get','post'],'view-feedback','FeedbackController@message');
Route::get('feedback_ok',function(){
    return view('feedback.feedback_ok');
});
Route::post('feedback/action', 'FeedbackController@action');
Route::get('clear', function(){
    Session::flush();
    return redirect('/');
});

Route::get('modal',function(){
    return view('users.modal');
});

//Route::get('res', 'PasswordController@change');

//Route::get('/migrate','SystemController@migrate');

Route::get('temporary',function(){
   return \App\Dtr_calendar::get(['start'])[0]->start;
});

//TEST CONTROLLER
Route::get('test', 'TestController@test');
