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
        $produk = new UserData();
        $produk->nama_produk = $this->post('nama_produk');
        $produk->harga_produk = $this->post('harga_produk');
        $produk->stok_produk = $this->post('stok_produk');
        $produk->gambar_produk = $this->response_upload();
        $produk->stok_minimal_produk = $this->post('stok_minimal_produk');

        $produk->updated_date = date("Y-m-d H:i:s");
        $produk->deleted_date = date("0000:00:0:00:00");

        $response = $this->Produk_model->updateProduk($produk, $id);

        return $this->returnData($response['msg'], $response['error']);
    }

    public function response_upload()
    {
        $this->load->helper(array('form', 'url'));

        $config = array(
            'upload_path' => "upload/gambar_produk/",
            'allowed_types' => "gif|jpg|png|jpeg",
            'overwrite' => true,
            'encrypt_name' => true,
            'max_size' => "2048000",
            'max_height' => "3000",
            'max_width' => "3000",
        );
        
        if (!file_exists('upload/gambar_produk/')) {
            mkdir('upload/gambar_produk/', 0777, true);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('gambar_produk')) {
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            $file_name = $upload_data['file_name'];

            $dir_img = "upload/gambar_produk/" . $file_name;
            return $dir_img;
        } else {
            return 'upload/gambar_produk/default.jpg';
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