@extends('layouts.layout')
@section('title')    
    {{Config::get('constants.site.name')}} | Unauthorized
@stop
@section('main')	
	you are not Authorized
@stop
@show