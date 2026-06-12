@extends('layouts.app')
@section('title', 'Pembayaran')

@push('styles')
<style>
  .navbar { display: none; }
  .footer { display: none; }

  /* WA Button */
  .btn-wa {
    background: #25D366;
    color: white;
    border-color: #25D366;
    font-size: 16px;
    padding: 16px 24px;
    border-radius: var(--r-full);
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 600;
    transition: background .2s ease;
    cursor: pointer;
    border: none;
    font-family: var(--font-body);
  }
  .btn-wa:hover { background: #1ebe5d; }
  .btn-wa svg { flex-shrink: 0; }

  /* Info WA box */
  .wa-info-box {
    background: #f0fdf4;
    border: 1px solid #86efac;
    border-radius: var(--r-lg);
    padding: 16px;
    font-size: 13px;
    color: #166534;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 16px;
  }
  .wa-info-box .wa-icon { font-size: 18px; flex-shrink: 0; }

  /* Required star */
  .req { color: var(--danger); margin-left: 2px; }

  /* Validation error */
  .field-error {
    font-size: 12px;
    color: var(--danger);
    margin-top: 4px;
    display: none;
  }
  .form-control.invalid { border-color: var(--danger); }
</style>
@endpush

@section('content')
<!-- Checkout Nav -->
<nav class="checkout-nav">
  <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:8px;font-family:var(--font-display);font-size:1.2rem">
    <span style="color:var(--primary)">&#9670;</span> KalaFabrics
  </a>
  <div class="checkout-steps">
    <div class="step completed">
      <div class="step-dot">✓</div>
      <span>Keranjang</span>
    </div>
    <div class="step-line done"></div>
    <div class="step active">
      <div class="step-dot">2</div>
      <span>Pembayaran</span>
    </div>
    <div class="step-line"></div>
    <div class="step">
      <div class="step-dot">3</div>
      <span>Konfirmasi via WA</span>
    </div>
  </div>
  <div></div>
</nav>

<!-- Main -->
<div style="padding:40px 0;background:var(--bg);min-height:calc(100vh - var(--nav-h))">
  <div class="container">
    <h2 style="margin-bottom:8px">Pembayaran</h2>
    <p style="margin-bottom:32px;color:var(--text-muted)">Isi data pengiriman Anda, lalu klik <strong>Buat Pesanan</strong> untuk menghubungi admin via WhatsApp.</p>

    <div class="checkout-layout">

      <!-- LEFT: Form -->
      <div>

        <!-- Informasi Pengiriman -->
        <div class="checkout-section">
          <h3>🚚 Informasi Pengiriman</h3>

          <div class="form-group">
            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
            <input type="text" id="inp-nama" class="form-control" placeholder="Masukkan nama lengkap Anda">
            <div class="field-error" id="err-nama">Nama lengkap wajib diisi.</div>
          </div>

          <div class="form-group">
            <label class="form-label">Nomor WhatsApp Anda <span class="req">*</span></label>
            <input type="tel" id="inp-wa" class="form-control" placeholder="Contoh: 081345162892">
            <div class="field-error" id="err-wa">Nomor WhatsApp wajib diisi.</div>
          </div>

          <div class="form-group">
            <label class="form-label">Alamat Lengkap <span class="req">*</span></label>
            <input type="text" id="inp-alamat" class="form-control" placeholder="Nama jalan, nomor rumah, RT/RW">
            <div class="field-error" id="err-alamat">Alamat lengkap wajib diisi.</div>
          </div>

          <div class="input-row">
            <div class="form-group">
              <label class="form-label">Kota <span class="req">*</span></label>
              <input type="text" id="inp-kota" class="form-control" placeholder="Nama kota">
              <div class="field-error" id="err-kota">Kota wajib diisi.</div>
            </div>
            <div class="form-group">
              <label class="form-label">Kode Pos</label>
              <input type="text" id="inp-kodepos" class="form-control" placeholder="Kode pos">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Catatan Pesanan <span style="color:var(--text-light);font-weight:400">(opsional)</span></label>
            <input type="text" id="inp-catatan" class="form-control" placeholder="Misal: warna pilihan, ukuran, dll.">
          </div>
        </div>

        <!-- Metode Pengiriman -->
        <div class="checkout-section">
          <h3>📦 Metode Pengiriman</h3>
          <div class="delivery-option selected" id="del-standar" onclick="selectDelivery(this, 25000)">
            <div class="delivery-radio"></div>
            <div class="delivery-info">
              <h4>Pengiriman Standar (Bebas Karbon)</h4>
              <p>Estimasi 3-5 hari kerja. Diimbangi dengan proyek penanaman pohon.</p>
            </div>
            <div class="delivery-price">Rp 25.000</div>
          </div>
          <div class="delivery-option" id="del-ekspres" onclick="selectDelivery(this, 45000)">
            <div class="delivery-radio"></div>
            <div class="delivery-info">
              <h4>Pengiriman Ekspres</h4>
              <p>Estimasi 1-2 hari kerja.</p>
            </div>
            <div class="delivery-price">Rp 45.000</div>
          </div>
        </div>

      </div>

      <!-- RIGHT: Ringkasan + WA Button -->
      <div>
        <div class="order-summary" style="margin-bottom:20px">
          <h3>Ringkasan Pesanan</h3>

          <!-- Daftar produk diisi JS -->
          <div id="checkout-items"></div>

          <div class="divider"></div>

          <div class="order-line">
            <span>Subtotal</span>
            <span id="co-subtotal">Rp 0</span>
          </div>
          <div class="order-line">
            <span>Biaya Pengiriman</span>
            <span id="co-shipping">Rp 25.000</span>
          </div>

          <div class="order-total">
            <span>Total</span>
            <span id="co-total">Rp 0</span>
          </div>

          <!-- Info WA -->
          <div class="wa-info-box">
            <span class="wa-icon">💬</span>
            <span>Setelah klik <strong>Buat Pesanan</strong>, Anda akan diarahkan ke WhatsApp Admin dengan detail pesanan yang sudah terisi otomatis.</span>
          </div>

          <!-- Tombol WA -->
          <button class="btn-wa" onclick="buatPesananWA()">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Buat Pesanan via WhatsApp
          </button>

          <a href="{{ route('cart') }}" class="btn btn-secondary btn-block" style="margin-top:10px">← Kembali ke Keranjang</a>
        </div>

        <!-- Impact Box -->
        <div class="impact-box-dark">
          <h4>🌱 Dampak Pesanan Anda</h4>
          <p>Dengan memilih produk sirkular, pesanan ini berkontribusi pada lingkungan:</p>
          <div class="impact-stats">
            <div class="impact-stat">
              <div class="val">1.15<small style="font-size:1rem">kg</small></div>
              <div class="lbl">Limbah diselamatkan</div>
            </div>
            <div class="impact-stat">
              <div class="val">450<small style="font-size:1rem">L</small></div>
              <div class="lbl">Air dihemat</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // =============================================
  // GANTI NOMOR WA ADMIN DI SINI
  // =============================================
  var WA_ADMIN = '6282150888442'; // format: 62xxxxxxxxxx (tanpa + atau 0 di depan)
  // =============================================

  var shippingCost = 25000;
  var cartData     = [];

  function formatRupiah(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
  }

  /* ---------- Load data dari sessionStorage (diisi oleh cart.blade.php) ---------- */
  function loadCartData() {
    var raw = sessionStorage.getItem('kala_cart');
    if (raw) {
      cartData = JSON.parse(raw);
    } else {
      // Fallback demo jika langsung buka halaman checkout
      cartData = [
        { name: 'Upcycled Patchwork Tote Bag', price: 250000, qty: 1 },
        { name: 'Recycled Textile Coaster Set', price: 85000,  qty: 2 }
      ];
    }
    renderItems();
    recalcTotal();
  }

  /* ---------- Render daftar produk di ringkasan ---------- */
  function renderItems() {
    var container = document.getElementById('checkout-items');
    container.innerHTML = '';
    cartData.forEach(function(item) {
      var lineTotal = item.price * item.qty;
      var div = document.createElement('div');
      div.className = 'order-item';
      div.innerHTML =
        '<div class="order-item-info" style="flex:1">' +
          '<div class="order-item-name">' + item.name + '</div>' +
          '<div class="order-item-qty">Qty: ' + item.qty + '</div>' +
        '</div>' +
        '<div class="order-item-price">' + formatRupiah(lineTotal) + '</div>';
      container.appendChild(div);
    });
  }

  /* ---------- Hitung total ---------- */
  function recalcTotal() {
    var subtotal = 0;
    cartData.forEach(function(item) { subtotal += item.price * item.qty; });
    var total = subtotal + shippingCost;

    document.getElementById('co-subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('co-shipping').textContent = formatRupiah(shippingCost);
    document.getElementById('co-total').textContent    = formatRupiah(total);
  }

  /* ---------- Pilih metode pengiriman ---------- */
  function selectDelivery(el, cost) {
    document.querySelectorAll('.delivery-option').forEach(function(o) { o.classList.remove('selected'); });
    el.classList.add('selected');
    shippingCost = cost;
    recalcTotal();
  }

  /* ---------- Validasi form ---------- */
  function validateForm() {
    var valid = true;
    var fields = [
      { id: 'inp-nama',   err: 'err-nama'   },
      { id: 'inp-wa',     err: 'err-wa'     },
      { id: 'inp-alamat', err: 'err-alamat' },
      { id: 'inp-kota',   err: 'err-kota'   }
    ];
    fields.forEach(function(f) {
      var inp  = document.getElementById(f.id);
      var errEl = document.getElementById(f.err);
      if (!inp.value.trim()) {
        inp.classList.add('invalid');
        errEl.style.display = 'block';
        valid = false;
      } else {
        inp.classList.remove('invalid');
        errEl.style.display = 'none';
      }
    });
    return valid;
  }

  /* ---------- Buat Pesanan → Redirect WhatsApp ---------- */
  function buatPesananWA() {
    if (!validateForm()) {
      // Scroll ke field pertama yang error
      var firstErr = document.querySelector('.form-control.invalid');
      if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    var nama     = document.getElementById('inp-nama').value.trim();
    var noWA     = document.getElementById('inp-wa').value.trim();
    var alamat   = document.getElementById('inp-alamat').value.trim();
    var kota     = document.getElementById('inp-kota').value.trim();
    var kodepos  = document.getElementById('inp-kodepos').value.trim();
    var catatan  = document.getElementById('inp-catatan').value.trim();

    // Hitung subtotal & total
    var subtotal = 0;
    cartData.forEach(function(item) { subtotal += item.price * item.qty; });
    var total = subtotal + shippingCost;

    // --- Susun template pesan WA ---
    var metodeKirim = shippingCost === 25000
      ? 'Standar (Bebas Karbon) - Rp 25.000'
      : 'Ekspres - Rp 45.000';

    var daftarProduk = '';
    cartData.forEach(function(item, i) {
      var lineTotal = item.price * item.qty;
      daftarProduk +=
        (i + 1) + '. ' + item.name + '\n' +
        '   Qty    : ' + item.qty + '\n' +
        '   Harga  : ' + formatRupiah(item.price) + ' / item\n' +
        '   Subtotal: ' + formatRupiah(lineTotal) + '\n\n';
    });

    var pesan =
      '🌿 *PESANAN BARU - KalaFabrics* 🌿\n' +
      '━━━━━━━━━━━━━━━━━━━━\n\n' +
      '📦 *DETAIL PESANAN*\n\n' +
      daftarProduk +
      '━━━━━━━━━━━━━━━━━━━━\n' +
      '🚚 Metode Kirim : ' + metodeKirim + '\n' +
      '💰 Subtotal     : ' + formatRupiah(subtotal) + '\n' +
      '🚚 Ongkir       : ' + formatRupiah(shippingCost) + '\n' +
      '💵 *TOTAL BAYAR : ' + formatRupiah(total) + '*\n' +
      '━━━━━━━━━━━━━━━━━━━━\n\n' +
      '👤 *DATA PENGIRIMAN*\n' +
      'Nama    : ' + nama + '\n' +
      'No. WA  : ' + noWA + '\n' +
      'Alamat  : ' + alamat + '\n' +
      'Kota    : ' + kota + (kodepos ? ' ' + kodepos : '') + '\n' +
      (catatan ? 'Catatan : ' + catatan + '\n' : '') +
      '\nMohon konfirmasi pesanan ini. Terima kasih! 🙏';

    // Encode pesan untuk URL
    var pesanEncoded = encodeURIComponent(pesan);
    var waURL = 'https://wa.me/' + WA_ADMIN + '?text=' + pesanEncoded;

    // Buka WhatsApp di tab baru
    window.open(waURL, '_blank');
  }

  // Init saat halaman dimuat
  loadCartData();
</script>
@endpush
