@extends('email_templates.base.layout')
@section('main-content')
    <tr>
        <td>
            <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%"
                   style="padding-top:24px">
                <tbody>
                <tr>
                    <td align="left" style="padding:0 36px">
                        <h2 style="padding:0;margin:0;color:#000000;font-weight:500;font-size:24px;line-height:1.333">
                            Your verification code is : {{ $verificationCode }}</h2>
                        <p class="m_-4742265021905027275option-text m_-4742265021905027275option-text--variant-2"
                           style="padding-top:16px;margin:0;color:rgba(0,0,0,0.9);font-weight:400;font-size:16px;line-height:1.25">
                            Your account can’t be accessed without this verification code, even if you didn’t submit
                            this request.</p>

                        <p class="m_-4742265021905027275option-text m_-4742265021905027275option-text--variant-2"
                           style="padding-top:16px;padding-bottom:16px;margin:0;color:rgba(0,0,0,0.9);font-weight:400;font-size:16px;line-height:1.25">
                            To keep your account secure, we recommend using a unique password for your ExpertApp account or
                            using the ExpertApp
                            Account Access to sign in. ExpertApp Account Access’ two-factor authentication makes signing
                            in to your account easier, without needing to remember or change passwords
                        </p>

                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
@endsection
