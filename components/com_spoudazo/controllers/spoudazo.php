<?php

defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

class SpoudazoControllerSpoudazo extends SpoudazoController {

	public function setCookie()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$option=$jinput->getArray();
		
		$cityID=$jinput->get('cityID','');
		$return_url=$jinput->get('return_url','','RAW');
		$notAgain=$jinput->get('notAgain','false');
		
		$cookie=$app->input->cookie;
		
		$cookie->set('spoudazoCookie','true',time() + (10*365*24*60*60),'/' );
		$cookie->set('spoudazoCityID',$cityID,time() + (10*365*24*60*60),'/' );
		
		//$app->redirect(JRoute::_($return_url));
		
		echo new JResponseJson( array('cityID'=>$cityID, 'return_url'=>$return_url) );
		
		jexit();
	}
	
	public function addSubscriber()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$email=$jinput->get('email','vaskou@hotmail.com','RAW');
		$listID='2ec7866a54';
		$username = 'yesinternet';
		$APIKey = '583793ce6fa23567e84ff52b95b35786-us11';
		self::mailchimp_request('POST', $listID, $username, $APIKey, $email);
	}
	
	public function checkSubscriber()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$email=$jinput->get('email','vaskou@hotmail.com','RAW');
		$listID='2ec7866a54';
		$username = 'yesinternet';
		$APIKey = '583793ce6fa23567e84ff52b95b35786-us11';
		self::mailchimp_request('GET', $listID, $username, $APIKey, $email);
	}
	
	private function mailchimp_request($type, $listID, $username, $APIKey, $email )
	{
		$request =  'http://us11.api.mailchimp.com/3.0/lists';
		$request .= '/'.$listID.'/members/';
			
		$postargs = json_encode(array('email_address'=>$email,'status'=>'subscribed'));
		
		if($type=='GET'){
			$request .= md5($email);
		}
		
		$session = curl_init($request);
		
		
		// Set the POST options.
		if($type=='POST'){
			curl_setopt($session, CURLOPT_POST, true);
		}elseif($type!='GET'){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
		}
		if($type!='GET'){
			curl_setopt($session, CURLOPT_POSTFIELDS, $postargs);
		}
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_USERPWD, $username.':'.$APIKey);
		
		// Do the POST and then close the session
		$response = curl_exec($session);
		
		if($response === false)
		{
			echo 'Curl error: ' . curl_error($session);
		}
		curl_close($session);
		var_dump($response);
		// Parse the JSON response
		try {
			if(is_object(json_decode($response))){
				$resultObj=json_decode($response);	
			}else{
				throw new Exception("Result is not a json object");
			}
		} catch( Exception $e ) {
			var_dump($e);
			return false;
		}
		
		var_dump($resultObj);
		die;
	}
	

}