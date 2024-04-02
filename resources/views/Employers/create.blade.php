@extends('layouts.template');

@section('content')
<h1 class="app-page-title">Employers</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
	                <div class="col-12 col-md-4">
		                <h3 class="section-title">Ajouter</h3>
		                <div class="section-intro">Ajouter ici un employer </div>
	                </div>
	                <div class="col-12 col-md-8">
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form" method="post" action="{{route('employer.store')}}">
                                @csrf
                                @method('post')

                                    <div class="mb-3">
									    <label for="setting-input-3" class="form-label"> Département </label>
                                        <select name="departement_id" id="departement_id" class="form-control">
                                            <option value=""></option>
											@foreach ($departements as $departement)
												<option value="{{$departement->id}}">{{$departement->name}}</option>
											@endforeach
                                        </select>
										@error('departement_id')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>

								    <div class="mb-3">
                                        <label for="setting-input-1" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="setting-input-1" name="first_name" placeholder="Entrer un nom" required>
										@error('first_name')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>
									<div class="mb-3">
									    <label for="setting-input-2" class="form-label">Prenom</label>
									    <input type="text" class="form-control" id="setting-input-2" name="last_name" placeholder="Entrer un prenom" required>
										@error('last_name')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>
								    <div class="mb-3">
									    <label for="setting-input-3" class="form-label"> Email </label>
									    <input type="email" class="form-control" id="setting-input-3" name="email" placeholder="Entrer le mail">
										@error('email')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>
                                    <div class="mb-3">
									    <label for="setting-input-3" class="form-label"> Contact </label>
									    <input type="text" class="form-control" id="setting-input-3" name="telephone" placeholder="numero">
										@error('telephone')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>
									<div class="mb-3">
									    <label for="setting-input-3" class="form-label"> Montant Journalier </label>
									    <input type="number" class="form-control" id="setting-input-3" name="montant_journalier" placeholder="Entrer le montant">
										@error('montant_journalier')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>
									<button type="submit" class="btn app-btn-primary" >Enrégistrer</button>
							    </form>
						    </div><!--//app-card-body-->
						    
						</div><!--//app-card-->
	                </div>
                </div><!--//row-->
            
@endsection