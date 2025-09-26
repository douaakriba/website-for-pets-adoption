<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Espace - Adopti Dz</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: #fffbea;
    }
     a{text-decoration:none;color:inherit;}
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


    .dashboard {
      max-width: 900px;
      margin: 40px auto;
      padding: 20px;
      text-align: center;
    }

    .dashboard h2 {
      color: #333;
    }

    .welcome {
      font-size: 18px;
      margin-bottom: 30px;
    }

    .actions {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      flex: 1 1 250px;
      max-width: 280px;
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    .card h3 {
      margin-bottom: 15px;
      color: #444;
    }

    .card a {
      display: inline-block;
      padding: 10px 20px;
      background: #f6c90e;
      border-radius: 10px;
      color: #333;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .card a:hover {
      background: #ffdb4d;
    }
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
</header>

<div class="dashboard">
  <h2>Bienvenue sur PetDz 🐾</h2>
  <p class="welcome">Ravi de vous voir ici ! Que souhaitez-vous faire aujourd'hui ?</p>

  <div class="actions">
    <div class="card">
      <h3>Adopter un animal</h3>
      <a href="adoption.php">Voir les animaux</a>
    </div>

    <div class="card">
      <h3>Publier une annonce d’adoption</h3>
      <a href="new_adoption.html">Publier</a>
    </div>

    <div class="card">
      <h3>Vendre un produit</h3>
      <a href="new_product.html">Ajouter un produit</a>
    </div>

    <div class="card">
      <h3>Parcourir les produits</h3>
      <a href="market.php">Voir les produits</a>
    </div>
  </div>
</div>

</body>
</html>
