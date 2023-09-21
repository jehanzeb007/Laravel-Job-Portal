<?php 
    if (!empty($attributes)) {
        $id = $item['id'];
        if ($id==null) {
            $id = 0;
        }
    }
?>
<div class="cpt_data">
    <div class="row">   
        <div class="col-md-6 col-xs-6 col-sm-6">
            <div class="form-group  {{ $errors->has('name.'.$index) ? 'has-error' : ''}}"style=" margin-right: 1px;">
                {!! Form::label('name[]', 'Attribute') !!}
                 <input type="text" name="name[]" placeholder="Attribute Name" class="paid form-control" value="<?=!empty($item['name']) ? $item['name'] : null?>" />
            </div>
            <div style="display:none;">
                @if (empty($attributes)) 
                    {!! Form::text('name_id[]', null, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('name_id[]', $item['id'], ['class' => 'form-control']) !!}
                @endif
            </div>
        </div>
        <div class="add col-md-2 col-xs-2 col-sm-2">
            {!! Form::button('+', ['class' => 'btn btn-success form-control', 'onclick' =>'cloneMe()'] ) !!}
        </div>
        @if (empty($attributes)) 
            <div class="remove col-md-2 col-xs-2 col-sm-2" style="display: none;">
                {!! Form::button('-', ['class' => 'remove_clone btn btn-danger form-control','onclick' =>'removeMe(this)'] ) !!}
            </div>
        @else
            <div class="remove col-md-2 col-xs-2 col-sm-2" style="<?=$index == 0 ? 'display: none;' : 'display: block'; ?>">
                {!! Form::button('-', ['class' => 'remove_clone btn btn-danger form-control','onclick' =>"removeMe(this,$id)"] ) !!}
            </div>
        @endif
        

    </div>
</div>
