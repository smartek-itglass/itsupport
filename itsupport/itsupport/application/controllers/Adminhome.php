<?php
/**
 * 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Adminhome extends CI_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this -> load -> library('session');
		$this->no_cache();
		$this->redirect();
		$this->load->library('form_validation');
	}
	protected function no_cache() 
	{
		//This function is used for clearing the cache
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}
	public function redirect()
	{
		//This function is used for redirecting a function
		$email = $this->session->userdata('admin_email_id');
		if($email =='')
		{
			redirect('admin/index');
		}
	}
    public function addCategory()
    {
        //This function is for add the category
        if($this->uri->segment(3)!='')
		{
			$cate_data['detail']=$this->admin_model->getRecord('category', array('category_id'=>$this->uri->segment(3)));	
		}
		$cate_data['data']=$this->admin_model->getRecord('category', array());
        $this->load->view('admin/add_category',$cate_data);
		if(isset($_POST['submit']))
		{
			$category_name	= $this->input->post('category_name');
			$category_spanish= $this->input->post('category_spanish');
			$check=$this->admin_model->getRecord('category',array('category_name'=>$category_name,'category_spanish'=>$category_spanish));
			if($check==0)
			{
				//save the image file
				if(isset($_FILES['category_image']['name']))
				{
					if($_FILES['category_image']['name']!='')
					{
						$imanename = $_FILES['category_image']['name'];
						$temp = explode(".", $_FILES["category_image"]["name"]);
						$newfilename = rand(1, 99999) . '.' . end($temp);
						//This is for upload the image
						$path= './images/category/'.$newfilename;
						$upload = copy($_FILES['category_image']['tmp_name'], $path);
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
				
				if(isset($_FILES['background_image1']['name']))
				{
					if($_FILES['background_image1']['name']!='')
					{
						$imanename = $_FILES['background_image1']['name'];
						$temp = explode(".", $_FILES["background_image1"]["name"]);
						$background_image = rand(1, 99999) . '.' . end($temp);
						//This is for upload the image
						$path= './images/background_image/'.$background_image;
						$upload = copy($_FILES['background_image1']['tmp_name'], $path);
					}
					else 
					{
						$background_image ="";
					}
				}	
				else 
				{
					$background_image ="";
				}
				//now save the category detail
				$data=array(
							'category_name'=>$category_name,
							'category_spanish'=>$category_spanish,
							'category_image'=>$newfilename,
							'background_image'=>$background_image,
							'created'=>date('Y-m-d H:i:s'));
				$result=$this->admin_model->saveRecord('category',$data);
				if($result==0)
				{
					$this -> session -> set_flashdata('error_msg', 'Category could not add ');
					redirect('adminhome/addCategory');	
				}
				else 
				{
					$this->admin_model->updateRecord('update_dates',array('category_update_date'=>date('Y-m-d H:i')),array('update_id'=>1));
					$this -> session -> set_flashdata('success_msg', 'Category added successfully');
					redirect('adminhome/addCategory');
				}
			}
			else 
			{
				$this -> session -> set_flashdata('error_msg', 'Category Name already exist');
				redirect('adminhome/addCategory');
			}
		}
		if(isset($_POST['update']))
		{
			$category_name	= $this->input->post('category_name');
			$category_spanish= $this->input->post('category_spanish');
			$category_id	= $this->uri->segment(3);
			$check=$this->admin_model->getRecord('category',array('category_name'=>$category_name,'category_spanish'=>$category_spanish,'category_id!='=>$category_id));
			if($check==0)
			{
				//save the image file
				if(isset($_FILES['category_image1']['name']))
				{
					if($_FILES['category_image1']['name']!='')
					{
						$imanename = $_FILES['category_image1']['name'];
						$temp = explode(".", $_FILES["category_image1"]["name"]);
						$newfilename = rand(1, 99999) . '.' . end($temp);
						//This is for upload the image
						$path= './images/category/'.$newfilename;
						$upload = copy($_FILES['category_image1']['tmp_name'], $path);
					}
					else 
					{
						$newfilename =$cate_data['detail'][0]['category_image'];
					}
				}	
				else 
				{
					$newfilename =$cate_data['detail'][0]['category_image'];
				}
				if(isset($_FILES['background_image']['name']))
				{
					if($_FILES['background_image']['name']!='')
					{
						$imanename = $_FILES['background_image']['name'];
						$temp = explode(".", $_FILES["background_image"]["name"]);
						$background_image = rand(1, 99999) . '.' . end($temp);
						//This is for upload the image
						$path= './images/background_image/'.$background_image;
						$upload = copy($_FILES['background_image']['tmp_name'], $path);
					}
					else 
					{
						$background_image ="";
					}
				}	
				else 
				{
					$background_image ="";
				}
				//now update the data
				$data=array(
							'category_name'=>$category_name,
							'category_image'=>$newfilename,
							'background_image'=>$background_image,
							'category_spanish'=>$category_spanish
							);
				$this->admin_model->updateRecord('category',$data,array('category_id'=>$category_id));
				$this->admin_model->updateRecord('update_dates',array('category_update_date'=>date('Y-m-d H:i')),array('update_id'=>1));
				$this -> session -> set_flashdata('success_msg', 'Category updated successfully');
				redirect('adminhome/addCategory');
			}
			else 
			{
				$this -> session -> set_flashdata('error_msg', 'Category Name already exist');
				redirect('adminhome/addCategory');
			}
		}
	}
	public function deleteCategory()
	{
		//This function is use to delete the category
		//now getting the values from view
		$category_id	= $this->uri->segment(3);
		$this->admin_model->deleteRecord(array('category_id'=>$category_id),'category');
		$this->admin_model->deleteRecord(array('category_id'=>$category_id),'title');
		$this -> session -> set_flashdata('success_msg', 'Category deleted successfully');
		redirect('adminhome/addCategory');
	}
	public function addTitle()
	{
		//This function is for add the title for a category
		if($this->uri->segment(3)!='')
		{
			$title['detail']=$this->admin_model->getRecord('title', array('title_id'=>$this->uri->segment(3))); 		
		}
		$query="SELECT * FROM `title` t JOIN `category` c ON t.`category_id`=c.`category_id` ";
		$title['data']=$this->admin_model->getRecordQuery($query);
		
		$this->load->view('admin/add_title',$title);
		//now save the title 
		if(isset($_POST['submit']))
		{
			$category		= $this->input->post('category');
			$title_name		= $this->input->post('title_name');
			$title_spanish	= $this->input->post('title_spanish');
			
			$data=array(
						'category_id'=>$category,
						'title_name'=>$title_name,
						'title_spanish'=>$title_spanish,
						'created'=>date('Y-m-d H:i:s'));
			$result=$this->admin_model->saveRecord('title', $data);
			if($result==0)
			{
				//Title could add this time	
				$this -> session -> set_flashdata('success_msg', 'Title could not add');
				redirect('adminhome/addTitle');		
			}
			else 
			{
				//Title added successfully
				$this -> session -> set_flashdata('error_msg', 'Title added successfully');
				redirect('adminhome/addTitle');
			}
		}
		//Now update the title
		if(isset($_POST['update']))
		{
			$category		= $this->input->post('category');
			$title_name		= $this->input->post('title_name');
			$title_spanish	= $this->input->post('title_spanish');
			$title_id		= $this->uri->segment(3);
			$data=array(
						'category_id'=>$category,
						'title_name'=>$title_name,
						'title_spanish'=>$title_spanish,
						);
			$result=$this->admin_model->updateRecord('title',$data,array('title_id'=>$title_id));	
			$this -> session -> set_flashdata('success_msg', 'Title updated successfully');
			redirect('adminhome/addTitle');
		}
	}
	public function deleteTitle()
	{
		//This function is used to delete the title
		$title_id		= $this->uri->segment(3);
		$this->admin_model->deleteRecord(array('title_id'=>$title_id),'title');
		$this -> session -> set_flashdata('success_msg', 'Title deleted successfully');
		redirect('adminhome/addCategory');
	}
	public function addContent()
	{
		//This function is used to add content
		$detail=array();
		if($this->uri->segment(3)!='')
		{
			$query="SELECT * FROM `content` co LEFT JOIN `title` t ON co.`title_id`=t.`title_id` LEFT JOIN `category` c ON co.`category_id`=c.`category_id` WHERE co.`content_id`= '".$this->uri->segment(3)."'";
			$detail['detail']=$this->admin_model->getRecordQuery($query);
		}
		$this->load->view('admin/add_content',$detail);
		if(isset($_POST['submit']))
		{
			$category			= $this->input->post('category');
			$title				= $this->input->post('title');
			$content			= $this->input->post('content');
			$content_spanish	= $this->input->post('content_spanish');
			
			if(isset($_FILES['image']['name']))
			{
				if($_FILES['image']['name']!='')
				{
					$imanename = $_FILES['image']['name'];
					$temp = explode(".", $_FILES["image"]["name"]);
					$newfilename = rand(1, 99999) . '.' . end($temp);
					//This is for upload the image
					$path= './images/content/'.$newfilename;
					$upload = copy($_FILES['image']['tmp_name'], $path);
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
						'category_id'		=> $category,
						'title_id'			=> $title,
						'content'			=> $content,
						'cantent_spanish'	=> $content_spanish,
						'image'				=> $newfilename,
						'created'			=> date('Y-m-d H:i:s'));
						
			$result=$this->admin_model->saveRecord('content', $data);
			if($result==0)
			{
				$this->session->set_flashdata('error_msg','Content could not add');
				redirect('adminhome/viewContent');	
			}
			else 
			{
				$this->session->set_flashdata('success_msg','Content added successfully');
				redirect('adminhome/viewContent');
			}
		}
		if(isset($_POST['update']))
		{
			$category			= $this->input->post('category');
			$title				= $this->input->post('title');
			$content			= $this->input->post('content');
			$content_spanish	= $this->input->post('content_spanish');
			$content_id			= $this->uri->segment(3);
			
			if(isset($_FILES['image1']['name']))
			{
				if($_FILES['image1']['name']!='')
				{
					$imanename = $_FILES['image1']['name'];
					$temp = explode(".", $_FILES["image1"]["name"]);
					$newfilename = rand(1, 99999) . '.' . end($temp);
					//This is for upload the image
					$path= './images/content/'.$newfilename;
					$upload = copy($_FILES['image1']['tmp_name'], $path);
				}
				else 
				{
					$newfilename =$detail['detail'][0]['image'];
				}
			}	
			else 
			{
				$newfilename =$detail['detail'][0]['image'];
			}
			
			$data=array(
						'category_id'		=> $category,
						'title_id'			=> $title,
						'content'			=> $content,
						'cantent_spanish'	=> $content_spanish,
						'image'				=> $newfilename,
						);
						
			$result=$this->admin_model->updateRecord('content',$data,array('content_id'=>$content_id));
			$this->session->set_flashdata('success_msg','Content added successfully');
			redirect('adminhome/viewContent');
		}
	}
	public function getTitle()
	{
		//This function is for ajax
		//This function is for getting the title of the category
		$result=$this->admin_model->getRecord('title', array('category_id'=>$this->uri->segment(3)));
		if($result==0)
		{
			echo '<option> no title</option>';
		}
		else 
		{
			foreach ($result as $value) 
			{
				echo '<option value="'.$value['title_id'].'">'.$value['title_name'].'</option>';	
			}
		}
	}
	public function viewContent()
	{
		//This function is used to view content
		$query="SELECT * FROM `content` co LEFT JOIN `title` t ON co.`title_id`=t.`title_id` LEFT JOIN `category` c ON co.`category_id`=c.`category_id`";
		$result['data']=$this->admin_model->getRecordQuery($query);
		$this->load->view('admin/view_content',$result);
	}
	public function deleteContent()
	{
		//This function is for delete the content
		//now getting the values from view
		$content_id=$this->uri->segment(3);
		$this->admin_model->deleteRecord(array('content_id'=>$content_id),'content');
		$this->session->set_flashdata('success_msg','Content deleted successfully');
		redirect('adminhome/viewContent');
	}
	public function addContinents()
	{
		//This function is add or update the continents
		$detail['data']=$this->admin_model->getRecord('continents', array());
		if($this->uri->segment(3)!='')
		{
			$detail['detail']=$this->admin_model->getRecord('continents', array('continent_id'=>$this->uri->segment(3)));	
		}
		$this->load->view('admin/add_continents',$detail);
		if(isset($_POST['submit']))
		{
			$continent_name=$this->input->post('continent_name');
			$continent_spanish=$this->input->post('continent_spanish');
			$check=$this->admin_model->getRecord('continents', array('continent_name'=>$continent_name,'continent_spanish'=>$continent_spanish));
			if($check!=0)
			{
				//contient name is already exist
				$this->session->set_flashdata('error_msg','This Continent name is already exist');
				redirect('adminhome/addContinents');
			}
			else
			{
				
				//now add the continent
				if(isset($_FILES['image']['name']))
				{
					if($_FILES['image']['name']!='')
					{
						$imanename = $_FILES['image']['name'];
						$temp = explode(".", $_FILES["image"]["name"]);
						$newfilename = rand(1, 99999) . '.' . end($temp);
						//This is for upload the image
						$path= './images/continents/'.$newfilename;
						$upload = copy($_FILES['image']['tmp_name'], $path);
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
							'continent_name'=>$continent_name,
							'continent_spanish'=>$continent_spanish,
							'image'=>$newfilename,
							'created'=>date('Y-m-d H:i:s'));
							
				$result=$this->admin_model->saveRecord('continents', $data);
				if($result==0)
				{
					//continent could add this time
					$this->session->set_flashdata('error_msg','Continent could not add');
					redirect('adminhome/addContinents');	
				}
				else
				{
					$this->admin_model->updateRecord('update_dates',array('continents_update_date'=>date('Y-m-d H:i')),array('update_id'=>1));
					//continent added successfully
					$this->session->set_flashdata('success_msg','Continent added successfully');
					redirect('adminhome/addContinents');
				}
			}
		}
		//now update the continent
		if(isset($_POST['update']))
		{
			//now getting the values from view
			$continent_name		= $this->input->post('continent_name');
			$continent_spanish	= $this->input->post('continent_spanish');
			$continent_id		= $this->uri->segment(3);
			
			$check=$this->admin_model->getRecord('continents', array('continent_name'=>$continent_name,'continent_spanish'=>$continent_spanish,'continent_id!='=>$continent_id));
			if($check!=0)
			{
				//contient name is already exist
				$this->session->set_flashdata('error_msg','This Continent name is already exist');
				redirect('adminhome/addContinents');
			}
			else
			{
				//now add the continent
				if(isset($_FILES['image1']['name']))
				{
					if($_FILES['image1']['name']!='')
					{
						$imanename = $_FILES['image1']['name'];
						$temp = explode(".", $_FILES["image1"]["name"]);
						$newfilename = rand(1, 99999) . '.' . end($temp);
						//This is for upload the image
						$path= './images/continents/'.$newfilename;
						$upload = copy($_FILES['image1']['tmp_name'], $path);
					}
					else 
					{
						$newfilename =$detail['detail'][0]['image'];
					}
				}	
				else 
				{
					$newfilename =$detail['detail'][0]['image'];
				}
				$data = array(
							'continent_name'=>$continent_name,
							'continent_spanish'=>$continent_spanish,
							'image'=>$newfilename
					    );
				$result=$this->admin_model->updateRecord('continents',$data,array('continent_id'=>$continent_id));
				$this->admin_model->updateRecord('update_dates',array('continents_update_date'=>date('Y-m-d H:i')),array('update_id'=>1));
				$this->session->set_flashdata('success_msg','Continent added successfully');
				redirect('adminhome/addContinents');
			}
		}
	}
	public function deleteContinent()
	{
		//This function is use to delete the continents
		$continent_id=$this->uri->segment(3);
		$this->admin_model->deleteRecord(array('continent_id'=>$continent_id),'continents');
		$this->session->set_flashdata('success_msg','Continent deleted successfully');
		redirect('adminhome/addContinents');
	}
	public function addCountries()
	{
		//This function is for adding the countries for continet
		if($this->uri->segment(3)!="")
		{
			$detail['detail']=$this->admin_model->getRecord('countries', array('country_id'=>$this->uri->segment(3)));	
		}
		$query="SELECT * FROM `countries`c LEFT JOIN `continents` con ON c.`continent_id`=con.`continent_id`";
		$detail['data']=$this->admin_model->getRecordQuery($query);
		$this->load->view('admin/add_country',$detail);
		if(isset($_POST['submit']))
		{
			$continet_id		= $this->input->post('continent');
			$country_name		= $this->input->post('country_name');
			$country_spanish	= $this->input->post('country_spanish');
			$number				= $this->input->post('number');
			$email_id			= $this->input->post('email_id');
			//now check the country already exist or not
			$check=$this->admin_model->getRecord('countries', array('country_name'=>$country_name,'continent_id'=>$continet_id));
			if($check==0)
			{
				//There is no country for this continent
				$data=array(
							'country_name'		=> $country_name,
							'continent_id'		=> $continet_id,
							'country_spanish'	=> $country_spanish,
							'number'			=> $number,
							'email_id'			=> $email_id,
							'created'			=> date('Y-m-d H:i:s'));
				$result=$this->admin_model->saveRecord('countries', $data);
				if($result==0)
				{
					$this->session->set_flashdata('error_msg','Country could not add');
					redirect('adminhome/addCountries');
				}
				else 
				{
					$this->session->set_flashdata('success_msg','Country added successfully');
					redirect('adminhome/addCountries');
				}
			}
			else 
			{
				$this->session->set_flashdata('error_msg','country already exist in this continent');
				redirect('adminhome/addCountries');
			}
		}
		if(isset($_POST['update']))
		{
			$country_id			= $this->uri->segment(3);
			$continet_id		= $this->input->post('continent');
			$country_name		= $this->input->post('country_name');
			$country_spanish	= $this->input->post('country_spanish');
			$number				= $this->input->post('number');
			$email_id			= $this->input->post('email_id');
			//now check the country already exist or not
			$check=$this->admin_model->getRecord('countries', array('country_name'=>$country_name,'continent_id'=>$continet_id,'country_id!='=>$country_id));
			if($check==0)
			{
				//There is no country for this continent
				$data=array(
							'country_name'		=> $country_name,
							'continent_id'		=> $continet_id,
							'country_spanish'	=> $country_spanish,
							'number'			=> $number,
							'email_id'			=> $email_id,
							);
				$result=$this->admin_model->updateRecord('countries',$data,array('country_id'=>$country_id));
			
				$this->session->set_flashdata('success_msg','Country updated successfully');
				redirect('adminhome/addCountries');
			}
			else 
			{
				$this->session->set_flashdata('error_msg','country already exist in this continent');
				redirect('adminhome/addCountries');
			}
		}
	}
	public function deleteCountries()
	{
		//This function is use to delete the countries
		$country_id=$this->uri->segment(3);
		$this->admin_model->deleteRecord(array('country_id'=>$country_id),'countries');
		
		$this->session->set_flashdata('success_msg','Country deleted successfully');
		redirect('adminhome/addCountries');
	}
	public function uploadxl()
	{
		//echo $_SERVER['DOCUMENT_ROOT'].'/itsupport/assets/excel/PHPExcel.php';die;
		require $_SERVER['DOCUMENT_ROOT'].'/itsupport/assets/excel/PHPExcel.php';
		require_once $_SERVER['DOCUMENT_ROOT'].'/itsupport/assets/excel/PHPExcel/IOFactory.php';
		$this->load->view('admin/upload_xl_file');
		
		if(isset($_POST['submit']))
		{
			
			//Load file
			$path = $_FILES['xls_file']['tmp_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($path);
			
			//Loop threw file to get data
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
			{
				$worksheetTitle     = $worksheet->getTitle();
				
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
				
				for ($row = 1; $row <= $highestRow; ++ $row) 
				{
				    for ($col = 0; $col < $highestColumnIndex; ++ $col) 
				    {
				        $cell = $worksheet->getCellByColumnAndRow($col, $row);
				        $val = $cell->getCalculatedValue();
				    }
				}
			}
			
			for ($row = 1; $row <= $highestRow; ++ $row) 
			{
				$val=array();
				for ($col = 0; $col < $highestColumnIndex; ++ $col) 
				{
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val[] = $cell->getValue();
				}
				echo "<pre>";
				print_r($val);
				//Now insert the data in database
				/*$data=array(
							'continent_id'=>$val[0],
							'country_name'=>$val[1],
							'country_spanish'=>$val[2],
							'number'=>$val[3],
							'created'=>date('Y-m-d H:i:s'));
				$this->admin_model->saveRecord('countries', $data);*/
			}
			die;
			$this->session->set_flashdata('success_msg','Country added successfully');
			redirect('adminhome/addCountries');
		}
	}
	public function exportExcel()
	{
	
		/*******EDIT LINES 3-8*******/
	 
		$filename = "excelfilename";         //File Name
		$flag = false;
		$file_ending = "xls";
		$query="SELECT * FROM `continents` c LEFT JOIN `countries` cu ON c.`continent_id`=cu.`continent_id`";
		$result=$this->admin_model->getRecordQuery($query);
	
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		/*******Start of Formatting for Excel*******/ 
		$i=1;  
		 foreach ($result as $val) 
		 {
        	$arr = array(
				'Sr no'=>$i,
                'Continent English' => $val['continent_name'],
                'Continent Spanish' => $val['continent_spanish'],
                'Country English' => $val['country_name'],
                'Country Spanish' => $val['country_spanish'],
                'Number' => $val['number'],
            );
                if(!$flag){
                    // display field/column names as first row
                    echo implode("\t", array_keys($arr)) . "\r\n";
                    echo "\n";
                } 
                $flag = true;
                echo implode("\t", array_values($arr)) . "\r\n";
                $i++;
            }
            echo "\n";  

	}
    //// code by deepika 
    /* Start send alert notification */
	public function alertNotification()
	{
		if(isset($_POST['submit']))
		{
			if($this->form_validation->run('alert_notifi_val')==FALSE)
			{
				$this->load->view('admin/alert_notification');
			}
			else 
			{
				$notification	= ($_POST['notification'] != '')?$_POST['notification'] : '';;
				$platform 		= ($_POST['platform'] != '')?$_POST['platform'] : '';;
				$location 		= ($_POST['location'] != '')?$_POST['location'] : '';;
				$notifi_date	= ($_POST['notifi_date'] != '')?$_POST['notifi_date'] : '';;
				$status 		= ($_POST['status'] != '')?$_POST['status'] : '';;
				$notifi_type 	= ($_POST['notifi_type'] != '')?$_POST['notifi_type'] : '';;
				
				$data = array(
					
					'notification'=> $notification,
					'platform'	  => $platform,
					'location'	  => $location,
					'notifi_date' => $notifi_date,
					'status'	  => $status,
					'notifi_type' => $notifi_type,
					'created'	  => date('Y-m-d H:i:s')
				);
							
				$result=$this->admin_model->saveRecord('alert_notification', $data);
				if($result!=0)
				{
					//now send the notification
					$device=$this->admin_model->getRecord('user', array('device_token!='=>''));
					if($device!=0)
					{
						foreach ($device as $value) 
						{
							if($value['notification']==0)
							{
								if($value['device_type']==0)
								{
									//This is for android 
									$array=array(
											'message'	  => $notification,
											'platform'	  => $platform,
											'location'	  => $location,
											'notifi_date' => $notifi_date,
											'status'	  => $status,
											'notifi_type' => $notifi_type,
											'created'	  => date('Y-m-d H:i:s')
										);
									$this->admin_model->send_android_notification($value['device_token'],$array);	
								}
								else 
								{
									//This is for ios
									$array=array(
											'alert' 		=> $notification,
											'platform'	  	=> $platform,
											'location'	  	=> $location,
											'notifi_date' 	=> $notifi_date,
											'status'	  	=> $status,
											'notifi_type' 	=> $notifi_type,
											'created'	  	=> date('Y-m-d H:i:s'),
											'sound' 		=> 'default',
										);
									$this->admin_model->ios_notification($value['device_token'],$array);	
								}
							}
						}
					}
					$this->session->set_flashdata('success_msg','send successfully');
				}
				else 
				{
					$this->session->set_flashdata('error_msg','Data could not send at the moment');
				}
				redirect('adminhome/alertNotification');
			}
		}else{
			$this->load->view('admin/alert_notification');
		}
	}
}
?>