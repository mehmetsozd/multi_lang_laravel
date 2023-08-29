<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class TranslateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lang = Config::get('app.locale');
        \App\Models\Translate::create([
            'code'=>$lang,
            'translate'=>json_decode('{"CallText":"Hemen Ara","homePage":"Anasayfa","aboutUs":"Hakk\u0131m\u0131zda","ourServices":"Hizmetlerimiz","ourTeam":"Ekibimiz","gallery":"Galeri","doctorAsks":"Hekiminiz Soruyor","myBlogs":"Bloglar\u0131m","myBlogsDescription":"Bloglar\u0131m\u0131z\u0131 inceleyebilirsiniz.","myBlogsButton":"\u0130ncele","patientStories":"Hasta Hikayeleri","sss":"S\u0131kca Sorulan Sorular","readMore":"Devam\u0131n\u0131 Oku","ourService":"Hizmetlerimiz","videos":"Videolar","ourHospitals":"Hastanelerimiz","title":{"homePage":"title Anasayfa","aboutUs":"title Hakk\u0131m\u0131zda","ourServices":"title Hizmetlerimiz","ourTeam":"title Ekibimiz","reservation":"title Rezervasyon","blog":"title Bloglar\u0131m","videos":"title Videolar","hospital":"title Hastanelerimiz","gallery":"title Galeri","privacyPolicy":"title Gizlilik Politikas\u0131","doctorQuestion":"title Doktorunuz Soruyor ?"},"footerContent":"\u0130\u00e7erik","privacyPolicy":"Gizlilik Politikas\u0131 & KVKK","textMore":"Daha Fazla Oku","textMoreHide":"Daha Az Oku","form":{"title":"form Detayl\u0131 Bilgi Almak \u0130\u00e7in Formu Doldurabilirsiniz","name":"form Ad Soyad","email":"form Email","phone":"form Telefon","send":"form G\u00f6nder","success":"form Bilgilendirme formu ba\u015far\u0131yla g\u00f6nderildi","error":"form Bilgilendirme formu g\u00f6nderilirken bir hata olu\u015ftu","errorFillAll":"form L\u00fctfen t\u00fcm alanlar\u0131 doldurunuz"}}',TRUE),
        ]);
    }
}
