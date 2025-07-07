<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;

class produkkategori extends BaseController
{
    
    public function index()
    {
        $model = new ProductCategoryModel();
        $data['categories'] = $model->findAll();
        return view('kategori_produk', $data);
    }

    public function store()
    {
        $model = new ProductCategoryModel();
        $model->save([
            'nama' => $this->request->getPost('nama'),
        ]);
        return redirect()->to('/produkkategori');
    }

    public function edit($id)
    {
        $model = new ProductCategoryModel();
        $data['categories'] = $model->findAll();
        $data['edit'] = $model->find($id);
        return view('kategori_produk', $data);
    }

    public function update($id)
    {
        $model = new ProductCategoryModel();
        $model->update($id, [
            'nama' => $this->request->getPost('nama'),
        ]);
        return redirect()->to('/produkkategori');
    }

    public function delete($id)
    {
        $model = new ProductCategoryModel();
        $model->delete($id);
        return redirect()->to('/produkkategori');
    }
}