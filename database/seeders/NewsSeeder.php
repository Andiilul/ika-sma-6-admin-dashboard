<?php

namespace Database\Seeders;

use App\Enums\NewsStatus;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::query()->value('id'); // ambil 1 user pertama kalau ada

        $items = [
            [
                'title' => 'IKA SMA 6 Gelar Silaturahmi Awal Tahun Bersama Alumni',
                'excerpt' => 'Kegiatan silaturahmi awal tahun menjadi ajang mempererat hubungan antaralumni lintas angkatan.',
                'content' => 'IKA SMA 6 mengawali tahun dengan kegiatan silaturahmi bersama alumni dari berbagai angkatan. Acara ini bertujuan memperkuat koneksi, membangun kolaborasi, dan menyusun agenda strategis organisasi untuk periode mendatang.',
                'published_at' => '2026-01-05 09:00:00',
            ],
            [
                'title' => 'Program Beasiswa Alumni Resmi Diluncurkan untuk Siswa Berprestasi',
                'excerpt' => 'Program beasiswa ini dihadirkan sebagai bentuk kontribusi nyata alumni terhadap pendidikan di sekolah.',
                'content' => 'Program Beasiswa Alumni resmi diluncurkan sebagai bentuk dukungan kepada siswa berprestasi yang membutuhkan bantuan pendidikan. Program ini diharapkan menjadi langkah berkelanjutan dalam memperluas akses pendidikan yang lebih baik.',
                'published_at' => '2026-01-12 10:30:00',
            ],
            [
                'title' => 'Seminar Karier Hadirkan Alumni dari Berbagai Profesi',
                'excerpt' => 'Seminar karier mempertemukan siswa dengan alumni yang telah berkiprah di beragam bidang profesional.',
                'content' => 'Melalui seminar karier ini, siswa mendapatkan wawasan langsung dari alumni yang bekerja di sektor teknologi, pendidikan, pemerintahan, bisnis, dan industri kreatif. Kegiatan berlangsung interaktif dan penuh inspirasi.',
                'published_at' => '2026-01-18 13:00:00',
            ],
            [
                'title' => 'IKA SMA 6 Sukses Selenggarakan Donor Darah Bersama',
                'excerpt' => 'Aksi kemanusiaan ini disambut antusias oleh alumni, guru, dan masyarakat sekitar.',
                'content' => 'Kegiatan donor darah bersama yang diselenggarakan IKA SMA 6 berjalan lancar dengan partisipasi tinggi dari berbagai pihak. Selain membantu kebutuhan stok darah, kegiatan ini juga memperkuat semangat solidaritas sosial.',
                'published_at' => '2026-01-25 08:15:00',
            ],
            [
                'title' => 'Workshop Digital Branding Dorong Alumni Lebih Adaptif',
                'excerpt' => 'Peserta mendapatkan pemahaman praktis tentang personal branding dan strategi digital.',
                'content' => 'Workshop digital branding dirancang untuk membantu alumni memahami pentingnya identitas profesional di era digital. Materi mencakup personal branding, optimasi media sosial, hingga penyusunan portofolio yang relevan.',
                'published_at' => '2026-02-01 14:00:00',
            ],
            [
                'title' => 'Reuni Akbar Jadi Momentum Penguatan Jejaring Alumni',
                'excerpt' => 'Reuni akbar tidak hanya menjadi ajang nostalgia, tetapi juga wadah membangun kolaborasi konkret.',
                'content' => 'Reuni akbar yang dihadiri alumni lintas angkatan berlangsung meriah dan penuh kehangatan. Selain mempererat silaturahmi, kegiatan ini juga dimanfaatkan untuk memperluas jejaring dan merancang program bersama di masa depan.',
                'published_at' => '2026-02-08 16:00:00',
            ],
            [
                'title' => 'Pelatihan Public Speaking Tingkatkan Kepercayaan Diri Peserta',
                'excerpt' => 'Pelatihan ini membekali peserta dengan teknik berbicara di depan umum secara efektif.',
                'content' => 'Dalam pelatihan public speaking, peserta belajar teknik menyusun gagasan, mengelola intonasi, bahasa tubuh, serta strategi tampil percaya diri di hadapan audiens. Kegiatan ini menjadi salah satu program pengembangan kapasitas yang diminati.',
                'published_at' => '2026-02-14 09:45:00',
            ],
            [
                'title' => 'IKA SMA 6 Perluas Program Sosial Melalui Bakti Ramadhan',
                'excerpt' => 'Program sosial Ramadhan diarahkan untuk memperkuat kepedulian dan kontribusi alumni bagi masyarakat.',
                'content' => 'Melalui program bakti Ramadhan, IKA SMA 6 menyalurkan bantuan sosial kepada masyarakat yang membutuhkan. Kegiatan ini menjadi bagian dari komitmen alumni untuk terus hadir memberi manfaat secara langsung.',
                'published_at' => '2026-02-21 11:20:00',
            ],
            [
                'title' => 'Turnamen Futsal Alumni Bangun Semangat Sportivitas',
                'excerpt' => 'Turnamen futsal menjadi sarana mempererat hubungan antarangkatan dalam suasana kompetitif yang sehat.',
                'content' => 'Turnamen futsal alumni sukses digelar dengan partisipasi berbagai angkatan. Selain menghadirkan pertandingan seru, kegiatan ini juga menumbuhkan semangat sportivitas, kebersamaan, dan gaya hidup aktif di kalangan alumni.',
                'published_at' => '2026-02-28 15:10:00',
            ],
            [
                'title' => 'Pengurus IKA SMA 6 Susun Agenda Strategis Tahun 2026',
                'excerpt' => 'Rapat kerja pengurus menghasilkan sejumlah prioritas program untuk satu tahun ke depan.',
                'content' => 'Pengurus IKA SMA 6 menggelar rapat kerja untuk menyusun agenda strategis tahun 2026. Fokus program mencakup penguatan organisasi, kegiatan sosial, pengembangan alumni muda, serta peningkatan kontribusi terhadap sekolah.',
                'published_at' => '2026-03-05 10:00:00',
            ],
        ];

        foreach ($items as $item) {
            News::updateOrCreate(
                [
                    'slug' => \Illuminate\Support\Str::slug($item['title']),
                ],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'status' => NewsStatus::Published,
                    'published_at' => $item['published_at'],
                    'meta_title' => $item['title'],
                    'meta_description' => $item['excerpt'],
                    'og_image_path' => null,
                    'author_id' => $authorId,
                ]
            );
        }
    }
}