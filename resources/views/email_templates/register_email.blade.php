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
                        Dear {{$first_name}} {{$last_name}}:
                      </span>
                      <span style="clear:both;float:left;">
                        This email contains link to register for
                      </span>
                      <span style="clear:both;float:left;">
                        <a href="{{url('')}}">{{url('')}}</a>
                      </span>
                    </p>
                    <p style="float:left;clear: both;">
                      If this link does not open 'register' page upon clicking, trying copying and pasting this link in the address bar of your internet browser.
                    </p>
                    <p style="float:left;clear: both;">
                      <a href="{{url('register/verification/'.$token)}}">
                       {{url("register/verification/$token")}}
                      </a>
                    </p>
                    <p style="float:left;clear: both;">
                      <span style="clear:both;float:left;">
                        If you did not request to register, please ignore this email. Your email cannot be register unless the link above is clicked within next 24 hours.
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
