Push Notification GCM
==================

Google GCM Push Notification is small PHP library for send push notification to Android and iOS mobile devices.


## Install

Please follow the guide [Google GCM](https://developers.google.com/cloud-messaging/) for configure the API Key.

- [iOS guide](https://developers.google.com/cloud-messaging/ios/client) 
- [Android guide](https://developers.google.com/cloud-messaging/android/client)

### Composer


The preferred way to install Push Notification GCM is via [composer](http://getcomposer.org/).

Add in your `composer.json`:

	"require": {
		...
		"spitalia/push-notification-gcm": "dev-master"
		
	}

then update your dependencies with `composer update`.

## Start usage

``` php

    $pushNotificationGCM = new PushNotificationGCM($google_api_key);
    $devices = array($devicetoken);
    $message = ['data' => ['message' => 'hello', 'reason' => 'new_event']];
    
    try {
        foreach($devices as $devicetoken){
            $pushNotificationGCM->addDevice($devicetoken);
        }
        // set this for send silent push notification
        $pushNotificationGCM->silent_notification = true;
        
        // set the title of badge
        $pushNotificationGCM->default_title_notification = APP_TITLE;
        
        // set this for set verbose the variable $pushNotificationGCM->reponseGCM
        $pushNotificationGCM->debug = true;
        
        $pushNotificationGCM->addMessage($message);
        $pushNotificationGCM->push();
        
        
        // The array $pushNotificationGCM->reponseGCM contains array('success'=>array(),'failure'=>array()); if debug is true return other keys
        
    }catch (PushNotificationGCMException $e){
        echo 'Error code: '.$e->getPushNotificationCode()." - ".$e->getMessage();
    } catch(Exception $e){
        echo $e->getMessage();
    }
    
```

## Creators

**Securproject.it Team**


## Licence

Free for commercial and non-commercial use ([Apache License](http://www.apache.org/licenses/LICENSE-2.0.html) or [GPL](http://www.gnu.org/licenses/gpl-2.0.html)).


