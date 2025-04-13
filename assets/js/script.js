  // Side Navigation
  const menuToggle = document.querySelector('.menu-toggle');
  const closeBtn = document.querySelector('.close-btn');
  const sideNav = document.querySelector('.side-nav');
  const overlay = document.querySelector('.nav-overlay');
  menuToggle.addEventListener('click', () => {
      sideNav.classList.add('active');
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden';
  });
  function closeNav() {
      sideNav.classList.remove('active');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
  }
  closeBtn.addEventListener('click', closeNav);
  overlay.addEventListener('click', closeNav);
  // Bottom Nav Click Fix
  document.querySelectorAll('.bottom-nav a').forEach(link => {
      link.addEventListener('click', () => {
          document.querySelectorAll('.bottom-nav a').forEach(l => l.classList.remove('active'));
          link.classList.add('active');
      });
  });
  // Dynamic Calendar Based on Today's Date
  function updateCalendar() {
      const today = new Date();
      const monthYear = today.toLocaleString('default', { month: 'long', year: 'numeric' });
      document.getElementById('calendar-month').textContent = monthYear;
      const daysContainer = document.getElementById('calendar-grid');
      daysContainer.innerHTML = '';
      const firstDay = new Date(today.getFullYear(), today.getMonth(), 1).getDay();
      const lastDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
          daysContainer.innerHTML += `<div class="calendar-day empty"></div>`;
      }
      for (let i = 1; i <= lastDate; i++) {
          const dayClass = (i === today.getDate()) ? 'calendar-day selected' : 'calendar-day';
          daysContainer.innerHTML += `<div class="${dayClass}">${i}</div>`;
      }
  }
  updateCalendar();