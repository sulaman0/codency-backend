<?php

namespace App\Http\Controllers\Auth;

use App\AppHelper\AppHelper;
use App\Exceptions\CustomErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyForgetPasswordCodeRequest;
use App\Models\User;
use App\Notifications\Auth\ForgetPasswordCodeNotification;
use App\Service\Misc\VerificationCodeService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    /**
     * @throws \Exception
     */
    public function sendResetLinkEmail(Request $request, VerificationCodeService $resetPasswordCodeService)
    {

        $this->validateEmail($request);

        ## find user via email and send verification code to him, on his email address.
        $User = $this->findUserByEmail($request->email);
        if (!$User instanceof User) {
            throw new \Exception(__('common.email_not_exists'));
        }
        $verificationCode = $resetPasswordCodeService->generateNewCode($User->id);
        $User->notify(new ForgetPasswordCodeNotification($verificationCode));

        if ($request->wantsJson()) {
            return AppHelper::sendSuccessResponse(true, 'common.reset_password_code_sent_to_your_registered_email');
        } else {
            return redirect(url('login'))->with('success', __('passwords.sent'));
        }
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param string $response
     * @return RedirectResponse|JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return AppHelper::sendSuccessResponse(true, trans($response));
        } else {
            return back()->with('status', trans($response));
        }
    }


    function findUserByEmail($email)
    {
        return User::findUserByEmail($email);
    }

    function verifyResetPasswordCode(VerifyForgetPasswordCodeRequest $request, VerificationCodeService $resetPasswordCodeService): JsonResponse
    {
        try {
            $User = $this->findUserByEmail($request->email);
            if (!$User instanceof User) {
                throw new \Exception("No user found with this email");
            }
            $r = $resetPasswordCodeService->isCodeVerify($request->code, $User->id);

            $User->tokens()->delete();
            ## generate login token and return response.
            $TokenResult = $User->createToken(env('APP_KEY') . $User->id);

            return AppHelper::sendSuccessResponse($r,
                $r ? 'common.code_is_verified' : 'common.invalid_code',
                ['token' => $r ? $TokenResult->plainTextToken : null],
            );
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

}
