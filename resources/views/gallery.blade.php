@extends('layouts.app')

@section('title', 'Galeri Kegiatan & Dokumentasi — PGRI (Persatuan Guru Republik Indonesia)')

@section('content')
<!-- HEADER SECTION -->
<div class="text-white py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #991b1b 50%, #dc2626 100%);">
    <div class="container py-4 text-center position-relative" style="z-index: 2;">
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold mb-3 shadow-sm">
            <i class="fa-solid fa-camera-retro me-1"></i> DOKUMENTASI RESMI &amp; FOTO KEGIATAN
        </span>
        <h1 class="display-5 fw-extrabold text-white tracking-tight mb-3">Galeri Dokumentasi PGRI</h1>
        <p class="lead opacity-90 mx-auto mb-0" style="max-width: 760px; font-size: 1.05rem;">
            Kumpulan foto sampul dan dokumentasi lengkap dari berbagai agenda: Konferensi Kerja, Workshop &amp; Diklat Profesi, Peringatan Hari Guru Nasional, serta Aksi Kemanusiaan PGRI di seluruh Indonesia.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- CATEGORY FILTER TABS -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        @foreach($categories as $key => $label)
        <a href="{{ route('gallery.index', ['category' => $key]) }}" class="btn btn-sm rounded-pill px-4 py-2 fw-bold transition {{ request('category', 'all') == $key ? 'btn-danger shadow' : 'btn-outline-secondary bg-white text-secondary' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <!-- GALLERY GRID -->
    <div class="row g-4 mb-5">
        @forelse($galleries as $gallery)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 bg-white border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-col justify-content-between transition-all hover-shadow" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                
                <!-- Image Container with Cover & Badges -->
                <div class="position-relative overflow-hidden cursor-pointer" onclick='openPublicGalleryModal(@json($gallery))' style="cursor: pointer;">
                    <img src="{{ $gallery->cover_photo }}" class="card-img-top object-fit-cover w-100" alt="{{ $gallery->title }}" style="height: 250px; transition: transform 0.5s ease;" onerror="this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800'">
                    
                    <!-- Kategori Badge -->
                    <span class="badge bg-danger bg-opacity-95 rounded-pill position-absolute top-0 end-0 m-3 px-3 py-2 shadow-sm font-monospace text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                        {{ $gallery->category ?? 'Kegiatan PGRI' }}
                    </span>

                    <!-- Jumlah Foto Badge -->
                    <span class="badge bg-dark bg-opacity-80 rounded-pill position-absolute bottom-0 start-0 m-3 px-3 py-2 shadow-sm d-flex align-items-center gap-1.5" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-images text-warning"></i>
                        <span>{{ $gallery->photos_count }} Foto</span>
                    </span>

                    <!-- Hover Overlay Button -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-40 opacity-0 hover-opacity-100 d-flex align-items-center justify-center transition" style="backdrop-filter: blur(2px);">
                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 py-1-5 fw-bold shadow">
                            <i class="fa-solid fa-magnifying-glass-plus me-1 text-danger"></i> Lihat Dokumentasi
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Meta Date & Location -->
                        <div class="d-flex align-items-center gap-2 small text-muted mb-2" style="font-size: 0.8rem;">
                            <span><i class="fa-regular fa-calendar-check me-1 text-danger"></i> {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '-' }}</span>
                            <span>•</span>
                            <span class="text-truncate" style="max-width: 160px;"><i class="fa-solid fa-location-dot me-1 text-warning"></i> {{ $gallery->location ?? 'Indonesia' }}</span>
                        </div>

                        <!-- Title -->
                        <h5 class="fw-bold text-dark mb-2 lh-base cursor-pointer" onclick='openPublicGalleryModal(@json($gallery))' style="font-size: 1.05rem; cursor: pointer;">
                            {{ $gallery->title }}
                        </h5>

                        <!-- Description -->
                        <p class="text-secondary small mb-3 leading-relaxed" style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $gallery->description ?? 'Dokumentasi kegiatan resmi Pengurus dan Anggota Persatuan Guru Republik Indonesia.' }}
                        </p>
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                        <span class="text-muted extra-small" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-camera text-secondary me-1"></i> Album Dokumentasi
                        </span>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" onclick='openPublicGalleryModal(@json($gallery))' style="font-size: 0.78rem;">
                            <span>Buka Foto</span>
                            <i class="fa-solid fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted fs-1 mb-3"><i class="fa-solid fa-images text-danger opacity-50"></i></div>
            <h4 class="fw-bold text-dark">Belum Ada Dokumentasi Foto</h4>
            <p class="text-muted small">Silakan pilih kategori lain atau periksa kembali di lain waktu.</p>
            <a href="{{ route('gallery.index') }}" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold mt-2">
                Lihat Semua Kegiatan
            </a>
        </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center">
        {{ $galleries->links() }}
    </div>
