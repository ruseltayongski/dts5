<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AccessController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }
    
    static function access()
    {
        $budget = Section::where('description','Budget Section')->first();
        $accounting = Section::where('description','Accounting Section')->first();
        if(Auth::user()->section == $accounting->id) {
            return 'accounting';
        }else if(Auth::user()->section == $budget->id) {
            return 'budget';
        }
        return 'general';
    }
}
