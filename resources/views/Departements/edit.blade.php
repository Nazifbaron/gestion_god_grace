@extends('layouts.template');

@section('content')
<h1 class="app-page-title">Departements</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
	                <div class="col-12 col-md-4">
		                <h3 class="section-title">Editer</h3>
		                <div class="section-intro">Editer ici un departement </div>
	                </div>
	                <div class="col-12 col-md-8">
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form" method="post" action="{{route('departement.update',$departement->id)}}">
                                @csrf
                                @method('put')
									

								    <div class="mb-3">
                                        <label for="setting-input-1" class="form-label">Nom Département</label>
                                        <input type="text" class="form-control" id="setting-input-1" name="name" value="{{$departement->name}}" placeholder="Entrer un nom de département" required>
										@error('name')
										<div class="text-danger"> {{$message}}</div>
									@enderror
									</div>
									
									<button type="submit" class="btn app-btn-primary" >Modifier</button>
							    </form>
						    </div><!--//app-card-body-->
						    
						</div><!--//app-card-->
	                </div>
                </div><!--//row-->
            
@endsection