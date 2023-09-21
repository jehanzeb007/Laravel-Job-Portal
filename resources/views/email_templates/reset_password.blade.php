<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
    <title>Toil</title>
  </head>
  <body style="font-family: Verdana; font-size: 10pt;">
    <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="text-align: left; background-color: #ffffff; color: #000000; font-size: 12px; margin: 0;" width="600">
      <tbody>
        <tr>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" style="line-height: 1.5; font-size: 12px; font-family: arial;" width="600">
              <tbody>
                <tr>
                  <td style="padding-top: 30px; padding-left: 5px; padding-right: 5px;" valign="top">
                    <p style="font-size: 12px;float:left;clear: both;">
                      <span style="clear:both;float:left;">
                        Dear {{$user->first_name}} {{$user->last_name}}:
                      </span>
                      <span style="clear:both;float:left;">
                        This email contains link to reset your password for
                      </span>
                      <span style="clear:both;float:left;">
                        <a href="{{url('')}}">{{url('')}}</a>
                      </span>
                    </p>
                    <p style="float:left;clear: both;">
                      If this link does not open 'reset password' page upon clicking, trying copying and pasting this link in the address bar of your internet browser.
                    </p>
                    <p style="float:left;clear: both;">
                      @if($user->is_admin==1)
                      <a href="{{url('admin/send_mail/'.$token)}}">
                        {{url("admin/send_mail/$token")}}
                      </a>
                      @else
                        <a href="{{url('send_mail/'.$token)}}">
                        {{url("send_mail/$token")}}
                      </a>
                      @endif
                    </p>
                    <p style="float:left;clear: both;">
                      <span style="clear:both;float:left;">
                        If you did not request to reset your password, please ignore this email. Your password cannot be changed unless the link above is clicked within next 24 hours.
                      </span>
                    </p>
                    <p style="float:left;clear: both;">
                      <span style="clear:both;float:left;">
                        Thank you,
                      </span>
                      <span style="clear:both;float:left;">
                        Toil Administration
                      </span>
                    </p>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
