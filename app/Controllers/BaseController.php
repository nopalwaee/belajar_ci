<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\DiskonModel; // ✅ Tambahkan model diskon

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // ✅ Set diskon otomatis untuk semua user
        $today = date('Y-m-d');
        $diskonModel = new DiskonModel();
        $diskonAktif = $diskonModel->where('tanggal', $today)->first();

        if ($diskonAktif) {
            session()->set('diskon_nominal', $diskonAktif['nominal']);
            session()->set('diskon_aktif', $diskonAktif['nominal']);
        } else {
            session()->remove('diskon_nominal');
            session()->remove('diskon_aktif');
        }
    }
}