</div>

<!-- MODAL LIGHTBOX VIEW PUBLIC GALLERY -->
<div class="modal fade" id="publicGalleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden">
            
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white border-0 px-4 py-3">
                <div class="d-flex flex-column">
                    <span id="modalCategoryBadge" class="badge bg-danger rounded-pill px-3 py-1 font-monospace text-uppercase align-self-start mb-1" style="font-size: 0.7rem;">
                        Kategori
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0" id="modalTitle">Judul Kegiatan</h5>
                    <div class="small text-white-50 mt-1" id="modalMeta">
                        <i class="fa-regular fa-calendar-check me-1 text-danger"></i> <span id="modalDate">-</span>
                        <span class="mx-2">•</span>
                        <i class="fa-solid fa-location-dot me-1 text-warning"></i> <span id="modalLocation">-</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4 bg-light">
                <!-- Foto Utama Terpilih -->
                <div class="position-relative bg-black rounded-3 overflow-hidden d-flex align-items-center justify-center mb-4 shadow" style="min-height: 380px; max-height: 520px;">
                    <img id="modalMainImage" src="" alt="Dokumentasi Terpilih" class="img-fluid rounded" style="max-height: 520px; object-fit: contain;">
                    
                    <!-- Navigation Buttons -->
                    <button type="button" onclick="prevModalPhoto()" class="btn btn-dark bg-opacity-60 border-0 rounded-circle position-absolute start-0 top-50 translate-middle-y ms-3 d-flex align-items-center justify-center shadow" style="width: 44px; height: 44px; z-index: 5;">
                        <i class="fa-solid fa-chevron-left text-white"></i>
                    </button>
                    <button type="button" onclick="nextModalPhoto()" class="btn btn-dark bg-opacity-60 border-0 rounded-circle position-absolute end-0 top-50 translate-middle-y me-3 d-flex align-items-center justify-center shadow" style="width: 44px; height: 44px; z-index: 5;">
                        <i class="fa-solid fa-chevron-right text-white"></i>
                    </button>

                    <!-- Foto Indicator Badge -->
                    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3 bg-black bg-opacity-75 text-white px-3 py-1 rounded-pill small fw-bold shadow">
                        Foto <span id="modalCurrentIndex">1</span> dari <span id="modalTotalCount">1</span>
                    </div>
                </div>

                <!-- Deskripsi Kegiatan -->
                <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white">
                    <h6 class="fw-bold text-dark mb-1 small text-uppercase tracking-wider">Keterangan Kegiatan</h6>
                    <p id="modalDescription" class="text-secondary small mb-0 leading-relaxed">
                        Deskripsi lengkap...
                    </p>
                </div>

                <!-- Strip Thumbnail Foto Dokumentasi -->
                <div>
                    <h6 class="fw-bold text-dark mb-2 small text-uppercase tracking-wider d-flex justify-content-between align-items-center">
                        <span>Pilihan Foto Dokumentasi</span>
                        <span class="text-muted fw-normal font-monospace" style="font-size: 0.75rem;">Klik thumbnail untuk memperbesar</span>
                    </h6>
                    <div id="modalThumbnailsGrid" class="d-flex flex-wrap gap-2 p-2 bg-white rounded-3 border">
                        <!-- Thumbnails injected via JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-white border-top px-4 py-2-5 justify-content-between">
                <span class="text-muted small">
                    <i class="fa-solid fa-shield-halved text-danger me-1"></i> Dokumentasi Resmi Persatuan Guru Republik Indonesia
                </span>
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4 fw-bold" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 30px rgba(0, 0, 0, 0.1) !important;
}
.hover-opacity-100:hover {
    opacity: 1 !important;
}
.cursor-pointer {
    cursor: pointer;
}
.thumb-btn {
    width: 68px;
    height: 68px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #e2e8f0;
    cursor: pointer;
    padding: 0;
    background: #000;
    transition: all 0.2s ease;
}
.thumb-btn:hover, .thumb-btn.active {
    border-color: #dc2626;
    transform: scale(1.05);
}
.thumb-btn img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

