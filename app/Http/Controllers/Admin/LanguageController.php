<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translate;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\DataTables;
use App\Models\LandingSetting;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    public function index()
    {
        return view('admin.language');
    }
    
    public function edit(Request $request)
    {
        $request->validate([
            'language_id'    => 'required|exists:languages,id',
        ]);
        $language = Language::where('id',$request->language_id)->first();

        return response()->json($language);
    }

    public function list()
    {
        $languages = Language::query();
        return Datatables::of($languages)->toJson();
    }

    public function update(Request $request)
    {
        if($request->language_id){
            $language = Language::where('id',$request->language_id)->first();
            $language->name = $request->name;
            $language->save();
            return response()->json(['message' => 'Language updated successfully']);
        }else{
            $langCodeCheck = Language::where('code',$request->code)->first();
            if($langCodeCheck){
                return response()->json(['message' => 'Language code already exists'],422);
            }else{
                $language = new Language();
                $language->name = $request->name;
                $language->code = strtolower($request->code);
                $language->save();


                $this->tableAddColumn(strtolower($request->code));
                self::setEnvironmentValue();
                return response()->json(['message' => 'Language created successfully']);
            }
        }
    }
    
    public function delete(Request $request)
    {
        $request->validate([
            'language_id'    => 'required|exists:languages,id',
        ]);
        $language = Language::where('id',$request->language_id)->first();
        if($language->is_default == '1'){
            return response()->json(['message' => 'Default language can not be deleted'],422);
        }else {
            $language->delete();
            self::tableDropColumn($language->code);
            self::setEnvironmentValue();
            return response()->json(['message' => 'Language deleted successfully']);
        }
    }
    
    public function defualt(Request $request){
        $request->validate([
            'language_id'    => 'required|exists:languages,id',
        ]);
        $languages = Language::all();
        foreach($languages as $language){
            if($language->id == $request->language_id){
                $language->is_default = '1';
            }else{
                $language->is_default = '0';
            }
            $language->save();
        }
        self::setEnvironmentValue();
        return response()->json(['message' => 'Language set as default successfully']);
    }

    private function tableAddColumn($lang)
    {
        $defualt = env('APP_DEFUALT_LANG');
        Schema::table('xxx', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('xxxy'.$defualt, function ($table) use ($lang) {
                $table->string('xxxyy'.$lang)->nullable();
            });

    }

    private function tableDropColumn($lang){
        Schema::table('xxx', function (Blueprint $table) use ($lang) {
            $table->dropColumn('xxxy'.$lang);
        });

    }

    public function setEnvironmentValue()
    {
        $langs = Language::all();
        $values = [];
        $defualtLang = '';
        foreach($langs as $lang){
            $values['APP_LANG'][] = $lang->code;
            if($lang->is_default == '1'){
                $defualtLang = $lang->code;
            }
        }
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $str .= "\n";

        $keyPosition = strpos($str, "APP_LANG=");
        $endOfLinePosition = strpos($str, "\n", $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
        if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
            $str .= "APP_LANG=".$values['APP_LANG']."\n";
        } else {
            $str = str_replace($oldLine, "APP_LANG=".implode(',',$values['APP_LANG']), $str);
        }


        $keyPosition = strpos($str, "APP_DEFUALT_LANG=");
        $endOfLinePosition = strpos($str, "\n", $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
        if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
            $str .= "APP_DEFUALT_LANG=".$defualtLang."\n";
        } else {
            $str = str_replace($oldLine, "APP_DEFUALT_LANG=".$defualtLang, $str);
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;


    }
}
