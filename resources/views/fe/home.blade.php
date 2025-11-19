@php
use Illuminate\Support\Str;
@endphp

@extends('fe.master')

@section('title', 'Desa Arborek Papua')

@section('content')

<!-- Hero Section -->
<section id="home" class="hero section dark-background">
    <img src="{{ asset('fe/assets/img/arborek2.jpeg') }}" alt="" data-aos="fade-in">
    <div class="container d-flex flex-column align-items-center">
        <h2 data-aos="fade-up" data-aos-delay="100">Desa ARBOREK</h2>
        <p data-aos="fade-up" data-aos-delay="200">Desa Wisata</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
            <a href="#about" class="btn-get-started">Get Started</a>
            <a href="https://youtu.be/RF660LcsuDQ?si=h6ebnfhU2zItmcJx" class="glightbox btn-watch-video d-flex align-items-center">
                <i class="bi bi-play-circle"></i><span>Watch Video</span></a>
        </div>
    </div>
</section>
<!-- /Hero Section -->

<!-- Wisata Section -->
<section id="wisata" class="services section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Wisata</h2>
        <p>Wisata Desa Arborek</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
            @forelse($obyekWisatas as $wisata)
            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="service-item">
                    <div class="img">
                        @php
                        $foto = $wisata->foto1 ?? $wisata->foto2 ?? $wisata->foto3 ?? $wisata->foto4 ?? $wisata->foto5;
                        @endphp
                        <img src="{{ $foto ? asset('storage/' . $foto) : asset('fe/assets/img/default-wisata.jpg') }}"
                            class="img-fluid"
                            alt="{{ $wisata->nama_wisata }}">
                    </div>
                    <div class="details position-relative">
                        <div class="icon"><i class="bi bi-activity"></i></div>
                        <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal"
                            data-bs-target="#modalWisata{{ $wisata->id }}">
                            <h3>{{ $wisata->nama_wisata }}</h3>
                        </a>
                        <p>{{ Str::limit($wisata->deskripsi_wisata, 100) }}</p>
                        <p><b>Kategori:</b> {{ $wisata->kategoriWisata->kategori_wisata ?? '-' }}</p>
                        <p><b>Fasilitas:</b> {{ Str::limit($wisata->fasilitas, 50) }}</p>
                    </div>
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="modalWisata{{ $wisata->id }}">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $wisata->nama_wisata }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ $foto ? asset('storage/' . $foto) : asset('fe/assets/img/default-wisata.jpg') }}"
                                class="img-fluid rounded mb-3">

                            <p><b>Kategori:</b> {{ $wisata->kategoriWisata->kategori_wisata ?? '-' }}</p>
                            <p><b>Deskripsi:</b> {{ $wisata->deskripsi_wisata }}</p>
                            <p><b>Fasilitas:</b> {{ $wisata->fasilitas }}</p>

                            @for($i=1; $i<=5; $i++)
                                @if($wisata->{'foto'.$i})
                                <img src="{{ asset('storage/' . $wisata->{'foto'.$i}) }}"
                                    class="img-thumbnail me-1 mb-1" width="60">
                                @endif
                                @endfor
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Belum ada wisata.</p>
            @endforelse
        </div>
    </div>

</section>
<!-- /Wisata Section -->

