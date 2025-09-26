<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Market | Adopti Dz</title>
  <style>
    /* ===== RESET ===== */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; background: #FFFDF5; color: #444; }
    a{text-decoration:none;color:inherit;}

    /* ===== HEADER ===== */
    header {
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
    .hero {text-align: center;padding: 50px 6%;background: #FFF9E6;}
    .hero h1 { font-size: 2rem; color: #E6B800; margin-bottom: 10px; }
    .hero p { font-size: 1rem; color: #555; }

    /* ===== FILTER ===== */
    .filter {margin: 25px auto;padding: 10px;display: flex;justify-content: center;gap: 15px;flex-wrap: wrap;}
    .filter select {
      padding: 10px 14px;
      border-radius: 10px;
      border: 1px solid #ddd;
      font-size: 0.95rem;
      outline: none;
    }
    .filter button {
      background: #FFD84D;
      border: none;
      padding: 10px 18px;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }
    .filter button:hover { background: #E6B800; color: white; }

    /* ===== PRODUCT CARDS ===== */
    .products {display: grid;grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));gap: 25px;padding: 30px 6%;}
    .product-card {background: white;border-radius: 16px;overflow: hidden;box-shadow: 0 4px 12px rgba(0,0,0,0.06);transition: transform 0.3s ease;}
    .product-card:hover {transform: translateY(-6px);}
    .product-card img {width: 100%;height: 180px;object-fit: contain;background: #fafafa;padding: 5px;}
    .product-info {padding: 15px;}
    .product-info h3 {color: #E6B800;font-size: 1.2rem;margin-bottom: 8px;}
    .product-info p {font-size: 0.9rem;margin-bottom: 6px;color: #555;}
    .price {font-weight: bold;color: #333;}
    .product-info button {
      margin-top: 10px;background: #FFD84D;border: none;padding: 8px 14px;
      border-radius: 8px;font-size: 0.9rem;font-weight: bold;cursor: pointer;transition: background 0.3s;
    }
    .product-info button:hover {background: #E6B800;color: white;}

    /* ===== FOOTER ===== */
    footer {margin-top: 40px;text-align: center;padding: 20px;background: #FFF9E6;font-size: 0.9rem;color: #777;}

    /* ===== RESPONSIVE ===== */
    @media(max-width:768px){
      nav ul{display:none;flex-direction:column;position:absolute;top:65px;right:8%;background:#fff;border-radius:10px;padding:15px;box-shadow:0 5px 15px rgba(0,0,0,.1);}
      nav ul.active{display:flex;}
      .menu-toggle{display:flex;}
    }

    /* --- فورم: نفس ستايل new_product.html --- */
form label { display:block; margin-top:15px; font-weight:600; }
form input, form select, form textarea {
  width:100%;
  padding:12px;
  border-radius:10px;
  border:1px solid #ddd;
  margin-top:6px;
  font-size:0.95rem;
}
form button {
  margin-top:20px;
  width:100%;
  padding:12px;
  background:#FFD84D;
  border:none;
  border-radius:12px;
  font-weight:bold;
  cursor:pointer;
  transition:0.3s;
}
form button:hover { background:#E6B800; color:#fff; }

  </style>
</head>
<body>

  <!-- ===== HEADER ===== -->
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

  <!-- ===== HERO ===== -->
  <section class="hero">
    <h1>Découvrez nos produits 🐾</h1>
    <p>Trouvez tout ce dont votre compagnon a besoin 💛</p>
  </section>

  <!-- ===== FILTER ===== -->
  <section class="filter">
    <select id="typeFilter">
      <option value="all">Tous les types</option>
      <option value="Nourriture">Nourriture</option>
      <option value="Jouets">Jouets</option>
      <option value="Accessoires">Accessoires</option>
      <option value="Hygiène">Hygiène</option>
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
    <button onclick="filterProducts()">Rechercher</button>
  </section>

  <!-- ===== PRODUCT CARDS ===== -->
  <section class="products" id="productsContainer"></section>

  <!-- ===== FOOTER ===== -->
  <footer>
    <p>© 2025 Adopti Dz – Produits pour animaux avec amour 🐾</p>
  </footer>

  <!-- ===== SCRIPT ===== -->
  <script>
    let allProducts = [];

    // Charger les produits depuis l’API
   async function loadProducts() {
  const res = await fetch("new_product.php?action=all");
  const ads = await res.json();
  allProducts = ads; // déjà produits
  renderProducts(allProducts);
}


    // Afficher les produits
  function renderProducts(products) {
  const container = document.getElementById("productsContainer");
  container.innerHTML = "";

  products.forEach(p => {
    // safe values
    const img = (p.images && p.images.length > 0) ? p.images[0] : "placeholder.jpg";
    const title = p.title ? p.title.replace(/"/g, '&quot;') : '';
    const price = p.price || '';
    const wilaya = p.wilaya || '';
    const condition = p.item_condition || '';
    const phone = p.phone || '';
    const desc = p.description ? p.description.replace(/</g,'&lt;').replace(/>/g,'&gt;') : '';

    const card = document.createElement("div");
    card.className = "product-card";
    card.setAttribute("data-type", p.category || "");
    card.setAttribute("data-wilaya", wilaya);

    card.innerHTML = `
      <img src="${img}" alt="${title}">
      <div class="product-info">
        <h3>${title}</h3>
        <p class="price">${price ? price + " DA" : "N/A"}</p>
        <p>Lieu : ${wilaya}</p>
        <p>État : ${condition}</p>
        <p>📞 ${phone || "Non disponible"}</p>

        <a href="tel:${phone}" style="text-decoration:none;">
          <button type="button">Contacter le vendeur</button>
        </a>

        ${p.is_owner ? `
          <button class="edit-btn" type="button">Modifier</button>

          <form class="edit-form" style="display:none;" enctype="multipart/form-data">
            <input type="hidden" name="id" value="${p.id}">
            
            <label>Nom du produit</label>
            <input type="text" name="title" value="${title}" required>

            <label>Prix (DZD)</label>
            <input type="number" name="price" step="0.01" value="${price}" required>

            <label>Téléphone</label>
            <input type="text" name="phone" value="${phone}">

            <label>Wilaya</label>
            <select name="wilaya">
              <option ${wilaya===''? 'selected':''} value="">Choisir Wilaya</option>
              <!-- يمكنك إبقاء كل الولاية هنا أو إنك لا تضيفها كلها الآن -->
              <option ${wilaya==='Alger' ? 'selected' : ''}>Alger</option>
              <option ${wilaya==='Oran' ? 'selected' : ''}>Oran</option>
              <option ${wilaya==='Skikda' ? 'selected' : ''}>Skikda</option>
              <!-- زيد الباقي كيما في الفورم -->
            </select>

            <label>Description</label>
            <textarea name="description" rows="3">${desc}</textarea>

            <label>Ajouter des images (optionnel)</label>
            <input type="file" name="images[]" multiple accept="image/*">

            <button type="submit">Sauvegarder</button>
          </form>
        ` : ''}
      </div>
    `;

    container.appendChild(card);

    // --- attach listeners once per card ---
    if (p.is_owner) {
      const editBtn = card.querySelector('.edit-btn');
      const editForm = card.querySelector('.edit-form');

      // toggle visibility
      editBtn.addEventListener('click', () => {
        editForm.style.display = (editForm.style.display === 'none' || editForm.style.display === '') ? 'block' : 'none';
      });

      // submit handler - attached once
      editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(editForm);

        try {
          const res = await fetch("new_product.php?action=update", {
            method: "POST",
            body: fd,
            credentials: 'same-origin'
          });
          const json = await res.json();
          if (json.status === 'success') {
            // reload products
            await loadProducts();
            alert('Produit modifié avec succès !');
          } else {
            alert('Erreur: ' + (json.message || 'Unknown'));
            console.error(json);
          }
        } catch (err) {
          console.error(err);
          alert('Erreur réseau ou serveur');
        }
      });
    }
  });
}


    // Filtrage
    function filterProducts() {
      const type = document.getElementById("typeFilter").value;
      const wilaya = document.getElementById("wilayaFilter").value;

      let filtered = allProducts.filter(p => {
        const matchType = type === "all" || p.category === type;
        const matchWilaya = wilaya === "all" || p.wilaya === wilaya;
        return matchType && matchWilaya;
      });

      renderProducts(filtered);
    }

    document.addEventListener("DOMContentLoaded", loadProducts);
  </script>

</body>
</html>
