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
  
  function adminAddClass(elm, newClass) {
    if (elm.classList) {
      elm.classList.add(newClass);
    } else {
      elm.className += ' ' + newClass;
    }
  }
  function adminCollectionHas(a, b) { //helper function (see below)
    for(var i = 0, len = a.length; i < len; i ++) {
      if(a[i] == b) return true;
    }
    return false;
  }
  function adminFindParentBySelector(elm, selector) {
    var all = document.querySelectorAll(selector);
    var cur = elm.parentNode;
    while(cur && !adminCollectionHas(all, cur)) { //keep going up until you find a match
      cur = cur.parentNode; //go up
    }
    return cur; //will return null if not found
  }

  for (var i=0; i<adminBarEditLinks.length; i++) {
    adminEdit = document.querySelectorAll('.admin_edit[data-id="'+i+'"]');
    adminEdit[0].innerHTML = adminBarEditLinks[i];
    
    // check for container selector
    if (adminEdit[0].hasAttribute("data-container")) {
      var containerSelector = adminFindParentBySelector(
        adminEdit[0],
        adminEdit[0].getAttribute("data-container")
      );
      
      if (containerSelector !== null) {
        adminAddClass(containerSelector, 'admin_edit_container'); 
      }
    }
    
    // display each edit link
    adminAddClass(adminEdit[0], 'admin_edit_embedded');
  }
});