<!-- Paket Wisata Section -->
<section id="paket_wisata" class="services section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Activity</h2>
        <p>Wisata Desa Arborek</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
            @forelse($paketWisatas as $paket)
            <div class="col-xl-4 col-md-6" data-aos="zoom-in">
                <div class="service-item">
                    <div class="img">
                        @php
                        $foto = $paket->foto1 ?? $paket->foto2 ?? $paket->foto3 ?? $paket->foto4 ?? $paket->foto5;
                        @endphp
                        <img src="{{ $foto ? asset('storage/' . $foto) : asset('fe/assets/img/default-wisata.jpg') }}" class="img-fluid">
                    </div>

                    <div class="details position-relative">
                        <div class="icon"><i class="bi bi-activity"></i></div>
                        <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#modalPaket{{ $paket->id }}">
                            <h3>{{ $paket->nama_paket }}</h3>
                        </a>

                        <p>{{ Str::limit($paket->deskripsi,100) }}</p>
                        <p><b>Fasilitas:</b> {{ Str::limit($paket->fasilitas,50) }}</p>
                        <p>Harga mulai Rp{{ number_format($paket->harga_per_pack,0,',','.') }}/orang</p>
                    </div>
                </div>
            </div>

            {{-- Modal Paket --}}
            <div class="modal fade" id="modalPaket{{ $paket->id }}">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>{{ $paket->nama_paket }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ $foto ? asset('storage/' . $foto) : asset('fe/assets/img/default-wisata.jpg') }}"
                                class="img-fluid rounded mb-3">

                            <p><b>Deskripsi:</b> {{ $paket->deskripsi }}</p>
                            <p><b>Fasilitas:</b> {{ $paket->fasilitas }}</p>
                            <p><b>Harga:</b> Rp{{ number_format($paket->harga_per_pack,0,',','.') }}/orang</p>

                            @for($i=1;$i<=5;$i++)
                                @if($paket->{'foto'.$i})
                                <img src="{{ asset('storage/' . $paket->{'foto'.$i}) }}" width="60" class="img-thumbnail me-1 mb-1">
                                @endif
                                @endfor
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Belum ada paket wisata.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Penginapan Section -->
<section id="penginapan" class="services section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Penginapan</h2>
        <p>Penginapan Desa Arborek</p>
    </div>

    <div class="container">
        <div class="row gy-5">
            @forelse($penginapans as $penginapan)
            @php
            $foto = $penginapan->foto1 ?? $penginapan->foto2 ?? $penginapan->foto3 ?? $penginapan->foto4 ?? $penginapan->foto5;
            @endphp

            <div class="col-xl-4 col-md-6">
                <div class="service-item">
                    <div class="img">
                        <img src="{{ $foto ? asset('storage/' . $foto) : asset('fe/assets/img/default-penginapan.jpg') }}"
                            class="img-fluid">
                    </div>

                    <div class="details position-relative">
                        <div class="icon"><i class="bi bi-house-door"></i></div>
                        <a href="#" class="stretched-link" data-bs-toggle="modal"
                            data-bs-target="#modalPenginapan{{ $penginapan->id }}">
                            <h3>{{ $penginapan->nama_penginapan }}</h3>
                        </a>

                        <p>{{ Str::limit($penginapan->deskripsi,100) }}</p>
                        <p><b>Fasilitas:</b> {{ Str::limit($penginapan->fasilitas,50) }}</p>
                    </div>
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="modalPenginapan{{ $penginapan->id }}">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>{{ $penginapan->nama_penginapan }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <img id="mainPenginapanImage{{ $penginapan->id }}"
                                src="{{ $foto ? asset('storage/' . $foto) : asset('fe/assets/img/default-penginapan.jpg') }}"
                                class="img-fluid rounded mb-3">

                            @for($i=1;$i<=5;$i++)
                                @if($penginapan->{'foto'.$i})
                                <img src="{{ asset('storage/' . $penginapan->{'foto'.$i}) }}"
                                    data-src="{{ asset('storage/' . $penginapan->{'foto'.$i}) }}"
                                    data-target="#mainPenginapanImage{{ $penginapan->id }}"
                                    width="60"
                                    class="img-thumbnail me-1 mb-1">
                                @endif
                                @endfor

                                <p><b>Deskripsi:</b> {{ $penginapan->deskripsi }}</p>
                                <p><b>Fasilitas:</b> {{ $penginapan->fasilitas }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Belum ada penginapan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Berita Section -->
<section id="berita" class="services section light-background">

    <div class="container section-title" data-aos="fade-up">
        <h2>Berita</h2>
        <p>Berita Tentang Kita</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @forelse($beritas as $berita)
            <div class="col-md-6">
                <div class="service-item d-flex position-relative h-100">

                    @if($berita->foto)
                    <img src="{{ asset('storage/' . $berita->foto) }}"
                        class="img-fluid me-3"
                        style="width: 100px; height:100px; object-fit:cover;">
                    @else
                    <i class="bi bi-newspaper icon"></i>
                    @endif

                    <div>
                        <h4>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalBerita{{ $berita->id }}">
                                {{ $berita->judul }}
                            </a>
                        </h4>

                        <p>{{ Str::limit($berita->berita,150) }}</p>

                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($berita->tgl_post)->format('d M Y') }}
                        </small>
                    </div>

                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="modalBerita{{ $berita->id }}">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>{{ $berita->judul }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            @if($berita->foto)
                            <img src="{{ asset('storage/' . $berita->foto) }}" class="img-fluid mb-3">
                            @endif

                            <p class="text-muted">
                                <i class="bi bi-calendar"></i>
                                {{ \Carbon\Carbon::parse($berita->tgl_post)->format('l, d F Y') }}
                            </p>

                            <p><b>Kategori:</b> {{ $berita->kategoriBerita->kategori_berita ?? '-' }}</p>

                            <div>{!! nl2br(e($berita->berita)) !!}</div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Belum ada berita.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Reservasi Section / Contact -->
<section id="reservasi" class="contact section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Kontak Kami</p>
    </div>

    <div class="container">
        <div class="row gy-4">

            <div class="col-lg-6">

                <div class="info-item d-flex flex-column align-items-center mb-3">
                    <i class="bi bi-geo-alt"></i>
                    <h3>Alamat</h3>
                    <p>Jalan Dokter Semeru, Bogor Tengah, Jawa Barat</p>
                </div>

                <div class="info-item d-flex flex-column align-items-center mb-3">
                    <i class="bi bi-telephone"></i>
                    <h3>Hubungi</h3>
                    <p>(0251) 8350544</p>
                </div>

                <div class="info-item d-flex flex-column align-items-center">
                    <i class="bi bi-envelope"></i>
                    <h3>Email</h3>
                    <p>Ghina@gmail.com</p>
                </div>

            </div>

            <div class="col-lg-6">
                <form action="#" method="post" class="php-email-form">
                    <div class="row gy-4">

                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Your Name" required>
                        </div>

                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Your Email" required>
                        </div>

                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Subject" required>
                        </div>

                        <div class="col-md-12">
                            <textarea class="form-control" rows="4" placeholder="Message" required></textarea>
                        </div>

                        <div class="col-md-12 text-center">
                            <button type="submit">Send Message</button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>

</section>

@endsection