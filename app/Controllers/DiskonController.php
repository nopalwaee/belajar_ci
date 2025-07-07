<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
        helper(['form', 'number']);
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');
        $query = $this->diskonModel;

        if ($keyword) {
            $query = $query->like('tanggal', $keyword)->orLike('nominal', $keyword);
        }

        $data['diskon'] = $query->orderBy('tanggal', 'ASC')->paginate(5);
        $data['pager'] = $this->diskonModel->pager;
        $data['keyword'] = $keyword;

        // ✅ Update session diskon aktif untuk hari ini
        $today = date('Y-m-d');
        $diskonAktif = $this->diskonModel->where('tanggal', $today)->first();
        if ($diskonAktif) {
            session()->set('diskon_nominal', $diskonAktif['nominal']);
            session()->set('diskon_aktif', $diskonAktif['nominal']); 
        } else {
            session()->remove('diskon_nominal');
            session()->remove('diskon_aktif'); 

        }

        return view('v_diskon', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/');

        $data['mode'] = 'create';
        $data['diskon'] = $this->diskonModel->findAll();
        return view('v_diskon', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'tanggal' => 'required|is_unique[diskon.tanggal]',
            'nominal' => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $tanggal = $this->request->getPost('tanggal');
        $nominal = str_replace('.', '', $this->request->getPost('nominal'));

        $this->diskonModel->save([
            'tanggal' => $tanggal,
            'nominal' => $nominal
        ]);

        // ✅ Jika diskon untuk hari ini, simpan ke session diskon_nominal
        if ($tanggal == date('Y-m-d')) {
            session()->set('diskon_nominal', $nominal);
        }

        return redirect()->to('/diskon')->with('redirect_success', 'Data berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (!$this->validate([
            'nominal' => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $nominal = str_replace('.', '', $this->request->getPost('nominal'));

        $diskon = $this->diskonModel->find($id);

        $this->diskonModel->update($id, ['nominal' => $nominal]);

        // ✅ Jika diskon ini adalah untuk hari ini, update session juga
        if ($diskon && $diskon['tanggal'] == date('Y-m-d')) {
            session()->set('diskon_nominal', $nominal);
        }

        return redirect()->to('/diskon')->with('redirect_success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $diskon = $this->diskonModel->find($id);

        $this->diskonModel->delete($id);

        // ✅ Jika diskon yang dihapus adalah diskon hari ini, hapus dari session
        if ($diskon && $diskon['tanggal'] == date('Y-m-d')) {
            session()->remove('diskon_nominal');
        }

        return redirect()->to('/diskon')->with('redirect_success', 'Data berhasil dihapus.');
    }
}