function toggleTheme(){
  var html = document.documentElement;
  var cur = html.getAttribute('data-theme')||'dark';
  var next = cur==='dark'?'light':'dark';
  html.setAttribute('data-theme',next);
  localStorage.setItem('lcTheme',next);
  updateThemeBtn();
}
function updateThemeBtn(){
  var t = document.documentElement.getAttribute('data-theme')||'dark';
  var btn = document.getElementById('themeBtn');
  if(btn) btn.textContent = t==='dark'?'🌙':'☀️';
}
document.addEventListener('DOMContentLoaded',function(){
  var t = localStorage.getItem('lcTheme')||'dark';
  document.documentElement.setAttribute('data-theme',t);
  updateThemeBtn();
});
