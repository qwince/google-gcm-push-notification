<?php
/**
 * Google GCM Push Notification is small PHP library for send push notification to Android and iOS mobile devices.
 *
 * For more information @see readme.md
 *
 * @link http://github.com/
 * @author Securproject.it Team
 * @copyright 2015 Securproject.it
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */

class PushNotificationGCMException extends Exception {

    /**
     * Error code
     */
    const MESSAGE_IS_NOT_ARRAY                      = 10;
    const DEVICE_TOKEN_IS_NOT_VALID                 = 11;
    const DEVICE_TOKEN_IS_NOT_STRING                = 12;
    const SEND_TO_RESPONSE_ERROR                    = 13;
    const SEND_TO_RESPONSE_IS_NOT_VALID             = 14;
    const CHECK_VALIDITY_RESPONSE_IS_NOT_VALID      = 15;
    const CHECK_VALIDITY_RESPONSE_IS_NOT_VALID_JSON = 16;
    const CURL_ERROR                                = 17;

    /**
     * @param int $code
     * @param int $message
     * @param Exception $previous
     */
    public function __construct($code, $message, Exception $previous = null) {

        parent::__construct($message, $code, $previous);
    }

    /**
     *
     * @return int
     */
    public function getPushNotificationCode(){
        return $this->code;
    }
}