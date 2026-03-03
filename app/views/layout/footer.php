  </main>
</div>

<script>
(function(){
  const saved = localStorage.getItem('theme');
  if(saved === 'dark') document.body.classList.add('dark');

  window.toggleTheme = function(){
    document.body.classList.toggle('dark');
    const dark = document.body.classList.contains('dark');
    localStorage.setItem('theme', dark ? 'dark' : 'light');

    const icon = document.getElementById('themeIcon');
    if(icon) icon.innerText = dark ? '☀️' : '🌙';
  }

  document.addEventListener('DOMContentLoaded', function(){
    const dark = document.body.classList.contains('dark');
    const icon = document.getElementById('themeIcon');
    if(icon) icon.innerText = dark ? '☀️' : '🌙';
  });
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
