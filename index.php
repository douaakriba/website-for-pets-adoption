
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adopti Dz</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
    body{background:#FFFCF7;color:#444;line-height:1.6;}
    a{text-decoration:none;color:inherit;}

    /* ===== HEADER ===== */
    header{
      background:#fff;
      padding:15px 8%;
      display:flex;align-items:center;justify-content:space-between;
      box-shadow:0 2px 5px rgba(0,0,0,0.05);
      position:sticky;top:0;z-index:1000;
    }
    .logo{display:flex;align-items:center;gap:10px;}
    .logo img{width:70px;height:70px;border-radius:50%;}
    .logo span{font-weight:700;font-size:1.5rem;color:#ffcc59;}
    nav ul{display:flex;list-style:none;gap:20px;}
    nav ul li a{font-weight:500;transition:.3s;}
    nav ul li a:hover{color:#E6B800;}
    .menu-toggle{display:none;flex-direction:column;gap:4px;cursor:pointer;}
    .menu-toggle span{width:25px;height:3px;background:#333;border-radius:2px;}

    /* ===== HERO ===== */
    .hero{
      background:#fff9ea;
      display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;
      padding:60px 8%;
    }
    .hero-text{flex:1 1 400px;}
    .hero-text h1{font-size:2.8rem;color:#333;margin-bottom:15px;}
    .hero-text p{margin-bottom:25px;color:#555;}
    .btn{padding:12px 25px;background:#FFD966;border-radius:30px;font-weight:600;color:#333;transition:.3s;}
    .btn:hover{background:#E6B800;color:#fff;}
    .hero-btns{display:flex;gap:15px;flex-wrap:wrap;}
    .hero-img{flex:1 1 80px;text-align:center;}
    .hero-img img{max-width:100%;border-radius:20px;}

    /* ===== WHY ===== */
    .why{padding:60px 8%;text-align:center;}
    .why h2{font-size:2rem;color:#E6B800;margin-bottom:20px;}
    .why p{max-width:700px;margin:0 auto;color:#555;}

    /* ===== HOW IT WORKS ===== */
    .steps{padding:60px 8%;background:#FFFBEA;}
    .steps h2{text-align:center;font-size:2rem;color:#E6B800;margin-bottom:40px;}
    .step-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:25px;}
    .step{background:#fff;padding:25px;border-radius:18px;text-align:center;box-shadow:0 3px 8px rgba(0,0,0,0.05);}
    .step img{width:60px;height:60px;margin-bottom:15px;}
    .step h3{margin-bottom:10px;color:#333;}





    /* ===== ADVICE SECTION ===== */
   /* ===== ADVICE SWIPE SECTION ===== */
.advice {
  padding: 60px 6%;
  background: #FFFDF5;
  text-align: center;
}

.advice h2 {
  font-size: 2rem;
  color: #E6B800;
  margin-bottom: 25px;
  font-weight: bold;
}

.advice-carousel {
  display: flex;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  gap: 20px;
  padding-bottom: 10px;
  scrollbar-width: none; /* hide scrollbar for Firefox */
}
.advice-carousel::-webkit-scrollbar {
  display: none; /* hide scrollbar for Chrome/Safari */
}

.advice-card {
  flex: 0 0 280px;
  background: #fff;
  padding: 25px;
  border-radius: 18px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  scroll-snap-align: start;
  transition: transform 0.3s ease;
}
.advice-card:hover {
  transform: translateY(-8px);
}
.advice-card img {
  width: 60px;
  margin-bottom: 15px;
}
.advice-card h3 {
  font-size: 1.2rem;
  color: #444;
  margin-bottom: 10px;
}
.advice-card p {
  font-size: 0.95rem;
  color: #666;
  line-height: 1.4rem;
}


    /* ===== JOIN US ===== */
    .join{padding:60px 8%;text-align:center;}
    .join h2{font-size:2rem;color:#E6B800;margin-bottom:20px;}
    .join p{color:#555;margin-bottom:20px;}
    .join a{background:#FFD966;padding:12px 25px;border-radius:30px;font-weight:600;}
    .join a:hover{background:#E6B800;color:#fff;}

    /* ===== FOOTER ===== */
    footer{background:#fff;padding:20px;text-align:center;font-size:0.9rem;color:#555;margin-top:40px;}

    /* ===== RESPONSIVE ===== */
    @media(max-width:768px){
      nav ul{display:none;flex-direction:column;position:absolute;top:65px;right:8%;background:#fff;border-radius:10px;padding:15px;box-shadow:0 5px 15px rgba(0,0,0,.1);}
      nav ul.active{display:flex;}
      .menu-toggle{display:flex;}
      .hero{flex-direction:column;text-align:center;}
      .hero-img{margin-top:20px;}
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
      <img src="logo.png" alt="PetDz Logo">
      <span>Adopti Dz</span>
    </div>
    <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="adoption.php">Adoption</a></li>
      <li><a href="market.php">Boutique</a></li>

      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- ✅ يظهر فقط للمستخدم المسجل -->
        <li><a href="dashboard.php">Mon éspace</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
      <?php else: ?>
        <!-- ❌ يظهر فقط للمستخدم الغير مسجل -->
        <li><a href="login.html">Connexion</a></li>
      <?php endif; ?>

    </ul>
  </nav>
    <div class="menu-toggle" onclick="document.querySelector('nav ul').classList.toggle('active')">
      <span></span><span></span><span></span>
    </div>
  </header>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-text">
      <h1>Bienvenue sur Adopti DZ 🐾</h1>
      <p>Plateforme algérienne pour adopter ou proposer un animal,<br>
         et acheter ou vendre des produits animaliers en toute simplicité..</p>
      <div class="hero-btns">
        <a href="adoption.php" class="btn">Découvrir l’adoption</a>
        <a href="market.php" class="btn">Voir la boutique</a>
      </div>
    </div>
    <div class="hero-img">
      <img src="pet.png" alt="Pets Illustration">
    </div>
  </section>

  <!-- WHY -->
  <section class="why">
    <h2>Pourquoi Adopti Dz ?</h2>
    <p>Parce que chaque animal mérite un foyer aimant 💛.<br>  
       Adopti Dz facilite la mise en relation entre propriétaires et futurs adoptants,  
       et vous aide à trouver tout ce qu’il faut pour vos compagnons.</p>
  </section>

  <!-- HOW IT WORKS -->
  <section class="steps">
    <h2>Comment ça marche ?</h2>
    <div class="step-grid">
      <div class="step">
        <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" alt="Step">
        <h3>1. Explorer</h3>
        <p>Consultez librement les annonces d’animaux et de produits.</p>
      </div>
      <div class="step">
        <img src="https://cdn-icons-png.flaticon.com/512/2950/2950741.png" alt="Step">
        <h3>2. Contacter</h3>
        <p>Appelez directement le propriétaire pour adopter ou acheter.</p>
      </div>
      <div class="step">
        <img src="https://cdn-icons-png.flaticon.com/512/1828/1828919.png" alt="Step">
        <h3>3. Publier (avec compte)</h3>
        <p>Créez un compte pour partager vos propres annonces.</p>
      </div>
    </div>
  </section>
    


<!-- ====== PET MEDICAL & GENERAL ADVICE SECTION ====== -->
<section class="advice">
  <h2>Conseils Médicaux & Utiles 🐾</h2>
  <div class="advice-carousel">

    <!-- Vaccination -->
    <div class="advice-card">
      <img src="dog.png" alt="Vaccination">
      <h3>Vaccination</h3>
      <p>Les vaccins protègent vos animaux contre des maladies graves comme la rage, le typhus et la parvovirose.</p>
    </div>



    <!-- Vet Check -->
    <div class="advice-card">
      <img src="vet.png" alt="Vet">
      <h3>Visite vétérinaire</h3>
      <p>Un contrôle régulier chez le vétérinaire permet de détecter rapidement tout problème de santé.</p>
    </div>
    
    <!-- Pregnancy & Cats -->
    <div class="advice-card">
      <img src="pregnant.png" alt="Pregnancy">
      <h3>Grossesse & Chats</h3>
      <p>Les femmes enceintes doivent éviter de nettoyer la litière pour réduire le risque de toxoplasmose.</p>
    </div>

    <!-- Dangerous Foods -->
    <div class="advice-card">
      <img src="food.png" alt="Food">
      <h3>Aliments interdits</h3>
      <p>Pas de chocolat, raisins, oignon ou ail ! Ces aliments sont toxiques pour chiens et chats.</p>
    </div>

    <!-- Parasites -->
    <div class="advice-card">
    
      <img src="disease.png" alt="Parasites">
      <h3>Parasites</h3>
      <p>Protégez vos animaux des puces et tiques avec des traitements mensuels adaptés.</p>
    </div>

    <!-- Worms -->
    <div class="advice-card">
      <img src="worm.png" alt="Worms">
      <h3>Vermifuge</h3>
      <p>Un déparasitage interne tous les 3 à 6 mois est essentiel pour garder vos animaux en bonne santé.</p>
    </div>

    <!-- Exercise -->
    <div class="advice-card">
      <img src="dogg.png" alt="Exercise">
      <h3>Activité physique</h3>
      <p>Les chiens ont besoin de promenades quotidiennes, les chats d’activités ludiques pour rester actifs.</p>
    </div>

    <!-- Dental Care -->
    <div class="advice-card">
      <img src="veterinary.png" alt="Dental">
      <h3>Hygiène dentaire</h3>
      <p>Des soins dentaires réguliers préviennent le tartre, les infections et la mauvaise haleine.</p>
    </div>

    <!-- Grooming -->
    <div class="advice-card">
      <img src="grooming.png" alt="Grooming">
      <h3>Toilettage</h3>
      <p>Le brossage régulier du pelage réduit la perte de poils et prévient les nœuds.</p>
    </div>

  </div>
</section>




  <!-- JOIN US -->
  <section class="join">
    <h2>Envie de partager une annonce ?</h2>
    <p>Créez un compte gratuitement et rejoignez la communauté PetDz.</p>
    <a href="signup.html">Créer un compte</a>
  </section>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 Adopti Dz. Tous droits réservés.</p>
  </footer>

</body>
</html>



