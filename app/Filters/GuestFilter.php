<?php 
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class GuestFilter implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		$session = Services::session();
		$user = $session->has('user') ? $session->get('user') : false;
		if($user){
			$session->setFlashdata('successMsg','You Are Already LoggedIn..!!');
			return redirect('user');
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{

	}

	
}

?>