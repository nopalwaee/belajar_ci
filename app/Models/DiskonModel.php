<?php

namespace App\Models;

use CodeIgniter\Model;

class DiskonModel extends Model
{
    protected $table            = 'diskon';         // nama tabel
    protected $primaryKey       = 'id';             // primary key
    protected $allowedFields    = ['tanggal', 'nominal', 'created_at', 'updated_at']; // field yg bisa diisi

    protected $useTimestamps    = true;             // otomatis isi created_at & updated_at
}