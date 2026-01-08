<?php
function sendEmailApi($jns_doc, $no_doc, $location){
	// URL API yang akan diakses
$url = "http://10.62.124.17/sami-local/api/send-email-pr-trial/$jns_doc/$no_doc/$location";

// Data yang akan dikirim dalam permintaan API (jika ada)
$data = array(
    'from_api' => true,
);

// Menginisialisasi cURL
$ch = curl_init();

// Pengaturan cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Jika Anda mengirim data dalam permintaan, aktifkan opsi CURLOPT_POST dan set data yang akan dikirim
if (!empty($data)) {
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
}

// Eksekusi permintaan dan simpan respon
$response = curl_exec($ch);

// Periksa jika ada kesalahan
if ($response === false) {
    $error = curl_error($ch);
    // Tangani kesalahan curl di sini
    // echo "Error: " . $error;
} else {
    // Tangani respon yang diterima dari API
    // echo "Response berhasil <br>";
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
}

// Tutup koneksi cURL
curl_close($ch);

}

sendEmailApi('PR', 'PGA-IT-2405-017');

?>