<script>
let currentModalPhotos = [];
let currentPhotoIndex = 0;

function openPublicGalleryModal(gallery) {
    document.getElementById('modalTitle').innerText = gallery.title;
    document.getElementById('modalCategoryBadge').innerText = gallery.category || 'Kegiatan PGRI';
    
    const dateFormatted = gallery.event_date ? new Date(gallery.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-';
    document.getElementById('modalDate').innerText = dateFormatted;
    document.getElementById('modalLocation').innerText = gallery.location || 'Indonesia';
    document.getElementById('modalDescription').innerText = gallery.description || 'Dokumentasi kegiatan resmi Persatuan Guru Republik Indonesia.';

    // Prepare photos list
    let photos = [];
    if (Array.isArray(gallery.photos) && gallery.photos.length > 0) {
        photos = gallery.photos.filter(p => !!p);
    }
    if (photos.length === 0) {
        photos = [gallery.cover_image || gallery.image || 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800'];
    }

    currentModalPhotos = photos;
    currentPhotoIndex = 0;

    document.getElementById('modalTotalCount').innerText = currentModalPhotos.length;

    renderModalPhoto(0);
    renderModalThumbnails();

    const myModal = new bootstrap.Modal(document.getElementById('publicGalleryModal'));
    myModal.show();
}

function renderModalPhoto(index) {
    if (index < 0) index = currentModalPhotos.length - 1;
    if (index >= currentModalPhotos.length) index = 0;
    
    currentPhotoIndex = index;
    document.getElementById('modalMainImage').src = currentModalPhotos[index];
    document.getElementById('modalCurrentIndex').innerText = index + 1;

    // Update active thumbnail border
    document.querySelectorAll('.thumb-btn').forEach((btn, idx) => {
        if (idx === index) {
            btn.classList.add('active');
            btn.style.borderColor = '#dc2626';
        } else {
            btn.classList.remove('active');
            btn.style.borderColor = '#e2e8f0';
        }
    });
}

function prevModalPhoto() {
    renderModalPhoto(currentPhotoIndex - 1);
}

function nextModalPhoto() {
    renderModalPhoto(currentPhotoIndex + 1);
}

function renderModalThumbnails() {
    const grid = document.getElementById('modalThumbnailsGrid');
    grid.innerHTML = '';

    currentModalPhotos.forEach((photo, idx) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `thumb-btn ${idx === 0 ? 'active' : ''}`;
        btn.innerHTML = `<img src="${photo}" alt="Thumbnail ${idx + 1}">`;
        btn.onclick = () => renderModalPhoto(idx);
        grid.appendChild(btn);
    });
}

// Keyboard arrow navigation
document.addEventListener('keydown', function(e) {
    const modalEl = document.getElementById('publicGalleryModal');
    if (modalEl && modalEl.classList.contains('show')) {
        if (e.key === 'ArrowLeft') prevModalPhoto();
        if (e.key === 'ArrowRight') nextModalPhoto();
    }
});
</script>
@endsection
