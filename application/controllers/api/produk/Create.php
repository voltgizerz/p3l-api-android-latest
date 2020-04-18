<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Create extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Produk_model', 'produk');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'nama_produk' => $this->post('nama_produk'),
            'harga_produk' => $this->post('harga_produk'),
            'stok_produk' => $this->post('stok_produk'),
            'gambar_produk' => $this->response_upload(),
            'gambar_produk_desktop' => $_FILES["gambar_produk"]["name"],
            'stok_minimal_produk' => $this->post('stok_minimal_produk'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
        if ($this->produk->createProduk($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES Produk BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN Produk BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function response_upload()
    {
        $part = "upload/gambar_produk/";
	    $filename = "img".rand(9,9999).".jpg";
	    
	    if (!file_exists('upload/gambar/')) {
            mkdir('upload/gambar/', 777, true);
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
            //file upload tidak ada
           return 'upload/gambar_produk/default.jpg' ;
        }
    }
}