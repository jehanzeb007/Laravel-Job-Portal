<ul class="fl w400 sec-questions">
  <div class="clr"></div>
  <li class="txt_1">Reset with Security Question</li>

  @if( $questions['sec_question_1'] && $questions['sec_question_2'] )
    
    <input type="hidden" name="uid" id="sec-uid" value="{{ $userId }}">

    <li>
      <label>{{ $questions['sec_question_1'] }}</label>
      <input name="sec_answer_1" id="sec_answer_1" type="text" class="textInputPop fl"/>
      <div class="clr"></div>
    </li>

    <li>
      <label>{{ $questions['sec_question_2'] }}</label>
      <input name="sec_answer_2" id="sec_answer_2" type="text" class="textInputPop fl"/>
      <div class="clr"></div>
    </li>

    <li>
      <div class="siteButtonSmall"> <span>
        <input name="password" id="password" type="button" value="Recover your password" onclick="recoverViaSecAnswers()" />
        </span> 

        </div>
        <div class="clr"></div>
    </li>
    <li class="success sec-question-error" style="display:none; margin-top: 5px;"></li>
  @else
    <li class="success sec-question-error">Unfortunately, you don't have any security questions setup, please use the email section to reset your password.</li>
  @endif

  <div class="clr"></div>
</ul>

<script type="text/javascript">
  function recoverViaSecAnswers () {

    $('.sec-question-error').html('');
    $('.sec-question-error').hide();

    var sec_answer_1 = $('#sec_answer_1');
    var sec_answer_2 = $('#sec_answer_2');

    if ( !sec_answer_1 || !sec_answer_2 ) {
        $('.sec-question-error').html('* Both the security answers must be entered');
        $('.sec-question-error').show();

        return;   
    };

    $.ajax({
        method: "POST",
        url: "{{URL::route('recoverPassViaSecAnswers')}}",
        data: { sec_answer_1: $('#sec_answer_1').val(), sec_answer_2: $('#sec_answer_2').val(), userId: $('#sec-uid').val(),_token:$("input[name=_token]").val() },
        success: function ( response ) {
          if ( (response.status == 'success') && response.url ) {
            window.location = response.url + "?camefrom=secanswers";
          } else if(response.status != 'error'){
            $('.sec-questions').html( response );
          } else {
            
            if ( response.blocked == 'yes' ) {
                $('.sec-questions li:not(".sec-question-error"):not(".txt_1")').remove();
                $('.sec-question-error').attr('style', 'display: list-item; margin-top: 20px;')
            }

            $('.sec-question-error').html('* ' + response.message);
            $('.sec-question-error').show();
          }
        }
    });
  }
</script>