<?php

declare(strict_types=1);

namespace App\Enums;

enum PrayerTimezone: string
{
    case JHR01 = 'JHR01';
    case JHR02 = 'JHR02';
    case JHR03 = 'JHR03';
    case JHR04 = 'JHR04';
    case KDH01 = 'KDH01';
    case KDH02 = 'KDH02';
    case KDH03 = 'KDH03';
    case KDH04 = 'KDH04';
    case KDH05 = 'KDH05';
    case KDH06 = 'KDH06';
    case KDH07 = 'KDH07';
    case KTN01 = 'KTN01';
    case KTN02 = 'KTN02';
    case MLK01 = 'MLK01';
    case NGS01 = 'NGS01';
    case NGS02 = 'NGS02';
    case NGS03 = 'NGS03';
    case PHG01 = 'PHG01';
    case PHG02 = 'PHG02';
    case PHG03 = 'PHG03';
    case PHG04 = 'PHG04';
    case PHG05 = 'PHG05';
    case PHG06 = 'PHG06';
    case PLS01 = 'PLS01';
    case PNG01 = 'PNG01';
    case PRK01 = 'PRK01';
    case PRK02 = 'PRK02';
    case PRK03 = 'PRK03';
    case PRK04 = 'PRK04';
    case PRK05 = 'PRK05';
    case PRK06 = 'PRK06';
    case PRK07 = 'PRK07';
    case SBH01 = 'SBH01';
    case SBH02 = 'SBH02';
    case SBH03 = 'SBH03';
    case SBH04 = 'SBH04';
    case SBH05 = 'SBH05';
    case SBH06 = 'SBH06';
    case SBH07 = 'SBH07';
    case SBH08 = 'SBH08';
    case SBH09 = 'SBH09';
    case SGR01 = 'SGR01';
    case SGR02 = 'SGR02';
    case SGR03 = 'SGR03';
    case SWK01 = 'SWK01';
    case SWK02 = 'SWK02';
    case SWK03 = 'SWK03';
    case SWK04 = 'SWK04';
    case SWK05 = 'SWK05';
    case SWK06 = 'SWK06';
    case SWK07 = 'SWK07';
    case SWK08 = 'SWK08';
    case SWK09 = 'SWK09';
    case TRG01 = 'TRG01';
    case TRG02 = 'TRG02';
    case TRG03 = 'TRG03';
    case TRG04 = 'TRG04';
    case WLY01 = 'WLY01';
    case WLY02 = 'WLY02';

