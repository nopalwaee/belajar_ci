<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php 
    function getTransactionData() {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:8080/api",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded",
                "Key: random123678abcghi"
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    $apiResponse = getTransactionData();
    ?>

    <div class="p-4 text-center">
      <h1 class="display-5 fw-bold">Dashboard Transaksi Toko</h1>
      <p class="fs-5"><?= date("l, d-m-Y") ?> <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
    </div>

    <div class="container mb-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-3">Daftar Transaksi</h5>
          <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
              <thead class="table-dark">
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Alamat</th>
                  <th>Total Harga</th>
                  <th>Ongkir</th>
                  <th>Total Bayar</th>
                  <th>Jumlah Item</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (!empty($apiResponse) && isset($apiResponse->status->code) && $apiResponse->status->code == 200) {
                    $transactions = $apiResponse->results;
                    $no = 1;
                    foreach ($transactions as $trx) {
                        $totalQty = 0;
                        if (!empty($trx->details)) {
                            foreach ($trx->details as $detail) {
                                $totalQty += $detail->jumlah ?? 0;
                            }
                        }
                        ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $trx->username ?? '-' ?></td>
                          <td><?= $trx->alamat ?? '-' ?></td>
                          <td><?= number_format($trx->total_harga ?? 0, 0, ',', '.') ?></td>
                          <td><?= number_format($trx->ongkir ?? 0, 0, ',', '.') ?></td>
                          <td><?= number_format(($trx->total_harga ?? 0) + ($trx->ongkir ?? 0), 0, ',', '.') ?></td>
                          <td><?= $totalQty ?> item</td>
                          <td><?= ($trx->status == 1) ? 'Selesai' : 'Belum Selesai' ?></td>
                          <td><?= date('d-m-Y H:i:s', strtotime($trx->created_at)) ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='9'>Data tidak tersedia atau API gagal dipanggil.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script>
      function waktu() {
        const now = new Date();
        document.getElementById("jam").innerText = now.getHours().toString().padStart(2, '0');
        document.getElementById("menit").innerText = now.getMinutes().toString().padStart(2, '0');
        document.getElementById("detik").innerText = now.getSeconds().toString().padStart(2, '0');
        setTimeout(waktu, 1000);
      }
      waktu();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
