<?php
$kegiatan = [
  ['image' => 'makan.jpg',
  'judul' => 'Memberi Makan Gajah',
  'deskripsi' => 'Pengunjung dapat secara langsung memberi makan gajah dengan buah-buahan yang telah disediakan.'
  ],
  [
    'image' => 'mandi.jpg',
    'judul' => 'Memandikan Gajah',
    'deskripsi' => 'Pada waktu tertentu, wisatawan bisa ikut memandikan gajah di sungai sekitar lokasi.'
  ],
  [
  'image' => 'trekking.jpg',
  'judul' => 'Trekking Alam',
  'deskripsi' => 'Paket trekking singkat di sekitar hutan konservasi bersama gajah dan pawang.'
  ],
  [
    'image' => 'konservasi.jpg',
    'judul' => 'Belajar Konservasi',
    'deskripsi' => 'Program edukatif untuk mengenal pentingnya konservasi gajah Sumatera.'
  ]
]
;

$ulasan = [
  [
    'komentar' => 'A terrific piece of praise',
    'nama' => 'Robert'
  ],
  [
    'komentar' => 'A fantastic bit of feedback',
    'nama' => 'David'
  ],
  [
    'komentar' => 'A genuinely glowing review',
    'nama' => 'Cristo'
  ]
]
;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pusat Latihan Gajah Minas</title>
  <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <!-- Navbar -->
  <header>
    <div class="container nav">
      <h2 class="logo">Pusat Latihan Gajah Minas</h2>
      <nav>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero -->
  <section class="hero" id="home">
    <img src="assets/hero.jpg" alt="Hero" class="hero-img">
    <div class="hero-text">
      <h1>Pusat Latihan Gajah Minas</h1>
    </div>
  </section>

  <!-- About -->
  <section class="about" id="about">
    <div class="container">
      <h2>Selamat Datang di Pusat Latihan Gajah Minas</h2>
      <p>Pusat Pelatihan Gajah Minas merupakan destinasi edukasi dan konservasi gajah yang berada di Minas, Riau. Tempat ini menjadi rumah bagi puluhan gajah Sumatera sekaligus pusat pelatihan dan perawatan mereka.</p>
      <p>Pengunjung dapat menyaksikan secara langsung aktivitas gajah, mengenal lebih dekat perilaku mereka, serta memahami upaya konservasi yang dilakukan...</p>
    </div>
  </section>

  <!-- Activities -->
  <section class="activities">
    <div class="container">
      <h2>Berbagai kegiatan seru dan mendidik bisa kamu lakukan saat berkunjung</h2>
      <div class="grid">
        
      <?php
      for($i = 0; $i < count($kegiatan); $i += 1) {
        echo '<div class="card">';
        echo '<img src="assets/' . $kegiatan[$i]['image'] . '" alt="' . $kegiatan[$i]['judul'] . '">';
        echo '<h3>' . $kegiatan[$i]['judul'] . '</h3>';
        echo '<p>' . $kegiatan[$i]['deskripsi'] . '</p>';
        echo '</div>';
      }
      ?>
      </div>
    </div>
  </section>
  ?>
  <!-- CTA -->
  <section class="cta">
    <h2>Tertarik?</h2>
    <p>Hubungi kami via WhatsApp! Tim kami siap membantu proses pesananmu secepatnya.</p>
    <a href="#" class="btn">Klik Disini</a>
  </section>

  <!-- Testimonials -->
  <section class="testimonials">
    <div class="container">
      <h2>Ulasan</h2>
      <div class="grid">
      <?php
      for($i = 0; $i < count($ulasan); $i += 1) {
        echo '<div class="card">';
        echo '<p>' . $ulasan[$i]['komentar'] . '</p>';
        echo '<p>'. '<b>' . $ulasan[$i]['nama'] .'</b>'. '</p>';
        echo '</div>';
      }
      ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
   <footer id="contact">
    <div class="container footer">
      <p>
      <i class="fas fa-map-marker-alt"></i>
      Unnamed Road No.28446, Minas Jaya, Kec. Minas, Kabupaten Siak, Riau 28684
    </p>
      <div class="contact-icons">
        <a href="https://instagram.com/yourusername" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://facebook.com/yourusername" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
        <a href="https://youtube.com/yourusername" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="mailto:youremail@example.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
      </div>
      <p>&copy; 2025 Pusat Latihan Gajah Minas</p>
    </div>
  </footer>

</body>
</html>
