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
						$tit['content']			= array();
						//now getting the content of this title
						$content=$this->user_model->getRecord('content',array('category_id'=>$valueti['category_id'],'title_id'=>$valueti['title_id']));
						if($content!=0)
						{
							foreach ($content as $valuecon) 
							{
								$cont['content_id']			= $valuecon['content_id'];
								$cont['category_id']		= $valuecon['category_id'];
								$cont['title_id']			= $valuecon['title_id'];
								$cont['content']			= $valuecon['content'];
								$cont['cantent_spanish']	= $valuecon['cantent_spanish'];
								$cont['created']			= $valuecon['created'];
								$cont['updated']			= $valuecon['updated'];
								$tit['content'][]			= $cont;	
							}
						}
						$cat['title'][]=$tit;
					}
				}
				$post['category'][]=$cat;	
			}
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
				$continents['continent_id']=$value['continent_id'];
				$continents['continent_name']=$value['continent_name'];
				$continents['continent_spanish']=$value['continent_spanish'];
				$continents['created']=$value['created'];
				$continents['updated']=$value['updated'];
				
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
}	