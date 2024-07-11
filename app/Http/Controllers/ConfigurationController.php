<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Requests\ConfigRequest;


class ConfigurationController extends Controller
{
    public function index(){
        $allConfigurations = Configuration::latest()->paginate(10);
        return view('config/index',compact('allConfigurations'));
    }

    public function create(){
        return view('config/create');
    }
    public function store(ConfigRequest $request){
        try{

            Configuration::create($request->all());
            return redirect()->route('configurations.index')->with('success_msg','Configuration ajouter avec succès');
        }catch(Exception $e){
            dd($e);
        }
    }

    public function delete(Configuration $configuration){
       try{

        $configuration-> delete();

        return redirect()->route('configurations.index')->with('success_msg','Configuration supprimer avec succès');
        }catch(Exception $e){
            dd($e);
        }
    }
}
