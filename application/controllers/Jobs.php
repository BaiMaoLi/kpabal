<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation','session');
        $this->load->model('member_model');
        $this->load->model('basis_model');
        $this->load->model('board_model');
        $this->load->model('category_model');
        $this->load->model('business_model');
        $this->load->model('job_model');
	}
	public function fav(){
		$out=array();
	$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
		
	if($memberIdx==''){
		$out=array('success'=>false,'msg'=>'You need login to perform this action');
	}else{
		$data=array(
		'userid'=>$this->input->post('pid'),
		'rid'=>$memberIdx,
		'type'=>$this->input->post('type'),
		);
		$this->job_model->insertData('tbl_job_fav_shortlist',$data);
		$out=array('success'=>true,'msg'=>'Marked favorite');
	}
	    header('Content-Type: application/json');
	echo json_encode($out);
	}
	public function fav_job(){
		$out=array();
	$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
		
		
	if($memberIdx==''){
		$out=array('success'=>false,'msg'=>'You need login to perform this action');
	}else{
		
		$pr=$this->job_model->getData('tbl_job_persons',array('author'=>$memberIdx));
		if(count($pr)>0){
		$data=array(
		'userid'=>$pr[0]['id'],
		'jobid'=>$this->input->post('jid'),
		'type'=>$this->input->post('type'),
		);
		$this->job_model->insertData('tbl_job_fav_application',$data);
		$out=array('success'=>true,'msg'=>'Marked favorite');
	}
		else{
			$out=array('success'=>false,'msg'=>'Please submit your profile to apply');
		}
	}
	    header('Content-Type: application/json');
	echo json_encode($out);
	}
    public function __generate_header_data($caption = "") {
        $header_data = [];

        $header_data['loggedinuser'] = __get_user_session();
        $header_data['caption'] = $caption;
        $header_data['categories'] = $this->category_model->get_tree_rows_with_parent("site_menu", "01", true);
        $header_data['news_categories'] = $this->category_model->get_tree_rows("news_category", true);
        $header_data['blog_categories'] = $this->category_model->get_tree_rows("board_category", true);
        $header_data['notices'] = $this->basis_model->get_rows_total("site_notice", "", "page_date desc", 0, 5);

        return $header_data;
    }

    public function __generate_footer_data() {
        $footer_data = [];
        $footer_data['blog_categories'] = $this->category_model->get_rows("board_category");
        $footer_data['recent_business'] = $this->business_model->recent_business();
        $footer_data['total_business'] = $this->business_model->total_count();
        $footer_data['total_client'] = $footer_data['total_business'] + $this->member_model->total_count();

        return $footer_data;
    }
	
	public function index($category = "")
	{
        $data['selected'] = 'jobs';
        $header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();

        	$this->db->select("*");
		    $this->db->from("jobs");
		    $this->db->order_by("id", "desc");
		    $data['careers_occupation1']=0;
		    $data['careers_occupation2']=0;
		    $data['careers_type']=0;
		    $data['company_location']=0;
		    $data['keyword']="";
		    if($this->input->post('careers_occupation2')>0){
		        $this->db->where("subcat",$this->input->post('careers_occupation2'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		        $data['careers_occupation2']=$this->input->post('careers_occupation2');
		    }else if($this->input->post('careers_occupation1')>0){
		        $this->db->where("category",$this->input->post('careers_occupation1'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		    }
		    if($this->input->post('careers_type')>0){
		        $this->db->where("careers_type",$this->input->post('careers_type'));
		        $data['careers_type']=$this->input->post('careers_type');
		    }
		    if($this->input->post('company_location')>0){
		        $this->db->where("company_location",$this->input->post('company_location'));
		        $data['company_location']=$this->input->post('company_location');
		    }
		    if($this->input->post('keyword')!=""){
		        $this->db->where("title like '%".$this->input->post('keyword')."%'");
		        $data['keyword']=$this->input->post('keyword');
		    }
		    $res=$this->db->get();
		    if($this->db->count_all_results()>0){
    		    $data['p_cats']=$this->job_model->get_cat(0);
    		    if($data['careers_occupation1']>1){
                    $data['s_cats']=$this->job_model->get_cat($data['careers_occupation1']);
    		    }else{
    		        $data['s_cats']=$this->job_model->get_cat(1);
    		    }

                $data['j_types']=$this->job_model->get_type();
                $data['locations']=$this->job_model->get_locations();
                $search=$res->result_array();
                $result=array();
                foreach($search as $sch){
                    $loc_id=$sch['company_location'];
                    $sch['company_location']=$this->job_model->get_location_name($loc_id);
                    array_push($result,$sch);
                }
                $data['data']=$result;
		    }

        $message_data=$this->input->post();
        if($message_data['contact_name']!=""){
            if($this->job_model->contact($message_data)) {
                $data['error'] = "ok";
            }else{
                $data['error'] = "failed";
            }
        }
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
		$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
		if($memberIdx!=''){
			$pr=$this->job_model->getData('tbl_job_persons',array('author'=>$memberIdx));
		$data['favs']=$this->job_model->getData('tbl_job_fav_application',array('userid'=>$pr[0]['id']));
	
		}else{
			$data['favs']=array();
		}
		
        $data['pre_jobs']=$this->job_model->get_pre_jobs();
        $data['pre_persons']=$this->job_model->get_pre_persons();
        $data['jobs']=$this->job_model->get_jobs();
        $data['persons']=$this->job_model->get_persons();
        $data['brokers']=$this->job_model->get_all_persons();
        $data['companies']=$this->job_model->get_companies();
        $data['allcomp']=$this->job_model->getData('tbl_jobs_company',array());
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/index',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
    }
    public function details($id=0)
		{
            $header_data = $this->__generate_header_data("jobs");
            $footer_data = $this->__generate_footer_data();
                    $data['data']=$this->job_model->get_jobs($id);
                    $this->db->set("lookup",$data['data'][0]["lookup"]+1);
    		        $this->db->where("id",$id);
    		        $this->db->update("jobs");

                    $data['user_id']=$this->job_model->get_current_user();
					$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
						$member = $this->general->user_logged_in();
                       $memberIdx = $member->memberIdx;
					  $pr=$this->job_model->getData('tbl_job_persons',array('author'=>$memberIdx));
					$data['data']['favs']=$this->job_model->getData('tbl_job_fav_application',array('userid'=>$pr[0]['id']));
					$data['data']['applications']=$this->job_model->getData('tbl_job_fav_application',array('jobid'=>$id,'type'=>1));
					$data['data']['skills']=$this->job_model->getData('tbl_job_skills',array());
                    $message_data=$this->input->post();
                    if($message_data['contact_name']!=""){
                        if($this->job_model->contact($message_data)) {
                            $data['error'] = "ok";
                        }else{
                            $data['error'] = "failed";
                        }
                    }
        			
                    $this->load->view('kpabal/common/header',$header_data);
                    $this->load->view('frontend/jobs/details',$data);
                    $this->load->view('kpabal/common/footer',$footer_data);
                    $this->load->view('frontend/jobs/index_js');
		}
		
	public function join_person(){
	$input=array(
		'author'=>$this->job_model->get_current_user()
		);
		if($this->job_model->get_current_user()!=''){
		$r=$this->job_model->getData('tbl_job_persons',$input);
		if(count($r)==0){
			$input1=array(
		'author'=>$this->job_model->get_current_user(),
		'post_date'=>date('Y-m-d'),
		);
		$this->job_model->insertData('tbl_job_persons',$input1);
		$r=$this->job_model->getData('tbl_job_persons',$input);
		redirect("jobs/details_person/".$r[0]['id']);
		}else{
			redirect("jobs/details_person/".$r[0]['id']);
		}
		}else{
		redirect("login");	
		}
		
	}
	public function join_company(){
		$input=array(
		'author'=>$this->job_model->get_current_user()
		);
		if($this->job_model->get_current_user()!=''){
		$r=$this->job_model->getData('tbl_jobs_company',$input);
		if(count($r)==0){
			$input1=array(
		'author'=>$this->job_model->get_current_user(),
		'joined'=>date('Y-m-d'),
		);
		$this->job_model->insertData('tbl_jobs_company',$input1);
		$r=$this->job_model->getData('tbl_jobs_company',$input);
		redirect("jobs/edit_company/".$r[0]['id']);
		}else{
			redirect("jobs/manage_jobs/");
		}}else{
		redirect("login");	
		}
	}
	public function edit_company($id=0){
		$header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();
		$data['msg']='';
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
			if($this->input->post()!=null){
			$data['msg']='Company updated successfully';
			if($_FILES['userfile']['tmp_name']){

     $config['upload_path']          = './assets/company_logos/';
                $config['allowed_types']        = 'gif|jpg|png';
                $new_name = time().$_FILES["userfile"]['name'];
                $config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                    
                }
                else
                {
                      
                      $in=array(
		'logo'=>'assets/company_logos/'.$new_name
		);
		$this->job_model->updateData('tbl_jobs_company',array('id'=>$id),$in);
                }
}
			
			$postData=$this->input->post();
			
			$input=array(
			'name'=>$postData['name'],
			'employees'=>$postData['employees'],
			'business_type'=>$postData['business_type'],
			'company_level'=>$postData['company_level'],
			'about'=>$postData['about'],
			'location'=>$postData['location'],
			'company_address'=>$postData['company_address'],
			'home_page'=>$postData['home_page'],
			'email'=>$postData['email'],
			'phone'=>$postData['phone'],
			'near_by'=>$postData['near_by'],
			'fb'=>$postData['fb'],
			'twitter'=>$postData['twitter'],
			'linkedin'=>$postData['linkedin'],
			'youtube'=>$postData['youtube']
			);
			$this->job_model->updateData('tbl_jobs_company',array('id'=>$id),$input);
			}
		$data['company']=$this->job_model->getData('tbl_jobs_company',array('id'=>$id));
		$data['user_id']=$this->job_model->get_current_user();
		$data['locations']=$this->job_model->get_locations();
		if($data['user_id']==$data['company'][0]['author']){
			
	$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/edit_company',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
		}else{
			redirect('jobs');
		}		
	}
	public function application($id=''){
		$header_data = $this->__generate_header_data("jobs");
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
        $footer_data = $this->__generate_footer_data();
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['s_cats']=$this->job_model->get_cat(1);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['user_id']=$this->job_model->get_current_user();
        $data['eval']=array();
		if($data['user_id']!=''){
			
				$d=$this->job_model->getData('tbl_jobs',array('id'=>$id,'author'=>$this->job_model->get_current_user()));
				if(count($d)>0){
					
			
		$company=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($company)==0){
			$data['nor']=true;
		}else{
			$data['nor']=false;
		}
		$data['company']=$company;
		$data['job']=$this->job_model->getData('tbl_jobs',array('id'=>$id));
	
		$data['favs']=$this->job_model->getData('tbl_job_fav_shortlist',array('rid'=>$this->job_model->get_current_user()));
		$data['apps']=$this->job_model->getData('tbl_job_fav_application',array('jobid'=>$id,'type'=>1));
		$data['persons']=$this->job_model->get_all_persons();
		$data['jobSkills']=$this->job_model->getData('tbl_job_skills',array());
	   $data['jobEducations']=$this->job_model->getData('tbl_job_educations');
	   $data['exps']=$this->job_model->getData('tbl_job_experience',array());
		$data['quals']=$this->job_model->getData('tbl_job_qualifications',array());
		$data['locations']=$this->job_model->get_locations();
		$data['j_types']=$this->job_model->get_type();

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/application',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
		}else{
					redirect('jobs/');
				}
		}else{
			redirect('jobs');
		}
		
	}
	public function myapplication(){
		$header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
		if($this->input->get('pre')!=null){
			$d=$this->job_model->getData('tbl_jobs',array('id'=>$this->input->get('pre'),'author'=>$this->job_model->get_current_user()));
				if(count($d)>0){
					$in=array(
					'pre_price'=>120					
					);
					$this->job_model->updateData('tbl_jobs',array('id'=>$this->input->get('pre')),$in);
					redirect('jobs/manage_jobs');
				}else{
					redirect('jobs/manage_jobs');
				}
		}
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['s_cats']=$this->job_model->get_cat(1);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['user_id']=$this->job_model->get_current_user();
        $data['eval']=array();
		if($data['user_id']!=''){
			
		$company=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($company)==0){
			$data['nor']=true;
		}else{
			$data['nor']=false;
		}
		$data['company']=$company;
		$data['jobs']=$this->job_model->get_jobs_all();
	
		$data['favs']=$this->job_model->getData('tbl_job_fav_shortlist',array('rid'=>$this->job_model->get_current_user()));
		$p=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		$data['apps']=$this->job_model->getData('tbl_job_fav_application',array('userid'=>$p[0]['id'],'type'=>1));
		$data['apshort']=$this->job_model->getData('tbl_job_fav_application',array('userid'=>$p[0]['id'],'type'=>0));
		$data['persons']=$this->job_model->get_all_persons();
		$data['jobSkills']=$this->job_model->getData('tbl_job_skills',array());
	   $data['jobEducations']=$this->job_model->getData('tbl_job_educations');
	   $data['exps']=$this->job_model->getData('tbl_job_experience',array());
		$data['quals']=$this->job_model->getData('tbl_job_qualifications',array());
		$data['locations']=$this->job_model->get_locations();
		$data['j_types']=$this->job_model->get_type();

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/myapplications',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
		}else{
			redirect('jobs');
		}
	}
	public function manage_jobs(){
	$header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
		if($this->input->get('pre')!=null){
			$d=$this->job_model->getData('tbl_jobs',array('id'=>$this->input->get('pre'),'author'=>$this->job_model->get_current_user()));
				if(count($d)>0){
					$in=array(
					'pre_price'=>120					
					);
					$this->job_model->updateData('tbl_jobs',array('id'=>$this->input->get('pre')),$in);
					redirect('jobs/manage_jobs');
				}else{
					redirect('jobs/manage_jobs');
				}
		}
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['s_cats']=$this->job_model->get_cat(1);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['user_id']=$this->job_model->get_current_user();
        $data['eval']=array();
		if($data['user_id']!=''){
			if($this->input->get('del')!=null){
				$d=$this->job_model->getData('tbl_jobs',array('id'=>$this->input->get('del'),'author'=>$this->job_model->get_current_user()));
				if(count($d)>0){
					$this->job_model->deleteData('tbl_jobs',array('id'=>$this->input->get('del')));
					redirect('jobs/manage_jobs');
				}else{
					redirect('jobs/manage_jobs');
				}
			}
		$company=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($company)==0){
			$data['nor']=true;
		}else{
			$data['nor']=false;
		}
		$data['company']=$company;
		$data['jobs']=$this->job_model->get_jobs_for_company($company[0]['id']);
	
		$data['favs']=$this->job_model->getData('tbl_job_fav_shortlist',array('rid'=>$this->job_model->get_current_user()));
		$p=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		$data['apps']=$this->job_model->getData('tbl_job_fav_application',array('userid'=>$p[0]['id']));
		$data['persons']=$this->job_model->get_all_persons();
		$data['jobSkills']=$this->job_model->getData('tbl_job_skills',array());
	   $data['jobEducations']=$this->job_model->getData('tbl_job_educations');
	   $data['exps']=$this->job_model->getData('tbl_job_experience',array());
		$data['quals']=$this->job_model->getData('tbl_job_qualifications',array());
		$data['locations']=$this->job_model->get_locations();
		$data['j_types']=$this->job_model->get_type();

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/manage_job',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
		}else{
			redirect('jobs');
		}
		
	}
	public function newp($id=0){
        $header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['s_cats']=$this->job_model->get_cat(1);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['user_id']=$this->job_model->get_current_user();
        $data['eval']=array();
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
		if($data['user_id']!=''){
			
			if($this->input->get('edit')!=null){
				$data['eval']=$this->job_model->getData('tbl_jobs',array('id'=>$this->input->get('edit')));
				if($data['eval'][0]['author']!=$data['user_id']){
					redirect('jobs');
				}
			}
		$data['jobSkills']=$this->job_model->getData('tbl_job_skills',array());
	   $data['jobEducations']=$this->job_model->getData('tbl_job_educations');
	   $data['exps']=$this->job_model->getData('tbl_job_experience',array());
		$data['quals']=$this->job_model->getData('tbl_job_qualifications',array());
		$data['locations']=$this->job_model->get_locations();
		$data['j_types']=$this->job_model->get_type();

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/new',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
		}else{
			redirect('jobs');
		}
		
    }
    public function post_update_data(){ 
	  $data=$this->input->post();
        if($this->job_model->get_current_user()<1){
            redirect("login/");
        }else {
          
			$company=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
			$input=array(
			'title'=>$data['title'],
			'company_location'=>$data['company_location'],
			'experience'=>$data['experience'],
			'category'=>$data['careers_occupation1'],
			'subcat'=>$data['careers_occupation2'],
			'education'=>$data['education'],
			'careers_type'=>$data['careers_type'],
			'careers_time'=>$data['careers_time'],
			'careers_weekly'=>$data['careers_weekly'],
			'careers_salary'=>$data['careers_salary'],
			'qualification'=>$data['qualification'],
			'gender'=>$data['gender'],
			'content'=>$data['content'],
			'skills'=>json_encode(array('skills'=>$data['skills'])),
			'company_id'=>$company[0]['id'],
			'post_date'=>date('Y-m-d',time()),
			'show'=>'on',
			'author'=>$this->job_model->get_current_user(),
			);
			$this->job_model->updateData('tbl_jobs',array('id'=>$data['postid']),$input);
           // $this->job_model->edit_job($data);
            redirect("jobs/newp?edit=".$data['postid'].'&msg=success');
        }
		
	}
    public function post_insert(){
        $data=$this->input->post();
        if($this->job_model->get_current_user()<1){
            redirect("login/");
        }else {
           /* if ($_FILES["company_logo"]["name"] != "") {
                $target_dir = 'assets/company_logos/';
                $filename = basename($_FILES["company_logo"]["name"]);
                $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $new_filename = strtotime(date("Y-m-d H:i:s"));
                $target_file = $target_dir . $new_filename . "." . $imageFileType;
                move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file);
                $data['logo'] = $target_file;
            }*/
			$company=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
			$input=array(
			'title'=>$data['title'],
			'company_location'=>$data['company_location'],
			'experience'=>$data['experience'],
			'category'=>$data['careers_occupation1'],
			'subcat'=>$data['careers_occupation2'],
			'education'=>$data['education'],
			'careers_type'=>$data['careers_type'],
			'careers_time'=>$data['careers_time'],
			'careers_weekly'=>$data['careers_weekly'],
			'careers_salary'=>$data['careers_salary'],
			'qualification'=>$data['qualification'],
			'gender'=>$data['gender'],
			'content'=>$data['content'],
			'skills'=>json_encode(array('skills'=>$data['skills'])),
			'company_id'=>$company[0]['id'],
			'post_date'=>date('Y-m-d',time()),
			'show'=>'on',
			'author'=>$this->job_model->get_current_user(),
			);
			$this->job_model->insertData('tbl_jobs',$input);
           // $this->job_model->edit_job($data);
            redirect("jobs/");
        }
	}
	public function delete_job($id = 0){
        $this->db->where('id', $id);
        $this->db->delete('jobs');
	    redirect("jobs/");
	}
	public function edit($id=0)
	{
        $header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['user_id']=$this->job_model->get_current_user();
        
		//$id=$this->input->get('id');
		if($id>0){
		    $this->db->select("*");
		    $this->db->from("jobs");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
		    $data['data']=$res->result_array();
            $data['s_cats']=$this->job_model->get_cat($data['data'][0]['category']);
		}
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/edit',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        //$this->load->view('frontend/jobs/index_js');
	}
