<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
include (APPPATH . 'libraries/REST_Controller.php');
class User extends REST_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}
	public function getCategoryView_get()
	{
		//This view is for getting the category
		$this->load->view('webservices/get_category');
	}
	public function getCategory_post()
	{
		//This function is for getting the category and it's title
		//now getting the values from view
		$category=$this->user_model->getRecord('category',array());
		if($category==0)
		{
			$post['message']="There is no category";	
		}
		else 
		{
			$post['message']="success";
			foreach ($category as $value) 
			{
				$cat['category_id']			= $value['category_id'];
				$cat['category_name']		= $value['category_name'];
				$cat['category_spanish']	= $value['category_spanish'];
				if($value['category_image']=='')
				{
					$cat['category_image']	= "";
				}
				else 
				{
					$cat['category_image']	= $this->user_model->get_user_img_url('category', $value['category_image']);	
				}
				if($value['background_image']=='')
				{
					$cat['background_image']	= "";
				}
				else 
				{
					$cat['background_image']	= $this->user_model->get_user_img_url('background_image', $value['background_image']);	
				}
				$cat['created']				= $value['created'];
				$cat['updated']				= $value['updated'];
				$cat['title']				= array();
				//now getting the title of this category
				$title=$this->user_model->getRecord('title',array('category_id'=>$value['category_id']));
				if($title!=0)
				{
					foreach ($title as $valueti) 
					{
						$tit['title_id']		= $valueti['title_id'];
						$tit['category_id']		= $valueti['category_id'];
						$tit['title_name']		= $valueti['title_name'];
						$tit['title_spanish']	= $valueti['title_spanish'];
						$tit['created']			= $valueti['created'];
						$tit['updated']			= $valueti['updated'];
						
						$cat['title'][]			= $tit;
					}
				}
				$post['category'][]=$cat;	
			}
		}
		echo json_encode($post);
	}
	public function getContentView_get()
	{
		//This view is for getting the content of the title
		$this->load->view('webservices/get_contents');
	}
	public function getContent_post()
	{
		//This function is for getting the content of the title
		//now getting the values from view
		$category_id	= $this->input->post('category_id');
		$title_id		= $this->input->post('title_id');
		//now getting the content of this title
		$content=$this->user_model->getRecord('content',array('category_id'=>$category_id,'title_id'=>$title_id));
		if($content!=0)
		{
			$post['message']="success";
			foreach ($content as $valuecon) 
			{
				$cont['content_id']			= $valuecon['content_id'];
				$cont['category_id']		= $valuecon['category_id'];
				$cont['title_id']			= $valuecon['title_id'];
				//$cont['image']				= $valuecon['image'];
				if($valuecon['image']=='')
				{
					$cont['image']			= "";
				}
				else 
				{
					$cont['image']			= $this->user_model->get_user_img_url('content', $valuecon['image']);	
				}	
				//$cont['content']			= html_entity_decode(str_replace("\n", '',str_replace("\r", '', html_escape(strip_tags($valuecon['content'])))));
				//$cont['cantent_spanish']	= html_entity_decode(str_replace("\n", '',str_replace("\r", '', html_escape(strip_tags($valuecon['cantent_spanish'])))));//html_escape(strip_tags($valuecon['cantent_spanish']));
				$cont['content']			= ($valuecon['content']);
				$cont['cantent_spanish']	= ($valuecon['cantent_spanish']);
				
				$cont['created']			= $valuecon['created'];
				$cont['updated']			= $valuecon['updated'];
				$post['content'][]			= $cont;	
			}
		}
		else 
		{
			$post['message']="no contents";	
		}
		echo json_encode($post);
	}
	public function getContinentsView_get()
	{
		//This view is for getting the continents
		$this->load->view('webservices/get_continents');
	}
	public function getContinents_post()
	{
		//This function is for getting the continents
		//now getting the values from view
		$result=$this->user_model->getRecord('continents',array());
		if($result==0)
		{
			//There is no continent
			$post['message']="no continent found";
		}
		else 
		{
			//There are some of the continents
			$post['message']="success";
			foreach ($result as $value) 
			{
				$continents['continent_id']		= $value['continent_id'];
				$continents['continent_name']	= $value['continent_name'];
				$continents['continent_spanish']= $value['continent_spanish'];
				if($value['image']=='')
				{
					$continents['image']		= "";
				}
				else 
				{
					$continents['image']		= $this->user_model->get_user_img_url('continents', $value['image']);	
				}	
				$continents['created']			= $value['created'];
				$continents['updated']			= $value['updated'];
				$continents['country']=array();
				//now getting the country
				$c_result=$this->user_model->getRecord('countries',array('continent_id'=>$value['continent_id']));
				if($c_result!=0)
				{
					foreach ($c_result as $valuec) 
					{
						$country['country_id']		= $valuec['country_id'];
						$country['continent_id']	= $valuec['continent_id'];
						$country['country_name']	= $valuec['country_name'];
						$country['country_spanish']	= $valuec['country_spanish'];
						$country['number']			= $valuec['number'];
						$country['email_id']		= $valuec['email_id'];
						$country['created']			= $valuec['created'];
						$country['updated']			= $valuec['updated'];
						$continents['country'][]	= $country; 
					}
				}
				
				$post['continent'][]=$continents;
			}
		}
		echo json_encode($post);	
	}
	public function getCountriesView_get()
	{
		//This view is for getting the country for continents
		$this->load->view('webservices/get_country');
	}
	public function getCountries_post()
	{
		//This function is for getting the country for continents
		//now getting the values from view
		$continent_id	= $this->input->post('continent_id');
		$page_no		= $this->input->post('page_no');
		$limit			= $this->input->post('limit');
		$limit1			= $page_no * $limit;
		$start			= $limit1 - $limit;
		$where="`continent_id`='".$continent_id."' LIMIT ".$start.",".$limit;
		$result=$this->user_model->getRecord('countries',$where);
		if($result==0)
		{
			$post['message']="no country ";	
		}
		else 
		{
			$post['message']="success";
			foreach ($result as $value) 
			{
				$country['country_id']		= $value['country_id'];
				$country['continent_id']	= $value['continent_id'];
				$country['country_name']	= $value['country_name'];
				$country['country_spanish']	= $value['country_spanish'];
				$country['number']			= $value['number'];
				$country['email_id']		= $value['email_id'];
				$country['created']			= $value['created'];
				$country['updated']			= $value['updated'];
				$post['country'][]			= $country; 
			}
			$count=$this->user_model->getRecord('countries',array('continent_id'=>$continent_id));
			if($count==0)
			{
				$post['is_more_data']="no";
			}
			else 
			{
				if(count($count)>$limit1)
				{
					$post['is_more_data']="yes";
				}
				else 
				{
					$post['is_more_data']="no";
				}
			}
		}
		echo json_encode($post);
	}
	public function emergencyNotificationView_get()
	{
		//This view is for send the emergency notification
		$this->load->view('webservices/emergency_notification');
	}
	public function emergencyNotification_post()
	{
		//This function is for send the emergency notification
		//now getting the values from view
		$location		= $this->input->post('location');
		$software_name	= $this->input->post('software_name');
		$subject		= $this->input->post('subject');
		$date			= $this->input->post('date');
		$note			= $this->input->post('note');
		
		if(isset($_FILES['picture']['name']))
		{
			if($_FILES['picture']['name']!='')
			{
				$imanename = $_FILES['picture']['name'];
				$temp = explode(".", $_FILES["picture"]["name"]);
				$newfilename = rand(1, 99999) . '.' . end($temp);
				//This is for upload the image
				$path= './images/emergency/'.$newfilename;
				$upload = copy($_FILES['picture']['tmp_name'], $path);
			}
			else 
			{
				$newfilename ="";
			}
		}	
		else 
		{
			$newfilename ="";
		}
		$data=array(
					'location'=>$location,
					'software_name'=>$software_name,
					'subject'=>$subject,
					'date'=>$date,
					'note'=>$note,
					'created'=>date('Y-m-d H:i:s'));
		$result=$this->user_model->saveRecord('enotification',$data);
		if($result==0)
		{
			$post['message']="failure";
		}
		else 
		{
			$post['message']="success";
			$email_id="parkhya.developer@gmail.com";
			$this->user_model->sendSmtpEmail($email_id,$software_name,$subject,$user_name="");
		}
		echo json_encode($post);
	}
	 /* alert list */
    public function alertNotificationView_get()
	{
		//This view is for send the emergency notification
		$this->load->view('webservices/alert_notification');
	}
	public function alertNotification_post()
	{
		//This function is for get alert notification
		//now getting the values from view
		$notification_type	= $this->input->post('notification_type');
		
		if($notification_type == 3){
			$dataArr = array();
		}else{
			$dataArr = array('notifi_type'=>$notification_type);
		}
		
		$notificationList = $this->user_model->getRecord('alert_notification',$dataArr);
		
		if(!empty($notificationList))
		{
			foreach($notificationList as $list){
				$notifiArr[] = array(
				     'notification_id' => $list['notification_id'],
				     'notification' => $list['notification'],
				     'platform' => $list['platform'],
				     'location' => $list['location'],
				     'notifi_date' => $list['notifi_date'],
				     'status' => $list['status'],
				     'notifi_type' => $list['notifi_type'],
				     'created' => $list['created'],
				);
			}
			$post['message']="success";
			$post['result']=$notifiArr;
		}
		else 
		{
			$post['message']="No result found";
		}
		echo json_encode($post);
	}
    /* --- alert list --- */
    
    /* last update dates */
    public function updateDatesView_get()
	{
		//This view is for send the emergency notification
		$this->load->view('webservices/update_dates');
	}
	public function updateDates_post()
	{
		$dateInfo = $this->user_model->getRecord('update_dates',array('update_id'=>1));
		
		$post['message']="success";
	    $post['category_update_date'] = $dateInfo[0]['category_update_date'];
		$post['continents_update_date'] = $dateInfo[0]['continents_update_date'];
		
		echo json_encode($post);
	}
    /*--- dates ---- */
    
	public function userLoginView_get()
	{
		//This view is for login the user
		$this->load->view('webservices/user_login');
	}
	public function userLogin_post()
	{
		//This function is for login the user
		//now getting the values from view
		$user			= $this->input->post('user');
		$password		= $this->input->post('password');
		$device_token	= $this->input->post('device_token');
		$device_type	= $this->input->post('device_type');
		
		$where="(`user_name`='".$user."' OR `email_id`='".$user."') AND `password`='".$password."'";
		$result=$this->user_model->getRecord('user',$where);
		if($result==0)
		{
			$post['message']="failure";	
		}
		else 
		{
			$post['message']="success";
			$post['notification']=$result[0]['notification'];
			//now update the device type and token
			$data=array('device_type'=>$device_type,'device_token'=>$device_token);
			$this->user_model->updateRecord('user',$data,array('user_id'=>$result[0]['user_id']));
		}
		echo json_encode($post);
	}
	public function saveDevice_post()
	{
		$device_token	= $this->input->post('device_token');
		$device_type	= $this->input->post('device_type');
		$result=$this->user_model->getRecord('user',array('device_type'=>$device_type,'device_token'=>$device_token));
		if($result==0)
		{
			$data=array('device_type'=>$device_type,'device_token'=>$device_token);
			$this->user_model->saveRecord('user',$data);
		}
		$post['message']="success";
		echo json_encode($post);
	}
	public function testNotification_get()
	{
		$registatoin_ids="eZw5vYbAMqc:APA91bH49OeMSmHCo0mAg6Jjf1dRg4JSsMQHfHU7ssES3oJYpKslaubWO3ok_ohD8nLMPZViWPl51qSM4U96zoLdQNqTiut25LTDAF-8M0IRVhMQrxzH105LbI6f9NR3qRMG3MOQQhPY";
		$array=array('message'=>'Testing notification');
		$this->user_model->send_android_notification($registatoin_ids,$array);
	}
	public function iosNotification_get()
	{
		$deviceToken="8b0a30790da7f683a1f9be78f307cb6449c6ea309e62788e3d906f297eb09665";
		$array=array('alert'=>'ios testing');
		echo $this->user_model->ios_notification($deviceToken,$array);
	}
}	