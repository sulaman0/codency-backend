<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ empty($emailTemplateTitle) ? 'Email': $emailTemplateTitle }}</title>
</head>

<style>
    @media only screen and (max-width: 425px) {
        .m_-4742265021905027275mercado-email-container {
            margin: 0 auto;
            max-width: unset;
        }
    }
</style>
<body style="margin:0">
<table role="presentation" align="center" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#F3F2EF"
       style="background-color:#f3f2ef;table-layout:fixed">
    <tbody>
    <tr>
        <td align="center" bgcolor="#ffffff" style="background-color:#ffffff;">
            <center style="width:100%">
                <table role="presentation" border="0" class="m_-4742265021905027275mercado-email-container"
                       cellspacing="0" cellpadding="0" width="512" bgcolor="#FFFFFF"
                       style="background-color:#9d242b;margin:0 auto;max-width:750px;width:inherit">
                    <tbody>
                    <tr>
                        <td bgcolor="#9d242b"
                            style="background-color:#9d242b;padding:18px 24px 0 24px; border-top: 10px solid #ffffff">
                            <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%"
                                   style="width:100%!important;min-width:100%!important">
                                <tbody>
                                <tr>
                                    <td align="left" valign="middle">
                                        <a
                                            href="{{ url('/') }}"
                                            style="color:#9d242b;display:inline-block;text-decoration:none"
                                            target="_blank"
                                            data-saferedirecturl="https://www.google.com/url?q={{ url('/') }}">
                                            <img alt="Codency" border="0"
                                                 src="https://codency.pmitc.com.sa/assets/media/logos/demo3.png"
                                                 height="150"
                                                 style="max-height:150px;outline:none;color:#ffffff;max-width:unset!important;text-decoration:none;margin:-12px 0 0 -15px"
                                                 class="CToWUd">
                                        </a>
                                    </td>
                                    <td valign="middle" width="100%" align="right"><a
                                            href="{{ url('/') }}"
                                            style="margin:0;color:#9d242b;display:inline-block;text-decoration:none"
                                            target="_blank"
                                            data-saferedirecturl="https://www.google.com/url?q={{ url('/') }}">
                                            <p style="margin:0;font-weight:400"></p><span
                                                style="word-wrap:break-word;
                                                color:#ffffff;word-break:break-word;
                                                font-family: Arial, Helvetica, sans-serif;
                                                font-weight:400;font-size:14px;
                                                line-height:1.429">Mr. {{ $username  }}</span>
                                            <table role="presentation" border="0" cellspacing="0" cellpadding="0"
                                                   width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="left" valign="middle"
                                                        style="padding:0 0 0 10px;padding-top:7px"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @yield("main-content")
                    <tr>
                        <td>
                            <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%"
                                   bgcolor="#F3F2EF" align="left"
                                   style="background-color:#f3f2ef;padding-top:16px;color:#000000;text-align:left">
                                <tbody>
                                <tr>
                                    <td>
                                        <table width="24" border="0" cellspacing="0" cellpadding="1">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div style="height:0px;font-size:0px;line-height:0px"> &nbsp;</div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0"
                                               width="100%">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <table role="presentation" border="0" cellspacing="0"
                                                           cellpadding="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <table width="1" border="0" cellspacing="0"
                                                                       cellpadding="1">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div
                                                                                style="height:12px;font-size:12px;line-height:12px">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="padding:0;color:#000000;text-align:left"><p
                                                                    style="margin:0;word-wrap:break-word;color:#000000;
                                                                    word-break:break-word;
                                                                    font-family: Arial, Helvetica, sans-serif;
                                                                    font-weight:400;font-size:12px;line-height:1.333">
                                                                    This email was intended for {{$username}}.

                                                                    {{--                                                                    <a--}}
                                                                    {{--                                                                        href="{{ route('privacy_policy') }}"--}}
                                                                    {{--                                                                        style="color:#9d242b;text-decoration:underline;display:inline-block"--}}
                                                                    {{--                                                                        target="_blank"--}}
                                                                    {{--                                                                        data-saferedirecturl="https://www.google.com/url?q={{ url('privacy_policy') }}">--}}
                                                                    {{--                                                                        Learn--}}
                                                                    {{--                                                                        why we included this.</a>--}}
                                                                </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table width="1" border="0" cellspacing="0"
                                                                       cellpadding="1">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div
                                                                                style="height:12px;font-size:12px;line-height:12px">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="padding:0;color:#000000;text-align:left"><p
                                                                    style="margin:0;
                                                                    font-family: Arial, Helvetica, sans-serif;
                                                                    color:#000000;font-weight:400;font-size:12px;line-height:1.333">
                                                                    You're receiving this email because you (or someone
                                                                    using this email) created an account on Codency
                                                                    using this address.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="padding:16px 0 0 0;text-align:left"></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="padding:0;text-align:left"><a
                                                                    href="{{ route('sign_in') }}"
                                                                    style="color:#9d242b;text-decoration:underline;display:inline-block"
                                                                    target="_blank"
                                                                    data-saferedirecturl="https://www.google.com/url?q={{route('sign_in')}}">
                                                                    <img
                                                                        alt="Codency" border="0" height="100"
                                                                        src="https://codency.pmitc.com.sa/assets/media/logos/demo3.png"
                                                                        style="outline:none;color:#ffffff;max-width:unset!important;display:block;text-decoration:none;margin:-10px 0 -30px -10px"
                                                                        class="CToWUd"></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="padding:0;color:#000000;text-align:left"><p
                                                                    style="margin:0;
                                                                    font-family: Arial, Helvetica, sans-serif;
                                                                    color:#000000;font-weight:400;font-size:12px;line-height:1.333">
                                                                    © 2024 Codency Saudi Arabia Company.</p></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table width="1" border="0" cellspacing="0"
                                                                       cellpadding="1">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div
                                                                                style="height:24px;font-size:24px;line-height:24px">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table width="24" border="0" cellspacing="0" cellpadding="1">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div style="height:0px;font-size:0px;line-height:0px"> &nbsp;</div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </center>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>

