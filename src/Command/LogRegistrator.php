<?php


namespace App\Command;


use Symfony\Component\HttpKernel\KernelInterface;

class LogRegistrator
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function registerLog($message)
    {
        $folder = $this->kernel->getProjectDir() . '/Logs';
        $file = fopen($folder . '/logs.log', 'a');
        $date = new \DateTime();
        $datefr = $date->format('d-m-Y');
        $time = $date->format('H:i');
        $ip = $_SERVER['REMOTE_ADDR'];
        fwrite($file, "\r\n" . $ip . ' ' . $message . ' le ' . $datefr . ' à ' . $time);
        fclose($file);
    }

}
