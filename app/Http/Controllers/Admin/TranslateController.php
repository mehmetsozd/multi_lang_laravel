<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translate;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function index()
    {
        // Path to the project's root folder
        $translateFile = base_path().'/resources/lang/tr/index.php';
        $translateFile = require_once ($translateFile);
        $defualtTranslates = [];
        foreach ($translateFile as $key=>$value){
            $defualtTranslates[$key] = $value;
        }
        $defualtTranslateJson = json_encode($defualtTranslates);
        return view('admin.translate', compact('defualtTranslates','defualtTranslateJson'));
    }
    public function list(){
        $translates = Translate::select(['id','code']);
        return Datatables::of($translates)->toJson();
    }
    public function edit(Request $request){
        $request->validate([
            'translate_id' => 'required|exists:translates,id',
        ]);
        $translate = Translate::where('id',$request->translate_id)->first();
        return response()->json($translate);
    }

    public function update(Request $request){
        $request->validate([
            'translate_id' => 'required|exists:translates,id',
        ]);
        $translate = Translate::where('id',$request->translate_id)->first();
        $translate->translate = $request->translate;
        $translate->save();
        return response()->json(['message' => 'Translate updated successfully']);
    }

}
