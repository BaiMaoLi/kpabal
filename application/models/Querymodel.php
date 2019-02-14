<?php   
defined('BASEPATH') OR exit('No direct script access allowed');
class QueryModel extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    
  public function youtubu_news(){
       $playlist = array();
       $data = array();
       $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';    
////////**********Get the news_name_list*********//////////// 
        $this->db->select('news_id,news_name,news_channelID');
        $this->db->from('news');
        $temp1 =  $this->db->get();
        //print_r($temp->result_array());exit();
        $temp =array();
        $count = 0;

        foreach ($temp1->result_array() as $one) {
           if (!empty($one['news_channelID'])){
            $temp[$count] = $one;
            $count++;
           }
        }

        //$this->db->select('news_id,news_channelID');
        //$this->db->from('news');
        //$temp =  $this->db->get();
        $channelID_list = $temp;
        $playlist_item_maxcount = 2;
        $videolist_item_maxcount = 2;
  
       if(!empty($channelID_list)){        
            foreach ($channelID_list as $channel_ID) {
              
               $api_url = 'https://www.googleapis.com/youtube/v3/playlists?order=date&part=snippet%2CcontentDetails&channelId='.$channel_ID['news_channelID'].'&maxResults='.$playlist_item_maxcount.'&key='.$api_key;
                $playlist = json_decode(file_get_contents($api_url),true);
                if (!empty($playlist)) { 
                   foreach ($playlist['items'] as $listitem) {
                        $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$videolist_item_maxcount.'&order=date&playlistId='.$listitem['id'].'&key='.$api_key;
                        $data['videolist'] = json_decode(file_get_contents($api_url),true);
                        if(!empty($data)) {
                            foreach ($data['videolist']['items'] as $videoitem){

                                $videoid = $videoitem['snippet']['resourceId']['videoId'];
                                $title = $videoitem['snippet']['title'];
                                $image = $videoitem['snippet']['thumbnails']['medium']['url'];
                                $duration = "45:06";
                                $create_date = $videoitem['snippet']['publishedAt'];
                                $api_type = 'Y';
                                $video_url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoid.'&key='.$api_key;
                                $one_videoinfo = json_decode(file_get_contents($video_url),true);
                                foreach ($one_videoinfo['items'] as $item) {
                                    $likes = $item['statistics']['likeCount'];
                                }
                                //print_r($likes);exit();
                                //$insert_video_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration, 'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$videoid, 'likes'=>$likes, 'news_id'=> $channel_ID['news_id'], 'playlistid' => $listitem['id']);
                                //$id = $this->insert('Inforamtion',$insert_video_data, true);
                                print_r($insert_video_data);    
                                if($id > 0) {
                                    echo "success\n";
                                }else {
                                    echo "faild";
                                }
                                //print_r($videoitem['snippet']['title'];
                                //print_r("////");
                            }
                        } else {
                            echo "empty data";
                        }

                   }
                }  
           }
        }else {
            echo "not exist chnnel database";
        }   
    } 

    public function youtubu_movie() {

        $data = array();
        $movie = array();
        $this->db->select('country_name');
        $this->db->from('country');
        $temp =  $this->db->get();
        //print_r($temp->result_array());exit();
        foreach ($temp->result_array() as $country) {
            $this->db->select('vid,video_channelID');
            $this->db->from('video');
            $this->db->where('country_name',$country['country_name']);
            $temp =  $this->db->get();
            $channelID_list[$country['country_name']] = $temp->result_array();
        }
            //print_r($channelID_list);exit();
            $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
            $playlist = array();
            $playlist_item_maxcount = 2;
            $videolist_item_maxcount = 2;
            if(!empty($channelID_list)) {
                foreach ($channelID_list as $one) {
                    foreach ($one as $channel_ID) {
                        $api_url = 'https://www.googleapis.com/youtube/v3/playlists?order=date&part=snippet%2CcontentDetails&channelId='.$channel_ID['video_channelID'].'&maxResults='.$playlist_item_maxcount.'&key='.$api_key;
                        $playlist = json_decode(file_get_contents($api_url),true);
                        if(!empty($playlist)) {
                            foreach ($playlist['items'] as $listitem) {
                                $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$videolist_item_maxcount.'&order=date&playlistId='.$listitem['id'].'&key='.$api_key;
                                $data['videolist'] = json_decode(file_get_contents($api_url),true);
                                if(!empty($data)) {
                                    foreach ($data['videolist']['items'] as $videoitem) {
                                        $videoid = $videoitem['snippet']['resourceId']['videoId'];
                                        $title = $videoitem['snippet']['title'];
                                        $image = $videoitem['snippet']['thumbnails']['medium']['url'];
                                        $duration = "45:06";
                                //print_r(expression)
                                        $create_date = $videoitem['snippet']['publishedAt'];
                                        $api_type = 'Y';
                                        $video_url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoid.'&key='.$api_key;
                                        $one_videoinfo = json_decode(file_get_contents($video_url),true);

                                        foreach ($one_videoinfo['items'] as $item) {
                                            $likes = $item['statistics']['likeCount'];
                                        }
                                        $insert_video_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration,
                                                           'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$videoid,
                                                           'likes'=>$likes, 'vid'=> $channel_ID['vid'], 'playlistid' => $listitem['id']);
                                        $id = $this->insert('inforamtion',$insert_video_data, true);
                                        if($id > 0) {
                                            echo "success";
                                        }else {
                                            echo "faild";
                                        }
                                    }
                                }

                            }

                        }
                    }
                }

            } 
    }


