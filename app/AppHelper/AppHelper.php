<?php


namespace App\AppHelper;


use App\Models\Locations\LocationModel;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Imagick;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AppHelper
{

    const availableLanguages = [
        'en',
        'ar',
    ];

    const defaultDateFormat = 'D, d-m-Y';

    static function defaultFutureDateValidation($format = 'm/d/Y'): string
    {
        return 'required|date_format:' . $format . '|after:today';
    }

    static function defaultFutureDateValidation_Nullable($format = 'm/d/Y'): string
    {
        return 'required|date_format:' . $format . '|after:today';
    }

    static function defaultPastDateValidation($format = 'm/d/Y'): string
    {
        return 'required|date_format:' . $format . '|before:today';
    }

    static function defaultPastDateValidation_Nullable($format = 'm/d/Y'): string
    {
        return 'nullable|date_format:' . $format . '|before:today';
    }

    static function humanReadAbleTime($time)
    {
        return $time->diffForHumans();
    }

    static function logErrorException($exception): JsonResponse
    {
        Log::error('ErrorException', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]);

        return response()->json(['status' => false, 'line_no' => $exception->getLine(), 'file' => $exception->getFile(), 'message' => $exception->getMessage()]);
    }

    static function sendSuccessResponse($status = true, $message = 'success', $payload = [], $extra = [], $payloadKeyName = 'payload'): JsonResponse
    {
        $responseAr = [
            'status' => $status,
            'message' => __($message),
            $payloadKeyName => empty($payload) ? new \stdClass() : $payload,
        ];
        $responseAr = array_merge($responseAr, $extra);
        return response()->json($responseAr);
    }

    /**
     * @Purpose Get user form the request
     * @param Request $request
     * @return Authenticatable|null
     */
    static function getUserFromRequest(Request $request): ?Authenticatable
    {
        return $request->wantsJson() ? $request->user() : Auth::user();
    }

    static function isAjaxCall($request)
    {
        return $request->hasHeader('ApiResponse');
    }

    static function getLoggedInWebUser(): ?Authenticatable
    {
        return Auth::user();
    }

    static function shouldShowLoggedInUserHeader(): bool
    {
        return self::getLoggedInWebUser() instanceof User && \request()->route()->getName() <> 'home';
    }

    static function adminDashboard(): array
    {
        return [
            [
                'nme' => __('home.dashboard'),
                'href' => route('admin_dashboard'),
                'route_name' => 'admin_dashboard',
            ],
            [
                'nme' => __('home.users'),
                'href' => route('users.index'),
                'route_name' => 'users.index',
            ],
            [
                'nme' => __('home.events_subscription'),
                'href' => route('users.index'),
                'route_name' => '',
            ],
            [
                'nme' => __('home.tutoring_subscription'),
                'href' => route('users.index'),
                'route_name' => '',
            ],
        ];
    }

    static function calculateInclusiveTax($amt): float
    {
        return (float)number_format(abs(($amt / 1.15) - ($amt)), 2);
    }

    static function portalDashboard(): array
    {
        return [
            [
                'nme' => __('home.home'),
                'href' => route('web_home'),
                'route_name' => ['web_home'],
            ],
            [
                'nme' => __('home.tutoring'),
                'href' => route('expert-tutoring.index'),
                'route_name' => ['expert-tutoring.index', 'expert-tutoring.show', 'expert-tutoring.edit', 'expert-tutoring.create'],
            ],
            [
                'nme' => __('home.events'),
                'href' => route('expert-event.index'),
                'route_name' => ['expert-event.index', 'expert-event.show', 'expert-event.edit', 'expert-event.create'],
            ],
            [
                'nme' => __('home.space'),
                'href' => route('expert-space.index'),
                'route_name' => ['expert-space.index', 'expert-space.create', 'expert-space.show', 'expert-space.edit'],
            ],
            [
                'nme' => __('home.profile'),
                'href' => route('expert-my-profile.index'),
                'route_name' => ['expert-my-profile.index', 'expert-my-profile.show', 'expert-verify-profile.index'],
            ],
        ];
    }

    static function shouldShowAdminUserHeader(): bool
    {
        $loggedInUser = self::getLoggedInWebUser();
        return $loggedInUser instanceof User && $loggedInUser->id == 2;
    }

    /**
     * @Purpose Get default avatar of user.
     * @param Request|null $request
     * @param null $gender
     * @param bool $blue
     * @param bool $profileBiggerPic
     * @param bool $lightBlue
     * @return string
     */
    static function getDefaultAvatarPath(
        Request $request = null, $gender = null,
        bool    $blue = false, bool $profileBiggerPic = false,
        bool    $lightBlue = false
    ): string
    {
        if ($profileBiggerPic) {
            return asset('assets/images/expert-1.png');
        } elseif ($blue) {
            return asset('assets/images/portal/user-default-blue-avatar.png');
        } elseif ($lightBlue) {
            return asset('assets/images/space/default-user.svg');
        } else {
            return asset('assets/images/portal/user-default-avatar.svg');
        }
    }


    static function getAppDate($date)
    {
        return date(self::defaultDateFormat, strtotime($date));
    }

    static function getAppDateAndTime($date)
    {
        return date(self::defaultDateFormat . ' H:i', strtotime($date));
    }

    static function getAppDateAndTimeHTMLParse($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    static function getAppDateHTMLParse($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    /**
     * @param $price
     * @return string
     */
    static function getPriceFormat($price)
    {
        return 'SAR ' . number_format((float)$price, 2);
    }

    /**
     * Filter price, remove currency from string.
     * @param $price
     * @return string|string[]
     */
    static function priceFilter($price)
    {
        return str_replace('SAR ', '', $price);
    }

    /**
     * @Purpose get logged in users
     * @return Authenticatable|null
     */
    static function getLoginInUser(): ?Authenticatable
    {
        return auth()->guard('api')->user();
    }

    static function isUserIdLoggedIn(): bool
    {
        return self::getLoginInUser() instanceof User;
    }

    /**
     * @param $date
     *
     * @Purpose get formatted date
     * @return false|int
     */
    static function getMySQLFormattedDate($date = null)
    {
        return empty($date) ? date('Y-m-d') : date('Y-m-d', strtotime($date));
    }

    static function getMySQLFormattedDateTime($date)
    {
        return date('Y-m-d H:i', strtotime($date));
    }

    static function getPhoneNumberFormated($phone)
    {
        return '+966 ' . $phone;
    }

    static function isMobile(): bool
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu
(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            return true;
        } else {
            return false;
        }
    }

    static function getHTMLTagOnBaseOfLocale(): string
    {
        $locale = App::getLocale();
        if ($locale == 'en') {
            return '<html lang="en">';
        } else {
            return '<html dir="rtl" lang="ar">';
        }
    }

    static function getManagers(): array
    {
        return [
            User::find(1),
            User::find(20),
        ];
    }

    public static function voteNumberFormat($num): string
    {
        return number_format($num);
    }

    static function numberFormatToTwo($num): string
    {
        return number_format($num, 2);
    }

    static function headerUploadOptionMenu(): array
    {
        $loggedInUser = AppHelper::getLoggedInWebUser();
        return [
            [
                'name' => __('common.write_post'),
                'img' => asset('assets/images/header/write-post.svg'),
                'modalTrigger' => '#writeAPostModal',
                'class' => ''

            ],
//            [
//                'name' => __('common.ask_question'),
//                'img' => asset('assets/images/header/ask-question.svg'),
//                'modalTrigger' => '#askAQuestionModal',
//            ],
//            [
//                'name' => __('common.add_media'),
//                'img' => asset('assets/images/header/upload-media.svg'),
//                'modalTrigger' => '#writeAPostModal',
//            ],
//            [
//                'name' => __('common.upload_document'),
//                'img' => asset('assets/images/header/upload-document.svg'),
//                'modalTrigger' => '#writeAPostModal',
//            ],
            [
                'name' => __('common.space'),
                'img' => asset('assets/images/header/topic.svg'),
                'route' => route('expert-space.create'),
                'class' => '',
                'is_allow_to_do' => $loggedInUser->canCreateTopic(),
            ],
            [
                'name' => __('common.tutoring'),
                'img' => asset('assets/images/header/give-tutoring.svg'),
                'route' => route('expert-tutoring.create'),
                'class' => 'w-20px',
                'is_allow_to_do' => $loggedInUser->canCreateTutoring(),
            ],
            [
                'name' => __('common.event'),
                'img' => asset('assets/images/events/event-icon.svg'),
                'route' => route('expert-event.create'),
                'class' => 'w-20px',
                'is_allow_to_do' => $loggedInUser->canCreateEvent(),
            ],
//            [
//                'name' => __('common.create_poll'),
//                'img' => asset('assets/images/header/ask-question.svg'),
//                'modalTrigger' => '#createPollModal',
//            ],
        ];
    }

    static function convertDocToPdf($documentUploadedPath, $destinationFolder): string
    {
        $destinationFolderWithName = $destinationFolder . DIRECTORY_SEPARATOR . 'file.pdf';
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $Content = \PhpOffice\PhpWord\IOFactory::load($documentUploadedPath);
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save($destinationFolderWithName);

        return $destinationFolderWithName;
    }

    static function convertPDFToImage($destinationPath, $pdfPath): array
    {
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath);
        }

        $imagick = new Imagick();
        $imagick->readImage($pdfPath);
        $imagick->writeImages($destinationPath . '/convert.png', true);
        return File::allFiles($destinationPath);
    }

    static function convertXlsxToPdf($destinationFolder, $documentUploadedPath): string
    {
        $destinationFolderWithName = $destinationFolder . DIRECTORY_SEPARATOR . 'file.pdf';

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        //Load word file
        $Content = IOFactory::load($documentUploadedPath);

        //Save it into PDF
        $PDFWriter = IOFactory::createWriter($Content, 'Dompdf');
        $PDFWriter->save($destinationFolderWithName);
        return $destinationFolderWithName;
    }

    static function dataTableRequestFormat($request): Request
    {
        return $request;
        /** @var Request $request */
        ## set the page no
        if (!empty($page = $request->pagination['page'])) {
            $request->query->set('page', $page);
        }

        ## set the search parameter
        if (!empty($request->all()['query']['generalSearch'])) {
            $request->query->set('search', $request->all()['query']['generalSearch']);
        }

        ## set the page length
        if (!empty($pageLength = $request->pagination['perpage'])) {
            $request->query->set('page_length', $pageLength);
        }

        return $request;
    }

    static function dataTableResponseFormat(LengthAwarePaginator $lengthAwarePaginator, Request $request)
    {
        return $lengthAwarePaginator->getCollection();
        return response()->json([
            'meta' => [
                'page' => $lengthAwarePaginator->currentPage(),
                'pages' => $lengthAwarePaginator->lastPage(),
                'perpage' => $lengthAwarePaginator->perPage(),
                'total' => $lengthAwarePaginator->total(),
                'sort' => 'asc',
                'field' => 'id',
            ],
            'data' => $lengthAwarePaginator->getCollection(),
        ]);
    }

    static function isAndroidRequest($request): bool
    {
        return $request->hasHeader('http-x-os') && $request->header('http-x-os') === 'android';
    }

    public static function getPriceFormatNonSar($price)
    {

        return ceil((float)$price);
    }

    public static function parseLocation($location)
    {
        if ($location instanceof LocationModel) {
            $lString = $location->loc_nme;
            if (!empty($location->room)) {
                $lString .= " " . $location->room;
            }

            if (!empty($location->floor)) {
                $lString .= " " . $location->floor;
            }

            if (!empty($location->building_nme)) {
                $lString .= " " . $location->building_nme;
            }

            return $lString;
        } else {
            return '-';
        }
    }

}
