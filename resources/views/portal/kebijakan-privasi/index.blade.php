@extends('portal.layouts.app')

@section('content')
    <div class="w-full max-w-screen-xl mx-auto py-16 px-3 sm:px-6 text-gray-800">
        <h1 class="text-3xl font-bold text-center mt-12 mb-8 text-gray-900">
            Kebijakan Privasi
        </h1>

        <p class="text-justify text-gray-600 text-lg sm:text-xl max-w-full mx-auto mb-5 leading-relaxed">
            Kebijakan Privasi berikut menjelaskan bagaimana website E-Lapor DIY mengumpulkan, menggunakan, dan melindungi
            informasi pribadi pengguna. Dengan menggunakan layanan kami, Anda dianggap telah membaca, memahami, dan
            menyetujui
            isi Kebijakan Privasi ini.
        </p>

        <div class="space-y-5 w-full max-w-full sm:max-w-4xl lg:max-w-5xl xl:max-w-7xl mx-auto">
            @php
                $items = [
                    [
                        'title' => 'Pengumpulan Data Pengguna',
                        'content' => '<p>Kebijakan privasi ini memungkinkan untuk mengumpulkan informasi data pengguna website E-Lapor DIY pada saat melakukan registrasi. Informasi data yang pengguna berikan meliputi NIK, nama lengkap, email, dan nomor telepon. Pengguna melakukan verifikasi terhadap informasi yang diberikan, untuk memastikan bahwa data yang diberikan benar.</p>',
                    ],
                    [
                        'title' => 'Penggunaan Data Pengguna',
                        'content' => '<p>Informasi data pengguna digunakan untuk memverifikasi kepemilikian seseorang atas suatu akun. Ketika pengguna telah memiliki akun di E-Lapor DIY, pengguna dapat mengirimkan aduan pada E-Lapor DIY.</p>',
                    ],
                    [
                        'title' => 'Pembaharuan Data Pengguna',
                        'content' => '<p>Pengguna dapat memperbarui semua data yang telah diberikan, ketika terdapat kesalahan atau perubahan data pribadi.</p>',
                    ],
                    [
                        'title' => 'Pemberian Data Pengguna',
                        'content' => '<p>Pemberian data pengguna dilakukan apabila dibutuhkan adanya pengungkapan data kepada mitra atau pihak ketiga.</p>',
                    ],
                    [
                        'title' => 'Keamanan',
                        'content' => '<p>Kami tidak akan memberikan informasi pribadi pengguna kepada pihak manapun, karena bagi Kami kerahasiaan informasi pengguna adalah hal penting. Kami akan mengupayakan dan memberikan yang terbaik dalam melindungi dan mengamankan data pengguna.</p>',
                    ],
                    [
                        'title' => 'Perubahan Kebijakan Privasi',
                        'content' => '<p>Kebijakan Privasi ini akan Kami tinjau secara berkala dan disesuaikan apabila hal tersebut diperlukan. Kami mengimbau agar Pengguna dapat meninjau kebijakan privasi ini untuk mengetahui perkembangan informasi terbaru tentang Kebijakan Privasi yang Kami berlakukan.</p>',
                    ],
                    [
                        'title' => 'Kontak',
                        'content' => '<p>Untuk informasi lebih lanjut Anda dapat menghubungi Kami melalui email 
                                                                      <a href="mailto:diskominfo@jogjaprov.go.id" class="text-red-700 font-medium hover:underline">
                                                                      diskominfo@jogjaprov.go.id</a>.</p>',
                    ],
                    [
                        'title' => 'Daftar Email',
                        'content' => '
                        <div class="overflow-x-auto max-h-96 overflow-y-auto border rounded-lg">
                            <table class="min-w-full border border-gray-300 text-sm sm:text-base">
                                <thead class="bg-gray-200 text-gray-700 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-2 border">No.</th>
                                        <th class="px-4 py-2 border">Nama Instansi</th>
                                        <th class="px-4 py-2 border">Email</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-4 py-2 border">1</td><td class="px-4 py-2 border">Sekretariat Daerah</td><td class="px-4 py-2 border">sekda@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">2</td><td class="px-4 py-2 border">Biro Administrasi Perekonomian dan Sumberdaya Alam</td><td class="px-4 py-2 border">biro.perekonomian@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">3</td><td class="px-4 py-2 border">Biro Bina Mental Spiritual</td><td class="px-4 py-2 border">binamentals@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">4</td><td class="px-4 py-2 border">Biro Hukum</td><td class="px-4 py-2 border">birohukum@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">5</td><td class="px-4 py-2 border">Biro Tata Pemerintahan</td><td class="px-4 py-2 border">rotapem@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">6</td><td class="px-4 py-2 border">Biro Organisasi</td><td class="px-4 py-2 border">roorganisasi@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">7</td><td class="px-4 py-2 border">Biro Pengembangan Infrastruktur Wilayah dan Pembiayaan Pembangunan</td><td class="px-4 py-2 border">ropiwp2@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">8</td><td class="px-4 py-2 border">Biro Umum, Hubungan Masyarakat, dan Protokol</td><td class="px-4 py-2 border">roumum@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">9</td><td class="px-4 py-2 border">Badan Perencanaan Pembangunan Daerah</td><td class="px-4 py-2 border">bappeda@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">10</td><td class="px-4 py-2 border">Badan Pengelolaan Keuangan dan Aset</td><td class="px-4 py-2 border">bpka@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">11</td><td class="px-4 py-2 border">Badan Kepegawaian Daerah</td><td class="px-4 py-2 border">bkd@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">12</td><td class="px-4 py-2 border">Badan Pendidikan dan Pelatihan</td><td class="px-4 py-2 border">diklat@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">13</td><td class="px-4 py-2 border">Badan Penanggulangan Bencana Daerah</td><td class="px-4 py-2 border">bpbd@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">14</td><td class="px-4 py-2 border">Badan Penghubung Daerah</td><td class="px-4 py-2 border">kaperda@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">15</td><td class="px-4 py-2 border">Paniradya Kaistimewan</td><td class="px-4 py-2 border">paniradya.kaistimewan@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">16</td><td class="px-4 py-2 border">Sekretariat DPRD</td><td class="px-4 py-2 border">setwan@dprd-diy.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">17</td><td class="px-4 py-2 border">Inspektorat</td><td class="px-4 py-2 border">inspektorat@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">18</td><td class="px-4 py-2 border">Satuan Polisi Pamong Praja</td><td class="px-4 py-2 border">satpolpp@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">19</td><td class="px-4 py-2 border">Dinas Kebudayaan (Kundha Kabudayan)</td><td class="px-4 py-2 border">disbud@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">20</td><td class="px-4 py-2 border">Dinas Pertanahan dan Tata Ruang</td><td class="px-4 py-2 border">dispertaru@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">21</td><td class="px-4 py-2 border">Dinas Pendidikan, Pemuda dan Olah Raga</td><td class="px-4 py-2 border">dikpora@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">22</td><td class="px-4 py-2 border">Dinas Kesehatan</td><td class="px-4 py-2 border">dinkes@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">23</td><td class="px-4 py-2 border">Dinas Sosial</td><td class="px-4 py-2 border">dinsos@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">24</td><td class="px-4 py-2 border">Dinas Perhubungan</td><td class="px-4 py-2 border">dishub@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">25</td><td class="px-4 py-2 border">Dinas Pekerjaan Umum, Perumahan dan Energi Sumber Daya Mineral</td><td class="px-4 py-2 border">dpupesdm@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">26</td><td class="px-4 py-2 border">Dinas Tenaga Kerja dan Transmigrasi</td><td class="px-4 py-2 border">disnakertrans@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">27</td><td class="px-4 py-2 border">Dinas Pariwisata</td><td class="px-4 py-2 border">dispar@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">28</td><td class="px-4 py-2 border">Dinas Pertanian dan Ketahanan Pangan</td><td class="px-4 py-2 border">dpkp@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">29</td><td class="px-4 py-2 border">Dinas Perdagangan dan Industri</td><td class="px-4 py-2 border">disdagin@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">30</td><td class="px-4 py-2 border">Dinas Lingkungan Hidup</td><td class="px-4 py-2 border">dlh@jogjaprov.go.id</td></tr>
                                    <tr><td class="px-4 py-2 border">31</td><td class="px-4 py-2 border">Dinas Kebudayaan</td><td class="px-4 py-2 border">disbud@jogjaprov.go.id</td></tr>
                                </tbody>
                            </table>
                        </div>
                    ',
                    ],
                ];
            @endphp

            @foreach ($items as $item)
                <div class="border rounded-lg shadow-sm overflow-hidden" x-data="{ open: false }">
                    <!-- Accordion Header -->
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-5 py-4 text-left 
                                               bg-red-800 text-white font-semibold text-lg sm:text-xl hover:bg-red-900 transition">
                        <span>{{ $item['title'] }}</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Accordion Content -->
                    <div x-show="open" x-cloak x-transition
                        class="px-5 py-4 text-gray-700 text-lg sm:text-xl bg-gray-100 border-t border-gray-200 space-y-3 leading-relaxed">
                        {!! $item['content'] !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection