<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Talky_model extends CI_Model {
    public function get_cat($id){
        $this->db->select("*");
        $this->db->from("talky_category");
        $this->db->where("parent",$id);
        $res=$this->db->get();
        //print_r($id);die;
        return $res->result_array();
    }
    public function edit_talky($data){
        if(count($data['tags'])>0){
            foreach ($data['tags'] as $tag){
                $this->db->select("*");
                $this->db->from("talky_tags");
                $this->db->where("title",$tag);
                $res=$this->db->get();
                if(count($res->result_array())<1){
                    $this->insert_tag($tag);
                }
            }
            $this->db->set('tags', serialize($data['tags']));
        }
        $date=date('Y-m-d H:i:s');
        $this->db->set('talky_title', $data['title']);
        if($data['content']!="")$this->db->set('talky_desc', $data['content']);
        if($data['category']!="")$this->db->set('category', $data['category']);
        $this->db->set('post_date', $date);
        if($data['talky_photo']!="")$this->db->set('post_img', $data['talky_photo']);
        if($data['talky_video']!="")$this->db->set('post_video', $data['talky_video']);
        $this->db->set('author', $data['author']);
        $id=$data['id'];
        if($id>0){
            $this->db->where('id',$id);
            $res = $this->db->update('talky');
        }else {
            $res = $this->db->insert('talky');
        }

    }
    public function insert_tag($tag){
        $this->db->set("title",$tag);
        $this->db->set("logo","");
        $this->db->set("active","");
        $res=$this->db->insert("talky_tags");
        return $res;
    }
    public function get_tags($id=""){
        $this->db->select("*");
        $this->db->from("talky_tags");
        if($id>0)$this->db->where("id",$id);
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_active_tags(){
        $this->db->select("*");
        $this->db->from("talky_tags");
        $this->db->where("active","on");
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_search_talky($id="",$cat="",$keyword="",$tag=""){
        $this->db->select("*");
        $this->db->from("talky");
        if($id>0)$this->db->where("id",$id);
        if($cat!="")$this->db->where("category",$cat);
        if($keyword!="")$this->db->like("talky_title",$keyword);
        if($tag!="")$this->db->like("tags",$tag);
        $this->db->order_by("post_date", "desc");
        $res=$this->db->get();

        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $sch['author_data']=$this->get_user($sch['author']);
            $sch['comments']=$this->get_comments($sch['id']);
            array_push($result,$sch);
        }
        return $result;

    }
    public function get_search_talky_by_category($id=""){
        $this->db->select("*");
        $this->db->from("talky");
        if($id>0)$this->db->where("category",$id);
        $this->db->order_by("post_date", "desc");
        $res=$this->db->get();

        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $sch['author_data']=$this->get_user($sch['author']);
            $sch['comments']=$this->get_comments($sch['id']);
            array_push($result,$sch);
        }
        return $result;

    }
    public function view_list($id){
        $this->db->select("*");
        $this->db->from("talky");
        $this->db->where("category",$id);
        $this->db->order_by("post_date", "desc");
        $res=$this->db->get();
        $html="";
        $data=$res->result_array();
        foreach ($data as $v){
            if($v['post_video']!="") {
                $html.='
                <li>
                    <div class="wrap">

                        <figure data-url="'.ROOTPATH."talky/detail/".$v["id"].'"
                                onclick="location.href="'.ROOTPATH."talky/detail/".$v["id"].'">
                            <a data-start="0">
                                <div class="image">
                                    <video controls autoplay
                                           poster="https://i.imgur.com/sH63yqs_d.jpg?maxwidth=520&amp;shape=thumb&amp;fidelity=high"
                                           draggable="false" preload="none" loop=""
                                           src="'.ROOTPATH."talky/detail/".$v["post_video"].'"
                                           type="video/mp4" style="width: 100%; height: auto;"></video>
                                </div>
                                <figcaption>
                                    <h3>'.$v["talky_title"].'</h3>
                                    <span class="writer">'.$v["author"].'</span>
                                </figcaption>
                            </a>
                        </figure>
                    </div>
                </li>';
            }else {
                $html.='
                <li>
                    <div class="wrap">

                        <figure data-url="'.ROOTPATH."talky/detail/".$v["id"].'"
                                onclick="location.href="'.ROOTPATH."talky/detail/".$v["id"].'">
                            <a data-start="1">
                                <div class="image"><img
                                        src="'.ROOTPATH.$v["post_img"].'"
                                        alt="'.$v["talky_title"].'"/>
                                </div>
                                <figcaption>
                                    <h3>'.$v["talky_title"].'</h3>
                                    <span class="writer">'.$v["author"].'</span>
                                </figcaption>
                            </a>
                        </figure>
                    </div>
                </li>';
            }
        }
        $html.='<li class="grid-sizer"></li>';
        return $html;

    }
    public function insert_comment($post){
        $this->db->set('comment_title', $post['comment']);
        $this->db->set('customer_id', $post['author']);
        $this->db->set('talky_id', $post['id']);
        $res = $this->db->insert('talky_comment');
    }

    public function get_user($id){
        $this->db->select("*");
        $this->db->from("member");
        $this->db->where("memberIdx ",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0];
    }

    public function get_comments($id){
        $this->db->select("*");
        $this->db->from("talky_comment");
        $this->db->where("talky_id ",$id);
        $res=$this->db->get();
        //$result=$res->result_array();
        //return $result;

        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $sch['author_data']=$this->get_user($sch['customer_id']);
            array_push($result,$sch);
        }
        return $result;
    }
    public function get_comment($id){
        $this->db->select("*");
        $this->db->from("talky_comment");
        $this->db->where("id ",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result;
    }

    public function edit_tag($data){
        $this->db->set('title', $data['title']);
        if($data['logo']!="") {
            $this->db->set('logo', $data['logo']);
        }
        if($data['isDisplay']!=""){
            $this->db->set('active', $data['isDisplay']);
        }else{
            $this->db->set('active', "off");
        }
        if($data['id']!="") {
            $this->db->where("id",$data['id']);
            $res = $this->db->update('talky_tags');
        }else{
            $res = $this->db->insert('talky_tags');
        }
    }
}
?>