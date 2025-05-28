<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Canil Legalzinho</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f8f3f6;
      color: #333;
    }

    header {
      background: #ffffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .hero-nav {
      display: flex;
      gap: 1rem;
    }

    .hero-nav a {
      text-decoration: none;
      color: #444;
      font-weight: bold;
    }

    .hero-nav a:hover {
      color: #da70d6;
    }

    .hero-banner {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 3rem 1rem;
      background-color: #fff0f5;
    }

    .hero-banner h1 {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: #da70d6;
    }

    .hero-banner p {
      font-size: 1rem;
      max-width: 600px;
      margin-bottom: 2rem;
    }

    .cta-button {
      background: #da70d6;
      color: #fff;
      padding: 1rem 2rem;
      font-size: 1rem;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .cta-button:hover {
      background: #c25cc2;
    }

    .pet-card-oferta {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .pet-card {
      background: #fff;
      border-radius: 12px;
      padding: 1rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 280px;
    }

    .pet-card h3 {
      margin: 1rem 0 0.5rem;
      color: #da70d6;
    }

    .pet-card p {
      font-size: 0.9rem;
      color: #555;
    }

    .garantia {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem 1rem;
      background: #fff;
      text-align: center;
    }

    .garantia h2 {
      color: #da70d6;
      margin-bottom: 1rem;
    }

    .garantia p {
      max-width: 600px;
    }

    .blog-carrossel {
      padding: 2rem 1rem;
      background: #f0e6f6;
      text-align: center;
    }

    .blog-carrossel h2 {
      margin-bottom: 1rem;
      color: #9932cc;
    }

    .slides {
      display: flex;
      gap: 1rem;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      padding-bottom: 1rem;
    }

    .slide {
      flex: 0 0 80%;
      background: #fff;
      border-radius: 12px;
      padding: 1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      scroll-snap-align: center;
    }

    .slide h3 {
      color: #da70d6;
      margin-bottom: 0.5rem;
    }

    .slide p {
      font-size: 0.9rem;
    }

    footer {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 1rem;
    }

    footer p {
      margin: 0;
    }

    @media (min-width: 768px) {
      .hero-banner {
        flex-direction: row;
        justify-content: space-between;
        text-align: left;
        padding: 4rem 6rem;
      }

      .garantia {
        flex-direction: row;
        justify-content: center;
        gap: 2rem;
        text-align: left;
      }

      .slides {
        gap: 2rem;
      }

      .slide {
        flex: 0 0 30%;
      }
    }
  </style>
</head>
<body>
  <header>
    <!-- Logo removida -->
<!-- filepath: c:\xampp\htdocs\Canil\admin\produtos\index.php -->
<nav class="hero-nav">
    <a href="index.php">Home</a>
    <a href="caes_disponiveis.php">Cães Disponíveis</a>
    <a href="#">Sobre</a>
    <a href="#">Contato</a>
</nav>
    <h1>Canil Legalzinho</h1>
  </header>

  <section class="hero-banner">
    <div>
      <h1>Encontre seu novo melhor amigo</h1>
      <p>Descubra os mais adoráveis e saudáveis filhotes prontos para fazer parte da sua família!</p>
      <button class="cta-button">Ver Filhotes</button>
    </div>
    <div class="hero-pet-card">
      <!-- Imagem principal removida -->
    </div>
  </section>

  <section class="pet-card-oferta">
    <!-- Cards de pets sem imagem -->
    <div class="pet-card">
      <h3>Golden Retriever</h3>
      <p>3 meses - Vacinado e Vermifugado</p>
    </div>
    <div class="pet-card">
      <h3>Shih Tzu</h3>
      <p>2 meses - Pelagem Premium</p>
    </div>
  </section>

  <section class="garantia">
    <!-- Imagem de garantia removida -->
    <div>
      <h2>Garantia de Saúde e Procedência</h2>
      <p>Todos os nossos filhotes são entregues com garantia de saúde, carteira de vacinação atualizada e acompanhamento veterinário.</p>
    </div>
  </section>

  <section class="blog-carrossel">
    <h2>Dicas e Cuidados</h2>
    <div class="slides">
      <div class="slide">
        <h3>Como alimentar seu filhote</h3>
        <p>Dicas essenciais sobre alimentação saudável para seu novo amiguinho.</p>
      </div>
      <div class="slide">
        <h3>Primeiros cuidados em casa</h3>
        <p>O que fazer nos primeiros dias com seu novo cãozinho.</p>
      </div>
      <div class="slide">
        <h3>Vacinação e Vermifugação</h3>
        <p>Entenda o calendário de vacinas e cuidados essenciais.</p>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 Canil Legalzinho. Todos os direitos reservados.</p>
  </footer>
</body>
</html>
