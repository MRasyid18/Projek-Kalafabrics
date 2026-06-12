@extends('layouts.app')
@section('title', 'Ranger')

@section('content')
<section style="padding:60px 0;text-align:center">
  <div class="container">
    <h1>Program Ranger KalaFabrics</h1>
    <p style="max-width:540px;margin:16px auto 32px;font-size:15px">Jadilah agen perubahan di komunitasmu. Ranger KalaFabrics adalah relawan yang mengedukasi, mengumpulkan donasi limbah kain, dan mengorganisir kegiatan sosial lokal.</p>
    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Jadi Ranger</a>
  </div>
</section>

<section class="bg-alt">
  <div class="container">
    <div class="section-title">
      <h2>Leaderboard Ranger</h2>
      <p>Ranger terbaik bulan ini berdasarkan kontribusi dan aktivitas</p>
    </div>
    <div class="leaderboard-card" style="max-width:600px;margin:0 auto">
      <div class="leaderboard-header">Leaderboard Ranger — November 2024</div>
      <div class="leaderboard-row">
        <span class="lb-rank">🥇</span>
        <span class="lb-name">Rina M. (Jakarta)</span>
        <span class="lb-level">Level 6 (Gold)</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">🥈</span>
        <span class="lb-name">Agus T. (Bandung)</span>
        <span class="lb-level">Level 4 (Silver)</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">🥉</span>
        <span class="lb-name">Siti A. (Yogyakarta)</span>
        <span class="lb-level">Level 3 (Bronze)</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">4</span>
        <span class="lb-name">Dian R. (Surabaya)</span>
        <span class="lb-level">Level 2</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">5</span>
        <span class="lb-name">Budi S. (Medan)</span>
        <span class="lb-level">Level 1</span>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="section-title">
      <h2>Keuntungan Menjadi Ranger</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
      <div class="card">
        <div style="font-size:32px;margin-bottom:12px">🎓</div>
        <h4 style="margin-bottom:8px">Pelatihan Eksklusif</h4>
        <p class="text-sm">Akses workshop upcycling, daur ulang, dan edukasi circular economy.</p>
      </div>
      <div class="card">
        <div style="font-size:32px;margin-bottom:12px">🏅</div>
        <h4 style="margin-bottom:8px">Sistem Poin & Level</h4>
        <p class="text-sm">Kumpulkan poin dari setiap aktivitas dan naiki level Ranger Anda.</p>
      </div>
      <div class="card">
        <div style="font-size:32px;margin-bottom:12px">🤝</div>
        <h4 style="margin-bottom:8px">Komunitas & Network</h4>
        <p class="text-sm">Terhubung dengan sesama Ranger dari seluruh Indonesia.</p>
      </div>
    </div>
  </div>
</section>
@endsection
