<?php
class OpenFireRestApi
{
	public $host		= '52.34.159.44';
	public $port		= '9090';
	public $plugin		= '/plugins/restapi/v1';
	public $secret		= '225R7Q6zt48h5Dtf';
	public $useSSL		= false;
    protected $params   = array();

    /**
     * Make the request and analyze the result
     *
     * @param   string          $type           Request method
     * @param   string          $endpoint       Api request endpoint
     * @param   string[]        $params         Parameters
     * @return  array|false                     Array with data or error, or False when something went fully wrong
     */
    private function doRequest($type, $endpoint, $params=array())
    {
    	$base = ($this->useSSL) ? "https" : "http";
    	$url = $base . "://" . $this->host . ":" .$this->port.$this->plugin.$endpoint;
    	$headers = array(
  			'Accept' => 'application/json',
  			'Authorization' => $this->secret
  		);
		
       
        switch ($type) {
            case 'get':
                $result = Requests::get($url, $headers);
                break;
            case 'post':
                $headers += ['Content-Type'=>'application/json'];                
                $params = json_encode($params);
                $result = Requests::post($url, $headers, $params);
                break;
            case 'delete':
                $headers += ['Content-Type'=>'application/json'];                
                $params = json_encode($params);
                $result = Requests::delete($url, $headers);
                break;
            case 'put':
                $headers += ['Content-Type'=>'application/json'];                
                $params = json_encode($params);
                $result = Requests::put($url, $headers, $params);
                break;
            default:
                # code...
                break;
        }
        
        if ($result->status_code == 200 || $result->status_code == 201) {
            return array('status'=>true, 'message'=>$result->body);
        }
        return array('status'=>false, 'message'=>$result->body);
    	
    }
    

    /**
     * Get all registered users
     *
     * @return json|false       Json with data or error, or False when something went fully wrong
     */
    public function getUsers()
    {
    	$endpoint = '/users';        
    	return $this->doRequest('get',$endpoint);
    }


    /**
     * Get information for a specified user
     *
     * @return json|false       Json with data or error, or False when something went fully wrong
     */
    public function getUser($username)
    {
        $endpoint = '/users/'.$username; 
        return $this->doRequest('get', $endpoint);
    }


    /**
     * Creates a new OpenFire user
     *
     * @param   string          $username   Username
     * @param   string          $password   Password
     * @param   string|false    $name       Name    (Optional)
     * @param   string|false    $email      Email   (Optional)
     * @param   string[]|false  $groups     Groups  (Optional)
     * @return  json|false                 Json with data or error, or False when something went fully wrong
     */
    public function addUser($username, $password, $name=false, $email=false, $groups=false)
    {   
        // $params = $this->setParam(func_get_args());
        //return $array = array('username'=>$username,'password'=>$password,'name'=>$name,'email'=>$email,'groups'=>$groups);
		$endpoint = '/users'; 
        return $this->doRequest('post', $endpoint, compact('username', 'password','name','email', 'groups'));
    }


    /**
     * Deletes an OpenFire user
     *
     * @param   string          $username   Username
     * @return  json|false                 Json with data or error, or False when something went fully wrong
     */
    public function deleteUser($username)
    {
        $endpoint = '/users/'.$username; 
        return $this->doRequest('delete', $endpoint);
    }

    /**
     * Updates an OpenFire user
     *
     * @param   string          $username   Username
     * @param   string|false    $password   Password (Optional)
     * @param   string|false    $name       Name (Optional)
     * @param   string|false    $email      Email (Optional)
     * @param   string[]|false  $groups     Groups (Optional)
     * @return  json|false                 Json with data or error, or False when something went fully wrong
     */
    public function updateUser($username, $password, $name=false, $email=false, $groups=false)
    {
        $endpoint = '/users/'.$username; 
        return $this->doRequest('put', $endpoint, compact('username', 'password','name','email', 'groups'));
    }

     /**
     * locks/Disables an OpenFire user
     *
     * @param   string          $username   Username
     * @return  json|false                 Json with data or error, or False when something went fully wrong
     */
    public function lockoutUser($username)
    {
        $endpoint = '/lockouts/'.$username; 
        return $this->doRequest('post', $endpoint);
    }


    /**
     * unlocks an OpenFire user
     *
     * @param   string          $username   Username
     * @return  json|false                 Json with data or error, or False when something went fully wrong
     */
    public function unlockUser($username)
    {
        $endpoint = '/lockouts/'.$username; 
        return $this->doRequest('delete', $endpoint);
    }


    /**
     * Adds to this OpenFire user's roster
     *
     * @param   string          $username       Username
     * @param   string          $itemJid        Item JID
     * @param   string|false    $name           Name         (Optional)
     * @param   int|false       $subscription   Subscription (Optional)
     * @return  json|false                     Json with data or error, or False when something went fully wrong
     */
    public function addToRoster($username, $jid, $name=false, $subscription=false)
    {
        $endpoint = '/users/'.$username.'/roster';
        return $this->doRequest('post', $endpoint, compact('jid','name','subscription'));
    }


    /**
     * Removes from this OpenFire user's roster
     *
     * @param   string          $username   Username
     * @param   string          $itemJid    Item JID
     * @return  json|false                 Json with data or error, or False when something went fully wrong
     */
    public function deleteFromRoster($username, $jid)
    {
        $endpoint = '/users/'.$username.'/roster/'.$jid;
        return $this->doRequest('delete', $endpoint, $jid);
    }

    /**
     * Updates this OpenFire user's roster
     *
     * @param   string          $username       Username
     * @param   string          $itemJid        Item JID
     * @param   string|false    $name           Name         (Optional)
     * @param   int|false       $subscription   Subscription (Optional)
     * @return  json|false                     Json with data or error, or False when something went fully wrong
     */
    public function updateRoster($username, $jid, $nickname=false, $subscriptionType=false)
    {
        $endpoint = '/users/'.$username.'/roster/'.$jid;
        return $this->doRequest('put', $endpoint, $jid, compact('jid','username','subscriptionType'));     
    }

}