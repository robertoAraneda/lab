@extends('layouts.app')

@section('content')
<div class="container">
    
        <h5 class="m-4">Resultado de la búsqueda: <span class="text-primary">"{{ $id }}"</span> </h5>

        <search-analyte-component props-search="{{ $id }}" :analytes="{{ $analytes }}"></search-analyte-component>
 

</div>
@endsection