    public function locations(): string
    {
        return match ($this) {
            self::JHR01 => 'Pulau Aur dan Pulau Pemanggil',
            self::JHR02 => 'Johor Bahru, Kota Tinggi, Mersing, Kulai',
            self::JHR03 => 'Kluang, Pontian',
            self::JHR04 => 'Batu Pahat, Muar, Segamat, Gemas Johor, Tangkak',
            self::KDH01 => 'Kota Setar, Kubang Pasu, Pokok Sena (Daerah Kecil)',
            self::KDH02 => 'Kuala Muda, Yan, Pendang',
            self::KDH03 => 'Padang Terap, Sik',
            self::KDH04 => 'Baling',
            self::KDH05 => 'Bandar Baharu, Kulim',
            self::KDH06 => 'Langkawi',
            self::KDH07 => 'Puncak Gunung Jerai',
            self::KTN01 => 'Bachok, Kota Bharu, Machang, Pasir Mas, Pasir Puteh, Tanah Merah, Tumpat, Kuala Krai, Mukim Chiku',
            self::KTN02 => 'Gua Musang (Daerah Galas Dan Bertam), Jeli, Jajahan Kecil Lojing',
            self::MLK01 => 'SELURUH NEGERI MELAKA',
            self::NGS01 => 'Tampin, Jempol',
            self::NGS02 => 'Jelebu, Kuala Pilah, Rembau',
            self::NGS03 => 'Port Dickson, Seremban',
            self::PHG01 => 'Pulau Tioman',
            self::PHG02 => 'Kuantan, Pekan, Rompin, Muadzam Shah',
            self::PHG03 => 'Jerantut, Temerloh, Maran, Bera, Chenor, Jengka',
            self::PHG04 => 'Bentong, Lipis, Raub',
            self::PHG05 => 'Genting Sempah, Janda Baik, Bukit Tinggi',
            self::PHG06 => 'Cameron Highlands, Genting Higlands, Bukit Fraser',
            self::PLS01 => 'Kangar, Padang Besar, Arau',
            self::PNG01 => 'Seluruh Negeri Pulau Pinang',
            self::PRK01 => 'Tapah, Slim River, Tanjung Malim',
            self::PRK02 => 'Kuala Kangsar, Sg. Siput , Ipoh, Batu Gajah, Kampar',
            self::PRK03 => 'Lenggong, Pengkalan Hulu, Grik',
            self::PRK04 => 'Temengor, Belum',
            self::PRK05 => 'Kg Gajah, Teluk Intan, Bagan Datuk, Seri Iskandar, Beruas, Parit, Lumut, Sitiawan, Pulau Pangkor',
            self::PRK06 => 'Selama, Taiping, Bagan Serai, Parit Buntar',
            self::PRK07 => 'Bukit Larut',
            self::SBH01 => 'Bahagian Sandakan (Timur), Bukit Garam, Semawang, Temanggong, Tambisan, Bandar Sandakan, Sukau',
            self::SBH02 => 'Beluran, Telupid, Pinangah, Terusan, Kuamut, Bahagian Sandakan (Barat)',
            self::SBH03 => 'Lahad Datu, Silabukan, Kunak, Sahabat, Semporna, Tungku, Bahagian Tawau  (Timur)',
            self::SBH04 => 'Bandar Tawau, Balong, Merotai, Kalabakan, Bahagian Tawau (Barat)',
            self::SBH05 => 'Kudat, Kota Marudu, Pitas, Pulau Banggi, Bahagian Kudat',
            self::SBH06 => 'Gunung Kinabalu',
            self::SBH07 => 'Kota Kinabalu, Ranau, Kota Belud, Tuaran, Penampang, Papar, Putatan, Bahagian Pantai Barat',
            self::SBH08 => 'Pensiangan, Keningau, Tambunan, Nabawan, Bahagian Pendalaman (Atas)',
            self::SBH09 => 'Beaufort, Kuala Penyu, Sipitang, Tenom, Long Pasia, Membakut, Weston, Bahagian Pendalaman (Bawah)',
            self::SGR01 => 'Gombak, Petaling, Sepang, Hulu Langat, Hulu Selangor, S.Alam',
            self::SGR02 => 'Kuala Selangor, Sabak Bernam',
            self::SGR03 => 'Klang, Kuala Langat',
            self::SWK01 => 'Limbang, Lawas, Sundar, Trusan',
            self::SWK02 => 'Miri, Niah, Bekenu, Sibuti, Marudi',
            self::SWK03 => 'Pandan, Belaga, Suai, Tatau, Sebauh, Bintulu',
            self::SWK04 => 'Sibu, Mukah, Dalat, Song, Igan, Oya, Balingian, Kanowit, Kapit',
            self::SWK05 => 'Sarikei, Matu, Julau, Rajang, Daro, Bintangor, Belawai',
            self::SWK06 => 'Lubok Antu, Sri Aman, Roban, Debak, Kabong, Lingga, Engkelili, Betong, Spaoh, Pusa, Saratok',
            self::SWK07 => 'Serian, Simunjan, Samarahan, Sebuyau, Meludam',
            self::SWK08 => 'Kuching, Bau, Lundu, Sematan',
            self::SWK09 => 'Zon Khas (Kampung Patarikan)',
            self::TRG01 => 'Kuala Terengganu, Marang, Kuala Nerus',
            self::TRG02 => 'Besut, Setiu',
            self::TRG03 => 'Hulu Terengganu',
            self::TRG04 => 'Dungun, Kemaman',
            self::WLY01 => 'Kuala Lumpur, Putrajaya',
            self::WLY02 => 'Labuan',
        };
    }
}
