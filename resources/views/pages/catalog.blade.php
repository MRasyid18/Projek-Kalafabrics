@extends('layouts.app')
@section('title', 'Katalog Produk')

@section('content')
<section style="padding:60px 0 40px">
  <div class="container">
    <div class="d-flex align-center justify-between" style="margin-bottom:32px">
      <div>
        <h1>Upcycled &amp; Recycled Catalog</h1>
        <p style="margin-top:12px;max-width:480px">Discover our curated collection of sustainable goods, thoughtfully crafted from repurposed textiles to minimise environmental impact without compromising on artisanal quality.</p>
      </div>
      <div>
        <input type="text" class="form-control-box" placeholder="🔍  Search catalog..." style="width:220px">
      </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
      <button class="filter-tab active">Semua</button>
      <button class="filter-tab">Upcycled Fashion</button>
      <button class="filter-tab">Recycled Craft</button>
      <button class="filter-tab">B2B Products</button>
      <button class="filter-tab">♻️ Tukar dengan Poin</button>
    </div>

    <!-- Products Grid -->
    <div class="products-grid">

      <div class="product-card">
        <div class="product-img">
          <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&q=80" alt="Tote Bag">
          <div class="product-clean-badge">✓ Clean Standard</div>
        </div>
        <div class="product-body">
          <div class="product-category">Upcycled Fashion</div>
          <div class="product-name">Upcycled Patchwork Tote Bag</div>
          <div class="product-price">Rp 240.000</div>
          <div class="product-save">● Saves 450g fabric waste</div>
          <div class="product-actions">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Tambah ke Keranjang</a>
            <a href="#" class="btn btn-secondary btn-block">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img">
          <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&q=80" alt="Apron">
          <div class="product-clean-badge">✓ Clean Standard</div>
        </div>
        <div class="product-body">
          <div class="product-category">B2B Products</div>
          <div class="product-name">Apron Custom Upcycled</div>
          <div class="product-price">Rp 180.000</div>
          <div class="product-save">● Saves 320g fabric waste</div>
          <div class="product-actions">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Tambah ke Keranjang</a>
            <a href="#" class="btn btn-secondary btn-block">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img">
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80" alt="Coaster">
        </div>
        <div class="product-body">
          <div class="product-category">Recycled Craft</div>
          <div class="product-name">Recycled Textile Coaster Set</div>
          <div class="product-price">Rp 80.000</div>
          <div class="product-save">● Saves 150g fabric waste</div>
          <div class="product-actions">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Tambah ke Keranjang</a>
            <a href="#" class="btn btn-secondary btn-block">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img">
          <img src="https://images.unsplash.com/photo-1606760227091-3dd870d97f1d?w=600&q=80" alt="Keychain">
        </div>
        <div class="product-body">
          <div class="product-category">Recycled Craft</div>
          <div class="product-name">Fabric Waste Keychain</div>
          <div class="product-price">Rp 40.000</div>
          <div class="product-save">● Saves 50g fabric waste</div>
          <div class="product-actions">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Tambah ke Keranjang</a>
            <a href="#" class="btn btn-secondary btn-block">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img">
          <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&q=80" alt="Wall Decor">
          <div class="product-clean-badge">✓ Clean Standard</div>
        </div>
        <div class="product-body">
          <div class="product-category">Recycled Craft</div>
          <div class="product-name">Recycled Wall Decor</div>
          <div class="product-price">Rp 310.000</div>
          <div class="product-save">● Saves 800g fabric waste</div>
          <div class="product-actions">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Tambah ke Keranjang</a>
            <a href="#" class="btn btn-secondary btn-block">Lihat Detail</a>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img">
          <img src="https://images.unsplash.com/photo-1565043666747-69f6646db940?w=600&q=80" alt="Cafe Ornament">
        </div>
        <div class="product-body">
          <div class="product-category">B2B Products</div>
          <div class="product-name">Café Ornament Set</div>
          <div class="product-price">Rp 120.000</div>
          <div class="product-save">● Saves 200g fabric waste</div>
          <div class="product-actions">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Tambah ke Keranjang</a>
            <a href="#" class="btn btn-secondary btn-block">Lihat Detail</a>
          </div>
        </div>
      </div>

    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button class="page-btn">&#8592;</button>
      <span class="page-info">1 / 4</span>
      <button class="page-btn">&#8594;</button>
    </div>
  </div>
</section>
@endsection
