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
		
		SpoudazoLibrary::set_cookie($cityID);
		
		echo new JResponseJson( array('cityID'=>$cityID) );
		
		jexit();
	}
	
	public function addSubscriber()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$email=$jinput->get('email','','STRING');

		$cityID=$jinput->get('cityID','','INT');
		
		$redirect=$jinput->get('redirect','','STRING');
		
		$return_url=$jinput->get('return_url','','BASE64');
		
		$city=SpoudazoLibrary::getCity($cityID);
		
		if($city){
			$listID=$city['listID'];
		
			$response = self::mailchimp_request('POST', $listID, $email);
		}
		
		SpoudazoLibrary::set_cookie($cityID);
		
		if($redirect=='true'){
			$app->redirect(base64_decode($return_url));
		}else{
			echo new JResponseJson( array('cityID'=>$cityID, 'response'=>$response) );
			
			jexit();
		}
	}
	
	public function checkSubscriber()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$email=$jinput->get('email','','STRING');

		$cityID=$jinput->get('cityID','','INT');
		
		$city=SpoudazoLibrary::getCity($cityID);
		
		if($city){
			$listID=$city['listID'];
		
			$response = self::mailchimp_request('GET', $listID, $email);
		}
		
		echo new JResponseJson( array('cityID'=>$cityID, 'response'=>$response) );
		
		jexit();
		
	}
	
	private function mailchimp_request($type, $listID, $email )
	{
		$datacenter = JComponentHelper::getParams('com_spoudazo')->get('datacenter');
		$username = JComponentHelper::getParams('com_spoudazo')->get('username');
		$APIKey = JComponentHelper::getParams('com_spoudazo')->get('APIKey');
		
		if(!$datacenter || !$username || !$APIKey){
			return false;
		}
		
		$request =  'http://'.$datacenter.'.api.mailchimp.com/3.0/lists';
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
		
		curl_close($session);
		
		// Parse the JSON response
		try {
			if(is_object(json_decode($response))){
				$resultObj=json_decode($response);	
			}else{
				throw new Exception("Result is not a json object");
			}
		} catch( Exception $e ) {
			//var_dump($e);
			return false;
		}
		
		return $resultObj;

	}

}