$( document ).ready(function() {
   $("#link_fija").closest("ul").closest("li").attr('class', 'active');
   $("#link_fija").closest("ul").fadeIn();
   $("#link_fija").addClass("current-page"); 
});