public function getyoutubu_newsfromdb() {

        $this->db->select('news_id,news_name,news_channelID');
        $this->db->from('news');
        $temp1 =  $this->db->get();
          //$strsql = "select news_id,news_name,news_channelID  from news" ;
          //$temp1 = $this->db->query($strsql)->result_array();
        //$result = $temp1 ? $temp1->result_array() : FALSE;
        //$result = $query->result();
        //print_r($temp1);exit();
        $temp =array();
        $count = 0;
        foreach ($temp1->result_array() as $one) {
           if (!empty($one['news_channelID'])){
            $temp[$count] = $one;
            $count++;
           }
        }
        //print_r($temp);exit();
        $result = array();
        if(!empty($temp)) {

            foreach ($temp as $one) {
                //print_r($one['news_id']);exit();
                $this->db->select('*');
                $this->db->where('news_id', $one['news_id']);
                $this->db->where('api_type', 'Y');
                $this->db->from('Inforamtion');
                $query =  $this->db->get();
                //$strsql = "select *  from Inforamtion where api_type = 'Y' and news_id = ".$one['news_id'] ;
                //$query = $this->db->query($strsql)->result_array();
                //$query = $this->db->get_where('Information', ["memberIdx" => $memberIdx, "articleIdx" => $articleIdx])->result();
                
                $result[$one['news_name']] = $query->result_array(); 
                
            }

        }else {
            echo "no exist data";
        }
        print_r($result);exit();
        return $result;
}
public function getyoutubu_dramafromdb() {
print_r("youtube");exit();
        $this->db->select('country_name');
        $this->db->from('country');
        $temp =  $this->db->get();
        //$strsql = "select country_name  from country" ;
        //$temp = $this->db->query($strsql)->result_array();
        print_r($temp);exit();
        $result = array();
        $results = array();
        $temp1 = array();
        if(!empty($temp->result_array())) {

            foreach ($temp->result_array() as $one) {
                //print_r($one);
                $this->db->select('vid,country_name');
                $this->db->where('country_name', $one['country_name']);
                $this->db->from('video');
                $query =  $this->db->get();
                //$strsql = "select vid,country_name  from video where  country_name = ".$one['country_name'];
                //$query = $this->db->query($strsql)->result_array();
                $result[$one['country_name']] = $query->result_array(); 
                //print_r($result)
            }
            //print_r($result);exit();
            
            foreach ($result as $country) {
                $count = 0;
                foreach ($country as $one) {

                    $this->db->select('*');
                    $this->db->where('vid', $one['vid']);
                    $this->db->where('api_type', 'Y');
                    $this->db->from('Inforamtion');
                    $query =  $this->db->get();
                    //$strsql = "select *  from Inforamtion where api_type = 'Y' and vid = ".$one['vid'];
                    foreach ( $query->result_array() as $onevideo ) {
                        $count++;
                        $temp1[$count] = $onevideo; 
                    }
                   
                }

                $results[$one['country_name']] = $temp1;
                $temp1 = array();    
            }
           //print_r($results);  exit();
        }else {
            echo "no exist data";
        }       
            print_r($results);exit();
             return $results;

}


public function getplaylist($video) {

       $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
       $playlist = array();
       $result = array();
       $videolist_item_maxcount = 20;
       $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$videolist_item_maxcount.'&order=date&playlistId='.$video['playlistid'].'&key='.$api_key;
       $data['videolist'] = json_decode(file_get_contents($api_url),true);
       if(!empty($data)) {
                $count = 0;
                foreach ($data['videolist']['items'] as $videoitem){

                    $videoid = $videoitem['snippet']['resourceId']['videoId'];
                    $title = $videoitem['snippet']['title'];
                     $image = $videoitem['snippet']['thumbnails']['medium']['url'];
                    $duration = "45:06";
                                //print_r(expression)
                    $create_date = $videoitem['snippet']['publishedAt'];
                    $api_type = 'Y';
                    $video_url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoid.'&key='.$api_key;
                    $one_videoinfo = json_decode(file_get_contents($video_url),true);

                    foreach ($one_videoinfo['items'] as $item) {
                        $likes = $item['statistics']['likeCount'];
                    }
                                //print_r($likes);exit();
                    $video_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration,
                                                           'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$videoid,
                                                           'likes'=>$likes);
                    
                    $result[$count] = $video_data;
                    $count++;
                                //print_r($videoitem['snippet']['title'];
                                //print_r("////");
                }
                $playlist = $result;
             }
             //print_r($playlist);exit(); 
    return $playlist;

}

public function getrelatedlist($video){

       $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
       $playlist = array();
       $result = array();
       $videolist_item_maxcount = 10;
       $api_url = 'https://www.googleapis.com/youtube/v3/search/?type=video&relatedToVideoId='.$video['video_id'].'&part=snippet&key='.$api_key;
       $data['videolist'] = json_decode(file_get_contents($api_url),true);
       if(!empty($data)) {
                $count = 0;
                foreach ($data['videolist']['items'] as $videoitem){

                    $videoid = $videoitem['id']['videoId'];
                    $title = $videoitem['snippet']['title'];
                     $image = $videoitem['snippet']['thumbnails']['medium']['url'];
                    $duration = "45:06";
                                //print_r(expression)
                    $create_date = $videoitem['snippet']['publishedAt'];
                    $api_type = 'Y';
                    $video_url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoid.'&key='.$api_key;
                    $one_videoinfo = json_decode(file_get_contents($video_url),true);

                    foreach ($one_videoinfo['items'] as $item) {
                        $likes = $item['statistics']['likeCount'];
                    }
                                //print_r($likes);exit();
                    $video_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration,
                                                           'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$videoid,
                                                           'likes'=>$likes);
                    
                    $result[$count] = $video_data;
                    $count++;
                                //print_r($videoitem['snippet']['title'];
                                //print_r("////");
                }
                $playlist = $result;
             }
             //print_r($playlist);exit(); 
    return $playlist;

}

public function dailymotion_news()
    {

        $limit = 2;
        $this->db->select('news_id,news_name,daily_userID');
        $this->db->from('news');
        $temp1 =  $this->db->get();
        //print_r($temp->result_array());exit();
        $userIDs =array();
        $count = 0;

        foreach ($temp1->result_array() as $one) {
           if (!empty($one['daily_userID'])){
            $userIDs[$count] = $one;
            $count++;
           }
        }

        foreach ($userIDs as $user_ID) {
           
        
            $api_url = 'https://api.dailymotion.com/user/'.$user_ID['daily_userID'].'/videos?fields=created_time,duration,id,likes_total,thumbnail_240_url,owner,title,&sort=recent&limit='.$limit;
            $playlist = json_decode(file_get_contents($api_url),true);
           // print_r($playlist);exit();
            if (!empty($playlist['list'])) { 
                   
                foreach ($playlist['list'] as $newsitem){

                    $newsid = $newsitem['id'];
                    $title = $newsitem['title'];
                    $image = $newsitem['thumbnail_240_url'];
                    $duration = $newsitem['duration'];
                    $create_date = $newsitem['created_time'];
                    $api_type = 'D';
                    $likes = $newsitem['likes_total'];
                                //print_r($likes);exit();
                    $insert_video_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration, 'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$newsid, 'likes'=>$likes, 'news_id'=> $user_ID['news_id'], 'playlistid' => 'playlists');
                                $id = $this->insert('Inforamtion',$insert_video_data, true);
                    //print_r($insert_video_data);            
                }

                if(id > 0) {
                    echo "success";
                } else {
                    echo "faild";
                }
            } else {
                 echo "empty data";
            }

                   
            
        }            
        
    }

public function dailymotion_movie()
{

        $limit = 2;
        $userIDs =array();
        $count = 0;
        $this->db->select('country_name');
        $this->db->from('country');
        $countrys =  $this->db->get();
        foreach ($countrys->result_array() as $country) { 
           $api_url = 'https://api.dailymotion.com/videos?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&channel=tv&languages='.$country['country_name'].'&longer_than=30&sort=recent&page=1&limit='.$limit;
            $playlist = json_decode(file_get_contents($api_url),true);
           // print_r($playlist);exit();
            if (!empty($playlist['list'])) { 
                   
                foreach ($playlist['list'] as $newsitem){

                    $newsid = $newsitem['id'];
                    $title = $newsitem['title'];
                    $image = $newsitem['thumbnail_240_url'];
                    $duration = $newsitem['duration'];
                    $create_date = $newsitem['created_time'];
                    $api_type = 'D';
                    $likes = $newsitem['likes_total'];
                                //print_r($likes);exit();
                    $insert_video_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration, 'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$newsid, 'likes'=>$likes, 'news_id'=> $user_ID['news_id'], 'playlistid' => 'playlists','country_name' => $country['country_name']);
                    $id = $this->insert('Inforamtion',$insert_video_data, true);
                    //print_r($insert_video_data);            
                }

            } else {
                 echo "empty data";
            }

        }

}

public function getdailymotion_relatedlist($videoinfo) {

    $limit = 10;
    $count = 0;
    $result = array();
    $api_url = 'https://api.dailymotion.com/video/'.$videoinfo['video_id'].'/related?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&limit='.$limit;
    $relatedlist = json_decode(file_get_contents($api_url),true);
            if (!empty($relatedlist['list'])) { 
                   
                foreach ($relatedlist['list'] as $oneitem){

                    $newsid = $oneitem['id'];
                    $title = $oneitem['title'];
                    $image = $oneitem['thumbnail_240_url'];
                    $duration = $oneitem['duration'];
                    $create_date = $oneitem['created_time'];
                    $api_type = 'D';
                    $likes = $oneitem['likes_total'];
                                //print_r($likes);exit();
                    $related_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration, 'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$newsid, 'likes'=>$likes);
                    $result[$count] = $related_data;
                    $count++;
                               
                }

            } else {
                 echo "empty data";
            }
            //print_r($result); 
            return $result;
}

public function getdailymotion_playlist($videoinfo) {

    $limit = 10;
    $count = 0;
    $result = array();
    $api_url = 'https://api.dailymotion.com/video/'.$videoinfo['video_id'].'/related?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&limit='.$limit;
    $relatedlist = json_decode(file_get_contents($api_url),true);
            if (!empty($relatedlist['list'])) { 
                   
                foreach ($relatedlist['list'] as $oneitem){

                    $newsid = $oneitem['id'];
                    $title = $oneitem['title'];
                    $image = $oneitem['thumbnail_240_url'];
                    $duration = $oneitem['duration'];
                    $create_date = $oneitem['created_time'];
                    $api_type = 'D';
                    $likes = $oneitem['likes_total'];
                                //print_r($likes);exit();
                    $related_data = array('title'=>$title, 'image'=>$image, 'duration'=>$duration, 'create_date'=>$create_date, 'api_type'=>$api_type, 'video_id'=>$newsid, 'likes'=>$likes);
                    $result[$count] = $related_data;
                    $count++;
                               
                }

            } else {
                 echo "empty data";
            }
            //print_r($result);
            return $result; 

}

public function getdailymotion_newsfromdb(){
print_r("youtube");
    $this->db->select('news_id,news_name,news_channelID');
        $this->db->from('news');
        $temp1 =  $this->db->get();
        //print_r($temp->result_array());exit();
        $temp =array();
        $count = 0;

        foreach ($temp1->result_array() as $one) {
           if (!empty($one['news_channelID'])){
            $temp[$count] = $one;
            $count++;
           }
        }
        $result = array();
        if(!empty($temp)) {

            foreach ($temp as $one) {
                $this->db->select('*');
                $this->db->where('news_id', $one['news_id']);
                $this->db->where('api_type', 'D');
                $this->db->from('Inforamtion');
                $query =  $this->db->get();
                $result[$one['news_name']] = $query->result_array(); 
                
            }

        }else {
            echo "no exist data";
        }
        //print_r($result);exit();
        return $result;
}

public function getdailymotion_dramafromdb() {
print_r("youtube");
    $this->db->select('country_name');
        $this->db->from('country');
        $temp1 =  $this->db->get();
        $temp = $temp1->result_array();
        $result = array();
        if(!empty($temp)) {

            foreach ($temp as $one) {
                $this->db->select('*');
                $this->db->where('country_name', $one['country_name']);
                $this->db->where('api_type', 'D');
                $this->db->from('Inforamtion');
                $query =  $this->db->get();
                $result[$one['country_name']] = $query->result_array(); 
                
            }

        }else {
            echo "no exist data";
        }
        //print_r($result);exit();
        return $result;

} 
}
