@extends('layouts.template');

@section('content')
<h1 class="app-page-title">Configurations</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
	                <div class="col-12 col-md-4">
		                <h3 class="section-title">Ajouter</h3>
		                <div class="section-intro">Nouvelle Configuration </div>
	                </div>
	                <div class="col-12 col-md-8">
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form" method="post" action="{{route('configurations.store')}}">
                                @csrf
                                @method('post')
									

								    <div class="mb-3">
                                        <label for="setting-input-1" class="form-label">Type de configurations</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value=""></option> 
                                                <option value="PAYEMENT_DATE">Date de paiement</option>
                                                <option value="APP_NAME">Nom de l'application</option>
                                                <option value="DEVELOPPER_NAME">Equipe de Developpement</option>
                                                <option value="ANOTHER">Autre Option</option>

                                            </select>										@error('type')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>

								    <div class="mb-3">
                                        <label for="setting-input-1" class="form-label">Valeur</label>
                                        <input type="text" class="form-control" id="setting-input-1" name="value" value="{{old('value')}}" placeholder="Entrer la valeur" required>
										@error('value')
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