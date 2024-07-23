<?php

namespace HaschaDev\Services\Page;

use HaschaDev\Contracts\Page\Pageable;
use Illuminate\Support\Facades\Log;
use HaschaDev\Services\Page\Routerable;

class PageService implements Pageable
{
    public readonly string $route;
    public readonly string $url_request;
    protected ?Routerable $routerable;
    public readonly string $title;
    public readonly string $name;
    public readonly string $tagline;
    public readonly string $description;

    public function __construct()
    {}

    public function setRouter(string $routeName): void
    {
        $this->routerable = Routerable::init($routeName);
        $this->route = $routeName;
        $this->url_request = request()->fullUrl();

        /**
         * Page Data
         * 
         */
        $this->setPageableData();
    }

    public function routerable(): Routerable
    {
        if(!isset($this->routerable)){
            throw new \Exception("Routerable belum diinisiasi. error_in_PHP_class: " . __CLASS__ . ' #URL: ' . request()->fullUrl());
        }
        return $this->routerable;
    }

    /**
     * set Pageable Data
     * 
     */
    private function setPageableData(): void
    {
        $route = $this->routerable;
        switch ($route) {

            case Routerable::INDEX:
            $title = "Home Page | Error";
            $name = "Indeks";
            $tagline = "Terimakasih telah memberikan kepercayaan kepada kami.";
            $description = "Hascha Media Development, membangun dan mewujudkan sumber daya yang hebat untuk kepentingan bersama. Mulai berkolaborasi dan diskusikan langkah-langkah positif demi menempatkan proses ideal dalam mencapai tujuan kompleks!";
            break;
            
            case Routerable::DASHBOARD:
            $title = "Administrator Page";
            $name = "Dashboard";
            $tagline = "Membangun wadah untuk aset dan sumber daya.";
            $description = "Halaman Administrasi menempatkan titik awal dan mengubah setiap objek menjadi sumber daya yang selalu bermanfaat.";
            break;
            
            case Routerable::PRODUCT:
            $title = "Product Page";
            $name = "Kelola Daftar Produk";
            $tagline = "Objek utama membangun sumber daya; langkah awal dalam mencapai langkah-langkah selanjutnya.";
            $description = "Mengelola produk sebagai aplikasi (objek) dalam mengimplementasi berbagai fungsi dan manfaat yang dapat digunakan oleh sebanyak mungkin klien.";
            break;
            
            case Routerable::PRODUCT_CREATE:
            $title = "Create New Product";
            $name = "Tambahkan Produk Baru";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::PRODUCT_MANAGE:
            $title = "Manage Product";
            $name = "Kelola Produk";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::MODEL:
            $title = "Feature Model Page";
            $name = "Kelola Daftar Model";
            $tagline = "Klasifikasi berbagai fungsi yang dapat dibangun di atas dasar konsep terstruktur.";
            $description = "Model Fitur memudahkan pengelolaan fitur yang dikelompokan menjadi suatu konsep terstruktur secara dinamis, dapat berdiri sendiri, dan reusable.";
            break;
            
            case Routerable::MODEL_MANAGE:
            $title = "Manage Feature Model";
            $name = "Model Fitur";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::FEATURE:
            $title = "Feature Page";
            $name = "Kelola Daftar Fitur";
            $tagline = "Fungsionalitas yang dapat diandalkan untuk membangun sekelompok aturan dinamis.";
            $description = "Atur dan kelola fitur aplikasi untuk menciptakan fungsi yang saling terhubung; Membangun objek dinamis untuk berbagai kebutuhan kompleks aplikasi.";
            break;
            
            case Routerable::FEATURE_CREATE:
            $title = "Create New Feature";
            $name = "Tambah Fitur Baru";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::FEATURE_MANAGE:
            $title = "Manage Feature";
            $name = "Fitur";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::RULE:
            $title = "Feature Rule Page";
            $name = "Kelola Daftar Aturan Fitur (Rules)";
            $tagline = "Sekumpulan definisi yang menjaga fungsi dan kinerja dalam ruang lingkup tujuan yang dibutuhkan.";
            $description = "Memproses, mengelola, mengorgabisir, hingga melakukan berbagai fungsionalitas dinamis untuk memeuhi setiap kebutuhan dan tujuan.";
            break;
            
            case Routerable::RULE_CREATE:
            $title = "Create New Feature Rule";
            $name = "Tambah Aturan Fitur Baru";
            $tagline = "Membangun fungsi yang relevan dan mendetails, mengintegrasikan setiap aliran terstruktur menjadi tersistem.";
            $description = "Menambahkan aturan fitur (rules) dan mulai melengkapi fungsionalitas tanpa batas. Sebuah implementasi ide dan gagasan yang akan digunakan oleh banyak sumber daya.";
            break;
            
            case Routerable::RULE_MANAGE:
            $title = "Manage Feature Rule";
            $name = "Aturan Fitur (Rules)";
            $tagline = "";
            $description = "";
            break;
            
            // case Routerable::SERVICE:
            // $title = "Service Page";
            // $name = "Kelola Daftar Layanan Aplikasi";
            // $tagline = "";
            // $description = "";
            // break;
            
            case Routerable::SERVICE_CREATE:
            $title = "Create New Service";
            $name = "Tambah Layanan Baru";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::SERVICE_MANAGE:
            $title = "Manage Service";
            $name = "Layanan Aplikasi";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::SERVICE_PAGE_CREATE:
            $title = "Create New Page Service";
            $name = "Tambah Halaman Baru";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::SERVICE_PAGE_MANAGE:
            $title = "Manage Page Service";
            $name = "Rute dan Halaman";
            $tagline = "";
            $description = "";
            break;

            case Routerable::PACKAGE:
            $title = "Service Package Page";
            $name = "Kelola Daftar Paket Layanan";
            $tagline = "Atur lisensi berdasarkan paket fitur dalam layanan yang terhubung.";
            $description = "Menetapkan fungsi dan aturan fitur, mengelola harga paket layanan, dan menerbitkan lisensi.";
            break;
            
            case Routerable::PACKAGE_CREATE:
            $title = "Create New Service Package";
            $name = "Tambah Paket Layanan Baru";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::PACKAGE_MANAGE:
            $title = "Manage Service Package";
            $name = "Paket Layanan";
            $tagline = "";
            $description = "";
            break;
            
            case Routerable::INTEGRATION:
            $title = "Hub Integration";
            $name = "Integrasi";
            $tagline = "Objek utama membangun sumber daya; langkah awal dalam mencapai langkah-langkah selanjutnya.";
            $description = "Mengelola produk sebagai aplikasi (objek) dalam mengimplementasi berbagai fungsi dan manfaat yang dapat digunakan oleh sebanyak mungkin klien.";
            break;

            default:
            $title = "";
            $name = "";
            $tagline = "";
            $description = "";
            break;
        }

        try {
            $this->title = (string) $title;
            $this->name = (string) $name;
            $this->tagline = (string) $tagline;
            $this->description = (string) $description;
        } catch (\Throwable $th) {
            Log::error("Kesalahan mendefinisikan objek (attributes). Error: {$th}");
        }
    }
}