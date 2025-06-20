<!doctype html>
<html lang="kr">
<head>
  <div class="container">
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>VELOX - Premium Supercar Collection</title>
 <link  href="css/bootstrap.min.css" rel="stylesheet">
 <link  href="css/my.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
 <script src="js/jquery-3.7.1.min.js"></script>
 <script src="js/bootstrap.bundle.min.js"></script>
 <style>
     @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
     .main-logo {
         display: flex;
         align-items: center;
         gap: 14px;
         flex-direction: row;
     }
     .logo-symbol {
         width: 44px;
         height: 44px;
         min-width: 44px;
         min-height: 44px;
         background: linear-gradient(135deg, #8A2BE2, #4B0082, #9932CC);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         position: relative;
         overflow: hidden;
         box-shadow: 0 0 10px rgba(138,43,226,0.18), inset 0 2px 10px rgba(255,255,255,0.12);
     }
     .logo-symbol::before {
         content: '';
         position: absolute;
         top: -50%;
         left: -50%;
         width: 200%;
         height: 200%;
         background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.12), transparent);
         animation: rotate 4s linear infinite;
     }
     @keyframes rotate {
         100% { transform: rotate(360deg); }
     }
     .symbol-inner {
         width: 85%;
         height: 85%;
         background: linear-gradient(135deg, #000, #1a1a1a);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         position: relative;
         z-index: 2;
     }
     .velocity-lines {
         position: absolute;
         width: 100%;
         height: 100%;
         display: flex;
         align-items: center;
         justify-content: center;
     }
     .velocity-lines::before,
     .velocity-lines::after {
         content: '';
         position: absolute;
         width: 2px;
         height: 12px;
         background: linear-gradient(to bottom, #8A2BE2, transparent);
         border-radius: 2px;
     }
     .velocity-lines::before {
         transform: rotate(45deg) translateX(-5px);
     }
     .velocity-lines::after {
         transform: rotate(-45deg) translateX(5px);
     }
     .brand-text {
         display: flex;
         flex-direction: column;
         gap: 2px;
         align-items: flex-start;
     }
     .brand-name {
         font-size: 28px;
         font-weight: 900;
         background: linear-gradient(135deg, #8A2BE2, #9932CC, #DA70D6, #E6E6FA);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         letter-spacing: 1.5px;
         text-transform: uppercase;
         position: relative;
         font-family: 'Orbitron', sans-serif;
     }
     .brand-subtitle {
         font-size: 13px;
         color: #aaa;
         text-transform: uppercase;
         letter-spacing: 1.2px;
         font-weight: 400;
         text-align: left;
         font-family: 'Orbitron', sans-serif;
         margin-left: 0;
         margin-top: 2px;
     }
 </style>
</head>
<body style="background:#181818;">
<!-- 슈퍼카 다크 네비게이션 -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#181818; box-shadow:0 2px 12px #000a;">
  <div class="container-fluid px-4">
    <a class="navbar-brand p-0" href="index.html" style="background:none; box-shadow:none;">
      <span class="main-logo">
        <span class="logo-symbol">
          <span class="symbol-inner"></span>
          <span class="velocity-lines"></span>
        </span>
        <span class="brand-text">
          <span class="brand-name">VELOX</span>
          <span class="brand-subtitle">Premium Supercar Collection</span>
        </span>
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item mx-1"><a class="nav-link" href="index.html"><i class="fa-solid fa-house"></i> Home</a></li>
        <?php
         $cookie_id =$_COOKIE["cookie_id"];
         if (!$cookie_id) {
        ?>
        <li class="nav-item mx-1"><a class="nav-link" href="member_login.php"><i class="fa-solid fa-right-to-bracket"></i> 로그인</a></li>
        <li class="nav-item mx-1"><a class="nav-link" href="member_join.php"><i class="fa-solid fa-user-plus"></i> 회원가입</a></li>
        <?php } else { ?>
        <li class="nav-item mx-1"><a class="nav-link" href="member_logout.php"><i class="fa-solid fa-right-from-bracket"></i> 로그아웃</a></li>
        <li class="nav-item mx-1"><a class="nav-link" href="member_edit.php"><i class="fa-solid fa-user-gear"></i> 정보수정</a></li>
        <?php } ?>
        <li class="nav-item mx-1"><a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> 장바구니</a></li>
        <li class="nav-item mx-1"><a class="nav-link" href="jumun_login.html"><i class="fa-solid fa-clipboard-list"></i> 주문조회</a></li>
        <li class="nav-item mx-1"><a class="nav-link" href="qa.html"><i class="fa-solid fa-comments"></i> Q&amp;A</a></li>
        <li class="nav-item mx-1"><a class="nav-link" href="faq.html"><i class="fa-solid fa-circle-question"></i> FAQ</a></li>
        <li class="nav-item mx-2">
          <form class="d-flex" name="form1" method="post" action="product_search.php" onsubmit="return !!this.find_text.value;">
            <input class="form-control form-control-sm me-2" type="text" name="find_text" placeholder="슈퍼카 검색" aria-label="Search" style="background:#232323; color:#FFD600; border:1.5px solid #FFD600; min-width:120px;">
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- 슈퍼카 메인 슬라이드 (YouTube Carousel) -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" style="box-shadow:0 4px 24px #000a; max-width:900px; margin:32px auto 24px auto; border-radius:18px; overflow:hidden;">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <!-- 1번 슬라이드: 유튜브 영상 -->
    <div class="carousel-item active">
      <div style="position:relative; width:100%; aspect-ratio:16/9; background:#000; overflow:hidden; border-radius:18px;">
        <iframe src="https://www.youtube.com/embed/MvVXL-vBQs0?autoplay=1&mute=1&loop=1&playlist=MvVXL-vBQs0&controls=0&showinfo=0&modestbranding=1" title="Supercar 1" allowfullscreen allow="autoplay" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"></iframe>
      </div>
      <div class="carousel-caption d-none d-md-block">
        <h1 style="color:#FFD600;text-shadow:0 2px 8px #000;">Ferrari SF90 Stradale</h1>
      </div>
    </div>
    <!-- 2번 슬라이드: 유튜브 영상 -->
    <div class="carousel-item">
      <div style="position:relative; width:100%; aspect-ratio:16/9; background:#000; overflow:hidden; border-radius:18px;">
        <iframe src="https://www.youtube.com/embed/sitXeGjm4Mc?start=47&autoplay=1&mute=1&loop=1&playlist=sitXeGjm4Mc&controls=0&showinfo=0&modestbranding=1" title="Supercar 2" allowfullscreen allow="autoplay" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"></iframe>
      </div>
      <div class="carousel-caption d-none d-md-block">
        <h1 style="color:#FFD600;text-shadow:0 2px 8px #000;">Lamborghini Revuelto</h1>
      </div>
    </div>
    <!-- 3번 슬라이드: 유튜브 영상 -->
    <div class="carousel-item">
      <div style="position:relative; width:100%; aspect-ratio:16/9; background:#000; overflow:hidden; border-radius:18px;">
        <iframe src="https://www.youtube.com/embed/tk5B4GSbgD4?autoplay=1&mute=1&loop=1&playlist=tk5B4GSbgD4&controls=0&showinfo=0&modestbranding=1" title="Supercar 3" allowfullscreen allow="autoplay" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"></iframe>
      </div>
      <div class="carousel-caption d-none d-md-block">
        <h1 style="color:#FFD600;text-shadow:0 2px 8px #000;">The new McLaren 765LT</h1>
      </div>
    </div>
    <!-- 4번 슬라이드: 유튜브 영상 -->
    <div class="carousel-item">
      <div style="position:relative; width:100%; aspect-ratio:16/9; background:#000; overflow:hidden; border-radius:18px;">
        <iframe src="https://www.youtube.com/embed/CPmRNLYBObE?autoplay=1&mute=1&loop=1&playlist=CPmRNLYBObE&controls=0&showinfo=0&modestbranding=1" title="Supercar 4" allowfullscreen allow="autoplay" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"></iframe>
      </div>
      <div class="carousel-caption d-none d-md-block">
        <h1 style="color:#FFD600;text-shadow:0 2px 8px #000;">the new Porsche Panamera 4</h1>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!-- 카테고리/상품검색 메뉴 (유지, 다크 스타일) -->
<div class="row bg-light m-0 p-1 fs-6 border" style="background:#232323 !important;">
 <div class="col">
  <div class="d-flex">
   <ul class="nav me-auto">
    <li class="nav-item zoom_a"><a class="nav-link" href="menu.php?menu=1"> Lamborghini </a></li>
    <li class="nav-item zoom_a"><a class="nav-link" href="menu.php?menu=2"> Ferrari </a></li>
    <li class="nav-item zoom_a"><a class="nav-link" href="menu.php?menu=3"> McLaren </a></li>
    <li class="nav-item zoom_a"><a class="nav-link" href="menu.php?menu=4"> Porsche </a></li>
    <li class="nav-item zoom_a"><a class="nav-link" href="menu.php?menu=5"> Mercedes-AMG </a></li>
    <li class="nav-item zoom_a"><a class="nav-link" href="menu.php?menu=6"> BMW M </a></li>
    <li class="nav-item dropdown">
     <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"> More </a>
     <ul class="dropdown-menu">
      <li class="nav-item zoom_a"><a class="dropdown-item" href="#">Audi RS</a></li>
      <li class="nav-item zoom_a"><a class="dropdown-item" href="#">Bentley</a></li>
      <li><hr class="dropdown-divider"></li>
      <li class="nav-item zoom_a"><a class="dropdown-item" href="#">Rolls-Royce</a></li>
     </ul>
    </li>
   </ul>
  </div>
 </div>
</div>
<!-- 페이지 본문 시작 (유지) -->

</body>
</html>