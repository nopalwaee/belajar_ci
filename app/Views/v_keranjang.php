<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php echo form_open('keranjang/edit') ?>

<table class="table datatable text-center align-middle">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Foto</th>
            <th>Harga Asli</th>
            <th>Diskon</th>
            <th>Harga Setelah Diskon</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (!empty($items)):
            foreach ($items as $index => $item):
                $hargaAsli = $item['options']['harga_asli'] ?? $item['price'];
                $diskon = $item['options']['diskon'] ?? 0;
                $hargaDiskon = $item['price'];
        ?>
                <tr>
                    <td><?= esc($item['name']) ?></td>
                    <td>
                        <img src="<?= base_url("img/" . $item['options']['foto']) ?>" width="100px">
                    </td>
                    <td><?= number_to_currency($hargaAsli, 'IDR') ?></td>
                    <td><?= number_to_currency($diskon, 'IDR') ?></td>
                    <td><strong><?= number_to_currency($hargaDiskon, 'IDR') ?></strong></td>
                    <td>
                        <input type="number" min="1" name="qty<?= $i++ ?>" class="form-control text-center" value="<?= $item['qty'] ?>">
                    </td>
                    <td><?= number_to_currency($item['subtotal'], 'IDR') ?></td>
                    <td>
                        <a href="<?= base_url('keranjang/delete/' . $item['rowid']) ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
        <?php
            endforeach;
        endif;
        ?>
    </tbody>
</table>

<div class="alert alert-info">
    <?= "Total = " . number_to_currency($total, 'IDR') ?>
</div>

<button type="submit" class="btn btn-primary">Perbarui Keranjang</button>
<a class="btn btn-warning" href="<?= base_url('keranjang/clear') ?>">Kosongkan Keranjang</a>

<?php if (!empty($items)): ?>
    <a class="btn btn-success" href="<?= base_url('checkout') ?>">Selesai Belanja</a>
<?php endif; ?>

<?php echo form_close() ?>
<?= $this->endSection() ?>
