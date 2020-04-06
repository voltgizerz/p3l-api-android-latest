<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Update extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
    }

  

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $produk = new UserData();
        $produk->nama_produk = $this->post('nama_produk');
        $produk->harga_produk = $this->post('harga_produk');
        $produk->stok_produk = $this->post('stok_produk');
        $produk->gambar_produk = $this->response_upload($id);
        $produk->stok_minimal_produk = $this->post('stok_minimal_produk');

        $produk->updated_date = date("Y-m-d H:i:s");
        $produk->deleted_date = date("0000:00:0:00:00");

        $response = $this->Produk_model->updateProduk($produk, $id);

        return $this->returnData($response['msg'], $response['error']);
    }

    public function response_upload($id)
    {
        $part = "upload/gambar_produk/";
	    $filename = "img".rand(9,9999).".jpg";
	    
	    if (!file_exists('upload/gambar/')) {
            mkdir('upload/gambar/', 777, true);
        }
        
        if($this->Produk_model->cekGambar($id) != 1){
            unlink(FCPATH.$this->Produk_model->cekGambar($id));
        }
        
         
       if ($_FILES["gambar_produk"]["name"] != "") 
       {
          
            $destinationfile = $part.$filename;
			if(move_uploaded_file($_FILES['gambar_produk']['tmp_name'],  $destinationfile))
			{
                return $destinationfile;
			}else
			{
			    // gagal upload
			    return 'upload/gambar_produk/default.jpg' ;
			}

        } 
        else 
        {
            //FILE TIDAK ADA DI UPLOAD
            if($this->Produk_model->cekGambar($id) == 1){
                return 'upload/gambar_produk/default.jpg';
            }else{
                
                return $this->Produk_model->cekGambar($id);
            }
         ;
        }
    }


    public function returnData($msg, $error)
    {
        $response['error'] = $error;
        $response['message'] = $msg;
        return $this->response($response);
    }
}
class UserData
{
    public $nama_produk;
    public $harga_produk;
    public $stok_produk;
    public $stok_minimal_produk;
    public $gambar_produk;
    public $updated_date;
    public $deleted_date;
}