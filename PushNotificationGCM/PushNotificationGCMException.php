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
    const API_KEY_BROKEN                            = 1;
    const MESSAGE_IS_NOT_ARRAY                      = 2;
    const DEVICE_TOKEN_IS_NOT_STRING                = 3;

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