/******/ (() => { // webpackBootstrap
/*!**************************!*\
  !*** ./src/tabs/view.js ***!
  \**************************/
/**
* Tabbing functionality for the front-end
*/
document.addEventListener("DOMContentLoaded", function () {
  function tabs() {
    const tabList = document.getElementById('tabs-block-nav');
    const content = document.getElementById('tabs-block-content');
    function closeAllTabs() {
      for (const item of content.children) {
        item.classList.remove('active');
        item.hidden = true;
      }
      for (const tab of tabList.children) {
        tab.setAttribute('aria-selected', 'false');
        tab.classList.remove('current');
      }
    }
    ;
    for (const tab of tabList.children) {
      tab.addEventListener("click", () => {
        const id = tab.getAttribute('aria-controls');
        const tabContent = document.getElementById(id);
        closeAllTabs();
        tabContent.classList.toggle('active');
        tabContent.hidden = false;
        tab.setAttribute('aria-selected', 'true');
        tab.classList.toggle('current');
      });
    }
  }
  ;
  tabs();
});
/******/ })()
;
//# sourceMappingURL=view.js.map