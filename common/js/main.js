//JavaScript

"use strict";

window.addEventListener("load", autoHeight, false);
window.addEventListener("resize", autoHeight, false);

function autoHeight() {
  let header = document.querySelector("header");
  let footer = document.querySelector("footer");
  let elem = document.querySelector("section");
  
  addClass(elem, "flex");
  
  if (window.innerWidth >= 768) {
    let curr = header.offsetHeight + elem.offsetHeight + footer.offsetHeight;
    
    if (window.innerHeight > curr) {
      elem.style.height = (window.innerHeight - header.offsetHeight - footer.offsetHeight) + "px";
    }
  }
}

function addClass (elem, myClass) {
  if (elem.classList) {
    elem.classList.add(myClass);
  }
  else {
    var arr = elem.className.split(" ");
    var i = arr.indexOf(myClass);
    if (i == -1) {
      arr.push(myClass);
      elem.className = arr.join(" ");
    }
  }
}

function removeClass (elem, myClass) {
  if (elem.classList) {
    elem.classList.remove(myClass);
  }
  else {
    var arr = elem.className.split(" ");
    var i = arr.indexOf(myClass);
    if (i >= 0) {
      arr.splice(i, 1);
      elem.className = arr.join(" ");
    }
  }
}

function addEventListenerToList(list, evt, func) {
  var arr = list;
  if (arr) {
    for (var i = 0; i < arr.length; i++) {
      arr[i].addEventListener(evt, func, false);
    }
  }
}