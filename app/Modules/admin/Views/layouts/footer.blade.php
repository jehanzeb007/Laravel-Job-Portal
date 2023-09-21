<div id="footer"> 
    <div class="hbiAdmin_footerInnerLeft"> Copyright &copy; {{date('Y')}}  All Rights Reserved. </div>
    <div class="hbiAdmin_footerInnerRight">
        <ul>
            <li>aa</li>
            <li style="padding-right:0px;">wqq</li>
            
        </ul>
    </div>

    <div class="clr"></div>
</div>
<script>
    // confirmation before delete
    $(document).ready(function() {
        $("#calendar_date" ).datepicker({dateFormat: "mm-dd-yy"});
        
        $('.delete-it').click(function() {
            return confirm("Are you sure want to delete?");
        });
        $( "#success-message" ).fadeOut( 9000);
    });
</script>
@if ($errors->any())
    @foreach($errors->toArray() as $field=>$error)
        <script>
            $('label[for="{{$field}}"]').attr('style', 'color:#C51E1E');
        </script>
    @endforeach
@endif
