<?php

class Facebook_connect extends CI_Controller {

	// beberapa detail aplikasi kita
	// ini semua harus diisi.
	var $fb_appid = APPID;
	var $fb_secret = SECRET;
	var $fb_api = APPID;
	
	function __construct()
	{
		parent::__construct();	
		$this->load->helper("url");
	}
	
	function index() {
		$data['app_id'] = $this->fb_appid;
		
		$this->load->view('facebook', $data);
	}
	
	function fb() {
		$this->load->library("curl");
		// method untuk redirect balik dari facebook
		// setelah pemanggilan pertama, facebook mengirimkan sebuah kode 
		// yang bisa kita tangkap lewat $_GET['code']
		
		// cek dulu, apa $_GET['code'] ada
		if(isset($_GET['code'])) {
			// buat url untuk mengambil token
			$url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->fb_appid.'&redirect_uri='.site_url("/facebook_connect/fb").'&client_secret='.$this->fb_secret.'&code='.$_GET['code'];
						
			// ambil token lewat curl
			$token_data = $this->curl->simple_get($url);
			
			// ambil kode token saja, dengan regular expression
			// arti tanda ([^&]+) adalah:
			// ambil semua karakter asal bukan tanda &
			preg_match("/access_token=([^&]+)/",$token_data,$token);

			// kode token ada di variabel token[1]
			$access_token = $token[1];
			
			// pengambilan token selesai, sekarang ambil userid, nama
			$uri = 'https://graph.facebook.com/me?access_token='.$access_token;
			$data = $this->curl->simple_get($uri);
			
			// decode data
			$fb = json_decode($data);
			/*
			echo "<pre>";
			print_r($fb);
			echo "</pre>";
			die();
			*/
			$fb_id = $fb->id;
			
			// ambil nama dan foto pengguna
			$fb_userdata = $this->curl->simple_get("https://graph.facebook.com/".$fb_id."?fields=name,picture&access_token=".$access_token);
			
			//echo "https://graph.facebook.com/".$fb_id."?fields=name,picture&access_token=".$access_token;
			
			$fb_user = json_decode($fb_userdata);
			//print_r($fb_user);
			//die();
			
			$data = array();
			$data['fbuser'] = array('id'=>$fb_id, 'avatar'=> $fb_user->picture->data->url, 'nama'=> $fb_user->name);
			
			// print_r($data);
			//die();
			
		}
		elseif(isset($_GET['error_reason'])) {
			// untuk menangkap user yang klik "Dont Allow" atau "Cancel di Facebook"
			// buat variabel untuk ditampilkan di view
			$data['tolak'] = "Uh oh, saya ditolak T_T";
		}
		
		$this->load->view("facebook",$data);
	}
}
?>