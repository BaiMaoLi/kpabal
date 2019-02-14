<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_model extends CI_Model {
    var $tbl_name = "tbl_news";
    var $tbl_category_name = "tbl_news_category";

    public function get_news_for_landing()
    {
        $strsql = sprintf("select categoryIdx from %s where isDisplay=1 order by orderNum", $this->tbl_category_name);
        $categories = $this->db->query($strsql)->result();

        $ret = new \stdClass();
        $category_news = [];
        $total_count = 0;
        foreach ($categories as $category) {
            $categoryIdx = $category->categoryIdx;

            $strsql = sprintf("select a.*, b.categoryCode, b.categoryName from %s a inner join %s b on a.categoryIdx = b.categoryIdx where a.categoryIdx = '$categoryIdx' order by a.admin_pre_order_chk desc, a.admin_pre_order desc, a.published desc, a.id desc limit %s", $this->tbl_name, $this->tbl_category_name, 10);
            $result = $this->db->query($strsql)->result();
            for($i=0; $i<count($result); $i++) {
                $categoryIdx = $result[$i]->categoryIdx;
                if(isset($category_news[$categoryIdx])) $category_news[$categoryIdx][] = $result[$i];
                else $category_news[$categoryIdx] = [$result[$i]];
                $total_count++;
            }
        }

        $featured = [];
        $min_limit = 7;
        if($min_limit > $total_count) $min_limit = $total_count;
        $min_limit = $min_limit - (($min_limit + 2) % 3);

        while(count($featured) < $min_limit){
            foreach ($category_news as $categoryIdx => $news) {
                if(count($featured) >= $min_limit) break;
                if(count($news) == 0) break;
                $featured[] = $news[0];
                array_splice($category_news[$categoryIdx], 0, 1);
            }
        }

        $ret->category_news = $category_news;

        // $ret->main = $featured[0];
        // array_splice($featured, 0, 1);
        $ret->featured = $featured;

        return $ret;
    }

    public function get_news_for_category($categoryIdx, $offset = 12)
    {
        $strsql = sprintf("select a.*, b.categoryCode, b.categoryName from %s a inner join %s b on a.categoryIdx = b.categoryIdx where a.categoryIdx = '$categoryIdx' order by a.admin_pre_order_chk desc, a.admin_pre_order desc, a.published desc, a.id desc limit %s", $this->tbl_name, $this->tbl_category_name, $offset);
        $result = $this->db->query($strsql)->result();

        if(count($result) == 0) return false;

        $ret = new \stdClass();

        // $ret->main = $result[0];
        // array_splice($result, 0, 1);
        $ret->featured = $result;

        return $ret;        
    }

    public function get_page_news_for_category($categoryIdx, $page_num=1, $offset = 12)
    {
        $strsql = sprintf("select a.*, b.categoryCode from %s a inner join %s b on a.categoryIdx = b.categoryIdx where a.categoryIdx = '$categoryIdx' order by a.admin_pre_order_chk desc, a.admin_pre_order desc, a.published desc, a.id desc limit %s, %s", $this->tbl_name, $this->tbl_category_name, $offset * $page_num, $offset);
        $result = $this->db->query($strsql)->result();

        return $result;
    }

    public function get_total_news_for_category($categoryIdx)
    {
        $strsql = sprintf("select count(*) cn from %s where categoryIdx = '$categoryIdx'", $this->tbl_name);
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function getCategoryIdx($category)
    {
        $strsql = sprintf("select categoryIdx from %s where INSTR(categoryCode, '$category') = 1", $this->tbl_category_name);
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->categoryIdx;
        return false;
    }

    public function register_news($scrape_source = "webhose", $categoryIdx, $post)
    {
        if($scrape_source == "webhose") {
            $main_image = $post->thread->main_image;
		
            if($main_image) {
                $main_image = str_replace("?type=w400", "", $main_image);
                $image_data = @file_get_contents($main_image);
                if($image_data) {
                    $uuid = $post->uuid;
                    $strsql = sprintf("select count(*) cn from %s where uuid='$uuid'", $this->tbl_name);
                    $result = $this->db->query($strsql)->result();
                    if(count($result) && ($result[0]->cn)) return false;
                    
                    $published = $post->published;
                    $published = str_replace("T", " ", $published);
                    $published = substr($published, 0, 19);
                    $news = array(
                            'categoryIdx'       => $categoryIdx,
                            'article_title'     => $post->title,
                            'article_content'   => $post->text,
                            'article_source'    => $post->thread->site,
                            'article_author'    => $post->author,
                            'article_link'      => $post->url,
                            'scrape_source'     => $scrape_source,
                            'uuid'              => $post->uuid,
                            'categoryInfo'      => json_encode($post->thread->site_categories),
                            'replies_count'     => $post->thread->replies_count,
                            'participants_count'=> $post->thread->participants_count,
                            'rating'            => (is_null($post->rating)?'':$post->rating),
                            'published'         => $published,
                        );
                    $this->db->insert("news", $news);
                    $news_id = $this->db->insert_id();
                    $filename = PROJECT_MEDIA_DIR."/news_".$news_id.".jpg";
                    @file_put_contents($filename, $image_data);
                }
            }
        } else if($scrape_source == "newsapi") {
            $main_image = $post->urlToImage;
            if($main_image) {
                $image_data = @file_get_contents($main_image);
                if($image_data) {
                    $article_link = $post->url;
                    $strsql = "select count(*) cn from ".$this->tbl_name." where article_link='".$article_link."'";
                    $result = $this->db->query($strsql)->result();
                    if(count($result) && ($result[0]->cn)) return false;
                    
                    $published = $post->publishedAt;
                    $published = str_replace("T", " ", $published);
                    $published = substr($published, 0, 19);
                    $news = array(
                            'categoryIdx'       => $categoryIdx,
                            'article_title'     => $post->title,
                            'article_content'   => $post->description,
                            'article_source'    => $post->source->name,
                            'article_author'    => (is_null($post->author)?'':$post->author),
                            'article_link'      => $post->url,
                            'scrape_source'     => $scrape_source,
                            'published'         => $published,
                        );
                    $this->db->insert("news", $news);
                    $news_id = $this->db->insert_id();
                    $filename = PROJECT_MEDIA_DIR."/news_".$news_id.".jpg";
                    @file_put_contents($filename, $image_data);
                }
            }
        } else if($scrape_source == "yonhapnews") {
          	if($post->image!=''){
			
            $main_image = 'https://img2.yna.co.kr'.$post->image;	
			}else{
				
            $main_image = 'https://www.kpabal.com/placeholder.jpg';
			}
		
            if($main_image) {
                $image_data = @file_get_contents($main_image);
				
                if($image_data) {
					//echo 'hello';
                    $article_link = $post->link;
					//echo $post->title.'<br>';
                    $strsql = "select count(*) cn from ".$this->tbl_name." where article_link='".$article_link."'";
					//echo $article_link;
                    $result = $this->db->query($strsql)->result();
					
                    if($result[0]->cn>0){ return false;}
                    else{
                    $published = date("Y-m-d H:i:s");
                    $news = array(
                            'categoryIdx'       => $categoryIdx,
                            'article_title'     => $post->title,
                            'article_content'   => $post->content,
                            'article_source'    => "yonhapnews.co.kr",
                            'article_author'    => '',
                            'article_link'      => $post->link,
                            'scrape_source'     => $scrape_source,
                            'published'         => $published,
                        );
						
                    $this->db->insert("news", $news);
                    $news_id = $this->db->insert_id();
					echo $news_id;
                    $filename = PROJECT_MEDIA_DIR."/news_".$news_id.".jpg";
                    @file_put_contents($filename, $image_data);
					}
                }
            }
        }

    }
}
