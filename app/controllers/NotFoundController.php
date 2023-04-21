<?php

namespace App\Controllers;

use App\Framework\Controller;

/**
 * Class NotFoundController
 */
class NotFoundController
{
	use Controller;
	
	public function index(): void
    {
		print '404';
	}
}
