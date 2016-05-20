var adminBarEditLinks = [];

var ready = function (fn) {
  if (typeof fn !== 'function') return;
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    return fn();
  }
  document.addEventListener('DOMContentLoaded', fn, false);
};

ready(function() {
  var adminEdit;

  for (var i=0; i<adminBarEditLinks.length; i++) {
    adminEdit = document.querySelectorAll('.admin_edit[data-id="'+i+'"]');
    adminEdit[0].innerHTML = adminBarEditLinks[i];
    
    if (adminEdit[0].classList) {
      adminEdit[0].classList.add('admin_edit_embedded');
    } else {
      adminEdit[0].className += ' admin_edit_embedded';
    }
  }
});