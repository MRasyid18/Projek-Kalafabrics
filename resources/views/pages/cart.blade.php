@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<section style="padding:60px 0">
  <div class="container">
    <div style="margin-bottom:32px">
      <h1>Keranjang Belanja</h1>
      <p style="margin-top:8px">Tinjau pesanan Anda dan lanjutkan ke pembayaran.</p>
    </div>

    <div style="display:grid;grid-template-columns:1.4fr 1fr;gap:40px;align-items:start">

      <!-- Cart Items -->
      <div id="cart-items-wrapper">

        <div class="cart-item"
          data-name="Upcycled Patchwork Tote Bag"
          data-price="250000"
          data-qty="1">
          <div class="cart-item-img">
            <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?w=300&q=80" alt="Tote Bag">
          </div>
          <div class="cart-item-body">
            <div class="cart-item-name">Upcycled Patchwork Tote Bag</div>
            <div style="margin-bottom:14px">
              <span class="badge badge-light-green">♻️ Saves 850g of textile waste</span>
            </div>
            <div class="d-flex align-center justify-between">
              <div class="qty-control">
                <button class="qty-btn" data-action="minus">−</button>
                <span class="qty-value">1</span>
                <button class="qty-btn" data-action="plus">+</button>
              </div>
              <div style="text-align:right">
                <div class="text-sm text-muted item-unit-price">Rp 250.000 / item</div>
                <div style="font-weight:600" class="item-subtotal">Rp 250.000</div>
              </div>
            </div>
          </div>
          <button class="cart-remove" title="Hapus">×</button>
        </div>

        <div class="cart-item"
          data-name="Recycled Textile Coaster Set"
          data-price="85000"
          data-qty="2">
          <div class="cart-item-img">
            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=300&q=80" alt="Coaster">
          </div>
          <div class="cart-item-body">
            <div class="cart-item-name">Recycled Textile Coaster Set</div>
            <div style="margin-bottom:14px">
              <span class="badge badge-light-green">♻️ Saves 150g of textile waste</span>
            </div>
            <div class="d-flex align-center justify-between">
              <div class="qty-control">
                <button class="qty-btn" data-action="minus">−</button>
                <span class="qty-value">2</span>
                <button class="qty-btn" data-action="plus">+</button>
              </div>
              <div style="text-align:right">
                <div class="text-sm text-muted item-unit-price">Rp 85.000 / item</div>
                <div style="font-weight:600" class="item-subtotal">Rp 170.000</div>
              </div>
            </div>
          </div>
          <button class="cart-remove" title="Hapus">×</button>
        </div>

        <!-- Keranjang kosong -->
        <div id="empty-cart" style="display:none;text-align:center;padding:60px 20px">
          <div style="font-size:48px;margin-bottom:16px">🛒</div>
          <h3 style="margin-bottom:8px">Keranjang Anda kosong</h3>
          <p style="margin-bottom:24px">Belum ada produk yang ditambahkan.</p>
          <a href="{{ route('catalog') }}" class="btn btn-primary">Lihat Katalog</a>
        </div>

      </div>

      <!-- Order Summary -->
      <div class="order-summary" id="order-summary-box">
        <h3>Ringkasan Pesanan</h3>

        <div class="order-line">
          <span id="subtotal-label">Subtotal (2 produk)</span>
          <span id="subtotal-value">Rp 0</span>
        </div>
        <div class="order-line">
          <span>Estimasi Pengiriman</span>
          <span id="shipping-value">Rp 25.000</span>
        </div>

        <div class="order-total">
          <span>Total Harga</span>
          <span id="total-value">Rp 0</span>
        </div>

        <div class="impact-box">
          <span>♻️</span>
          <span>Dampak Positif: Anda menyelamatkan limbah tekstil dengan pesanan ini.</span>
        </div>

        <a href="{{ route('checkout') }}" class="btn btn-primary btn-block btn-lg" id="btn-checkout" style="margin-bottom:12px">
          Lanjut ke Pembayaran
        </a>
        <a href="{{ route('catalog') }}" class="btn btn-secondary btn-block">← Kembali Belanja</a>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  // Format Rupiah
  function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
  }

  // Hitung ulang semua total di keranjang
  function recalcCart() {
    var items = document.querySelectorAll('.cart-item');
    var subtotal = 0;
    var totalQty = 0;

    items.forEach(function(item) {
      var price = parseInt(item.dataset.price) || 0;
      var qty   = parseInt(item.dataset.qty)   || 1;
      var lineTotal = price * qty;

      // Update tampilan subtotal per item
      var subtotalEl = item.querySelector('.item-subtotal');
      if (subtotalEl) subtotalEl.textContent = formatRupiah(lineTotal);

      subtotal += lineTotal;
      totalQty += qty;
    });

    var shipping = 25000;
    var total    = subtotal + shipping;

    document.getElementById('subtotal-label').textContent  = 'Subtotal (' + totalQty + ' produk)';
    document.getElementById('subtotal-value').textContent  = formatRupiah(subtotal);
    document.getElementById('shipping-value').textContent  = formatRupiah(shipping);
    document.getElementById('total-value').textContent     = formatRupiah(total);

    // Tampilkan/sembunyikan empty state
    var emptyEl = document.getElementById('empty-cart');
    var summaryEl = document.getElementById('order-summary-box');
    var checkoutBtn = document.getElementById('btn-checkout');
    if (items.length === 0) {
      emptyEl.style.display = 'block';
      summaryEl.style.opacity = '0.4';
      summaryEl.style.pointerEvents = 'none';
    } else {
      emptyEl.style.display  = 'none';
      summaryEl.style.opacity = '1';
      summaryEl.style.pointerEvents = 'auto';
    }

    // Simpan data cart ke sessionStorage agar bisa dibaca di halaman checkout
    var cartData = [];
    items.forEach(function(item) {
      cartData.push({
        name:  item.dataset.name,
        price: parseInt(item.dataset.price),
        qty:   parseInt(item.dataset.qty)
      });
    });
    sessionStorage.setItem('kala_cart', JSON.stringify(cartData));
    sessionStorage.setItem('kala_shipping', shipping);
  }

  // Tombol + / -
  document.querySelectorAll('.qty-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var item = this.closest('.cart-item');
      var qty  = parseInt(item.dataset.qty) || 1;
      var action = this.dataset.action;

      if (action === 'minus') {
        if (qty > 1) qty--;
      } else {
        qty++;
      }

      item.dataset.qty = qty;
      item.querySelector('.qty-value').textContent = qty;
      recalcCart();
    });
  });

  // Tombol hapus item
  document.querySelectorAll('.cart-remove').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var item = this.closest('.cart-item');
      item.style.transition = 'opacity .3s ease, transform .3s ease';
      item.style.opacity    = '0';
      item.style.transform  = 'translateX(20px)';
      setTimeout(function() {
        item.remove();
        recalcCart();
      }, 300);
    });
  });

  // Init hitung saat halaman dibuka
  recalcCart();
</script>
@endpush
