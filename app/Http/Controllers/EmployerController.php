<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Departement;
use App\Http\Requests\EmployerRequest;
use App\Http\Requests\UpdateRequest;


class EmployerController extends Controller
{
    public function index(Employer $employer){
        $employers = Employer::with('departement')->paginate(10);
        return view('Employers.index', compact('employers'));
    }

    public function create(){
        $departements = Departement::all();
        return view('Employers.create',compact('departements'));
    }

    public function edit(Employer $employer){
        $departements = Departement::all();
        return view('Employers.edit', compact('employer','departements'));
    }

    public function store(Employer $employer,EmployerRequest $request){
        //dd($request);
       /* $query = Employer::create($request->all());
        if($query){
            return redirect()->route('employer.index')->with('success_message','Employer ajouté');
        } autre façon de créer des utilisateurs seulement avec cette méthode les names doivent etre égale a ce qui ce trouve dans la base de donnée et le model et puis dans le model on fait : protected $guarded=['']*/
        
        try{
            $employer->nom = $request->first_name;
            $employer->prenom = $request->last_name;
            $employer->telephone = $request->telephone;
            $employer->email = $request->email;
            $employer->departement_id = $request->departement_id;
            $employer->montant_journalier = $request->montant_journalier;

            $employer->save();
        }catch(exception $e){

        }
    }

    public function update(UpdateRequest $request,Employer $employer){
        try{
            $employer->nom = $request->first_name;
            $employer->prenom = $request->last_name;
            $employer->telephone = $request->telephone;
            $employer->email = $request->email;
            $employer->departement_id = $request->departement_id;
            $employer->montant_journalier = $request->montant_journalier;

            $employer->update();

            return redirect()->route('employer.index')->with('success_message','Employer modifier avec success');
        }catch(exception $e){

        }
    }

    public function delete( Employer $employer){
        try{
            $employer->delete();

            return redirect()->route('employer.index')->with('success_message','Employer supprimer avec success');
        }catch(exception $e){
            dd( $e);
        }
    }
}