/*	public function post_update(){
        $data=$this->input->post();
        if($_FILES["company_logo"]["name"]!=""){
            $target_dir = 'assets/company_logos/';
            $filename=basename($_FILES["company_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->job_model->edit_job($data);
	    redirect("jobs/");
	}*/
	
	
	public function person()
	{
        $header_data = $this->__generate_header_data("person");
        $footer_data = $this->__generate_footer_data();
	        $this->db->select("*");
		    $this->db->from("job_persons");
		    $this->db->order_by("id", "desc");
		    $data['careers_occupation1']=0;
		    $data['careers_occupation2']=0;
		    $data['careers_type']=0;
		    $data['company_location']=0;
		    $data['keyword']="";
		    if($this->input->post('careers_occupation2')>0){
		        $this->db->where("subcat",$this->input->post('careers_occupation2'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		        $data['careers_occupation2']=$this->input->post('careers_occupation2');
		    }else if($this->input->post('careers_occupation1')>0){
		        $this->db->where("category",$this->input->post('careers_occupation1'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		    }
		    if($this->input->post('careers_type')>0){
		        $this->db->where("careers_type",$this->input->post('careers_type'));
		        $data['careers_type']=$this->input->post('careers_type');
		    }
		    if($this->input->post('company_location')>0){
		        $this->db->where("company_location",$this->input->post('company_location'));
		        $data['company_location']=$this->input->post('company_location');
		    }
		    if($this->input->post('keyword')!=""){
		        $this->db->where("title like '%".$this->input->post('keyword')."%'");
		        $data['keyword']=$this->input->post('keyword');
		    }
		    $res=$this->db->get();
		    if($this->db->count_all_results()>0){
    		    $data['p_cats']=$this->job_model->get_cat(0);
    		    if($data['careers_occupation1']>1){
                    $data['s_cats']=$this->job_model->get_cat($data['careers_occupation1']);
    		    }else{
    		        $data['s_cats']=$this->job_model->get_cat(1);
    		    }
                
                $data['j_types']=$this->job_model->get_type();
                $data['locations']=$this->job_model->get_locations();
                $search=$res->result_array();
                $result=array();
                foreach($search as $sch){
                    $loc_id=$sch['company_location'];
                    $sch['company_location']=$this->job_model->get_location_name($loc_id);
                    $cat=$this->job_model->get_cat_name($sch['category']);
                    $scat=$this->job_model->get_cat_name($sch['subcat']);
                    $sch['category']=$cat[0]['name'];
                    $sch['subcat']=$scat[0]['name'];
                    $sch['careers_type']=$this->job_model->get_type_name($sch['careers_type'])[0]['name'];
                    array_push($result,$sch);
                }
                $data['data']=$result;
		    }
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/person',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
	}
	public function new_person()
	{
        $header_data = $this->__generate_header_data("person");
        $footer_data = $this->__generate_footer_data();
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['s_cats']=$this->job_model->get_cat(1);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['user_id']=$this->job_model->get_current_user();
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/new_person',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
	}
	public function person_insert(){
        $data=$this->input->post();
        $this->job_model->edit_person($data);
		redirect("jobs/person");
	}
	public function details_person($id=0)
	{
        $header_data = $this->__generate_header_data("person");
        $footer_data = $this->__generate_footer_data();
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['exps']=$this->job_model->getData('tbl_job_experience',array());
        $data['user_id']=$this->job_model->get_current_user();
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}


        $data['data']=$this->job_model->get_persons_by_id($id);
       // $data['data']=$this->job_model->getData('tbl_job_persons',array('id'=>$id));
		/*print_r($data['data']);
		print_r($id);*/
        $data['data']['personCertificates']=$this->job_model->getData('tbl_job_person_certificates',array('person_id'=>$id));
        $data['data']['personEducations']=$this->job_model->getData('tbl_job_person_education',array('person_id'=>$id));
        $data['data']['personExperience']=$this->job_model->getData('tbl_job_person_experience',array('person_id'=>$id));
        $data['data']['personSkills']=$this->job_model->getData('tbl_job_person_skills',array('person_id'=>$id));
        $data['data']['jobSkills']=$this->job_model->getData('tbl_job_skills',array());
		$member = $this->general->user_logged_in();
                       $memberIdx = $member->memberIdx;
					  $pr=$this->job_model->getData('tbl_job_persons',array('author'=>$memberIdx));
					$data['data']['favs']=$this->job_model->getData('tbl_job_fav_shortlist',array('rid'=>$memberIdx));
					$data['data']['userid']=$pr[0]['id'];
        $this->db->set("lookup",$data['data'][0]["lookup"]+1);
        $this->db->where("id",$id);
        $this->db->update("job_persons");
		$message_data=$this->input->post();
        if($message_data['contact_name']!=""){
            if($this->job_model->contact($message_data)) {
                $data['error'] = "ok";
            }else{
                $data['error'] = "failed";
            }
        }
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/details_person',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
	}
	public function edit_person($id=0)
	{
		$data['msg']='';
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
		if($this->input->post()!=null){
			
			if($_FILES['userfile']['tmp_name']){

     $config['upload_path']          = './assets/jobs/';
                $config['allowed_types']        = 'gif|jpg|png';
                $new_name = time().$_FILES["userfile"]['name'];
                $config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                    
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                      $in=array(
		'avatar'=>'assets/jobs/'.$new_name
		);
		$this->job_model->updateData('tbl_member',array('memberIdx'=>$this->job_model->get_current_user()),$in);
                }
}
			$postdata=$this->input->post();
			$specialism=$postdata['specialism'];
			$experience=$postdata['experience'];
			$fb=$postdata['fb'];
			$twitter=$postdata['twitter'];
			$linkedin=$postdata['linkedin'];
			$youtube=$postdata['youtube'];
			$content=$postdata['content'];
			$title=$postdata['title'];
			$careers_salary=$postdata['careers_salary'];
			$company_location=$postdata['company_location'];
			
			$educationDegree=$postdata['educationDegree'];
			$educationPeriod=$postdata['educationPeriod'];
			$educationInstitute=$postdata['educationInstitute'];
			$educationDes=$postdata['educationDes'];
			$educationID=$postdata['educationID'];
			
			$experienceRole=$postdata['experienceRole'];
			$experiencePeriod=$postdata['experiencePeriod'];
			$experienceCompany=$postdata['experienceCompany'];
			$experienceDes=$postdata['experienceDes'];
			
			$certificatesTitle=$postdata['certificatesTitle'];
			$certificatesPeriod=$postdata['certificatesPeriod'];
			$certificatesDes=$postdata['certificatesDes'];
			
			$skillLevel=$postdata['skillLevel'];
			$skillName=$postdata['skillName'];
			
			$personCertificates=$this->job_model->getData('tbl_job_person_certificates',array('person_id'=>$id));
        $personEducations=$this->job_model->getData('tbl_job_person_education',array('person_id'=>$id));
        $personExperience=$this->job_model->getData('tbl_job_person_experience',array('person_id'=>$id));
        $personSkills=$this->job_model->getData('tbl_job_person_skills',array('person_id'=>$id));
		
		$in=array(
		'content'=>$content,
		'category'=>$specialism,
		'fb'=>$fb,
		'twitter'=>$twitter,
		'youtube'=>$youtube,
		'linkedin'=>$linkedin,
		'experience'=>$experience,
		'careers_salary'=>$careers_salary,
		'company_location'=>$company_location,
		'title'=>$title
		);
		$this->job_model->updateData('tbl_job_persons',array('id'=>$id),$in);
		foreach($personCertificates as $pc){
			$found=0;
		foreach($certificatesTitle as $key=>$cert){
			if($key==$pc['id']){
				$found=1;
			}
		}
		
		if($found==0){
			$this->job_model->deleteData('tbl_job_person_certificates',array('id'=>$pc['id']));
		}
		}
		foreach($certificatesTitle as $key=>$cert){
			if($cert!=''){
			$found=0;
			foreach($personCertificates as $pc){
			if($key==$pc['id']){
				$found=1;
			}	
			}
			if($found==1){
				//update
				$input=array(
				'title'=>$certificatesTitle[$key],
				'period'=>$certificatesPeriod[$key],
				'description'=>$certificatesDes[$key],
				'person_id'=>$id
				);
				
				$this->job_model->updateData('tbl_job_person_certificates',array('id'=>$key),$input);
			}else{
				$input=array(
				'title'=>$certificatesTitle[$key],
				'period'=>$certificatesPeriod[$key],
				'description'=>$certificatesDes[$key],
				'person_id'=>$id
				);
				$this->job_model->insertData('tbl_job_person_certificates',$input);
			}
			}
		}
		
			foreach($personExperience as $pc){
			$found=0;
		foreach($experienceRole as $key=>$cert){
			if($key==$pc['id']){
				$found=1;
			}
		}
		
		if($found==0){
			$this->job_model->deleteData('tbl_job_person_experience',array('id'=>$pc['id']));
		}
		}
			
		foreach($experienceRole as $key=>$cert){
			if($cert!=''){
			$found=0;
			foreach($personExperience as $pc){
			if($key==$pc['id']){
				$found=1;
			}	
			}
			if($found==1){
				//update
				$input=array(
				'role'=>$experienceRole[$key],
				'company'=>$experienceCompany[$key],
				'period'=>$experiencePeriod[$key],
				'description'=>$experienceDes[$key],
				'person_id'=>$id
				);
				
				$this->job_model->updateData('tbl_job_person_experience',array('id'=>$key),$input);
			}else{
				$input=array(
				'role'=>$experienceRole[$key],
				'company'=>$experienceCompany[$key],
				'period'=>$experiencePeriod[$key],
				'description'=>$experienceDes[$key],
				'person_id'=>$id
				);
				$this->job_model->insertData('tbl_job_person_experience',$input);
			}
			}
		}
		
		
		
			foreach($personEducations as $pc){
			$found=0;
		foreach($educationDegree as $key=>$cert){
			if($key==$pc['id']){
				$found=1;
			}
		}
		
		if($found==0){
			$this->job_model->deleteData('tbl_job_person_education',array('id'=>$pc['id']));
		}
		}
		
		foreach($educationDegree as $key=>$cert){
			if($cert!=''){
			$found=0;
			foreach($personEducations as $pc){
			if($key==$pc['id']){
				$found=1;
			}	
			}
			if($found==1){
				//update
				$input=array(
				'degree'=>$educationDegree[$key],
				'institute'=>$educationInstitute[$key],
				'description'=>$educationDes[$key],
				'period'=>$educationPeriod[$key],
				'education_id'=>$educationID[$key],
				'person_id'=>$id
				);
				
				$this->job_model->updateData('tbl_job_person_education',array('id'=>$key),$input);
			}else{
				$input=array(
				'degree'=>$educationDegree[$key],
				'institute'=>$educationInstitute[$key],
				'description'=>$educationDes[$key],
				'period'=>$educationPeriod[$key],
				'education_id'=>$educationID[$key],
				'person_id'=>$id
				);
				
				$this->job_model->insertData('tbl_job_person_education',$input);
			}
			}
		}
		
		foreach($personSkills as $pc){
			$found=0;
		foreach($skillLevel as $key=>$cert){
			if($key==$pc['id']){
				$found=1;
			}
		}
		
		if($found==0){
			//print_r($personSkills);
			$this->job_model->deleteData('tbl_job_person_skills',array('id'=>$pc['id']));
		}
		}
		
		
			$sn=0;
		foreach($skillLevel as $key=>$cert){
			if($cert!=''){
			$found=0;
			foreach($personSkills as $pc){
			if($key==$pc['id']){
				$found=1;
			}	
			}
			if($found==1){
				//update
				$input=array(
				'level'=>$skillLevel[$key]
				);
				
				$this->job_model->updateData('tbl_job_person_skills',array('id'=>$key),$input);
			}else{
				$input=array(
				'skill_id'=>$skillName[$sn],
				'level'=>$skillLevel[$key],
				'person_id'=>$id
				);
				//print_r($input);
				$this->job_model->insertData('tbl_job_person_skills',$input);
				$sn++;
			}
			}
		}	
		$data['msg']='Profile updated successfully';
		}
        $header_data = $this->__generate_header_data("person");
        $footer_data = $this->__generate_footer_data();
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $data['user_id']=$this->job_model->get_current_user();
       $data['data']=$this->job_model->get_persons($id);
		
		if($data['data'][0]['author']==$data['user_id']){
		if($id>0){
		    
            $data['s_cats']=$this->job_model->get_cat($data['data'][0]['category']);
			$data['data']['jobEducations']=$this->job_model->getData('tbl_job_educations');
			$data['data']['personCertificates']=$this->job_model->getData('tbl_job_person_certificates',array('person_id'=>$id));
        $data['data']['personEducations']=$this->job_model->getData('tbl_job_person_education',array('person_id'=>$id));
        $data['data']['personExperience']=$this->job_model->getData('tbl_job_person_experience',array('person_id'=>$id));
        $data['data']['personSkills']=$this->job_model->getData('tbl_job_person_skills',array('person_id'=>$id));
        $data['data']['jobSkills']=$this->job_model->getData('tbl_job_skills',array());
        $data['data']['cats']=$this->job_model->getData('tbl_job_cat',array('parent'=>0));
		}
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/edit_person',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
		}else{
			//redirect(base_url().'jobs');
		}
	}
	
    public function update_person(){
        $data=$this->input->post();
        $this->job_model->edit_person($data);
    	redirect("jobs/person");
    }
    public function delete_person($id = 0){
        $this->db->where('id', $id);
        $this->db->delete('job_persons');
	    redirect("jobs/person");
	}
	public function total_persons($category = "")
    {
        $header_data = $this->__generate_header_data("person");
        $footer_data = $this->__generate_footer_data();

        $message_data=$this->input->get();
        if($message_data['contact_name']!=""){
            if($this->job_model->contact($message_data)) {
                $data['error'] = "ok";
            }else{
                $data['error'] = "failed";
            }
        }else{
            $post_data=$this->input->get();
        }
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
		$data['elevels']=$this->job_model->getData('tbl_job_educations',array());
		$data['exps']=$this->job_model->getData('tbl_job_experience',array());
		$data['quals']=$this->job_model->getData('tbl_job_qualifications',array());
		$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
		if($memberIdx!=''){
		$data['favs']=$this->job_model->getData('tbl_job_fav_shortlist',array('rid'=>$memberIdx));
		}else{
			$data['favs']=array();
		}
        if($category!="") {
            $divcat = explode("_", $category);
            $cat_type = $divcat[0];
            $cat = $divcat[1];
            $data['persons']=$this->job_model->get_persons_by_cat($cat_type,$cat);
            $data['pre_persons']=$this->job_model->get_pre_persons_by_cat($cat_type,$cat);
        }else if(count($post_data)>0){
            $data['persons']=$this->job_model->search_persons($post_data);
            $data['pre_persons']=$this->job_model->search_pre_persons($post_data);
			$data['keyword']=$post_data['keyword'];
			$data['postdate']=$post_data['postdate'];
			$data['education']=$post_data['education'];
			$data['experience']=$post_data['experience'];
			$data['qualification']=$post_data['qualification'];
			$data['careers_occupation1']=$post_data['careers_occupation1'];
			$data['careers_occupation2']=$post_data['careers_occupation2'];
			$data['careers_type']=$post_data['careers_type'];
			$data['company_location']=$post_data['company_location'];
        }else{
            $data['persons']=$this->job_model->get_persons();
            $data['pre_persons']=$this->job_model->get_pre_persons();
        }
        $data['user_id']=$this->job_model->get_current_user();
        $data['category_tree']=$this->job_model->get_category_tree();

        $data['p_cats']=$this->job_model->get_cat(0);
        if($data['careers_occupation1']>1){
            $data['s_cats']=$this->job_model->get_cat($data['careers_occupation1']);
        }else{
            $data['s_cats']=$this->job_model->get_cat(1);
        }

        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/total_persons',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        //$this->load->view('frontend/jobs/index_js');
    }
    public function total_jobs($category = "")
    {
        $data['selected'] = 'jobs';
        $header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();

        $message_data=$this->input->post();
        if($message_data!=null){
            if($this->job_model->contact($message_data)) {
                $data['error'] = "ok";
            }else{
                $data['error'] = "failed";
            }
        }else{
            $post_data=$this->input->get();
        }
		$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
		$data['elevels']=$this->job_model->getData('tbl_job_educations',array());
		$data['exps']=$this->job_model->getData('tbl_job_experience',array());
		$data['quals']=$this->job_model->getData('tbl_job_qualifications',array());
		$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
		if($memberIdx!=''){
			$pr=$this->job_model->getData('tbl_job_persons',array('author'=>$memberIdx));
		$data['favs']=$this->job_model->getData('tbl_job_fav_application',array('userid'=>$pr[0]['id']));
	
		}else{
			$data['favs']=array();
		}
        if($category!="") {
            $divcat = explode("_", $category);
            $cat_type = $divcat[0];
            $cat = $divcat[1];
            $data['jobs']=$this->job_model->get_jobs_by_cat($cat_type,$cat);
            $data['pre_jobs']=$this->job_model->get_pre_jobs_by_cat($cat_type,$cat);
        }else if(count($post_data)>0){
            $data['jobs']=$this->job_model->search_jobs($post_data);
            $data['pre_jobs']=$this->job_model->search_pre_jobs($post_data);
			$data['keyword']=$post_data['keyword'];
			$data['postdate']=$post_data['postdate'];
			$data['education']=$post_data['education'];
			$data['experience']=$post_data['experience'];
			$data['qualification']=$post_data['qualification'];
			$data['careers_occupation1']=$post_data['careers_occupation1'];
			$data['careers_occupation2']=$post_data['careers_occupation2'];
			$data['careers_type']=$post_data['careers_type'];
			$data['company_location']=$post_data['company_location'];
        }else{
            $data['jobs']=$this->job_model->get_jobs();
            $data['pre_jobs']=$this->job_model->get_pre_jobs();
        }
        $data['user_id']=$this->job_model->get_current_user();
        $data['category_tree']=$this->job_model->get_category_tree();

        $data['p_cats']=$this->job_model->get_cat(0);
        if($data['careers_occupation1']>1){
            $data['s_cats']=$this->job_model->get_cat($data['careers_occupation1']);
        }else{
            $data['s_cats']=$this->job_model->get_cat(1);
        }

        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/total_jobs',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        //$this->load->view('frontend/jobs/index_js');
    }
    public function author($memberIdx=0){
        /*if (!$this->general->frontend_controlpanel_logged_in()) {
            redirect(FRONTEND_LOGIN_PUBLIC_DIR);
        }*/

        $header_data = $this->__generate_header_data("Author");
        $header_data['loggedinuser'] = __get_user_session();
        if($memberIdx==0)$memberIdx = $header_data['loggedinuser']['memberIdx'];
        $data['memberIdx']=$memberIdx;
        $data['member'] = $this->member_model->get_item($memberIdx);
        $data['states'] = $this->category_model->get_tree_rows("address_state");
        $message_data=$this->input->post();
        if($message_data['contact_name']!=""){
            $from=$message_data['email'];
            $to=$message_data['author_email'];
            $name=$message_data['contact_name'];
            $phone=$message_data['phone'];
            $subject=$message_data['message_content']. "\r\n";
            $subject.="My Phone: ".$phone;
            $headers = "From: ". $from . "\r\n" ."CC: somebodyelse@example.com";

            if(mail($to,$name,$subject, $headers)) {
                $data['error'] = "ok";
            }else{
                $data['error'] = "failed";
            }
        }

        //$data['rents']=$this->job_model->get_rentByAuthor($memberIdx);
        //$data['sales']=$this->job_model->get_saleByAuthor($memberIdx);

        $footer_data = $this->__generate_footer_data();
        $footer_data['additional_js'] = [
        ];
        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/jobs/author',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        //$this->load->view("kpabal/user/profile_js", $data);
    }

    public function details_company($id=0)
    {
        $header_data = $this->__generate_header_data("jobs");
        $footer_data = $this->__generate_footer_data();
		$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
		if($memberIdx!=''){
			$pr=$this->job_model->getData('tbl_job_persons',array('author'=>$memberIdx));
		$data['favs']=$this->job_model->getData('tbl_job_fav_application',array('userid'=>$pr[0]['id']));
	
		}else{
			$data['favs']=array();
		}
			$companyd=$this->job_model->getData('tbl_jobs_company',array('author'=>$this->job_model->get_current_user()));
		if(count($companyd)>0){
			$data['is_comp']=$companyd[0]['id'];
		}else{
			$data['is_comp']='';
		}
		$personsd=$this->job_model->getData('tbl_job_persons',array('author'=>$this->job_model->get_current_user()));
		if(count($personsd)>0){
			$data['is_cand']=$personsd[0]['id'];
		}else{
			$data['is_cand']='';
		}
        $data['data']=$this->job_model->get_jobs_company($id);
        $data['company']=$this->job_model->getData('tbl_jobs_company',array('id'=>$id));
		$data['user_id']=$this->job_model->get_current_user();
		$data['locations']=$this->job_model->get_locations();
        $data['data']['jobs']=$this->job_model->get_jobs_for_company($id);
        $this->db->set("lookup",$data['data'][0]["lookup"]+1);
        $this->db->where("id",$id);
        $this->db->update("jobs");

        $data['user_id']=$this->job_model->get_current_user();
        $message_data=$this->input->post();
        if($message_data['contact_name']!=""){
            if($this->job_model->contact($message_data)) {
                $data['error'] = "ok";
            }else{
                $data['error'] = "failed";
            }
        }

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/jobs/details_company',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/jobs/index_js');
    }
}