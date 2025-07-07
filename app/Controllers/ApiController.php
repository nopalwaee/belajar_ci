<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class ApiController extends ResourceController
{
    protected $transaction;
    protected $transaction_detail;
    protected $apiKey;

    public function __construct()
    {
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
        $this->apiKey = getenv('API_KEY');
    }

    public function index()
    {
        // Default response untuk unauthorized
        $response = [
            'results' => [],
            'status'  => [
                'code'        => 401,
                'description' => 'Unauthorized',
            ],
        ];

        // Ambil API Key dari header
        $keyHeader = $this->request->getHeaderLine('Key');

        if (!$keyHeader) {
            $response['status']['description'] = 'API Key is missing.';
            return $this->respond($response);
        }

        if ($keyHeader !== $this->apiKey) {
            $response['status']['description'] = 'API Key is invalid.';
            return $this->respond($response);
        }

        // Jika API key valid, ambil semua transaksi
        $transactions = $this->transaction->findAll();

        foreach ($transactions as &$transaksi) {
            // Ambil semua detail transaksi untuk ID ini
            $details = $this->transaction_detail
                ->where('transaction_id', $transaksi['id'])
                ->findAll();

            // Hitung total item
            $totalQty = array_sum(array_column($details, 'jumlah'));

            // Tambahkan ke hasil
            $transaksi['jumlah_item'] = $totalQty;
            $transaksi['details']     = $details;
        }

        $response['results'] = $transactions;
        $response['status'] = [
            'code'        => 200,
            'description' => 'OK',
        ];

        return $this->respond($response);
    }

    // Metode tidak digunakan
    public function show($id = null) {}
    public function new() {}
    public function create() {}
    public function edit($id = null) {}
    public function update($id = null) {}
    public function delete($id = null) {}
}
