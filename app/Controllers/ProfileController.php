<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
  
class ProfileController extends Controller
{
    public function index()
    {
        $session = session();
        // echo "Hello : ".$session->get('name');
        echo view('layout/header');
        echo view('dashboard/main');
        echo view('layout/footer');
    }
}