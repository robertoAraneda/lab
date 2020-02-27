@extends('layouts.app')

@section('content')
<div class="container">

        <detail-analyte-component :analyte="{{ $analyte }}"></detail-analyte-component>
 

</div>
@endsection