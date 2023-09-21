@extends('default.main_layout')

@section('home')

<section class="job-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-7 co-xs-12 text-left">
                <h3>{{$page->title}}</h3>
            </div>
        </div>
    </div>
</section>
<section class="single-job-section single-job-section-2">
    <div class="container">
        <div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="single-job-detail-box">
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="job-detail-2">
                            <h2>{{$page->title}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="single-job-page-2 job-short-detail">
                        <div class="heading-inner">
                            <p class="title">Description</p>
                        </div>
                        <div class="job-desc job-detail-boxes">
                            <p>
                                {{$page->long_description}}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop