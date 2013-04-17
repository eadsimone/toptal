<?php

include '../functions.php';

class Video {

    public $post = array();
    public $new = array();
    public $old = array();

    public function __construct()
    {
        foreach($_POST as $key=>$val) {
            $this->post[$key] = stripslashes(urldecode($val));
        }
        if (isset($this->post['videoGuid'])) {
            $old = $this->getVideo();
            $this->old = $old['responseObject'][0];
        }
        foreach($this->old as $key=>$old) {
            if (!is_array($old) && !is_object($old)) {
                $this->new[$key] = $old;
            }
        }
        $this->new['guid'] = $this->post['videoGuid'];
        $this->new['assetStatus'] = $this->post['isActive'];
        $this->new['title'] = $this->post['videoname'];
        $this->new['description'] = $this->post['videodescription'];

        $this->newImage(array("thumb", "poster"));

        if (count($this->old['videoStreams']) === 4) {
            $this->oldStream();
        }
        else {
            $this->new['videoStreams'] = array(array(
                "typeName"=> "native_video_stream",
                "id"=> null,
                "format"=> "original",
                "urlProgressiveDownload"=>$this->post['originalVideoUrl']
            ));
        }
    }

    public function getVideo() {
        return json_decode(ServicebusGetVideo( $_SESSION['SSMData']['clientGuid'], $this->post['videoGuid']), true);
    }

    public function oldStream() {

        foreach ($this->old['videoStreams'] as $key=>$stream) {
            $this->new['videoStreams'][$key] = $stream;
            if($stream['format'] === 'original') {
                $this->new['videoStreams'][$key]['urlProgressiveDownload'] = $this->post['originalVideoUrl'];
            } else {
                $this->new['videoStreams'][$key]['urlProgressiveDownload'] = '';
            }
            $this->new['videoStreams'][$key]['urlHttpLiveStream'] = '';
            $this->new['videoStreams'][$key]['urlRtmpStream'] = '';
        }
    }

    public function newImage($names = array()) {
        foreach($names as $name) {
            $key = $name."Image";
            $this->new[$key] = $this->old[$key];
            $this->new[$key]['typeName'] = 'image';
            $this->new[$key]['url'] = $this->post[$key.'Url'];
            $this->new[$key]['name'] = 'video'.$name;
            $this->new[$key]['id'] = $this->old[$key]['id'];
        }
    }

}

$video = new Video;

$orig_data = '{"apiKey":"{{publicKey}}","clientId":"'. $_SESSION['SSMData']['clientGuid'].'","requestObject":' . json_encode($video->new) .',"params":null}';
$sb_path = "/api/cms/videos/createorupdate";

$response = ServicebusRequest($sb_path, $orig_data);

echo $response;