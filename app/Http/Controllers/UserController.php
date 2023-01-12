<?php

namespace App\Http\Controllers;

use App\Models\DetailPetisi;
use App\Models\Petisi;
use App\Models\User;
use App\Rules\BinusianValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function register(Request $req){
        $rules = [
            'name' => 'required|regex:/[a-zA-Z\s]+/',
            'nim' => 'required|numeric|digits:10|unique:users,nim',
            'email' => ['required','email','unique:users,email', new BinusianValidation],
            'password' => 'required|min:5|max:20',
        ];

        if(app()->getLocale() == 'id'){
            $validator = Validator::make($req->all(), $rules, $messages = [
                'required' => 'Kolom :attribute dibutuhkan untuk pendaftaran!',
                'regex' => 'Kolom Nama hanya dapat diisi dengan karakter dan spasi!',
                'numeric' => 'Kolom NIM hanya dapat diisi dengan angka!',
                'unique' => ':attribute-mu sudah terdaftar dalam sistem!',
                'digits' => 'Kolom NIM wajib diisi dengan :digits digit!',
                'min' => 'Kata sandi harus memiliki minimal :min karakter!',
                'max' => 'Kata sandi tidak boleh melebihi :max karakter!',
                ]
            );
        }
        if(app()->getLocale() == 'en'){
            $validator = Validator::make($req->all(), $rules, $messages = [
                'required' => 'The :attribute field is needed to register!',
                'regex' => 'The name field can only consists of characters and spaces!',
                'numeric' => 'The NIM field can only consists of digits!',
                'unique' => 'Your :attribute is already registered in our system!',
                'digits' => 'The NIM field must be exactly :digits digits!',
                'min' => 'Password must have a minimum character of :min characters!',
                'max' => 'Password cannot exceed :max characters!',
                ]
            );
        }


        if ($validator->fails()){
            return back()->withErrors($validator)->withInput($req->input());
        }

        User::insert([
            'nama' => $req->name,
            'nim' => $req->nim,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $lang = app()->getLocale();
        return redirect("/$lang/login");
    }

    public function login(Request $req){
        $rules = [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:5|max:20',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()){
            return back()->withErrors($validator)
                         ->withInput($req->input());
        }

        $credentials = [
            'email' => $req->email,
            'password'=> $req->password
        ];

        if($req->remember){
            Cookie::queue('emailcookie', $req->email, 60);
            Cookie::queue('passcookie', $req->password, 60);
        }

        if(Auth::attempt($credentials, true)){
            $req->session()->regenerate();
            return redirect()->intended('/');
        }


        if(app()->getLocale() == 'id'){
            return back()->with('loginError', 'Akun anda tidak terdaftar atau data yang anda masukkan tidak sesuai!')->withInput($req->input());
        }

        if(app()->getLocale() == 'en'){
            return back()->with('loginError', 'Your account is not registered or does not match our record!')->withInput($req->input());
        }
    }

    public function logout(){
        Auth::logout();
        $lang = app()->getLocale();
        return redirect("/$lang/login");
    }

    public function dukungpetisi(Request $req){
        $rules = [
            'petuser' => 'unique:detail_petisis,petuser'
        ];

        if(app()->getLocale() == 'id'){
            $validator = Validator::make($req->all(), $rules, $messages = [
                'petuser.unique' => 'Kamu sudah mendukung petisi ini!',
            ]);
        }
        if(app()->getLocale() == 'en'){
            $validator = Validator::make($req->all(), $rules, $messages = [
                'petuser.unique' => 'You\'ve signed this petition!',
            ]);
        }


        if ($validator->fails()){
            return back()->withErrors($validator);
        }

        $pet = Petisi::firstwhere('id', '=', $req->petid);
        // $counter = $pet->counter + 1;
        // @dd($counter);

        Petisi::where('id', '=', $req->petid)->update([
            'counter' => $pet->counter + 1
        ]);

        DetailPetisi::insert([
            'user_id' => Auth::user()->id,
            'pet_id' => $req->petid,
            'petuser' => $req->petuser
        ]);


        if(app()->getLocale() == 'id'){
            return back()->with('success', 'Berhasil memberikan dukungan ke petisi ini!');
        }

        if(app()->getLocale() == 'en'){
            return back()->with('success', 'Successfully signed the petition!');
        }
    }

    public function mulaiview(){
        return view('mulaipetisi');
    }
}
