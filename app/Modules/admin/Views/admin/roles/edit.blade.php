@extends('layouts.layout')
@section('title')    
    {{Config::get('constants.site.name')}} | Edit Role
@stop
@section('header_assets')
    @parent
    {!! HTML::style('assets/public/css/footable-0.1.css') !!}
    {!! HTML::style('assets/public/css/footable.sortable-0.1.css') !!}
    <style type="text/css">
        .form-horizontal .control-label {
            text-align: left;
        }
        .header{
            margin-left: 15px;
        }
        .tab-content{
            margin-left: 15px;
        }
        .nav-pills > li.active > a {
            background-color: #eee !important; 
            color: #3342b7;
            font-size: 16px;
        }
        .nav-pills > li > a {
            height: 45px;
            background-color: #eee !important; 
            color: #333;
            font-size: 16px;
        }
        
        .box{
            background-color: #fff !important;
            border: 1px solid #ccc;
            padding: 0px;
            margin-right: 80px;
            margin-bottom: 35px;
        }
        .head{
            
            width: 100%;
            height: 30px;
            text-transform: uppercase;
            padding-left: 20px;
            padding-top: 5px;
            color: #f5f5f5;
        }
        .left-side{
                
            padding: 0px;   
            padding-top: 15px; 

        }
        .rigth-side{
            border-left: 1px solid #ccc;
            padding-top: 10px;
            padding-bottom: 20px;
        }
        .border{
            border-bottom: 1px solid #ccc;
            margin-top: 5px;
            margin-left: -7px;
            margin-right: -7px;
            margin-bottom: 10px;
        }
        .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
            color: #3342b7;
        }
        #roleTab .nav  li.active{ background: #eee;}
        #roleTab{
            margin-bottom: 40px;
        }

    </style>
@show
@section('main')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div>
            <div class="pull-left">
                <h1 class="section-title-inner">
                    <span>Edit Role</span>
                </h1>
            </div>
            <div class="pull-right"><h4 class="caps"><a href="{{route('roles')}}"><i class="fa fa-chevron-left"></i> Back </a></h4></div>
            <div class="clearfix"></div>
        </div>
        <hr/>

        {!! Form::model($role, ['method' => 'post','url' => [route('update_role'), $role->id],'class' => 'form-horizontal']) !!}
    
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div id="roleTab" >
            <ul id="myTab" class="nav nav-pills">
                <li role="presentation"  class="active"><a class="camel-cse" href="#general_info" data-toggle="pills">General Information</a>

                </li> 
                <li role="presentation"  style="padding-left: 5px;"><a class="camel-cse" href="#rights" data-toggle="pills">Rights</a></li>
            </ul>  
        </div>
         

        <div class="tab-content">
            <div  class="tab-pane active" id="general_info">
                    <div style="display:none;">
                            {!! Form::text('id', $role->id, ['class' => 'form-control']) !!}
                    </div>  
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                            {!! Form::label('name', 'Name: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('display_name') ? 'has-error' : ''}}">
                            {!! Form::label('display_name', 'Display Name: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                            {!! Form::label('description', 'Description: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
            </div>

            <div  class="tab-pane" id="rights">
            
                @foreach($permission as $value)

                    <div  class=" box col-sm-5 roles-box">
                        
                        <div class="head primary_color" >
                            <h4>{{$value->name}}</h4> 
                        </div>
                        <div class="left-side col-sm-4">

                            <div class="col-sm-2">
                                {!! Form::checkbox('parent_name[]', null, null, array('class' => 'parent','id'=>'parent_checkbox'.$value->id, 'onClick' => "selectParentRole($value->id)")) !!}
                            </div>
                            <div class="col-sm-8">
                               {!! Form::label('parent_name[]', $value->name , array('style'=>'font-weight: 600;')) !!}
                            </div>
                        </div>
                        
                        <div class="rigth-side col-sm-8">
                            @foreach($value->children as $v)

                                <div class="row" style="margin-bottom:5px;">
                                    <div class="col-sm-1">
                                        @if(in_array($v->id, $permission_id))
                                            {!! Form::checkbox('child_name['.$v->id.']', null, true, array('class'=>'childs child_checkbox'.$value->id, 'onClick' => "selectChildRole($value->id)")) !!}
                                        @else
                                            {!! Form::checkbox('child_name['.$v->id.']', null, null, array('class'=>'childs child_checkbox'.$value->id, 'onClick' => "selectChildRole($value->id)")) !!}
                                        @endif 
                                    </div>
                                    <div class="col-sm-8">
                                       <label style=" font-weight: normal;">{{$v->name}}</label> 
                                    </div>
                                </div>
                                <div class="border"> 
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-9 col-sm-3">
        {!! Form::submit('Edit Role', ['class' => 'btn btn-primary form-control primary_color']) !!}
    </div>
</div>

@section('footer_assets')
    @parent
    <script>
        
        function selectParentRole(id) {
            
            var id = id;
            
            $("#parent_checkbox"+id).change(function () {
                $(".child_checkbox"+id).prop('checked', $(this).prop("checked"));
            });
        }

        function selectChildRole(id) {
            var id = id;
            var child = $('.child_checkbox'+id).length;
            var checked_child = $('.child_checkbox'+id+':checked').length;
            var difference = child - checked_child;

            if (difference==0){
                $("#parent_checkbox"+id).prop('checked', true);
            }else{
                $("#parent_checkbox"+id).prop('checked', false);
            }       
        }

        $(document).ready(function(){
            $("#myTab a").click(function(e){
                e.preventDefault();
                $(this).tab('show');

            });

            updateRolesChecks();
        });

        function updateRolesChecks(){
            $(".roles-box").each(function(){
                var childCheck = $(this).find('.childs').length;
                var selectedChild = $(this).find('.childs:checked').length;
                if(selectedChild != 0 && selectedChild == childCheck){
                    $(this).find('.parent').attr("checked","checked");
                }
            })
        }

    </script>
@show

@stop