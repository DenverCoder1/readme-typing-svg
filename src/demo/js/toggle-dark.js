function toggleTheme() {
  const icon = document.querySelector(".darkmode i");
  /* dark mode on */
  if (document.body.getAttribute("data-theme") !== "dark") {
    icon.className = "gg-sun";
    setCookie("darkmode", "on", 9999);
    document.body.setAttribute("data-theme", "dark");
  }
  /* dark mode off */
  else {
    icon.className = "gg-moon";
    setCookie("darkmode", "off", 9999);
    document.body.removeAttribute("data-theme");
  }
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
