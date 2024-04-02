<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Http\Requests\DepartementRequest;

class DepartementController extends Controller
{
    public function index(Departement $departement){
        $departements = Departement::paginate(10);
        return view('Departements.index', compact('departements'));
    }

    public function create(){
        return view('Departements.create');
    }

    public function store(Departement $departement,DepartementRequest $request){
         /*Departement::create([
            'name'=> $request->name
        ]);*/
       try{
            $departement->name = $request->name;
            $departement->save();
        } catch(Exception $e) {
            dd($e);
        }
        
        return redirect()->route('departement.index')->with('error_msg','Département ajouté avec succèss');
    }

    public function edit(Departement $departement){
        
        return view('Departements.edit',compact('departement'));
    }

    public function update(Departement $departement,DepartementRequest $request){
    
      try{
           $departement->name = $request->name;
           $departement->save();
       } catch(Exception $e) {
           dd($e);
       }
       
       return redirect()->route('departement.index')->with('success_msg','Modification éffectué avec succèss');
   }
   public function delete(Departement $departement){
  try{
       
       $departement->delete();
   } catch(Exception $e) {
       dd($e);
   }
   
   return redirect()->route('departement.index')->with('error_msg','Suppression éffectué avec succèss');
}
}