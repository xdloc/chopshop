<?php
declare(strict_types=1);

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
