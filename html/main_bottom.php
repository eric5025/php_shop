<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!-- 슈퍼카 다크 푸터 -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
.footer .main-logo {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 12px 0 12px 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.9), rgba(20,20,20,0.8));
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 4px 16px rgba(0,0,0,0.12), inset 0 1px 0 rgba(255,255,255,0.08);
    backdrop-filter: blur(8px);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    justify-content: center;
}
.footer .main-logo::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
    animation: luxuryShine 3s infinite;
}
@keyframes luxuryShine {
    0% { left: -100%; }
    60% { left: 100%; }
    100% { left: 100%; }
}
.footer .main-logo:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(138,43,226,0.12), inset 0 1px 0 rgba(255,255,255,0.12);
}
.footer .logo-symbol {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, #8A2BE2, #4B0082, #9932CC);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(138,43,226,0.18), inset 0 2px 10px rgba(255,255,255,0.12);
}
.footer .logo-symbol::before {
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
.footer .symbol-inner {
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
.footer .velocity-lines {
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.footer .velocity-lines::before,
.footer .velocity-lines::after {
    content: '';
    position: absolute;
    width: 2px;
    height: 12px;
    background: linear-gradient(to bottom, #8A2BE2, transparent);
    border-radius: 2px;
}
.footer .velocity-lines::before {
    transform: rotate(45deg) translateX(-5px);
}
.footer .velocity-lines::after {
    transform: rotate(-45deg) translateX(5px);
}
.footer .brand-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.footer .brand-name {
    font-size: 20px;
    font-weight: 900;
    background: linear-gradient(135deg, #8A2BE2, #9932CC, #DA70D6, #E6E6FA);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 2px;
    text-transform: uppercase;
    position: relative;
    font-family: 'Orbitron', sans-serif;
}
.footer .brand-subtitle {
    font-size: 9px;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 400;
    text-align: left;
    font-family: 'Orbitron', sans-serif;
}
</style>
<footer class="footer mt-5" style="background:#181818; color:#FFD600; border-radius:24px 24px 0 0; box-shadow:0 -2px 12px #000a;">
  <div class="container-fluid py-4">
    <div class="row align-items-center">
      <div class="col-md-2 text-center mb-3 mb-md-0">
        <a href="index.html">
          <div class="main-logo">
            <div class="logo-symbol">
              <div class="symbol-inner">
                <div class="velocity-lines"></div>
              </div>
            </div>
            <div class="brand-text">
              <div class="brand-name">VELOX</div>
              <div class="brand-subtitle">Supercar Collection</div>
            </div>
          </div>
        </a>
        <div class="mt-2">
          <i class="fab fa-cc-visa fa-lg mx-1" style="color:#FFD600;"></i>
          <i class="fab fa-cc-mastercard fa-lg mx-1" style="color:#D90429;"></i>
          <i class="fab fa-cc-amex fa-lg mx-1" style="color:#FF6F00;"></i>
        </div>
      </div>
      <div class="col-md-7 text-md-start text-center mb-3 mb-md-0" style="line-height:1.7;">
        <h5 style="color:#FFD600; font-weight:900; letter-spacing:-1px; font-family:'Orbitron',sans-serif;">VELOX</h5>
        <div style="font-size:13px; color:#ccc;">
          상호: eric | 대표 : 권혁진 | 사업자 등록번호 : 123-12-123345<br>
          주소 : 21424 서울 도봉구 창3동   | 전화 : 010-9271-3940 | Fax : 02-3333-4444<br>
          개인정보관리책임자 : 권혁진 | 이메일 : eric@naver.com<br>
          <span style="color:#FFD600;">Copyright © 2024 www.eric.ac.kr &nbsp; All Rights Reserved.</span>
        </div>
      </div>
      <div class="col-md-3 text-center text-md-end" style="font-size:13px;">
        <a href="company.html" class="mx-1" style="color:#FFD600;">회사소개</a>|
        <a href="useinfo.html" class="mx-1" style="color:#FFD600;">이용안내</a>|
        <a href="policy.html" class="mx-1" style="color:#FFD600;">개인정보정책</a>|
        <a href="admin/index.html" class="mx-1" style="color:#D90429;"><b>Admin</b></a>
        <div class="mt-3">
          <a href="http://www.ftc.go.kr/"><img src="images/footer_pic1.gif" border="0" class="img-fluid mb-2" style="max-width:48px;"></a>
          <a href="http://www.sgic.co.kr/"><img src="images/footer_pic2.gif" border="0" class="img-fluid mb-2" style="max-width:48px;"></a>
        </div>
        <div class="mt-2">
          <a href="#" class="mx-1"><i class="fab fa-instagram fa-lg" style="color:#FFD600;"></i></a>
          <a href="#" class="mx-1"><i class="fab fa-facebook fa-lg" style="color:#FFD600;"></i></a>
          <a href="#" class="mx-1"><i class="fab fa-youtube fa-lg" style="color:#D90429;"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- 끝 : 슈퍼카 다크 푸터 -->

</div>

</body>
</html>
