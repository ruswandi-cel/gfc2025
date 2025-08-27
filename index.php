<?php include '../admin/db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>GFC 2025 Live Score</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- Particle Layer -->
<div id="particles"></div>

<div class="main-container">
  <h1>🏆 GFC 2025 LIVE SCORE</h1>
  <p>Update skor, klasemen, dan statistik pertandingan secara real-time. Pilih menu di bawah:</p>
  <div class="buttons">
    <a href="live.php">Live Score</a>
    <a href="klasemen.php">Klasemen</a>
    <a href="statistik.php">Statistik</a>
    <a href="awards.php">Awards</a>
    <a href="galeri.php">Galeri</a>
    <a href="kontak.php">Kontak</a>
  </div>
  <button class="toggle-btn" onclick="toggleMode()">🔄 Mode Ringan</button>
</div>

<script>
let lightMode = false;
const particlesContainer = document.getElementById("particles");
const toggleBtn = document.querySelector(".toggle-btn");

// generate particles
function generateParticles(count){
  particlesContainer.innerHTML = "";
  for(let i=0;i<count;i++){
    const p = document.createElement("div");
    p.className = "particle";
    p.style.top = Math.random() * 100 + "vh";
    p.style.left = Math.random() * 100 + "vw";
    const size = Math.random() * 8 + 2;
    p.style.width = p.style.height = size + "px";
    p.style.background = "rgba(255,255,255,0.2)";
    p.style.animation = "moveParticle " + (Math.random() * 20 + 10) + "s linear infinite";
    particlesContainer.appendChild(p);
  }
}

// toggle mode
function toggleMode(){
  lightMode = !lightMode;
  if(lightMode){
    document.body.classList.add("light-mode");
    toggleBtn.innerText = "🔄 Mode Full Animasi";
    generateParticles(20); // ringan
  } else {
    document.body.classList.remove("light-mode");
    toggleBtn.innerText = "🔄 Mode Ringan";
    generateParticles(80); // full animasi
  }
}

// default (deteksi mobile → otomatis ringan)
if(/Mobile|Android|iPhone/i.test(navigator.userAgent)){
  lightMode = true;
}
toggleMode();
</script>

</body>
</html>
