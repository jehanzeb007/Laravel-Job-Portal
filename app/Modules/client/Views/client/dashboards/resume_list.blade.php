@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Resume List
@stop
@section('resume_list')    
    class="active"
@stop
@section('top_nav')

@stop<div>@include('default.top_nav',['user'=>$user])</div>
@section('header_bar')

<section class="job-breadcrumb">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-sm-7 co-xs-12 text-left">
            <h3>Edit profile</h3>
         </div>
      </div>
   </div>
</section>
@stop
@section('body')
<style type="text/css">
    .form-horizontal .form-group {
        margin-left: 0px;
    }
</style>
<section class="dashboard-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 col-sm-4 col-xs-12">
                   @include('client::client.left_side_image_bar',['$user'=>$user])
                   @include('client::client.left_side_bar',['$user'=>$user])
                </div>

                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="heading-inner first-heading">
                        <p class="title">My Resume</p>
                        <a href="javascript:void(0)"><span class="pull-right add-button btn-default" data-toggle="modal" data-target=".add-resume-modal" id="resume_btn"> Add New Resume</span></a>
                    </div>
                    
                    <div class="resume-list">
                    	<div class="table-responsive">
                            <table class="table  table-striped">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Resume Title</th>
                                        <th>Download</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($resumes as $item)
                                    <tr>
                                        <td>
                                            <h5>{{$item->title}}</h5></td>
                                        <td><a class="btn btn-primary" href="{{route('download_file',$item->id)}}" title="{{$item->path}}"> Download </a></td>

                                        <td>{!! link_to_route('delete_resume', 'Delete', array($item->id), array('class' => 'btn btn-danger','title'=>"$item->path", "onclick"=>"return confirm('Are you sure?')")) !!}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="model" class="modal add-resume-modal in" tabindex="-1" role="dialog" aria-labelledby="" style="display: none; padding-right: 17px;">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            {!! Form::open(['url' => route('update_resume'), 'class' => 'form-horizontal','method' => 'post', 'files'=>'true']) !!}
                            
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add New Resume</h4>
                            </div>
                            <?php 
                                $value=0;
                                if(\Session::get('validate_fails')){
                                    $value=\Session::get('validate_fails');
                                } 
                            ?>
                           @if ($errors->any())
                              <ul class="alert alert-danger" >
                                 @foreach ($errors->all() as $error)
                                 <li >{{ $error }}</li>
                                 @endforeach
                              </ul>
                            @endif
                            <div class="modal-body">
                                <div class="input-group image-preview form-group {{ $errors->has('title') ? 'has-error' : ''}}"  style="width:100%">
                                    <label>Title</label>
                                    <input name="title" type="text" class="form-group" value="{{old('title')}}" style="width:100%"></input>
                                </div>
                              <input type="file" name="doc"  class="form-group {{ $errors->has('doc') ? 'has-error' : ''}}"> 
                                <p>Only pdf and doc files are accepted</p>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default">Save Resume</button>
                            </div>
                            {!! Form::close()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        if ({{$value}}==1) {
            $('#resume_btn').click();
        };
    });

</script>
@stop