<?php

namespace App\Services;

use App\Models\DataLatih;

class KnnService
{
    // Konversi Intensitas Penggunaan dari teks ke angka
    protected function konversiIntensitas($label)
    {
        return match ($label) {
            'Rendah' => 0,
            'Sedang' => 1,
            'Tinggi' => 2,
            default => 0,
        };
    }

    // Similarity Jenis Aset: 0 kalau sama, 1 kalau beda
    protected function similarityJenisAset($jenisA, $jenisB)
    {
        return $jenisA === $jenisB ? 0 : 1;
    }

    // Fungsi utama klasifikasi
    public function klasifikasi($jenisAsetUji, $intensitasUji, $usiaUji, $k = 3)
    {
        $dataLatih = DataLatih::all();

        // Ambil nilai min-max dari data latih (buat normalisasi X2 dan X3)
        $intensitasNumerik = $dataLatih->map(fn($d) => $this->konversiIntensitas($d->intensitas_penggunaan));
        $usiaNumerik = $dataLatih->pluck('usia_aset');

        $minIntensitas = $intensitasNumerik->min();
        $maxIntensitas = $intensitasNumerik->max();
        $minUsia = $usiaNumerik->min();
        $maxUsia = $usiaNumerik->max();

        // Normalisasi data uji
        $intensitasUjiNumerik = $this->konversiIntensitas($intensitasUji);
        $x2Uji = ($maxIntensitas - $minIntensitas) == 0 ? 0 :
            ($intensitasUjiNumerik - $minIntensitas) / ($maxIntensitas - $minIntensitas);
        $x3Uji = ($maxUsia - $minUsia) == 0 ? 0 :
            ($usiaUji - $minUsia) / ($maxUsia - $minUsia);

        $jarak = [];

        foreach ($dataLatih as $d) {
            // X1: similarity jenis aset (0 atau 1, tidak dinormalisasi)
            $x1 = $this->similarityJenisAset($jenisAsetUji, $d->jenis_aset);

            // Normalisasi X2 dan X3 data latih
            $intensitasNumerikD = $this->konversiIntensitas($d->intensitas_penggunaan);
            $x2 = ($maxIntensitas - $minIntensitas) == 0 ? 0 :
                ($intensitasNumerikD - $minIntensitas) / ($maxIntensitas - $minIntensitas);
            $x3 = ($maxUsia - $minUsia) == 0 ? 0 :
                ($d->usia_aset - $minUsia) / ($maxUsia - $minUsia);

            // Euclidean Distance
            $jarakEuclidean = sqrt(
                pow($x1 - 0, 2) +      // similarity jenis aset uji selalu dianggap 0 (dirinya sendiri)
                pow($x2Uji - $x2, 2) +
                pow($x3Uji - $x3, 2)
            );

            $jarak[] = [
                'id_data_latih' => $d->id_data_latih,
                'nama_referensi' => $d->jenis_aset,
                'jarak' => round($jarakEuclidean, 4),
                'label_kondisi' => $d->label_kondisi,
            ];
        }

        // Urutkan berdasarkan jarak terkecil
        usort($jarak, fn($a, $b) => $a['jarak'] <=> $b['jarak']);

        // Ambil K tetangga terdekat
        $kTetangga = array_slice($jarak, 0, $k);

        // Majority voting
        $labelCount = [];
        foreach ($kTetangga as $tetangga) {
            $label = $tetangga['label_kondisi'];
            $labelCount[$label] = ($labelCount[$label] ?? 0) + 1;
        }
        arsort($labelCount);
        $hasilKlasifikasi = array_key_first($labelCount);

        return [
            'hasil_klasifikasi' => $hasilKlasifikasi,
            'k_tetangga' => $kTetangga,
            'semua_jarak' => $jarak,
        ];
    }
}