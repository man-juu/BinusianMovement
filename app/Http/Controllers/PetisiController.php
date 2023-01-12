<?php

namespace App\Http\Controllers;

use App\Models\DetailPetisi;
use App\Models\Petisi;
use Carbon\Carbon;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Locale;

class PetisiController extends Controller
{
    public function insertpetisi(Request $req){
        $rules = [
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'title' => 'required|min:5|max:50',
            'detail' => 'required|min:100',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput($req->input());
        }

        if ($req->image){
            $file = $req->file('image');

            $fileName = $file->getClientOriginalName();
            Storage::putFileAs('public/img/', $file, $fileName);
        } else{
            $fileName = 'petisi.png';
        }

        $slug = Str::random(40);

        Petisi::insert([
            'slugpet' => $slug.Auth::user()->id,
            'user_id' => Auth::user()->id,
            'judul' => $req->title,
            'sjudul' => Str::substr($req->title, 0, 16),
            'desc' => $req->detail,
            'sdesc' => Str::substr($req->detail, 0, 75),
            'img' => $fileName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $pet = Petisi::all()->last();

        DetailPetisi::insert([
            'user_id' => Auth::user()->id,
            'pet_id' => $pet->id,
            'petuser' => Auth::user()->id.$pet->id
        ]);
        $lang = app()->getLocale();
        return redirect("/$lang");
    }
}
