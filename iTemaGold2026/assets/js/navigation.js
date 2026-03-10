(function () {
  const nav = document.querySelector('.main-navigation');
  if (!nav) return;

  nav.querySelectorAll('a').forEach((link) => {
    link.setAttribute('rel', 'bookmark');
  });
})();
