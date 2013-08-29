function toggleMenu(el1, el2, over) {
    var p; var prefix = "nav-";
    if (el2 == -1) { p = document.getElementById(prefix + el1) }
    else { p = document.getElementById(prefix + el1 + "-" + el2) }
    var newClassName;
    if (over == 1) { 
        newClassName = p.className + " over"; p.className = newClassName }
    else {
        newClassName = p.className.replace(" over", ""); p.className = newClassName
    } 
}