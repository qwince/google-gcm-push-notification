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

include_once 'PushNotificationGCMException.php';

class PushNotificationGCM
{

    const HTTP_OK           = 200;
    const HTTP_UNAUTHORIZED = 401;

    /**
     * For iOS only - silent remote notifications
     * @var bool
     */
    public $silent_notification = false;

    /**
     * @var string
     */
    public $default_title_notification = '';

    /**
     * Google GCM apiKey
     * @var string
     */
    private $api_key = '';

    /**
     * Google GCM url
     * @var string
     */
    private $urlGCMSend = "https://gcm-http.googleapis.com/gcm/send";

    /**
     * Curl Port for $urlGCMSend
     * @var int
     */
    private $GCMPort = 443;

    /**
     * Curl Timeout
     * @var int
     */
    private $timeout = 10;

    /**
     * @var int
     */
    public $priority = 7;

    /**
     * All devices to send Push Notification
     * @var array
     */
    private $devices = array();

    /**
     * The array message to sent
     * @var array
     */
    private $message = array();

    /**
     * @var array
     */
    public $reponseGCM = array('success'=>array(),'failure'=>array());

    /**
     * set verbose the send
     * @var bool
     */
    public $debug = false;

    /**
     * Curl error code
     * @var array
     */
    public $error_codes = array(
        0 => 'No Errors',
        1 => 'CURLE_UNSUPPORTED_PROTOCOL',
        2 => 'CURLE_FAILED_INIT',
        3 => 'CURLE_URL_MALFORMAT',
        4 => 'CURLE_URL_MALFORMAT_USER',
        5 => 'CURLE_COULDNT_RESOLVE_PROXY',
        6 => 'CURLE_COULDNT_RESOLVE_HOST',
        7 => 'CURLE_COULDNT_CONNECT',
        8 => 'CURLE_FTP_WEIRD_SERVER_REPLY',
        9 => 'CURLE_REMOTE_ACCESS_DENIED',
        11 => 'CURLE_FTP_WEIRD_PASS_REPLY',
        13 => 'CURLE_FTP_WEIRD_PASV_REPLY',
        14 => 'CURLE_FTP_WEIRD_227_FORMAT',
        15 => 'CURLE_FTP_CANT_GET_HOST',
        17 => 'CURLE_FTP_COULDNT_SET_TYPE',
        18 => 'CURLE_PARTIAL_FILE',
        19 => 'CURLE_FTP_COULDNT_RETR_FILE',
        21 => 'CURLE_QUOTE_ERROR',
        22 => 'CURLE_HTTP_RETURNED_ERROR',
        23 => 'CURLE_WRITE_ERROR',
        25 => 'CURLE_UPLOAD_FAILED',
        26 => 'CURLE_READ_ERROR',
        27 => 'CURLE_OUT_OF_MEMORY',
        28 => 'CURLE_OPERATION_TIMEDOUT',
        30 => 'CURLE_FTP_PORT_FAILED',
        31 => 'CURLE_FTP_COULDNT_USE_REST',
        33 => 'CURLE_RANGE_ERROR',
        34 => 'CURLE_HTTP_POST_ERROR',
        35 => 'CURLE_SSL_CONNECT_ERROR',
        36 => 'CURLE_BAD_DOWNLOAD_RESUME',
        37 => 'CURLE_FILE_COULDNT_READ_FILE',
        38 => 'CURLE_LDAP_CANNOT_BIND',
        39 => 'CURLE_LDAP_SEARCH_FAILED',
        41 => 'CURLE_FUNCTION_NOT_FOUND',
        42 => 'CURLE_ABORTED_BY_CALLBACK',
        43 => 'CURLE_BAD_FUNCTION_ARGUMENT',
        45 => 'CURLE_INTERFACE_FAILED',
        47 => 'CURLE_TOO_MANY_REDIRECTS',
        48 => 'CURLE_UNKNOWN_TELNET_OPTION',
        49 => 'CURLE_TELNET_OPTION_SYNTAX',
        51 => 'CURLE_PEER_FAILED_VERIFICATION',
        52 => 'CURLE_GOT_NOTHING',
        53 => 'CURLE_SSL_ENGINE_NOTFOUND',
        54 => 'CURLE_SSL_ENGINE_SETFAILED',
        55 => 'CURLE_SEND_ERROR',
        56 => 'CURLE_RECV_ERROR',
        58 => 'CURLE_SSL_CERTPROBLEM',
        59 => 'CURLE_SSL_CIPHER',
        60 => 'CURLE_SSL_CACERT',
        61 => 'CURLE_BAD_CONTENT_ENCODING',
        62 => 'CURLE_LDAP_INVALID_URL',
        63 => 'CURLE_FILESIZE_EXCEEDED',
        64 => 'CURLE_USE_SSL_FAILED',
        65 => 'CURLE_SEND_FAIL_REWIND',
        66 => 'CURLE_SSL_ENGINE_INITFAILED',
        67 => 'CURLE_LOGIN_DENIED',
        68 => 'CURLE_TFTP_NOTFOUND',
        69 => 'CURLE_TFTP_PERM',
        70 => 'CURLE_REMOTE_DISK_FULL',
        71 => 'CURLE_TFTP_ILLEGAL',
        72 => 'CURLE_TFTP_UNKNOWNID',
        73 => 'CURLE_REMOTE_FILE_EXISTS',
        74 => 'CURLE_TFTP_NOSUCHUSER',
        75 => 'CURLE_CONV_FAILED',
        76 => 'CURLE_CONV_REQD',
        77 => 'CURLE_SSL_CACERT_BADFILE',
        78 => 'CURLE_REMOTE_FILE_NOT_FOUND',
        79 => 'CURLE_SSH',
        80 => 'CURLE_SSL_SHUTDOWN_FAILED',
        81 => 'CURLE_AGAIN',
        82 => 'CURLE_SSL_CRL_BADFILE',
        83 => 'CURLE_SSL_ISSUER_ERROR',
        84 => 'CURLE_FTP_PRET_FAILED',
        84 => 'CURLE_FTP_PRET_FAILED',
        85 => 'CURLE_RTSP_CSEQ_ERROR',
        86 => 'CURLE_RTSP_SESSION_ERROR',
        87 => 'CURLE_FTP_BAD_FILE_LIST',
        88 => 'CURLE_CHUNK_FAILED');

