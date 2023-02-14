<?php
declare(strict_types=1);

namespace NiceYu\JwtAuth;

use NiceYu\Enum\Enum;

/**
 * class PlatformEnum
 * @method static PlatformEnum H5()
 * @method static PlatformEnum PC()
 * @method static PlatformEnum WEB()
 * @method static PlatformEnum APP()
 * @method static PlatformEnum IOS()
 * @method static PlatformEnum ANDROID()
 * @method static PlatformEnum WECHAT_APPLETS()
 * @method static PlatformEnum WECHAT_PUBLIC_ACCOUNT()
 */
class PlatformEnum extends Enum
{
    /** html5 */
    protected const H5 = 'h5';

    /** pc程序 */
    protected const PC = 'pc';

    /** web程序 */
    protected const WEB = 'web';

    /** app 应用程序 */
    protected const APP = 'app';

    /** 苹果应用程序 */
    protected const IOS = 'ios';

    /** 安卓应用程序 */
    protected const ANDROID = 'android';

    /** 微信小程序 */
    protected const WECHAT_APPLETS = 'wechat applets';

    /** 微信公众号 */
    protected const WECHAT_PUBLIC_ACCOUNT = 'wechat public account';
}