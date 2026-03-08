<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id'); // ambil 1 user pertama kalau ada

        $activities = [
            [
                'title' => 'Seminar Kewirausahaan Alumni',
                'short_description' => 'Seminar penguatan jiwa kewirausahaan bagi alumni.',
                'description' => 'Kegiatan seminar ini menghadirkan pembicara dari kalangan alumni untuk berbagi pengalaman membangun usaha dan strategi menghadapi tantangan bisnis di era digital.',
                'date' => '2026-01-10',
                'location' => 'Aula IKA SMA 6',
            ],
            [
                'title' => 'Bakti Sosial Ramadhan',
                'short_description' => 'Kegiatan sosial berbagi bersama masyarakat sekitar.',
                'description' => 'Bakti sosial ini meliputi penyaluran sembako dan santunan kepada warga yang membutuhkan sebagai bentuk kepedulian sosial keluarga besar alumni.',
                'date' => '2026-01-18',
                'location' => 'Masjid Nurul Ilmi',
            ],
            [
                'title' => 'Reuni Akbar Angkatan',
                'short_description' => 'Ajang silaturahmi lintas angkatan alumni.',
                'description' => 'Reuni akbar diselenggarakan untuk mempererat hubungan antaralumni, memperluas jejaring, dan membangun kolaborasi yang bermanfaat bagi organisasi.',
                'date' => '2026-01-25',
                'location' => 'Gedung Serbaguna',
            ],
            [
                'title' => 'Pelatihan Public Speaking',
                'short_description' => 'Pelatihan komunikasi publik untuk siswa dan alumni muda.',
                'description' => 'Peserta akan dibekali teknik berbicara di depan umum, membangun kepercayaan diri, dan menyusun materi presentasi yang efektif.',
                'date' => '2026-02-02',
                'location' => 'Ruang Multimedia',
            ],
            [
                'title' => 'Career Talk Inspiratif',
                'short_description' => 'Sesi berbagi karier dari alumni di berbagai bidang.',
                'description' => 'Kegiatan ini mempertemukan siswa dengan alumni yang telah berkiprah di dunia kerja untuk memberikan gambaran karier dan motivasi masa depan.',
                'date' => '2026-02-08',
                'location' => 'Hall Sekolah',
            ],
            [
                'title' => 'Donor Darah Bersama',
                'short_description' => 'Aksi kemanusiaan melalui kegiatan donor darah.',
                'description' => 'Donor darah bersama dilaksanakan bekerja sama dengan PMI untuk membantu ketersediaan stok darah sekaligus menumbuhkan semangat solidaritas sosial.',
                'date' => '2026-02-14',
                'location' => 'Lapangan Indoor',
            ],
            [
                'title' => 'Workshop Digital Branding',
                'short_description' => 'Pelatihan membangun identitas digital secara profesional.',
                'description' => 'Workshop ini membahas personal branding, penggunaan media sosial secara strategis, serta penyusunan portofolio digital untuk kebutuhan akademik dan profesional.',
                'date' => '2026-02-20',
                'location' => 'Lab Komputer',
            ],
            [
                'title' => 'Turnamen Futsal Alumni',
                'short_description' => 'Kompetisi olahraga untuk mempererat kebersamaan alumni.',
                'description' => 'Turnamen futsal ini diikuti oleh beberapa tim lintas angkatan sebagai sarana menjaga kebugaran, sportivitas, dan silaturahmi.',
                'date' => '2026-02-27',
                'location' => 'GOR Mini',
            ],
            [
                'title' => 'Kajian dan Silaturahmi',
                'short_description' => 'Kegiatan keagamaan yang dikemas dalam suasana kekeluargaan.',
                'description' => 'Acara ini menghadirkan pemateri untuk membahas nilai-nilai kebersamaan, integritas, dan kontribusi sosial yang dapat diwujudkan oleh para alumni.',
                'date' => '2026-03-03',
                'location' => 'Aula Masjid',
            ],
            [
                'title' => 'Peluncuran Program Beasiswa Alumni',
                'short_description' => 'Peresmian program dukungan pendidikan untuk siswa berprestasi.',
                'description' => 'Program beasiswa alumni diluncurkan sebagai bentuk kontribusi nyata dalam mendukung siswa yang berprestasi dan membutuhkan bantuan pendidikan.',
                'date' => '2026-03-10',
                'location' => 'Ruang Pertemuan Utama',
            ],
        ];

        foreach ($activities as $activity) {
            Activity::updateOrCreate(
                [
                    'title' => $activity['title'],
                    'date' => $activity['date'],
                ],
                [
                    'short_description' => $activity['short_description'],
                    'description' => $activity['description'],
                    'location' => $activity['location'],
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    // image_path sengaja tidak diisi, akan null
                ]
            );
        }
    }
}