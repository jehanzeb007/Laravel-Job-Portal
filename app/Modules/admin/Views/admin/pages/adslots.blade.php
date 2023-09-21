@extends('layouts.admin.admin')

@section('main')

<h1>Link Ad Slots</h1>

{{ Form::open(array('route' => '')) }}
<ul>
    <li>
        {{ Form::label('select_page', 'Select Page:') }}
        {{ Form::select('page_id', $pagesArray, 1, array('id' => 'page_id')) }}
    </li>

    <li>
        {{ Form::label('select_slot', 'Select Slot:') }}
        {{ Form::select('sequence', $slotsArray, 1, array('id' => 'sequence')); }}
    </li>

    <li>
        {{ Form::label('select_ad_type', 'Select Ad Type:') }}
        {{ Form::select('slotable_type', $slotableTypeArray, 'testimonial', array('id' => 'slotable_type')); }}
    </li>
    
    <li id="li-slotable">
        {{ Form::label('slotables_id', 'Select:') }}
        {{ Form::select('slotable_id', array(), null,array('id' => 'slotable_id')); }}
    </li>

    <li>
        {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
    </li>
</ul>
{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
</ul>
@endif
@stop

@section('admin_assets')
@parent
<script>
    $( document ).ready(function() {
        @if(count($filledSlots))
            populatFields();
        @endif
        
        $("#page_id").change(function() {
            $('#sequence').val('1');
            $('#slotable_type').val('1');
            //$("#li-slotable").hide();
            
            @if(count($filledSlots))
                populatFields();
            @endif
        });
        
        $("#sequence").change(function() {
            $('#slotable_type').val('1');
             populatSubFields();
            
        });
        
        $("#slotable_type").change(function() {
             populatSubFields();
            
        });
        
    });
    
    /**
     * Function to set slotable dropdown options
     * @param: Slotable type
     */
    function setAdsData(type) {
        $('#slotable_id option').remove();
        var list = $('#slotable_id');
        @foreach($slotsData as $type=>$slotable)
            if(type == '{{{ $type }}}') {
                @foreach($slotable as $key=>$value)
                    list.append(new Option( '{{{ $value["title"] }}}' , '{{{ $value["id"] }}}' ));
                @endforeach   
            }
        @endforeach
    }
    /**
     *Populate  page slots
     **/ 
    function populatFields() {
        //Resetting slotable
        $('#slotable_id option').remove();
        var list = $('#slotable_id');
        //settng ads data
        setAdsData($('#slotable_type').val());
        //end setting ads data
        @foreach($filledSlots as $page_id=>$value)
            // If page is already set
            if($('#page_id').val() == '{{ trim($page_id )}}' ) {
                // Getting sequence/slots that have been set against this page
                @foreach($value as $sequence=>$types) 
                    $('#sequence').val('{{ $sequence }}');
                    @foreach($types as $type=>$ads)
                        var type = '{{{ $type }}}';
                        $('#slotable_type').val(type);
                        if(type != 'testimonial') {
                            @if(count($ads))
                                $('#li-slotable').show();
                                //resettng ads data
                                setAdsData(type);
                                //end setting ads data
                                @foreach($ads as $slotable_id=>$slotable_title)
                                      list.val('{{{ $slotable_id }}}');

                                @endforeach
                            
                            @endif    
                        } else {
                            $('#li-slotable').hide();
                        }
                        
                    @endforeach
                
                @endforeach
            }
        @endforeach
    }
    /**
     *Populate sub fields
     **/ 
    function populatSubFields() {
        $('#li-slotable').show();
       setAdsData($('#slotable_type').val());
    }
</script>

@stop
