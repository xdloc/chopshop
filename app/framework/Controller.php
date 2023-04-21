<?php
declare(strict_types=1);


namespace App\Framework;

/**
 * Trait Controller
 * @package App\Framework
 */
trait Controller
{

    public function view($name, $data = []): void
    {
        if (!empty($data)) {
            extract($data);
        }

        $filename = "../app/views/".$name.".view.php";
        if (file_exists($filename)) {
            require $filename;
        } else {

            $filename = "../app/views/404.view.php";
            require $filename;
        }
    }
}