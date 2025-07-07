<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h4>History Transaksi Pembelian <strong><?= esc($username) ?></strong></h4>
<hr>

<div class="table-responsive">
    <table class="table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pembelian</th>
                <th>Waktu</th>
                <th>Total Bayar</th>
                <th>Ongkir</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($buy)) : ?>
                <?php foreach ($buy as $index => $item) : ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= esc($item['id']) ?></td>
                        <td><?= esc($item['created_at']) ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= number_to_currency($item['ongkir'], 'IDR') ?></td>
                        <td><?= esc($item['alamat']) ?></td>
                        <td><?= ($item['status'] == "1") ? "Sudah Selesai" : "Belum Selesai" ?></td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Transaksi #<?= esc($item['id']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (!empty($product[$item['id']])) : ?>
                                        <?php foreach ($product[$item['id']] as $index2 => $item2) : ?>
                                            <div class="mb-3">
                                                <strong><?= $index2 + 1 ?>. <?= esc($item2['nama']) ?></strong><br>
                                                <?php if (!empty($item2['foto']) && file_exists("img/" . $item2['foto'])) : ?>
                                                    <img src="<?= base_url("img/" . $item2['foto']) ?>" width="100px" class="img-thumbnail">
                                                <?php endif; ?><br>
                                                Harga Asli: <?= number_to_currency($item2['harga_asli'] ?? $item2['harga'], 'IDR') ?><br>
                                                Diskon: <?= number_to_currency($item2['diskon'] ?? 0, 'IDR') ?><br>
                                                Harga Setelah Diskon: <strong><?= number_to_currency($item2['harga'], 'IDR') ?></strong><br>
                                                Jumlah: <?= $item2['jumlah'] ?> pcs<br>
                                                Subtotal: <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                            </div>
                                            <hr>
                                        <?php endforeach; ?>
                                        <div>
                                            <strong>Ongkir:</strong> <?= number_to_currency($item['ongkir'], 'IDR') ?><br>
                                            <strong>Total Pembayaran:</strong> <?= number_to_currency($item['total_harga'], 'IDR') ?>
                                        </div>
                                    <?php else : ?>
                                        <p class="text-muted">Tidak ada detail produk.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Detail Modal -->

                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
