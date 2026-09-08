<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Jamaluddin Al Afgani, S.Pd.,MP',
                'nip' => '197705012008011010',
                'password' => bcrypt('12345678'),
                'role' => 'kepalabalai',
                'no_hp' => '0851234546789',
                'jabatan' => 'Kepala Balai BBPP BK',
            ],
            [
                'name' => 'Rosdiana, S. Pi, MM', 
                'nip' => '197001141999032001', 
                'password' => bcrypt('12345678'), 
                'role' => 'kepalabagian', 
                'no_hp' => '0851234546789',
                'jabatan' => 'Kepala Bagian Umum',
            ],
            [
                'name' => 'Nenny Slaviaty, SP, MM', 
                'nip' => '197101162002122001', 
                'password' => bcrypt('12345678'), 
                'role' => 'kepalatimkerja', 
                'no_hp' => '0851234546789',
                'jabatan' => 'Analis Sumber Daya Manusia Aparatur Muda',
            ],
            [
                'name' => 'Hernik Yuswanti', 
                'nip' => '197202202000032001', 
                'password' => bcrypt('12345678'), 
                'role' => 'user', 
                'no_hp' => '0851234546789',
                'jabatan' => 'Pengolah Data dan Informasi'
            ],
            [
                'name' => 'M. Arsyad Ali', 
                'nip' => '197204241998031003', 
                'password' => bcrypt('12345678'), 
                'role' => 'user', 
                'no_hp' => '0851234546789',
                'jabatan' => 'Pengolah Data dan Informasi'
            ],
            [
                'name' => 'ADMIN', 
                'nip' => '300000000000000003', 
                'password' => bcrypt('12345678'), 
                'role' => 'admin'
            ],
            [
                'name' => 'PUTRI DAMAYANTI, M.Si.',
                'nip' => '199608012023212037',
                'password' => Hash::make('12345678'),
                'role' => 'widyaiswara',
                'no_hp' => '085123456780',
                'jabatan' => 'WIDYAISWARA AHLI PERTAMA'
            ],
            [
                'name' => 'Haeruddin, SE, Ak., M.Si',
                'nip' => '197706032011011007',
                'password' => Hash::make('12345678'),
                'role' => 'kepalatimkerja',
                'no_hp' => '085123456789',
                'jabatan' => 'Analis Pengelolaan Keuangan APBN Muda'
            ],
            [
                'name' => 'Ismail Hamid, SE',
                'nip' => '197101302003121001',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'no_hp' => '085123456780',
                'jabatan' => 'Pengolah Data dan Informasi'
            ],
            [
                'name' => 'Sabri, SE',
                'nip' => '199008152011011001',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'no_hp' => '085123456781',
                'jabatan' => 'Pengolah Data dan Informasi'
            ],
            [
                'name' => 'Abd. Rahman, S.AP',
                'nip' => '199105202011011001',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'no_hp' => '085123456782',
                'jabatan' => 'Analis Pengelolaan Keuangan APBN Pertama'
            ],
            [
                'name' => 'Marhumi',
                'nip' => '197506082006042026',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'no_hp' => '085123456783',
                'jabatan' => 'Pengolah Data dan Informasi'
            ],
            [
                'name' => 'Tajuddin, S.Kom',
                'nip' => '197701052002121003',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'no_hp' => '085123456784',
                'jabatan' => 'Penelaah Teknis Kebijakan'
            ],
            [
                'name' => 'Waode Nurinnah, S.ST.', 
                'nip' => '199509132025212016', 
                'password' => Hash::make('12345678'), 
                'role' => 'user', 
                'no_hp' => '', 
                'jabatan' => 'Penata Layanan Operasional', 
                'e_mail' => ''
                ],


                [
                    'name' => 'Muh. Arhamsyah, S.Pd.', 
                    'nip' => '199506242025211012', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Perencana Ahli Pertama'
                ],


                [
                    'name' => 'Istiqamawati', 
                    'nip' => '198610132025212009', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],


                [
                    'name' => 'Nur Indra Buana, S.T.P.', 
                    'nip' => '199101172025211004', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Perencana Ahli Pertama'
                ],

                [
                    'name' => 'Sri Mardhani, M.M.', 
                    'nip' => '199203202025212007', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Widyaiswara Ahli Pertama'
                ],

                [
                    'name' => 'Supriadi. S', 
                    'nip' => '199302142025211010', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Chelmi, S.E.', 
                    'nip' => '199001272025211008', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Arsiparis Ahli Pertama'
                ],

                [
                    'name' => 'Naziruddin AB, S.T.P.', 
                    'nip' => '199101312025211008', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Perencana Ahli Pertama'
                ],

                [
                    'name' => 'Ismayanti, M.M', 
                    'nip' => '198706232025212004', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Widyaiswara Ahli Pertama'
                ],

                [
                    'name' => 'Haryuti Abdi, S.Kom.', 
                    'nip' => '199103272025212020', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pranata Komputer Ahli Pertama'
                ],

                [
                    'name' => 'Riska Juwita, S.T.P.', 
                    'nip' => '198707142025212027', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Perencana Ahli Pertama'
                ],


                [
                    'name' => 'Naharuddin', 
                    'nip' => '198711222025211007', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Angreani.A, S.KM.', 
                    'nip' => '199310222025212011', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Besse Fika Yulistia, S.ST.', 
                    'nip' => '199512252025212019', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Jumarwansa, S.P.', 
                    'nip' => '199308132025211023', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Sukirman', 
                    'nip' => '198305112025211007', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Besse Kurniyati Warisman, S.Tr.Pt', 
                    'nip' => '199709032025212004', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Nadya Husaimah, A.Md.Keb', 
                    'nip' => '199604132025212015', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengelola Layanan Operasional'
                ],

                [
                    'name' => 'Muhammad Fachri', 
                    'nip' => '199401072025211018', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Operator Layanan Operasional'
                ],

                [
                    'name' => 'Muh. Natsir', 
                    'nip' => '199406102025211015', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Operator Layanan Operasional'
                ],

                [
                    'name' => 'Ide Bagus Sudaniel', 
                    'nip' => '197510212025211003', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Rano Karno', 
                    'nip' => '199302122025211016', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Bakri, S.P.', 
                    'nip' => '199404252025211007', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Syamsuddin', 
                    'nip' => '198810252025211018', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Muh.Said', 
                    'nip' => '198805102025211024', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Husain Haiya, S.P.', 
                    'nip' => '199101112025211008', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Nur Inayah, S.E.', 
                    'nip' => '199211232025212021', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Ulfah Hadaming, S.E.', 
                    'nip' => '199209172025212013', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Sumanto', 
                    'nip' => '197806052025211023', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Sakir', 
                    'nip' => '198708062025211000', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Operator Layanan Operasional'
                ],

                [
                    'name' => 'Afdal Adnan Tysar, SE', 
                    'nip' => '199010172025211013', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Muh Zuljalalil Wal Iqram', 
                    'nip' => '199507042025211008', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengadministrasi Perkantoran'
                ],

                [
                    'name' => 'Jumriani, S.E.', 
                    'nip' => '199008162025212016', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Sakir', 
                    'nip' => '198010102025211044', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Pengelola Umum Operasional'
                ],

                [
                    'name' => 'Yuni Erliya, S.Km', 
                    'nip' => '199305112025212021', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Yohanes Mandai, S.ST', 
                    'nip' => '198211242025211013', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Nadja Fiqhy Anwar. S.E', 
                    'nip' => '199412052025212000', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Penata Layanan Operasional'
                ],

                [
                    'name' => 'Thomas Attariba, S.ST', 
                    'nip' => '197608152025211013', 
                    'password' => Hash::make('12345678'), 
                    'role' => 'user', 
                    'no_hp' => '', 
                    'jabatan' => 'Arsiparis Ahli Pertama'
                ],


        ];
        
        foreach($users as $user) {
            User::create($user);
        }
    }
}
