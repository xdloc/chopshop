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
            extract($data, EXTR_OVERWRITE,"");
        }

        $filename = "../app/Views/".$name.".view.php";
        if (!file_exists($filename)) {
            $filename = "../app/Views/404.view.php";
        }
        //require '../app/Views/header.view.php';
        require $filename;
        //require '../app/Views/header.view.php';

    }
}