<?php
/**
 * Autor: Bogiceic Milan 0284/2020
 */
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $sesija=session();
        
        if(!$sesija->has("user") || ($sesija->has("user") && $sesija->get('user')['type']!='A') ){
            return redirect()->to(site_url("Login"));
        }
            
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
