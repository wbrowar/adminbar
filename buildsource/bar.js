// click to show mobile menu
function adminBarShowMobile(e) {
  var adminBarLinks = document.getElementById("admin_bar_links");
  
  if (adminBarLinks.classList) {
    adminBarLinks.classList.add('admin_bar_active');
  } else {
    adminBarLinks.className += ' admin_bar_active';
  }
}

document.getElementById("admin_bar_mobile_toggle").addEventListener('click', adminBarShowMobile);

// click to hide all overlays
function adminBarHideMobile(e) {
  var adminBarLinks = document.getElementById("admin_bar_links");
  
  if (adminBarLinks.classList) {
    adminBarLinks.classList.remove('admin_bar_active');
  } else {
    adminBarLinks.className = adminBarLinks.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
  }
}

var adminBarCloseButtons = document.querySelectorAll('.admin_bar_overlay .admin_bar_close');

for (var i = 0; i < adminBarCloseButtons.length; i++) {
  adminBarCloseButtons[i].addEventListener('click', adminBarHideMobile);
}

// add adminbar link to <html> element
if (document.documentElement.classList) {
  document.documentElement.classList.add('adminbar');
} else {
  document.documentElement.className += ' adminbar';
}