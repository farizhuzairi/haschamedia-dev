<?php

namespace HaschaDev\Enums;

enum ComponentableType : string
{
    case DEFAULT_ = "Selalu tersedia dan dapat dipergunakan untuk mendukung  suatu layanan atau fungsi lain.";
    case DEPENDENCY_ = "Memerlukan dukungan dari layanan atau fungsi lain, atau diperlukan untuk mendukung suatu layanan atau fungsi lain.";
    case OPTIONAL_ = "Tersedia sebagai layanan atau fungsional ekstra; tidak menggagalkan layanan atau fungsi lain jika tidak digunakan.";
    case REQUIRED_ = "Diperlukan dan harus tersedia; bersifat utama dan tetap.";
    case CONDITIONAL_ = "Sebagai layanan atau fungsi khusus yang didefinisikan secara dinamis berdasarkan suatu kondisi tertentu (bersyarat).";

    public static function getByName(string $key, bool $isValue = false): self|string|null
    {
        foreach (self::cases() as $case) {
            if ($case->name === $key) {
                return $isValue ? $case->value : $case;
            }
        }
        return null;
    }
}