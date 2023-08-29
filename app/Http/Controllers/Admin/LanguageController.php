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
        Schema::table('before_photos', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('text_'.$defualt, function ($table) use ($lang) {
                $table->string('text_'.$lang)->nullable();
            });

        });
        Schema::table('comments', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('comment_'.$defualt, function ($table) use ($lang) {
                $table->string('name_'.$lang)->nullable();
                $table->string('position_'.$lang)->nullable();
                $table->text('comment_'.$lang)->nullable();
            });
        });
        Schema::table('doctors', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('text_'.$defualt, function ($table) use ($lang) {
                $table->string('name_'.$lang)->nullable();
                $table->string('position_'.$lang)->nullable();
                $table->string('text_'.$lang)->nullable();
            });
        });
        Schema::table('faqs', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('answer_'.$defualt, function ($table) use ($lang) {
                $table->string('question_'.$lang)->nullable();
                $table->text('answer_'.$lang)->nullable();
            });
        });
        Schema::table('landings', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('name_'.$defualt, function ($table) use ($lang) {
                $table->string('name_'.$lang)->nullable();
            });

        });
        Schema::table('landing_settings', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('settings_'.$defualt, function ($table) use ($lang) {
                $table->json('settings_'.$lang)->nullable();
            });
        });

        // $settingsDefault = DB::table('landing_settings')->select('settings_'.$defualt)->get();

        // foreach ($settingsDefault as $data) {
        //     LandingSetting::where('settings_'.$defualt, $data->{'settings_'.$defualt})
        //         ->update(['settings_'.$lang => $data->{'settings_'.$defualt}]);
        // }
        Schema::table('services', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('name_'.$defualt, function ($table) use ($lang) {
                $table->string('name_'.$lang)->nullable();
            });
        });
        Schema::table('sliders', function (Blueprint $table) use ($lang,$defualt) {
            $table->after('link_text_'.$defualt, function ($table) use ($lang) {
                $table->string('title_'.$lang)->nullable();
                $table->string('description_'.$lang)->nullable();
                $table->string('link_text_'.$lang)->nullable();
            });
        });

    }




    private function tableDropColumn($lang){
        Schema::table('before_photos', function (Blueprint $table) use ($lang) {
            $table->dropColumn('text_'.$lang);
        });
        Schema::table('comments', function (Blueprint $table) use ($lang) {
            $table->dropColumn('name_'.$lang);
            $table->dropColumn('position_'.$lang);
            $table->dropColumn('comment_'.$lang);
        });
        Schema::table('doctors', function (Blueprint $table) use ($lang) {
            $table->dropColumn('name_'.$lang);
            $table->dropColumn('position_'.$lang);
            $table->dropColumn('text_'.$lang);
        });
        Schema::table('faqs', function (Blueprint $table) use ($lang) {
            $table->dropColumn('question_'.$lang);
            $table->dropColumn('answer_'.$lang);
        });
        Schema::table('landings', function (Blueprint $table) use ($lang) {
            $table->dropColumn('name_'.$lang);
        });
        Schema::table('landing_settings', function (Blueprint $table) use ($lang) {
            $table->dropColumn('settings_'.$lang);
        });
        Schema::table('services', function (Blueprint $table) use ($lang) {
            $table->dropColumn('name_'.$lang);
        });
        Schema::table('sliders', function (Blueprint $table) use ($lang) {
            $table->dropColumn('title_'.$lang);
            $table->dropColumn('description_'.$lang);
            $table->dropColumn('link_text_'.$lang);
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
