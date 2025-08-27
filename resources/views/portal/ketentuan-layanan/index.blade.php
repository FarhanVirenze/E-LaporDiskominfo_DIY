@extends('portal.layouts.app')

@section('content')
    <div class="w-full max-w-screen-xl mx-auto py-16 px-3 sm:px-6 text-gray-800">
        <h1 class="text-3xl font-bold text-center mt-12 mb-8 text-gray-900">
            Ketentuan Layanan
        </h1>

        <p class="text-justify text-gray-600 text-lg sm:text-xl max-w-full mx-auto mb-5 leading-relaxed">

            Ketentuan Layanan berikut adalah ketentuan dalam pengunjungan situs, konten, layanan dan fitur yang ada di
            website E-Lapor DIY. Dengan mengakses dan menggunakan website E-Lapor DIY, berarti Anda telah memahami dan
            menyetujui untuk terikat dan tunduk dengan semua peraturan yang berlaku di situs ini. Jika Anda tidak setuju
            untuk terikat dengan semua peraturan yang berlaku, silakan untuk tidak mengakses situs ini.
        </p>

        <div class="space-y-5 w-full max-w-full sm:max-w-4xl lg:max-w-5xl xl:max-w-7xl mx-auto" x-data="{ active: null }">


            @php
                $items = [
                    [
                        'title' => 'Pengubahan Ketentuan Layanan',
                        'content' => '
                                                                                                                                                                            Kami setiap saat dapat mengubah, mengganti, menambah atau mengurangi Ketentuan Layanan ini.
                                                                                                                                                                            Anda terikat oleh setiap perubahan tersebut dan oleh sebab itu secara berkala harus melihat
                                                                                                                                                                            halaman ini untuk memeriksa Ketentuan Layanan yang berlaku dan mengikat Anda.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Penambahan Ketentuan Layanan',
                        'content' => '
                                                                                                                                                                            Beberapa area atau layanan dari website E-Lapor DIY, seperti halaman di mana Anda dapat
                                                                                                                                                                            mengunggah berkas, dapat memiliki panduan dan peraturan pengunjungan yang akan menambah
                                                                                                                                                                            Ketentuan Layanan ini. Dengan menggunakan layanan tersebut, Anda setuju untuk terikat dengan
                                                                                                                                                                            petunjuk dan peraturan pengunjungan yang berlaku tersebut.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Pengubahan Website E-Lapor DIY',
                        'content' => '
                                                                                                                                                                            Kami dapat tidak meneruskan atau mengubah layanan atau fitur pada website E-Lapor DIY
                                                                                                                                                                            sewaktu-waktu dan tanpa pemberitahuan terlebih dahulu.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Pengunjung Website',
                        'content' => '
                                                                                                                                                                            Sebagai pengunjung website, Anda dapat melihat aduan publik yang telah dikirimkan oleh pengunjung lain.
                                                                                                                                                                            Layanan Kirim Aduan yang ada pada situs ini hanya disediakan untuk pengunjung yang telah mendaftar
                                                                                                                                                                            dengan memberikan data-data yang benar. Sebagai pengunjung yang telah mendaftarkan akun, Anda diwajibkan
                                                                                                                                                                            untuk mengikuti segala peraturan pengunjungan layanan tersebut serta menjaga keamanan kata sandi (password) akun Anda.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Prosedur Pengaduan',
                        'content' => '
                                                                                                                                                                            Dalam mengirimkan aduan melalui website E-Lapor DIY, Anda setuju untuk:
                                                                                                                                                                            <ul class="list-disc list-inside space-y-1 mt-2">
                                                                                                                                                                                <li>Menggunakan bahasa yang sopan dan tidak mengandung unsur SARA dan/atau pornografi.</li>
                                                                                                                                                                                <li>Memberikan informasi aduan yang faktual dan lengkap saat mengisi formulir.</li>
                                                                                                                                                                                <li>Menjaga, memantau, dan memberikan respons secara berkala terkait dengan aduan yang sudah dikirimkan.</li>
                                                                                                                                                                                <li>Tidak menggunakan website dengan cara yang merusak, melumpuhkan, membebani, atau mengganggu server/jaringan.</li>
                                                                                                                                                                                <li>Tidak melakukan akses ilegal melalui peretasan (hacking), password mining, atau cara lainnya.</li>
                                                                                                                                                                            </ul>

                                                                                                                                                                            Kami akan bekerja sama dengan pejabat penegak hukum atau perintah pengadilan terkait pengungkapan identitas pengguna.

                                                                                                                                                                            <br><br>
                                                                                                                                                                            Adapun kewenangan kami selaku pengelola:
                                                                                                                                                                            <ul class="list-disc list-inside space-y-1 mt-2">
                                                                                                                                                                                <li>Kami akan merespons aduan melalui Satuan Kerja (OPD) yang berwenang.</li>
                                                                                                                                                                                <li>OPD terkait akan melakukan tindak lanjut terhadap aduan yang Anda kirimkan.</li>
                                                                                                                                                                            </ul>
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Jenis Aduan',
                        'content' => '
                                                                                                                                                                            Beberapa jenis aduan di website E-Lapor DIY adalah:
                                                                                                                                                                            <ul class="list-disc list-inside space-y-1 mt-2">
                                                                                                                                                                                <li><span class="font-semibold">Umum</span> – aduan dapat diakses dan dilihat oleh pengunjung lain.</li>
                                                                                                                                                                                <li><span class="font-semibold">Anonim</span> – aduan dikirim tanpa identitas pengirim.</li>
                                                                                                                                                                                <li><span class="font-semibold">Rahasia</span> – aduan hanya dapat diakses oleh pihak berwenang, tidak ditampilkan ke publik.</li>
                                                                                                                                                                            </ul>
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Kendala Teknis',
                        'content' => '
                                                                                                                                                                            Jika saat login Anda diarahkan ke halaman "Page Expired 404", langkah yang harus dilakukan:
                                                                                                                                                                            <ul class="list-decimal list-inside space-y-1 mt-2">
                                                                                                                                                                                <li>Tekan <kbd>Ctrl + Shift + R</kbd> untuk clear cache browser.</li>
                                                                                                                                                                                <li>Clear cache browser secara menyeluruh melalui menu <i>Clear Browsing Data</i> → pilih <b>All Time</b>.</li>
                                                                                                                                                                                <li>Jika masih bermasalah, coba gunakan browser lain.</li>
                                                                                                                                                                                <li>Hubungi Admin untuk bantuan lebih lanjut.</li>
                                                                                                                                                                            </ul>
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Pemblokiran atau Penghapusan Akun',
                        'content' => '
                                                                                                                                                                            Kami berhak untuk memblokir dan menghapus akun pengguna yang terindikasi melakukan pelanggaran
                                                                                                                                                                            terhadap syarat dan ketentuan, atau yang mengganggu stabilitas website E-Lapor DIY.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Pengawasan',
                        'content' => '
                                                                                                                                                                            Kami memiliki kewajiban untuk memeriksa aduan yang dikirimkan dan berhak mengarsipkan data
                                                                                                                                                                            yang berciri sebagai spam.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Kebijakan Privasi',
                        'content' => '
                                                                                                                                                                            Kami berkomitmen menjaga kerahasiaan data pribadi sesuai dengan kebijakan privasi yang berlaku.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Kontak Kami',
                        'content' => '
                                                                                                                                                                            Untuk pertanyaan atau umpan balik, silakan hubungi kami melalui halaman <b>Kontak Kami</b> pada website E-Lapor DIY.
                                                                                                                                                                        ',
                    ],
                    [
                        'title' => 'Gagal Login',
                        'content' => '
                                                                                                                                                                            Jika mengalami kendala saat login, silakan hubungi <b>Help Desk</b> kami melalui WhatsApp.
                                                                                                                                                                            Tim kami siap memberikan solusi terbaik dan membantu Anda mengatasi masalah login dengan cepat.
                                                                                                                                                                        ',
                    ],
                ];
            @endphp

            @foreach ($items as $index => $item)
                <div class="border rounded-lg shadow-sm overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-5 py-4 text-left 
                               bg-red-800 text-white font-semibold text-lg sm:text-xl hover:bg-red-900 transition">
                        <span>{{ $item['title'] }}</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition
                        class="px-5 py-4 text-gray-700 text-lg sm:text-xl bg-gray-100 border-t border-gray-200 space-y-1 leading-relaxed">
                        {!! $item['content'] !!}
                    </div>
                </div>
            @endforeach 

        </div>
    </div>
@endsection