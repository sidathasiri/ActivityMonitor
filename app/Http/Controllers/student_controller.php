<?php

namespace App\Http\Controllers;

use App\Activity;
use App\category;
use App\module;
use App\student;
use App\takes_part;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class student_controller extends Controller{
    public function getRegister(){
        return view('register');
    }

    public function getLogin(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function postLogin(Request $request){
        $this->validate($request, [
            'index' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt(['id' => $request['index'], 'password' => $request['password']])){
            return redirect()->route('login')->with('fail', 'Login Failed!');
        }

        $student = student::where('id', $request['index'])->first();

        return redirect()->route('dashboard');
    }

   public function getDashboard(){
        $pendingActivityObj = array();
        $approvedActivityObj = array();
        $pActivities = takes_part::where(['student_id' => Auth::user()->id, 'status' => 'pending'])->get();
        $aActivities = takes_part::where(['student_id' => Auth::user()->id, 'status' => 'approved'])->get();
        foreach ($pActivities as $activity){
            $pendingAct = Activity::where('id', $activity->id)->first();
            array_push($pendingActivityObj, $pendingAct);
        }

       foreach ($aActivities as $activity){
           $acceptedAct = Activity::where('id', $activity->id)->first();
           array_push($approvedActivityObj, $acceptedAct);
       }

       return view('dashboard', ['pendingObjs' => $pendingActivityObj, 'acceptedObjs' => $approvedActivityObj]);
   }

   public function getLogout(){
       Auth::logout();
       return redirect()->route('login');
   }


    public function register(Request $request){
        $this->validate($request, [
            'index' => 'required|unique:students,id',
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|email|unique:students',
            'password' => 'required'
        ]);

        $student = new student();
        $student->first_name = ucfirst($request['firstname']);
        $student->last_name = ucfirst($request['lastname']);
        $student->email = $request['email'];
        $student->id = $request['index'];
        $student->password = bcrypt($request['password']);
        $student->save();

        return redirect()->route('register')->with('success', 'true');

    }

    public function getAddActivity(){
        $categories = category::all();
        $modules = module::where('cat_id', '1')->get();
        return view('addNewActivity', ['categories' => $categories, 'modules' => $modules]);
    }

    public function getEditProfile(){
        return view('editProfile');
    }

    public function changeData(){
        $success = null;
        $student = student::where('id', Auth::user()->id)->first();
        if(Input::has('firstname')){
            $student->first_name = ucfirst(Input::get('firstname'));
            $success = 'true';
        }

        if(Input::has('lastname')){
            $student->last_name = ucfirst(Input::get('lastname'));
            $success = 'true';
        }

        if(Input::has('email')){
            $student->email = Input::get('email');
            $success = 'true';
        }

        $student->save();
        return redirect()->route('editProfile')->with('success', $success);
    }

    public function editPassword(Request $request){

        $this->validate($request, [
            'password' => 'min:5'
        ]);

        $success = null;
        $fail = null;
        $student = student::where('id', Auth::user()->id)->first();

        if (Input::get('password') === Input::get('repassword') and Input::has('password')) {
            $student->password = bcrypt(Input::get('password'));
            $student->save();
            $success = 'true';
        }

        else{
            $fail = 'true';
        }
        return redirect()->route('editProfile')->with(array('success'=> $success, 'fail'=> $fail));
    }

    public function postAddActivity(Request $request){

        $this->validate($request, [
            'activity' => 'required',
            'post' => 'required',
            'joined_date' => 'required|date',
            'description' => 'required'
        ]);

        $activity = new Activity();
        $activity->name = $request['activity'];
        $activity->post = $request['post'];
        $activity->cat_id = Input::get('catSelect');
        $activity->module_id = Input::get('module');
        $activity->description = $request['description'];
        $activity->joined_date = $request['joined_date'];
        $activity->save();

        $takes = new takes_part();
        $takes->student_id = Auth::user()->id;
        $takes->activity_id = $activity->id;
        $takes->status = 'pending';
        $takes->save();

        return redirect()->route('addActivity')->with('success', 'true');
    }

}
