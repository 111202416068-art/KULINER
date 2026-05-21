<?php

/**
 * Custom Helper untuk generate ikon bintang berdasarkan angka rating
 * Memenuhi syarat Nilai Hijau Poin 9 (Custom Helper)
 */
if (!function_exists('render_bintang')) {
    function render_bintang($rating) {
        $rating = floatval($rating);
        $output = '';

        // Looping untuk memunculkan maksimal 5 bintang
        for ($i = 1; $i <= 5; $i++) {
            if ($rating >= $i) {
                // Bintang Penuh
                $output .= '<i class="bi bi-star-fill text-warning me-1"></i>';
            } elseif ($rating >= ($i - 0.5)) {
                // Bintang Setengah (Jika rating desimal seperti 4.5)
                $output .= '<i class="bi bi-star-half text-warning me-1"></i>';
            } else {
                // Bintang Kosong
                $output .= '<i class="bi bi-star text-muted me-1"></i>';
            }
        }

        return $output;
    }
}