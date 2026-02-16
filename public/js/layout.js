/******/ (() => { // webpackBootstrap
/*!********************************!*\
  !*** ./resources/js/layout.js ***!
  \********************************/
document.addEventListener("DOMContentLoaded", function () {
  var sidebar = document.getElementById("sidebar");
  var contentWrapper = document.getElementById("contentWrapper");
  var toggleBtn = document.getElementById("toggleSidebar");
  var sidebarOverlay = document.getElementById("sidebarOverlay");
  var userMenu = document.getElementById("userMenu");
  var userDropdown = document.getElementById("userDropdown");
  function toggleSidebar() {
    var isActive = sidebar.classList.toggle("active");
    contentWrapper.classList.toggle("sidebar-active", isActive);
    sidebarOverlay.classList.toggle("active", isActive);
    localStorage.setItem("sidebarActive", isActive);
  }
  function closeSidebar() {
    sidebar.classList.remove("active");
    contentWrapper.classList.remove("sidebar-active");
    sidebarOverlay.classList.remove("active");
    localStorage.setItem("sidebarActive", false);
  }
  function initSidebar() {
    var savedState = localStorage.getItem("sidebarActive");
    if (savedState === "true") {
      sidebar.classList.add("active");
      contentWrapper.classList.add("sidebar-active");
    } else {
      sidebar.classList.remove("active");
      contentWrapper.classList.remove("sidebar-active");
      sidebarOverlay.classList.remove("active");
      if (savedState === null) {
        localStorage.setItem("sidebarActive", false);
      }
    }
    sidebarOverlay.addEventListener("click", closeSidebar);
  }
  function initUserMenu() {
    userMenu.addEventListener("click", function (e) {
      e.stopPropagation();
      userDropdown.classList.toggle("show");
    });
    document.addEventListener("click", function (e) {
      if (!userMenu.contains(e.target)) {
        userDropdown.classList.remove("show");
      }
    });
    userDropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }
  function initResponsive() {
    window.addEventListener("resize", function () {
      if (window.innerWidth > 768 && sidebarOverlay.classList.contains("active")) {
        closeSidebar();
      }
    });
  }
  function initActiveLink() {
    var sidebarLinks = document.querySelectorAll(".sidebar a:not([href='javascript:void(0);'])");
    var currentUrl = window.location.origin + window.location.pathname;
    sidebarLinks.forEach(function (link) {
      var linkUrl = new URL(link.href);
      var cleanLinkUrl = linkUrl.origin + linkUrl.pathname;
      if (cleanLinkUrl === currentUrl) {
        link.classList.add("active-link");
      }
    });
    sidebarLinks.forEach(function (link) {
      link.addEventListener("click", function () {
        sidebarLinks.forEach(function (l) {
          return l.classList.remove("active-link");
        });
        this.classList.add("active-link");
        if (window.innerWidth <= 768) {
          closeSidebar();
        }
      });
    });
  }
  function initSubmenu(toggleId, menuId, iconId, storageKey) {
    var toggle = document.getElementById(toggleId);
    var menu = document.getElementById(menuId);
    var icon = document.getElementById(iconId);
    if (!toggle) return;
    var savedState = localStorage.getItem(storageKey);
    if (savedState === "true") {
      menu.classList.add("show-menu");
      icon.classList.add("rotate");
    }
    toggle.addEventListener("click", function () {
      var isOpen = menu.classList.toggle("show-menu");
      icon.classList.toggle("rotate");
      localStorage.setItem(storageKey, isOpen);
    });
  }
  function init() {
    initSidebar();
    initUserMenu();
    initResponsive();
    initSubmenu("toggleActivos", "menuActivos", "iconActivos", "menuActivosOpen");
    initSubmenu("toggleHerramienta", "menuHerramienta", "iconHerramienta", "menuHerramientaOpen");
    initSubmenu("toggleCatalogos", "menuCatalogos", "iconCatalogos", "menuCatalogosOpen");
    initActiveLink();
    toggleBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      toggleSidebar();
    });
  }
  init();
});
/******/ })()
;