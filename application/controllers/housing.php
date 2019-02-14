<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Housing extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
        $this->load->model('member_model');
        $this->load->model('basis_model');
        $this->load->model('board_model');
        $this->load->model('category_model');
        $this->load->model('business_model');
        $this->load->model('housing_model');
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
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();

        $data['rents']=$this->housing_model->get_recent_rent();
        $data['sales']=$this->housing_model->get_recent_sale();
        $data['prents']=$this->housing_model->get_premium_rent();
        $data['psales']=$this->housing_model->get_premium_sale();
        $data['cats1']=$this->housing_model->get_cat(3);
        $data['cats2']=$this->housing_model->get_cat(9);
        $data['locs']=$this->housing_model->get_locations();
        $data['brokers']=$this->housing_model->get_bocker();

        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/index',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        //$this->load->view('frontend/jobs/index_js');
    }
    public function search_result($page = "")
    {
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();
        $search_data=$this->input->get();$search_data['type'] = 1;
     
            if($this->input->get("search_type")=="sale"){
                $search_data['search_type'] = "sale";                $search_data['type'] = 2;
            }else {
                $search_data['search_type'] = "rent";				$search_data['type'] = 1;
            }
      

        $data['search_data']=$search_data;
        if($page<1)$page=1;
        $data['rents']=$this->housing_model->get_search_data($search_data,$page);

        $data1['page']=$page;
        $data['cats1']=$this->housing_model->get_cat(3);
        $data['cats2']=$this->housing_model->get_cat(9);
        $data['locs']=$this->housing_model->get_locations();
        $data['key']=$this->housing_model->get_gmapi();
        $data['lat']=40.75233;
        $data['lng']=-73.85346;
        $loc_data=$this->housing_model->get_locations($data['search_data']['location']);
        $zip=$loc_data[0]['zip'];
        if(!empty($zip)) {
            //Formatted address
            $formattedAddr = str_replace(' ', '+', $zip);
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&sensor=false');
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            if( $output->results[0]->geometry->location->lat!="" &&  $output->results[0]->geometry->location->lng!="") {
                $data['lat'] = $output->results[0]->geometry->location->lat;
                $data['lng'] = $output->results[0]->geometry->location->lng;
            }
        }
        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/result',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/housing/result_js',$data1);
    }

    public function propertyimageUpload(){		
	if($_FILES["file"]["name"]!=""){     
	$target_dir = 'assets/housing_logos/';       
	$filename=basename($_FILES["file"]["name"]);     
	$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));     
	$new_filename=time();        
    $target_file = $target_dir . $new_filename.".".$imageFileType;   
	move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);		
	$input=array(			'src'=>$target_file			);	
	$id=$this->housing_model->insertData('tbl_housing_images',$input);	
	$ret="<img src='".base_url().$target_file."' width='200px'><input type='hidden' name='pimgs[]' value='$id'>";		
	echo $ret;      
	}		
	}    
	public function listProperty(){	
$uid=$this->housing_model->get_current_user();
	if($uid!=null){	
	$data['selected'] = 'hosing';
	$header_data = $this->__generate_header_data("housing");      
	$footer_data = $this->__generate_footer_data();     
	$data['cats1']=$this->housing_model->get_cat(3);    
    $data['cats2']=$this->housing_model->get_cat(9);     
	$data['locs']=$this->housing_model->get_locations();	
	$this->load->view('kpabal/common/header',$header_data);     
	$this->load->view('frontend/housing/list',$data);   
	$this->load->view('kpabal/common/footer',$footer_data);      
	$this->load->view('frontend/housing/result_js',$data1);	
}else{
		redirect(base_url().'login');
	}	
	}  
	public function dashboard(){		
	$uid=$this->housing_model->get_current_user();
	 $data['authorID']=$this->housing_model->get_current_user();
	if($uid!=null){
	$header_data = $this->__generate_header_data("housing");   
	$footer_data = $this->__generate_footer_data();            
    $uid=$this->housing_model->get_current_user();
	if($this->input->post()!=null){
		$input=array(
		'area'=>$this->input->post('address'),
		'about'=>$this->input->post('about'),
		'author'=>$uid,
		);
		$in=array(
		'mobile'=>$this->input->post('mobile')
		);
		$in1=array(
		
		);
		
	}
	$data['usermaster']=$this->housing_model->getData('tbl_member',array('memberIdx'=>$uid));
	$data['userdata']=$this->housing_model->getData('tbl_housing_broker',array('author'=>$uid));
	$data['properties']=$this->housing_model->get_all_properties($uid);
	$this->load->view('kpabal/common/header',$header_data);      
	$this->load->view('frontend/housing/dashboard',$data);      
	$this->load->view('kpabal/common/footer',$footer_data);     
	$this->load->view('frontend/housing/result_js');	
	}else{
		redirect(base_url().'login');
	}
	}  
	public function details($id = "")
    {
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();

        $data['data']=$this->housing_model->get_recent_rent($id);	
		
		$pics= json_decode($data['data'][0]['images']);	
		$allpic=array();			
		if($pics!=null){
		foreach($pics->images as $im){	
		$allpic[]=$this->housing_model->getData('tbl_housing_images',array('id'=>$im))[0]['src'];		
		}			
		}
		$data['images']=$allpic;
		
       /* $data['author']=$this->housing_model->get_user_name($data['data'][0]['author']);
        $data['authorEmail']=$this->housing_model->get_user_email($data['data'][0]['author']);
        $data['authorID']=$data['data'][0]['author'];
        $data['location']=$this->housing_model->get_location_name($data['data'][0]['location']);
        $data['category']=$this->housing_model->get_cat_name($data['data'][0]['subcat']);*/
        $data['cats1']=$this->housing_model->get_cat(3);
        $data['cats2']=$this->housing_model->get_cat(9);
        $data['locs']=$this->housing_model->get_locations();
        $data['current_user']=$this->housing_model->get_current_user();
        $data['authorID']=$this->housing_model->get_current_user();


        $this->db->set("views",$data['data'][0]["views"]+1);
        $this->db->where("id",$id);
        $this->db->update("housing");

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/housing/rentDetail',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/housing/result_js');
    }

    public function saleDetail($id = "")
    {
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();

        $data['data']=$this->housing_model->get_recent_sale($id);

        $data['author']=$this->housing_model->get_user_name($data['data'][0]['author']);
        $data['authorEmail']=$this->housing_model->get_user_email($data['data'][0]['author']);
        $data['authorID']=$data['data'][0]['author'];

        $data['location']=$this->housing_model->get_location_name($data['data'][0]['location']);
        $data['category']=$this->housing_model->get_cat_name($data['data'][0]['subcat']);
        $data['cats1']=$this->housing_model->get_cat(3);
        $data['cats2']=$this->housing_model->get_cat(9);
        $data['locs']=$this->housing_model->get_locations();
        $data['current_user']=$this->housing_model->get_current_user();

        $this->db->set("views",$data['data'][0]["views"]+1);
        $this->db->where("id",$id);
        $this->db->update("housing_sale");

        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/saleDetail',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/housing/result_js');
    }
    public function new_rent($id = "")
    {
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();

        $data['key']=$this->housing_model->get_gmapi();
        $data['p_cats']=$this->housing_model->get_cat(0);
        $data['s_cats']=$this->housing_model->get_cat(3);
        //$data['j_types']=$this->housing_model->get_type();
        $data['locations']=$this->housing_model->get_locations();

        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/new_rent',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/housing/result_js');
    }
    public function post_insert(){
        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_rent($data);
        redirect("housing");
    }
    public function new_sale()
    {
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();

        $data['key']=$this->housing_model->get_gmapi();
        $data['p_cats']=$this->housing_model->get_cat(0);
        $data['s_cats']=$this->housing_model->get_cat(9);
        $data['locations']=$this->housing_model->get_locations();

        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/new_sale',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    public function post_sale_insert(){
        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_sale($data);
        redirect("housing");
    }
    public function post_list_property(){
        $data=$this->input->post();
              		if($data!=null){						  $author=$this->housing_model->get_current_user();        $date=date('Y-m-d');$type=0;        if($data["form_type"]=="Rent"){          $type=1;        }else {            $type=2;        }		$show='off';        if($data['isDisplay']!=""){           $show='on';        }else{          $show='off';        }		if($author==null){			$author='452';		}				if($data['con_dog']==null){			$data['con_dog']='off';		}		if($data['con_photo']==null){			$data['con_photo']='off';		}		if($data['con_car']==null){			$data['con_car']='off';		}		if($data['con_phone']==null){			$data['con_phone']='off';		}		if($data['con_int']==null){			$data['con_int']='off';		}if($data['con_tv']==null){			$data['con_tv']='off';		}if($data['con_cook']==null){			$data['con_cook']='off';		}		if($data['con_smoke']==null){			$data['con_smoke']='off';		}		if($data['con_cat']==null){			$data['con_cat']='off';		}		if($data['con_note']==null){			$data['con_note']='off';		}				$input=array(		'title'=>$data['title'],		'pre_price'=>$data['pre_price'],		'pre_date'=>$data['pre_date'],		'category'=> $data['careers_occupation1'],		'subcat'=> $data['careers_occupation2'],		'location'=> $data['location'],		'address'=> $data['address'],		'phone'=> $data['phone'],		'email'=> $data['email'],		'gender'=> $data['gender'],		'price'=> $data['price'],		'etc'=> $data['etc'],		'lat'=> $data['lat'],		'lng'=> $data['lng'],		'area'=> $data['area'],		'createDate'=> $date,		'type'=> $type,		'author'=> $author,		'content'=> $data['content'],		'show'=> $show,		'util'=>$data['util'],		'deposit'=> $data['deposit'],		'con_dog'=>$data['con_dog'],		'con_cat'=> $data['con_cat'],		'con_smoke'=> $data['con_smoke'],		'con_cook'=> $data['con_cook'],		'con_tv'=> $data['con_tv'],		'con_int'=> $data['con_int'],		'con_phone'=> $data['con_phone'],		'con_car'=> $data['con_car'],		'con_photo'=> $data['con_photo'],		'con_note'=> $data['con_note'],		'images'=> json_encode(array('images'=>$data['pimgs'])),						);  					$x=$this->housing_model->insertData('tbl_housing',$input);			redirect(base_url().'housing/details/'.$x);					}		
       
    }

    public function edit_rent($id=0)
    {
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();

        $data['key']=$this->housing_model->get_gmapi();

        $data['p_cats']=$this->housing_model->get_cat(0);
        //$data['j_types']=$this->housing_model->get_type();
        $data['locations']=$this->housing_model->get_locations();

        //$id=$this->input->get('id');
        if($id>0){
            $this->db->select("*");
            $this->db->from("housing");
            $this->db->where("id",$id);
            $res=$this->db->get();
            $data['data']=$res->result_array();
            $data['s_cats']=$this->housing_model->get_cat(3);
        }

        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/edit_rent',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    public function post_update(){
        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_rent($data);
        redirect("housing");
    }

    public function edit_sale($id=0)
    {
        $data['selected'] = 'hosing';
        $header_data = $this->__generate_header_data("housing");
        $footer_data = $this->__generate_footer_data();

        $data['key']=$this->housing_model->get_gmapi();
        $data['s_cats']=$this->housing_model->get_cat(0);
        //$data['j_types']=$this->housing_model->get_type();
        $data['locations']=$this->housing_model->get_locations();

        //$id=$this->input->get('id');
        if($id>0){
            $this->db->select("*");
            $this->db->from("housing_sale");
            $this->db->where("id",$id);
            $res=$this->db->get();
            $data['data']=$res->result_array();
            $data['s_cats']=$this->housing_model->get_cat(9);
        }

        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/edit_sale',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    public function post_sale_update(){
        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_sale($data);
        redirect("housing");
    }

    public function delete_rent($id = 0){
        $this->housing_model->delete_rent($id);
        redirect("housing");
    }

    public function delete_sale($id = 0){
        $this->housing_model->delete_sale($id);
        redirect("housing");
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

        $data['rents']=$this->housing_model->get_rentByAuthor($memberIdx);
        $data['sales']=$this->housing_model->get_saleByAuthor($memberIdx);

        $footer_data = $this->__generate_footer_data();
        $footer_data['additional_js'] = [
        ];
        $this->load->view('kpabal/housing/header',$header_data);
        $this->load->view('frontend/housing/author',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        //$this->load->view("kpabal/user/profile_js", $data);
    }
    public function import_data(){
        $path = 'data.xml';
        $xmlfile = file_get_contents($path);
        $xml = new SimpleXMLElement($xmlfile);
        $xmls=$xml->Worksheet->Table->Row;
        foreach($xmls as $x){
            $email=trim($x->Cell[3]->Data[0]);
            if($email!="") {
                $title = $x->Cell[0]->Data[0];
                $author0 = explode("(",$x->Cell[1]->Data[0]);
                $author1=explode(")",$author0[1]);
                $author2=$author1[0];
                $author=$this->housing_model->get1_user_id($author2,$email);
                $dateview = explode(" / ", $x->Cell[2]->Data[0]);
                $date = $dateview[0];
                $view = $dateview[1];
                $phone = $x->Cell[4]->Data[0];
                $category=3;
                $subcat0 = $x->Cell[5]->Data[0];
                $subcat=$this->housing_model->get1_cat($subcat0);
                $region0 = $x->Cell[6]->Data[0];
                $address = $x->Cell[17]->Data[0];
                $zip0=explode("(",$address);
                $zip=explode(")",$zip0[1]);
                $region=$this->housing_model->get1_location($region0,$zip[0]);
                echo $region."<br>";
                $pprice = explode(" ", $x->Cell[7]->Data[0]);
                $price = $pprice[1];
                $gender = $x->Cell[8]->Data[0];
                if($gender=="상관없음")$gender="Both";
                if($gender=="남자")$gender="Male";
                if($gender=="여자")$gender="Female";
                $utility= $x->Cell[9]->Data[0];
                if($utility=="포함"){
                    $utility="on";
                }else{
                    $utility="off";
                }
                $broker = $x->Cell[10]->Data[0];
                $deposit = str_replace("$ ","", $x->Cell[11]->Data[0]);

                $condition = $x->Cell[12]->Data[0];
                if (strpos($condition, 'Dog가능') !== false) {
                    $dog="on";
                }else{
                    $dog="off";
                }
                if (strpos($condition, 'Cat가능') !== false) {
                    $cat="on";
                }else{
                    $cat="off";
                }
                if (strpos($condition, '흡연가능') !== false) {
                    $smoke="on";
                }else{
                    $smoke="off";
                }
                if (strpos($condition, '취사가능') !== false) {
                    $cook="on";
                }else{
                    $cook="off";
                }
                if (strpos($condition, 'TV') !== false) {
                    $tv="on";
                }else{
                    $tv="off";
                }

                if (strpos($condition, '주차가능') !== false) {
                    $car="on";
                }else{
                    $car="off";
                }

                $photo="off";
                $note="off";



                if($x->Cell[13]->Data[0]="있음") {
                    $internet = "on";
                }else{
                    $internet="off";
                }
                if($x->Cell[14]->Data[0]="설치가능") {
                    $phoneline = "on";
                }else{
                    $phoneline="off";
                }
                $movedate = $x->Cell[15]->Data[0];
                $etc = $x->Cell[18]->Data[0];
                $image = $x->Cell[19]->Data[0];

                $this->db->set("category ",$category);
                $this->db->set("subcat",$subcat);
                $this->db->set("location",$region);
                $this->db->set("title",$title);
                $this->db->set("logo",$image);
                $this->db->set("author",$author);
                $this->db->set("createDate",$date);
                $this->db->set("email",$email);
                $this->db->set("phone",$phone);
                $this->db->set("price",$price);
                $this->db->set("address",$address);
                $this->db->set("etc",$etc);
                //$this->db->set("content",$subcat);
                $this->db->set("views",$view);
                $this->db->set("gender",$gender);
                $this->db->set("show","on");
                $this->db->set("moving_date",$movedate);
                $this->db->set("util",$utility);
                $this->db->set("deposit",$deposit);
                $this->db->set("con_dog",$dog);
                $this->db->set("con_cat",$cat);
                $this->db->set("con_smoke",$smoke);
                $this->db->set("con_cook",$cook);
                $this->db->set("con_tv",$tv);
                $this->db->set("con_int",$internet);
                $this->db->set("con_phone",$phoneline);
                $this->db->set("con_car",$car);
                $this->db->set("con_photo",$photo);
                $this->db->set("con_note",$note);
                $this->db->insert('housing');
            }
        }
    }

    public function duo(){
        //header("Location:http://m.duo.co.kr/");
        header("Location:http://Wedeliver4u.com");
    }
}