    /**
     *
     *
     * @param $api_key
     */
    function __construct($api_key)
    {
        if(is_string($api_key))
            $this->api_key = $api_key;
        else
            throw new PushNotificationGCMException(PushNotificationGCMException::API_KEY_BROKEN,"Please, insert correct api key");
    }


    /**
     * Add device token to queue
     * @param string $device_token
     * @throws PushNotificationGCMException
     */
    public function addDevice($device_token)
    {
        if(is_string($device_token))
            $this->devices[] = $device_token;
        else
            throw new PushNotificationGCMException(PushNotificationGCMException::DEVICE_TOKEN_IS_NOT_STRING,'Please, check the device token format');
    }


    /**
     * Add devices array to queue
     * @param array $devices {$device_token}
     * @throws PushNotificationGCMException
     */
    public function addDevices($devices){
        if(is_array($devices))
            $this->devices = $devices;
        else
            throw new PushNotificationGCMException(PushNotificationGCMException::DEVICES_IS_NOT_ARRAY,'Please, check the device array format');
    }

    /**
     * Add array|object message to push notification
     *
     * @param array|object $message
     * @throws Exception
     */
    public function addMessage($message)
    {
        if (is_array($message))
            $this->message = $message;
        else
            throw new PushNotificationGCMException(PushNotificationGCMException::MESSAGE_IS_NOT_ARRAY,'Please, check your message format');
    }

    /**
     * Send Push notification to devices
     *
     * @throws Exception
     * @throws DeviceNotValidException
     */
    public function push()
    {
        $this->sendTo();

        if(count($this->reponseGCM['failure'])){
            $this->checkValidity();
        }
    }

    /**
     * Curl function to send push notifications
     *
     * @return bool|mixed
     * @throws Exception
     */
    private function sendTo()
    {
        $message_to_push = array();
        $message_to_push['registration_ids'] = $this->devices;
        $message_to_push['data'] = $this->message;
        $message_to_push['priority'] = $this->priority;

        if($this->silent_notification === false) {
            $title = (array_key_exists('title',$this->message)) ? $this->message['title'] : $this->default_title_notification;
            $text  = (array_key_exists('text',$this->message))  ? $this->message['text']  : '';
            $message_to_push['notification'] = array('body' => $text, 'title' => $title);
            $message_to_push['content_available'] = true;
        }
        if($this->debug) {
            $this->reponseGCM['message_to_push'] = json_encode($message_to_push);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlGCMSend);
        curl_setopt($ch, CURLOPT_PORT, $this->GCMPort);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: key=' . $this->api_key)
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message_to_push));
        $response = curl_exec($ch);
        $error = $this->error_codes[curl_errno($ch)];

        $info = curl_getinfo($ch);
        curl_close($ch);

        $body = json_decode(substr($response, $info['header_size']));

        if($this->debug) {
            $this->reponseGCM['response_body'] = $body;
        }

        if ($response === FALSE) {
            throw new PushNotificationGCMException(PushNotificationGCMException::CURL_ERROR,'Curl response response with error:'.$error);
        } else if ($body) {

            if ($body->success > 0) {
                foreach ($body->results as $key_reponse=>$result) {
                    if(property_exists($result,'message_id')){
                        $this->reponseGCM['success'][] = $this->devices[$key_reponse];
                    }
                }
            }

            if($body->failure > 0) {
                foreach ($body->results as $key_reponse=>$result) {
                    if(property_exists($result,'error')){
                        $this->reponseGCM['failure'][] = $this->devices[$key_reponse];
                    }
                }
            }

        } else {
            throw new PushNotificationGCMException(PushNotificationGCMException::CURL_ERROR,'Curl response is not a valid json');
        }
    }

    /**
     * Checking the validity of API key
     */
    private function checkValidity()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlGCMSend);
        curl_setopt($ch, CURLOPT_PORT, $this->GCMPort);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: key=' . $this->api_key)
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('registration_ids' => 'ABC')));
        $info = curl_getinfo($ch);
        curl_close($ch);

        if($info['http_code'] == self::HTTP_UNAUTHORIZED)
            throw new PushNotificationGCMException(PushNotificationGCMException::API_KEY_BROKEN,"Please, insert correct api key");

        if($this->debug){
            if($info['http_code'] == self::HTTP_OK)
                $this->reponseGCM['checkValidity'] = 'API KEY is valid';
        }

    }
}
