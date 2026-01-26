AOS.init({
  duration: 1000,
  once: true,
  offset: 120
});

// Scroll Progress Bar

window.addEventListener('scroll', () => {

  let scrollTop = window.scrollY;
  let docHeight = document.body.scrollHeight - window.innerHeight;

  let progress = (scrollTop / docHeight) * 100;

  document.getElementById('progress-bar').style.width = progress + "%";

});

// Hero Parallax Effect

const hero = document.querySelector('.hero');

if(hero){

  hero.addEventListener('mousemove', (e)=>{

    let x = (window.innerWidth / 2 - e.pageX) / 40;
    let y = (window.innerHeight / 2 - e.pageY) / 40;

    hero.style.backgroundPosition =
      `calc(50% + ${x}px) calc(50% + ${y}px)`;
  });

}

// ================= LIVE CAMPUS SLIDER =================

const campusSlides = document.querySelectorAll('.campus-slide');
let campusIndex = 0;

if (campusSlides.length > 0) {

  setInterval(() => {

    campusSlides[campusIndex].classList.remove('active');

    campusIndex = (campusIndex + 1) % campusSlides.length;

    campusSlides[campusIndex].classList.add('active');

  }, 5000); // Change every 5 sec
}

// ================= HERO TYPING EFFECT =================

const text = "Providing Quality Education with Values and Discipline Since 2006";let index = 0;

const typingEl = document.querySelector('.typing-text');

function typeEffect() {

  if (typingEl && index < text.length) {
    typingEl.textContent += text.charAt(index);
    index++;
    setTimeout(typeEffect, 70);
  }
}

if (typingEl) {
  typingEl.textContent = "";
  typeEffect();
}

// ================= HEADER SCROLL EFFECT =================

const header = document.querySelector(".header-main");

window.addEventListener("scroll", () => {

  if (window.scrollY > 80) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }

});


// ================= SCROLL TO TOP (SMOOTH ANIMATED) =================

document.addEventListener("DOMContentLoaded", () => {

  const scrollBtn = document.getElementById("scrollTopBtn");

  if (!scrollBtn) return;

  // Show / Hide Button
  window.addEventListener("scroll", () => {

    if (window.scrollY > 400) {
      scrollBtn.style.display = "flex";
      scrollBtn.classList.add("active");
    } else {
      scrollBtn.style.display = "none";
      scrollBtn.classList.remove("active");
    }

  });

  // Custom smooth scroll animation
  function smoothScrollToTop() {

    const start = window.scrollY;
    const duration = 800;
    const startTime = performance.now();

    function animate(currentTime) {

      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);

      const ease = 1 - Math.pow(1 - progress, 3);

      window.scrollTo(0, start * (1 - ease));

      if (progress < 1) {
        requestAnimationFrame(animate);
      }

    }

    requestAnimationFrame(animate);
  }

  // Click
  scrollBtn.addEventListener("click", () => {

    scrollBtn.classList.remove("active");
    scrollBtn.classList.add("clicked");

    smoothScrollToTop();

    setTimeout(() => {
      scrollBtn.classList.remove("clicked");
      scrollBtn.classList.add("active");
    }, 900);

  });

});
