<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Enkripsi & Dekripsi XOR</title>
    <style>
        body { 
            font-family: "Times New Roman", Times, serif; 
            background-color: #f4f4f9; /* Memberikan sedikit warna latar belakang */
            margin: 0;
            padding: 20px;
        }
        
        /* Membuat kotak kontainer di tengah layar */
        .container {
            max-width: 450px; 
            margin: 40px auto; /* margin auto akan membuat elemen berada di tengah horizontal */
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Sedikit bayangan agar elegan */
        }

        h2 { 
            text-align: center; 
            margin-top: 0;
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            margin-top: 15px; 
            margin-bottom: 5px; 
            font-weight: bold;
        }

        /* Lebar input dan select diatur 100% agar pas dengan kontainer */
        input[type="text"], select { 
            width: 100%; 
            padding: 6px; 
            background-color: #e8f0fe; 
            border: 1px solid #767676; 
            box-sizing: border-box;
            border-radius: 3px;
        }

        button { 
            margin-top: 20px; 
            padding: 8px 12px; 
            cursor: pointer; 
            width: 100%; /* Tombol dibuat memanjang */
            font-size: 16px;
            font-weight: bold;
        }

        hr { 
            margin-top: 25px; 
            border: 0; 
            border-top: 1px solid #ccc; 
        }

        h3 {
            text-align: center;
        }

        /* Area hasil diletakkan di tengah dan teks bisa turun ke bawah jika terlalu panjang */
        .hasil { 
            font-size: 18px; 
            margin-top: 15px; 
            text-align: center;
            word-break: break-all;
            background-color: #eef;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Aplikasi Enkripsi & Dekripsi XOR</h2>

        <form method="POST" action="">
            <label>Masukkan Pesan (Teks Asli / Cipher):</label>
            <input type="text" name="pesan" value="<?= isset($_POST['pesan']) ? htmlspecialchars($_POST['pesan']) : '' ?>" required>

            <label>Kata Kunci (Key):</label>
            <input type="text" name="kunci" value="<?= isset($_POST['kunci']) ? htmlspecialchars($_POST['kunci']) : 'UMPONTIANAK' ?>" required>

            <label>Pilih Aksi:</label>
            <select name="aksi">
                <option value="enkripsi" <?= (isset($_POST['aksi']) && $_POST['aksi'] == 'enkripsi') ? 'selected' : '' ?>>Enkripsi (Plain -> Cipher)</option>
                <option value="dekripsi" <?= (isset($_POST['aksi']) && $_POST['aksi'] == 'dekripsi') ? 'selected' : '' ?>>Dekripsi (Cipher -> Plain)</option>
            </select>
            <br>
            <button type="submit" name="proses">Proses Kriptografi</button>
        </form>

        <hr>

        <h3>Hasil Proses:</h3>

        <?php
        // Fungsi untuk melakukan operasi XOR
        function xor_process($teks, $kunci) {
            $hasil = '';
            $panjang_kunci = strlen($kunci);
            for ($i = 0; $i < strlen($teks); $i++) {
                // Melakukan proses XOR per karakter
                $hasil .= $teks[$i] ^ $kunci[$i % $panjang_kunci];
            }
            return $hasil;
        }

        // Jika tombol proses diklik
        if (isset($_POST['proses'])) {
            $pesan = $_POST['pesan'];
            $kunci = $_POST['kunci'];
            $aksi = $_POST['aksi'];

            if ($aksi == 'enkripsi') {
                // Enkripsi: Teks asli di-XOR dengan Kunci, lalu diubah ke format Hexadecimal agar bisa dibaca di layar
                $teks_xor = xor_process($pesan, $kunci);
                $hasil_akhir = bin2hex($teks_xor);
                echo "<div class='hasil'>" . htmlspecialchars($hasil_akhir) . "</div>";
                
            } elseif ($aksi == 'dekripsi') {
                // Dekripsi: Hexadecimal diubah dulu kembali ke Teks (biner/string), lalu di-XOR dengan Kunci
                // Cek dulu apakah pesan benar-benar format hexadecimal yang valid
                if (ctype_xdigit($pesan) && strlen($pesan) % 2 == 0) {
                    $teks_biner = hex2bin($pesan);
                    $hasil_akhir = xor_process($teks_biner, $kunci);
                    echo "<div class='hasil'>" . htmlspecialchars($hasil_akhir) . "</div>";
                } else {
                    echo "<div class='hasil' style='color:red;'>Error: Pesan Cipher bukan format Hexadecimal yang valid!</div>";
                }
            }
        }
        ?>
    </div>

</body>
</html>