<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adoption | Adopti Dz</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; background: #FFFDF5; color: #444; }

    header{background:#fff;padding:15px 8%;display:flex;align-items:center;justify-content:space-between;box-shadow:0 2px 5px rgba(0,0,0,0.05);position:sticky;top:0;z-index:1000;}
    .logo{display:flex;align-items:center;gap:10px;}
    .logo img{width:70px;height:70px;border-radius:50%;}
    .logo span{font-weight:700;font-size:1.5rem;color:#ffcc59;}

    nav ul{display:flex;list-style:none;gap:20px;}
    

    nav ul li a {
  font-weight: 500;
  transition: .3s;
  text-decoration: none;   /* نحي underline */
  color: #444;             /* اللون الأساسي */
}

nav ul li a:hover {
  color: #E6B800;          /* اللون كي يمر الفأر */
}


    .menu-toggle{display:none;flex-direction:column;gap:4px;cursor:pointer;}
    .menu-toggle span{width:25px;height:3px;background:#333;border-radius:2px;}

    .hero {text-align:center;padding:50px 6%;background:#FFF9E6;}
    .hero h1 {font-size:2rem;color:#E6B800;margin-bottom:12px;}
    .hero p {font-size:1.05rem;color:#555;}

    .filter {margin:30px auto;padding:15px;display:flex;justify-content:center;gap:15px;flex-wrap:wrap;}
    .filter select, .filter button {padding:10px 14px;border-radius:10px;border:1px solid #ddd;font-size:0.95rem;outline:none;}
    .filter button {background:#FFD84D;border:none;font-weight:bold;cursor:pointer;transition:0.3s;}
    .filter button:hover {background:#E6B800;color:white;}

    .pets {display:grid;grid-template-columns:repeat(auto-fit,minmax(270px,1fr));gap:25px;padding:40px 6%;}
    .pet-card {background:white;border-radius:16px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.06);transition: transform 0.3s ease;}
    .pet-card:hover {transform: translateY(-8px);}

    .slider {position:relative;width:100%;height:160px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#fdfdfd;}
    .slider img {width:100%;height:100%;object-fit:contain;background:#f8f8f8;display:none;padding:5px;border-radius:8px;}
    .slider img.active {display:block;}
    .slider button {position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,216,77,0.8);border:none;font-size:1.2rem;padding:6px 10px;cursor:pointer;border-radius:50%;}
    .slider button:hover {background:#E6B800;color:white;}
    .slider .prev {left:10px;}
    .slider .next {right:10px;}

    .pet-info {padding:15px;}
    .pet-info h3 {color:#E6B800;margin-bottom:8px;font-size:1.2rem;}
    .pet-info p {font-size:0.9rem;color:#555;margin-bottom:6px;}
    .note {font-style:italic;color:#777;margin-bottom:10px;}
    .pet-info button {margin-top:8px;background:#FFD84D;border:none;padding:8px 14px;border-radius:8px;font-size:0.9rem;font-weight:bold;cursor:pointer;transition:0.3s;}
    .pet-info button:hover {background:#E6B800;color:white;}
    .edit-form input {display:block;width:100%;margin-bottom:8px;padding:6px;border:1px solid #ddd;border-radius:6px;}

    footer {margin-top:50px;text-align:center;padding:20px;background:#FFF9E6;font-size:0.9rem;color:#777;}

    @media(max-width:768px){
      nav ul{display:none;flex-direction:column;position:absolute;top:65px;right:8%;background:#fff;border-radius:10px;padding:15px;box-shadow:0 5px 15px rgba(0,0,0,.1);}
      nav ul.active{display:flex;}
      .menu-toggle{display:flex;}
    }
  </style>
</head>
<body>

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

<section class="hero">
  <h1>Trouvez votre nouvel ami 🐾</h1>
  <p>Adoptez un animal et offrez-lui une deuxième chance pleine d’amour 💛</p>
</section>

<section class="filter">
  <select id="animalType">
    <option value="">Type d’animal</option>
    <option value="Chat">Chat</option>
    <option value="Chien">Chien</option>
    <option value="Oiseau">Oiseau</option>
    <option value="Autre">Autre</option>
  </select>
  <select id="wilayaFilter">
   <option value="all">Toutes les wilayas</option>
      <option>Adrar</option>
      <option>Chlef</option>
      <option>Laghouat</option>
      <option>Oum El Bouaghi</option>
      <option>Batna</option>
      <option>Béjaïa</option>
      <option>Biskra</option>
      <option>Béchar</option>
      <option>Blida</option>
      <option>Bouira</option>
      <option>Tamanrasset</option>
      <option>Tébessa</option>
      <option>Tlemcen</option>
      <option>Tiaret</option>
      <option>Tizi Ouzou</option>
      <option>Alger</option>
      <option>Djelfa</option>
      <option>Jijel</option>
      <option>Sétif</option>
      <option>Saïda</option>
      <option>Skikda</option>
      <option>Sidi Bel Abbès</option>
      <option>Annaba</option>
      <option>Guelma</option>
      <option>Constantine</option>
      <option>Médéa</option>
      <option>Mostaganem</option>
      <option>MSila</option>
      <option>Mascara</option>
      <option>Ouargla</option>
      <option>Oran</option>
      <option>El Bayadh</option>
      <option>Illizi</option>
      <option>Bordj Bou Arreridj</option>
      <option>Boumerdès</option>
      <option>El Tarf</option>
      <option>Tindouf</option>
      <option>Tissemsilt</option>
      <option>El Oued</option>
      <option>Khenchela</option>
      <option>Souk Ahras</option>
      <option>Tipaza</option>
      <option>Mila</option>
      <option>Aïn Defla</option>
      <option>Naâma</option>
      <option>Aïn Témouchent</option>
      <option>Ghardaïa</option>
      <option>Relizane</option>
    </select>
  <button id="searchBtn">Rechercher</button>
</section>

<section class="pets" id="petsContainer"></section>

<footer>
  <p>© 2025 Adopti Dz – L’amour commence par une adoption 🐾</p>
</footer>

<script>
async function loadAdoptions() {
  const res = await fetch("new_adoption.php?action=all");
  const pets = await res.json();
  allPets = pets;
  renderPets(allPets);
}

function renderPets(pets) {
  petsContainer.innerHTML = '';

  pets.forEach(pet => {
    const images = (pet.images && pet.images.length) ? pet.images : ['placeholder.jpg'];
    let current = 0;

    const card = document.createElement('div');
    card.className = 'pet-card';
    card.dataset.type = pet.species || '';
    card.dataset.wilaya = pet.wilaya || '';

    // ✅ نزيد شرط: الزر يبان غير إذا pet.is_owner == true
    card.innerHTML = `
      <div class="slider">
        ${images.map((img, i) => `<img src="${img}" class="${i===0?'active':''}" alt="${pet.title}">`).join('')}
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
      </div>
      <div class="pet-info">
        <h3>${pet.title}</h3>
        <p>Lieu : ${pet.wilaya || 'Non spécifié'}</p>
        <p>${pet.description || ''}</p>
        <a href="tel:${pet.phone}"><button>Contacter le propriétaire</button></a>

        ${pet.is_owner ? `
        <button class="edit-btn">Modifier</button>
        <form class="edit-form" style="display:none; margin-top:10px;">
          <input type="hidden" name="id" value="${pet.id}">
          <input type="text" name="title" value="${pet.title}">
          <input type="text" name="description" value="${pet.description}">
          <input type="text" name="phone" value="${pet.phone}">
          <input type="text" name="wilaya" value="${pet.wilaya}">
          <button type="submit">Sauvegarder</button>
        </form>` : ``}
      </div>
    `;

    petsContainer.appendChild(card);

    // Slider functionality
    const imgEls = card.querySelectorAll('img');
    card.querySelector('.next').addEventListener('click', () => {
      imgEls[current].classList.remove('active');
      current = (current + 1) % imgEls.length;
      imgEls[current].classList.add('active');
    });
    card.querySelector('.prev').addEventListener('click', () => {
      imgEls[current].classList.remove('active');
      current = (current - 1 + imgEls.length) % imgEls.length;
      imgEls[current].classList.add('active');
    });

    // ✅ نزيد فقط إذا المالك هو اللي داخل
    if (pet.is_owner) {
      const editBtn = card.querySelector('.edit-btn');
      const editForm = card.querySelector('.edit-form');

      editBtn.addEventListener('click', () => {
        editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
      });

      editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(editForm);

        const res = await fetch("new_adoption.php?action=update", {
          method: "POST",
          body: formData
        });

        const result = await res.json();
        if (result.status === "success") {
          alert("Mise à jour réussie !");
          loadAdoptions();
        } else {
          alert("Erreur lors de la mise à jour.");
        }
      });
    }
  });

}

// Filter
document.getElementById('searchBtn').addEventListener('click', () => {
  const type = document.getElementById('animalType').value;
  const wilaya = document.getElementById('wilayaFilter').value;

  const filtered = allPets.filter(pet => {
    const matchType = !type || (pet.species === type);
    const matchWilaya = !wilaya || (pet.wilaya === wilaya);
    return matchType && matchWilaya;
  });

  renderPets(filtered);
});

document.addEventListener('DOMContentLoaded', loadAdoptions);
</script>


</body>
</html>

